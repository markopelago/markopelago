<?php include_once "header.php"; ?>

<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text">
		<?=$db->fetch_single_data("categories","name_".$__locale,["id"=>$_GET["id"]]);?>
		</div>
	</div>
		<?php 
			
			$products = $db->fetch_all_data("goods",[],"category_ids like '%|".$_GET["id"]."|%' ORDER BY RAND() LIMIT 10");
			foreach($products as $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
		?>
			<div class="img-thumbnail thumbnail_goods">
				<a href="product_detail.php?id=<?=$product["id"];?>">
					<img src="products/<?=$img;?>" alt="#">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price"><p>Rp. <?=format_amount($product["price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
					<button class="btn btn-primary btn-sm" style="width:100%"><?=v("buy");?></button>
					<div class="seller-info"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></p></div>
					<div class="location-info"><img src="icons/location.png" alt="#" style="width:10px; height:10px;">
					<?php 
						$location_id = $db->fetch_single_data("sellers","location_id",["id"=>$product["seller_id"]]);
						echo $db->fetch_single_data("locations","name_".$__locale,["id"=>$location_id]);
					?>
					</p>
					</div>
				</a>
			</div>
		<?php } ?>
</div>


<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>