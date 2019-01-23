<?php include_once "header.php"; ?>
<?php
    $transaction_forwarder_id = $_GET["deliver_id"];
	$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"id = '".$transaction_forwarder_id."' AND forwarder_user_id = '".$__user_id."'");
	if(count($transaction_forwarders) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	$transaction_id = $transaction_forwarders[0]["transaction_id"];
	$cart_group = $db->fetch_single_data("transactions","cart_group",["id" => $transaction_id]);
	if(!$cart_group) $cart_group = $transaction_forwarders[0]["cart_group"];
	$transaction_ids = "";
	$transactions = $db->fetch_all_data("transactions",["id"],"cart_group = '".$cart_group."'");
	foreach($transactions as $transaction){
		if($db->fetch_single_data("transaction_forwarder","id",["transaction_id" => $transaction["id"],"forwarder_user_id" => $__user_id]) > 0) $transaction_ids .= $transaction["id"].","; 
	}
	$transaction_ids = substr($transaction_ids,0,-1);
	if(!$transaction_ids) $transaction_ids = $transaction_forwarders[0]["transaction_ids"];
	
	
	$transaction_forwarder = $transaction_forwarders[0];
	$transactions = $db->fetch_all_data("transactions",[],"id IN (".$transaction_ids.")");
	if($_GET["changeStatus"] > 1 && $_GET["changeStatus"] <= 7){
		$receipt_no = generate_markoantar_receipt_no();
		$db->addtable("transaction_forwarder");	
		$db->where("id",$transaction_forwarder_id);
		$db->where("cart_group",$cart_group);
		$db->where("forwarder_user_id",$__user_id);
		$db->addfield("markoantar_status");								$db->addvalue($_GET["changeStatus"]);
		$db->addfield("markoantar_status".$_GET["changeStatus"]."_at");	$db->addvalue($__now);
		if($_GET["changeStatus"] == 3){
			$db->addfield("receipt_no");								$db->addvalue($receipt_no);			
			$db->addfield("receipt_at");								$db->addvalue($__now);			
		}
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			if($_GET["changeStatus"] == 2){
				$db->addtable("forwarder_vehicles");
				$db->where("id",$transaction_forwarder["courier_service"]);
				$db->where("user_id",$__user_id);
				$db->addfield("is_available");		$db->addvalue(0);			
				$db->update();
			}
			if($_GET["changeStatus"] == 3){
				$db->addtable("transactions");
				$db->where("id",$transaction_id);
				$db->addfield("sent_at");			$db->addvalue($__now);			
				$db->update();
			}
			if($_GET["changeStatus"] == 4){
				$db->addtable("transactions");
				$db->where("id",$transaction_id);
				$db->addfield("status");			$db->addvalue(6);			
				$db->addfield("delivered_at");		$db->addvalue($__now);			
				$db->update();
			}
			if($_GET["changeStatus"] == 6){
				$db->addtable("forwarder_vehicles");
				$db->where("id",$transaction_forwarder["courier_service"]);
				$db->where("user_id",$__user_id);
				$db->addfield("is_available");		$db->addvalue(1);			
				$db->update();
			}
			javascript("window.location='?deliver_id=".$transaction_forwarder_id."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
?>
<script>
	function changeStatus(status,markoantar_status){
		if(confirm(markoantar_status+" ?")){
			window.location = "?deliver_id=<?=$transaction_forwarder_id;?>&changeStatus="+status;
		}
	}
</script>

<div class="container">
    <div class="row">
		<div class="common_title"><img src="assets/sent.png" height="25"> &nbsp;<?=v("delivery_of_goods");?></div>
	</div>
</div>
<div class="container">
    <div class="row">
		<table class="table table-bordered" width="100%">
			<?php 
				$total_weight = 0;
				foreach($transactions as $key => $transaction){
					$total_weight += $transaction_forwarder["weight"]*$transaction_forwarder["qty"]/1000;
					$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
					$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
					$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
					if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
					$units  = $db->fetch_all_data("units",[],"id = '".$transaction_details["unit_id"]."'")[0];
					$status = $db->fetch_single_data("transactions","status",["id" => $transaction["id"]]);
			?>
			<tr>
				<td colspan="4">
					<div class="col-md-2">
						<img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
					</div>
					<div class="col-md-10">
						<b><?=$goods["name"]?></b><br>
						<?=$transaction_details["qty"]?> x Rp <?=format_amount($transaction_details["price"])?><br>
						<?=v("weight_per_unit");?> : <?=($goods["weight"]/1000);?> Kg<br>
					</div>
				</td>
			</tr>
			<?php } ?>
		</table>
		<hr>
		
		
		<table class="table table-bordered" width="100%">
			<?php 
				$transaction = $transactions[0];
				$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
				$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
				$status = $db->fetch_single_data("transactions","status",["id" => $transaction["id"]]);
				$seller_name = $db->fetch_single_data("sellers","name",["user_id" => $transaction["seller_user_id"]]);
				$seller_pic = $db->fetch_single_data("sellers","pic",["user_id" => $transaction["seller_user_id"]]);
				$seller_phone = $db->fetch_single_data("a_users","phone",["id" => $transaction["seller_user_id"]]);
			?>
			<tr>
				<td colspan="4">
					<u><?=v("pickup_location");?> :</u><br><br>
					<b><?=$seller_name." (".$seller_pic.")";?></b><br>
					<?php
						$locations = get_location($transaction_forwarder["pickup_location_id"]);
						echo $locations[3]["name"].", ".$locations[2]["name"]."<br>";
						echo $locations[1]["name"].", ".$locations[0]["name"],", ".$locations[3]["zipcode"]."<br>";
						
						$onclickSendMessage = "onclick=\"newMessage('".$transaction["seller_user_id"]."',".$goods["id"].",'markoantar','seller');\"";
						$btn_chat = "<div><button class='btn btn-primary btn-blue' ".$onclickSendMessage."><span class='glyphicon glyphicon-envelope'></span>&nbsp;".v("send_message_to_seller")."</button></div>";
					?>
					<?=$seller_phone;?>
					<?=$btn_chat;?>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<u><?=v("delivery_destination");?> :</u><br><br>
					<b><?=$transaction_forwarder["user_address_pic"];?></b> <br>
					<?=$transaction_forwarder["user_address"];?> <br>
					<?php
						$locations = get_location($transaction_forwarder["user_address_location_id"]);
						echo $locations[3]["name"].", ".$locations[2]["name"]."<br>";
						echo $locations[1]["name"].", ".$locations[0]["name"],", ".$locations[3]["zipcode"]."<br>";
						
						$onclickSendMessage = "onclick=\"newMessage('".$transaction["buyer_user_id"]."',".$goods["id"].",'markoantar','buyer');\"";
						$btn_chat = "<div><button class='btn btn-primary btn-blue' ".$onclickSendMessage."><span class='glyphicon glyphicon-envelope'></span>&nbsp;".v("send_message_to_buyer")."</button></div>";
					?>
					<?=$transaction_forwarder["user_address_phone"];?>
					<?=$btn_chat;?>
				</td>
			</tr>
			<tr>
				<td colspan="2" width="70%"> 
					<?php
						$vehicle_id = $db->fetch_single_data("forwarder_routes","vehicle_id",["user_id" => $transaction_forwarder["forwarder_user_id"],"id" => $transaction_forwarder["courier_service"]]);
						$forwarder_vehicle = $db->fetch_all_data("forwarder_vehicles",[],"user_id = '".$transaction_forwarder["forwarder_user_id"]."' AND id = '".$vehicle_id."'")[0];
						$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $forwarder_vehicle["vehicle_type_id"]]);
						$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $forwarder_vehicle["vehicle_brand_id"]]);
						$transaction_forwarder["courier_service"] = $vehicle_type." ".$vehicle_brand;
						if($status == "4") $wait_for_pickup = "<div class='alert alert-warning'>".v("wait_for_pickup")."</div>";
					?>
					<u><?=v("courier_service");?> :</u><br> <?=($transaction_forwarder["forwarder_user_id"] > 0)?"Marko Antar ":"";?><?=$transaction_forwarder["name"];?> -- <?=explode(" (",$transaction_forwarder["courier_service"])[0];?>
					<?php
						if($status >= "5" && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
							echo "<br><b>".v("delivered_at").": ".format_tanggal($transaction_forwarder["receipt_at"]);
							echo "<br>".v("shipping_receipt_number").": ".$transaction_forwarder["receipt_no"]."</b>";
						}
					?>
				</td>
				<td nowrap width="15%">
					<?=v("weight");?><br><b><?=$transaction_forwarder["weight"]/1000;?> Kg</b>
					<br><br>
					<?=v("shipping_charges");?><br><b>Rp <?=format_amount($transaction_forwarder["total"])?></b>
				</td> 
			</tr>
		</table>
		<?php 
			if($transaction_forwarder["markoantar_status"] > 0 && $transaction_forwarder["markoantar_status"] < 6)
				echo "<div class='alert alert-warning'>".markoantar_status($transaction_forwarder["markoantar_status"])."</div>";
			if($transaction_forwarder["markoantar_status"] >= 1 && $transaction_forwarder["markoantar_status"] < 6) 
				echo $f->input("update_status",markoantar_status($transaction_forwarder["markoantar_status"]+1),"style=\"width:100%;\" onclick=\"changeStatus(".($transaction_forwarder["markoantar_status"]+1).",'".markoantar_status($transaction_forwarder["markoantar_status"]+1)."');\"","btn btn-success");
			if($transaction_forwarder["markoantar_status"] == 6) 
				echo "<div class='alert alert-success'>".v("transaction_done")."</div>";
		?>
    </div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>