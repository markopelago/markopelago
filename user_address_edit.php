<?php
	include_once "homepage_header.php";
	if(isset($_POST["save_address"])){
		$db->addtable("user_addresses");	$db->where("id",$_GET["id"]); $db->where("user_id",$__user_id);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("location_id");		$db->addvalue($_POST["subdistrict_id"]);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='dashboard.php?tabActive=addresses';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_data");
		}
	}
	
	$user_address = $db->fetch_all_data("user_addresses",[],"id='".$_GET["id"]."' AND user_id='".$__user_id."'")[0];
	$locations = get_location($user_address["location_id"]);
	$province_id = $locations[0]["id"];
	$city_id = $locations[1]["id"];
	$district_id = $locations[2]["id"];
	$subdistrict_id = $locations[3]["id"];
	
?>
<div class="row">	
	<div class="container">
		<h2 class="well"><?=strtoupper(v("dashboard"));?></h2>
		<h3><?=v("edit_address");?></h3>
	</div>
	<div class="container">
		<form method="POST" action="?id=<?=$_GET["id"];?>">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("name");?></label><?=$f->input("name",$user_address["name"],"required placeholder='".v("name")."... (".v("example_home_office").")'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("pic");?></label><?=$f->input("pic",$user_address["pic"],"required placeholder='".v("pic")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("phone");?></label><?=$f->input("phone",$user_address["phone"],"required placeholder='".v("phone")."...'","form-control");?>
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
					<label><?=v("address");?></label><?=$f->textarea("address",$user_address["address"],"required placeholder='".v("address")."...'","form-control");?>
				</div>
				
				<div class="form-group">
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php?tabActive=addresses';\"","btn btn-warning");?>
					<?=$f->input("save_address",v("save"),"type='submit'","btn btn-primary");?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php";