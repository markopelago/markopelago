<?php include_once "head.php";?>
<div class="bo_title">Surveys</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$sel_users = $f->select("sel_users",$db->fetch_select_data("a_users","id","name",["id"=>"(SELECT user_id FROM backofficers):IN"],[],"",true),@$_GET["sel_users"],"style='height:20px'");
				$sel_survey_templates = $f->select("sel_survey_templates",$db->fetch_select_data("survey_templates","id","name",[],[],"",true),@$_GET["sel_survey_templates"],"style='height:20px'");
				$txt_name = $f->input("txt_name",@$_GET["txt_name"]);
				$sel_locations = $f->select("sel_locations",$db->fetch_select_data("locations","id","name_id",[],"parent_id,seqno","",true),@$_GET["sel_locations"],"style='height:20px'");
			?>
			<?=$t->row(array("User",$sel_users));?>
			<?=$t->row(array("Survey Name",$sel_survey_templates));?>
			<?=$t->row(array("Name",$txt_name));?>
			<?=$t->row(array("Location",$sel_locations));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if(@$_GET["sel_users"]!="") 			$whereclause .= "user_id = '".$_GET["sel_users"]."' AND ";
	if(@$_GET["sel_survey_templates"]!="")	$whereclause .= "survey_template_id = '".$_GET["sel_survey_templates"]."' AND ";
	if(@$_GET["txt_name"]!="")		 		$whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["txt_name"])."%"."' AND ";
	if(@$_GET["sel_locations"]!="")	 		$whereclause .= "location_id = '".$_GET["sel_locations"]."' AND ";
	
	$maxrow = $db->get_maxrow("surveys",substr($whereclause,0,-4));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("surveys");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$surveys = $db->fetch_data(true);
?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('user_id');\">User</div>",
						"<div onclick=\"sorting('survey_name');\">Survey Name</div>",
						"<div onclick=\"sorting('surveyed_at');\">Surveyed At</div>",
						"<div onclick=\"sorting('name');\">Name</div>",
						"<div onclick=\"sorting('email');\">Email</div>",
						"<div onclick=\"sorting('location_id');\">Location</div>",					
						""));?>
	<?php 
		foreach($surveys as $no => $survey){
			$actions = 	"<a href=\"surveys_view.php?id=".$survey["id"]."\">View</a>";
			$user = $db->fetch_single_data("a_users","name",["id" => $survey["user_id"]]);
			$location = $db->fetch_single_data("locations","name_id",["id" => $survey["location_id"]]);
			echo $t->row(
				[$no+$start+1,$user,$survey["survey_name"],format_tanggal($survey["surveyed_at"]),$survey["name"],$survey["email"],$location,$actions],
				["align='right' valign='top'",""]
			);
		} 
	?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>