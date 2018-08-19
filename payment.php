<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];

    if($_POST["payment"]){
        
        $db->addtable("transaction_payments");
		$db->where("cart_group",$cart_group);
		$db->addfield("bank_account_id");	$db->addvalue($_POST["bank_account_id"]);
		$db->addfield("account_name");	    $db->addvalue($_POST["bank_an"]);
		$db->addfield("account_no");		$db->addvalue($_POST["account"]);
		$db->addfield("bank_id");	        $db->addvalue($_POST["bank_id"]);
		$db->addfield("transfer_at");		$db->addvalue($_POST["transfer_at"]);
		$updating = $db->update();
        
        if($updating["affected_rows"] > 0){
			$db->addtable("transactions");	
			$db->where("cart_group",$cart_group);
			$db->where("buyer_user_id",$__user_id);
			$db->addfield("status");	    $db->addvalue("2");
			$updating = $db->update();
            $_SESSION["message"] = v("payment_confirmation_success");
            javascript("window.location='dashboard.php?tabActive=purchase_list';");
			exit();
        } else {
            $_SESSION["errormessage"] = v("payment_confirmation_failed");
        }
        
    }
	$transaction_payments["transfer_at"] = date("Y-m-d");
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$_GET["cart_group"]."'");
	$invoice_nos = "";
	foreach($transactions as $transaction){ $invoice_nos .= $transaction["invoice_no"].", "; }
	$invoice_nos = substr($invoice_nos,0,-2);
	
?>
<script>
	function load_bank_info(bank_account_id){
		$("#bank_info").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadBankAccounts&bank_account_id="+bank_account_id, function(returnval){
			$("#bank_info").html(returnval);
		});
	}
</script>
<form role="form" method="POST" autocomplete="off">	
	<div style="height:20px;"></div>
	<div class="container">
		<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
			<div class="sub-title-text">
				<span class="glyphicon glyphicon-barcode" style="color:#800000;"></span> &nbsp;<?=v("payment");?>
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
						
						<b>Invoice No : <?=$invoice_nos;?></b><br><br>
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
						<form method="POST" action="?cart_group=<?=$_GET["cart_group"];?>">
							<?php 
								if($invoice["status"] != "1"){
									$bank_accounts = $db->fetch_select_data("bank_accounts","id","concat(account_name,' -- ',(SELECT name FROM banks WHERE id=bank_id),':',account_no)");
									echo v("choose_the_destination_bank")." : ".$f->select("bank_account_id",$bank_accounts,$transaction_payments["bank_account_id"],"onchange=\"load_bank_info(this.value);\"");
							?>
								<br><br>
								<u>Harap dibayarkan ke :</u><br>
								<div id="bank_info"></div>
								<br><br>
								<u>Data Pembayaran :</u><br>
								<p>Jika Anda sudah melakukan pembayaran, silakan isi form berikut untuk mengkonfirmasi pembayaran Anda.</p>
								<table>
									<tr><td>Nama Pemilik Rekening &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("bank_an","".$transaction_payments["account_name"]."","","form-control");?></td></tr>
									<tr><td>No Rekening Bank Pengirim  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("account","".$transaction_payments["account_no"]."","","form-control");?></td></tr>
									<tr><td>Nama Bank Pengirim  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->select("bank_id",$db->fetch_select_data("banks","id","name",[],["name"],"",true),$transaction_payments["bank_id"],"required placeholder='".v("bank_name")."...'","form-control");?></td></tr>
									<tr><td>Tanggal Transfer  &nbsp;&nbsp;&nbsp;</td><td nowrap><?=$f->input("transfer_at",$transaction_payments["transfer_at"],"type='date'","form-control");?></td></tr>
								</table>
								<br>
								<?=$f->input("payment","Konfirmasi","type='submit' style='width:100%;'","btn btn-lg btn-info");?>
								<br>
							<?php } ?>
						</form>
					</i><br>				
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	load_bank_info(document.getElementById("bank_account_id").value);
</script>


<?php include_once "footer.php"; ?>