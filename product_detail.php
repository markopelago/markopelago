<?php 
	include_once "header.php"; 
	$goods = $db->fetch_all_data("goods",[],"id = '".$_GET["id"]."'")[0];
	$seller = $db->fetch_all_data("sellers",[],"id = '".$goods["seller_id"]."'")[0];
	$onclickSendMessage = "onclick=\"$('#ul_signin').addClass('show');\"";
	$onclickBuy = "onclick=\"$('#ul_signin').addClass('show');\"";
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
<a class="btn" href="index.php"><h3><span class="glyphicon glyphicon-chevron-left"><b>BACK</b></span></h3></a>
	<div style="height:20px;"></div>
	<div class="row sub-title-area">
		<div class="sub-title-text"> <?=$db->fetch_single_data("goods","name",["id"=>$_GET["id"]]);?> </div>
	</div>
	</div>
    <div class="row">
        <div class="col-md-9" style="border-top: 1px solid #ccc;">
            <div style="height:20px;"></div>
            <div class="col-md-5">
				<div class="panel panel-default">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
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
						<div class="carousel-inner" style="height: auto !important ">
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
				</div>
			</div>
            <div class="col-md-7">
                <div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><b><?=v("product_information");?></b></h3>
					</div>
					<div class="panel-body">
						<table class="table table-striped">
							<tr>
								<td><?=v("weight")?></td>
								<td><?=$goods["weight"];?> gr</td>
							</tr>
							<tr>
								<td><?=v("dimension")?><br><?=v("l_w_h2");?></td>
								<td><?=$goods["dimension"];?></td>
							</tr>
							<tr>
								<td><?=v("condition")?></td>
								<td><?=($goods["is_new"] != 1) ? v("second") : v("new");?></td>
							</tr>
							<tr>
								<td><?=v("stock")?></td>
								<td><?=$stock;?></td>
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
					<h3 class="panel-title"><center><b><?=v("about_seller");?></b></center></h3>
				</div>
				<div class="panel-body">
					<center>
						<?php $seller["logo"] = ($seller["logo"] == "")?"nologo.jpg":$seller["logo"]; ?>
						<img class="img-responsive" src="users_images/<?=$seller["logo"];?>"><br>
						<b><?=$seller["name"];?></b><br><br>
						<?php if($__seller_id != $goods["seller_id"]){ ?>
						<button class="btn btn-primary" <?=$onclickSendMessage;?>><span class="glyphicon glyphicon-envelope"></span>&nbsp;<?=v("send_message_to_seller");?></button>
						<?php } ?>
					</center>
				</div>
            </div>
            <div style="height:2px;"></div>
				
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><center><b><?=v("price");?></b></center></h3>
				</div>
				<div class="panel-body">
					<h3><b><center>Rp. <?=format_amount($db->fetch_single_data("goods","price",["id"=>$_GET["id"]]));?></center></b></h3>
				</div>
            </div>
            <div style="height:2px;"></div>
			<?php if($__seller_id != $goods["seller_id"]){ ?>
				<?php if($stock > 0){ ?>
					<button <?=$onclickBuy;?> class="btn btn-primary btn-lg" style="width:100%"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<?=v("buy");?></button>
				<?php } else { ?>
					<button class="btn btn-lg" style="width:100%"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;<?=v("buy");?> (<?=v("empty_stock");?>)</button>
				<?php } ?>
			<?php } ?>
        </div>
    </div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>