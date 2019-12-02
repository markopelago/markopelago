<?php
	ini_set("session.cookie_lifetime", 60 * 60 * 24 * 100);
	ini_set("session.gc_maxlifetime", 60 * 60 * 24 * 100);
	set_time_limit(0);
	
	/* if($_COOKIE["kanari_access"] != "ok" && $_COOKIE["android_apps"] != 1){
		?> <img src="http://bluefish.co.id/images/under_maintenance.jpg"> <?php
		exit();
	} */
	
	session_start();
	$__project_description		= "Markopelago";
	$__title_project			= "Markopelago [Beta]";
	$__canonical				= "http://www.markopelago.com";
	$__isloggedin				= @$_SESSION["isloggedin"];
	$__username					= @$_SESSION["username"];
	$__fullname					= @$_SESSION["fullname"];
	$__user_id					= @$_SESSION["user_id"];
	$__group_id					= @$_SESSION["group_id"];
	$__first_name				= @$_SESSION["first_name"];
	$__errormessage				= @$_SESSION["errormessage"];
	$__markopasar_seller_id		= @$_SESSION["markopasar_seller_id"];
	$__phpself 					= basename($_SERVER["PHP_SELF"]);
	$__now						= date("Y-m-d H:i:s");
	$__self_pickup_fee			= 2000;
	$__marko_cod				= 0;
	$__cod_max_km				= 23;
	$__cod_tolerance_km			= 2;
	$__cod_max_gram				= 99999999999999999;

	$__invalid_request = false;
	foreach($_GET as $key => $value){
		if(strpos(" ".$value,'"') > 0) $__invalid_request = true;
		if(strpos(" ".$value,"'") > 0) $__invalid_request = true;
		if(strpos(" ".$value,"<") > 0) $__invalid_request = true;
		if(strpos(" ".$value,">") > 0) $__invalid_request = true;
	}
	foreach($_POST as $key => $value){
		if(strpos(" ".$value,'"') > 0) $__invalid_request = true;
		if(strpos(" ".$value,"'") > 0) $__invalid_request = true;
		if(strpos(" ".$value,"<") > 0) $__invalid_request = true;
		if(strpos(" ".$value,">") > 0) $__invalid_request = true;
	}
	if($__invalid_request){
		$_SESSION["errormessage"] = "Mohon untuk tidak menggunakan karakter spesial, terima kasih!";
		?> <script> window.location="index.php";</script> <?php
		exit();
	}
	
	if(isset($_GET["locale"])) { setcookie("locale",$_GET["locale"]);$_COOKIE["locale"]=$_GET["locale"]; }
	if(!isset($_COOKIE["locale"])) { setcookie("locale","id");$_COOKIE["locale"]="id"; }
	$__locale = $_COOKIE["locale"];
	if($__locale == "id") $__anti_locale = "en";
	if($__locale == "en") $__anti_locale = "id";
	
	include_once "classes/database.php";
	include_once "classes/form_elements.php";
    include_once "classes/tables.php";
    include_once "classes/helper.php";
	include_once "classes/vocabulary.php";
	include_once "classes/rajaongkir.php";
	
	$vocabulary = new Vocabulary($__locale);
	$db = new Database();
	$f = new FormElements();
	$t = new Tables();
	$h = new Helper();
	$ro = new Rajaongkir();
	
	if($_SERVER["REMOTE_ADDR"] == "::1") $_SERVER["REMOTE_ADDR"] = "127.0.0.1";
	$__remote_addr = $_SERVER["REMOTE_ADDR"];
	
	$__user 		= @$db->fetch_all_data("a_users",[],"id = '".$__user_id."'")[0];
	$__seller 		= @$db->fetch_all_data("sellers",[],"user_id = '".$__user_id."'")[0];
	$__buyer 		= @$db->fetch_all_data("buyers",[],"user_id = '".$__user_id."'")[0];
	$__forwarder 	= @$db->fetch_all_data("forwarders",[],"user_id = '".$__user_id."'")[0];
	$__marko_id 	= $__user["marko_id"];
	$__seller_id 	= $__seller["id"];
	$__buyer_id		= $__buyer["id"];
	$__forwarder_id = $__forwarder["id"];
	$__isBackofficer = $__user["is_backofficer"];
	$__email_confirmed = false;
	$__phone_confirmed = false;
	$__user_confirmed = false;
	$__pasar_category_id = 49;
	
	if($__user_id == 1) $__isBackofficer = "1";
	if($__user["custom_radius"] > 0) $__cod_max_km = $__user["custom_radius"];
	if($__user["email_confirmed_at"] != "0000-00-00 00:00:00") $__email_confirmed = true;
	if($__user["phone_confirmed_at"] != "0000-00-00 00:00:00") $__phone_confirmed = true;
	if($__email_confirmed || $__phone_confirmed) $__user_confirmed = true;
	$__showXSonly 	= "class='hidden-sm hidden-md hidden-lg'";
	
	$__tblDesign100 = "width='100%' cellpadding='0' cellspacing='0'";
	
	function v($index){
		global $vocabulary;
		if($vocabulary->w($index)) return $vocabulary->w($index);
		else return $index;
	}
	
	function randtoken($len){
		$return = "";
		while(strlen($return) < $len){
			if(rand(0,1) == 0){//angka
				$return .= rand(0,9);
			} else {//huruf
				$return .= chr(rand(65,90));
			}
		}
		return $return;
	}
	
	function generateToken($suffix = ""){
		global $db,$__user_id,$__isloggedin;
		if($__user_id && $__isloggedin){
			if($suffix == "") $suffix = $__user_id;
			$looping = true;
			while($looping){
				$token = randtoken(20)."_".$suffix;
				if($db->fetch_single_data("a_users","id",["token" => $token]) <= 0 ){
					$db->addtable("a_users");	$db->where("id",$__user_id);
					$db->addfield("token");		$db->addvalue($token);
					$updating = $db->update();
					if($updating["affected_rows"] > 0){
						$looping = false;
					}
				}
			}
			return $token;
		}
		return "";
	}
	
	
	
	function generateAppsToken($suffix = ""){
		global $db,$__user_id,$__isloggedin;
		if($__user_id && $__isloggedin){
			if($suffix == "") $suffix = $__user_id;
			$looping = true;
			while($looping){
				$token = randtoken(20)."_".$suffix;
				if($db->fetch_single_data("a_users","id",["token" => $token]) <= 0 ){
					$db->addtable("a_users");	$db->where("id",$__user_id);
					$db->addfield("app_token");	$db->addvalue($token);
					$updating = $db->update();
					if($updating["affected_rows"] > 0){
						$looping = false;
					}
				}
			}
			return $token;
		}
		return "";
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
		$isnegative = false;
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
		if($_max > 0){return "Rp.".$min." - Rp.".$max;} else {return "Rp.".$min." - ".v("infinite");}
	}
	
	function format_tanggal ($tanggal,$mode="dmY",$withtime=false,$gmt7 = false) {
		$h = 0;
		$i = 0;
		$s = 0;
		$m = 0;
		$d = 0;
		$Y = 0;
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
			else if($mode == "dMY"){ $tanggal = date("d F Y".$format_time,mktime($h,$i,$s,$m,$d,$Y)); }
			else { $tanggal = date($mode.$format_time,mktime($h,$i,$s,$m,$d,$Y)); }
			return $tanggal;
		}
	}
	
	function format_range_tanggal($tanggal1,$tanggal2){
		global $v;
		if($tanggal1 == "" || substr($tanggal1,0,10) == "0000-00-00") $tanggal1 = "0000-00-00";
		if($tanggal2 == "" || substr($tanggal2,0,10) == "0000-00-00") $tanggal2 = "0000-00-00";
		$return = "";
		if($tanggal1 != "0000-00-00") $return .= format_tanggal($tanggal1,"dMY"); else  $return .= v("now");
		$return .= " - ";
		if($tanggal2 != "0000-00-00") $return .= format_tanggal($tanggal2,"dMY"); else  $return .= v("now");
		return $return;
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
	
	function paging($rowperpage,$maxrow,$activepage,$class = ""){
		$numpage = ceil($maxrow/$rowperpage);
		$activepage = ($activepage == 0) ? 1:$activepage;
		$return = "<div class='".$class."'>";
		for($i = 1 ; $i <= $numpage ; $i++){
			if($activepage == $i ) $return .= "<a id=\"a_active\" href=\"javascript:changepage('".$i."');\">".$i."</a>";
			else  $return .= "<a href=\"javascript:changepage('".$i."');\">".$i."</a>";
			if($i%20 == 0) $return .= "<br><br>";
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
	
	function numberpad($number,$pad){
		return sprintf("%0".$pad."d", $number);
	}
	
	function get_location_childest_ids($location_id){
		global $db;
		$location_ids = "";
		$locations1 = $db->fetch_all_data("locations",[],"parent_id='".$location_id."'");
		if(count($locations1) > 0){
			foreach($locations1 as $location1){
				$locations2 = $db->fetch_all_data("locations",[],"parent_id='".$location1["id"]."'");
				if(count($locations2) > 0){
					foreach($locations2 as $location2){
						$locations3 = $db->fetch_all_data("locations",[],"parent_id='".$location2["id"]."'");
						if(count($locations3) > 0){
							foreach($locations3 as $location3){
								$locations4 = $db->fetch_all_data("locations",[],"parent_id='".$location3["id"]."'");
								if(count($locations4) > 0){
									foreach($locations4 as $location4){
										$locations5 = $db->fetch_all_data("locations",[],"parent_id='".$location4["id"]."'");										
										if(count($locations5) > 0){
											foreach($locations5 as $location5){
												$locations6 = $db->fetch_all_data("locations",[],"parent_id='".$location5["id"]."'");
												if(count($locations6) <= 0){
													$location_ids .= $location5["id"].",";
												}
											}
										} else $location_ids .= $location4["id"].",";
									}
								} else $location_ids .= $location3["id"].",";
							}
						} else $location_ids .= $location2["id"].",";
					}
				} else $location_ids .= $location1["id"].",";
			}
		} else $location_ids .= $location_id.",";
		return substr($location_ids,0,-1);
	}
	function get_location($location_id){
		global $db,$__locale;
		//level => province,city,district,subdistrict
		$caption = "";
		$level = 0;
		$location = @$db->fetch_all_data("locations",[],"id = '".$location_id."'")[0];
		$arr[$level]["id"] = $location["id"];
		$arr[$level]["name"] = $location["name_".$__locale];
		$arr[$level]["zipcode"] = $location["zipcode"];
		$caption = $location["name_".$__locale];
		if(!isset($zipcode)) $zipcode = $location["zipcode"];
		if($location["parent_id"] > 0){
			$level++;
			$location = @$db->fetch_all_data("locations",[],"id = '".$location["parent_id"]."'")[0];
			$arr[$level]["id"] = $location["id"];
			$arr[$level]["name"] = $location["name_".$__locale];
			$arr[$level]["zipcode"] = $location["zipcode"];
			$caption .= ", ".$location["name_".$__locale];
			if(!$zipcode) $zipcode = $location["zipcode"];
			if($location["parent_id"] > 0){
				$level++;
				$location = @$db->fetch_all_data("locations",[],"id = '".$location["parent_id"]."'")[0];
				$arr[$level]["id"] = $location["id"];
				$arr[$level]["name"] = $location["name_".$__locale];
				$arr[$level]["zipcode"] = $location["zipcode"];
				$caption .= ", ".$location["name_".$__locale];
				if(!$zipcode) $zipcode = $location["zipcode"];
				if($location["parent_id"] > 0){
					$level++;
					$location = @$db->fetch_all_data("locations",[],"id = '".$location["parent_id"]."'")[0];
					$arr[$level]["id"] = $location["id"];
					$arr[$level]["name"] = $location["name_".$__locale];
					$arr[$level]["zipcode"] = $location["zipcode"];
					$caption .= ", ".$location["name_".$__locale];
					if(!$zipcode) $zipcode = $location["zipcode"];
				}
			}
		}
		krsort($arr);
		$no = -1;
		foreach($arr as $key => $_arr){
			$no++;
			$returnval[$no] = $_arr;
		}
		$returnval["caption"] = $caption;
		if($zipcode) $returnval["caption"] .= ", ".$zipcode;
		return $returnval;
	}
	
	function resizeImage($filename){
		list($width, $height) = getimagesize($filename);
		$percent = 800/$width;
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
		
		$thumb = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($filename);
		
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg($thumb, $filename,100);
		return 1;
	}
	
	function markoantar_status($id){
		global $__locale,$db;
		return $db->fetch_single_data("markoantar_statuses","name_".$__locale,["id" => $id]);
	}
	
	function transactionList($id){
		global $__locale;
		$arr = array();
		if($__locale == "id"){
			$arr[0] = "Keranjang";
			$arr[1] = "Checkout Pembelian";
			$arr[2] = "Tunggu verifikasi pembayaran";
			$arr[3] = "Pembayaran terverifikasi";
			$arr[4] = "Pemesanan dalam proses";
			$arr[5] = "Pemesanan dalam pengiriman";
			$arr[6] = "Barang Diterima";
			$arr[7] = "Transaksi Selesai";
			$arr[-3] = "Konfirmasi pembelian dengan pembayaran di tempat";
		}
		if($__locale == "en"){
			$arr[0] = "Cart";
			$arr[1] = "Purchase Checkout";
			$arr[2] = "Waiting payment verification";
			$arr[3] = "Payment verified";
			$arr[4] = "Order in process";
			$arr[5] = "Order in delivery";
			$arr[6] = "Received";
			$arr[7] = "Transaction Done";
			$arr[-3] = "Confirm purchase with cash on delivery";
		}
		return $arr[$id];
	}
	
	function transactionstatuses(){
		global $__locale;
		$arr = array();
		if($__locale == "id"){
			$arr[""] = "-Status-";
			$arr[1] = "Checkout Pembelian";
			$arr[2] = "Tunggu verifikasi pembayaran";
			$arr[3] = "Pembayaran terverifikasi";
			$arr[4] = "Pemesanan dalam proses";
			$arr[5] = "Pemesanan dalam pengiriman";
			$arr[6] = "Barang Diterima";
			$arr[7] = "Transaksi Selesai";
		}
		if($__locale == "en"){
			$arr[""] = "-Status-";
			$arr[1] = "Purchase Checkout";
			$arr[2] = "Waiting payment verification";
			$arr[3] = "Payment verified";
			$arr[4] = "Order in process";
			$arr[5] = "Order in delivery";
			$arr[6] = "Received";
			$arr[7] = "Transaction Done";
		}
		return $arr;
	}
	
	function google_distancematrix($origins,$destinations){
		if($origins == "" || $destinations == "") return "ERROR";
		$key = "AIzaSyC27FE3B_k01GJPKk1TfneH_Yt_YHtvh70";
		$url = "https://maps.googleapis.com/maps/api/distancematrix/json?";
		$getValues = [
			"origins" => $origins,
			"destinations" => $destinations,
			"key" => $key
		];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt_array($curl, 
			[
				CURLOPT_URL => $url.http_build_query($getValues),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET"
			]
		);
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return json_decode($err, true);
		} else {
			return json_decode($response, true)["rows"];
		}
	}
	
	function generate_uniqcode(){
		global $db,$__now;
		$uniqcode = $db->fetch_single_data("transaction_payments","uniqcode",["created_at" => substr($__now,0,10)."%:LIKE"],["uniqcode DESC"]);
		return numberpad(($uniqcode+1),3);
	}
	
	function generate_invoice_no(){
		global $db;
		$invoice_no = "INV/".date("Ymd")."/";
		$seqno = $db->fetch_single_data("transactions","invoice_no",["invoice_no" => $invoice_no."%:LIKE"],["invoice_no DESC"]);
		$seqno = (str_replace($invoice_no,"",$seqno) * 1) + 1;
		$invoice_no = "INV/".date("Ymd")."/".numberpad($seqno,7);
		return $invoice_no;
	}
	
	function generate_po_no(){
		global $db;
		$po_no = "PO/".date("Ymd")."/";
		$seqno = $db->fetch_single_data("transactions","po_no",["po_no" => $po_no."%:LIKE"],["po_no DESC"]);
		$seqno = (str_replace($po_no,"",$seqno) * 1) + 1;
		$po_no = "PO/".date("Ymd")."/".numberpad($seqno,7);
		return $po_no;
	}
	
	function generate_self_pickup_receipt_no(){
		global $db;
		$receipt_no = "SPU".date("Ymd");
		$seqno = $db->fetch_single_data("transaction_forwarder","receipt_no",["receipt_no" => $receipt_no."%:LIKE"],["receipt_no DESC"]);
		$seqno = (str_replace($receipt_no,"",$seqno) * 1) + 1;
		$receipt_no = "SPU".date("Ymd").numberpad($seqno,7);
		return $receipt_no;
	}
	
	function generate_markoantar_receipt_no(){
		global $db;
		$receipt_no = "MarkoAntar".date("Ymd");
		$seqno = $db->fetch_single_data("transaction_forwarder","receipt_no",["receipt_no" => $receipt_no."%:LIKE"],["receipt_no DESC"]);
		$seqno = (str_replace($receipt_no,"",$seqno) * 1) + 1;
		$receipt_no = "MarkoAntar".date("Ymd").numberpad($seqno,7);
		return $receipt_no;
	}
	
	function get_goods_price($goods_id,$qty = 0){
		global $db;
		if($qty == 0) $qty = 1;
		$price = $db->fetch_single_data("goods_prices","price",["goods_id" => $goods_id,"qty" => $qty.":<="],["qty DESC"]);
		$commission = $db->fetch_single_data("goods_prices","commission",["goods_id" => $goods_id,"qty" => $qty.":<="],["qty DESC"]);
		$display_price = $price + ($price * $commission / 100);
		return ["price" => $price, "commission" => $commission, "display_price" => $display_price];
	}
	
	function getHari($day){
		$arr[1] = "Senin";
		$arr[2] = "Selasa";
		$arr[3] = "Rabu";
		$arr[4] = "Kamis";
		$arr[5] = "Jumat";
		$arr[6] = "Sabtu";
		$arr[7] = "Minggu";
		return $arr[$day];
	}
	
	function is_pasar($goods_id){
		global $db;
		$pasar_category_id = 49;
		$category_ids = $db->fetch_single_data("goods","category_ids",["id" => $goods_id]);
		$category_ids = pipetoarray($category_ids);
		foreach($category_ids as $category_id){
			if($category_id == $pasar_category_id) return true;
			if($db->fetch_single_data("categories","parent_id",["id" => $category_id]) == $pasar_category_id) return true;
		}
		return false;
	}
	
	function pasar_category_ids(){
		global $db;
		$pasar_category_ids = "49";
		$categories = $db->fetch_all_data("categories",["id"],"parent_id='49'");
		foreach($categories as $category){ $pasar_category_ids .= ",".$category["id"]; }
		return $pasar_category_ids;
	}
	
	function arr_pasar_category_ids(){
		global $db;
		$arr[] = 49;
		$categories = $db->fetch_all_data("categories",["id"],"parent_id='49'");
		foreach($categories as $category){ $arr[] = $category["id"]; }
		return $arr;
	}
?>
<?php include_once "log_action.php"; ?>
