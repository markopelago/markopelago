<?php include_once "head.php"; ?>
<?php include_once "invoices_func.php"; ?>
<?php
    $cart_group = $_GET["cart_group"];
	if($_GET["changeStatus"]  == 3){
		$failedUpdatingTransactions = false;
		$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."' GROUP BY seller_user_id");
		foreach($transactions as $transaction){
			$po_no = generate_po_no();
			updateStatus3($cart_group,$transaction["seller_user_id"],$po_no);
			// if($updating["affected_rows"] <= 0) $failedUpdatingTransactions = true;
		}
		if(!$failedUpdatingTransactions){
			sendMailPaymentVerified($cart_group);
			$_SESSION["message"] = "Status berhasil diubah";
		} else {
			$_SESSION["errormessage"] = "Status gagal diubah";
		}
	}
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
	}
	$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart_group."'")[0];
	$bank_from = $db->fetch_single_data("banks","name",["id" => $transaction_payments["bank_id"]]);
	$bank_from .= " (".$transaction_payments["account_no"].") <br> a/n:".$transaction_payments["account_name"];
	$bank_to = "";
	if($transaction_payments["bank_account_id"] > 0){
		$bank_account = $db->fetch_all_data("bank_accounts",[],"id = '".$transaction_payments["bank_account_id"]."'")[0];
		$bank_to = $db->fetch_single_data("banks","name",["id" => $bank_account["bank_id"]]);
		$bank_to .= " (".$bank_account["account_no"].") <br> a/n:".$bank_account["account_name"];				
	}
	if($transactions[0]["status"] == "2") $status = "<button onclick=\"changeStatus('".$cart_group."',3)\">Payment Verified</button>";
?>
<script>
	function changeStatus(cart_group,status){
		if(status == 3){
			if(confirm("Anda yakin pembayaran sudah terverifikasi?")){
				window.location="?cart_group="+cart_group+"&changeStatus="+status;
			}
		}
	}
</script>
<div class="container">
    <div class="row">
		<?php 
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
				$seller_id = $seller["id"];
				$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
		?>
			<table border="1" width="100%">
				<tr>
					<td colspan="6">
						<b><?=$seller["name"];?></b><br>
						<?=$seller_locations[2]["name"];?>, <?=$seller_locations[1]["name"];?>, <?=$seller_locations[0]["name"];?><br>
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
				?>
				<tr>
					<td colspan="4">
						<div class="col-md-2">
							<img src="../goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
						</div>
						<div class="col-md-10">
							<b><?=$goods["name"]?></b><br>
							<?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp <?=format_amount($transaction_details["price"])?><br>
							Weight per Unit : <?=($goods["weight"]/1000);?> Kg
						</div>
					</td>
					<td colspan="2" align="right">
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
						<?=v("weight");?><br> <?=($transaction_forwarder["weight"]/1000);?> Kg
					</td> 
					<td nowrap width="15%" align="right">
						<?=v(($transaction_forwarder["name"] == "self_pickup")?"administration_fee":"shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
					</td>
				</tr>
				<tr><td colspan="6" align="right"><b> Total : Rp <?=format_amount($subtotal[$seller_id])?></b></td></tr>
				<?php if($transaction["status"] == "7")	
						echo "<tr><td colspan='6' style='width:100%;font-size:20px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-thumbs-up '></span> ".v("transaction_done")."</td></tr>"; 
				?>
			</table>
			<br>
		<?php } ?>
		<?php
			$total_tagihan = 0;
			foreach($subtotal as $seller_id => $total){
				$total_tagihan += $total;
			}
		?>
		<table width="100%">
			<tr>
				<td align="right"><b>Total Bill : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></td>
			</tr>
		</table>
		<h3><b>Payment Info:</b></h3>
		<table>
			<tr><td valign="top"><b>Transaction At</b></td><td valign="top"><b>:</b></td><td><?=format_tanggal($transactions[0]["transaction_at"]);?></td></tr>
			<tr><td valign="top"><b>Transfer At</b></td><td valign="top"><b>:</b></td><td><?=format_tanggal($transaction_payments["transfer_at"]);?></td></tr>
			<tr><td valign="top"><b>Uniq Code</b></td><td valign="top"><b>:</b></td><td align="right"><?=format_amount($transaction_payments["uniqcode"]);?></td></tr>
			<tr><td valign="top"><b>Total Amount</b></td><td valign="top"><b>:</b></td><td align="right"><b><?=format_amount($transaction_payments["total"]);?></b></td></tr>
			<tr><td valign="top"><b>Bank From</b></td><td valign="top"><b>:</b></td><td><?=$bank_from;?></td></tr>
			<tr><td valign="top"><b>Bank To</b></td><td valign="top"><b>:</b></td><td><?=$bank_to;?></td></tr>
			<tr><td colspan="3"><?=$status;?></td></tr>
		</table>
		<br>
		<?php if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "2:<="]) <= 0){ ?>
			<span style="width:100%;color:green;"><h3><b>PAID</b></h3></span>
		<?php } ?>
    </div>
	<?=$f->input("back","Back","type='button' onclick=\"window.history.back();\"");?>
</div>
<?php include_once "footer.php"; ?>