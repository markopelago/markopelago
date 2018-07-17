<?php
	if(isset($_POST["next"])){
		$db->addtable("buyers");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
		$db->addfield("birthplace_id");		$db->addvalue($_POST["location_id"]);
		$db->addfield("gender_id");			$db->addvalue($_POST["gender_id"]);
		
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){ 
			javascript("window.location='?step=3';"); 
		} else {
			$_SESSION["errormessage"] = v("saving_data_failed");
		}
	}
	$data = $_POST;
	$locations = $db->fetch_select_data("locations","id","name_".$__locale,[],"parent_id,seqno");
?>
<form role="form" method="POST" autocomplete="off">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("birth_at");?></label><?=$f->input("birthdate",$data["birthdate"],"type='date' required placeholder='".v("store_name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("birth_place");?></label><?=$f->select("location_id",$locations,$data["location_id"],"required placeholder='".v("birth_place")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("gender");?></label><?=$f->select("gender_id",$db->fetch_select_data("genders","id","name_".$__locale),$data["gender_id"],"required placeholder='".v("gender")."...'","form-control");?>
		</div>
		
		
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>