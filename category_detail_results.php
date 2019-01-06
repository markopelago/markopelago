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

	function calculate(goods_id,qty){
		$.get("ajax/transaction.php?mode=calculate&goods_id="+goods_id+"&qty="+qty, function(returnval){
			var values = returnval.split("|||");
			document.getElementById("price["+goods_id+"]").innerHTML = values[0];
			
		});
	}

	function cart_calculate(goods_id,qty){
		$.get("ajax/transaction.php?mode=cart_calculate&goods_id="+goods_id+"&qty="+qty, function(returnval){
			var values = returnval.split("|||");
            var val = values[4].replace("Rp. ", "");
			try{document.getElementById("total_buy").innerHTML = val;} catch(e){}
            
            try{
				var budget = document.getElementById("budget").value;
				var total_buy = document.getElementById("total_buy").textContent;
				var tot_buy = total_buy.replace("Rp. ", "");
				var tot_buy = tot_buy.replace(".", "");

				var total = budget - tot_buy;
				var total = total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
				document.getElementById("total").innerHTML = total;
			} catch(e){}
		});
	}

	function price_calculation(){
        var budget = document.getElementById("budget").value;
        var total_buy = document.getElementById("total_buy").textContent;
        var tot_buy = total_buy.replace("Rp. ", "");
        var tot_buy = tot_buy.replace(".", "");
        
        
        var total = budget - tot_buy;
        var total = total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")
        document.getElementById("total").innerHTML = total;
	}
	
	cart_calculate(0,0);
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
            <script> calculate(<?=$goods_id;?>,1); </script>
			<td width="<?=(!isMobile())?"20":"50";?>%" align="center" <?=(!$is_pasar)?"onclick=\"window.location='product_detail.php?id=".$product["id"]."';\"":"";?>>
				<div class="goods_list_thumbnail">
					<img onclick="window.location='product_detail.php?id=<?=$goods_id;?>';" class="img-responsive" src="goods/<?=$img;?>" style="cursor:pointer;">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price">
                        <table>
                            <tr>
                                <td id="price[<?=$goods_id;?>]"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> <?php if(!$is_pasar){?>/ <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?><?php } ?></p></td>
                            </tr>
                        </table>
                    </div>
					<div class="seller"><?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?></div>
					<?php if($is_pasar){ ?>
						<div class="direct_cart">
							<table <?=$__tblDesign100;?>>
								<tr>
									<td style="position:relative;float:left;">
											<div class="oval_border2">
												<div class="left_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepDown(1);calculate('<?=$goods_id;?>',document.getElementById('qty[<?=$goods_id;?>]').value);">-</div>
												<div class="center_text"><?=$f->input("qty[".$goods_id."]",$minqty,"type='number' min='1' step='1' onchange=\"calculate('".$goods_id."',this.value);\"");?></div>
												<div class="right_caption" onclick="document.getElementById('qty[<?=$goods_id;?>]').stepUp(1);calculate('<?=$goods_id;?>',document.getElementById('qty[<?=$goods_id;?>]').value);">+</div>
											</div>
									</td>
									<td style="position:relative;float:left;margin-left:10px;">
										<span class="glyphicon glyphicon-shopping-cart" style="color:#800000;font-size:<?=(!isMobile())?"1.5":"1.2";?>em;cursor:pointer;" onclick="add_to_cart('<?=$goods_id;?>',document.getElementById('qty[<?=$goods_id;?>]').value);cart_calculate('<?=$goods_id;?>',document.getElementById('qty[<?=$goods_id;?>]').value);price_calculation();" id="add_to_cart_<?=$goods_id;?>"></span>
									</td>
									<td style="position:relative;float:left;margin-left:10px;">
										<span class="glyphicon glyphicon-zoom-in" style="color:#29A9E1;font-size:<?=(!isMobile())?"1.5":"1.2";?>em;cursor:pointer;" onclick="window.location='product_detail.php?id=<?=$goods_id;?>';"></span>
									</td>
								</tr>
							</table>
						</div>
					<?php } ?>
				</div>
			</td>
		<?php } ?>
		</tr>
	</table>
</div>

<?php
if($is_pasar){
    $calculator=(!isMobile())?"calculator":"calculator_mobile";
    
?>
    <div class="<?=$calculator;?>" style="display:none;">
        <br>
        <table width="100%">
            <tr>
                <td width="40%"><b>&nbsp;&nbsp;Budget Belanja</b></td>
                <td width="10%"><b>&nbsp;&nbsp;Rp. </b></td>
                <td width="50%">

                    <?php 
                    $txt_price = $f->input("budget","0","onchange=\"price_calculation();\" type='number'  style='width:150px;' step='any'","form-control");
                    echo $txt_price;
                    ?>
                </td>
            </tr>
            <tr>
                <td width="40%" style="border-bottom:1px dashed #fff;"><b>&nbsp;&nbsp;Total Belanja</b></td>
                <td width="10%" style="border-bottom:1px dashed #fff;"><b>&nbsp;&nbsp;Rp. </b></td>
                <td width="50%" id="total_buy" style="border-bottom:1px dashed #fff;">0</td>
            </tr>
            <tr>
                <td width="40%"><b>&nbsp;&nbsp;Saldo Belanja</b></td>
                <td width="10%"><b>&nbsp;&nbsp;Rp. </b></td>
                <td width="50%" id="total"></td>
            </tr>
        </table>
        <br>
    </div>
<?php
    
}
?>
<div style="height:40px;"></div>