<?php include_once "header.php"; ?>
<?php
    $cart_group = $_GET["cart_group"];
    $invoice_no = $_GET["invoice_no"];
	if($cart_group) $transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
	if($invoice_no) $transactions = $db->fetch_all_data("transactions",[],"invoice_no = '".$invoice_no."'");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
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
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
	}
?>
<script>
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
		<?php 
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
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
						$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];
						
						$total = $transaction_details["total"] + $transaction_forwarder["total"];
						$total_tagihan += $total;
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
							<?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp <?=format_amount($transaction_details["price"])?><br>
						</div>
					</td>
					<td colspan="2" align="right" nowrap>
						Sub Total<br>
						Rp. <?=format_amount($transaction_details["total"])?>
					</td>   
				</tr>
				<tr>
					<td colspan="5">
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
					<td colspan="3" width="70%"> 
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
								if($transaction["status"] >= 5 && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
									echo "<br><b>".v("delivered_at").": ".format_tanggal($transaction_forwarder["receipt_at"]);
									echo "<br>".v("shipping_receipt_number").": ".$transaction_forwarder["receipt_no"]."</b>";
								}
							}
						?>
					</td>
					<td nowrap width="15%" align="right">
						<?=v("weight");?><br> <?=($transaction_forwarder["weight"]*$transaction_forwarder["qty"]/1000);?> Kg
					</td> 
					<td nowrap width="15%" align="right">
						<?=v(($transaction_forwarder["name"] == "self_pickup")?"administration_fee":"shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
					</td>
				</tr>
				<tr><td colspan="6" align="right"><b> Total : Rp <?=format_amount($total)?></b></td></tr>
				<?php 
					if($transaction["status"] == "7")	
						echo "<tr><td colspan='6' style='width:100%;font-size:20px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-thumbs-up '></span> ".v("transaction_done")."</td></tr>";
				?>
				<tr><td colspan="6"></td></tr>
				<?php } ?>
			</table>
		<?php } ?>
		<table width="100%">
			<tr>
				<td align="right"><h4><b><?=v("total_shopping");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></h4></td>
			</tr>
		</table>
		<?php 
			if($cart_group != ""){
				if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "2:<="]) > 0){
					echo $f->input("pay",v("pay"),"style=\"position:relative;float:right;\" onclick='window.location=\"payment.php?cart_group=".$cart_group."\";'","btn btn-success");
				} else {
					echo "<div style='width:100%;font-size:20px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-ok '> ".v("paid")."</span></div>";
				}
			} else {
				if($transaction["status"] < 7){
					echo "<a onclick=\"transactionDone();\" href='#' style='position:relative;float:right;' class='btn btn-primary'><span class='glyphicon glyphicon-ok'></span> ".v("transaction_done")."</a>";					
				}
			}
		?>
		<a href="dashboard.php?tabActive=purchase_list" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></a>
    </div>
</div>
<div style="height:40px;"></div>


<?php include_once "footer.php"; ?>