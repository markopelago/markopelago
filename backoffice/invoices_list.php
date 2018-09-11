<?php include_once "head.php";?>
<?php
	if($_GET["changeStatus"]  == 3){
		$cart_group = $_GET["cart_group"];
		$failedUpdatingTransactions = false;
		$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
		foreach($transactions as $transaction){
			$po_no = generate_po_no();
			$db->addtable("transactions");  
			$db->where("cart_group",$cart_group);
			$db->where("seller_user_id",$transaction["seller_user_id"]);
			$db->where("status","2");
			$db->addfield("po_no");			$db->addvalue($po_no);
			$db->addfield("po_at");			$db->addvalue($__now);
			$db->addfield("status");        $db->addvalue("3");
			$updating = $db->update();
			// if($updating["affected_rows"] <= 0) $failedUpdatingTransactions = true;
		}
		if(!$failedUpdatingTransactions){
			$_SESSION["message"] = "Status berhasil diubah";
			?><script> window.location='invoices_list.php'; </script><?php
			exit();
		} else {
			$_SESSION["errormessage"] = "Status gagal diubah";
		}
	}
?>
<script>
	function changeStatus(cart_group,status){
		if(status == 3){
			if(confirm("Anda yakin akan mengubah status data?")){
				window.location="?cart_group="+cart_group+"&changeStatus="+status;
			}
		}
	}
</script>
<div class="bo_title">INBOUND</div>

<?php
	$carts = $db->fetch_all_data("transactions",[],"status >= 2 GROUP BY cart_group");
?>
	<?=$t->start("","data_content");?>
	<?=$t->header(["No",
					"Invoice No",
					"PO No",
					"<div onclick=\"sorting('transaction_at');\">Transaction At</div>",
					"<div onclick=\"sorting('buyer_user_id');\">Buyer</div>",
					"Nominal",
					"Uniq",
					"Total",
					"<div onclick=\"sorting('status');\">Status</div>",
					"Transfer At",
					"Bank From",
					"Bank To",
					""]);?>
	<?php 
		foreach($carts as $no => $cart){
			$invoice_no = "";
			$po_no = "";
			$total = 0;
			$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart["cart_group"]."'");
			foreach($transactions as $transaction){
				if(!$po_s[$transaction["po_no"]]){
					$po_no .= $transaction["po_no"]."<br>"; 
					$po_s[$transaction["po_no"]] = 1;
				}
				if(!$invoices[$transaction["invoice_no"]]){
					$invoice_no .= $transaction["invoice_no"]."<br>"; 
					$invoices[$transaction["invoice_no"]] = 1;
				}
			}
			$invoice_no = substr($invoice_no,0,-4);
			$po_no = substr($po_no,0,-4);
			$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart["cart_group"]."'")[0];
			$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
			if($transaction["status"] == "2"){
				$status = $f->select("status",["2" => "Tunggu verifikasi pembayaran", "3" => "Pembayaran terverifikasi"],$transaction["status"],"onchange=\"changeStatus('".$transaction["cart_group"]."',this.value);\"");
			} else if($transaction["status"] > "2"){
				$status = "<b style='color:blue;'>Pembayaran terverifikasi</b>";
			}else{
				$status = "";
			}
			$bank_from = $db->fetch_single_data("banks","name",["id" => $transaction_payments["bank_id"]]);
			$bank_from .= " (".$transaction_payments["account_no"].") <br> a/n:".$transaction_payments["account_name"];
			$bank_to = "";
			if($transaction_payments["bank_account_id"] > 0){
				$bank_account = $db->fetch_all_data("bank_accounts",[],"id = '".$transaction_payments["bank_account_id"]."'")[0];
				$bank_to = $db->fetch_single_data("banks","name",["id" => $bank_account["bank_id"]]);
				$bank_to .= " (".$bank_account["account_no"].") <br> a/n:".$bank_account["account_name"];				
			}
			
			$actions = 	"<a href=\"invoice_view.php?cart_group=".$cart["cart_group"]."\">View</a>";
			echo $t->row(
				[$no+$start+1,
				$invoice_no,
				$po_no,
				$transaction["transaction_at"],
				$buyer,
				format_amount($transaction_payments["total"]),
				format_amount($transaction_payments["uniqcode"]),
				format_amount($transaction_payments["total"] + $transaction_payments["uniqcode"]),
				$status,
				format_tanggal($transaction_payments["transfer_at"]),
				$bank_from,
				$bank_to,
				$actions],
				["align='right' valign='top'","","","","","align='right' valign='top'","align='right' valign='top'","align='right' valign='top'"]
			);
		} 
	?>
	<?=$t->end();?>
	
<?php include_once "footer.php";?>