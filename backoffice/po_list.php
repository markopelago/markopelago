<?php include_once "head.php";?>
<?php 
	if($_GET["seller_paid"] == "1"){
		$db->addtable("transactions");  
		$db->where("po_no",$_GET["po_no"]);
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
	$carts = $db->fetch_all_data("transactions",[],"status >= 3 GROUP BY po_no"); 
?>

<script>
	function seller_paid(po_no){
		if(confirm("Anda yakin sudah membayar ke seller yang bersangkutan?")){
			window.location="?po_no="+po_no+"&seller_paid=1";
		}
	}
</script>
<div class="bo_title">PO</div>
	<?=$t->start("","data_content");?>
	<?=$t->header(["No",
					"PO No",
					"Seller",
					"Buyer",
					"Total",
					"commission",
					"Payment to Seller",
					"Seller Bank",
					"<div onclick=\"sorting('status');\">Status</div>",
					"<div onclick=\"sorting('transaction_at');\">Transaction At</div>",
					""]);?>
	<?php 
		foreach($carts as $no => $cart){
			$totgross = 0;
			$total = 0;
			$transaction = $db->fetch_all_data("transactions",[],"po_no = '".$cart["po_no"]."'")[0];
			$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$cart["po_no"]."')");
			foreach($transaction_details as $transaction_detail){
				$totgross += ($transaction_detail["gross"] * $transaction_detail["qty"]);
				$total += $transaction_detail["total"];
			}
			$commission = $total - $totgross;
			$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart["cart_group"]."'")[0];
			$seller = $db->fetch_single_data("sellers","name",["user_id" => $transaction["seller_user_id"]]);
			$seller_bank = $db->fetch_single_data("user_banks","concat('a/n: ',name,'<br>',(SELECT name FROM banks WHERE id=bank_id),' : ',account_no)",["user_id" => $transaction["seller_user_id"],"default_seller" => 1]);
			$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
		
			if($transaction["status"] < 7){
				$status = "<b style='color:red;'>Transaction Not Yet Done</b>";
			}else if($transaction["seller_paid"] == "0"){
				$status = "Unpaid<br>".$f->input("paid","Paid Now","type='button' onclick=\"seller_paid('".$cart["po_no"]."');\"");
			} else {
				$status = "<b style='color:blue;'>Seller Paid At ".$transaction["seller_paid_at"]."</b>";
			}
			$actions = 	"<a href=\"invoice_view.php?cart_group=".$cart["cart_group"]."\">View</a>";
			echo $t->row(
				[$no+$start+1,
				$cart["po_no"],
				$seller,
				$buyer,
				format_amount($total),
				format_amount($commission),
				"<b>".format_amount($totgross)."</b>",
				$seller_bank,
				$status,
				$transaction["transaction_at"],
				$actions],
				["align='right' valign='top'","","","","align='right' valign='top'","align='right' valign='top'","align='right' valign='top'",""]
			);
		} 
	?>
	<?=$t->end();?>
	
<?php include_once "footer.php";?>