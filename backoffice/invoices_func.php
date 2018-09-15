<?php 
	function updateStatus3($cart_group,$seller_user_id,$po_no){
		/* global $db,$__now;
		$db->addtable("transactions");  
		$db->where("cart_group",$cart_group);
		$db->where("seller_user_id",$seller_user_id);
		$db->where("status","2");
		$db->addfield("po_no");			$db->addvalue($po_no);
		$db->addfield("po_at");			$db->addvalue($__now);
		$db->addfield("status");        $db->addvalue("3");
		$updating = $db->update(); */
	}
	function sendMailPaymentVerified($cart_group){
		global $db;
		$emails = array();
		$po_s = array();
		$invoice_nos = "";
		$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
		foreach($transactions as $transaction){
			$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'");
			$seller_user_id = $transaction["seller_user_id"];
			$seller_email = $db->fetch_single_data("a_users","email",["id" => $seller_user_id]);
			$seller_name = $db->fetch_single_data("sellers","concat(pic,' - ',name)",["user_id" => $seller_user_id]);
			$po_s[$transaction["po_no"]]["seller_user_id"] = $seller_user_id;
			$po_s[$transaction["po_no"]]["seller_email"] = $seller_email;
			$po_s[$transaction["po_no"]]["seller_name"] = $seller_name;
			foreach($transaction_details as $transaction_detail){
				$goods_name = $db->fetch_single_data("goods","name",["id" => $transaction_detail["goods_id"]]);
				$unit = $db->fetch_single_data("units","name_".$__locale,["id" => $transaction_detail["unit_id"]]);
				$emails[$transaction["invoice_no"]]["total"] += $transaction_detail["total"];
				$emails[$transaction["invoice_no"]]["cart_detail"] .= "<tr>
																			<td>".$goods_name."</td>
																			<td align='right'>".$transaction_detail["qty"]."</td>
																			<td>".$unit."</td>
																			<td>Rp</td>
																			<td align='right'>".format_amount($transaction_detail["total"])."</td>
																		</tr>";
																		
				$po_s[$transaction["po_no"]]["total"] += $transaction_detail["total"];
				$po_s[$transaction["po_no"]]["cart_detail"] .= "<tr>
																	<td>".$goods_name."</td>
																	<td align='right'>".$transaction_detail["qty"]."</td>
																	<td>".$unit."</td>
																	<td>Rp</td>
																	<td align='right'>".format_amount($transaction_detail["total"])."</td>
																</tr>";
			}
			if(!$_invoice_nos[$transaction["invoice_no"]]){
				$_invoice_nos[$transaction["invoice_no"]] = 1;
				$invoice_nos .= $transaction["invoice_no"].", "; 
			}
		}
		$invoice_nos = substr($invoice_nos,0,-2);
		
		$order_detail = "";
		$TOTAL = 0;
		$shoppingTotal = 0;
		foreach($emails as $invoice_no => $email){
			$TOTAL += $email["total"];
			$shoppingTotal += $email["total"];
			$order_detail .= "<p><h3>".$invoice_no."</h3></p>
								<table cellpadding='3'>
									".$email["cart_detail"]."
									<tr>
										<td><b>Sub Total</b></td>
										<td></td>
										<td></td>
										<td><b>Rp</b></td>
										<td align='right'><b>".format_amount($email["total"])."</b></td>
									</tr>
								</table>";
								
			$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE invoice_no = '".$invoice_no."')");
			if(count($transaction_forwarders) > 0){
				$order_detail .= "<p></p><p><b>Servis Kurir : </b></p><table cellpadding='3'>";
				$forwarder_total = 0;
				foreach($transaction_forwarders as $transaction_forwarder){
					$forwarder_total += $transaction_forwarder["total"];
					$shoppingTotal += $transaction_forwarder["total"];
					$order_detail .= "<tr><td>".$transaction_forwarder["name"]." -- ".$transaction_forwarder["courier_service"]."</td>";						
					$order_detail .= "<td>Rp. </td>";						
					$order_detail .= "<td align='right'>".format_amount($transaction_forwarder["total"])."</td></tr>";
				}
				$order_detail .= "<tr><td><b>Subtotal Servis Kurir</b></td><td><b>Rp.</b></td><td align='right'><b>".format_amount($forwarder_total)."</b></td></tr>";
				$order_detail .= "</table><br>";
			}
		}
		
		$unique_code = $db->fetch_single_data("transaction_payments","uniqcode",["cart_group" => $cart_group]);
		$GrandTotal = $shoppingTotal + $unique_code;
		$payment_info = "<p><h3>Info Pembayaran:</h3></p>
								<table cellpadding='3'>";
		$payment_info .= "<tr><td>Total Belanja</td><td>Rp. </td><td align='right'>".format_amount($shoppingTotal)."</td></tr>";
		$payment_info .= "<tr><td>Kode Unik</td><td>Rp. </td><td align='right'>".format_amount($unique_code)."</td></tr>";
		$payment_info .= "<tr><td><b>Total Pembayaran</b></td><td><b>Rp. </b></td><td align='right'><b>".format_amount($GrandTotal)."</b></td></tr></table>";
		$arr1 = ["{order_detail}","{payment_info}"];
		$arr2 = [$order_detail,$payment_info];
		$body = read_file("../html/email_payment_verified_id.html");
		$body = str_replace($arr1,$arr2,$body);
		$buyer_user_id = $db->fetch_single_data("transactions","buyer_user_id",["cart_group" => $cart_group]);
		$buyer_email = $db->fetch_single_data("a_users","email",["id" => $buyer_user_id]);
		sendingmail("Markopelago.com -- Pembayaran Berhasil ".$invoice_nos,$buyer_email,$body,"system@markopelago.com|Markopelago System");
		
		$order_detail = "";
		$shoppingTotal = 0;
		foreach($po_s as $po_no => $po){
			$shoppingTotal = $po["total"];
			$order_detail = "<table cellpadding='3'>
									".$po["cart_detail"]."
									<tr>
										<td><b>Sub Total</b></td>
										<td></td>
										<td></td>
										<td><b>Rp</b></td>
										<td align='right'><b>".format_amount($po["total"])."</b></td>
									</tr>
								</table>";
								
			$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$po_no."')");
			if(count($transaction_forwarders) > 0){
				$order_detail .= "<p></p><p><b>Servis Kurir : </b></p><table cellpadding='3'>";
				$forwarder_total = 0;
				foreach($transaction_forwarders as $transaction_forwarder){
					$forwarder_total += $transaction_forwarder["total"];
					$shoppingTotal += $transaction_forwarder["total"];
					$order_detail .= "<tr><td>".$transaction_forwarder["name"]." -- ".$transaction_forwarder["courier_service"]."</td>";						
					$order_detail .= "<td>Rp. </td>";						
					$order_detail .= "<td align='right'>".format_amount($transaction_forwarder["total"])."</td></tr>";
				}
				$order_detail .= "<tr><td><b>Subtotal Servis Kurir</b></td><td><b>Rp.</b></td><td align='right'><b>".format_amount($forwarder_total)."</b></td></tr>";
				$order_detail .= "</table><br>";
			}
			$order_detail .= "<br><table cellpadding='3'><tr><td><b>Total Pembayaran</b></td><td><b>Rp. </b></td><td align='right'><b>".format_amount($shoppingTotal)."</b></td></tr></table>";
			$buyer_name = $db->fetch_single_data("a_users","name",["id" => $buyer_user_id]);
			
			$arr1 = ["{seller_name}","{buyer_name}","{order_detail}"];
			$arr2 = [$po["seller_name"],$buyer_name,$order_detail];
			$body = read_file("../html/email_purchase_order_id.html");
			$body = str_replace($arr1,$arr2,$body);
			sendingmail("Markopelago.com -- Purchase Order ".$po_no,$po["seller_email"],$body,"system@markopelago.com|Markopelago System");
		}
	}
?>