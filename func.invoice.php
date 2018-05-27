<?php
	function generate_invoice_no(){
		global $db;
		// CHR-001/001/17
		// JK-003/003/17
		// JK-0{mm}/{no}/{yy}
		$pattern = "JK-0".date("m")."/%/".date("y");
		$last_invoice_no = (substr($db->fetch_single_data("invoices","num",array("num" => $pattern.":LIKE"),array("num DESC")),7,3) * 1) + 1;
		$invoice_no = substr("000",0,3-strlen($last_invoice_no)).$last_invoice_no;
		return str_replace("%",$invoice_no,$pattern);
	}
?>