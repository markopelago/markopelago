<?php
	include_once "homepage_header.php";
	if($__seller_id != $db->fetch_single_data("goods","seller_id",["id" => $_GET["id"]])){
		$_SESSION["errormessage"] = v("you_dont_have_access");
		javascript("window.location='dashboard.php?tabActive=goods'");
		exit();
	}
	$goods = $db->fetch_all_data("goods",[],"id='".$_GET["id"]."' AND seller_id = '".$__seller_id."'")[0];
	$dimension = explode("x",$goods["dimension"]);
	$goods["length"] = trim($dimension[0]);
	$goods["width"] = trim($dimension[1]);
	$goods["height"] = trim($dimension[2]);
	
	$category_ids = str_replace("||",",",$goods["category_ids"]); $category_ids = str_replace("|","",$category_ids);
	$forwarder_ids = str_replace("||",",",$goods["forwarder_ids"]); $forwarder_ids = str_replace("|","",$forwarder_ids);
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
		<h2 class="well"><?=strtoupper(v("goods"));?></h2>
	</div>
</div>
<div class="container">
	<div class="row">
		<?php 
			$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id='".$_GET["id"]."' ORDER BY seqno");
			if(count($goods_photos) <= 0){
				?> <table class="table table-striped table-hover"><tr class="danger"><td colspan="9" align="center"><b><?=v("data_not_found");?></b></td></tr></table> <?php
			} else {
				foreach($goods_photos as $goods_photo){
					?> <div class="img-thumbnail" style="height:200px !important;"> <img src="goods/<?=$goods_photo["filename"];?>" alt="#"> </div> <?php 
				}
			} 
		?>
	</div>
	<div class="row">	
		<form method="POST">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("categories");?></label> 
					<?=$f->select("categories",$db->fetch_select_data("categories","id","name_".$__locale,["parent_id" => "0:>"],[]),"","multiple=\"multiple\"","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("goods_name");?></label><?=$f->input("name",$goods["name"],"disabled placeholder='".v("goods_name")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("description");?></label><?=$f->textarea("description",$goods["description"],"disabled placeholder='".v("description")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label>Barcode</label><?=$f->input("barcode",$goods["barcode"],"disabled placeholder='Barcode...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("condition");?></label><?=$f->select("is_new",["" => "","1" => v("new"),"2" => v("second_hand")],$goods["is_new"],"disabled placeholder='".v("unit")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("unit");?></label><?=$f->select("unit_id",$db->fetch_select_data("units","id","name_".$__locale,[],["name_".$__locale],"",true),$goods["unit_id"],"disabled placeholder='".v("unit")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("weight_per_unit");?> (gram)</label><?=$f->input("weight",$goods["weight"],"type='number' step='any' disabled placeholder='".v("weight")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("dimension");?> (<?=v("l_w_h");?>)</label>
					<div class="row">
						<div class="col-md-2"><?=$f->input("length",$goods["length"],"type='number' step='any' disabled placeholder='".v("length")."...'","form-control");?></div>
						<div class="col-md-1"> X </div>
						<div class="col-md-2"><?=$f->input("width",$goods["width"],"type='number' step='any' disabled placeholder='".v("width")."...'","form-control");?></div>
						<div class="col-md-1"> X </div>
						<div class="col-md-2"><?=$f->input("height",$goods["height"],"type='number' step='any' disabled placeholder='".v("height")."...'","form-control");?></div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<div class="form-group">
					<label><?=v("availability_days");?> (<?=v("days");?>)</label><?=$f->input("availability_days",$goods["availability_days"],"type='number' step='any' disabled placeholder='".v("availability_days")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("price");?> (<?=v("rupiahs");?>)</label><?=$f->input("price",$goods["price"],"type='number' step='any' disabled placeholder='".v("price")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("delivery_courier");?></label> 
					<?=$f->select("couriers",$db->fetch_select_data("forwarders","id","name",[],["id"]),"","multiple=\"multiple\"","form-control");?>
				</div>
				
				
				<div class="form-group">
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php?tabActive=goods';\"","btn btn-warning");?>
					<?=$f->input("edit",v("edit_goods"),"type='button' onclick=\"window.location='goods_edit.php?id=".$_GET["id"]."';\"","btn btn-primary");?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php"; ?>