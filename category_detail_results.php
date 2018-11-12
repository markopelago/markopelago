<div class="frame_common">
	<div class="frame_body">
		<?php $img = "category_".$_GET["category_id"].".png";?>
		<img src="assets/<?=$img;?>">&nbsp;&nbsp;
		<a class="btn btn-default" href="javascript:window.history.back();"><span class="glyphicon glyphicon-chevron-left"></span></a>&nbsp;&nbsp;
		<?=$db->fetch_single_data("categories","name_".$__locale,["id" => $_GET["category_id"]]);?>
	</div>
</div>
<div class="goods_list">
	<table width="100%">
		<tr>
		<?php 
			$category_ids = "(";
			$categories = $db->fetch_all_data("categories",["id"],"parent_id = '".$_GET["category_id"]."'");
			foreach($categories as $category){
				$category_ids .= "category_ids like '%|".$category["id"]."|%' OR ";
			}
			$category_ids = substr($category_ids,0,-3).")";
			$whereclause = " AND is_displayed = '1' ";
			if($_GET["province_id"] > 0){
				if($_GET["city_id"] > 0) $location_ids = get_location_childest_ids($_GET["city_id"]);
				else $location_ids = get_location_childest_ids($_GET["province_id"]);
				$whereclause .= " AND seller_id IN (SELECT id FROM sellers WHERE user_id IN (SELECT user_id FROM user_addresses WHERE location_id IN ($location_ids)))";
			}
			if($_GET["price_min"] > 0) $whereclause .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) >= '".$_GET["price_min"]."'";
			if($_GET["price_max"] > 0) $whereclause .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) <= '".$_GET["price_max"]."'";
			
			$products = $db->fetch_all_data("goods",[],$category_ids." ".$whereclause." ORDER BY RAND()");
			foreach($products as $key => $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
				if(!file_exists("goods/".$img)) $img = "no_goods.png";
				if($img == "") $img = "no_goods.png";
				$seller_user_id = $db->fetch_single_data("sellers","user_id",["id"=> $product["seller_id"]]);
				$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
				if(isMobile()){
					if($key%2 == 0) echo "</tr><tr>";
				} else {
					if($key%5 == 0) echo "</tr><tr>";
				}
		?>
			<td align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
				<div class="goods_list_thumbnail">
					<img class="img-responsive" src="goods/<?=$img;?>">
					<div class="caption"><p><?=substr($product["name"],0,20);?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
					<div class="seller"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></div>
				</div>
			</td>
		<?php } ?>
		</tr>
	</table>
</div>