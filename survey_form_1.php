<?php
	if($__phpself == "survey_edit.php") $data = $db->fetch_all_data("surveys",[],"id='".$id."' AND user_id='".$__user_id."'")[0];
	if(isset($_POST["next"])){
		$survey_name = $db->fetch_single_data("survey_templates","name",["id" => $template_id]);
		
		$db->addtable("surveys");
		if($__phpself == "survey_edit.php")	$db->where("id",$id);
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("survey_template_id");$db->addvalue($template_id);
		$db->addfield("survey_name");		$db->addvalue($survey_name);
		$db->addfield("surveyed_at");		$db->addvalue($_POST["surveyed_at"]);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("email");				$db->addvalue($_POST["email"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("location_id");		$db->addvalue($_POST["subdistrict_id"]);
		$db->addfield("coordinate");		$db->addvalue($_POST["coordinate"]);
		if($__phpself == "survey_add.php")	$inserting = $db->insert();
		if($__phpself == "survey_edit.php")	$inserting = $db->update();
		
		if($inserting["affected_rows"] >= 0){
			if($__phpself == "survey_add.php")	$insert_id = $inserting["insert_id"];
			else 								$insert_id = $id;
			javascript("window.location=\"survey_edit.php?step=2&id=".$insert_id."\";");
			exit();
		} else {
			$data = $_POST;
		}
	}
	if(!$data["surveyed_at"]) $data["surveyed_at"] = substr($__now,0,10);
	$locations = get_location($data["location_id"]);
	$province_id = $locations[0]["id"];
	$city_id = $locations[1]["id"];
	$district_id = $locations[2]["id"];
	$subdistrict_id = $locations[3]["id"];
	
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
<form role="form" method="POST" autocomplete="off">				
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
			<?php $provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["name_".$__locale],"",true); ?>
			<label><?=v("province");?></label> <?=$f->select("province_id",$provinces,$province_id,"required","form-control");?>
		</div>
		<div class="form-group" id="div_select_cities" style="display:<?=($province_id > 0) ? "block":"none";?>;">
			<?php $cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $province_id],["name_".$__locale],"",true); ?>
			<label><?=v("city");?></label><div id="div_cities"><?=$f->select("city_id",$cities,$city_id,"required onchange=\"loadDistricts(this.value);\"","form-control");?></div>
		</div>
		<div class="form-group" id="div_select_district" style="display:<?=($city_id > 0) ? "block":"none";?>;">
			<?php $districts = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $city_id],["name_".$__locale],"",true); ?>
			<label><?=v("district");?></label><div id="div_districts"><?=$f->select("district_id",$districts,$district_id,"required onchange=\"loadSubDistricts(this.value);\"","form-control");?></div>
		</div>
		<div class="form-group" id="div_select_subdistrict" style="display:<?=($district_id > 0) ? "block":"none";?>;">
			<?php $subdistricts = $db->fetch_select_data("locations","id","concat(name_".$__locale.",' [',zipcode,']')",["parent_id" => $district_id],["name_".$__locale],"",true); ?>
			<label><?=v("subdistrict");?></label><div id="div_subdistricts"><?=$f->select("subdistrict_id",$subdistricts,$subdistrict_id,"required","form-control");?></div>
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