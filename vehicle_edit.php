<?php
	include_once "header.php";
	if(isset($_POST["save_vehicle"])){
		if($_SESSION["errormessage"] == ""){
			$db->addtable("forwarder_vehicles");
			$db->where("id",$_GET["id"]);
			$db->where("user_id",$__user_id);
			$db->addfield("vehicle_type_id");	$db->addvalue($_POST["vehicle_type_id"]);
			$db->addfield("vehicle_brand_id");	$db->addvalue($_POST["vehicle_brand_id"]);
			$db->addfield("dimension_load_l");	$db->addvalue($_POST["dimension_load_l"]);
			$db->addfield("dimension_load_w");	$db->addvalue($_POST["dimension_load_w"]);
			$db->addfield("dimension_load_h");	$db->addvalue($_POST["dimension_load_h"]);
			$db->addfield("max_load");			$db->addvalue($_POST["max_load"]);
			$db->addfield("nopol");				$db->addvalue($_POST["nopol"]);
			$db->addfield("description");		$db->addvalue($_POST["description"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				$_SESSION["message"] = v("data_saved_successfully");
				javascript("window.location='dashboard.php?tabActive=vehicles';");
				exit();
			} else {
				$_SESSION["errormessage"] = v("failed_saving_data");
			}
		}
	}
	$_POST = $db->fetch_all_data("forwarder_vehicles",[],"id='".$_GET["id"]."' AND user_id = '".$__user_id."'")[0];
?>
<script>
	$(document).ready(function() {
		
	});
</script>
<div class="container">
	<div class="row">	
		<h3 class="well"><b><?=strtoupper(v("add_vehicle"));?></b></h3>
	</div>
</div>
<div class="container">
	<div class="row">	
		<form method="POST" action="?id=<?=$_GET["id"];?>">
			<input style="display:none;" type="submit" id="btn_save_vehicle" name="btn_save_vehicle" value="1">
			<input type="hidden" name="save_vehicle" value="1">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("vehicle_type");?></label> 
					<?=$f->select("vehicle_type_id",$db->fetch_select_data("vehicle_types","id","name",[],[],"",true),$_POST["vehicle_type_id"],"required","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("vehicle_brand");?></label> 
					<?=$f->select("vehicle_brand_id",$db->fetch_select_data("vehicle_brands","id","name",[],[],"",true),$_POST["vehicle_brand_id"],"required","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("dimension");?> (<?=v("l_w_h");?>)</label>
					<div class="row">
						<div class="col-xs-3"><?=$f->input("dimension_load_l",$_POST["dimension_load_l"],"type='number' step='any' required placeholder='".v("length")."...'","form-control");?></div>
						<div class="col-xs-1"> X </div>
						<div class="col-xs-3"><?=$f->input("dimension_load_w",$_POST["dimension_load_w"],"type='number' step='any' required placeholder='".v("width")."...'","form-control");?></div>
						<div class="col-xs-1"> X </div>
						<div class="col-xs-3"><?=$f->input("dimension_load_h",$_POST["dimension_load_h"],"type='number' step='any' required placeholder='".v("height")."...'","form-control");?></div>
						<div class="col-xs-1"></div>
					</div>
				</div>
				<div class="form-group">
					<label><?=v("max_load");?> (Kg)</label><?=$f->input("max_load",$_POST["max_load"],"required placeholder='".v("max_load")." (Kg)...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("vehicle_plat_number");?></label><?=$f->input("nopol",$_POST["nopol"],"required placeholder='".v("vehicle_plat_number")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("description");?></label><?=$f->textarea("description",$_POST["description"],"required placeholder='".v("description")."...'","form-control");?>
				</div>
				<div class="form-group">
					<button class="btn btn-warning" onclick="window.location='dashboard.php?tabActive=vehicles';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
					<button style="float:right;" class="btn btn-primary" onclick="btn_save_vehicle.click();"><?=v("next");?> <span class="glyphicon glyphicon-floppy-saved"></span></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php"; ?>