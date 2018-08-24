<?php include_once "header.php"; ?>
<?php
	$seller = $db->fetch_all_data("sellers",[],"id='".$_GET["id"]."'")[0];
	if(!$seller["header_image"]) $seller["header_image"] = "no_header.jpg";
	if(!$seller["logo"]) $seller["logo"] = "nologo.jpg";
	$location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => "1"]); 
?>
<div class="container">	
	<div class="row">
		<img class="img-responsive" src="users_images/<?=$seller["header_image"];?>">
	</div>
	<div class="row store-logo">
		<img class="img-responsive" style="display:inline;float:left;" src="users_images/<?=$seller["logo"];?>">
		<div class="store-title"><?=$seller["name"];?></div>
		<div class="store-subtitle">
			<span class="glyphicon glyphicon-map-marker"></span> <?=$db->fetch_single_data("locations","name_".$__locale,["id" => $location_id]);?>
		</div>
	</div>
</div>
<div class="container store-desc">
	<div class="row">
		<div class="panel panel-info">
			<div class="panel-heading"><?=$seller["description"];?></div>
		</div>
	</div>
	<div class="row sub-title-area">
		<div class="sub-title-text"> <?=v("goods_list");?> </div>
	</div>
	<?php
		$products = $db->fetch_all_data("goods",[],"seller_id = '".$seller["id"]."'");
		foreach($products as $product){
			$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
			if($img == "") $img = "no_goods.png";
	?>
		<div class="img-thumbnail thumbnail_goods">
			<a href="product_detail.php?id=<?=$product["id"];?>">
				<img src="goods/<?=$img;?>" alt="#">
				<div class="caption"><p><?=substr($product["name"],0,50);?></p></div>
				<div class="price"><p>Rp. <?=format_amount($product["price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
				<button class="btn btn-primary btn-sm" style="width:100%"><?=v("buy");?></button>
				<div class="seller-info">
					<img src="icons/location.png" alt="#" style="width:15px; height:15px;">
					<?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?>
				</div>
			</a>
		</div>
	<?php } ?>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>