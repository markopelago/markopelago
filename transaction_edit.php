<?php  include_once "header.php"; ?>
<?php
	$transaction_id = $db->fetch_single_data("transactions","id",["buyer_user_id" => $__user_id,"status" => 0]);
	if($transaction_id <= 0){
		javascript("window.location='index.php'");
		exit();
	}
	if($_POST["save"]){
		$db->addtable("transactions");			$db->where("id",$_GET["id"]); $db->delete_();
		$db->addtable("transaction_details");	$db->where("transaction_id",$_GET["id"]); $db->delete_();
		$db->addtable("transaction_forwarder");	$db->where("transaction_id",$_GET["id"]); $db->delete_();
		
		$goods_id = $_POST["goods_id"];
		
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
			$qty = $_POST["qty"];
			$unit_id = $db->fetch_single_data("goods","unit_id",["id" => $goods_id]);
			$price = $db->fetch_single_data("goods","price",["id" => $goods_id]);
			$weight = $db->fetch_single_data("goods","weight",["id" => $goods_id]);
			$total = $price * $qty;
			$notes = $_POST["notes"];
			
			$db->addtable("transaction_details");
			$db->addfield("transaction_id");		$db->addvalue($transaction_id);
			$db->addfield("goods_id");				$db->addvalue($goods_id);
			$db->addfield("qty");					$db->addvalue($qty);
			$db->addfield("unit_id");				$db->addvalue($unit_id);
			$db->addfield("price");					$db->addvalue($price);
			$db->addfield("total");					$db->addvalue($total);
			$db->addfield("weight");				$db->addvalue($weight);
			$db->addfield("notes");					$db->addvalue($notes);
			$inserting_transaction_details = $db->insert();
			
			$forwarder_id = $db->fetch_single_data("forwarders","id",["rajaongkir_code" => $_POST["delivery_courier"]]);
			$forwarder_user_id = $db->fetch_single_data("forwarders","user_id",["rajaongkir_code" => $_POST["delivery_courier"]]);
			$name = $db->fetch_single_data("forwarders","name",["rajaongkir_code" => $_POST["delivery_courier"]]);
			$price = $_POST["shipping_charges"];
			$total = $price;
			
			$user_address_id = $_POST["user_address"];
			$_user_address = $db->fetch_all_data("user_addresses",[],"id='".$user_address_id."' AND user_id='".$__user_id."'")[0];
			$user_address_name = $_user_address["name"];
			$user_address_pic = $_user_address["pic"];
			$user_address_phone = $_user_address["phone"];
			$user_address = $_user_address["address"];
			$user_address_location_id = $_user_address["location_id"];
			$user_address_coordinate = $_user_address["coordinate"];
			
			$db->addtable("transaction_forwarder");
			$db->addfield("transaction_id");		$db->addvalue($transaction_id);
			$db->addfield("forwarder_id");			$db->addvalue($forwarder_id);
			$db->addfield("forwarder_user_id");		$db->addvalue($forwarder_user_id);
			$db->addfield("name");					$db->addvalue($name);
			$db->addfield("courier_service");		$db->addvalue($_POST["courier_service"]);
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
			
			if($inserting_transaction_details["affected_rows"] > 0 && $inserting_transaction_forwarder["affected_rows"] > 0){
				javascript("window.location='mycart.php?cart_group=".$cart_group."'");
			} else {
				$db->addtable("transactions"); $db->where("id",$transaction_id);$db->delete_();
				$db->addtable("transaction_details"); $db->where("transaction_id",$transaction_id);$db->delete_();
				$db->addtable("transaction_forwarder"); $db->where("transaction_id",$transaction_id);$db->delete_();
				$_SESSION["errormessage"] = v("failed_transaction");
				javascript("window.location='product_detail.php?id=".$goods_id."'");
			}
		} else {
			$_SESSION["errormessage"] = v("failed_transaction");
			javascript("window.location='product_detail.php?id=".$goods_id."'");
		}
		exit();
	}
	$transaction_detail = $db->fetch_all_data("transaction_details",[],"transaction_id = '".$_GET["id"]."'")[0];
	$goods_id = $transaction_detail["goods_id"];
	$user_address_default = $db->fetch_single_data("user_addresses","id",["user_id" => $__user_id, "default_buyer" => "1"]);
?>
<div style="height:20px;"></div>
<script>
	$(document).ready(function(){
		change_address("<?=$user_address_default;?>");
		load_courier_services("<?=$goods_id;?>",$("#user_address").val(),$("#delivery_courier").val(),$("#qty").val());
		
		$("#qty").change(function(){
			load_calculation();
		});
		
		$("#user_address").change(function(){
			load_calculation();
		});
		
		$("#delivery_courier").change(function(){
			load_courier_services("<?=$goods_id;?>",$("#user_address").val(),$("#delivery_courier").val(),$("#qty").val());
		});
	});
	
	function load_calculation(){
		load_shipping_charges("<?=$goods_id;?>",$("#user_address").val(),$("#delivery_courier").val(),$("#courier_service").val(),$("#qty").val());
	}
	
	function change_address(user_address_id){
		$("#div_delivery_destination").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=getAddress&user_address_id="+user_address_id, function(returnval){
			$("#div_delivery_destination").html(returnval);
		});
	}
	
	function load_courier_services(goods_id,buyer_address_id,courier,qty){
		$("#div_courier_services").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadCourierServices&goods_id="+goods_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier+"&qty="+qty, function(returnval){
			$("#div_courier_services").html(returnval);
			load_shipping_charges(goods_id,buyer_address_id,courier,$("#courier_service").val(),$("#qty").val());
		});
	}
	
	function load_shipping_charges(goods_id,buyer_address_id,courier,courier_service,qty){
		$("#div_price").html("<img src='images/fancybox_loading.gif'>");
		$("#div_shipping_charges").html("<img src='images/fancybox_loading.gif'>");
		$("#div_sub_total").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/transaction.php?mode=loadShippingCharges&goods_id="+goods_id+"&buyer_address_id="+buyer_address_id+"&courier="+courier+"&courier_service="+courier_service+"&qty="+qty, function(returnval){
			returnval = returnval.split("|||");
			$("#div_price").html(returnval[0]);
			$("#div_shipping_charges").html(returnval[1]);
			$("#div_sub_total").html(returnval[2]);
			$("#shipping_charges").val(returnval[3]);
			$("#sub_total").val(returnval[4]);
		});
	}
</script>
<form role="form" action="?id=<?=$_GET["id"];?>" method="POST" autocomplete="off">	
	<?=$f->input("goods_id",$goods_id,"type='hidden'");?>
	<?=$f->input("shipping_charges",0,"type='hidden'");?>
	<?=$f->input("sub_total",0,"type='hidden'");?>
	<div class="container">
		<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
			<div class="sub-title-text">
			  <?=v("buy");?>
			</div>
		</div>
		<div style="height:20px;"></div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group col-md-12">
					<label><b><?=v("product_name");?></b></label>
					<div class="trx-value-text"><?=$db->fetch_single_data("goods","name",["id"=>$goods_id]);?></div>
				</div>
				<div class="form-group col-md-6">
					<label><b><?=v("qty");?></b></label>
					<?=$f->input("qty",$transaction_detail["qty"],"type='number'","form-control");?>
				</div>
				<div class="form-group col-md-6">
					<label><b><?=v("price");?></b></label>
					<div id="div_price" class="trx-value-text">Rp. <?=format_amount($db->fetch_single_data("goods","price",["id"=>$goods_id]))?></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group col-md-12">
					<label><b><?=v("notes_for_seller");?></b></label>
					<?=$f->textarea("notes",$transaction_detail["notes"],"style='width:100% !important;height:auto !important;'","form-control");?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<label><b><?=v("delivery_destination");?></b></label>
		</div>
		<?php $user_addresses = $db->fetch_select_data("user_addresses","id","name",["user_id " => $__user_id]); ?>
		<div class="col-md-6">
			<label for="user_address" class="col-md-4"><b><?=v("choose_another_address");?> : </b></label>
			<div class="col-md-8"> <?=$f->select("user_address",$user_addresses,$user_address_default,"onchange = 'change_address(this.value);'","form-control");?> </div>
		</div>
		<div style="height:40px;"></div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body bg-grey" id="div_delivery_destination"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-3">
					<label><?=v("delivery_courier");?></label>
					<?php $forwarders = $db->fetch_select_data("forwarders","rajaongkir_code","concat(name,' (',upper(rajaongkir_code),')')");?>
					<?=$f->select("delivery_courier",$forwarders,"","","form-control");?>
				</div>
				<div class="col-md-3">
					<label><?=v("courier_service");?></label>
					<div id="div_courier_services"></div>
				</div>
				<div class="col-md-3">
					<label><?=v("shipping_charges");?></label>
					<div id="div_shipping_charges" class="trx-value-text">Rp. 0</div>
				</div>
				<div class="col-md-3">
					<label>Sub Total</label>
					<div id="div_sub_total" class="trx-value-text">Rp. 0</div>
				</div>
			</div>
		</div>
		<div style="height:20px;"></div>
		<div class="row">
			<div class="col-md-12">
				<?=$f->input("back",v("back"),"type='button' onclick='history.back();'","btn btn-warning");?>
				<?=$f->input("save",v("save"),"type='submit' style='position:relative;float:right;'","btn btn-primary");?>
			</div>
		</div>
	</div>
</div>
<div style="height:20px;"></div>
<?php include_once "footer.php"; ?>