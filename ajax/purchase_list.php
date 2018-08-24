<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "checkPurchaseList"){
		echo count($db->fetch_all_data("transactions",["id"],"buyer_user_id = '".$__user_id."' AND (status BETWEEN 1 AND 2 OR status BETWEEN 5 AND 6) GROUP BY invoice_no"));
	}
	if($mode == "checkStoreSalesList"){
		echo count($db->fetch_all_data("transactions",["id"],"seller_user_id = '".$__user_id."' AND status BETWEEN 3 AND 4 GROUP BY po_no"));
	}
?>