<?php
	include_once "header.php";
	if(isset($_POST["save_goods"])){
		if($_POST["markoantar_ids"]!=""){
			$markoantar_ids = explode(",",$_POST["markoantar_ids"]);
			foreach($markoantar_ids as $markoantar_id){ 
				if($markoantar_id > 0) $_POST["forwarder_ids"][] = $markoantar_id;
			}
		}
		if(count($_POST["forwarder_ids"]) <= 0)	$_SESSION["errormessage"] = v("please_select_couriers");
		if(count($_POST["category_ids"]) <= 0)	$_SESSION["errormessage"] = v("please_select_categories");
		
		if($_SESSION["errormessage"] == ""){
			$dimension = $_POST["length"]." x ".$_POST["width"]." x ".$_POST["height"];
			$_POST["color_id"] = array_swap($_POST["color_id"]);
			$db->addtable("goods");
			$db->addfield("barcode");			$db->addvalue($_POST["barcode"]);
			$db->addfield("seller_id");			$db->addvalue($__seller_id);
			$db->addfield("category_ids");		$db->addvalue(sel_to_pipe($_POST["category_ids"]));
			$db->addfield("color_ids");			$db->addvalue(sel_to_pipe($_POST["color_id"]));
			$db->addfield("unit_id");			$db->addvalue($_POST["unit_id"]);
			$db->addfield("promo_id");			$db->addvalue($_POST["promo_id"]);
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("description");		$db->addvalue($_POST["description"]);
			$db->addfield("weight");			$db->addvalue($_POST["weight"]);
			$db->addfield("dimension");			$db->addvalue($dimension);
			$db->addfield("is_new");			$db->addvalue($_POST["is_new"]);
			$db->addfield("availability_days");	$db->addvalue($_POST["availability_days"]);
			$db->addfield("forwarder_ids");		$db->addvalue(sel_to_pipe($_POST["forwarder_ids"]));
			$db->addfield("self_pickup");		$db->addvalue($_POST["self_pickup"]);
			$db->addfield("pickup_location_id");$db->addvalue($_POST["subdistrict_id"]);
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$_SESSION["message"] = v("data_saved_successfully");
				javascript("window.location='goods_photo.php?id=".$inserting["insert_id"]."';");
				exit();
			} else {
				$_SESSION["errormessage"] = v("failed_saving_data");
			}
		}
	}
	$category_ids = str_replace("||",",",sel_to_pipe($_POST["category_ids"])); $category_ids = str_replace("|","",$category_ids);
	$forwarder_ids = str_replace("||",",",sel_to_pipe($_POST["forwarder_ids"])); $forwarder_ids = str_replace("|","",$forwarder_ids);
?>
<link rel="stylesheet" href="styles/jquery.magicsearch.css">
<script src="scripts/jquery.magicsearch.min.js"></script>
<script>
	$(document).ready(function() {
		$('#categories').multiselect({
			checkboxName: function(option){ return 'category_ids[]'; },
			nonSelectedText: '<?=v("choose_categories");?>'
		});
		$("#categories").val("<?=$category_ids;?>".split(","));
		$("#categories").multiselect("refresh");
		
		$('#couriers').multiselect({
			checkboxName: function(option){ return 'forwarder_ids[]'; },
			nonSelectedText: '<?=v("choose_couriers");?>'
		});
		$("#couriers").val("<?=$forwarder_ids;?>".split(","));
		$("#couriers").multiselect("refresh");
		
	});
	function saving_goods(){
		$("#markoantar_ids").val($("#markoantar_ids").attr("data-id"));
		btn_save_goods.click();
	}
</script>
<div class="container">
	<div class="row">	
		<h3 class="well"><b><?=strtoupper(v("add_goods"));?></b></h3>
	</div>
</div>
<div class="container">
	<div class="row">	
		<form method="POST">
			<input style="display:none;" type="submit" id="btn_save_goods" name="btn_save_goods" value="1">
			<input type="hidden" name="save_goods" value="1">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("categories");?></label> 
					<?=$f->select("categories",$db->fetch_select_data("categories","id","name_".$__locale,["parent_id" => "0:>"],[]),"","multiple=\"multiple\"","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("colors");?></label>
					<?php 
						$colors = $db->fetch_all_data("colors");
						foreach($colors as $color){
							$ischecked = ($_POST["color_id"][$color["id"]] == 1)?"checked":"";
							?>
								<div class="color_pick" style="background-color:#<?=$color["code"];?>;">
									<?=$f->input("color_id[".$color["id"]."]",1,$ischecked." type='checkbox'","form-control");?>
									<div class="color_pick_caption"><?=$color["name_".$__locale];?></div>
								</div>
							<?php
						}
					?>
				</div>
				<br><br><br><br>
				<div class="form-group">
					<label><?=v("goods_name");?></label><?=$f->input("name",$_POST["name"],"required placeholder='".v("goods_name")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("description");?></label><?=$f->textarea("description",$_POST["description"],"required placeholder='".v("description")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("condition");?></label><?=$f->select("is_new",["" => "","1" => v("new"),"2" => v("second_hand")],$_POST["is_new"],"required placeholder='".v("unit")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("unit");?></label><?=$f->select("unit_id",$db->fetch_select_data("units","id","name_".$__locale,[],["name_".$__locale],"",true),$_POST["unit_id"],"required placeholder='".v("unit")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("weight_per_unit");?> (gram)</label><?=$f->input("weight",$_POST["weight"],"type='number' step='any' required placeholder='".v("weight")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("dimension");?> (<?=v("l_w_h");?>)</label>
					<div class="row">
						<div class="col-xs-3"><?=$f->input("length",$_POST["length"],"type='number' step='any' required placeholder='".v("length")."...'","form-control");?></div>
						<div class="col-xs-1"> X </div>
						<div class="col-xs-3"><?=$f->input("width",$_POST["width"],"type='number' step='any' required placeholder='".v("width")."...'","form-control");?></div>
						<div class="col-xs-1"> X </div>
						<div class="col-xs-3"><?=$f->input("height",$_POST["height"],"type='number' step='any' required placeholder='".v("height")."...'","form-control");?></div>
						<div class="col-xs-1"></div>
					</div>
				</div>
				<div class="form-group">
					<label><?=v("availability_days");?> (<?=v("days");?>)</label><?=$f->input("availability_days",$_POST["availability_days"],"type='number' step='any' required placeholder='".v("availability_days")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("delivery_courier");?></label> 
					<?=$f->select("couriers",$db->fetch_select_data("forwarders","id","name",["user_id"=>"0"],["id"]),"","multiple=\"multiple\"","form-control");?>
				</div>
				<div class="form-group">
					<label>Marko Antar</label><?=$f->input("markoantar_ids","","data-id='".$_POST["markoantar_ids"]."' placeholder='Marko Antar...'","form-control magicsearch");?>
				</div>
				<div class="form-group">
					<label><?=v("self_pickup");?></label>
					<?=$f->select("self_pickup",["0" => v("no"),"1" => v("yes")],$_POST["self_pickup"],"","form-control");?>
				</div>
				<div class="panel panel-primary">
					<div class="panel-heading"><?=v("pickup_location");?></div>
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
				<div class="form-group">
					<button class="btn btn-warning" onclick="window.location='dashboard.php?tabActive=goods';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
					<button style="float:right;" class="btn btn-primary" onclick="saving_goods();"><?=v("next");?> <span class="glyphicon glyphicon-arrow-right"></span></button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	<?php $markoantars = $db->fetch_select_data("forwarders","id","name",["user_id" => "0:>"],["name"]);?>
	var markoantars = [ <?php foreach($markoantars as $id => $name){ echo "{id: ".$id.", name: '".$name."'},";} ?> ];
	$('#markoantar_ids').magicsearch({
		dataSource: markoantars,
		fields: ['name'],
		id: 'id',
		format: '%name%',
		multiple: true,
		focusShow: true,
		multiField: 'name',
		multiStyle:{width: 150}
	});
</script>
<?php include_once "footer.php"; ?>