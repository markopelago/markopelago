<div class="frame_common">
	<div class="frame_body">
		<?php $img = "category_".$_GET["category_id"].".png";?>
		<img src="assets/<?=$img;?>">&nbsp;&nbsp;
		<a class="btn btn-default" href="javascript:window.history.back();"><span class="glyphicon glyphicon-chevron-left"></span></a>&nbsp;&nbsp;
		<?=$db->fetch_single_data("categories","name_".$__locale,["id" => $_GET["category_id"]]);?>
	</div>
</div>
<div class="goods_list">
	<?php if($_GET["category_id"] == 49 && $_GET["subcategories"] <= 0 && isMobile()){ ?>
		<table width="100%">
			<tr>
			<?php
				$category_ids = [51,52,53,54,55,56,57,58,59,60,61,62,63,64,66,67,68,69,72,73];
				foreach($category_ids as $key => $category_id){
					echo "<td style=\"width:20%;padding:5px;\"><a href='?category_id=49&s=".$_GET["s"]."&c=".$_GET["c"]."&sort_id=".$_GET["sort_id"]."&keyword=".$_GET["keyword"]."&subcategories=".$category_id."&subcategory_ids%5B%5D=".$category_id."&province_id=".$_GET["province_id"]."&city_id=".$_GET["city_id"]."&price_min=".$_GET["price_min"]."&price_max=".$_GET["price_max"]."&search=CARI'><img style=\"width:100%;height:auto;\" src=\"assets/category_".$category_id.".png\"></a></td>";
					if(($key+1)%4 == 0) echo "</tr><tr>";
				}
			?>
			</tr>
		</table>
	<?php } else { ?>
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
				if($_GET["keyword"] != "") $whereclause .= " AND (name LIKE '%".str_replace(" ","%",$_GET["keyword"])."%' OR description LIKE '%".$_GET["keyword"]."%')";
				if($_GET["province_id"] > 0){
					if($_GET["city_id"] > 0) $location_ids = get_location_childest_ids($_GET["city_id"]);
					else $location_ids = get_location_childest_ids($_GET["province_id"]);
					$whereclause .= " AND seller_id IN (SELECT id FROM sellers WHERE user_id IN (SELECT user_id FROM user_addresses WHERE location_id IN ($location_ids)))";
				}
				if($_GET["price_min"] > 0) $whereclause .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) >= '".$_GET["price_min"]."'";
				if($_GET["price_max"] > 0) $whereclause .= " AND (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) <= '".$_GET["price_max"]."'";
				if(count($_GET["subcategory_ids"]) > 0 || $_GET["subcategories"] == "73"){
					$whereclause .= " AND (";
					foreach($_GET["subcategory_ids"] as $subcategory_id){
						$whereclause .= "category_ids like '%|".$subcategory_id."|%' OR ";
					}
					if($_GET["subcategories"] == "73"){ //Lainnya
						$whereclause .= "category_ids like '%|50|%' OR ";
						$whereclause .= "category_ids like '%|57|%' OR ";
						$whereclause .= "category_ids like '%|58|%' OR ";
					}
					$whereclause = substr($whereclause,0,-3).")";
				}
				if($__markopasar_seller_id > 0 && $_GET["category_id"] == 49) $whereclause .= " AND seller_id = '".$__markopasar_seller_id."'";

				$order_by = "";
				if($_GET["sort_id"] == "newest") $order_by = " ORDER BY id DESC";
				if($_GET["sort_id"] == "highest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) DESC";
				if($_GET["sort_id"] == "lowest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1)";
				
				$products = $db->fetch_all_data("goods",[],$category_ids." ".$whereclause.$order_by);
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
					$goods_id = $product["id"];
					$minqty = 1;
			?>
				<td width="<?=(!isMobile())?"20":"50";?>%" align="center" onclick="window.location='product_detail.php?id=<?=$product["id"];?>';">
					<div class="goods_list_thumbnail">
						<img onclick="window.location='product_detail.php?id=<?=$goods_id;?>';" class="img-responsive" src="goods/<?=$img;?>" style="cursor:pointer;">
						<div class="caption"><p><?=$product["name"];?></p></div>
						<div class="price">
							<table>
								<tr>
									<td><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?><?php } ?></p></td>
								</tr>
							</table>
						</div>
						<div class="seller" style="padding-left:3px;padding-right:3px;"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></div>
					</div>
				</td>
			<?php } ?>
			</tr>
		</table>
	<?php } ?>
</div>
<div style="height:40px;"></div>