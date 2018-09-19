<?php include_once "homepage_header.php"; ?>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<div class="col-md-5">
			<br>
			<div id="myCarousel" class="carousel slide carousel-main" data-ride="carousel">
				<!-- Wrapper for slides -->
				<div class="carousel-inner carousel-inner-main">
					<div class="item active">	<img src="images/main01.jpg"><div class="carousel-overlay"></div></div>
					<div class="item">			<img src="images/main02.jpg"><div class="carousel-overlay"></div></div>
					<div class="item">			<img src="images/main03.jpg"><div class="carousel-overlay"></div></div>
					<div class="item">			<img src="images/main04.jpg"><div class="carousel-overlay"></div></div>
					<div class="item">			<img src="images/main05.jpg"><div class="carousel-overlay"></div></div>
				</div>
				<!-- Left and right controls -->
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>	<span class="sr-only">Next</span>
				</a>
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
					<li data-target="#myCarousel" data-slide-to="3"></li>
					<li data-target="#myCarousel" data-slide-to="4"></li>
				</ol>	
			</div>
		</div>
		<div class="col-md-7">
			<div class="hidden-md hidden-lg" style="height:20px;"></div>
			<div class="row sub-title-area">
				<div class="sub-title-text"><?=v("categories");?></div>
				<div class="view-all-text"><a href="products.php?s=%20"><?=v("view_all");?></a></div>
			</div>
			<table class="table-categories">
				<tr>
				<?php 
					unset($categories);
					$categories = $db->fetch_all_data("categories",[],"parent_id = 0 AND id IN(1,2,3,4,5,6,8,9)","id");
					foreach($categories as $key => $category){
						if(($key)%4 == 0) echo "</tr><tr>";
				?>
					<td width="25%">
						<a href="category_detail.php?id=<?=$category["id"];?>">
							<img src="icons/categories/<?=$category["id"].".png";?>" alt="#">
							<div class="caption"><p><?=$category["name_".$__locale];?></p></div>
						</a>
					</td>
				<?php
					}
				?>
				</tr>
			</table>
		</div>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("best_selling_goods");?></div>
		<div class="view-all-text"><a href="products.php?s=%20"><?=v("view_all");?></a></div>
	</div>
	<div class="scrolling-wrapper">
		<?php 
			$products = $db->fetch_all_data("goods",[],"1=1 ORDER BY RAND() LIMIT 10");
			foreach($products as $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
				if(!file_exists("goods/".$img)) $img = "no_goods.png";
				if($img == "") $img = "no_goods.png";
		?>
			<div class="img-thumbnail goods-thumbnail">
				<a href="product_detail.php?id=<?=$product["id"];?>">
					<img src="goods/<?=$img;?>" alt="#">
					<div class="caption"><p><?=substr($product["name"],0,50);?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<div class="sub-title-text"><?=v("recommended_goods");?></div>
		<div class="view-all-text"><a href="products.php?s=%20"><?=v("view_all");?></a></div>
	</div>
	<div class="row">
		<?php 
			$products = $db->fetch_all_data("goods",[],"1=1 ORDER BY RAND() LIMIT 12");
			foreach($products as $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
				if(!file_exists("goods/".$img)) $img = "no_goods.png";
				if($img == "") $img = "no_goods.png";
		?>
			<div class="col-md-2 col-xs-4" style="margin-bottom:10px;">
				<div style="width:100%;" class="img-thumbnail goods-thumbnail">
					<center>
						<a href="product_detail.php?id=<?=$product["id"];?>">
							<img src="goods/<?=$img;?>" alt="#">
							<div class="caption"><p><?=substr($product["name"],0,20);?></p></div>
							<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
						</a>
					</center>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("recommended_sellers");?></div>
	</div>
	<div class="scrolling-wrapper">
		<?php 
			$sellers = $db->fetch_all_data("sellers",[],"1=1 ORDER BY RAND() LIMIT 10");
			foreach($sellers as $seller){
				if(!file_exists("users_images/".$seller["logo"])) $seller["logo"] = "nologo.jpg";
				if($seller["logo"] == "") $seller["logo"] = "nologo.jpg";
				$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => 1]);
				$seller_location = get_location($seller_location_id)[0]["name"];
		?>
			<div class="img-thumbnail seller-thumbnail">
				<a href="seller_detail.php?id=<?=$seller["id"];?>">
					<img class="img-circle" src="users_images/<?=$seller["logo"];?>" alt="#">
					<center>
						<div class="caption"><b><p><?=$seller["name"];?></p></b></div>
						<div class="location"><p><?=$seller_location;?></p></div>
					</center>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<?php //include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>