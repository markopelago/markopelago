<script>
	function add_to_cart(goods_id,qty){
		var btnCartArea = document.getElementById("add_to_cart_"+goods_id);
		btnCartArea.innerHTML = "<div><img src='images/fancybox_loading.gif' style=\"width:15px;height:15px;\"></div>";
		$.get("ajax/transaction.php?mode=add_to_cart&goods_id="+goods_id+"&goods_qty="+qty+"&notes_for_seller=", function(returnval){
			toastr.success("<?=v("success_add_to_cart");?>","",toastroptions);
			$.get("ajax/transaction.php?mode=cartcount", function(returnval){
				try{document.getElementById("val_cartcount1").innerHTML = returnval; } catch(e){}
				try{document.getElementById("val_cartcount2").innerHTML = returnval; } catch(e){}
				btnCartArea.innerHTML = "";
			});
		});
	}
</script>
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
			
			$products = $db->fetch_all_data("goods",[],$category_ids." ".$whereclause);
			foreach($products as $key => $product){
				$is_pasar = false;
				if(strpos(" ".$product["category_ids"],"|".$__pasar."|") > 0) $is_pasar = true;
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
			<td align="center" <?=(!$is_pasar)?"onclick=\"window.location='product_detail.php?id=".$product["id"]."';\"":"";?>>
				<div class="goods_list_thumbnail">
					<img class="img-responsive" src="goods/<?=$img;?>">
					<div class="caption"><p><?=substr($product["name"],0,20);?></p></div>
					<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?><?php } ?></p></div>
					<div class="seller"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></div>
					<?php if($is_pasar){ ?>
						<div class="direct_cart">
							<div style="position:relative;float:left;">
								<div class="oval_border2">
									<div class="left_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepDown(1);">-</div>
									<div class="center_text"><?=$f->input("qty[".$goods_id."]",$minqty,"type='number' min='1' step='1'");?></div>
									<div class="right_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepUp(1);">+</div>
								</div>
							</div>
							<div style="position:relative;float:left;margin-left:10px;">
								<span class="glyphicon glyphicon-shopping-cart" style="color:#800000;font-size:1.5em;cursor:pointer;" onclick="add_to_cart('<?=$goods_id;?>',document.getElementById('qty[<?=$goods_id;?>]').value);" id="add_to_cart_<?=$goods_id;?>"></span>
							</div>
							<div style="position:relative;float:left;margin-left:10px;">
								<span class="glyphicon glyphicon-search" style="color:#29A9E1;font-size:1.5em;cursor:pointer;" onclick="window.location='product_detail.php?id=<?=$goods_id;?>';"></span>
							</div>
						</div>
					<?php } ?>
				</div>
			</td>
		<?php } ?>
		</tr>
	</table>
</div>