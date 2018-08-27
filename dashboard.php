<?php include_once "homepage_header.php"; ?>
<?php
	if(!$__isloggedin){
		?> <script> window.location = "index.php"; </script> <?php
		exit();
	}
	$scrollAdj = (isMobile())?180:60;
?>
	<script>
		function focusto(tab_id){
			setTimeout(function(){ 
				$("html, body").animate({ scrollTop: $("#panel_"+tab_id).offset().top - <?=$scrollAdj;?> }, 1000); 
			}, 500);
		}
		function changeState(tab_id){ 
			window.history.pushState("","","?tabActive="+tab_id); 
			focusto(tab_id);
		}
	</script>
	<div class="container">
		<div class="row">
			<h2 class="well"><a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-chevron-left"></span></a><?=strtoupper(v("dashboard"));?></h2>
		</div>
	</div>
	<div class="container">
		<div class="panel-group" id="dashboard">
			<div id="panel_profile" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#profile" onclick="changeState('profile');">Profile</a></b>
					</h3>
				</div>
				<?php $is_collapse = ($_GET["tabActive"] == "profile" || $_GET["tabActive"] == "")?"in":"";?>
				<div id="profile" class="panel-collapse collapse <?=$is_collapse;?>"><div class="panel-body"><?php include_once "dashboard_profiles.php";?></div></div>
			</div><br>
			<div id="panel_seller" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#seller" onclick="changeState('seller');"><?=v("profile_my_store");?></a></b>
					</h3>
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
			<div id="panel_addresses" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#addresses" onclick="changeState('addresses');"><?=v("addresses");?></a></b>
					</h3>
				</div>
				<div id="addresses" class="panel-collapse collapse <?=($_GET["tabActive"] == "addresses")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_addresses.php";?></div></div>
			</div><br>
			<div id="panel_banks" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#banks" onclick="changeState('banks');"><?=v("banks");?></a></b>
					</h3>
				</div>
				<div id="banks" class="panel-collapse collapse <?=($_GET["tabActive"] == "banks")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_banks.php";?></div></div>
			</div><br>
			<?php if($__seller_id > 0){ ?>
			<div id="panel_goods" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#goods" onclick="changeState('goods');"><?=v("my_goods");?></a></b>
					</h3>
				</div>
				<div id="goods" class="panel-collapse collapse <?=($_GET["tabActive"] == "goods")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_goods.php";?></div></div>
			</div><br>
			<?php } ?>
			<div id="panel_purchase_list" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#purchase_list" onclick="changeState('purchase_list');"><?=v("purchase_list");?></a></b>
					</h3>
				</div>
				<div id="purchase_list" class="panel-collapse collapse <?=($_GET["tabActive"] == "purchase_list")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_purchase_list.php";?></div></div>
			</div><br>
			<?php if($__seller_id > 0 || $__forwarder_id > 0){ ?>
			<div id="panel_store_sales_list" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#store_sales_list" onclick="changeState('store_sales_list');"><?=v("store_sales_list");?></a></b>
					</h3>
				</div>
				<div id="store_sales_list" class="panel-collapse collapse <?=($_GET["tabActive"] == "store_sales_list")?"in":"";?>"><div class="panel-body"><?php include_once "dashboard_store_sales_list.php";?></div></div>
			</div><br>
			<?php } ?>
			<div id="panel_message" class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<b><a data-toggle="collapse" data-parent="#dashboard" href="#message" onclick="changeState('message');loadMessages();"><?=v("message");?></a></b>
					</h3>
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