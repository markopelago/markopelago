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
		$goods_id = $_GET["goods_id"];
		$buyer_address_id = $_GET["buyer_address_id"];
		$courier = $_GET["courier"];
		$qty = $_GET["qty"];
		$seller_id = $db->fetch_single_data("goods","seller_id",["id" => $goods_id]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id,"default_seller" => 1]));
		$origin = $ro->location_id($seller_locations[0]["name"],$seller_locations[1]["name"],$seller_locations[2]["name"]);
		
		$buyer_locations = get_location($db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]));
		$destination = $ro->location_id($buyer_locations[0]["name"],$buyer_locations[1]["name"],$buyer_locations[2]["name"]);
		$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
		$courier_services = array();
		$ro_cost = $ro->cost($origin,$destination,($weight*$qty),$courier);
		
		if($ro_cost["status"]["code"] == "400"){
			echo $ro_cost["status"]["description"];
		} else {
			foreach($ro_cost["results"][0]["costs"] as $cost){
				$courier_services[$cost["service"]] = $cost["description"]." (".$cost["service"].")";
			}
			echo $f->select("courier_service",$courier_services,"","onchange = 'load_calculation();'","form-control");			
		}
	}
	
	if($mode == "loadShippingCharges"){
		$goods_id = $_GET["goods_id"];
		$buyer_address_id = $_GET["buyer_address_id"];
		$courier = $_GET["courier"];
		$courier_service = $_GET["courier_service"];
		$qty = $_GET["qty"];
		$seller_id = $db->fetch_single_data("goods","seller_id",["id" => $goods_id]);
		$seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $seller_id]);
		$seller_locations = get_location($db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id]));
		$origin = $ro->location_id($seller_locations[0]["name"],$seller_locations[1]["name"],$seller_locations[2]["name"]);
		
		$buyer_locations = get_location($db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]));
		$destination = $ro->location_id($buyer_locations[0]["name"],$buyer_locations[1]["name"],$buyer_locations[2]["name"]);
		$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
		foreach($ro->cost($origin,$destination,($weight*$qty),$courier)["results"][0]["costs"] as $cost){
			if(strtolower($cost["service"]) == strtolower($courier_service)){
				$shippingcharges = $cost["cost"][0]["value"];
				break;
			}
		}
		$price = get_goods_price($goods_id,$qty)["display_price"];
		$subtotal = $price * $qty;
		$total = $subtotal + $shippingcharges;
		echo " x Rp. ".format_amount($price)." = Rp. ".format_amount($subtotal)."|||Rp. ".format_amount($shippingcharges)."|||Rp. ".format_amount($total)."|||".$shippingcharges."|||".$total;
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
		$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(1).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["transaction_at"],"dMY",true)."</div></div>";
		if($transaction["po_at"] != "0000-00-00 00:00:00") 			$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(3).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["po_at"],"dMY",true)."</div></div>";
		if($transaction["process_at"] != "0000-00-00 00:00:00") 	$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(4).":<br>&nbsp;&nbsp;&nbsp;".format_tanggal($transaction["process_at"],"dMY",true)."</div></div>";
		if($transaction["sent_at"] != "0000-00-00 00:00:00") {
			$receipt_no = $db->fetch_single_data("transaction_forwarder","receipt_no",["transaction_id" => $transaction_id]);
			$return .= "<div class='panel panel-info'><div class='panel-heading'>".transactionList(5).":<br>";
			$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"id IN (SELECT id FROM transactions WHERE invoice_no='".$transaction["invoice_no"]."')");
			$receipts = array();
			foreach($transaction_forwarders as $transaction_forwarder){
				if($transaction_forwarder["receipt_no"] != ""){
					$receipts[$transaction_forwarder["receipt_no"]] = $transaction_forwarder["receipt_at"];
					$receipts_courier[$transaction_forwarder["receipt_no"]] = $db->fetch_single_data("forwarders","rajaongkir_code",["id" => $transaction_forwarder["forwarder_id"]]);
				}
			}
			foreach($receipts as $receipt_no => $receipt_at){
				$trackers = $ro->waybill($receipts_courier[$receipt_no],$receipt_no);
				$return .= "&nbsp;&nbsp;&nbsp;".v("receipt_number")." <b>".$receipt_no."</b>";
				if(count($trackers["result"]["manifest"]) <= 0) $return .= " : ".format_tanggal($receipt_at,"dMY",true);
				if(count($trackers["result"]["manifest"]) > 0){
					$return .= "</div>";
					$return .= "<div class='panel-body'><b>TRACK SHIPMENT:</b>";
					foreach($trackers["result"]["manifest"] as $manifest){
						$return .= "<br><br>".$manifest["manifest_description"];
						$return .= "<br>&nbsp;&nbsp;&nbsp;".format_tanggal($manifest["manifest_date"]." ".$manifest["manifest_time"] ,"dMY",true);
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
?>