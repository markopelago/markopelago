<?php include_once "homepage_header.php"; ?>
<?php
	if(!$__isloggedin){
		?> <script> window.location = "index.php"; </script> <?php
		exit();
	}
?>
	<script>
		function changeState(tab_id){ window.history.pushState("","","?tabActive="+tab_id); }
	</script>
	<div class="container">
		<div class="row">
			<h2 class="well"><?=strtoupper(v("dashboard"));?></h2>
			<h3><?=$db->fetch_single_data("a_users","name",["id" => $__user_id]);?></h3>
			<?php if($__seller_id > 0){ ?>
				<div class="col-md-12">
					<img id="headerProfileImg" src="users_images/<?=$__seller["header_image"];?>" class="img-responsive">
					<input name="change_header" id="change_header" value="<?=v("change_header");?>" style="position:relative;top:-34px;" type="button" onclick="window.location='dashboard_headerprofile.php';" class="btn btn-primary">
					<br><br>
				</div>	
			<?php } ?>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<div><img id="mainProfileImg" src="users_images/<?=($__buyer["avatar"] == "")?"nophoto.png":$__buyer["avatar"];?>"></div>
				<div><input name="change_avatar" id="change_avatar" value="<?=v("change_avatar");?>" style="width:200px;" type="button" onclick="window.location='dashboard_avatar.php';" class="btn btn-primary"></div>
				<br><br>
			</div>
			<div class="col-md-10">
				<div class="col-md-12">
					<ul class="col-md-12 nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#profile" onclick="changeState('profile');">Profile</a></li>
						<li><a data-toggle="tab" href="#seller" onclick="changeState('seller');"><?=v("profile_my_store");?></a></li>
						<li><a data-toggle="tab" href="#addresses" onclick="changeState('addresses');"><?=v("addresses");?></a></li>
						<li><a data-toggle="tab" href="#banks" onclick="changeState('banks');"><?=v("banks");?></a></li>
						<?php if($__seller_id > 0){ ?>
							<li><a data-toggle="tab" href="#goods" onclick="changeState('goods');"><?=v("my_goods");?></a></li>
						<?php } ?>
						<?php if($__seller_id > 0|| $__forwarder_id > 0){ ?>
							<li><a data-toggle="tab" href="#po" onclick="changeState('po');"><?=v("po");?></a></li>
						<?php } ?>
						<li><a data-toggle="tab" href="#invoices" onclick="changeState('invoices');"><?=v("invoices");?></a></li>
						<li><a data-toggle="tab" href="#message" onclick="changeState('message');"><?=v("message");?><span class="notification-counter" style="visibility:hidden;" id="notifMessageTabCount"></span></a></li>
					</ul>
					<br><br>
					<div class="col-md-12 tab-content">
						<div id="profile" class="tab-pane active"><?php include_once "dashboard_profiles.php";?></div><br>
						<div id="seller" class="tab-pane active"><?php include_once "dashboard_seller.php";?></div><br>
						<div id="addresses" class="tab-pane"><?php include_once "dashboard_addresses.php"; ?></div>
						<div id="banks" class="tab-pane"><?php include_once "dashboard_banks.php"; ?></div>
						<div id="invoices" class="tab-pane"><?php include_once "dashboard_invoices.php"; ?></div>
						<div id="po" class="tab-pane"><?php include_once "dashboard_po.php"; ?></div>
						<div id="goods" class="tab-pane"><?php include_once "dashboard_goods.php"; ?></div>
						<div id="message" class="tab-pane"><?php include_once "dashboard_messages.php"; ?></div>
					</div>
				</div>		
			</div>
		</div>
	</div>
	<div style="height:20px;"></div>
<?php include_once "footer.php"; ?>