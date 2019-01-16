<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "checkPurchaseList"){
		echo count($db->fetch_all_data("transactions",["id"],"buyer_user_id = '".$__user_id."' AND (status BETWEEN 1 AND 2 OR status BETWEEN 5 AND 6) GROUP BY invoice_no"));
	}
	if($mode == "checkStoreSalesList"){
		echo count($db->fetch_all_data("transactions",["id"],"seller_user_id = '".$__user_id."' AND status BETWEEN 3 AND 4 GROUP BY po_no"));
	}
	if($mode == "checkDeliveringGoods"){
		$transaction_ids = "";
		$transactions_forwarders = $db->fetch_all_data("transaction_forwarder",["transaction_id"],"forwarder_user_id = '".$__user_id."' AND markoantar_status BETWEEN 1 AND 3");
		foreach($transactions_forwarders as $transactions_forwarder){ $transaction_ids .= $transactions_forwarder["transaction_id"].","; }
		$transaction_ids = substr($transaction_ids,0,-1);
		echo count($db->fetch_all_data("transactions",["id"],"id IN (".$transaction_ids.") GROUP BY cart_group"));
	}
?>