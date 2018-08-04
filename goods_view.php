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
	
	$category_ids = pipetoarray($goods["category_ids"]);
	$forwarder_ids = pipetoarray($goods["forwarder_ids"]);
	
	$goods_categories = "";
	foreach($category_ids as $category_id){ $goods_categories .= $db->fetch_single_data("categories","name_".$__locale,["id" => $category_id]).", "; }
	$goods_categories = substr($goods_categories,0,-2);
	
	$goods_forwarders = "";
	foreach($forwarder_ids as $forwarder_id){ $goods_forwarders .= $db->fetch_single_data("forwarders","name",["id" => $forwarder_id]).", "; }
	$goods_forwarders = substr($goods_forwarders,0,-2);
	
	$good_is_new = "";
	if($goods["is_new"] == "1") $good_is_new = v("new");
	if($goods["is_new"] == "2") $good_is_new = v("second_hand");
	
?>
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
			$stock_in = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["id"],"in_out" => "in"]);
			$stock_out = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["id"],"in_out" => "out"]);
			$stock = $stock_in - $stock_out;
			$btnStockHistory = "<div style=\"position:relative;float:right;\">".$f->input("stock_history",v("stock_history"),"type='button' onclick=\"window.location='goods_stock_history.php?goods_id=".$_GET["id"]."';\"","btn btn-primary")."</div>";
		?>
	</div>
	<br>
	<div class="form-group">
		<?=$f->input("edit_goods_photo",v("edit_goods_photo"),"type='button' onclick=\"window.location='goods_photo.php?id=".$_GET["id"]."';\"","btn btn-primary");?>
	</div>
	<div class="row">
		<?=$t->start("","","table table-striped table-hover");?>
			<?=$t->row(["<b>".v("categories")."</b>",$goods_categories]);?>
			<?=$t->row(["<b>".v("goods_name")."</b>",$goods["name"]]);?>
			<?=$t->row(["<b>".v("description")."</b>",$goods["description"]]);?>
			<!--<?=$t->row(["<b>Barcode</b>",$goods["barcode"]]);?>-->
			<?=$t->row(["<b>".v("condition")."</b>",$good_is_new]);?>
			<?=$t->row(["<b>".v("stock")."</b>",$stock." ".$btnStockHistory]);?>
			<?=$t->row(["<b>".v("unit")."</b>",$db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]])]);?>
			<?=$t->row(["<b>".v("weight_per_unit")."</b>",$goods["weight"]]);?>
			<?=$t->row(["<b>".v("dimension"). " (".v("l_w_h").")</b>",$goods["dimension"]]);?>
			<?=$t->row(["<b>".v("availability_days")."</b>",$goods["availability_days"]." ".v("days")]);?>
			<?=$t->row(["<b>".v("price")."</b>","Rp. ".format_amount($goods["price"])]);?>
			<?=$t->row(["<b>".v("delivery_courier")."</b>",$goods_forwarders]);?>
		<?=$t->end();?>
		
		<div class="col-md-12">
			<div class="form-group">
				<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php?tabActive=goods';\"","btn btn-warning");?>
				<?=$f->input("edit",v("edit_goods"),"type='button' onclick=\"window.location='goods_edit.php?id=".$_GET["id"]."';\"","btn btn-primary");?>
			</div>
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>