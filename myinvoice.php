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
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
		<div class="sub-title-text">
            <span class="glyphicon glyphicon-list-alt" style="color:#800000;"></span> &nbsp;Invoice
		</div>
	</div>
    <div class="row">
        <div style="height:20px;"></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php 
				    foreach($_trxBySeller as $seller_user_id => $transactions){
				        $seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
                ?>
                    <table class="table table-bordered" width="100%">
                        <tr>
                            <td colspan="6"><?=v("seller");?> : <b><?=$seller["name"];?></b></td>
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
                                    <img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
                                </div>
                                <div class="col-md-10">
                                    <b><?=$goods["name"]?></b><br>
                                    <?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp <?=format_amount($transaction_details["price"])?><br>
									<?=v("weight_per_unit");?> : <?=($goods["weight"]/1000);?> Kg
                                </div>
                            </td>
                            <td colspan="2" align="right">
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
						<td align="right"><b><?=v("total_bill");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></td>
					</tr>
				</table>
            </div>
        </div>
		<a href="dashboard.php?tabActive=purchase_list" class="btn btn-warning"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></a>
		<?php 
			if($cart_group != ""){
				if($db->fetch_single_data("transactions","id",["cart_group" => $cart_group,"status" => "2:<="]) > 0){
					echo $f->input("pay",v("pay"),"style=\"position:relative;float:right;\" onclick='window.location=\"payment.php?cart_group=".$cart_group."\";'","btn btn-success");
				} else {
					echo "<span style='width:100%' class='btn btn-success'><h3><b><span class='glyphicon glyphicon-ok '> <?=v('paid');?></span></b></h3></span>";
				}
			} else {
				if($transaction["status"] < 7){
					echo "<a onclick=\"transactionDone();\" href='#' style='position:relative;float:right;' class='btn btn-primary'><span class='glyphicon glyphicon-ok'></span> ".v("transaction_done")."</a>";					
				}
			}
		?>
    </div>
</div>
<div style="height:40px;"></div>


<?php include_once "footer.php"; ?>