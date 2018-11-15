<?php
	include_once "header.php"; 
	$goods = $db->fetch_all_data("goods",[],"id = '".$_GET["id"]."'")[0];
	$seller = $db->fetch_all_data("sellers",[],"id = '".$goods["seller_id"]."'")[0];
	if($db->fetch_single_data("goods_viewed","id",["goods_id" => $_GET["id"],"user_id" => $__user_id]) <= 0){
		$db->addtable("goods_viewed");
			$db->addfield("goods_id");	$db->addvalue($_GET["id"]);
			$db->addfield("user_id");	$db->addvalue($__user_id);
			$db->insert();
	}
	
	if(isMobile()) $onclickSendMessage = "onclick=\"try{ $('#ul_signin').addClass('show'); }catch(e){} try{ openNav(); }catch(e){}\"";
	else $onclickSendMessage = "onclick=\"try{ $('#ul_signin').addClass('show'); }catch(e){}\"";
	
	$onclickBuy = $onclickSendMessage;
	if($__isloggedin){
		$onclickSendMessage = "onclick=\"newMessage('".$seller["user_id"]."','".$goods["id"]."','buyer','seller');\"";
		$onclickBuy = "onclick=\"window.location='transaction.php?id=".$_GET["id"]."&goods_qty='+goods_qty.value+'&notes_for_seller='+notes_for_seller.value;\"";
	}
	$stock = $db->fetch_single_data("goods_histories","concat(sum(qty))",["goods_id" => $_GET["id"],"in_out" => "in"]);
	$stock -= $db->fetch_single_data("goods_histories","concat(sum(qty))",["goods_id" => $_GET["id"],"in_out" => "out"]);
	if($stock<0) $stock = 0;
	
	$like_number = $db->fetch_single_data("goods_liked","concat(count(*))",["goods_id" => $_GET["id"]]);
	$is_liked = ($db->fetch_single_data("goods_liked","id",["goods_id" => $_GET["id"],"user_id" => $__user_id]) > 0)?"liked":"unliked";
	
	if($__isloggedin){
		$goods_like = "<div id=\"goods_isliked\" class=\"goods_like goods_".$is_liked."\" onclick=\"goods_like('".$_GET["id"]."');\">";
	} else {
		$goods_like = "<div id=\"goods_isliked\" class=\"goods_like goods_".$is_liked."\">";
	}
	$goods_like .= "<div class=\"goods_likes_count\" id=\"goods_likes_count\">".format_amount($like_number)."</div>";
	$goods_like .= "</div> <div class=\"goods_liked_caption\">".v("liked")."</div>";
	$viewed = $db->fetch_single_data("goods_viewed","concat(count(*))",["goods_id" => $_GET["id"]])*1;
	$sent = $db->fetch_single_data("transaction_details","concat(sum(qty))",["goods_id" => $_GET["id"],"transaction_id" => "(SELECT id FROM transactions WHERE DATE(sent_at) <> '0000-00-00'):IN"]) * 1;
	$min_buy = $db->fetch_single_data("goods_prices","concat(min(qty))",["goods_id" => $_GET["id"]]) * 1;
?>
<script>
	function goods_like(goods_id){
		$("#goods_likes_count").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/goods.php?mode=goods_like&goods_id="+goods_id, function(returnval){
			$("#goods_likes_count").html(returnval);
			$.get("ajax/goods.php?mode=goods_isliked&goods_id="+goods_id, function(returnval){
				if(returnval*1 > 0){
					$("#goods_isliked").attr("class", "goods_like goods_liked");
				} else {
					$("#goods_isliked").attr("class", "goods_like goods_unliked");
				}
			});
		});
	}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div style="height:20px;"></div>
            <div class="col-md-5" style="padding:0px;">
				<div id="myCarousel" class="carousel carousel-goods slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<?php 
							$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id = '".$_GET["id"]."'");
							foreach($goods_photos as $key => $goods_photo){
								$addClass = "";
								if($key == 0) $addClass = "class='active'";
								?> <li data-target="#myCarousel" data-slide-to="<?=$key;?>" <?=$addClass;?>></li> <?php 
							}
						?>
					</ol>
					<!-- Wrapper for slides -->
					<div class="carousel-inner carousel-inner-goods">
						<?php
							if(count($goods_photos) > 0){
								foreach($goods_photos as $key => $goods_photo){
									$addClass = "";
									if($key == 0) $addClass = "active";
									if(!file_exists("goods/".$goods_photo["filename"])) $goods_photo["filename"] = "no_goods.png";
									?><div class="item <?=$addClass;?>"> <img src="goods/<?=$goods_photo["filename"];?>" onclick="showGoodsPhoto('<?=$goods_photo["goods_id"];?>','<?=$goods_photo["id"];?>')"> </div><?php
								}
							} else {
								?><div class="item active"> <img src="goods/no_goods.png"> </div><?php
							}
						?>
					</div>
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
					<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
				<div style="height:20px;"></div>
				<?php if(!isMobile()){
					echo "<div style='font-size:1em;font-weight:bolder;'>".v("notes_for_seller")."</div>";
					echo "<div style=\"height:10px;\"></div>";
					echo $f->input("notes_for_seller","","placeholder=\"".v("placeholder_notes_for_seller")."\"","notes_for_seller");
				} ?>
			</div>
			<div style="height:20px;" class="hidden-md hidden-lg"></div>
            <div class="col-md-7">
                <div class="panel panel-default">
					<div class="panel-body">
						<?php if(isMobile()){ echo "<div style='position:absolute;top:70px;right:30px;'>".$goods_like."</div>";} ?>
						<h3 style="margin-top:0px;"><b><?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?></b></h3>
						<h3 style="color:#800000;"><b>Rp. <?=format_amount(get_goods_price($_GET["id"])["display_price"]);?></b></h3>
						<div style="height:10px;"></div>
						<?php
							if($__seller_id != $goods["seller_id"]){
								if($stock <= 0){
									$buy_button = "<button class=\"btn\" style=\"width:200px;\"><span class=\"glyphicon glyphicon-shopping-cart\"></span>&nbsp;".v("buy")." (".v("empty_stock").")</button>";
								}else if(get_goods_price($_GET["id"])["display_price"] <= 0){
									$buy_button = "<button class=\"btn\" style=\"width:200px;\"><span class=\"glyphicon glyphicon-shopping-cart\"></span>&nbsp;".v("buy")."</button>";
								} else {
									$buy_button = "<button ".$onclickBuy." class=\"btn btn-primary btn-blue\" style=\"width:200px;\"><span class=\"glyphicon glyphicon-shopping-cart\"></span>&nbsp;".v("buy")."</button>";
								}
							}
						?>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" width="60%" height="1">
									<table style="height:100%;" cellpadding="0" cellspacing="0">
										<tr><td valign="top">
											<?php
												$color_ids = pipetoarray($goods["color_ids"]);
												if(count($color_ids) > 0){
													echo "<b>".v("color_choice")."</b><br>";
													foreach($color_ids as $color_id){
														$color_code = $db->fetch_single_data("colors","code",["id" => $color_id]);
														echo "<div class='color_choice' style='background-color:#".$color_code."'></div>";
													}
												}
											?>
										</td></tr>
										<?php if(!isMobile()){ ?> <tr><td valign="bottom"><?=$buy_button;?></td></tr> <?php } ?>
									</table>
								</td>
							<?php if(isMobile()){echo "</tr><tr>";}?>
								<td valign="top">
									<?php echo "<b>".v("goods_qty")."</b><br>";?>
									<div class="oval_border">
										<div class="left_caption" onclick="goods_qty.stepDown(1);">-</div>
										<div class="center_text"><?=$f->input("goods_qty","1","type='number' min='1' step='1'");?></div>
										<div class="right_caption" onclick="goods_qty.stepUp(1);">+</div>
									</div>
									<?php if(isMobile()){
										echo "<br><div style='font-size:1em;font-weight:bolder;'>".v("notes_for_seller")."</div>";
										echo $f->input("notes_for_seller","","placeholder=\"".v("placeholder_notes_for_seller")."\"","notes_for_seller");
									} ?>
									<?php if(!isMobile()){ echo $goods_like;} ?>
								</td>
							</tr>
							<?php if(isMobile()){ ?>
								<tr><td><br><?=$buy_button;?></td> </tr>
							<?php } ?>
						</table>
						<div style="height:10px;"></div>
						<table style="position:relative;left:-16px;width:calc(100% + 32px);" class="table-categories all-categories">
							<tr>
								<td width="25%" nowrap><?=v("weight")?><br><b><?=$goods["weight"];?> gr</b></td>
								<td width="25%" nowrap><?=v("dimension")?><br><b><?=$goods["dimension"];?></b></td>
								<?php if(isMobile()){echo "</tr><tr>";}?> 
								<td width="25%" nowrap><?=v("condition")?><br><b><?=($goods["is_new"] != 1) ? v("second") : v("new");?></b></td>
								<td width="25%" nowrap><?=v("stock")?><br><b><?=$stock;?></b></td>
							</tr>
						</table>
						<br>
						<table width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td rowspan="2" valign="middle" width="50"><img src="assets/viewed.png" width="40"></td>
								<td><?=v("viewed");?></td>
								<td rowspan="2" nowrap>&nbsp;&nbsp;&nbsp;</td>
								<td rowspan="2" valign="middle" width="50"><img src="assets/sent.png" width="40"></td>
								<td><?=v("sent");?></td>
								<td rowspan="2" valign="middle" width="50"><img src="assets/minimum_buy.png" width="40"></td>
								<td><?=v("min_buy");?></td>
							</tr>
							<tr>
								<td><b><?=$viewed;?></b></td>
								<td><b><?=$sent;?></b></td>
								<td><b><?=$min_buy;?></b></td>
							</tr>
						</table>
					</div>
                </div>
            </div>
        </div>
        <div style="height:20px;"></div>
        <div class="col-md-3">
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><center><b><a href="seller_detail.php?id=<?=$seller["id"];?>"><?=v("seller_profile");?></a></b></center></h3>
				</div>
				<div class="panel-body">
					<center>
						<?php $seller["logo"] = ($seller["logo"] == "")?"nologo.jpg":$seller["logo"]; ?>
						<div class="img-thumbnail seller-thumbnail" style="height:160px;">
							<img class="img-circle" src="users_images/<?=$seller["logo"];?>" alt="#">
							<img class="seller_body_profile" src="assets/seller_body_profile_<?=rand(1,4);?>.png">
							
							<?php $seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => 1])); ?>
							<div style="position:relative;top:-50px;">
								<b><a href="seller_detail.php?id=<?=$seller["id"];?>"><?=$seller["name"];?></a></b><br>
								<span class="glyphicon glyphicon-map-marker"></span> <?=$seller_locations[3]["name"];?>, <?=$seller_locations[2]["name"];?>
							</div>
						</div>
						<br><br>
						<?php if($__seller_id != $goods["seller_id"]){ ?>
						<button class="btn btn-primary btn-blue" <?=$onclickSendMessage;?>><span class="glyphicon glyphicon-envelope"></span>&nbsp;<?=v("send_message_to_seller");?></button>
						<?php } ?>
					</center>
				</div>
            </div>
        </div>
    </div><br><br>
	
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><b><?=v("product_description");?></b></h3>
			</div>
			<div class="panel-body">
				<p><?=str_replace(chr(13).chr(10),"<br>",$db->fetch_single_data("goods","description",["id"=>$_GET["id"]]));?></p>
			</div>
		</div>
	</div>
	<?php
		$products = $db->fetch_all_data("goods",[],"seller_id = '".$seller["id"]."' AND id <> '".$_GET["id"]."'");
		if(count($products) > 0){
	?>
		<div style="height:20px;"></div>
		<div class="row sub-title-area">
			<div class="sub-title-text"><?=v("other_goods_from_seller");?></div>
		</div>
		<div class="row">		
			<?php
				$products = $db->fetch_all_data("goods",[],"seller_id = '".$seller["id"]."' AND id <> '".$_GET["id"]."'");
				foreach($products as $product){
					$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
					if($img == "") $img = "no_goods.png";
					$seller_user_id = $db->fetch_single_data("sellers","user_id",["id"=> $product["seller_id"]]);
					$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
			?>
				<div class="img-thumbnail goods-thumbnail goods-thumbnail2">
					<a href="product_detail.php?id=<?=$product["id"];?>">
						<img src="goods/<?=$img;?>" alt="#">
						<div class="caption"><p><?=substr($product["name"],0,50);?></p></div>
						<div class="price"><p>Rp. <?=format_amount(get_goods_price($product["id"])["display_price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
						<button class="btn btn-primary btn-sm" style="width:100%"><?=v("buy");?></button>
						<div class="seller-info">
							<?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?><br>
							<span class="glyphicon glyphicon-map-marker"></span> <?=get_location($seller_location_id)[0]["name"];?>
						</div>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
</div>
<div style="height:20px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>