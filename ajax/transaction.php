<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	$user_address_id = $_GET["user_address_id"];
	if($mode == "getAddress"){
		$user_address = $db->fetch_all_data("user_addresses",[],"id = '".$user_address_id."' AND user_id = '".$__user_id."'")[0];
		if($user_address["id"] > 0){
			?>
				<h4><b><?=$user_address["pic"];?> (<?=$user_address["name"];?>)</b></h4>
				<?=$user_address["address"];?>
				<?=get_location($user_address["location_id"])["caption"];?>
				<?php if($user_address["phone"]){ ?>
				<br>
				<?=v("phone");?> : <?=$user_address["phone"];?>
				<?php } ?>
			<?php
		} else {
			echo "<div class='alert alert-warning'>".v("data_not_found")."</div>";
		}
	}
	
	if($mode == "loadCourierServices"){
		$seller_id = $_GET["seller_id"];
		$buyer_address_id = $_GET["buyer_address_id"];
		$courier = $_GET["courier"];
		$total_weight = 0;
		$is_markoantar = false;
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		$transaction_ids = "";
		$transactions = $db->fetch_all_data("transactions",["id"],"cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."'");
		foreach($transactions as $transaction){ $transaction_ids .= $transaction["id"].","; }
		$transaction_ids = substr($transaction_ids,0,-1);
		$is_pasar = $db->fetch_single_data("seller_is_pasar","id",["seller_id" => $seller_id]);
		$forwarder_id = $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $courier]);
		if($forwarder_id <= 0){
			$forwarder_id = $db->fetch_single_data("forwarders","id",["user_id" => $courier]);
			if($forwarder_id > 0) $is_markoantar = true;
		}
		$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (".$transaction_ids.")");
		foreach($transaction_details as $transaction_detail){ 
			$goods_id = $transaction_detail["goods_id"];
			$pickup_location_id = $db->fetch_single_data("goods","pickup_location_id",["id" => $goods_id]);
			if($pickup_location_id > 0) $pickup_location_ids[$pickup_location_id] = 1;
			$total_weight += ($db->fetch_single_data("goods","weight",["id" => $goods_id]) * $transaction_detail["qty"]);
		}
		if(count($pickup_location_ids) != 1 || $pickup_location_id <= 0) $pickup_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
		$seller_locations = get_location($pickup_location_id);
		
		$buyer_locations = get_location($db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]));
		$courier_services = array();
		
		if(!$is_markoantar){
			$origin = $ro->location_id($seller_locations[0]["name"],$seller_locations[1]["name"],$seller_locations[2]["name"]);
			$destination = $ro->location_id($buyer_locations[0]["name"],$buyer_locations[1]["name"],$buyer_locations[2]["name"]);
			$ro_cost = $ro->cost($origin,$destination,$total_weight,$courier);
			if($ro_cost["status"]["code"] == "400"){
				echo "<font color='red'>".$ro_cost["status"]["description"]."</font>";exit();
			} else {
				foreach($ro_cost["results"][0]["costs"] as $cost){
					$courier_services[$cost["service"]] = $cost["description"]." (".$cost["service"].")";
				}
			}
		} else {
			$courier_services = [];
			$forwarder_vehicles = $db->fetch_all_data("forwarder_vehicles",[],"user_id='".$courier."' AND max_load >= '".($total_weight/1000)."' AND is_active='1' AND is_available='1'");
			if($is_pasar){
				echo "<font color='green'>".str_replace(["{marko_cod}","{cod_max_gram}"],[format_amount($__marko_cod),$__cod_max_gram/1000],v("flat_rates_markoantar"))."</font>";
				exit();
			}else if(count($forwarder_vehicles)>0){
				foreach($forwarder_vehicles as $forwarder_vehicle){
					$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $forwarder_vehicle["vehicle_type_id"]]);
					$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $forwarder_vehicle["vehicle_brand_id"]]);
					$courier_services[$forwarder_vehicle["id"]] = $vehicle_type." ".$vehicle_brand." [".$forwarder_vehicle["nopol"]."] ( ".$forwarder_vehicle["max_load"]." Kg)";
				}
			} else{
				if(!$is_pasar) echo "<font color='red'>".v("no_courier_service_available")."</font>";
				else echo "<font color='green'>".str_replace(["{marko_cod}","{cod_max_gram}"],[format_amount($__marko_cod),$__cod_max_gram/1000],v("flat_rates_markoantar"))."</font>";
				exit();
			}
		}
		echo $f->select("courier_service_".$seller_id,$courier_services,"","","form-control");
		echo "<script>";
		echo "	$(\"#courier_service_".$seller_id."\").change(function(){";
		echo "		load_shipping_charges(".$seller_id.",$(\"#user_address\").val(),$(\"#delivery_courier_".$seller_id."\").val(),$(\"#courier_service_".$seller_id."\").val());";
		echo "	});";
		echo "</script>";
	}
	
	if($mode == "loadShippingCharges"){
		$seller_id = $_GET["seller_id"];
		$buyer_address_id = $_GET["buyer_address_id"];
		$courier = $_GET["courier"];
		$courier_service = $_GET["courier_service"];
		$is_markoantar = false;
		$total_weight = 0;
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		$transaction_ids = "";
		$transactions = $db->fetch_all_data("transactions",["id"],"cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."'");
		foreach($transactions as $transaction){ $transaction_ids .= $transaction["id"].","; }
		$transaction_ids = substr($transaction_ids,0,-1);
		$is_pasar = $db->fetch_single_data("seller_is_pasar","id",["seller_id" => $seller_id]);
		$forwarder_id = $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $courier]);
		if($forwarder_id <= 0){
			$forwarder_id = $db->fetch_single_data("forwarders","id",["user_id" => $courier]);
			if($forwarder_id > 0) $is_markoantar = true;
		}
		
		$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (".$transaction_ids.")");
		foreach($transaction_details as $transaction_detail){ 
			$goods_id = $transaction_detail["goods_id"];
			$pickup_location_id = $db->fetch_single_data("goods","pickup_location_id",["id" => $goods_id]);
			if($pickup_location_id > 0) $pickup_location_ids[$pickup_location_id] = 1;
			$total_weight += ($db->fetch_single_data("goods","weight",["id" => $goods_id]) * $transaction_detail["qty"]);
		}
		if(count($pickup_location_ids) != 1 || $pickup_location_id <= 0) $pickup_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
		$buyer_location_id = $db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]);
		$seller_locations = get_location($pickup_location_id);
		$buyer_locations = get_location($buyer_location_id);
		
		if(!$is_markoantar){
			$origin = $ro->location_id($seller_locations[0]["name"],$seller_locations[1]["name"],$seller_locations[2]["name"]);
			$destination = $ro->location_id($buyer_locations[0]["name"],$buyer_locations[1]["name"],$buyer_locations[2]["name"]);
			foreach($ro->cost($origin,$destination,$total_weight,$courier)["results"][0]["costs"] as $cost){
				if(strtolower($cost["service"]) == strtolower($courier_service)){
					$shippingcharges = $cost["cost"][0]["value"];
					break;
				}
			}
		} else {
			$shippingcharges = $db->fetch_single_data("forwarder_routes","price",["user_id" => $courier,"vehicle_id" => $courier_service,"source_location_id" => $pickup_location_id,"destination_location_id" => $buyer_location_id]);
		}
		
		$subtotal = 0;
		$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (".$transaction_ids.")");
		foreach($transaction_details as $transaction_detail){
			$goods_id = $transaction_detail["goods_id"];
			$qty = $transaction_detail["qty"];
			$price = get_goods_price($goods_id,$qty)["display_price"];
			$subtotal += ($price * $qty);
		}
		
		
		if($shippingcharges > 0){
			$total = $subtotal + $shippingcharges;
			echo " x Rp. ".format_amount($price)." = Rp. ".format_amount($subtotal)."|||Rp. ".format_amount($shippingcharges)."|||Rp. ".format_amount($total)."|||".$shippingcharges."|||".$total;
		} else {
			$no_shippingcharges_desc = v("no_shippingcharges_desc");
			if($is_pasar && $is_markoantar){
				$no_shippingcharges_desc = str_replace(["{marko_cod}","{cod_max_gram}"],[format_amount($__marko_cod),$__cod_max_gram/1000],v("flat_rates_markoantar"));
				$flat_rates_markoantar = "flat_rates_markoantar";
			}
			$total = $subtotal + $__marko_cod;
			echo " x Rp. ".format_amount($price)." = Rp. ".format_amount($subtotal)."|||<p style='font-size:0.8em;'>".$no_shippingcharges_desc."</p>|||Rp. ".format_amount($total)."|||".$__marko_cod."|||".$total."|||".$flat_rates_markoantar;
		}
	}
	
	if($mode == "loadBankAccounts"){
		$bank_account_id = $_GET["bank_account_id"];
		$bank_account = $db->fetch_all_data("bank_accounts",[],"id = '".$bank_account_id."'")[0];
		$bank_code = $db->fetch_single_data("banks","code",["id" => $bank_account["bank_id"]]);
		$bank_name = $db->fetch_single_data("banks","name",["id" => $bank_account["bank_id"]]);
		$bank_name .= " (Kode Bank ".numberpad($bank_code,3).")";
		echo $bank_name."<br><b>No Rekening: ".$bank_account["account_no"]."</b><br>a/n: ".$bank_account["account_name"];
	}
	
	if($mode == "loadUserBank"){
		$user_bank_id = $_GET["user_bank_id"];
		$user_bank = $db->fetch_all_data("user_banks",[],"id = '".$user_bank_id."'")[0];
		echo $user_bank["bank_id"]."|||".$user_bank["name"]."|||".$user_bank["account_no"]."|||";
	}

	if($mode == "loadShoppingProgress"){
		$return = "";
		$transaction_id = $_GET["transaction_id"];
		$transaction = $db->fetch_all_data("transactions",[],"id='".$transaction_id."'")[0];
		$seller_name = $db->fetch_single_data("sellers","name",["user_id" => $transaction["seller_user_id"]]);
		$cart_group = $transaction["cart_group"];
		$payment_type_id = $db->fetch_single_data("transaction_payments","payment_type_id",["cart_group" => $cart_group]);
		$seller_id = $db->fetch_single_data("sellers","id",["user_id" => $transaction["seller_user_id"]]);
		$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(1).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["transaction_at"],"dMY",true)."</div></div>";
		if($transaction["po_at"] != "0000-00-00"){
			if($payment_type_id == "-1")							$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(-3).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["po_at"],"dMY",true)."</div></div>";
			else													$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(3).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["po_at"],"dMY",true)."</div></div>";
		}
		if($transaction["process_at"] != "0000-00-00 00:00:00") 	$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(4).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["process_at"],"dMY",true)."</div></div>";
		if($transaction["sent_at"] != "0000-00-00 00:00:00") {
			$receipt_no = $db->fetch_single_data("transaction_forwarder","receipt_no",["transaction_id" => $transaction_id]);
			$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(5).":<br>";
			$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE invoice_no='".$transaction["invoice_no"]."')");
			if(count($transaction_forwarders) <= 0) $transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"cart_group = '".$cart_group."' AND seller_id = '".$seller_id."'");

			$receipts = array();
			$receipts_forwarder_user_id = array();
			$receipts_transaction_forwarder_id = array();
			$receipts_courier = array();
			foreach($transaction_forwarders as $transaction_forwarder){
				if($transaction_forwarder["receipt_no"] != ""){
					$receipts[$transaction_forwarder["receipt_no"]] = $transaction_forwarder["receipt_at"];
					$receipts_forwarder_user_id[$transaction_forwarder["receipt_no"]] = $transaction_forwarder["forwarder_user_id"];
					$receipts_transaction_forwarder_id[$transaction_forwarder["receipt_no"]] = $transaction_forwarder["id"];
					if($transaction_forwarder["forwarder_user_id"] == 0)
						$receipts_courier[$transaction_forwarder["receipt_no"]] = $db->fetch_single_data("forwarders","rajaongkir_code",["id" => $transaction_forwarder["forwarder_id"]]);
					
				}
			}
			foreach($receipts as $receipt_no => $receipt_at){
				if($receipts_forwarder_user_id[$receipt_no] == 0){
					$trackers = $ro->waybill($receipts_courier[$receipt_no],$receipt_no);
					$return .= "<div>&nbsp;&nbsp;&nbsp;".v("receipt_number")." <b>".$receipt_no."</b>";
					if(count($trackers["result"]["manifest"]) <= 0) $return .= " : ".format_tanggal($receipt_at,"dMY",true);
					$return .= "</div>";
					if(count($trackers["result"]["manifest"]) > 0){
						$return .= "</div>";
						$return .= "<div class='panel-body'><b>TRACK SHIPMENT:</b>";
						foreach($trackers["result"]["manifest"] as $manifest){
							$return .= "<br><br>".$manifest["manifest_description"];
							$return .= "<br>&nbsp;&nbsp;&nbsp;".format_tanggal($manifest["manifest_date"]." ".$manifest["manifest_time"] ,"dMY",true);
						}
					}
				} else {
					$return .= "&nbsp;&nbsp;&nbsp;".v("receipt_number")." <b>".$receipt_no."</b>";
					$return .= "</div>";
					$return .= "<div class='panel-body'><b>TRACK SHIPMENT:</b>";
					$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"id = '".$receipts_transaction_forwarder_id[$receipt_no]."'")[0];
					for($xx=1;$xx < 5;$xx++){
						if($transaction_forwarder["markoantar_status".$xx."_at"] != "0000-00-00 00:00:00") {
							$return .= "<br><br>".markoantar_status($xx);
							$return .= "<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction_forwarder["markoantar_status".$xx."_at"] ,"dMY",true);
						}
					}
				}
			}
			$return .= "</div></div>";
		}
		if($transaction["delivered_at"] != "0000-00-00 00:00:00") 	$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(6).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["delivered_at"],"dMY",true)."</div></div>";
		if($transaction["done_at"] != "0000-00-00 00:00:00") 		$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(7).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["done_at"],"dMY",true)."</div></div>";
		echo v("shopping_progress")." -- ".$seller_name."|||";
		echo "<div class=\"form-group\">";
		echo $return;
		echo "</div>|||";
		echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">".v("close")."</button>";
	}
	
	if($mode == "add_to_cart"){
		$goods_id = $_GET["goods_id"];
		$qty = $_GET["goods_qty"];
		if($qty < 0) $qty = 1;
		$notes = $_GET["notes_for_seller"];
		
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id" => $__user_id,"status" => 0]);
		if($cart_group == "") $cart_group = date("Ymdhis").numberpad($__user_id,6);
		
		$seller_id = $db->fetch_single_data("goods","seller_id",["id" => $goods_id]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		
		$db->addtable("transactions");
		$db->addfield("cart_group");		$db->addvalue($cart_group);
		$db->addfield("seller_user_id");	$db->addvalue($seller_user_id);
		$db->addfield("buyer_user_id");		$db->addvalue($__user_id);
		$db->addfield("transaction_at");	$db->addvalue($__now);
		$db->addfield("status");			$db->addvalue(0);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$transaction_id = $inserting["insert_id"];
			$unit_id = $db->fetch_single_data("goods","unit_id",["id" => $goods_id]);
			$goods_price = get_goods_price($goods_id,$qty);
			$gross = $goods_price["price"];
			$commission = $goods_price["commission"];
			$price = $goods_price["display_price"];
			$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
			$total = $price * $qty;
			
			$db->addtable("transaction_details");
			$db->addfield("transaction_id");		$db->addvalue($transaction_id);
			$db->addfield("goods_id");				$db->addvalue($goods_id);
			$db->addfield("qty");					$db->addvalue($qty);
			$db->addfield("unit_id");				$db->addvalue($unit_id);
			$db->addfield("gross");					$db->addvalue($gross);
			$db->addfield("commission");			$db->addvalue($commission);
			$db->addfield("price");					$db->addvalue($price);
			$db->addfield("total");					$db->addvalue($total);
			$db->addfield("weight");				$db->addvalue($weight);
			$db->addfield("notes");					$db->addvalue($notes);
			$inserting_transaction_details = $db->insert();
			
			if($inserting_transaction_details["affected_rows"] > 0){
				$_SESSION["message"] = v("success_add_to_cart");
			} else {
				$db->addtable("transactions"); $db->where("id",$transaction_id);$db->delete_();
				$db->addtable("transaction_details"); $db->where("transaction_id",$transaction_id);$db->delete_();
				$db->addtable("transaction_forwarder"); $db->where("transaction_id",$transaction_id);$db->delete_();
				$_SESSION["errormessage"] = v("failed_transaction");
			}
		} else {
			$_SESSION["errormessage"] = v("failed_transaction");
		}
		echo "done";
	}
	
	if($mode == "cart_calculate"){
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]);
		$goods_id = $_GET["goods_id"];
		$qty = $_GET["qty"];
		if($qty < 0) $qty = 1;
		$transactions = $db->fetch_all_data("transactions",[],"cart_group = '".$cart_group."' AND id IN (SELECT transaction_id FROM transaction_details WHERE goods_id='".$goods_id."')");
		$transaction_id1 = $transactions[0]["id"];
		$transaction_id2 = $transactions[count($transactions)-1]["id"];
		$notes = $db->fetch_single_data("transaction_details","notes",["transaction_id" => $transaction_id2]);
		$transaction_ids = "";
		foreach($transactions as $key => $transaction){ if($transaction["id"] != $transaction_id1) $transaction_ids .= $transaction["id"].","; }
		$transaction_ids = substr($transaction_ids,0,-1);
		
		$unit_id = $db->fetch_single_data("goods","unit_id",["id" => $goods_id]);
		$goods_price = get_goods_price($goods_id,$qty);
		$gross = $goods_price["price"];
		$commission = $goods_price["commission"];
		$price = $goods_price["display_price"];
		$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
		$total = $price * $qty;
		
		$db->addtable("transaction_details");	$db->where("transaction_id",$transaction_id1);
		$db->addfield("qty");					$db->addvalue($qty);
		$db->addfield("unit_id");				$db->addvalue($unit_id);
		$db->addfield("gross");					$db->addvalue($gross);
		$db->addfield("commission");			$db->addvalue($commission);
		$db->addfield("price");					$db->addvalue($price);
		$db->addfield("total");					$db->addvalue($total);
		$db->addfield("weight");				$db->addvalue($weight);
		$db->addfield("notes");					$db->addvalue($notes);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			if($transaction_ids != ""){
				$db->addtable("transaction_details"); $db->where("transaction_id",$transaction_ids,"s","IN"); $db->delete_();
				$db->addtable("transactions"); $db->where("id",$transaction_ids,"s","IN"); $db->delete_();
			}
		}
		$trx = $db->fetch_all_data("transaction_details",[],"transaction_id = '".$transaction_id1."'")[0];
		$total = $db->fetch_single_data("transaction_details","concat(sum(total))",["transaction_id" => "(SELECT id FROM transactions WHERE cart_group='".$cart_group."'):IN"]);
		echo "Rp. ".format_amount($trx["price"])."|||Rp. ".format_amount($trx["total"])."|||".$trx["weight"]."g|||".$trx["notes"]."|||Rp. ".format_amount($total)."|||";
	}

    if($mode == "calculate"){
		$goods_id = $_GET["goods_id"];
		$qty = $_GET["qty"];
		if($qty <= 0) $qty = 1;
        $goods_price = get_goods_price($goods_id,$qty);
		$gross = $goods_price["price"];
		$commission = $goods_price["commission"];
		$price = $goods_price["display_price"];
		$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
		$total = $price * $qty;
		echo "Rp. ".format_amount($total);
	}
	
	if($mode == "distance_estimation"){
		$seller_id = $_GET["seller_id"];
		$buyer_address_id = $_GET["buyer_address_id"];
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		$transaction_ids = "";
		$transactions = $db->fetch_all_data("transactions",["id"],"cart_group = '".$cart_group."' AND seller_user_id='".$seller_user_id."'");
		foreach($transactions as $transaction){ $transaction_ids .= $transaction["id"].","; }
		$transaction_ids = substr($transaction_ids,0,-1);
		$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (".$transaction_ids.")");
		foreach($transaction_details as $transaction_detail){
			$goods_id = $transaction_detail["goods_id"];
			$pickup_location_id = $db->fetch_single_data("goods","pickup_location_id",["id" => $goods_id]);
			if($pickup_location_id > 0) $pickup_location_ids[$pickup_location_id] = 1;
		}
		if(count($pickup_location_ids) != 1 || $pickup_location_id <= 0) $pickup_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]);
		$seller_locations = get_location($pickup_location_id);
		$buyer_locations = get_location($db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id]));
		$origins = $seller_locations[0]["name"].", ".$seller_locations[1]["name"].", ".$seller_locations[2]["name"].", ".$seller_locations[3]["name"];
		$destinations = $buyer_locations[0]["name"].", ".$buyer_locations[1]["name"].", ".$buyer_locations[2]["name"].", ".$buyer_locations[3]["name"];
		$distance = google_distancematrix($origins,$destinations)[0]["elements"][0]["distance"]["value"];
		if($distance > 0 || ($distance == 0 && $origins == $destinations)){
			echo $seller_id."|||".round($distance/1000,2)." Km|||".$distance;
		} else {
			// echo $seller_id."|||".round(($__cod_max_km + $__cod_tolerance_km + 1),2)." Km|||".(($__cod_max_km + $__cod_tolerance_km + 1) * 1000);
			echo $seller_id."|||".round(($__cod_max_km + $__cod_tolerance_km - 1),2)." Km|||".(($__cod_max_km + $__cod_tolerance_km - 1) * 1000);
		}
	}
	
	if($mode == "cartcount"){
		echo count($db->fetch_all_data("transactions",[],"buyer_user_id='".$__user_id."' AND status=0"));
	}

	if($mode == "pick_markoantar_form"){
		$forwarder_ids = "|27||30||31||32|";
		$transaction_id = $_GET["transaction_id"];
		$po_no = $db->fetch_single_data("transactions","po_no",["id" => $transaction_id]);
		$transaction_details = $db->fetch_all_data("transaction_details",["goods_id"],"transaction_id = '".$transaction_id."'");
		foreach($transaction_details as $transaction_detail){
			$goods_id = $transaction_detail["goods_id"];
			$forwarder_ids .= $db->fetch_single_data("goods","forwarder_ids",["id" => $goods_id]);
		}
		$forwarder_ids = array_unique(pipetoarray($forwarder_ids));
		$forwarders = [];
		foreach($forwarder_ids as $forwarder_id){ $forwarders[$forwarder_id] = $db->fetch_single_data("forwarders","name",["id" => $forwarder_id]); }
		$forwarders = array_filter($forwarders);
		echo "<form method='GET'>";
		echo "	".$f->input("po_no",$po_no,"type='hidden'");
		echo "	".$f->input("changeStatus","5","type='hidden'");
		echo "	".$f->input("transaction_id",$transaction_id,"type='hidden'");
		echo "	<div class='panel panel-info'>";
		echo "		<div class='panel-heading'>".v("please_select_markoantar").":</div>";
		echo "		<div class='panel-body'>";
		echo "			<div class='form-group'>";
		echo "				".$f->select("forwarder_id",$forwarders,"","","form-control");
		echo "			</div>";
		echo "			<div class='form-group'>";
		echo "				".$f->input("save",v("save"),"type='submit'","btn btn-primary");
		echo "			</div>";
		echo "		</div>";
		echo "	</div>";
		echo "</form>";
	}
	
	if($mode == "reviewForm"){
		echo "
			<script>
				function change_star_level(transaction_id,level){
					document.getElementById(\"review_level[\"+transaction_id+\"]\").value = level;
					for(var ii = 1 ; ii <= 5 ; ii++){		document.getElementById(\"star_\"+transaction_id+\"_\"+ii+\"\").src = \"assets/unstar.png\"; }
					for(var ii = 1 ; ii <= level ; ii++){ 	document.getElementById(\"star_\"+transaction_id+\"_\"+ii+\"\").src = \"assets/star.png\"; }
				}
			</script>
		";
		$transaction_ids = $_GET["transaction_ids"];
		$transactions = $db->fetch_all_data("transactions",[],"id IN (".$transaction_ids.")");
		$star_width = 20;
		$goods_photos_width = 120;
		if(isMobile()) $goods_photos_width = 70;
		foreach($transactions as $transaction){
			$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
		}
		echo "<form method=\"POST\" id=\"form_review\">";
		echo $f->input("saving_review",1,"type='hidden'");
		foreach($_trxBySeller as $seller_user_id => $transactions){
			echo "<table class=\"table table-bordered\" width=\"100%\">";
			foreach($transactions as $transaction){
				if($transaction["buyer_user_id"] == $__user_id){
					$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
					$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
					$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
					echo $f->input("review_level[".$transaction["id"]."]",$transaction_details["review_level"],"type='hidden'");
					echo "<tr><td colspan='2'><b>".$goods["name"]."</b></td></tr>";
					echo "<tr>";
					echo "	<td width='1'><img src=\"goods/".$goods_photos["filename"]."\" style=\"width:".$goods_photos_width."px;\"></td>";
					echo "	<td nowrap>";
					for($ii = 0; $ii < 5 ;$ii++){
						$level = $ii + 1;
						if($level <= $transaction_details["review_level"]) $star_file_image = "star";
						else $star_file_image = "unstar";
						echo "<img id=\"star_".$transaction["id"]."_".$level."\" src=\"assets/".$star_file_image.".png\" onclick=\"change_star_level('".$transaction["id"]."','".$level."');\" style=\"width:".$star_width."px;\">&nbsp;&nbsp;";
					}
					echo "		<br><br>";
					echo $f->textarea("review_description[".$transaction["id"]."]",$transaction_details["review_description"],"style=\"width:100%;height:80px !important;\"");
					echo "	</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
		}
		echo "</form>";
	}
	
	if($mode == "showReview"){
		$transaction_ids = $_GET["transaction_ids"];
		$transactions = $db->fetch_all_data("transactions",[],"id IN (".$transaction_ids.")");
		$star_width = 20;
		$goods_photos_width = 120;
		if(isMobile()) $goods_photos_width = 70;
		foreach($transactions as $transaction){
			$_trxBySeller[$transaction["seller_user_id"]][] = $transaction;
		}
		foreach($_trxBySeller as $seller_user_id => $transactions){
			echo "<table class=\"table table-bordered\" width=\"100%\">";
			foreach($transactions as $transaction){
				if($transaction["seller_user_id"] == $__user_id || $transaction["buyer_user_id"] == $__user_id){
					$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
					$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
					$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
					echo "<tr><td colspan='2'><b>".$goods["name"]."</b></td></tr>";
					echo "<tr>";
					echo "	<td width='1'><img src=\"goods/".$goods_photos["filename"]."\" style=\"width:".$goods_photos_width."px;\"></td>";
					echo "	<td nowrap>";
					for($ii = 0; $ii < 5 ;$ii++){
						$level = $ii + 1;
						if($level <= $transaction_details["review_level"]) $star_file_image = "star";
						else $star_file_image = "unstar";
						echo "<img id=\"star_".$transaction["id"]."_".$level."\" src=\"assets/".$star_file_image.".png\" style=\"width:".$star_width."px;\">&nbsp;&nbsp;";
					}
					echo "		<br><br>";
					echo "<pre>".$transaction_details["review_description"]."</pre>";
					echo "	</td>";
					echo "</tr>";
					if($transaction["seller_user_id"] == $__user_id){
						$db->addtable("transaction_details");	$db->where("id",$transaction_details["id"]);
						$db->addfield("review_id_read");		$db->addvalue("1");
						$db->addfield("review_read_at");		$db->addvalue($__now);
						$db->update();
					}
				}
			}
			echo "</table>";
		}
	}
	
	if($mode == "is_user_confirmed"){
		// if($__user["email_confirmed_at"] != "0000-00-00 00:00:00" || $__user["phone_confirmed_at"] != "0000-00-00 00:00:00") echo true;
		// else echo false;
		echo true;
	}
	
	if($mode == "shopping_calculator"){
		$cart_group = $db->fetch_single_data("transactions","cart_group",["buyer_user_id"=>$__user_id,"status" => "0"]);
		$total_items = $db->fetch_single_data("transaction_details","concat(count(0)) as total_items",["transaction_id" => "SELECT id FROM transactions WHERE buyer_user_id='".$__user_id."' AND cart_group='".$cart_group."':IN"]) * 1;
		$total_qty = $db->fetch_single_data("transaction_details","concat(sum(qty)) as total_items",["transaction_id" => "SELECT id FROM transactions WHERE buyer_user_id='".$__user_id."' AND cart_group='".$cart_group."':IN"]) * 1;
		$total_weight = $db->fetch_single_data("transaction_details","concat(sum(qty*weight)) as total_items",["transaction_id" => "SELECT id FROM transactions WHERE buyer_user_id='".$__user_id."' AND cart_group='".$cart_group."':IN"]) * 1;
		$total_shopping = $db->fetch_single_data("transaction_details","concat(sum(total)) as total_items",["transaction_id" => "SELECT id FROM transactions WHERE buyer_user_id='".$__user_id."' AND cart_group='".$cart_group."':IN"]) * 1;
		
		$return = v("shopping_calculator")."|||";
		$return .= "<table width='100%'>";
		$return .= "	<tr>";
		$return .= "		<td class='trx-value-text'><b>".v("total_items")."</b></td>";
		$return .= "		<td align='right'><b>".$total_items."</b></td>";
		$return .= "	</tr>";
		$return .= "	<tr>";
		$return .= "		<td class='trx-value-text'><b>".v("total_qty")."</b></td>";
		$return .= "		<td align='right'><b>".$total_qty."</b></td>";
		$return .= "	</tr>";
		$return .= "	<tr>";
		$return .= "		<td class='trx-value-text'><b>".v("total_weight")."</b></td>";
		$return .= "		<td align='right'><b>".($total_weight/1000)." Kg</b></td>";
		$return .= "	</tr>";
		$return .= "		<td class='trx-value-text'><b>".v("total_shopping")."</b></td>";
		$return .= "		<td align='right'><b>Rp. ".format_amount($total_shopping)."</b></td>";
		$return .= "	</tr>";
		$return .= "</table>";
		$return .= "|||<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">".v("close")."</button>";
		echo $return;
	}
?>