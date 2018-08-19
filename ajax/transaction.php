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
		$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id]);
		$origin = $ro->location_id(get_location($seller_location_id)[0]["name"],0,get_location($seller_location_id)[1]["name"]);
		
		$buyer_location_id = $db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]);
		$destination = $ro->location_id(get_location($buyer_location_id)[0]["name"],0,get_location($buyer_location_id)[1]["name"]);
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
		$seller_location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller_user_id]);
		$origin = $ro->location_id(get_location($seller_location_id)[0]["name"],0,get_location($seller_location_id)[1]["name"]);
		
		$buyer_location_id = $db->fetch_single_data("user_addresses","location_id",["id" => $buyer_address_id,"user_id" => $__user_id]);
		$destination = $ro->location_id(get_location($buyer_location_id)[0]["name"],0,get_location($buyer_location_id)[1]["name"]);
		$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
		foreach($ro->cost($origin,$destination,($weight*$qty),$courier)["results"][0]["costs"] as $cost){
			if(strtolower($cost["service"]) == strtolower($courier_service)){
				$shippingcharges = $cost["cost"][0]["value"];
				break;
			}
		}
		$price = $db->fetch_single_data("goods","price",["id" => $goods_id]) * $qty;
		$total = $price + $shippingcharges;
		echo "Rp. ".format_amount($price)."|||Rp. ".format_amount($shippingcharges)."|||Rp. ".format_amount($total)."|||".$shippingcharges."|||".$total;
	}
	
	if($mode == "loadBankAccounts"){
		$bank_account_id = $_GET["bank_account_id"];
		$bank_account = $db->fetch_all_data("bank_accounts",[],"id = '".$bank_account_id."'")[0];
		$bank_name = $db->fetch_single_data("banks","name",["id" => $bank_account["bank_id"]]);
		echo $bank_name."<br>No Rekening: ".$bank_account["account_no"]."<br>a/n: ".$bank_account["account_name"];
	}
?>