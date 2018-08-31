<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];
	if(isset($_GET["delete_transaction"])){
		$db->addtable("transactions");			$db->where("id",$_GET["delete_transaction"]); $db->delete_();
		$db->addtable("transaction_details");	$db->where("transaction_id",$_GET["delete_transaction"]); $db->delete_();
		$db->addtable("transaction_forwarder");	$db->where("transaction_id",$_GET["delete_transaction"]); $db->delete_();
	}
	
    if($_GET["checkout"] == "1"){
		$failedUpdatingTransactions = false;
		$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
		foreach($transactions as $transaction){
			$invoice_no = generate_invoice_no();
			$db->addtable("transactions");  
			$db->where("cart_group",$cart_group);
			$db->where("seller_user_id",$transaction["seller_user_id"]);
			$db->where("status","0");
			$db->addfield("invoice_no");	$db->addvalue($invoice_no);
			$db->addfield("invoice_at");	$db->addvalue($__now);
			$db->addfield("status");        $db->addvalue("1");
			$updating = $db->update();
			// if($updating["affected_rows"] <= 0) $failedUpdatingTransactions = true;
		}
        if(!$failedUpdatingTransactions){
			$invoice_no = $db->fetch_single_data("transactions","invoice_no",["cart_group"=>$cart_group]);
			$uniqcode = generate_uniqcode();
			$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
            foreach($transactions as $transaction){
                $transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
                $transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];

                $total = $transaction_details["total"] + $transaction_forwarder["total"];
                $total_tagihan += $total;
            }
			
			$db->addtable("transaction_payments");
			$db->addfield("cart_group");		$db->addvalue($cart_group);
			$db->addfield("payment_type_id");	$db->addvalue("2");
			$db->addfield("name");          	$db->addvalue("Transfer Bank");
			$db->addfield("total");		        $db->addvalue($total_tagihan);
			$db->addfield("uniqcode");		    $db->addvalue($uniqcode);
			$inserting = $db->insert();
            javascript("window.location='payment.php?cart_group=".$cart_group."';");
            exit();
        } else {
			$db->addtable("transactions");  
			$db->where("cart_group",$cart_group);
			$db->addfield("invoice_no");	$db->addvalue("");
			$db->addfield("invoice_at");	$db->addvalue("0000-00-00");
			$db->addfield("status");        $db->addvalue("0");
			$db->update();
            $_SESSION["errormessage"] = v("finalization_of_purchases_failed");
        }
    }
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
	}
?>
<script>
    function toggle_button(){
        document.getElementById("pay").style.display="none";
        document.getElementById("checkout").style.display="block";
    }
	
	function delete_transaction(transaction_id){
		if(confirm("<?=v("confirm_delete_transaction");?>")){
			window.location = "?delete_transaction="+transaction_id;
		}
	}

</script>

<div class="container">
    <div class="row">
		<h4 class="well"><b><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;<?=v("shopping_cart");?></b></h4>
	</div>
</div>
<form role="form" method="POST" autocomplete="off">	
<div class="container">
    <div class="row">
		<?php 
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
				$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
		?>
			<table class="table table-bordered" width="100%">
				<tr>
					<td colspan="6">
						<b><?=$seller["name"];?></b><br>
						<span class="glyphicon glyphicon-map-marker"></span> <?=$seller_locations[2]["name"];?>, <?=$seller_locations[1]["name"];?>, <?=$seller_locations[0]["name"];?><br>
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
						<?php if($transaction["status"] == 0){ ?>
							<div class="col-md-10 hidden-sm hidden-md hidden-lg">
								<span title="<?=v("edit");?>" class="glyphicon glyphicon-edit btn btn-primary" onclick="window.location='transaction_edit.php?id=<?=$transaction["id"];?>';"></span>
								<span title="<?=v("delete");?>" class="glyphicon glyphicon-remove btn btn-warning" onclick="delete_transaction('<?=$transaction["id"];?>');"></span><br><br>
							</div>
						<?php } ?>
						<div class="col-md-2">
							<img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
						</div>
						<div class="col-md-10">
							<?php if($transaction["status"] == 0){ ?>
								<div class="hidden-xs" style="position:relative;float:right;">
									<span title="<?=v("edit");?>" class="glyphicon glyphicon-edit btn btn-primary" onclick="window.location='transaction_edit.php?id=<?=$transaction["id"];?>';"></span>
									<span title="<?=v("delete");?>" class="glyphicon glyphicon-remove btn btn-warning" onclick="delete_transaction('<?=$transaction["id"];?>');"></span>
								</div>
							<?php } ?>
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
						<u><?=v("delivery_destination");?> :</u><br><br>
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
						<u><?=v("courier_service");?> :</u><br> <?=$transaction_forwarder["name"];?> -- <?=explode(" (",$transaction_forwarder["courier_service"])[0];?>
					</td>
					<td nowrap width="15%" align="right">
						<?=v("weight");?><br> <?=($transaction_forwarder["weight"]*$transaction_forwarder["qty"]/1000);?> Kg
					</td> 
					<td nowrap width="15%" align="right">
						<?=v("shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
					</td>
				</tr>
				<tr>
					<td colspan="6" align="right"><b> Total : Rp <?=format_amount($total)?></b></td>
				</tr>
				<tr><td colspan="6"></td></tr>
				<?php } ?>
			</table>
		<?php } ?>
		<table width="100%">
			<tr>
				<td align="right"><h4><b><?=v("total_bill");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></h4></td>
			</tr>
		</table>
		<br>
		
        <?php if($db->fetch_single_data("transactions","status",["cart_group" => $cart_group]) == 0){ ?>
            <div id="pay">
                <?=$f->input("more_shopping",v("more_shopping"),"onclick='window.location=\"index.php\"'","btn btn-warning");?>
                <?=$f->input("pay",v("pay"),"style=\"position:relative;float:right;\" onclick='toggle_button();'","btn btn-success");?>
            </div>
        <?php } else { ?>
            <?php if($db->fetch_single_data("transactions","status",["cart_group" => $cart_group]) == 1){ ?>
                <div id="checkout">
                    <?=$f->input("pay",v("pay"),"style=\"position:relative;float:right;\" onclick='window.location=\"payment.php?cart_group=".$cart_group."\";'","btn btn-success");?>
                </div>
            <?php } ?>
        <?php } ?>
        <div id="checkout" style="display:none;">
            <?=$f->input("checkout",v("finalization_of_purchases"),"style=\"position:relative;float:right;\" onclick='window.location=\"?checkout=1\"'","btn btn-primary");?>
        </div>
    </div>
</div>
</form>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>