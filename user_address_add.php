<?php
	include_once "homepage_header.php";
	if(isset($_POST["save_address"])){
		$db->addtable("user_addresses");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("location_id");		$db->addvalue($_POST["subdistrict_id"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='dashboard.php?tabActive=addresses';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_data");
		}
	}
?>
<div class="row">	
	<div class="container">
		<h2 class="well"><?=strtoupper(v("dashboard"));?></h2>
		<h3><?=v("add_address");?></h3>
	</div>
	<div class="container">
		<form method="POST">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("name");?></label><?=$f->input("name","","required placeholder='".v("name")."... (".v("example_home_office").")'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("pic");?></label><?=$f->input("pic",$pic,"required placeholder='".v("pic")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("phone");?></label><?=$f->input("phone",$phone,"required placeholder='".v("phone")."...'","form-control");?>
				</div>
				<div class="form-group">
					<?php $provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["name_".$__locale],"",true); ?>
					<label><?=v("province");?></label> <?=$f->select("province_id",$provinces,$province_id,"required","form-control");?>
				</div>
				<div class="form-group" id="div_select_cities" style="display:none;">
					<label><?=v("city");?></label><div id="div_cities"></div>
				</div>
				<div class="form-group" id="div_select_district" style="display:none;">
					<label><?=v("district");?></label><div id="div_districts"></div>
				</div>
				<div class="form-group" id="div_select_subdistrict" style="display:none;">
					<label><?=v("subdistrict");?></label><div id="div_subdistricts"></div>
				</div>
				<div class="form-group">
					<label><?=v("address");?></label><?=$f->textarea("address",$address,"required placeholder='".v("address")."...'","form-control");?>
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