<div class="goods_list">
	<?php
		$_GET["category_id"] = ($_GET["category_id"]=="")?$_GET["c"]:$_GET["category_id"];
		if($_GET["province_id"] > 0)
			if($_GET["city_id"] > 0) $location = get_location($_GET["city_id"])["caption"]; else $location = get_location($_GET["province_id"])["caption"];
		
		if($_GET["price_min"] > 0) $pricerange = "Rp. ".format_amount($_GET["price_min"]);
		if($_GET["price_max"] > 0){
			if($_GET["price_min"] <= 0) $pricerange .= "Rp. ".format_amount(0);
			$pricerange .= "&nbsp;".v("to")."&nbsp;Rp. ".format_amount($_GET["price_max"]);
		} else {
			if($_GET["price_min"] > 0) $pricerange .= "&nbsp;".v("to")."&nbsp;Rp. ".v("no_limit");
		}
		
	?>
	<div class="search_result"><?=v("search_result");?> <div class="search_result_value">"<?=$_GET["s"];?>"</div></div><br>
	<?php if($location != ""){ ?> <div class="location"><?=v("location");?></div> <div class="location_value">: <?=$location;?></div> <?php } ?>
	<?php if($pricerange != ""){ ?> <div class="location"><?=v("price");?></div> <div class="location_value">: <?=$pricerange;?></div> <?php } ?>
	<table width="100%">
		<tr>
		<?php 
			$whereclause = "";
			if($_GET["c"] || $_GET["category_id"]){
				if($_GET["category_id"] == "") $_GET["category_id"] = $_GET["c"];
				if($_GET["c"] == "") $_GET["c"] = $_GET["category_id"];
				$category_ids = "(";
				$categories = $db->fetch_all_data("categories",["id"],"parent_id = '".$_GET["category_id"]."'");
				foreach($categories as $category){
					$category_ids .= "category_ids like '%|".$category["id"]."|%' OR ";
				}
				$category_ids = substr($category_ids,0,-3).") AND ";
			}
			if($_GET["s"] != "") $whereclause .= "(name LIKE '%".str_replace(" ","%",$_GET["s"])."%' OR description LIKE '%".$_GET["s"]."%')";
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