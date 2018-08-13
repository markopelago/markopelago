<?php include_once "header.php"; ?>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"> <?=v("goods");?> </div>
	</div>
	<?php 
		if($_GET["s"] == ""){
			$_SESSION["errormessage"] = v("please_type_your_serach");
			javascript("window.location='index.php';");
			exit();
		}
		$whereclause = "";
		if($_GET["s"] != "") $whereclause .= "(name LIKE '%".$_GET["s"]."%' OR description LIKE '%".$_GET["s"]."%')";
		if($_GET["c"] > 0) $whereclause .= " AND category_ids LIKE '%|".$_GET["c"]."|%'";
		$products = $db->fetch_all_data("goods",[],$whereclause);
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