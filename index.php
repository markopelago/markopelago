<?php include_once "homepage_header.php"; ?>
<script>
	function loadmarketplace(){
		setTimeout(function(){ 
			$("html, body").animate({ scrollTop: <?=(isMobile())?"570":"500";?> }, 800); 
		}, 500);
	}
</script>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<div class="item active">	<img class="img-responsive" src="assets/banner_header_<?=(isMobile())?"m_":"";?>9.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_<?=(isMobile())?"m_":"";?>6.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_<?=(isMobile())?"m_":"";?>7.png" style="object-fit:cover;width:100%;"></div>
		<div class="item">			<img class="img-responsive" src="assets/banner_header_<?=(isMobile())?"m_":"";?>8.png" style="object-fit:cover;width:100%;"></div>
	</div>
</div>
<div class="category_title"><?=v("categories");?></div>
<div class="container">
	<div class="row">
<?php 
	$categories_td_width = "";
	if(!isMobile()) $categories_td_width = "style='width:70px !important;'";
	unset($categories);
	$categories = $db->fetch_all_data("categories",[],"id IN (1,3,4,5,6,8,9,49)","id=49 desc,id=1 desc, id");
	foreach($categories as $key => $category){
		$img = "wide_category_".$category["id"].".png";
?>
	<a href="category_detail.php?category_id=<?=$category["id"];?>"><img class="img-responsive" src="assets/<?=$img;?>"></a>
<?php
	}
?>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<div class="col-md-5">
			<a href="category_detail.php?category_id=49"><img class="img-responsive" src="assets/banner_pasar03.png"></a>
		</div>
		<div class="col-md-7 home_recommended_goods" style="<?=(isMobile())?"margin-top:30px;":"";?>">
			<div class="sub-title-text" style="margin-bottom:0px;"><?=v("recommended_goods");?></div>
			<div class="view-all-text" style="font-weight:bolder;font-size:1em;margin-right:10px;"><a href="products.php?s=+"><?=v("view_all");?></a></div>
			<table width="100%">
				<tr>
				<?php 
					$limit = 8;
					if(isMobile()) $limit = 20;
					$no_pasar_cat = "AND (category_ids NOT LIKE '%|49|%' ";
					$pasar_ids = $db->fetch_all_data("categories",["id"],"parent_id = 49");
					foreach($pasar_ids as $pasar_id){ $no_pasar_cat .= "AND category_ids NOT LIKE '%|".$pasar_id["id"]."|%'"; }
					$no_pasar_cat .=")";
					
					$products1 = $db->fetch_all_data("goods",[],"is_displayed = '1' AND id IN (248,303,291,244,179,221,283,412) LIMIT $limit");
					$products2 = $db->fetch_all_data("goods",[],"is_displayed = '1' ".$no_pasar_cat." ORDER BY RAND() LIMIT $limit");
					$products = $products1 + $products2;
					foreach($products as $key => $product){
						$is_pasar = is_pasar($product["id"]);
						$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
						if(!file_exists("goods/".$img)) $img = "no_goods.png";
						if($img == "") $img = "no_goods.png";
						if(isMobile()){
							if($key%2 == 0) echo "</tr><tr>";
						} else {
							if($key%4 == 0) echo "</tr><tr>";
						}
				?>
						<td width="<?=(!isMobile())?"25":"50";?>%" align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
							<div class="home_recommended_goods_thumbnail">
								<img class="img-responsive" src="goods/<?=$img;?>">
								<div class="caption"><p><?=$product["name"];?></p></div>
								<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?> <?php } ?></p></div>
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
		<div class="sub-title-text"><?=v("newest_goods");?><div class="view-all-text" style="font-size:0.7em;margin-top:15px;margin-right:10px;"><a href="products.php?s=+"><?=v("view_all");?></a></div></div>
	</div>
	<div class="home_recommended_goods <?=(isMobile())?"scrolling-wrapper":"";?>" style="padding-bottom:20px;">
		<table width="100%"><tr>
		<?php 
			$limit = 5;
			if(isMobile()) $limit = 20;
			$notpasar = "AND category_ids NOT LIKE '%|49|%' ";
			$categories = $db->fetch_all_data("categories",["id"],"parent_id='49'");
			foreach($categories as $category){ $notpasar .= "AND category_ids NOT LIKE '%|".$category["id"]."|%' "; }
			$products = $db->fetch_all_data("goods",[],"is_displayed = '1' $notpasar ORDER BY created_at DESC LIMIT $limit");
			foreach($products as $key => $product){
				$is_pasar = is_pasar($product["id"]);
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
				if(!file_exists("goods/".$img)) $img = "no_goods.png";
				if($img == "") $img = "no_goods.png";
				if(isMobile()) $product["name"] = wordwrap($product["name"],20,"<br />");
		?>	
			<td style="width:<?=(!isMobile())?"20%":"140px";?>;" align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';" align="center">
				<div class="home_recommended_goods_thumbnail" <?=(isMobile())?"style='width:140px;'":"";?>>
					<img class="img-responsive" src="goods/<?=$img;?>">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?><?php } ?></p></div>
				</div>
			</td>
			<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<?php } ?>
		</tr></table>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("recommended_sellers");?></div>
	</div>
	<div class="scrolling-wrapper">
		<?php 
			$i = 0;
			$sellers = $db->fetch_all_data("sellers",[],"1=1 ORDER BY RAND() LIMIT 10");
			foreach($sellers as $seller){
				if(!file_exists("users_images/".$seller["logo"])) $seller["logo"] = "nologo.jpg";
				if($seller["logo"] == "") $seller["logo"] = "nologo.jpg";
				$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => 1]);
				$seller_location = get_location($seller_location_id)[0]["name"];
				$i++;
				if($i>4) $i=1;
		?>
			<div class="img-thumbnail seller-thumbnail" style="height:210px;">
				<a href="seller_detail.php?id=<?=$seller["id"];?>">
					<img class="img-circle" src="users_images/<?=$seller["logo"];?>" alt="#">
					<img class="seller_body_profile" src="assets/seller_body_profile_<?=$i;?>.png">
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