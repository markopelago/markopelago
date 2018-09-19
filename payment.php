<?php include_once "header.php"; ?>
<?php
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];
	
	
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$_GET["cart_group"]."'");
	$invoice_nos = "";
	foreach($transactions as $transaction){ 
		if(!$_invoice_nos[$transaction["invoice_no"]]){
			$_invoice_nos[$transaction["invoice_no"]] = 1;
			$invoice_nos .= $transaction["invoice_no"].", "; 
		}
	}
	$invoice_nos = substr($invoice_nos,0,-2);
	$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart_group."'")[0];
	$total_all = $transaction_payments["total"] + $transaction_payments["uniqcode"];
	if($transaction_payments["transfer_at"] == "0000-00-00") $transaction_payments["transfer_at"] = date("Y-m-d");

    if($_POST["payment"]){
        
        $db->addtable("transaction_payments");
		$db->where("cart_group",$cart_group);
		$db->addfield("bank_account_id");	$db->addvalue($_POST["bank_account_id"]);
		$db->addfield("user_bank_id");	    $db->addvalue($_POST["user_bank_id"]);
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
			
			$buyer_name = $db->fetch_single_data("a_users","name",["id" => $__user_id]);
			$total = format_amount($transaction_payments["total"],2);
			$uniq_code = format_amount($transaction_payments["uniqcode"],2);
			$grandtotal = format_amount($total_all,2);
			
			$arr1 = ["{buyer_name}","{invoice_nos}","{total}","{uniq_code}","{grandtotal}"];
			$arr2 = [$buyer_name,$invoice_nos,$total,$uniq_code,$grandtotal];
			$body = read_file("html/email_payment_confirmed_id.html");
			$body = str_replace($arr1,$arr2,$body);
			sendingmail("Markopelago.com -- Payment Confirmation ".$buyer_name,"finance@markopelago.com",$body,"system@markopelago.com|Markopelago System");
			
            $_SESSION["message"] = v("payment_confirmation_success");
            javascript("window.location='dashboard.php?tabActive=purchase_list';");
			exit();
        } else {
            $_SESSION["errormessage"] = v("payment_confirmation_failed");
        }
        
    }
?>
<script>
	function load_bank_info(bank_account_id){
		$("#bank_info").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadBankAccounts&bank_account_id="+bank_account_id, function(returnval){
			$("#bank_info").html(returnval);
		});
	}
	
	function load_user_banks(user_bank_id){
		$.get("ajax/transaction.php?mode=loadUserBank&user_bank_id="+user_bank_id, function(returnval){
			returnval = returnval.split("|||");
			$("#bank_id").val(returnval[0]);
			$("#bank_an").val(returnval[1]);
			$("#account").val(returnval[2]);
		});
	}
</script>
<div class="container">
    <div class="row">
		<h4 class="well"><b><span class="glyphicon glyphicon-barcode" style="color:#800000;"></span> &nbsp;<?=v("payment");?></b></h4>
	</div>
</div>
<form role="form" method="POST" autocomplete="off">	
	<div class="container">
		<div class="row">
			<div class="well">
				<u>Detail Invoice:</u><br>
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
					
					<form method="POST" action="?cart_group=<?=$_GET["cart_group"];?>">
						<?php 
							if($invoice["status"] != "1"){
								$bank_accounts = $db->fetch_select_data("bank_accounts","id","concat((SELECT name FROM banks WHERE id=bank_id),':',account_no)");
								echo v("the_destination_bank")." :<br>".$f->select("bank_account_id",$bank_accounts,$transaction_payments["bank_account_id"],"onchange=\"load_bank_info(this.value);\"","form-control");
						?>
							<br>
							<u>Harap dibayarkan ke :</u><br>
							<div id="bank_info"></div>
							<br>
							<u>Data Pembayaran :</u><br>
							<p>Jika Anda sudah melakukan pembayaran, silakan isi form berikut untuk mengkonfirmasi pembayaran Anda.</p>
							<?php
								$user_banks = $db->fetch_select_data("user_banks","id","concat(name,' -- ',(SELECT name FROM banks WHERE id=bank_id),':',account_no)",["user_id" => $__user_id],[],"",true);
								echo "Bank :<br>".$f->select("user_bank_id",$user_banks,$transaction_payments["user_bank_id"],"onchange=\"load_user_banks(this.value);\"","form-control");
							?>
							<div class="row">
								<div class="form-group">
									<div class="col-md-3"><label>Nama Pemilik Rekening</label></div>
									<div class="col-md-8"><?=$f->input("bank_an","".$transaction_payments["account_name"]."","placeholder='Nama Pemilik Rekening...'","form-control");?></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-3"><label>No Rekening Bank Pengirim</label></div>
									<div class="col-md-8"><?=$f->input("account","".$transaction_payments["account_no"]."","placeholder='No Rekening Bank Pengirim...'","form-control");?></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-3"><label>Nama Bank Pengirim</label></div>
									<div class="col-md-8"><?=$f->select("bank_id",$db->fetch_select_data("banks","id","name",[],["name"],"",true),$transaction_payments["bank_id"],"required placeholder='".v("bank_name")."...'","form-control");?></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<div class="col-md-3"><label>Tanggal Transfer</label></div>
									<div class="col-md-8"><?=$f->input("transfer_at",$transaction_payments["transfer_at"],"type='date'","form-control");?></div>
								</div>
							</div>
							<br>
							<?=$f->input("payment","Konfirmasi","type='submit' style='width:100%;'","btn btn-lg btn-info");?>
							<br>
						<?php } ?>
					</form>
				<br>				
			</div>
		</div>
	</div>
</form>
<script>
	load_bank_info(document.getElementById("bank_account_id").value);
</script>


<?php include_once "footer.php"; ?>