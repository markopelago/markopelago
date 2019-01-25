<?php include_once "header.php"; ?>
<?php include_once "func.review.php"; ?>
<?php
    $cart_group = $_GET["cart_group"];
    $invoice_no = $_GET["invoice_no"];
	if($cart_group) $transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
	if($invoice_no) $transactions = $db->fetch_all_data("transactions",[],"invoice_no = '".$invoice_no."'");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	if(!$cart_group) $cart_group = $db->fetch_single_data("transactions","cart_group",["id" => $transactions[0]["id"]]);
	if($_GET["goods_received"] == "1"){
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $_GET["seller_id"]]);
		$db->addtable("transactions");	
		$db->where("invoice_no",$_GET["invoice_no"]);
		$db->where("buyer_user_id",$__user_id);
		$db->where("seller_user_id",$seller_user_id);
		$db->addfield("status");		$db->addvalue("6");
		$db->addfield("delivered_at");	$db->addvalue($__now);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = v("goods_received");
			javascript("window.location='?invoice_no=".$_GET["invoice_no"]."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
	if($_GET["transaction_done"] == "1"){
		$db->addtable("transactions");	
		$db->where("invoice_no",$_GET["invoice_no"]);
		$db->where("buyer_user_id",$__user_id);
		$db->addfield("status");	$db->addvalue("7");
		$db->addfield("done_at");	$db->addvalue($__now);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = v("transaction_done");
			javascript("window.location='?invoice_no=".$_GET["invoice_no"]."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
	$need_review_ids = "";
	$has_review_ids = "";
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
		if($db->fetch_single_data("transaction_details","is_reviewed",["transaction_id" => $transaction["id"]]) == 0 && $transaction["status"] == 7) $need_review_ids .= $transaction["id"].",";
		if($db->fetch_single_data("transaction_details","is_reviewed",["transaction_id" => $transaction["id"]]) == 1) $has_review_ids .= $transaction["id"].","; 
	}
	$need_review_ids = substr($need_review_ids,0,-1);
	$has_review_ids = substr($has_review_ids,0,-1);
	
?>
<script>
	function goods_received(seller_id){
		if(confirm("<?=v("are_you_sure_goods_received");?> ?")){
			window.location = "?invoice_no=<?=$_GET["invoice_no"];?>&goods_received=1&seller_id="+seller_id;
		}
	}
	function transactionDone(){
		if(confirm("<?=v("are_you_sure_transaction_done");?> ?")){
			window.location = "?invoice_no=<?=$_GET["invoice_no"];?>&transaction_done=1";
		}
	}
</script>

<div class="container">
    <div class="row">
		<div class="common_title"><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;Invoice</div>
	</div>
</div>
<div class="container">
    <div class="row">
		<?php if($has_review_ids != ""){ ?>
			<button class="btn btn-info" onclick="showReview('<?=$has_review_ids;?>');"><img src="assets/review.png" height="18"> <?=v("review");?></button>
			<br><br>
		<?php } ?>
		<?php
			if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "4:<"]) == 0 && $db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "6:>"]) == 0){
				echo "<a onclick=\"transactionDone();\" href='#' style='position:relative;float:right;' class='btn btn-primary'><span class='glyphicon glyphicon-ok'></span> ".v("transaction_done")."</a><br><br>";
			}
		?>
		<?php 
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
				$seller_id = $seller["id"];
				$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
		?>
			<table class="table table-bordered" width="100%">
				<tr>
					<td colspan="4">
						<b><?=$seller["name"];?></b><br>
						<span class="glyphicon glyphicon-map-marker"></span> <?=$seller_locations[2]["name"];?>, <?=$seller_locations[1]["name"];?>, <?=$seller_locations[0]["name"];?><br>
						<?php
							$onclickSendMessage = "onclick=\"newMessage('".$seller["user_id"]."',0,'buyer','seller');\"";
							echo "<div><button class='btn btn-primary btn-blue' ".$onclickSendMessage."><span class='glyphicon glyphicon-envelope'></span>&nbsp;".v("send_message_to_seller")."</button></div>";
						?>
					</td>
					<td colspan="2">
						<button class="btn btn-info" onclick="loadShopping_progress('<?=$transactions[0]["id"];?>');"><span class="glyphicon glyphicon glyphicon-th-list"></span> <?=v("show_shopping_progress");?></button>
					</td>
				</tr> 
				<?php 
					foreach($transactions as $transaction){
						$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
						$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
						$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
						$units  = $db->fetch_all_data("units",[],"id = '".$transaction_details["unit_id"]."'")[0];
						
						$total = $transaction_details["total"];
						$subtotal[$seller_id] += $total;
						$goods_photos["filename"] = ($goods_photos["filename"] == "")?"no_goods.png":$goods_photos["filename"];
						if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
				?>
				<tr>
					<td colspan="4">
						<div class="col-md-2">
							<img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
						</div>
						<div class="col-md-10">
							<b><?=$goods["name"]?></b><br>
							<span class="glyphicon glyphicon-scale"></span> <?=($goods["weight"]/1000);?> Kg<br>
							<?=$transaction_details["qty"]?> x Rp <?=format_amount($transaction_details["price"])?><br>
						</div>
					</td>
					<td colspan="2" align="right" nowrap>
						Sub Total<br>
						Rp. <?=format_amount($transaction_details["total"])?>
					</td>   
				</tr>
				<?php 
					}
					$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"cart_group = '".$cart_group."' AND seller_id='".$seller_id."'")[0];
					$subtotal[$seller_id] += $transaction_forwarder["total"];
				?>
				<tr>
					<td colspan="6">
						<u><?=v("delivery_destination");?> :</u><br>
						<b><?=$transaction_forwarder["user_address_pic"];?></b> <br>
						<?=$transaction_forwarder["user_address"];?> <br>
						<?php
							$locations = get_location($transaction_forwarder["user_address_location_id"]);
							echo $locations[3]["name"].", ".$locations[2]["name"]."<br>";
							echo $locations[1]["name"].", ".$locations[0]["name"],", ".$locations[3]["zipcode"]."<br>";
						?>
						<?=$transaction_forwarder["user_address_phone"];?>                                    
					</td>
				</tr>
				<tr>
					<td colspan="5" width="70%"> 
						<?php
							if($transaction_forwarder["forwarder_user_id"] > 0){
								$vehicle_id = $db->fetch_single_data("forwarder_routes","vehicle_id",["user_id" => $transaction_forwarder["forwarder_user_id"],"id" => $transaction_forwarder["courier_service"]]);
								$forwarder_vehicle = $db->fetch_all_data("forwarder_vehicles",[],"user_id = '".$transaction_forwarder["forwarder_user_id"]."' AND id = '".$vehicle_id."'")[0];
								$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $forwarder_vehicle["vehicle_type_id"]]);
								$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $forwarder_vehicle["vehicle_brand_id"]]);
								$transaction_forwarder["courier_service"] = $vehicle_type." ".$vehicle_brand;
							}
							$courier_service = $transaction_forwarder["name"]." -- ".explode(" (",$transaction_forwarder["courier_service"])[0];
							if($transaction_forwarder["name"] == "self_pickup"){
								$courier_service = v("self_pickup");
							}
						?>
						<u><?=v("courier_service");?> :</u><br> <?=($transaction_forwarder["forwarder_user_id"] > 0)?"Marko Antar ":"";?><?=$courier_service;?>
						<?php 
							if($transaction_forwarder["name"] == "self_pickup"){
								if($transaction_forwarder["pickup_address_id"] > 0){
									$user_address = $db->fetch_all_data("user_addresses",[],"id = '".$transaction_forwarder["pickup_address_id"]."' AND user_id = '".$transaction["seller_user_id"]."'")[0];
									$locations = get_location($user_address["location_id"]);
									
									echo "<br><br><u>".v("goods_pickup_address")."</u><br>";
									echo "<b>".$user_address["pic"]."</b><br>";
									echo $user_address["address"]."<br>";
									echo $locations[3]["name"].", ".$locations[2]["name"]."<br>";
									echo $locations[1]["name"].", ".$locations[0]["name"].", ".$locations[3]["zipcode"]."<br>";
									echo $user_address["phone"];
								}
								
								if($transaction["status"] >= 3 && $transaction_forwarder["markoantar_status"] == 0) echo "<div class='alert alert-warning'>".v("goods_not_ready_for_pickup")."</div>";
								if($transaction_forwarder["markoantar_status"] == 1) echo "<div class='alert alert-success'>".markoantar_status(1)."</div>";
								if($transaction_forwarder["receipt_no"] != "") echo "<div><b>".v("receipt_number").": ".$transaction_forwarder["receipt_no"]."</b></div>";
							} else {
								$receipt_no = $transaction_forwarder["receipt_no"];
								if($transaction["status"] >= 5 && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
									echo "<br><b>".v("delivered_at")." : </b>".format_tanggal($transaction_forwarder["receipt_at"]);
									echo "<br><b>".v("shipping_receipt_number")." : </b>".$receipt_no;
								}
								if($transaction["status"] == 5 && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
									echo "<br>".$f->input("goods_received",v("goods_received"),"type='button' onclick=\"goods_received('".$seller_id."');\"","btn btn-success");
								}
							}
							if($transaction["status"] > 5) echo "<div class='alert alert-success'><span class='glyphicon glyphicon-thumbs-up '></span> ".v("goods_received")."</div>";
						?>
					</td>
					<td nowrap width="30%" align="right">
						<?=v("weight");?><br> <?=($transaction_forwarder["weight"]/1000);?> Kg<br><br>
						<?=v(($transaction_forwarder["name"] == "self_pickup")?"administration_fee":"shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
					</td>
				</tr>
				<tr><td colspan="6" align="right"><b> Total : Rp <?=format_amount($subtotal[$seller_id])?></b></td></tr>
			</table>
		<?php 
			}
			$total_tagihan = 0; foreach($subtotal as $seller_id => $total){ $total_tagihan += $total; }
			?> <table width="100%"><tr><td align="right"><h4><b><?=v("total_shopping");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></h4></td></tr></table> <?php 
			if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "2:<="]) > 0){
				echo $f->input("pay",v("pay"),"style=\"position:relative;float:right;\" onclick='window.location=\"payment.php?cart_group=".$cart_group."\";'","btn btn-success");
			}
			if($transaction["status"] == "7")	
				echo "<div class='alert alert-success'><span class='glyphicon glyphicon-thumbs-up '></span> ".v("transaction_done")."</div>"; 
		?>
		<a href="dashboard.php?tabActive=purchase_list" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></a>
		
		<?php
			if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "4:<"]) == 0 && $db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "6:>"]) == 0){
				echo "<a onclick=\"transactionDone();\" href='#' style='position:relative;float:right;' class='btn btn-primary'><span class='glyphicon glyphicon-ok'></span> ".v("transaction_done")."</a><br><br>";
			}
		?>
    </div>
</div>
<div style="height:40px;"></div>
<?php if($need_review_ids != ""){ ?><script> loadReview("<?=$need_review_ids;?>"); </script><?php } ?>

<?php include_once "footer.php"; ?>