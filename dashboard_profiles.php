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
<script>
	function is_taxable_change(elmChecked){
		if(elmChecked == true){
			document.getElementById("is_taxable_area").style.display = "block";
			document.getElementById("npwp").required = true;
			document.getElementById("npwp_address").required = true;
		} else {
			document.getElementById("is_taxable_area").style.display = "none";
			document.getElementById("npwp").required = false;
			document.getElementById("npwp_address").required = false;
		}
	}
</script>
<form method="POST">
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
	<div class="form-group">
		<?php $checked = ($__user["is_taxable"] == "1") ? "checked":"";?>
		<label><?=v("is_taxable");?></label><?=$f->input("is_taxable","1",$checked ." type='checkbox' onclick='is_taxable_change(this.checked);'","form-control");?> <?=v("yes");?>
	</div>
	<div id="is_taxable_area" style="display:<?=($__user["is_taxable"] == "1") ? "block":"none";?>">
		<div class="form-group">
			<label><?=v("npwp");?></label><?=$f->input("npwp",$__user["npwp"],"placeholder='".v("npwp")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("nppkp");?></label><?=$f->input("nppkp",$__user["nppkp"],"placeholder='".v("nppkp")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("npwp_address");?></label><?=$f->textarea("npwp_address",$__user["npwp_address"],"placeholder='".v("npwp_address")."...'","form-control");?>
		</div>
	</div>
	<?=$f->input("save_profile",v("save"),"type='submit' width='75%'","btn btn-primary");?>
</form>
<div style="height:20px;"></div>