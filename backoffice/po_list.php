<?php include_once "head.php";?>
<div class="bo_title">PO</div>

<?php
	$carts = $db->fetch_all_data("transactions",[],"status >= 3 GROUP BY po_no");
?>
	<?=$t->start("","data_content");?>
	<?=$t->header(["No",
					"PO No",
					"Invoice No",
					"Seller",
					"Buyer",
					"Total",
					"<div onclick=\"sorting('status');\">Status</div>",
					"<div onclick=\"sorting('transaction_at');\">Transaction At</div>",
					""]);?>
	<?php 
		foreach($carts as $no => $cart){
			$invoice_no = "";
			$total = 0;
			$transactions = $db->fetch_all_data("transactions",[],"po_no = '".$cart["po_no"]."'");
			foreach($transactions as $transaction){
				if(!$invoices[$transaction["invoice_no"]]){
					$invoice_no .= $transaction["invoice_no"]."<br>"; 
					$invoices[$transaction["invoice_no"]] = 1;
				}
			}
			$invoice_no = substr($invoice_no,0,-4);
			$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart["cart_group"]."'")[0];
			$seller = $db->fetch_single_data("a_users","name",["id" => $transaction["seller_user_id"]]);
			$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
			$actions = 	"<a href=\"invoice_view.php?cart_group=".$cart["cart_group"]."\">View</a>";
			echo $t->row(
				[$no+$start+1,
				$cart["po_no"],
				$invoice_no,
				$seller,
				$buyer,
				format_amount($transaction_payments["total"]),
				$status,
				$transaction["transaction_at"],
				$actions],
				["align='right' valign='top'","","","align='right' valign='top'","align='right' valign='top'","align='right' valign='top'"]
			);
		} 
	?>
	<?=$t->end();?>
	
<?php include_once "footer.php";?>