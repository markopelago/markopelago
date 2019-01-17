<?php include_once "homepage_header.php"; ?>
<?php
	if(!$__isloggedin){
		?> <script> window.location = "index.php"; </script> <?php
		exit();
	}
	if($_GET["delete_purchase_list"] == 1 && $_GET["invoice_no"] != ""){
		$invoice_no = $_GET["invoice_no"];
		$transaction_status = $db->fetch_single_data("transactions","status",["invoice_no" => $invoice_no]);
		if($transaction_status <= 1){
			$db->addtable("transaction_details");	$db->where("transaction_id","(SELECT id FROM transactions WHERE invoice_no='".$invoice_no."' AND buyer_user_id='".$__user_id."')","s","IN");	$db->delete_();
			$db->addtable("transactions");			$db->where("invoice_no",$invoice_no);	$db->where("buyer_user_id",$__user_id);	$db->delete_();
			$_SESSION["message"] = v("delete_transaction_by_invoice_no_success");
		} else {
			$_SESSION["errormessage"] = v("no_permission_delete_transaction");
		}
		?> <script> window.location = "?tabActive=purchase_list"; </script> <?php
		exit();
	}
	if($_GET["delete_store_sales_list"] == 1 && $_GET["po_no"] != ""){
		$po_no = $_GET["po_no"];
		$transaction_status = $db->fetch_single_data("transactions","status",["po_no" => $po_no]);
		$transaction_cart_group = $db->fetch_single_data("transactions","cart_group",["po_no" => $po_no]);
		$is_cod = $db->fetch_single_data("transaction_payments","id",["cart_group" => $transaction_cart_group,"payment_type_id" => "-1"]);
		if($is_cod && $transaction_status <= 3){
			$db->addtable("transaction_details");	$db->where("transaction_id","(SELECT id FROM transactions WHERE po_no='".$po_no."' AND seller_user_id='".$__user_id."')","s","IN");	$db->delete_();
			$db->addtable("transactions");			$db->where("po_no",$po_no);	$db->where("seller_user_id",$__user_id);	$db->delete_();
			$_SESSION["message"] = v("delete_transaction_by_po_no_success");
		} else {
			$_SESSION["errormessage"] = v("no_permission_delete_transaction");
		}
		?> <script> window.location = "?tabActive=store_sales_list"; </script> <?php
		exit();
	}
	$expiredTransactions = $db->fetch_all_data("transactions",["id"],"buyer_user_id = '".$__user_id."' AND status < 2 AND HOUR(TIMEDIFF(NOW(), transaction_at)) > 24");
	foreach($expiredTransactions as $expiredTransaction){
		$delete_transaction_id = $expiredTransaction["id"];
		$db->addtable("transaction_details");	$db->where("transaction_id",$delete_transaction_id);	$db->delete_();
		$db->addtable("transaction_forwarder");	$db->where("transaction_id",$delete_transaction_id);	$db->delete_();
		$db->addtable("transactions");			$db->where("id",$delete_transaction_id);				$db->delete_();
	}
?>
	<style>
		.panel-heading{
			cursor:pointer;
		}
	</style>
	<script>
		function focusto(tab_id){
			setTimeout(function(){ 
				$("html, body").animate({ scrollTop: $("#panel_"+tab_id).offset().top - 60 }, 200); 
			}, 500);
		}
		function changeState(tab_id){ 
			window.history.pushState("","","?tabActive="+tab_id); 
			focusto(tab_id);
		}
		function delete_purchase_list(invoice_no){
			if(confirm("<?=v("confirm_delete_transaction_by_invoiceno");?>?".replace("{invoice_no}",invoice_no))){
				window.location="?delete_purchase_list=1&invoice_no="+invoice_no;
			}
		}
		function delete_po(po_no){
			if(confirm("<?=v("confirm_delete_transaction_by_pono");?>?".replace("{po_no}",po_no))){
				window.location="?delete_store_sales_list=1&po_no="+po_no;
			}
		}
	</script>
	<div class="container">
		<div class="row">
			<div class="common_title"><a style="color:#EE9634;" href="index.php"><span class="glyphicon glyphicon-chevron-left"></span></a> &nbsp;<?=v("dashboard");?></div>
		</div>
		<div class="panel-group" id="dashboard">
			<div id="panel_profile" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#profile" onclick="changeState('profile');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-user"></span> <b>Profile</b></h3>
				</div>
				<?php $is_collapse = ($_GET["tabActive"] == "profile" || $_GET["tabActive"] == "")?"in":"";?>
				<div id="profile" class="panel-collapse collapse <?=$is_collapse;?>"><div class="panel-body"><?php include_once "dashboard_profiles.php";?></div></div>
			</div><br>
			<div id="panel_seller" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#seller" onclick="changeState('seller');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-home"></span> <b><?=v("profile_my_store");?></b></h3>
				</div>
				<div id="seller" class="panel-collapse collapse <?=($_GET["tabActive"] == "seller")?"in":"";?>"><div class="panel-body">
					<?php $__seller["header_image"] = ($__seller["header_image"] == "")?"no_header.jpg":$__seller["header_image"]; ?>
						<div class="col-md-12 hidden-xs">
							<img id="headerProfileImg" src="users_images/<?=$__seller["header_image"];?>" class="img-responsive">
							<input name="change_header" id="change_header" value="<?=v("change_header");?>" style="position:relative;top:-33px;" type="button" onclick="window.location='dashboard_seller_header.php';" class="btn btn-primary">
							<br><br>
						</div>
					<?php include_once "dashboard_seller.php";?>
				</div></div>
			</div><br>
			<?php if($__forwarder_id <= 0){ ?>
			<div id="panel_markoantar" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#markoantar" onclick="changeState('markoantar');">
					<h3 class="panel-title"><img src="assets/sent.png" height="20"> <b>Marko Antar</b></h3>
				</div>
				<div id="markoantar" class="panel-collapse collapse <?=($_GET["tabActive"] == "markoantar")?"in":"";?>"><div class="panel-body">
					<?php include_once "dashboard_markoantar.php";?>
				</div></div>
			</div><br>
			<?php } else { ?>
			<div id="panel_vehicles" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#vehicles" onclick="changeState('vehicles');">
					<h3 class="panel-title"><img src="assets/sent.png" height="20"> <b><?=v("markoantar_vehicles");?></b></h3>
				</div>
				<div id="vehicles" class="panel-collapse collapse <?=($_GET["tabActive"] == "vehicles")?"in":"";?>"><div class="panel-body">
					<?php include_once "dashboard_vehicles.php";?>
				</div></div>
			</div><br>
			<div id="panel_markoantar_rates" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#markoantar_rates" onclick="changeState('markoantar_rates');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> <b><?=v("markoantar_rates");?></b></h3>
				</div>
				<div id="markoantar_rates" class="panel-collapse collapse <?=($_GET["tabActive"] == "markoantar_rates")?"in":"";?>"><div class="panel-body">
					<?php include_once "dashboard_markoantar_rates.php";?>
				</div></div>
			</div><br>
			<?php } ?>
			<div id="panel_addresses" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#addresses" onclick="changeState('addresses');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-map-marker"></span> <b><?=v("addresses");?></b></h3>
				</div>
				<div id="addresses" class="panel-collapse collapse <?=($_GET["tabActive"] == "addresses")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_addresses.php";?></div></div>
			</div><br>
			<div id="panel_banks" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#banks" onclick="changeState('banks');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-piggy-bank"></span> <b><?=v("banks");?></b></h3>
				</div>
				<div id="banks" class="panel-collapse collapse <?=($_GET["tabActive"] == "banks")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_banks.php";?></div></div>
			</div><br>
			<?php if($__seller_id > 0){ ?>
			<div id="panel_goods" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#goods" onclick="changeState('goods');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-barcode"></span> <b><?=v("my_goods");?></b></h3>
				</div>
				<div id="goods" class="panel-collapse collapse <?=($_GET["tabActive"] == "goods")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_goods.php";?></div></div>
			</div><br>
			<?php } ?>
			<div id="panel_purchase_list" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#purchase_list" onclick="changeState('purchase_list');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-shopping-cart"></span> <b><?=v("purchase_list");?></b><span class="notification-counter" style="visibility:hidden;" id="notifPurchaseListTabCount"></span></h3>
				</div>
				<div id="purchase_list" class="panel-collapse collapse <?=($_GET["tabActive"] == "purchase_list")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_purchase_list.php";?></div></div>
			</div><br>
			<?php if($__seller_id > 0){ ?>
			<div id="panel_store_sales_list" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#store_sales_list" onclick="changeState('store_sales_list');">
					<h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> <b><?=v("store_sales_list");?></b><span class="notification-counter" style="visibility:hidden;" id="notifStoreSalesListTabCount"></span></h3>
				</div>
				<div id="store_sales_list" class="panel-collapse collapse <?=($_GET["tabActive"] == "store_sales_list")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_store_sales_list.php";?></div></div>
			</div><br>
			<?php } ?>
			<?php if($__forwarder_id > 0){ ?>
			<div id="panel_list_of_delivering_goods" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#list_of_delivering_goods" onclick="changeState('list_of_delivering_goods');">
					<h3 class="panel-title"><img src="assets/sent.png" height="20"> <b><?=v("list_of_delivering_goods");?></b><span class="notification-counter" style="visibility:hidden;" id="notifDeliveringGoodsTabCount"></span></h3>
				</div>
				<div id="list_of_delivering_goods" class="panel-collapse collapse <?=($_GET["tabActive"] == "list_of_delivering_goods")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_list_of_delivering_goods.php";?></div></div>
			</div><br>
			<?php } ?>
			<div id="panel_message" class="panel panel-default">
				<div class="panel-heading" data-toggle="collapse" data-parent="#dashboard" href="#message" onclick="changeState('message');loadMessages();">
					<h3 class="panel-title"><span class="glyphicon glyphicon-envelope"></span> <b><?=v("message");?></b><span class="notification-counter" style="visibility:hidden;" id="notifMessageTabCount"></span></h3>
				</div>
				<div id="message" class="panel-collapse collapse <?=($_GET["tabActive"] == "message")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_messages.php";?></div></div>
			</div><br>
		</div> 
	</div>
	<div style="height:20px;"></div>
	<?php if($_GET["tabActive"] != ""){ ?>
		<script> focusto("<?=$_GET["tabActive"];?>"); </script>
	<?php } ?>
<?php include_once "footer.php"; ?>