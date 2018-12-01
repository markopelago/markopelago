<?php 
	include_once "header.php";
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
	$color_ids = pipetoarray($goods["color_ids"]);
	$forwarder_ids = pipetoarray($goods["forwarder_ids"]);
	
	$goods_categories = "";
	foreach($category_ids as $category_id){ $goods_categories .= $db->fetch_single_data("categories","name_".$__locale,["id" => $category_id]).", "; }
	$goods_categories = substr($goods_categories,0,-2);
	
	$goods_colors = "";
	foreach($color_ids as $color_id){
		$color_name = $db->fetch_single_data("colors","name_".$__locale,["id" => $color_id]);
		$color_code = $db->fetch_single_data("colors","code",["id" => $color_id]);
		$goods_colors .= "<div class='color_pick' style='background-color:#".$color_code.";'>";
		$goods_colors .= "	<div class='color_pick_caption'>".$color_name."</div>";
		$goods_colors .= "</div>"; 
	}
	$goods_colors = substr($goods_colors,0,-2);
	
	$goods_forwarders = "";
	foreach($forwarder_ids as $forwarder_id){ $goods_forwarders .= $db->fetch_single_data("forwarders","name",["id" => $forwarder_id]).", "; }
	$goods_forwarders = substr($goods_forwarders,0,-2);
	
	$good_is_new = "";
	if($goods["is_new"] == "1") $good_is_new = v("new");
	if($goods["is_new"] == "2") $good_is_new = v("second_hand");
	
?>
<div class="container">
	<div class="row">	
		<h4 class="well"><b><?=strtoupper(v("goods"));?></b></h4>
	</div>
</div>
<div class="container">
	<div class="row">
		<?php 
			$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id='".$_GET["id"]."' ORDER BY seqno");
			if(count($goods_photos) <= 0){
				?> <div class="alert alert-warning"><b><?=v("no_photo_found");?></b></div><?php
			} else {
				foreach($goods_photos as $goods_photo){
					if(!file_exists("goods/".$goods_photo["filename"])) $goods_photo["filename"] = "no_goods.png";
					?> <div class="img-thumbnail goods-thumbnail goods-thumbnail3"> <img src="goods/<?=$goods_photo["filename"];?>" alt="#"> </div> <?php 
				}
			} 
			$stock_in = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["id"],"in_out" => "in"]);
			$stock_out = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["id"],"in_out" => "out"]);
			$stock = $stock_in - $stock_out;
			$btnStockHistory = "<div style=\"position:relative;float:right;\">".$f->input("stock_history",v("stock_history"),"type='button' onclick=\"window.location='goods_stock_history.php?goods_id=".$_GET["id"]."';\"","btn btn-primary")."</div>";
			$btnGoodsPrices = "<div style=\"position:relative;float:right;\">".$f->input("goods_prices",v("goods_prices"),"type='button' onclick=\"window.location='goods_prices.php?goods_id=".$_GET["id"]."';\"","btn btn-primary")."</div>";
		?>
	</div>
	<br>
	<div class="form-group">
		<?=$f->input("edit_goods_photo",v("edit_goods_photo"),"type='button' onclick=\"window.location='goods_photo.php?id=".$_GET["id"]."';\"","btn btn-primary");?>
	</div>
	<div class="row">
		<table class="table table-striped table-hover">
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("categories");?></b></div>
					<div class="col-md-9"><?=$goods_categories;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("colors");?></b></div>
					<div class="col-md-9"><?=$goods_colors;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("goods_name");?></b></div>
					<div class="col-md-9"><?=$goods["name"];?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("description");?></b></div>
					<div class="col-md-9">
						<div class="panel-body">
							<p><?=str_replace(chr(13).chr(10),"<br>",$goods["description"]);?></p>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("condition");?></b></div>
					<div class="col-md-9"><?=$good_is_new;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("stock");?></b></div>
					<div class="col-md-9"><?=$stock." ".$btnStockHistory;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("unit");?></b></div>
					<div class="col-md-9"><?=$db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]]);?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("weight_per_unit");?></b></div>
					<div class="col-md-9"><?=$goods["weight"];?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("dimension");?><br>(<?=v("l_w_h");?>)</b></div>
					<div class="col-md-9"><?=$goods["dimension"];?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("availability_days");?></b></div>
					<div class="col-md-9"><?=$goods["availability_days"]." ".v("days");?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("price");?></b></div>
					<div class="col-md-9">Rp. <?=format_amount(get_goods_price($goods["id"])["display_price"])." ".$btnGoodsPrices;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("delivery_courier");?></b></div>
					<div class="col-md-9"><?=$goods_forwarders;?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("self_pickup");?></b></div>
					<div class="col-md-9"><?=($goods["self_pickup"] == "1")?v("yes"):v("no");?></div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="col-md-3"><b><?=v("pickup_location");?></b></div>
					<div class="col-md-9"><?=get_location($goods["pickup_location_id"])[3]["name"]." ,".get_location($goods["pickup_location_id"])[1]["name"];;?></div>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<button class="btn btn-warning" onclick="window.location='dashboard.php?tabActive=goods';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
				<button style="float:right;" class="btn btn-primary" onclick="window.location='goods_edit.php?id=<?=$_GET["id"];?>';"><span class="glyphicon glyphicon-edit"></span> <?=v("edit_goods");?></button>
			</div>
		</div>
	</div>
</div>
<?php include_once "footer.php"; ?>