<?php include_once "header.php"; ?>
<?php include_once "backoffice/invoices_func.php"; ?>
<?php
	$user_address_default = $db->fetch_single_data("user_addresses","id",["user_id" => $__user_id, "default_buyer" => "1"]);
	if($user_address_default <= 0){
		$_SESSION["errormessage"] = v("register_shipping_address_first");
		$_SESSION["referer_url"] = "transaction.php?id=".$_GET["id"];
		javascript("window.location='user_address_add.php'");
		exit();
	}
	if($_GET["user_address_id"] > 0) $user_address_default = $_GET["user_address_id"];
    $cart_group = ($_GET["cart_group"] == "")?$db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]):$_GET["cart_group"];
	$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."' ORDER BY seller_user_id");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	$_transaction_ids = "";
	foreach($transactions as $transaction){
		$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
		$_transaction_ids .= $transaction["id"].",";
	} $_transaction_ids = substr($_transaction_ids,0,-1);
	
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	if(isset($_POST["pay"]) || $_POST["action_mode"] == "cod"){
		$failedUpdatingTransactions = false;
		$invoice_no = generate_invoice_no();
		$db->addtable("transactions");  
		$db->where("cart_group",$cart_group);
		$db->where("buyer_user_id",$__user_id);
		$db->where("status","0");
		$db->addfield("invoice_no");	$db->addvalue($invoice_no);
		$db->addfield("invoice_at");	$db->addvalue($__now);
		$db->addfield("status");        $db->addvalue("1");
		$updating = $db->update();
		if($updating["affected_rows"] <= 0) $failedUpdatingTransactions = true;
		if(!$failedUpdatingTransactions){
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$transaction_id = $transactions["id"];
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
				$seller_id = $seller["id"];
				$is_pasar = $db->fetch_single_data("seller_is_pasar","id",["seller_id" => $seller_id]);
				$forwarder_id 				= $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $_POST["delivery_courier_".$seller_id]]);
				if($forwarder_id > 0){
					$forwarder_user_id 			= $db->fetch_single_data("forwarders","user_id",["rajaongkir_code" => $_POST["delivery_courier_".$seller_id]]);
					$name 						= $db->fetch_single_data("forwarders","name",["rajaongkir_code" => $_POST["delivery_courier_".$seller_id]]);
				} else {
					$forwarder_id 				= $db->fetch_single_data("forwarders","id",["user_id" => $_POST["delivery_courier_".$seller_id]]);
					$forwarder_user_id 			= $_POST["delivery_courier_".$seller_id];
					$name 						= $db->fetch_single_data("forwarders","name",["user_id" => $_POST["delivery_courier_".$seller_id]]);
				}
				$user_address_id 			= $_POST["user_address"];
				$_user_address				= $db->fetch_all_data("user_addresses",[],"id='".$user_address_id."' AND user_id='".$__user_id."'")[0];
				$user_address_name 			= $_user_address["name"];
				$user_address_pic 			= $_user_address["pic"];
				$user_address_phone 		= $_user_address["phone"];
				$user_address 				= $_user_address["address"];
				$user_address_location_id 	= $_user_address["location_id"];
				$user_address_coordinate 	= $_user_address["coordinate"];
				$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."')");
				$qty = 0;
				$total_weight = 0;
				foreach($transaction_details as $transaction_detail){
					$goods_id = $transaction_detail["goods_id"];
					$qty += $transaction_detail["qty"];
					$total_weight += ($transaction_detail["qty"] * $transaction_detail["weight"]);
					$pickup_location_id = $db->fetch_single_data("goods","pickup_location_id",["id" => $goods_id]);
					if($pickup_location_id > 0) $pickup_location_ids[$pickup_location_id] = 1;
				}
				if(count($pickup_location_ids) != 1 || $pickup_location_id <= 0) $pickup_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
				if($_POST["self_pickup_".$seller_id] > 0){
					$price 						= $__self_pickup_fee;
					$name						= "self_pickup";
					$_POST["courier_service_".$seller_id] = "self_pickup";
				} else {
					$seller_locations = get_location($pickup_location_id);
					$buyer_locations = get_location($user_address_location_id);
					$origin = $ro->location_id($seller_locations[0]["name"],$seller_locations[1]["name"],$seller_locations[2]["name"]);
					$destination = $ro->location_id($buyer_locations[0]["name"],$buyer_locations[1]["name"],$buyer_locations[2]["name"]);
					
					$is_markoantar = false;
					$forwarder_id = $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $_POST["delivery_courier_".$seller_id]]);
					if($forwarder_id <= 0){
						$forwarder_id = $db->fetch_single_data("forwarders","id",["user_id" => $_POST["delivery_courier_".$seller_id]]);
						if($forwarder_id > 0) $is_markoantar = true;
					}
					if(!$is_markoantar){
						foreach($ro->cost($origin,$destination,$total_weight,$_POST["delivery_courier_".$seller_id])["results"][0]["costs"] as $cost){
							if(strtolower($cost["service"]) == strtolower($_POST["courier_service_".$seller_id])){ $price = $cost["cost"][0]["value"]; break; }
						}
					} else {
						if($is_pasar) $price = $__marko_cod;
						else $price = $db->fetch_single_data("forwarder_routes","price",["user_id" => $_POST["delivery_courier_".$seller_id],"vehicle_id" => $_POST["courier_service_".$seller_id],"source_location_id" => $pickup_location_id,"destination_location_id" => $user_address_location_id]);
					}
				}
				$transaction_ids = "";
				$Xtransactions = $db->fetch_all_data("transactions",["id"],"cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."'");
				foreach($Xtransactions as $Xtransaction){ $transaction_ids .= $Xtransaction["id"].","; }
				$transaction_ids = substr($transaction_ids,0,-1);

				$db->addtable("transaction_forwarder");
				$db->addfield("cart_group");			$db->addvalue($cart_group);
				$db->addfield("transaction_id");		$db->addvalue($transaction_id);
				$db->addfield("transaction_ids");		$db->addvalue($transaction_ids);
				$db->addfield("seller_id");				$db->addvalue($seller_id);
				$db->addfield("forwarder_id");			$db->addvalue($forwarder_id);
				$db->addfield("forwarder_user_id");		$db->addvalue($forwarder_user_id);
				$db->addfield("name");					$db->addvalue($name);
				$db->addfield("courier_service");		$db->addvalue($_POST["courier_service_".$seller_id]);
				$db->addfield("pickup_location_id");	$db->addvalue($pickup_location_id);
				$db->addfield("user_address_id");		$db->addvalue($user_address_id);
				$db->addfield("user_address_name");		$db->addvalue($user_address_name);
				$db->addfield("user_address_pic");		$db->addvalue($user_address_pic);
				$db->addfield("user_address_phone");	$db->addvalue($user_address_phone);
				$db->addfield("user_address");			$db->addvalue($user_address);
				$db->addfield("user_address_location_id");$db->addvalue($user_address_location_id);
				$db->addfield("user_address_coordinate");$db->addvalue($user_address_coordinate);
				$db->addfield("weight");				$db->addvalue($total_weight);
				$db->addfield("qty");					$db->addvalue($qty);
				$db->addfield("price");					$db->addvalue($price);
				$db->addfield("total");					$db->addvalue($price);
				$inserting_transaction_forwarder = $db->insert();
			}
			
			$uniqcode = generate_uniqcode();
			$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
			foreach($transactions as $transaction){ $total_tagihan += $db->fetch_single_data("transaction_details","total",["id" => $transaction["id"]]); }
			$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"cart_group = '".$cart_group."'");
			foreach($transaction_forwarders as $transaction_forwarder){ $total_tagihan += $transaction_forwarder["total"]; }
			
			$db->addtable("transaction_payments");
			$db->addfield("cart_group");		$db->addvalue($cart_group);
			if($_POST["action_mode"] == "cod"){
				$db->addfield("payment_type_id");	$db->addvalue("-1");
				$db->addfield("name");          	$db->addvalue("COD");
			} else {
				$db->addfield("payment_type_id");	$db->addvalue("2");
				$db->addfield("name");          	$db->addvalue("Transfer Bank");
				$db->addfield("uniqcode");		    $db->addvalue($uniqcode);
			}
			$db->addfield("total");		        $db->addvalue($total_tagihan);
			$inserting = $db->insert();
			
			$emails = array();
			foreach($transactions as $transaction){
				$trx_at_dd = substr($transaction["transaction_at"],8,2);
				$trx_at_mm = substr($transaction["transaction_at"],5,2);
				$trx_at_yy = substr($transaction["transaction_at"],0,4);
				$last_transfer_day = getHari(date("N",mktime(0,0,0,$trx_at_mm,$trx_at_dd + 1,$trx_at_yy)));
				$last_transfer_at = date("d F Y",mktime(0,0,0,$trx_at_mm,$trx_at_dd + 1,$trx_at_yy));
				$emails[$transaction["invoice_no"]]["last_transfer_day"] = $last_transfer_day;
				$emails[$transaction["invoice_no"]]["last_transfer_at"] = $last_transfer_at;
				$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id = '".$transaction["id"]."'");
				$seller_user_id = $transaction["seller_user_id"];
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
					
					$db->addtable("goods_histories");
					$db->addfield("seller_user_id");	$db->addvalue($seller_user_id);
					$db->addfield("transaction_id");	$db->addvalue($transaction["id"]);
					$db->addfield("goods_id");			$db->addvalue($transaction_detail["goods_id"]);
					$db->addfield("in_out");			$db->addvalue("out");
					$db->addfield("qty");				$db->addvalue($transaction_detail["qty"]);
					$db->addfield("notes");				$db->addvalue($transaction_detail["notes"]);
					$db->addfield("history_at");		$db->addvalue($__now);
					$inserting = $db->insert();
				}
			}
			foreach($_trxBySeller as $seller_user_id => $transactions){
				$transaction_id = $transactions["id"];
				$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
				$seller_id = $seller["id"];
				$seller_email = $db->fetch_single_data("a_users","email",["id" => $seller_user_id]);
				$seller_name = $db->fetch_single_data("sellers","concat(pic,' - ',name)",["user_id" => $seller_user_id]);
				$detail_reservasi = "<table border='1'><tr><td><b>No</b></td><td><b>Produk</b></td><td><b>Qty</b></td><td><b>Unit</b></td></tr>";
				$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."')");
				$goods_names = "";
				foreach($transaction_details as $key => $transaction_detail){
					$goods_id = $transaction_detail["goods_id"];
					$goods_name = $db->fetch_single_data("goods","name",["id" => $transaction_detail["goods_id"]]);
					$qty = $transaction_detail["qty"];
					$unit = $db->fetch_single_data("units","name_".$__locale,["id" => $transaction_detail["unit_id"]]);
					$goods_names .= $goods_name." x ".$qty.", ";
					$detail_reservasi .= "<tr><td align='right'>".($key+1)."</td><td>".$goods_name."</td><td align='right'>".$qty."</td><td>".$unit."</td></tr>"; 
				}
				$detail_reservasi .= "</table>";
				$goods_names = substr($goods_names,0,-1);
					
				$arr1 = ["{seller_name}","{detail_reservasi}"];
				$arr2 = [$seller_name,$detail_reservasi];
				$body = read_file("html/email_reservasi_stok_id.html");
				$body = str_replace($arr1,$arr2,$body);
				sendingmail("Markopelago.com -- Reservasi Stok",$seller_email,$body,"system@markopelago.com|Markopelago System");
				
				$message = "Reservasi barang, ".$goods_names.". Jika pembeli sudah melakukan pembayaran atau memilih pembayaran di tempat, silakan Anda proses transaksi ini..";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($seller_user_id);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
			}
			
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
									
				$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"cart_group = '".$cart_group."'");
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
			$arr1 = ["{last_transfer_day}","{last_transfer_at}","{order_detail}","{payment_info}"];
			$arr2 = [$email["last_transfer_day"],$email["last_transfer_at"],$order_detail,$payment_info];
			
			if($_POST["action_mode"] != "cod"){
				$body = read_file("html/email_wait_payment_verification_id.html");
				$body = str_replace($arr1,$arr2,$body);
				sendingmail("Markopelago.com -- Menunggu Pembayaran ".$transaction["invoice_no"],$__user["email"],$body,"system@markopelago.com|Markopelago System");
				sendingmail("Markopelago.com -- Menunggu Pembayaran ".$transaction["invoice_no"],"finance@markopelago.com",$body,"system@markopelago.com|Markopelago System");
				
				$message = "Selamat! Anda sudah selesai melakukan pesanan dengan nomor invoice ".$transaction["invoice_no"].". Mohon segera melakukan pembayaran sesuai dengan metode pilihan transaksi anda. Terimakasih dan selamat beraktivitas. Salam Markopelago untuk Indonesia!";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($__user_id);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
			
				javascript("window.location='payment.php?cart_group=".$cart_group."';");
			} else {
				$body = read_file("html/email_cod_checkout_id.html");
				$body = str_replace($arr1,$arr2,$body);
				sendingmail("Markopelago.com -- COD | Invoice: ".$transaction["invoice_no"],$__user["email"],$body,"system@markopelago.com|Markopelago System");
				sendingmail("Markopelago.com -- COD | Invoice: ".$transaction["invoice_no"],"finance@markopelago.com",$body,"system@markopelago.com|Markopelago System");
				
				$message = "Selamat! Anda sudah selesai melakukan pesanan dengan nomor invoice ".$transaction["invoice_no"].". Mohon tunggu pengantaran barang ke tempat anda. Terimakasih dan selamat beraktivitas. Salam Markopelago untuk Indonesia!";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($__user_id);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
				
				$failedUpdatingTransactions = false;
				$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
				foreach($transactions as $transaction){
					$po_no = generate_po_no();
					updateStatus3($cart_group,$transaction["seller_user_id"],$po_no,true);
				}
				if(!$failedUpdatingTransactions){
					sendMailPaymentVerified($cart_group,true);
					$_SESSION["message"] = "Anda sudah selesai melakukan pesanan, Mohon tunggu pengantaran barang ke tempat anda.";
				}
				javascript("window.location='index.php';");
			}
			exit();
		} else {
			$db->addtable("transactions");  
			$db->where("cart_group",$cart_group);
			$db->addfield("invoice_no");	$db->addvalue("");
			$db->addfield("invoice_at");	$db->addvalue("0000-00-00");
			$db->addfield("status");        $db->addvalue("0");
			$db->update();
			$_SESSION["errormessage"] = v("finalization_of_purchases_failed");
		}
	}
	
	if(isset($_POST["addaddress"]) && isset($_POST["save_address"])){
		
		$user_addresses_id = $db->fetch_single_data("user_addresses","id",["user_id" => $__user_id]);
		$db->addtable("user_addresses");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["address"]);
		$db->addfield("location_id");		$db->addvalue($_POST["subdistrict_id"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$user_address_id = $inserting["insert_id"];
			$_SESSION["message"] = v("address_saved_successfully");
			javascript("window.location='?user_address_id=".$user_address_id."';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_address");
		}
	}
	
?>
<script>
	var total_shipping_charges = 0;
	var seller_ids = "";
	var numbers_is_valid = true;
	var is_cod_coverage = true;
	var cod_coverage = [];
	var is_markoantar = false;
	var using_markoantar = [];
	var is_only_pasar = false;
	var total_weight = 0;
	var flat_rates_markoantar = 0;
	
	function change_address(user_address_id){
		$("#total_bill").html("<img src='images/fancybox_loading.gif'>");
		$("#total_price").html("<img src='images/fancybox_loading.gif'>");
		$("#total_shipping_charges").html("<img src='images/fancybox_loading.gif'>");
		$("#div_delivery_destination").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=getAddress&user_address_id="+user_address_id, function(returnval){
			$("#div_delivery_destination").html(returnval);
			var arr_seller_id = seller_ids.split(",");
			for(xx=0;xx<arr_seller_id.length;xx++){
				seller__id = arr_seller_id[xx];
				$("#hide_sub_total_"+seller__id).val("0");
				load_courier_services(seller__id,user_address_id,$("#delivery_courier_"+seller__id).val());
			}
		});
	}
	
	function addaddress(){
		$.get( "ajax/profiles.php?mode=addaddress", function(modalBody) {
			modalFooter = "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button>";
			$('#modalTitle').html("");
			$('#modalTitle').parent().css( "display", "none" );
			$('#modalBody').html(modalBody);
			$('#modalFooter').html(modalFooter);
			$('#myModal').modal('show');
		});
	}
	
	function load_calculation(){
		var seller__id = 0;
		var total_bill = 0;
		var total_price = 0;
		var total_shipping_charges = 0;
		var shipping_charges = "";
		var arr_seller_id = seller_ids.split(",");
		var all_loaded = true;
		numbers_is_valid = true;
		for(xx=0;xx<arr_seller_id.length;xx++){
			seller__id = arr_seller_id[xx];
			if($("#hide_sub_total_"+seller__id).val() <= 0) {all_loaded = false;}
		}
		if(all_loaded){
			for(xx=0;xx<arr_seller_id.length;xx++){
				seller__id = arr_seller_id[xx];
				if(document.getElementById("self_pickup_"+seller__id).checked){
					$("#hide_shipping_charges_"+seller__id).val("<?=$__self_pickup_fee;?>");
					$("#hide_sub_total_"+seller__id).val(($("#hide_subtotal_"+seller__id).val() * 1) + <?=$__self_pickup_fee;?>);
					$("#div_pickup_distance_estimation_"+seller__id).html("<img src='images/fancybox_loading.gif'>");
					$.get("ajax/transaction.php?mode=distance_estimation&seller_id="+seller__id+"&buyer_address_id="+$("#user_address").val(), function(returnval){
						returnval = returnval.split("|||");
						$("#div_pickup_distance_estimation_"+returnval[0]).html(returnval[1]);
					});
				} else {
					shipping_charges = $("#hide_shipping_charges_"+seller__id).val() * 1;
					if(isNaN(shipping_charges)) shipping_charges = 0;
					$("#hide_sub_total_"+seller__id).val(($("#hide_subtotal_"+seller__id).val() * 1) + shipping_charges);
				}
				if(isNaN($("#hide_shipping_charges_"+seller__id).val() * 1)) $("#hide_shipping_charges_"+seller__id).val(0);
				total_shipping_charges += ($("#hide_shipping_charges_"+seller__id).val() * 1);
				total_price += $("#hide_subtotal_"+seller__id).val() * 1;
				total_bill += ($("#hide_sub_total_"+seller__id).val() * 1);
				$("#div_sub_total_"+seller__id).html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(($("#hide_subtotal_"+seller__id).val() * 1) + ($("#hide_shipping_charges_"+seller__id).val() * 1)));
			}
			if(total_bill <= 0) numbers_is_valid = false;
			if(total_price <= 0) numbers_is_valid = false;
			if(total_shipping_charges <= 0){
				if(is_only_pasar && is_markoantar){
					total_shipping_charges += flat_rates_markoantar;
					total_bill = (total_price * 1) + (flat_rates_markoantar * 1);
				} else {
					numbers_is_valid = false;
				}
			}
			$("#total_bill").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_bill));
			$("#total_price").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_price));
			$("#total_shipping_charges").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_shipping_charges));
			
			is_cod_coverage = true;
			for(xx=0;xx<arr_seller_id.length;xx++){
				seller__id = arr_seller_id[xx];
				$.get("ajax/transaction.php?mode=distance_estimation&seller_id="+seller__id+"&buyer_address_id="+$("#user_address").val(), function(returnval){
					returnval = returnval.split("|||");
					if((returnval[2] * 1 / 1000) > <?=($__cod_max_km + $__cod_tolerance_km);?>){
						is_cod_coverage = false;
						cod_coverage[returnval[0]] = false;
					} else {
						cod_coverage[returnval[0]] = true;
					}
				});
			}
		}
	}
	
	function load_courier_services(seller_id,buyer_address_id,courier){
		$("#div_courier_services_"+seller_id).html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadCourierServices&seller_id="+seller_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier, function(returnval){
			$("#div_courier_services_"+seller_id).html(returnval);
			load_shipping_charges(seller_id,buyer_address_id,courier,$("#courier_service_"+seller_id).val());
		});
	}
	
	function load_shipping_charges(seller_id,buyer_address_id,courier,courier_service){
		$("#div_shipping_charges_"+seller_id).html("<img src='images/fancybox_loading.gif'>");
		$("#div_sub_total_"+seller_id).html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadShippingCharges&seller_id="+seller_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier+"&courier_service="+courier_service, function(returnval){
			returnval = returnval.split("|||");
			$("#div_shipping_charges_"+seller_id).html(returnval[1]);
			$("#div_sub_total_"+seller_id).html(returnval[2]);
			
			$("#hide_shipping_charges_"+seller_id).val(returnval[3]);
			$("#hide_sub_total_"+seller_id).val(returnval[4]);
			load_calculation();
			if(returnval[5] == "flat_rates_markoantar"){
				using_markoantar[seller_id]=true;
				is_markoantar=true;
			}
		});
	}
	
	function self_pickup_change(elm,seller_id){
		if(elm.checked){
			$("#div_courier_area_"+seller_id).hide();
			$("#td_shipping_charges_"+seller_id).hide();
			$("#div_administration_fee_"+seller_id).show();
			load_calculation();
		} else {
			$("#div_courier_area_"+seller_id).show();
			$("#td_shipping_charges_"+seller_id).show();
			$("#div_administration_fee_"+seller_id).hide();
			load_shipping_charges(seller_id,$("#user_address").val(),$("#delivery_courier_"+seller_id).val(),$("#courier_service_"+seller_id).val());
		}
	}
	
	function btn_pay_click(){
		var arr_seller_id = seller_ids.split(",");
		var all_loaded = true;
		for(xx=0;xx<arr_seller_id.length;xx++){
			seller__id = arr_seller_id[xx];
			if($("#hide_sub_total_"+seller__id).val() <= 0) {all_loaded = false;}
		}
		if(all_loaded){
			var go_saving_process = true;
			var arr_seller_id = seller_ids.split(",");
			for(xx=0;xx<arr_seller_id.length;xx++){
				seller__id = arr_seller_id[xx];
				if(using_markoantar[seller__id]){ if(cod_coverage[seller__id] == false){ go_saving_process = false; } }
			}
			if(go_saving_process == false){
				toastr.warning("<?=str_replace("{cod_max_km}",$__cod_max_km,v("out_of_delivery_range"));?>","",toastroptions);
			} else {
				document.getElementById("pay").click();
			}
		}
	}
	
	function btn_cod_click(){
		if(is_cod_coverage == false){
			toastr.warning("<?=str_replace("{cod_max_km}",$__cod_max_km,v("out_of_delivery_range"));?>","",toastroptions);
		} else {
			if(confirm("<?=v("are_you_sure_pay_with_cod");?>")){
				document.getElementById("action_mode").value="cod";
				cart_form.submit();
			}
		}
	}
</script>
<form id="cart_form" role="form" method="POST" autocomplete="off" onsubmit="return numbers_is_valid;">	
	<input type="hidden" id="action_mode" name="action_mode">
	<div class="container">
		<div class="row">
			<div class="common_title"><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> &nbsp;<?=v("order");?></div>
			<table <?=$__tblDesign100;?>>
				<tr>
					<td valign="top" width="<?=(isMobile())?"100%":"70%";?>">
						<div style="font-size:1.2em;font-weight:bolder;margin-bottom:18px;padding-top:10px; position:relative; float:left;"><?=v("delivery_destination");?></div>
						<div style="font-size:1.2em;font-weight:bolder;margin-bottom:18px;padding-top:10px; position:relative; float:right;color:#800000;cursor:pointer;" onclick="addaddress();">
							+ <?=v("add_address");?>
						</div>
						<div style="height:45px;"></div>
						<div class="border_orange">
							<?php $user_addresses = $db->fetch_select_data("user_addresses","id","name",["user_id " => $__user_id]); ?>
							<div style="width:250px;position:relative;float:right;"> <?=$f->select("user_address",$user_addresses,$user_address_default,"onchange = 'change_address(this.value);'","form-control");?> </div>
							<div class="panel-body" style="margin-top:20px;" id="div_delivery_destination"></div>
							<script> change_address("<?=$user_address_default;?>"); </script>
						</div>
						<br>
						<?php
							$goods_ids = "";
							$seller_ids = "";
							$is_only_pasar = true;
							$TOTAL_WEIGHT = 0;
							$arr_pasar_category_ids = arr_pasar_category_ids();
							foreach($_trxBySeller as $seller_user_id => $transactions){
								$forwarder_ids = "";
								$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
								$seller_id = $seller["id"];
								$seller_ids .= $seller_id.",";
								if($db->fetch_single_data("seller_is_pasar","id",["seller_id" => $seller_id]) <= 0) $is_only_pasar = false;
								$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
								$_trxByGoods = [];
								$_trx_ids = [];
								foreach($transactions as $transaction){
									$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
									$_trxByGoods[$transaction_details["goods_id"]] = $transaction_details; 
									$_trx_ids[$transaction_details["goods_id"]] .= $transaction["id"].",";
								}
								?>
								<div class="border_orange">
									<table <?=$__tblDesign100;?>>
										<tr>
											<td valign="top">
												<div style="font-size:1.2em;font-weight:bolder;text-decoration:underline;text-decoration-color:#D6A266;"><?=v("seller");?> : <?=$seller["name"];?></div>
											</td>
										</tr>
									</table>
								<?php
								$_subtotal = 0;
								foreach($_trxByGoods as $goods_id => $transaction_details){
									$forwarder_ids .= $db->fetch_single_data("goods","forwarder_ids",["id" => $goods_id]);
									$goods_ids .= $goods_id.",";
									$transaction_ids = substr($_trx_ids[$goods_id],0,-1);
									$goods  = $db->fetch_all_data("goods",[],"id = '".$goods_id."'")[0];
									$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods_id."'","seqno")[0];
									if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
									$unit = $db->fetch_single_data("units","name_".$__locale,["id" => $transaction_details["unit_id"]]);
									$qty = $db->fetch_single_data("transaction_details","concat(sum(qty))",["transaction_id" => $transaction_ids.":IN","goods_id" => $goods_id]);
									$price = $transaction_details["gross"] + ($transaction_details["gross"] * $transaction_details["commission"] / 100);
									$subtotal = $price * $qty;
									$_subtotal += $subtotal;
									$total_price += $subtotal;
									$TOTAL_WEIGHT += ($qty * $transaction_details["weight"]);
									
						?>
									<div class="border_orange" style="box-shadow:none;margin-bottom:5px;">
										<table <?=$__tblDesign100;?>>
											<tr>
												<td width="90" valign="top"><img src="goods/<?=$goods_photos["filename"];?>" width="80" style="cursor:pointer;" onclick="window.location='product_detail.php?id=<?=$goods_id;?>';"></td>
												<td valign="top">
													<div style="font-size:1em;font-weight:bolder;text-decoration:underline;text-decoration-color:#D6A266;"><?=$goods["name"];?></div>
													<?=v("weight");?>&nbsp;&nbsp;&nbsp;<?=$goods["weight"]*$qty/1000;?>Kg
													&nbsp;&nbsp;&nbsp;
													<?=v("goods_qty");?>&nbsp;&nbsp;&nbsp;<?=$qty;?>
													<div style="font-size:1.4em;color:#800000;font-weight:bolder;margin-top:10px;" id="div_subtotal_<?=$goods_id;?>">Rp. <?=format_amount($subtotal);?></div>
												</td>
											</tr>
										</table>
									</div>
							<?php 
								}
								$forwarders = [];
								$forwarder_ids = str_replace(["||","|"],[",",""],$forwarder_ids);
								$_forwarders = $db->fetch_all_data("forwarders",[],"id IN ($forwarder_ids)","user_id DESC,id");
								$_marko_antar_exist = false;
								foreach($_forwarders as $_forwarder){
									if($_forwarder["user_id"]){
										if(!$_marko_antar_exist){
											$forwarders[$_forwarder["user_id"]] = "Marko Antar";
											$_marko_antar_exist = true;
										}
									} else {
										$forwarders[$_forwarder["rajaongkir_code"]] = $_forwarder["name"]." (".strtoupper($_forwarder["rajaongkir_code"]).")";
									}
								}
								$delivery_courier_area = "
										<div id=\"div_courier_area_".$seller_id."\">
											<div>
												<label>".v("delivery_courier")."</label>
												".$f->select("delivery_courier_".$seller_id,$forwarders,"","","form-control")."
											</div>
											<div>
												<label>".v("courier_service")."</label>
												<div id=\"div_courier_services_".$seller_id."\"></div>
											</div>
											<br>
										</div>
										<div>
											<label>".v("self_pickup")."</label>&nbsp;&nbsp;".$f->input("self_pickup_".$seller_id,1,"type='checkbox' onchange=\"self_pickup_change(this,".$seller_id.");\"")."
										</div>
										<script> 
											setTimeout(function(){ 
												load_courier_services(\"".$seller_id."\",$(\"#user_address\").val(),$(\"#delivery_courier_".$seller_id."\").val());
											}, 100); 
										</script>";
						?>
									<div class="border_orange" style="box-shadow:none;">
										<table <?=$__tblDesign100;?>>
											<tr><td colspan="2"><?=$delivery_courier_area;?></td></tr>
											<tr>
												<td colspan="2" style="padding-top:20px;" nowrap id="td_shipping_charges_<?=$seller_id;?>">
													<img src="assets/sent.png" width="40">&nbsp;&nbsp;&nbsp;<?=v("shipping_charges");?>	&nbsp;&nbsp;&nbsp;
													<a style="font-size:1.4em;color:#800000;font-weight:bolder;" id="div_shipping_charges_<?=$seller_id;?>"></a>
												</td>
												<td colspan="2" style="padding-top:20px;display:none;" nowrap id="div_administration_fee_<?=$seller_id;?>">
													<?=v("administration_fee");?>	&nbsp;&nbsp;&nbsp;
													<a style="font-size:1.4em;color:#800000;font-weight:bolder;" id="div_shipping_charges_<?=$seller_id;?>">Rp. 2.000</a><br>
													<?=v("goods_pickup_distance_estimation");?>	&nbsp;&nbsp;&nbsp;
													<a style="font-size:1.4em;color:#800000;font-weight:bolder;" id="div_pickup_distance_estimation_<?=$seller_id;?>"></a>
												</td>
											</tr>
										</table>
									</div>
								</div><br>
								<?=$f->input("hide_shipping_charges_".$seller_id,"0","type='hidden'");?>
								<?=$f->input("hide_subtotal_".$seller_id,$_subtotal,"type='hidden'");?>
								<?=$f->input("hide_sub_total_".$seller_id,"0","type='hidden'");?>
						<?php
							}
							$goods_ids = substr($goods_ids,0,-1);
							$seller_ids = substr($seller_ids,0,-1);
							$flat_rates_markoantar = $__marko_cod * ceil($TOTAL_WEIGHT/$__cod_max_gram);
							?><script> is_only_pasar = "<?=$is_only_pasar;?>";</script><?php
							?><script> goods_ids = "<?=$goods_ids;?>";</script><?php
							?><script> seller_ids = "<?=$seller_ids;?>";</script><?php
							?><script> total_weight = "<?=$TOTAL_WEIGHT;?>";</script><?php
							?><script> flat_rates_markoantar = "<?=$flat_rates_markoantar;?>";</script><?php
						?>
					</td>
					<?php
						$btn_cod = "";
						if($is_only_pasar) $btn_cod = "<div style=\"margin-top:10px;\">".$f->input("cod",v("cod"),"type='button' onclick='btn_cod_click();' style=\"width:165px;font-weight:bolder;\"","btn btn-success")."</div>";
						$shopping_summary = "
							<div style=\"font-size:1.2em;font-weight:bolder;margin-bottom:18px;padding-top:10px; text-align:center;\">".v("shopping_summary")."</div>
							<div class=\"border_orange\">
								<table width=\"95%\">
									<tr>
										<td style=\"font-size:1.2em;font-weight:bolder;\">".v("total_shopping")."</td>
										<td style=\"font-size:1.2em;color:#800000;width:1px;\" nowrap>Rp. </td>
										<td id=\"total_price\" style=\"font-size:1.2em;color:#800000;width:50px;\" nowrap align=\"right\"><img src='images/fancybox_loading.gif'></td>
									</tr>
									<tr>
										<td style=\"font-size:1.2em;font-weight:bolder;\">".v("total_shipping_charges")."</td>
										<td style=\"font-size:1.2em;color:#800000;width:1px;\" nowrap>Rp. </td>
										<td id=\"total_shipping_charges\" style=\"font-size:1.2em;color:#800000;width:50px;\" nowrap align=\"right\"><img src='images/fancybox_loading.gif'></td>
									</tr>
									<tr>
										<td style=\"font-size:1.2em;font-weight:bolder;\">".v("total_bill")."</td>
										<td style=\"font-size:1.2em;font-weight:bolder;color:#800000;width:1px;\" nowrap>Rp. </td>
										<td id=\"total_bill\" style=\"font-size:1.2em;font-weight:bolder;color:#800000;width:50px;\" nowrap align=\"right\"><img src='images/fancybox_loading.gif'></td>
									</tr>
								</table>
								<br>
								<table width=\"100%\"><tr>
									<td align=\"center\">
										<div style=\"height:10px;\"></div>
										".$f->input("btn_pay",v("bank_transfer"),"type='button' onclick='btn_pay_click();' style=\"width:165px;font-weight:bolder;\"","btn btn-primary").$btn_cod."
										".$f->input("pay",v("bank_transfer"),"type='submit' style=\"display:none;\"","btn btn-primary")."
									</td>
								</tr></table>
							</div>";
					?>
					<?php if(!isMobile()){ ?>
						<td style="width:10px;"></td>
						<td valign="top" width="28%"><?=$shopping_summary;?></td>
					<?php } ?>
				</tr>
			</table>
			<?php if(isMobile()){ ?>
				<?=$shopping_summary;?>
			<?php } ?>
		</div>
	</div>
</form>
<div style="height:40px;"></div>
<script>
	$(document).ready(function(){
		<?php
			$seller_ids = explode(",",$seller_ids);
			foreach($seller_ids as $seller__id){
		?>
				$("#delivery_courier_<?=$seller__id;?>").change(function(){
					load_courier_services(<?=$seller__id;?>,$("#user_address").val(),$("#delivery_courier_<?=$seller__id;?>").val());
				});
		<?php } ?>
	});
</script>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>