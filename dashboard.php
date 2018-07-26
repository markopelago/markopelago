<?php include_once "homepage_header.php"; ?>
<?php
	if(!$__isloggedin){
		?> <script> window.location = "index.php"; </script> <?php
		exit();
	}
?>
	<style>
		.tbl_detail td{
			padding-right:30px;
			text-align:center;
		}
	</style>
	<div class="row">
		<div class="container">
			<h2 class="well"><?=strtoupper(v("dashboard"));?></h2>
			<h3><?=$db->fetch_single_data("a_users","name",["id" => $__user_id]);?></h3>
			<?php if($__seller_id > 0){ ?>
				<div class="col-md-12 features wow fadeInRight animated">
					<img id="headerProfileImg" src="users_images/<?=$__seller["header_image"];?>" class="img-responsive">
					<input name="change_header" id="change_header" value="<?=v("change_header");?>" style="position:relative;top:-34px;" type="button" onclick="window.location='dashboard_headerprofile.php';" class="btn btn-primary">
					<br><br>
				</div>	
			<?php } ?>
		</div>
		<div class="container">
			<?php if($__seller_id > 0){ ?>
				<div class="col-md-2 features wow fadeInRight animated">
					<div><img id="mainProfileImg" src="users_images/<?=$__seller["logo"];?>"></div>
					<div><input name="change_logo" id="change_logo" value="<?=v("change_logo");?>" style="width:200px;" type="button" onclick="window.location='dashboard_logo.php';" class="btn btn-primary"></div>
					<br><br>
				</div>
			<?php } ?>
			<?php if($__buyer_id > 0){ ?>
				<div class="col-md-2 features wow fadeInRight animated">
					<div><img id="mainProfileImg" src="users_images/<?=$__buyer["avatar"];?>"></div>
					<div><input name="change_avatar" id="change_avatar" value="<?=v("change_avatar");?>" style="width:200px;" type="button" onclick="window.location='dashboard_avatar.php';" class="btn btn-primary"></div>
					<br><br>
				</div>
			<?php } ?>
			
			<div class="col-md-10 fadeInRight animated">
				<div class="col-md-12 container">
					<ul class="col-md-12 nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
						<li><a data-toggle="tab" href="#addresses"><?=v("addresses");?></a></li>
						<li><a data-toggle="tab" href="#banks"><?=v("banks");?></a></li>
						<li><a data-toggle="tab" href="#invoices"><?=v("invoices");?></a></li>
						<?php if($__seller_id > 0){ ?>
							<li><a data-toggle="tab" href="#po"><?=v("po");?></a></li>
							<li><a data-toggle="tab" href="#goods"><?=v("goods");?></a></li>
						<?php } ?>
						<li><a data-toggle="tab" href="#message"><?=v("message");?><span class="notification-counter" style="visibility:hidden;" id="notifMessageTabCount"></span></a></li>
					</ul>
					<br><br>
					<div class="col-md-12 tab-content">
						<div id="profile" class="tab-pane fade in active"><?php include_once "dashboard_profiles.php";?></div><br>
						<div id="addresses" class="tab-pane fade"><?php include_once "dashboard_addresses.php"; ?></div>
						<div id="banks" class="tab-pane fade"><?php include_once "dashboard_banks.php"; ?></div>
						<div id="invoices" class="tab-pane fade"><?php include_once "dashboard_invoices.php"; ?></div>
						<div id="po" class="tab-pane fade"><?php include_once "dashboard_po.php"; ?></div>
						<div id="goods" class="tab-pane fade"><?php include_once "dashboard_goods.php"; ?></div>
						<div id="message" class="tab-pane fade"><?php include_once "dashboard_messages.php"; ?></div>
					</div>
				</div>		
			</div>
		</div>
	</div>
<?php include_once "footer.php"; ?>