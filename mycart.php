<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];
    if($_GET["checkout"] == "1"){
        $db->addtable("transactions");  $db->where("cart_group",$cart_group);
        $db->addfield("status");        $db->addvalue("1");
        $updating = $db->update();
        if($updating["affected_rows"] > 0){
			$invoice_no = $db->fetch_single_data("transactions","invoice_no",["cart_group"=>$cart_group]);
			$uniq_code = 123;
			$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
            foreach($transactions as $key => $transaction){
                $transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
                $transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];

                $total = $transaction_details["total"] + $transaction_forwarder["total"];
                $total_tagihan += $total;
            }
			
			$db->addtable("transaction_payments");
			$db->addfield("cart_group");		$db->addvalue($cart_group);
			$db->addfield("invoice_no");		$db->addvalue($invoice_no);
			$db->addfield("payment_type_id");	$db->addvalue("2");
			$db->addfield("name");          	$db->addvalue("Transfer Bank");
			$db->addfield("total");		        $db->addvalue($total_tagihan);
			$db->addfield("uniqcode");		    $db->addvalue($uniq_code);
			$inserting = $db->insert();
            javascript("window.location='payment.php?cart_group=".$cart_group."';");
            exit();
        } else {
            $_SESSION["errormessage"] = v("checkout_failed");
        }
    }
?>
<script>
    function toggle_button(){
        document.getElementById("pay").style.display="none";
        document.getElementById("checkout").style.display="block";
    }

</script>


<form role="form" method="POST" autocomplete="off">	
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
		<div class="sub-title-text">
            <span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;Keranjang Belanja
		</div>
	</div>
    <div class="row">
        <div style="height:20px;"></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <?php 
				    $transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
				    foreach($transactions as $key => $transaction){
                        $transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
				        $seller = $db->fetch_all_data("sellers",[],"user_id = '".$transaction["seller_user_id"]."'")[0];
                        $goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
                        $goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
                        $units  = $db->fetch_all_data("units",[],"id = '".$transaction_details["unit_id"]."'")[0];
                        $transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];
                        
                        $total = $transaction_details["total"] + $transaction_forwarder["total"];
                        $total_tagihan += $total;
                        
                ?>
                    <table class="table table-bordered" width="100%">
                        <tr>
                            <td colspan="6"><?=v("pembelian_dari_toko");?> : <?=$seller["name"];?></td>
                        </tr> 
                        <tr>
                            <td colspan="4">
                                <div class="col-md-2">
                                    <img src="products/<?=$goods_photos["filename"]?>" style="width:120px;"> 
                                </div>
                                <div class="col-md-10">
                                    <?=$goods["name"]?><br>
                                    <?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp 
                                    <?=format_amount($transaction_details["price"])?>
                                </div>
                            </td>
                            <td colspan="2">
                                 <?=v("harga_barang");?><br>
                                 Rp <?=format_amount($transaction_details["price"])?>
                            </td>   
                        </tr>
                        <tr>
                            <td colspan="2" width="60%">
                                    <?=v("alamat");?><br>
                                    <?=$transaction_forwarder["user_address_pic"];?> <br>
                                    <?=$transaction_forwarder["user_address"];?> <br>
                                    <?=$transaction_forwarder["user_address_phone"];?>
                                    
                            </td>
                            <td>
                                    <?=v("total");?> <br>
                                    <?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?>
                            </td>  
                            <td>
                                    <?=v("subtotal");?> <br>
                                    Rp <?=format_amount($transaction_details["total"])?>
                            </td>  
                            <td>
                                    <?=v("ongkos_kirim");?> <br>
                                    Rp <?=format_amount($transaction_forwarder["total"])?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" align="right"><b> <?=v("total");?> : Rp <?=format_amount($total)?></b></td>
                        </tr>
                    </table>
                    <?php
                        }
                    ?>
                    <table width="100%">
                        <tr>
                            <td align="right"><b>Total Tagihan : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></td>
                        </tr>
                    </table>
            </div>
        </div>
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
            <?=$f->input("checkout",v("checkout"),"style=\"position:relative;float:right;\" onclick='window.location=\"?checkout=1\"'","btn btn-primary");?>
        </div>
    </div>
</div>
</form>
<div style="height:40px;"></div>


<?php include_once "footer.php"; ?>