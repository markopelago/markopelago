<?php include_once "homepage_header.php"; ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<div class="item active">	<img class="img-responsive" src="assets/banner_header_1.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_2.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_3.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_4.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_5.png" style="object-fit:cover;width:100%;"></div>
	</div>
</div>
<div class="category_title"><?=v("categories");?></div>
<div class="categories_head">
	<div class="container">
		<div class="row <?=(isMobile())?"scrolling-wrapper":"";?>">
			<table class="table_categories_head">
				<tr>
				<?php 
					$categories_td_width = "width='12%'";
					if(isMobile()) $categories_td_width = "style='width:100px !important;'";
					unset($categories);
					$categories = $db->fetch_all_data("categories",[],"id IN (1,2,3,4,5,6,8,9)","id");
					foreach($categories as $key => $category){
						$img = "category_".$category["id"].".png";
				?>
					<td <?=$categories_td_width;?> onclick="window.location='category_detail.php?id=<?=$category["id"];?>';">
						<div>
							<p><?=$category["name_".$__locale];?></p>
							<img class="img-responsive" src="assets/<?=$img;?>">
						</div>
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
	<div class="row">
		<div class="sub-title-text"><?=v("recommended_goods");?></div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<img class="img-responsive" src="banners/banner_01.png">
		</div>
		<div class="col-md-7 home_recommended_goods">
			<table width="100%">
				<tr>
				<?php 
					$products = $db->fetch_all_data("goods",[],"1=1 ORDER BY RAND() LIMIT 8");
					foreach($products as$key => $product){
						$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
						if(!file_exists("goods/".$img)) $img = "no_goods.png";
						if($img == "") $img = "no_goods.png";
						if(isMobile()){
							if($key%2 == 0) echo "</tr><tr>";
						} else {
							if($key%4 == 0) echo "</tr><tr>";
						}
				?>
						<td align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
							<div class="home_recommended_goods_thumbnail">
								<img class="img-responsive" src="goods/<?=$img;?>">
								<div class="caption"><p><?=substr($product["name"],0,20);?></p></div>
								<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
							</div>
						</td>
				<?php } ?>
				</tr>
			</table>
		</div>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<div class="sub-title-text member_reason"><?=v("reason_markopelago_member");?></div>
	</div>
</div>
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="position:relative;top:-15px;">
	<div class="carousel-inner">
		<div class="item active">	<img class="img-responsive" src="assets/markopelago_reason_1.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/markopelago_reason_2.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/markopelago_reason_3.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/markopelago_reason_4.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/markopelago_reason_5.png" style="object-fit:cover;width:100%;"></div>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<div class="sub-title-text"><?=v("newest_goods");?></div>
	</div>
	<div class="home_recommended_goods <?=(isMobile())?"scrolling-wrapper":"";?>" style="padding-bottom:20px;">
		<table width="100%" cellspacing="10">
		<?php 
			$newest_goods_td_width = "width='20%'";
			if(isMobile()) $newest_goods_td_width = "style='width:100px !important;'";
			$products = $db->fetch_all_data("goods",[],"1=1 ORDER BY created_at DESC LIMIT 5");
			foreach($products as$key => $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
				if(!file_exists("goods/".$img)) $img = "no_goods.png";
				if($img == "") $img = "no_goods.png";
		?>
			<td <?=$newest_goods_td_width;?> align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
				<div class="home_recommended_goods_thumbnail" style="padding:10px;">
					<img class="img-responsive" src="goods/<?=$img;?>">
					<div class="caption"><p><?=substr($product["name"],0,20);?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
				</div>
			</td>
			<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<?php } ?>
		</table>
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
			<div class="img-thumbnail seller-thumbnail" style="height:210px;">
				<a href="seller_detail.php?id=<?=$seller["id"];?>">
					<img class="img-circle" src="users_images/<?=$seller["logo"];?>" alt="#">
					<img class="seller_body_profile" src="assets/seller_body_profile_1.png">
					<center>
						<div class="caption"><b><p><?=$seller["name"];?></p></b></div>
						<div class="location"><p><i class="fa fa-map-marker" style="font-size:24px">&nbsp;</i><?=$seller_location;?></p></div>
					</center>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<?php //include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>