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

		$updating["affected_rows"] = true;
        
        if($updating["affected_rows"]){
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
			
			$message = "Terima kasih, Anda telah melakukan konfirmasi pembayaran atas Invoice: ".$invoice_nos;
			$db->addtable("notifications");
			$db->addfield("user_id");		$db->addvalue($__user_id);
			$db->addfield("message");		$db->addvalue($message);
			$inserting = $db->insert();
			
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

<form method="POST" action="?cart_group=<?=$_GET["cart_group"];?>" role="form" method="POST" autocomplete="off">
	<div class="container">
		<div class="row">
			<div class="common_title"><span class="glyphicon glyphicon-barcode" style="color:#1100BB;"></span> &nbsp;<?=v("payment");?></div>
			<div class="border_orange">
				<center>
					<?=(!isMobile())?"<h4><b>".v("make_a_payment_before")."</b></h4>":"<h5><b>".v("make_a_payment_before")."</b></h5>";?>
					<div class="well" style="margin-right:15px;padding:10px;font-weight:bolder;"><?=$invoice_nos;?></div>
				</center>
				<br>
				<div <?=(!isMobile())?"class='center'":"";?>>
					<table width="100%">
						<tr>
							<td nowrap><?=v("amount_to_be_paid");?></td>
							<?php if(!isMobile()){ ?> <td nowrap>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</td> <?php } else { ?> </tr><tr> <?php } ?>
							<td nowrap align="right"><b>Rp. <?=format_amount($transaction_payments["total"],2);?></b></td>
						</tr>
						<tr>
							<td nowrap><?=v("unique_code");?></td>
							<?php if(!isMobile()){ ?> <td nowrap>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</td> <?php } else { ?> </tr><tr> <?php } ?>
							<td nowrap align="right"><b>Rp. <?=format_amount($transaction_payments["uniqcode"],2);?></b></td>
						</tr>
						<tr><td <?=(!isMobile())?"colspan='3'":"";?>><hr style="border-width: 2px;"></td></tr>
						<tr>
							<td nowrap><b>Total</b></td>
							<?php if(!isMobile()){ ?> <td nowrap>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</td> <?php } else { ?> </tr><tr> <?php } ?>
							<td nowrap align="right"><b>Rp. <?=format_amount($total_all,2);?></b></td>
						</tr>
						<tr><td <?=(!isMobile())?"colspan='3'":"";?>><br></td></tr>
						<tr><td <?=(!isMobile())?"colspan='3'":"";?> nowrap>* <?=v("unique_code_reason");?></td></tr>
						<tr><td <?=(!isMobile())?"colspan='3'":"";?> nowrap>* <?=v("pay_precise_last_3_digits");?></td></tr>
						<tr><td <?=(!isMobile())?"colspan='3'":"";?>><br></td></tr>
						<?php 
							if($invoice["status"] != "1"){
								$bank_accounts = $db->fetch_select_data("bank_accounts","id","concat((SELECT name FROM banks WHERE id=bank_id),':',account_no)");
								$user_banks = $db->fetch_select_data("user_banks","id","concat(name,' -- ',(SELECT name FROM banks WHERE id=bank_id),':',account_no)",["user_id" => $__user_id],[],"",true);
						?>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> align="center"><img src="images/logo_marko.png" height="30"></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> align="center" style="padding-top:10px;padding-bottom:10px;"><?=v("payment_to_account");?> : </td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> align="center"><?=$f->select("bank_account_id",$bank_accounts,$transaction_payments["bank_account_id"],"onchange=\"load_bank_info(this.value);\"","form-control");?></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?>><br></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> id="bank_info"></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?>><br></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> style="padding-top:10px;padding-bottom:10px;"><?=v("fill_the_confirmation_form");?> </td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> style="padding-top:10px;padding-bottom:10px; color:red;font-weight:bolder;">Area Jakarta dsk: Min Order <u>Rp. 150.000,-</u><br>Area Tangerang Selatan: Min Order <u>Rp. 125.000,-</u></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?>></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> style="padding-top:10px;padding-bottom:10px; color:red;font-weight:bolder;">Pembelian akan di batalkan jika jarak antar melebihi <?=$__cod_max_km;?> Km. </td></tr>
							
							<!--tr><td <?=(!isMobile())?"colspan='3'":"";?> style="padding-bottom:10px;"><?=$f->select("user_bank_id",$user_banks,$transaction_payments["user_bank_id"],"onchange=\"load_user_banks(this.value);\"","form-control");?></td></tr>
							<tr>
								<td nowrap><?=v("account_name");?></td><?=(!isMobile())?"":"</tr><tr>";?>
								<td <?=(!isMobile())?"colspan='2'":"";?> nowrap style="padding-bottom:10px;"><?=$f->input("bank_an","".$transaction_payments["account_name"]."","placeholder='".v("account_name")."...'","form-control");?></td>
							</tr>
							<tr>
								<td nowrap><?=v("sending_bank_account_no");?></td><?=(!isMobile())?"":"</tr><tr>";?>
								<td <?=(!isMobile())?"colspan='2'":"";?> nowrap style="padding-bottom:10px;"><?=$f->input("account","".$transaction_payments["account_no"]."","placeholder='".v("sending_bank_account_no")."...'","form-control");?></td>
							</tr>
							<tr>
								<td nowrap><?=v("sending_bank_name");?></td><?=(!isMobile())?"":"</tr><tr>";?>
								<td <?=(!isMobile())?"colspan='2'":"";?> nowrap style="padding-bottom:10px;"><?=$f->select("bank_id",$db->fetch_select_data("banks","id","name",[],["name"],"",true),$transaction_payments["bank_id"],"required placeholder='".v("bank_name")."...'","form-control");?></td>
							</tr>
							<tr>
								<td nowrap><?=v("transfer_at");?></td><?=(!isMobile())?"":"</tr><tr>";?>
								<td <?=(!isMobile())?"colspan='2'":"";?> nowrap style="padding-bottom:10px;"><?=$f->input("transfer_at",$transaction_payments["transfer_at"],"type='date'","form-control");?></td>
							</tr-->
							<tr><td <?=(!isMobile())?"colspan='3'":"";?>><br></td></tr>
							<tr><td <?=(!isMobile())?"colspan='3'":"";?> align="center"><?=$f->input("payment","Konfirmasi","type='submit' style='width:100%;'","btn btn-lg btn-info");?></td></tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	load_bank_info(document.getElementById("bank_account_id").value);
</script>
<br>
<?php include_once "footer.php"; ?>