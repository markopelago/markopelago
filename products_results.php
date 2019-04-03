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
	<?php if(@$location != ""){ ?> <div class="location"><?=v("location");?></div> <div class="location_value">: <?=@$location;?></div> <?php } ?>
	<?php if(@$pricerange != ""){ ?> <div class="location"><?=v("price");?></div> <div class="location_value">: <?=@$pricerange;?></div> <?php } ?>
	<table width="100%">
		<tr>
		<?php
			if(!$_GET["c"] && $_GET["category_id"]) $_GET["c"] = $_GET["category_id"];
			$whereclauseCommon = "is_displayed = '1' ";

			$category_pasar_ids = "";
			if($_GET["c"] == 49 || $_GET["c"] == ""){
				$category_pasar_ids = "(";
				$categories = $db->fetch_all_data("categories",["id"],"parent_id = '49'");
				foreach($categories as $category){
					$category_pasar_ids .= "category_ids like '%|".$category["id"]."|%' OR ";
				}
				$category_pasar_ids = " AND ".substr($category_pasar_ids,0,-3).")";
			}

			if($_GET["c"]){
				$category_ids = "(";
				$categories = $db->fetch_all_data("categories",["id"],"parent_id = '".$_GET["category_id"]."'");
				foreach($categories as $category){
					$category_ids .= "category_ids like '%|".$category["id"]."|%' OR ";
				}
				$category_ids = " AND ".substr($category_ids,0,-3).")";
			} else {
				$whereclauseNonPasar .= " AND (category_ids NOT LIKE '%|49|%'";
				$pasar_ids = $db->fetch_all_data("categories",["id"],"parent_id = 49");
				foreach($pasar_ids as $pasar_id){ $whereclauseNonPasar .= " AND category_ids NOT LIKE '%|".$pasar_id["id"]."|%'"; }
				$whereclauseNonPasar .=")";
			}
			if($_GET["s"] != "") $whereclauseCommon .= " AND (name LIKE '%".str_replace(" ","%",$_GET["s"])."%' OR description LIKE '%".$_GET["s"]."%')";
			if($_GET["keyword"] != "") $whereclauseCommon .= " AND (name LIKE '%".str_replace(" ","%",$_GET["keyword"])."%' OR description LIKE '%".$_GET["keyword"]."%')";
			if($_GET["province_id"] > 0){
				if($_GET["city_id"] > 0) $location_ids = get_location_childest_ids($_GET["city_id"]);
				else $location_ids = get_location_childest_ids($_GET["province_id"]);
				$whereclauseCommon .= " AND seller_id IN (SELECT id FROM sellers WHERE user_id IN (SELECT user_id FROM user_addresses WHERE location_id IN ($location_ids)))";
			}
			if($_GET["price_min"] > 0) $whereclauseCommon .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) >= '".$_GET["price_min"]."'";
			if($_GET["price_max"] > 0) $whereclauseCommon .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) <= '".$_GET["price_max"]."'";
			if(count(@$_GET["subcategory_ids"]) > 0){
				$whereclauseCommon .= " AND (";
				foreach($_GET["subcategory_ids"] as $subcategory_id){
					$whereclauseCommon .= "category_ids like '%|".$subcategory_id."|%' OR ";
				}
				$whereclauseCommon = substr($whereclauseCommon,0,-3).")";
			}
			
			$order_by = "";
			if($_GET["sort_id"] == "newest") $order_by = " ORDER BY id DESC";
			if($_GET["sort_id"] == "highest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) DESC";
			if($_GET["sort_id"] == "lowest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1)";
			
			$products1 = [];
			$products2 = [];

			$whereAdditional = " AND IF(seller_id = '26' OR seller_id = '103', `seller_id`, '".$__markopasar_seller_id."') = '".$__markopasar_seller_id."'";

			$products1 = $db->fetch_all_data("goods",[],$whereclauseCommon.$category_ids.$whereclauseNonPasar.$whereAdditional.$order_by);
			if($_GET["c"] == 49 || $_GET["c"] == "") 
				$products2 = $db->fetch_all_data("goods",[],$whereclauseCommon.$category_pasar_ids.$whereAdditional.$order_by);
			$products = array_merge($products2,$products1);

			// if(count($products) <= 0 && $_GET["c"] == "" && $_GET["category_id"] == ""){ javascript("window.location='?s=".$_GET["s"]."&c=49';"); }//try category pasar
			
			foreach($products as $key => $product){
				$is_pasar = is_pasar($product["id"]);
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
			<td width="<?=(!isMobile())?"20":"50";?>%" align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
				<div class="goods_list_thumbnail">
					<img class="img-responsive" src="goods/<?=$img;?>">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?><?php } ?></p></div>
					<div class="seller"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></div>
				</div>
			</td>
		<?php } ?>
		</tr>
	</table>
</div>