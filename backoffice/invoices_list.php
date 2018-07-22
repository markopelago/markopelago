<?php include_once "head.php";?>
<?php
	if($_GET["changeStatus"]>0){
		$db->addtable("transactions");	$db->where("invoice_no",$_GET["invoice_no"]);
		$db->addfield("status");	$db->addvalue("2");
		$db->update();
	}
?>
<div class="bo_title">Invoices</div>

<?php
	$transactions = $db->fetch_all_data("transactions",[],"status > 0 GROUP BY invoice_no");
?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('invoice_no');\">Invoice No</div>",
						"<div onclick=\"sorting('buyer_user_id');\">Buyer</div>",
						"Nominal",
						"<div onclick=\"sorting('status');\">Status</div>",
						"<div onclick=\"sorting('transaction_at');\">Transaction At</div>"));?>
	<?php 
		foreach($transactions as $no => $transaction){
			$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
			$nominal = $db->fetch_single_data("transaction_payments","concat(total+uniqcode)",["invoice_no" => $transaction["invoice_no"]]);
			$status = $f->select("status",["1" => "UnPaid", "2" => "Paid"],$transaction["status"],"onchange=\"window.location='?changeStatus='+this.value+'&invoice_no=".$transaction["invoice_no"]."'\"");
			echo $t->row(
				array($no+$start+1,
				$transaction["invoice_no"],
				$buyer,
				format_amount($nominal),
				$status,
				$transaction["transaction_at"]),
				array("align='right' valign='top'","","","align='right' valign='top'")
			);
		} 
	?>
	<?=$t->end();?>
	
<?php include_once "footer.php";?>