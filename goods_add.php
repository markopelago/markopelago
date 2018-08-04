<?php
	include_once "homepage_header.php";
	if(isset($_POST["save_goods"])){
		if(count($_POST["forwarder_ids"]) <= 0)	$_SESSION["errormessage"] = v("please_select_couriers");
		if(count($_POST["category_ids"]) <= 0)	$_SESSION["errormessage"] = v("please_select_categories");
		
		if($_SESSION["errormessage"] == ""){
			$dimension = $_POST["length"]." x ".$_POST["width"]." x ".$_POST["height"];
			$db->addtable("goods");
			$db->addfield("barcode");			$db->addvalue($_POST["barcode"]);
			$db->addfield("seller_id");			$db->addvalue($__seller_id);
			$db->addfield("category_ids");		$db->addvalue(sel_to_pipe($_POST["category_ids"]));
			$db->addfield("unit_id");			$db->addvalue($_POST["unit_id"]);
			$db->addfield("promo_id");			$db->addvalue($_POST["promo_id"]);
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("description");		$db->addvalue($_POST["description"]);
			$db->addfield("weight");			$db->addvalue($_POST["weight"]);
			$db->addfield("dimension");			$db->addvalue($dimension);
			$db->addfield("is_new");			$db->addvalue($_POST["is_new"]);
			$db->addfield("price");				$db->addvalue($_POST["price"]);
			$db->addfield("availability_days");	$db->addvalue($_POST["availability_days"]);
			$db->addfield("forwarder_ids");		$db->addvalue(sel_to_pipe($_POST["forwarder_ids"]));
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
</script>
<div class="container">
	<div class="row">	
		<h2 class="well"><?=strtoupper(v("add_goods"));?></h2>
	</div>
</div>
<div class="container">
	<div class="row">	
		<form method="POST">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("categories");?></label> 
					<?=$f->select("categories",$db->fetch_select_data("categories","id","name_".$__locale,["parent_id" => "0:>"],[]),"","multiple=\"multiple\"","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("goods_name");?></label><?=$f->input("name",$_POST["name"],"required placeholder='".v("goods_name")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("description");?></label><?=$f->textarea("description",$_POST["description"],"required placeholder='".v("description")."...'","form-control");?>
				</div>
				<!--div class="form-group">
					<label>Barcode</label><?=$f->input("barcode",$_POST["barcode"],"required placeholder='Barcode...'","form-control");?>
				</div-->
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
						<div class="col-md-2"><?=$f->input("length",$_POST["length"],"type='number' step='any' required placeholder='".v("length")."...'","form-control");?></div>
						<div class="col-md-1"> X </div>
						<div class="col-md-2"><?=$f->input("width",$_POST["width"],"type='number' step='any' required placeholder='".v("width")."...'","form-control");?></div>
						<div class="col-md-1"> X </div>
						<div class="col-md-2"><?=$f->input("height",$_POST["height"],"type='number' step='any' required placeholder='".v("height")."...'","form-control");?></div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<div class="form-group">
					<label><?=v("availability_days");?> (<?=v("days");?>)</label><?=$f->input("availability_days",$_POST["availability_days"],"type='number' step='any' required placeholder='".v("availability_days")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("price");?> (<?=v("rupiahs");?>)</label><?=$f->input("price",$_POST["price"],"type='number' step='any' required placeholder='".v("price")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("delivery_courier");?></label> 
					<?=$f->select("couriers",$db->fetch_select_data("forwarders","id","name",[],["id"]),"","multiple=\"multiple\"","form-control");?>
				</div>
				
				
				<div class="form-group">
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php?tabActive=goods';\"","btn btn-warning");?>
					<?=$f->input("save_goods",v("next"),"type='submit'","btn btn-primary");?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php"; ?>