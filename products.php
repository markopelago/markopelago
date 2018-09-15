<?php include_once "header.php"; ?>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"> <?=v("goods_list");?> </div>
	</div>
	<?php 
		if($_GET["s"] == ""){
			$_SESSION["errormessage"] = v("please_type_your_serach");
			javascript("window.location='index.php';");
			exit();
		}
		$whereclause = "";
		if($_GET["s"] != "") $whereclause .= "(name LIKE '%".str_replace(" ","%",$_GET["s"])."%' OR description LIKE '%".$_GET["s"]."%')";
		if($_GET["c"] > 0) $whereclause .= " AND category_ids LIKE '%|".$_GET["c"]."|%'";
		$products = $db->fetch_all_data("goods",[],$whereclause);
		foreach($products as $product){
			$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
			if(!file_exists("goods/".$img)) $img = "no_goods.png";
			if($img == "") $img = "no_goods.png";
			$seller_user_id = $db->fetch_single_data("sellers","user_id",["id"=> $product["seller_id"]]);
			$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
	?>
		<div class="img-thumbnail goods-thumbnail goods-thumbnail2">
			<a href="product_detail.php?id=<?=$product["id"];?>">
				<img src="goods/<?=$img;?>" alt="#">
				<div class="caption"><p><?=substr($product["name"],0,50);?></p></div>
				<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
				<button class="btn btn-primary btn-sm" style="width:100%"><?=v("buy");?></button>
				<div class="seller-info">
					<?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?><br>
					<span class="glyphicon glyphicon-map-marker"></span> <?=get_location($seller_location_id)[0]["name"];?>
				</div>
			</a>
		</div>
	<?php } ?>
</div>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>