<?php
	ini_set("session.cookie_lifetime", 60 * 60 * 24 * 100);
	ini_set("session.gc_maxlifetime", 60 * 60 * 24 * 100);
	set_time_limit(0);
	
	session_start();
	$__title_project			= "Project Title";
	$__isloggedin				= @$_SESSION["isloggedin"];
	$__username					= @$_SESSION["username"];
	$__fullname					= @$_SESSION["fullname"];
	$__user_id					= @$_SESSION["user_id"];
	$__group_id					= @$_SESSION["group_id"];
	$__first_name				= @$_SESSION["first_name"];
	$__errormessage				= @$_SESSION["errormessage"];
	$__phpself 					= basename($_SERVER["PHP_SELF"]);
	$__http_referer 			= basename($_SERVER["HTTP_REFERER"]);
	
	if(isset($_GET["locale"])) { setcookie("locale",$_GET["locale"]);$_COOKIE["locale"]=$_GET["locale"]; }
	if(!isset($_COOKIE["locale"])) { setcookie("locale","id");$_COOKIE["locale"]="id"; }
	$__locale = $_COOKIE["locale"];
	
	include_once "../classes/database.php";
    include_once "../classes/form_elements.php";
    include_once "../classes/tables.php";
    include_once "../classes/helper.php";
	include_once "../classes/vocabulary.php";
	
	$v = new Vocabulary($__locale);
	$db = new Database();
	$f = new FormElements();
	$t = new Tables();
	$h = new Helper();
	if($_SERVER["REMOTE_ADDR"] == "::1") $_SERVER["REMOTE_ADDR"] = "127.0.0.1";
	
	$__isBackofficer = ($db->fetch_single_data("backofficers","id",["user_id"=>$__user_id]) > 0) ? "1":"0";
	if($__user_id == 1) $__isBackofficer = "1";
	
	$__is_allowed				= is_file_allowed($__phpself,$__user_id,$__group_id,$db);
	if(!$__is_allowed){
		$__is_allowed			= is_file_allowed($__http_referer,$__user_id,$__group_id,$db);
	}
	
	if($__group_id > 0){
		$db->addtable("a_backoffice_menu_privileges");
		$db->addfield("a_backoffice_menu_id");
		$db->where("group_id",$__group_id);
	} else if($__user_id == 1) {		
		$db->addtable("a_backoffice_menu");
		$db->addfield("id");
	}
	$arrmenu = $db->fetch_data(true);
	foreach($arrmenu as $menu){
		$__menu_ids[$menu[0]] = 1;
	}
	
	function is_file_allowed($filename,$user_id,$group_id,$db){
		$is_allowed = true;
		$file_pattern = "";
		if(strpos($filename,"_") > 0){
			$temp = explode("_",pathinfo($filename, PATHINFO_FILENAME));
			for($xx=0;$xx<count($temp)-1;$xx++){ $file_pattern .= $temp[$xx]."_"; }
			$file_pattern .= "%.".pathinfo($filename, PATHINFO_EXTENSION);
		} else { $file_pattern = $filename; }
		
		$file_pattern = str_replace(array("_extension","_extension_edit"),"",$file_pattern);
		
		$selected_menu_id = $db->fetch_single_data("a_backoffice_menu","id",array("url" => $file_pattern.":LIKE"));
		if($user_id != 1 && $db->fetch_single_data("a_backoffice_menu_privileges","privilege",array("group_id" => $group_id,"a_backoffice_menu_id" => $selected_menu_id)) == 0) {
			$is_allowed = false;
		}
		return $is_allowed;
	}
	
	if(isset($_GET["utm_source"]) && $_GET["utm_source"] != "") add_utm();
	
	function add_utm() {
		global $db;
		$db->addtable("utm");
		$db->addfield("utm_source");$db->addvalue($_GET["utm_source"]);
		$db->addfield("utm_medium");$db->addvalue($_GET["utm_medium"]);
		$db->addfield("utm_campaign");$db->addvalue($_GET["utm_campaign"]);
		$db->addfield("ip");$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("session_id");$db->addvalue(session_id());
		$db->insert();
	}
	
	function filter_request($request) {
		if (is_array($request))	{
			foreach ($request as $key => $value) {
			  $request[$key] = filter_request($value);
			}
			return $request;
		} else {
			// remove everything except for a-ZA-Z0-9_.-&=
			// $request = preg_replace('/[^a-ZA-Z0-9_\.\-&=]/', '', $request);
			$array1 = array("<script>","</script>","javascript:","'","database(");
			$array2 = array("","","","`","");
			$request = str_ireplace($array1,$array2,$request);
			return $request;
		}
	}
	
	function age($birthdate){
		$datediff = date_diff(date_create(date("Y-m-d H:i:s")),date_create($birthdate),true);
		return floor($datediff->days/365);
	}
	
	function read_file($filename){
		$fp = fopen($filename, "r");
		$return = fread($fp,filesize($filename));
		fclose($fp);
		return $return;
	}
	
	function chr13tobr($string) { return str_replace(chr(13).chr(10),"<br>",$string); }
	
	function isMobile($wanna_fullsite = "") {
		global $_SERVER;
		$useragent = $_SERVER["HTTP_USER_AGENT"];
		if($wanna_fullsite){ return false; }
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			return true;
		} else {
			return false;
		}
	}
	
	function add_br($string,$numchar = 100) { 
		$return = "";
		$i = 0;
		while($i<strlen($string)){
			$return .= substr($string,$i,$numchar)."<br>";
			$i += $numchar;
		}
		return $return;
	}
	
	function javascript($script){  ?> <script> $( document ).ready(function() { <?=$script;?> }); </script> <?php }
	
	function sanitasi($value){ return str_replace("'","''",$value); }
	
	foreach($_POST as $key => $value){ if(!is_array($value)) $_POST[$key] = sanitasi($value); }
	foreach($_GET as $key => $value){ if(!is_array($value)) $_GET[$key] = sanitasi($value); }
	
	function format_amount($amount,$decimalnum = 0){
		global $_isexport;
		if($_isexport) return $amount;
		if($amount < 0){ $amount  *= -1; $isnegative = true; }
		$return = number_format($amount,$decimalnum,",",".");
		if($isnegative) $return = "(".$return.")";
		return $return;
	}
	
	function salary_min_max($min,$max){
		global $__locale,$v;
		$_max = $max;
		if($__locale == "en") {
			$min = number_format($min);
			$max = number_format($max);
		} else {
			$min = number_format($min,0,",",".");
			$max = number_format($max,0,",",".");
		}
		if($_max > 0){return "Rp.".$min." - Rp.".$max;} else {return "Rp.".$min." - ".$v->w("infinite");}
	}
	
	function format_tanggal ($tanggal,$mode="dmY",$withtime=false,$gmt7 = false) {
		if(substr($tanggal,0,10) != "0000-00-00" && $tanggal != ""){
			$arr = explode(" ",$tanggal);
			$time = null;
			if(isset($arr[1])) $time = explode(":",$arr[1]);
			$tanggal = $arr[0];
			$arr = explode("-",$tanggal);
			$Y = $arr[0]; $m = $arr[1]; $d = $arr[2];
			if(is_array($time)){ $h = $time[0]; $i = $time[1]; $s = $time[2]; }
			if($gmt7){ $h = $h + 7; }
			$format_time = "";
			if($withtime && is_array($time)) $format_time = " H:i:s";

			if($mode == "dmY"){ $tanggal = date("d-m-Y".$format_time,mktime($h,$i,$s,$m,$d,$Y)); }
			if($mode == "dMY"){ $tanggal = date("d F Y".$format_time,mktime($h,$i,$s,$m,$d,$Y)); }
			return $tanggal;
		}
	}
	
	function format_range_tanggal($tanggal1,$tanggal2){
		global $v;
		if($tanggal1 == "" || substr($tanggal1,0,10) == "0000-00-00") $tanggal1 = "0000-00-00";
		if($tanggal2 == "" || substr($tanggal2,0,10) == "0000-00-00") $tanggal2 = "0000-00-00";
		$return = "";
		if($tanggal1 != "0000-00-00") $return .= format_tanggal($tanggal1,"dMY"); else  $return .= $v->words("now");
		$return .= " - ";
		if($tanggal2 != "0000-00-00") $return .= format_tanggal($tanggal2,"dMY"); else  $return .= $v->words("now");
		return $return;
	}
	
	function province_location_format_id($id){
		global $db;
		$db->addtable("locations"); $db->addfield("province_id,location_id");$db->where("id",$id);
		$temp = $db->fetch_data();
		if(isset($temp[0]) && isset($temp[1])) return $temp[0].":".$temp[1];				
	}
	
	function pipetoarray($data){
		if(!isset($data) || $data == "") return array();
		$arr = explode("|",$data);
		foreach($arr as $data){ 
			$data = str_replace("|","",$data);
			if ($data !="") $return[] = $data; 
		}
		return $return;
	}
	
	function sb_to_pipe($data){
		$return = "";
		if(is_array($data)) {
			ksort($data);
			foreach($data as $datum => $val){ $return .= "|".$datum."|"; }
		}
		return $return;
	}
	
	function array_swap($data){
		$return = array();
		if(is_array($data)){ foreach($data as $key => $value) { $return[] = $key; } }
		return $return;
	}
	
	function sel_to_pipe($data){
		if(!is_array($data)) return "";
		sort($data);
		$return = "";
		foreach($data as $datum => $val){ $return .= "|".$val."|"; }
		return $return;
	}
	
	function getStartRow($page,$rowperpage){
		$page = ($page > 0) ? $page:1;
		return ($page - 1) * $rowperpage;
	}
	
	function paging_short($rowperpage,$maxrow,$activepage,$class = "",$offset = 5){
		$numpage = ceil($maxrow/$rowperpage);
		$activepage = ($activepage == 0) ? 1:$activepage;
		$return = "<div class='".$class."'>";
		if($activepage > 1) $return .= "<a href=\"javascript:changepage('".($activepage - 1)."');\"><<</a>";
		
		if($activepage < ($offset-1)){
			$start = 1;
		} else {
			$start = $activepage - 2;
			$start = ($start<1) ? 1 : $start;
		}
		
		if($activepage > $numpage-($offset-1)){
			$start = $numpage-($offset-1);
			$start = ($start<1) ? 1 : $start;
		}
		
		
		$_loop_page = $start+($offset-1);
		$_loop_page = ($offset > $numpage) ? $numpage : $_loop_page;
		
		for($i = $start ; $i <= $_loop_page ; $i++){
			if($activepage == $i ) $return .= "<a id=\"a_active\" href=\"javascript:changepage('".$i."');\">".$i."</a>";
			else  $return .= "<a href=\"javascript:changepage('".$i."');\">".$i."</a>"; 
		}
		
		if($numpage > $activepage) $return .= "<a href=\"javascript:changepage('".($activepage + 1)."');\">>></a>";
		
		$return .= "</div>";
		return $return;
	}
	
	function paging($rowperpage,$maxrow,$activepage,$class = "",$offset = 20){
		$numpage = ceil($maxrow/$rowperpage);
		$activepage = ($activepage == 0) ? 1:$activepage;
		$return = "<div class='".$class."'>";
		if($activepage > 1) {
			$return .= "<a href=\"javascript:changepage('1');\"><<<</a>";
			$return .= "<a href=\"javascript:changepage('".($activepage - 1)."');\"><<</a>";
		}
		
		if($activepage < ($offset-1)){
			$start = 1;
		} else {
			$start = $activepage - 2;
			$start = ($start<1) ? 1 : $start;
		}
		
		if($activepage > $numpage-($offset-1)){
			$start = $numpage-($offset-1);
			$start = ($start<1) ? 1 : $start;
		}
		
		
		$_loop_page = $start+($offset-1);
		$_loop_page = ($offset > $numpage) ? $numpage : $_loop_page;
		
		for($i = $start ; $i <= $_loop_page ; $i++){
			if($activepage == $i ) $return .= "<a id=\"a_active\" href=\"javascript:changepage('".$i."');\">".$i."</a>";
			else  $return .= "<a href=\"javascript:changepage('".$i."');\">".$i."</a>"; 
		}
		
		if($numpage > $activepage){ 
			$return .= "<a href=\"javascript:changepage('".($activepage + 1)."');\">>></a>";
			$return .= "<a href=\"javascript:changepage('".($numpage)."');\">>>></a>";
		}
		
		$return .= "</div>";
		return $return;
	}
	
	function validate_domain_email($email){
        $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";
        if(eregi($exp,$email)){
            if(checkdnsrr(array_pop(explode("@",$email)),"MX")){
                return "1";
            }else{
                return "0";
            }
        }else{
            return "0";
        }
    }
?>
<?php include_once "../log_action.php"; ?>
