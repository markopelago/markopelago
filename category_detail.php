<?php include_once "header.php"; ?>
<h3><span class="glyphicon glyphicon-chevron-left" onClick="history.go(-1);">Back</span></h3>
<div style="height:60px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"> <?=$db->fetch_single_data("categories","name_".$__locale,["id"=>$_GET["id"]]);?> </div>
	</div>
	<?php 
		$products = $db->fetch_all_data("goods",[],"category_ids like '%|".$_GET["id"]."|%' ORDER BY RAND() LIMIT 10");
		foreach($products as $product){
			$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
			if($img == "") $img = "no_goods.png";
	?>
		<div class="img-thumbnail thumbnail_goods">
			<a href="product_detail.php?id=<?=$product["id"];?>">
				<img src="goods/<?=$img;?>" alt="#">
				<div class="caption"><p><?=$product["name"];?></p></div>
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