<?php
	if($__phpself == "survey_edit.php") $data = $db->fetch_all_data("surveys",[],"id='".$id."' AND user_id='".$__user_id."'")[0];
	if(isset($_POST["next"])){
		$survey_name = $db->fetch_single_data("survey_templates","name",["id" => $template_id]);
		
		$db->addtable("surveys");
		if($__phpself == "survey_edit.php")	$db->where("id",$id);
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("survey_template_id");$db->addvalue($template_id);
		$db->addfield("survey_name");		$db->addvalue($survey_name);
		$db->addfield("surveyed_at");		$db->addvalue($__now);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("email");				$db->addvalue($_POST["email"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("location_id");		$db->addvalue($_POST["location_id"]);
		$db->addfield("coordinate");		$db->addvalue($_POST["coordinate"]);
		if($__phpself == "survey_add.php")	$inserting = $db->insert();
		if($__phpself == "survey_edit.php")	$inserting = $db->update();
		
		if($inserting["affected_rows"] >= 0){
			if($__phpself == "survey_add.php")	$insert_id = $inserting["insert_id"];
			else 								$insert_id = $id;
			javascript("window.location=\"survey_edit.php?step=2&id=".$insert_id."\";");
		} else {
			$data = $_POST;
		}
	}
	$locations = $db->fetch_select_data("locations","id","name_".$__locale,[],"parent_id,seqno");
	if(!$data["surveyed_at"]) $data["surveyed_at"] = substr($__now,0,10);
?>
<script>
	var latlong = "";
	var geoSuccess = function(position) {
		document.getElementById("coordinate").value = position.coords.latitude+" ; "+position.coords.longitude;
	};
	function get_coordinate(){
		navigator.geolocation.getCurrentPosition(geoSuccess,geoSuccess);
	}
</script>
<form role="form" method="POST" autocomplete="off" onsubmit="return validation()" enctype="multipart/form-data">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("surveyed_at");?></label><?=$f->input("surveyed_at",$data["surveyed_at"],"required placeholder='".v("surveyed_at")."...' type='date'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("name");?></label><?=$f->input("name",$data["name"],"required placeholder='".v("name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("email");?></label><?=$f->input("email",$data["email"],"type='email' placeholder='".v("email")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required placeholder='".v("phone")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("address");?></label><?=$f->textarea("address",$data["address"],"required placeholder='".v("address")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("location");?></label><?=$f->select("location_id",$locations,$data["location_id"],"required placeholder='".v("location")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("coordinate");?></label>
			<?=$f->input("coordinate",$data["coordinate"],"placeholder='".v("coordinate")."...'","form-control");?>
			<?=$f->input("get_gps",v("get_coordinate"),"type='button' onclick='get_coordinate();'","btn btn-info");?>
		</div>
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>