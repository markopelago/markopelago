<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "checkPurchaseList"){
		$return = count($db->fetch_all_data("transactions",["id"],"buyer_user_id = '".$__user_id."' AND (status BETWEEN 1 AND 2 OR status BETWEEN 5 AND 6) GROUP BY invoice_no"));
		$return += count($db->fetch_all_data("transactions",["id"],"buyer_user_id = '".$__user_id."' AND status = 7 AND id IN (SELECT transaction_id FROM transaction_details WHERE transaction_id = transactions.id AND is_reviewed=0) GROUP BY invoice_no"));
		echo $return;
	}
	if($mode == "checkStoreSalesList"){
		$return = count($db->fetch_all_data("transactions",["id"],"seller_user_id = '".$__user_id."' AND status BETWEEN 2 AND 4 GROUP BY po_no"));
		$return += count($db->fetch_all_data("transactions",["id"],"seller_user_id = '".$__user_id."' AND id IN (SELECT transaction_id FROM transaction_details WHERE transaction_id = transactions.id AND is_reviewed=1 AND review_id_read=0) GROUP BY po_no"));
		echo $return;
	}
	if($mode == "checkDeliveringGoods"){
		$cart_groups = "";
		$transactions_forwarders = $db->fetch_all_data("transaction_forwarder",["cart_group"],"forwarder_user_id = '".$__user_id."' AND markoantar_status BETWEEN 1 AND 3");
		foreach($transactions_forwarders as $transactions_forwarder){ $cart_groups .= "'".$transactions_forwarder["cart_group"]."',"; }
		$cart_groups = substr($cart_groups,0,-1);
		echo count($db->fetch_all_data("transactions",["id"],"cart_group IN (".$cart_groups.") GROUP BY cart_group"));
	}
?>