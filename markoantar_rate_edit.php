<?php
	include_once "header.php";
	if(isset($_POST["save_markoantar_rate"])){
		if($_SESSION["errormessage"] == ""){
			$db->addtable("forwarder_routes");
			$db->where("id",$_GET["id"]);
			$db->where("user_id",$__user_id);
			$db->addfield("vehicle_id");				$db->addvalue($_POST["vehicle_id"]);
			$db->addfield("source_location_id");		$db->addvalue($_POST["subdistrict_id"]);
			$db->addfield("destination_location_id");	$db->addvalue($_POST["subdistrict_id_destination"]);
			$db->addfield("price");						$db->addvalue($_POST["price"]);
			$db->addfield("load_type_id");				$db->addvalue($_POST["load_type_id"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				$_SESSION["message"] = v("data_saved_successfully");
				javascript("window.location='dashboard.php?tabActive=markoantar_rates';");
				exit();
			} else {
				$_SESSION["errormessage"] = v("failed_saving_data");
			}
		}
	}
	$_POST = $db->fetch_all_data("forwarder_routes",[],"id='".$_GET["id"]."' AND user_id = '".$__user_id."'")[0];
	$locations = get_location($_POST["source_location_id"]);
	$province_id = $locations[0]["id"];
	$city_id = $locations[1]["id"];
	$district_id = $locations[2]["id"];
	$subdistrict_id = $locations[3]["id"];
	
	$locations = get_location($_POST["destination_location_id"]);
	$province_destination_id = $locations[0]["id"];
	$city_id_destination = $locations[1]["id"];
	$district_id_destination = $locations[2]["id"];
	$subdistrict_id_destination = $locations[3]["id"];
?>
<script>
	$(document).ready(function() {
		
	});
</script>
<div class="container">
	<div class="row">	
		<h3 class="well"><b><?=strtoupper(v("add_markoantar_rate"));?></b></h3>
	</div>
</div>
<div class="container">
	<div class="row">	
		<form method="POST">
			<input style="display:none;" type="submit" id="btn_markoantar_rate" name="btn_markoantar_rate" value="1">
			<input type="hidden" name="save_markoantar_rate" value="1">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("vehicle");?></label> 
					<?=$f->select("vehicle_id",$db->fetch_select_data("forwarder_vehicles","id","concat(nopol,' [',(SELECT name FROM vehicle_types WHERE id=forwarder_vehicles.vehicle_type_id),' -- ',(SELECT name FROM vehicle_brands WHERE id=forwarder_vehicles.vehicle_brand_id),']')",["user_id" => $__user_id],[],"",true),$_POST["vehicle_id"],"required","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("load_type");?></label> 
					<?=$f->select("load_type_id",$db->fetch_select_data("load_types","id","name",[],[],"",true),$_POST["load_type_id"],"required","form-control");?>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading"><?=v("source_location");?></div>
					<div class="panel-body">
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
					</div>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading"><?=v("destination_location");?></div>
					<div class="panel-body">
						<div class="form-group">
							<label><?=v("province");?></label> <?=$f->select("province_destination_id",$provinces,$province_destination_id,"onchange=\"loadCities(this.value,'destination');\" required","form-control");?>
						</div>
						<div class="form-group" id="div_select_cities_destination" style="display:<?=($province_destination_id > 0) ? "block":"none";?>;">
							<?php $cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $province_destination_id],["name_".$__locale],"",true); ?>
							<label><?=v("city");?></label><div id="div_cities_destination"><?=$f->select("city_id_destination",$cities,$city_id_destination,"required onchange=\"loadDistricts(this.value,'destination');\"","form-control");?></div>
						</div>
						<div class="form-group" id="div_select_district_destination" style="display:<?=($city_id_destination > 0) ? "block":"none";?>;">
							<?php $districts = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $city_id_destination],["name_".$__locale],"",true); ?>
							<label><?=v("district");?></label><div id="div_districts_destination"><?=$f->select("district_id_destination",$districts,$district_id_destination,"required onchange=\"loadSubDistricts(this.value,'destination);\"","form-control");?></div>
						</div>
						<div class="form-group" id="div_select_subdistrict_destination" style="display:<?=($district_id_destination > 0) ? "block":"none";?>;">
							<?php $subdistricts = $db->fetch_select_data("locations","id","concat(name_".$__locale.",' [',zipcode,']')",["parent_id" => $district_id_destination],["name_".$__locale],"",true); ?>
							<label><?=v("subdistrict");?></label><div id="div_subdistricts_destination"><?=$f->select("subdistrict_id_destination",$subdistricts,$subdistrict_id_destination,"required","form-control");?></div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label><?=v("price");?> (Rp.)</label><?=$f->input("price",$_POST["price"],"type='number' required placeholder='".v("price")."...'","form-control");?>
				</div>
				<div class="form-group">
					<button class="btn btn-warning" onclick="window.location='dashboard.php?tabActive=vehicles';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
					<button style="float:right;" class="btn btn-primary" onclick="btn_markoantar_rate.click();"><?=v("next");?> <span class="glyphicon glyphicon-floppy-saved"></span></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php"; ?>