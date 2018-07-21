<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];

    if($_POST["payment"]){
        
        $db->addtable("transaction_payments");
		$db->where("cart_group",$cart_group);
		$db->addfield("account_name");	    $db->addvalue($_POST["bank_an"]);
		$db->addfield("account_no");		$db->addvalue($_POST["account"]);
		$db->addfield("bank");	            $db->addvalue($_POST["bank"]);
		$db->addfield("transfer_at");		$db->addvalue($__now);
		$updating = $db->update();
        
        if($updating["affected_rows"] > 0){
            $_SESSION["message"] = v("payment_confirmation_success");
            javascript("window.location='dashboard.php?tabActive=invoice';");
        }else{
            $_SESSION["errormessage"] = v("payment_confirmation_failed");
        }
        
    }
?>
<form role="form" method="POST" autocomplete="off">	
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
		<div class="sub-title-text">
            <span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;Payment
		</div>
    </div>
    <div class="row">
        <div style="height:20px;"></div>
            <div class="container">
                <div class="well">
                    <u>Detail Invoice:</u><br>
                    <i>
                        <?php
                        $transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart_group."'")[0];
						$total_all = $transaction_payments["total"] + $transaction_payments["uniqcode"];
                        ?>
                        
                        <b>Invoice No : <?=$transaction_payments["invoice_no"];?></b><br><br>
                        <table width="200">
                            <tr><td colspan="3" nowrap>Dengan nilai :</td><tr>
                            <tr><td style="width:35px;"></td><td>Rp. </td><td align="right"><?=format_amount($transaction_payments["total"],2);?></td></tr>
                            <tr><td colspan="3" nowrap>Kode Unik <span style="color:red;">*</span> :</td><tr>
                            <tr><td style="width:35px;"></td><td>Rp. </td><td align="right"><?=format_amount($transaction_payments["uniqcode"],2);?></td></tr>
                            <tr><td colspan="3" nowrap><b>Total:</b></td><tr>
                            <tr><td style="width:35px;"></td><td><b>Rp. </b></td><td align="right"><b><?=format_amount($total_all,2);?></b></td></tr>
                        </table>
                        <br>
                        <p><i>*) Kode Unik adalah 3 digit angka yang kami tambahkan di belakang nominal total biaya transaksi Anda. Tujuannya adalah untuk mempermudah bagian keuangan Kami dalam melakukan verifikasi atas pembayaran yang sudah Anda lakukan.</i></p>
                        <br><br>
                        <?php if($invoice["status"] != "1"){ ?>
                            <u>Harap dibayarkan ke :</u><br>
                            Bank BCA<br>No Rekening: 123.123.123.123<br>a/n PT MARKOPELAGO
                            <br><br>
                            <u>Data Pembayaran :</u><br>
                            <p>Jika Anda sudah melakukan pembayaran, silakan isi form berikut untuk mengkonfirmasi pembayaran Anda.</p>
                            <form method="POST">
                                <input type="hidden" name="invoice_id" value="<?=$_GET["invoice_id"];?>">
                                <table>
                                    <tr><td>Nama Pemilik Rekening &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("bank_an","".$transaction_payments["account_name"]."","","form-control");?></td></tr>
                                    <tr><td>No Rekening Bank Pengirim  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("account","".$transaction_payments["account_no"]."","","form-control");?></td></tr>
                                    <tr><td>Nama Bank Pengirim  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("bank","".$transaction_payments["bank"]."","","form-control");?></td></tr>
                                    <tr><td>Tanggal Transfer  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("transfer_at",date("Y-m-d"),"type='date'","form-control");?></td></tr>
                                </table>
                                <br>
                                <?=$f->input("payment","Konfirmasi","type='submit' style='width:100%;'","btn btn-lg btn-info");?>
                            </form>
                            <br>
                        <?php } ?>
                    </i><br>				
                </div>
    </div>
    </div>
</div>
</form>


<?php include_once "footer.php"; ?>