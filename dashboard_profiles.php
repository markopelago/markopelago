<div style="height:20px;" class="hidden-xs"></div>
<?php 
	if(isset($_POST["save_profile"])){
		$db->addtable("a_users");		$db->where("id",$__user_id);
		$db->addfield("name");			$db->addvalue($_POST["name"]);
		$db->addfield("phone");			$db->addvalue($_POST["phone"]);
		$db->addfield("is_taxable");	$db->addvalue($_POST["is_taxable"]);
		if($_POST["is_taxable"] == "1"){
			$db->addfield("npwp");			$db->addvalue($_POST["npwp"]);
			$db->addfield("nppkp");			$db->addvalue($_POST["nppkp"]);
			$db->addfield("npwp_address");	$db->addvalue($_POST["npwp_address"]);
		}
		$inserting = $db->update();
		if($inserting["affected_rows"] > 0){
			$db->addtable("buyers");		$db->where("user_id",$__user_id);
			$db->addfield("birthdate");		$db->addvalue($_POST["birthdate"]);
			$db->addfield("birthplace_id");	$db->addvalue($_POST["birthplace_id"]);
			$db->addfield("gender_id");		$db->addvalue($_POST["gender_id"]);
			$inserting = $db->update();
			
			$_SESSION["message"] = v("data_saved_successfully");
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
		javascript("window.location='?tabActive=profile'");
		exit();
	}
	$provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],"seqno","",true);
	$locations = array();
	$locations[""] = "";
	foreach($provinces as $province_id => $province){
		if($province_id > 0){
			$cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $province_id],"seqno","",true);
			foreach($cities as $city_id => $city){
				$locations[$city_id] = $city;
			}
		}
	}
	asort($locations);
?>
<form method="POST">
	<center>
		<div><img id="mainProfileImg" src="users_images/<?=($__buyer["avatar"] == "")?"nophoto.png":$__buyer["avatar"];?>"></div>
		<div><input name="change_avatar" id="change_avatar" value="<?=v("change_avatar");?>" style="width:200px;position:relative;top:-32px;" type="button" onclick="window.location='dashboard_avatar.php';" class="btn btn-primary"></div>
		<br><br>
	</center>
	<div class="form-group">
		<label>Marko ID</label><?=$__marko_id;?>
	</div>
	<div class="form-group">
		<label><?=v("name");?></label><?=$f->input("name",$__user["name"],"required placeholder='".v("name")."...'","form-control");?>
	</div>
	<div class="form-group">
		<label><?=v("phone");?></label><?=$f->input("phone",$__user["phone"],"required placeholder='".v("phone")."...'","form-control");?>
	</div>
	<div class="form-group">
		<label><?=v("birth_place");?></label><?=$f->select("birthplace_id",$locations,$__buyer["birthplace_id"],"required placeholder='".v("birth_place")."...'","form-control");?>
	</div>
	<div class="form-group">
		<label><?=v("birth_at");?></label><?=$f->input("birthdate",$__buyer["birthdate"],"type='date' required placeholder='".v("birth_at")."...'","form-control");?>
	</div>
	<div class="form-group">
		<label><?=v("gender");?></label><?=$f->select("gender_id",$db->fetch_select_data("genders","id","name_".$__locale,"","","",true),$__buyer["gender_id"],"required ","form-control");?>
	</div>
	<?=$f->input("save_profile",v("save"),"type='submit' width='75%'","btn btn-primary");?>
</form>
<div style="height:20px;"></div>