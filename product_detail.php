<?php 
	include_once "header.php"; 
	$goods = $db->fetch_all_data("goods",[],"id = '".$_GET["id"]."'")[0];
	$seller = $db->fetch_all_data("sellers",[],"id = '".$goods["seller_id"]."'")[0];
	$onclickSendMessage = "onclick=\"try{ $('#ul_signin').addClass('show'); }catch(e){} try{ openNav(); }catch(e){}\"";
	$onclickBuy = $onclickSendMessage;
	if($__isloggedin){
		$onclickSendMessage = "onclick=\"newMessage('".$seller["user_id"]."','".$goods["id"]."','buyer','seller');\"";
		$onclickBuy = "onclick=\"window.location='transaction.php?id=".$_GET["id"]."';\"";
	}
	$stock = $db->fetch_single_data("goods_histories","concat(sum(qty))",["goods_id" => $_GET["id"],"in_out" => "in"]);
	$stock -= $db->fetch_single_data("goods_histories","concat(sum(qty))",["goods_id" => $_GET["id"],"in_out" => "out"]);
	if($stock<0) $stock = 0;
?>


<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div style="height:20px;"></div>
            <div class="col-md-5">
				<center>
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
									foreach($goods_photos as $goods_photo){
										$addClass = "";
										if($goods_photo["seqno"] == "1") $addClass = "active";
										?><div class="item <?=$addClass;?>"> <img src="goods/<?=$goods_photo["filename"];?>"> </div><?php
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
				</center>
			</div>
			<div style="height:20px;" class="hidden-md hidden-lg"></div>
            <div class="col-md-7">
                <div class="panel panel-default">
					<div class="panel-body">
						<h3 style="margin-top:0px;"></b><?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?></b></h3>
						<h3 style="color:#800000;"><b>Rp. <?=format_amount($db->fetch_single_data("goods","price",["id"=>$_GET["id"]]));?></b></h3>
						<div style="height:10px;"></div>
						<?php if($__seller_id != $goods["seller_id"]){ ?>
							<?php if($stock > 0){ ?>
								<button <?=$onclickBuy;?> class="btn btn-primary btn-red" style="width:200px;"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<?=v("buy");?></button>
							<?php } else { ?>
								<button class="btn" style="width:200px;"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<?=v("buy");?> (<?=v("empty_stock");?>)</button>
							<?php } ?>
						<?php } ?>
						<div style="height:10px;"></div>
						<table style="position:relative;left:-16px;width:calc(100% + 32px);" class="table-categories all-categories">
							<tr>
								<td width="25%" nowrap><?=v("weight")?><br><b><?=$goods["weight"];?> gr</b></td>
								<td width="25%" nowrap><?=v("dimension")?><br><b><?=$goods["dimension"];?></b></td>
								<td width="25%" nowrap><?=v("condition")?><br><b><?=($goods["is_new"] != 1) ? v("second") : v("new");?></b></td>
								<td width="25%" nowrap><?=v("stock")?><br><b><?=$stock;?></b></td>
							</tr>
						</table>
					</div>
                </div>
                <div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><b><?=v("product_description");?></b></h3>
					</div>
					<div class="panel-body">
                        <p><?=str_replace(chr(13).chr(10),"<br>",$db->fetch_single_data("goods","description",["id"=>$_GET["id"]]));?></p>
					</div>
                </div>
            </div>
        </div>
        <div style="height:20px;"></div>
        <div class="col-md-3">
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><center><b><a href="seller_detail.php?id=<?=$seller["id"];?>"><?=v("about_seller");?></a></b></center></h3>
				</div>
				<div class="panel-body">
					<center>
						<?php $seller["logo"] = ($seller["logo"] == "")?"nologo.jpg":$seller["logo"]; ?>
						<img class="img-responsive" src="users_images/<?=$seller["logo"];?>"><br>
						<b><a href="seller_detail.php?id=<?=$seller["id"];?>"><?=$seller["name"];?></a></b><br>
 						<?php $seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => 1])); ?>
						<span class="glyphicon glyphicon-map-marker"></span> <?=$seller_locations[3]["name"];?>, <?=$seller_locations[2]["name"];?>
						<br><br>
						<?php if($__seller_id != $goods["seller_id"]){ ?>
						<button class="btn btn-primary btn-red" <?=$onclickSendMessage;?>><span class="glyphicon glyphicon-envelope"></span>&nbsp;<?=v("send_message_to_seller");?></button>
						<?php } ?>
					</center>
				</div>
            </div>
        </div>
    </div>
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
					<div class="price"><p>Rp. <?=format_amount($product["price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
					<button class="btn btn-primary btn-sm" style="width:100%"><?=v("buy");?></button>
					<div class="seller-info">
						<?=$db->fetch_single_data("sellers","name",["id"=>$product["seller_id"]]);?><br>
						<span class="glyphicon glyphicon-map-marker"></span> <?=get_location($seller_location_id)[0]["name"];?>
					</div>
				</a>
			</div>
		<?php } ?>
    </div>
</div>
<div style="height:20px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>