<?php include_once "head.php"; ?>
<?php
    $po_no = $_GET["po_no"];
	if($_GET["seller_paid"] == "1"){
		$db->addtable("transactions");  
		$db->where("po_no",$po_no);
		$db->addfield("seller_paid");	$db->addvalue(1);
		$db->addfield("seller_paid_at");$db->addvalue($__now);
		$db->addfield("seller_paid_by");$db->addvalue($__username);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = "Status berhasil diubah";
			?><script> window.location='po_list.php'; </script><?php
			exit();
		} else {
			$_SESSION["errormessage"] = "Status gagal diubah";
		}
	}
	$transactions = $db->fetch_all_data("transactions",[],"po_no = '".$po_no."'");
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
	}
?>

<script>
	function seller_paid(po_no){
		if(confirm("Anda yakin sudah membayar ke seller yang bersangkutan?")){
			window.location="?po_no="+po_no+"&seller_paid=1";
		}
	}
</script>
<div class="container">
    <div class="row">
	<h3><b>PURCHASE ORDER</b></h3>
	</div>
    <div class="row">
		<?php 
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
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
						$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];
						
						$total = $transaction_details["total"] + $transaction_forwarder["total"];
						$total_tagihan += $total;
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
				<tr>
					<td colspan="5">
						<u>Delivery Destination :</u><br><br>
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
						<u>Courier Service :</u><br> <?=$transaction_forwarder["name"];?> -- <?=explode(" (",$transaction_forwarder["courier_service"])[0];?>
					</td>
					<td nowrap width="15%" align="right">
						Weight<br> <?=($transaction_forwarder["weight"]*$transaction_forwarder["qty"]/1000);?> Kg
					</td> 
					<td nowrap width="15%" align="right">
						Shipping Charges<br> Rp <?=format_amount($transaction_forwarder["total"])?>
					</td>
				</tr>
				<tr>
					<td colspan="6" align="right"><b> Total : Rp <?=format_amount($total)?></b></td>
				</tr>
				<tr><td colspan="6"></td></tr>
				<?php } ?>
			</table>
			<br>
		<?php } ?>
		<table width="100%">
			<tr>
				<td align="right"><b>Total Bill : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></td>
			</tr>
		</table>
    </div>
	<?=$f->input("back","Back","type='button' onclick=\"window.history.back();\"");?>
</div>
<?php include_once "footer.php"; ?>