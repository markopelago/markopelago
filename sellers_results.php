<div class="goods_list">
	<table width="100%">
		<tr>
		<?php 
			if($_GET["s"] != "") $whereclause_seller = " (name LIKE '%".str_replace(" ","%",$_GET["s"])."%' OR description LIKE '%".$_GET["s"]."%' OR pic LIKE '%".$_GET["s"]."%')";
			$order_by = "";
			if($_GET["sort_id"] == "newest") $order_by = " ORDER BY id DESC";
			if($_GET["sort_id"] == "highest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1) DESC";
			if($_GET["sort_id"] == "lowest_price") $order_by = " ORDER BY (SELECT (price+(price*commission/100)) FROM goods_prices WHERE goods_id=goods.id ORDER BY id LIMIT 1)";
			
			$sellers = $db->fetch_all_data("sellers",[],$whereclause_seller.$order_by);
			foreach($sellers as $key => $seller){
				$img = $seller["logo"];
				if(!file_exists("users_images/".$img)) $img = "nologo.jpg";
				if($img == "") $img = "nologo.jpg";
				$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["id"],"default_seller" => 1]);
				if(isMobile()){
					if($key%2 == 0) echo "</tr><tr>";
				} else {
					if($key%5 == 0) echo "</tr><tr>";
				}
		?>
			<td width="<?=(!isMobile())?"20":"50";?>%" align="center" onclick="window.location='seller_detail.php?id=<?=$seller["id"];?>';">
				<div class="goods_list_thumbnail">
					<img class="img-responsive" src="users_images/<?=$img;?>">
					<div class="caption"><p><?=$seller["name"];?></p></div>
				</div>
			</td>
		<?php } ?>
		</tr>
	</table>
</div>