<?php include_once "header.php"; ?>
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
	
	if(isset($_POST["pay"])){
		$failedUpdatingTransactions = false;
		foreach($transactions as $transaction){
			$invoice_no = generate_invoice_no();
			$db->addtable("transactions");  
			$db->where("cart_group",$cart_group);
			$db->where("seller_user_id",$transaction["seller_user_id"]);
			$db->where("status","0");
			$db->addfield("invoice_no");	$db->addvalue($invoice_no);
			$db->addfield("invoice_at");	$db->addvalue($__now);
			$db->addfield("status");        $db->addvalue("1");
			$updating = $db->update();
			
			$transaction_id 			= $transaction["id"];
			$goods_id 					= $db->fetch_single_data("transaction_details","goods_id",["transaction_id" => $transaction_id]);
			$qty 						= $db->fetch_single_data("transaction_details","qty",["transaction_id" => $transaction_id]);
			$weight 					= $db->fetch_single_data("goods","weight",["id" => $goods_id]);
			$forwarder_id 				= $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $_POST["delivery_courier_".$goods_id]]);
			if($forwarder_id > 0){
				$forwarder_user_id 			= $db->fetch_single_data("forwarders","user_id",["rajaongkir_code" => $_POST["delivery_courier_".$goods_id]]);
				$name 						= $db->fetch_single_data("forwarders","name",["rajaongkir_code" => $_POST["delivery_courier_".$goods_id]]);
			} else {
				$forwarder_id 				= $db->fetch_single_data("forwarders","id",["user_id" => $_POST["delivery_courier_".$goods_id]]);
				$forwarder_user_id 			= $_POST["delivery_courier_".$goods_id];
				$name 						= $db->fetch_single_data("forwarders","name",["user_id" => $_POST["delivery_courier_".$goods_id]]);
			}
			$price 						= $_POST["hide_shipping_charges_".$goods_id];
			$total 						= $price;
			$user_address_id 			= $_POST["user_address"];
			$_user_address				= $db->fetch_all_data("user_addresses",[],"id='".$user_address_id."' AND user_id='".$__user_id."'")[0];
			$user_address_name 			= $_user_address["name"];
			$user_address_pic 			= $_user_address["pic"];
			$user_address_phone 		= $_user_address["phone"];
			$user_address 				= $_user_address["address"];
			$user_address_location_id 	= $_user_address["location_id"];
			$user_address_coordinate 	= $_user_address["coordinate"];
			$pickup_location_id = $db->fetch_single_data("goods","pickup_location_id",["id" => $goods_id]);
			if($pickup_location_id <= 0) $pickup_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $transaction["seller_user_id"]]);
			
			$db->addtable("transaction_forwarder");
			$db->addfield("transaction_id");		$db->addvalue($transaction_id);
			$db->addfield("forwarder_id");			$db->addvalue($forwarder_id);
			$db->addfield("forwarder_user_id");		$db->addvalue($forwarder_user_id);
			$db->addfield("name");					$db->addvalue($name);
			$db->addfield("courier_service");		$db->addvalue($_POST["courier_service_".$goods_id]);
			$db->addfield("pickup_location_id");	$db->addvalue($pickup_location_id);
			$db->addfield("user_address_id");		$db->addvalue($user_address_id);
			$db->addfield("user_address_name");		$db->addvalue($user_address_name);
			$db->addfield("user_address_pic");		$db->addvalue($user_address_pic);
			$db->addfield("user_address_phone");	$db->addvalue($user_address_phone);
			$db->addfield("user_address");			$db->addvalue($user_address);
			$db->addfield("user_address_location_id");$db->addvalue($user_address_location_id);
			$db->addfield("user_address_coordinate");$db->addvalue($user_address_coordinate);
			$db->addfield("weight");				$db->addvalue($weight);
			$db->addfield("qty");					$db->addvalue($qty);
			$db->addfield("price");					$db->addvalue($price);
			$db->addfield("total");					$db->addvalue($total);
			$inserting_transaction_forwarder = $db->insert();
			
		}
		if(!$failedUpdatingTransactions){
			$uniqcode = generate_uniqcode();
			$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."'");
            foreach($transactions as $transaction){
                $transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
                $transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];

                $total = $transaction_details["total"] + $transaction_forwarder["total"];
                $total_tagihan += $total;
            }
			
			$db->addtable("transaction_payments");
			$db->addfield("cart_group");		$db->addvalue($cart_group);
			$db->addfield("payment_type_id");	$db->addvalue("2");
			$db->addfield("name");          	$db->addvalue("Transfer Bank");
			$db->addfield("total");		        $db->addvalue($total_tagihan);
			$db->addfield("uniqcode");		    $db->addvalue($uniqcode);
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
				$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'");
				$seller_user_id = $transaction["seller_user_id"];
				$seller_email = $db->fetch_single_data("a_users","email",["id" => $seller_user_id]);
				$seller_name = $db->fetch_single_data("sellers","concat(pic,' - ',name)",["user_id" => $seller_user_id]);
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
					
					$arr1 = ["{seller_name}","{goods_name}","{qty}","{unit}"];
					$arr2 = [$seller_name,$goods_name,$transaction_detail["qty"],$unit];
					$body = read_file("html/email_reservasi_stok_id.html");
					$body = str_replace($arr1,$arr2,$body);
					sendingmail("Markopelago.com -- Reservasi Stok  ".$goods_name,$seller_email,$body,"system@markopelago.com|Markopelago System");
					
					$message = "Barang yang Anda jual, ".$goods_name." telah direservasi sebanyak ".$transaction_detail["qty"]." ".$unit.". Kami menunggu pembayaran customer untuk selanjutnya bisa anda kirim.";
					$db->addtable("notifications");
					$db->addfield("user_id");		$db->addvalue($seller_user_id);
					$db->addfield("message");		$db->addvalue($message);
					$inserting = $db->insert();
				}
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
			$arr1 = ["{last_transfer_day}","{last_transfer_at}","{order_detail}","{payment_info}"];
			$arr2 = [$email["last_transfer_day"],$email["last_transfer_at"],$order_detail,$payment_info];
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
	var goods_ids = "";
	var last_goods_id = "";
	var numbers_is_valid = true;
	
	function change_address(user_address_id){
		$("#total_bill").html("<img src='images/fancybox_loading.gif'>");
		$("#total_price").html("<img src='images/fancybox_loading.gif'>");
		$("#total_shipping_charges").html("<img src='images/fancybox_loading.gif'>");
		$("#div_delivery_destination").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=getAddress&user_address_id="+user_address_id, function(returnval){
			$("#div_delivery_destination").html(returnval);
			var arr_goods_id = goods_ids.split(",");
			for(xx=0;xx<arr_goods_id.length;xx++){
				goods__id = arr_goods_id[xx];
				$("#hide_sub_total_"+goods__id).val("0");
				load_courier_services(goods__id,user_address_id,$("#delivery_courier_"+goods__id).val(),$("#hide_qty_"+goods__id).val());
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
		var goods__id = 0;
		var total_bill = 0;
		var total_price = 0;
		var total_shipping_charges = 0;
		var arr_goods_id = goods_ids.split(",");
		var all_loaded = true;
		numbers_is_valid = true;
		for(xx=0;xx<arr_goods_id.length;xx++){
			goods__id = arr_goods_id[xx];
			if($("#hide_sub_total_"+goods__id).val() <= 0) {all_loaded = false;}
		}
		if(all_loaded){
			for(xx=0;xx<arr_goods_id.length;xx++){
				goods__id = arr_goods_id[xx];
				total_shipping_charges += ($("#hide_shipping_charges_"+goods__id).val() * 1);
				total_price += ($("#hide_sub_total_"+goods__id).val() * 1) - ($("#hide_shipping_charges_"+goods__id).val() * 1);
				total_bill += ($("#hide_sub_total_"+goods__id).val() * 1);
				
			}
			if(total_bill <= 0) numbers_is_valid = false;
			if(total_price <= 0) numbers_is_valid = false;
			if(total_shipping_charges <= 0) numbers_is_valid = false;
			$("#total_bill").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_bill));
			$("#total_price").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_price));
			$("#total_shipping_charges").html("&nbsp;&nbsp;&nbsp;"+new Intl.NumberFormat('id-ID').format(total_shipping_charges));
		}
	}
	
	function load_courier_services(goods_id,buyer_address_id,courier,qty){
		if((goods_id * 1) > 0 && (qty * 1) > 0){
			$("#div_courier_services_"+goods_id).html("<img src='images/fancybox_loading.gif'>");
			$.get("ajax/transaction.php?mode=loadCourierServices&goods_id="+goods_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier+"&qty="+qty, function(returnval){
				$("#div_courier_services_"+goods_id).html(returnval);
				load_shipping_charges(goods_id,buyer_address_id,courier,$("#courier_service_"+goods_id).val(),qty);
			});
		}
	}
	
	function load_shipping_charges(goods_id,buyer_address_id,courier,courier_service,qty){
		$("#div_shipping_charges_"+goods_id).html("<img src='images/fancybox_loading.gif'>");
		$("#div_sub_total_"+goods_id).html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadShippingCharges&goods_id="+goods_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier+"&courier_service="+courier_service+"&qty="+qty, function(returnval){
			returnval = returnval.split("|||");
			$("#div_shipping_charges_"+goods_id).html(returnval[1]);
			$("#div_sub_total_"+goods_id).html(returnval[2]);
			
			$("#hide_shipping_charges_"+goods_id).val(returnval[3]);
			$("#hide_sub_total_"+goods_id).val(returnval[4]);
			load_calculation();
		});
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
						<div style="font-size:1.2em;font-weight:bolder;margin-bottom:10px;padding-top:10px;"><?=v("courier_detail");?></div>
						<?php
							$goods_ids = "";
							foreach($_trxBySeller as $seller_user_id => $transactions){
								$seller = $db->fetch_all_data("sellers",[],"user_id = '".$seller_user_id."'")[0];
								$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
								$_trxByGoods = [];
								$_trx_ids = [];
								foreach($transactions as $transaction){
									$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
									$_trxByGoods[$transaction_details["goods_id"]] = $transaction_details; 
									$_trx_ids[$transaction_details["goods_id"]] .= $transaction["id"].",";
								}
								
								foreach($_trxByGoods as $goods_id => $transaction_details){
									$goods_ids .= $goods_id.",";
									$transaction_ids = substr($_trx_ids[$goods_id],0,-1);
									$goods  = $db->fetch_all_data("goods",[],"id = '".$goods_id."'")[0];
									$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods_id."'","seqno")[0];
									if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
									$unit = $db->fetch_single_data("units","name_".$__locale,["id" => $transaction_details["unit_id"]]);
									$qty = $db->fetch_single_data("transaction_details","concat(sum(qty))",["transaction_id" => $transaction_ids.":IN","goods_id" => $goods_id]);
									$price = $transaction_details["gross"] + ($transaction_details["gross"] * $transaction_details["commission"] / 100);
									$subtotal = $price * $qty;
									$total_price += $subtotal;
									
									$forwarder_ids = str_replace(["||","|"],[",",""],$db->fetch_single_data("goods","forwarder_ids",["id" => $goods_id]));
									$forwarders = $db->fetch_select_data("forwarders","concat(IF(rajaongkir_code <> '', rajaongkir_code, user_id)) as rajaongkir_id","concat(IF(rajaongkir_code <> '', concat(name,' (',upper(rajaongkir_code),')'), concat('Marko Antar (',name,')')))",["id" => $forwarder_ids.":IN"],["user_id DESC,id"]);
									$delivery_courier_area = "
											<div>
												<label>".v("delivery_courier")."</label>
												".$f->select("delivery_courier_".$goods_id,$forwarders,"","","form-control")."
											</div>
											<div>
												<label>".v("courier_service")."</label>
												<div id=\"div_courier_services_".$goods_id."\"></div>
											</div>
											<script> 
												setTimeout(function(){ 
													load_courier_services(\"".$goods_id."\",$(\"#user_address\").val(),$(\"#delivery_courier_".$goods_id."\").val(),\"".$qty."\");
												}, 100); 
											</script>";
						?>
							<?=$f->input("hide_shipping_charges_".$goods_id,"0","type='hidden'");?>
							<?=$f->input("hide_sub_total_".$goods_id,"0","type='hidden'");?>
							<?=$f->input("hide_qty_".$goods_id,$qty,"type='hidden'");?>
							<div class="border_orange" style="box-shadow:none;">
								<table <?=$__tblDesign100;?>>
									<tr>
										<td valign="top">
											<table <?=$__tblDesign100;?>>
												<tr>
													<td width="90" valign="top"><img src="goods/<?=$goods_photos["filename"];?>" width="80" style="cursor:pointer;" onclick="window.location='product_detail.php?id=<?=$goods_id;?>';"></td>
													<td valign="top">
														<div style="font-size:1em;font-weight:bolder;text-decoration:underline;text-decoration-color:#D6A266;"><?=v("seller");?> : <?=$seller["name"];?></div>
														<div style="font-size:1em;"><?=$goods["name"];?></div>
														<div style="font-size:1.4em;color:#800000;font-weight:bolder;margin-top:10px;">Rp. <?=format_amount($subtotal);?></div>
													</td>
												</tr>
												<tr>
													<td colspan="2" style="padding-top:10px;" nowrap>
														<?=v("weight");?>&nbsp;&nbsp;&nbsp;<?=$goods["weight"]*$qty/1000;?>Kg
														&nbsp;&nbsp;&nbsp;
														<?=v("goods_qty");?>&nbsp;&nbsp;&nbsp;<?=$qty;?>
													</td>
												</tr>
												<?php if(isMobile()){ ?>
													<tr><td colspan="2" style="padding-top:20px;"><?=$delivery_courier_area;?></td></tr>
												<?php } ?>
												<tr>
													<td colspan="2" style="padding-top:20px;" nowrap>
														<img src="assets/sent.png" width="40">&nbsp;&nbsp;&nbsp;<?=v("shipping_charges");?>	&nbsp;&nbsp;&nbsp;
														<a style="font-size:1.4em;color:#800000;font-weight:bolder;" id="div_shipping_charges_<?=$goods_id;?>"></a>
													</td>
												</tr>
											</table>
										</td>
										<?php if(!isMobile()){ ?>
										<td style="width:10px;"></td>
										<td valign="top" style="width:40%;"> <?=$delivery_courier_area;?> </td>
										<?php } ?>
									</tr>
								</table>
							</div>
							<div class="border_orange" style="position:relative;top:-1px;">
								<b>Subtotal</b>
								<div style="font-size:1.4em;color:#800000;font-weight:bolder;position:relative;float:right;" id="div_sub_total_<?=$goods_id;?>">Rp. 0</div>
							</div><br>
							<script> last_goods_id = "<?=$goods_id;?>";</script>
						<?php
								}
							}
							$goods_ids = substr($goods_ids,0,-1);
							?><script> goods_ids = "<?=$goods_ids;?>";</script><?php
						?>
					</td>
					<?php
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
										".$f->input("pay",v("pay"),"type='submit' style=\"width:165px;font-weight:bolder;\"","btn btn-primary")."
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
			$goods_ids = explode(",",$goods_ids);
			foreach($goods_ids as $goods__id){
		?>
				$("#delivery_courier_<?=$goods__id;?>").change(function(){
					load_courier_services(<?=$goods__id;?>,$("#user_address").val(),$("#delivery_courier_<?=$goods__id;?>").val(),$("#hide_qty_<?=$goods__id;?>").val());
				});
		<?php } ?>
	});
</script>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>