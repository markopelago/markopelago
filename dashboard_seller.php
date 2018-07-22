<?php include_once "Xdashboard_model_action.php"; ?>
<div class="row">
	<?php 
		$sellers = $db->fetch_all_data("sellers",[],"user_id='".$__user_id."'")[0];
		
	?>
	
	
	<div class="container">
		<h2 class="well"><?=strtoupper(v("dashboard"));?></h2>
		<h3><?=$sellers["name"];?></h3>
	<div class="col-sm-2 features wow fadeInRight animated">
		<img id="headerProfileImg" src="users_images/<?=$sellers["header_image"];?>">
		<input name="change_header" id="change_header" value="<?=v("change_header");?>" style="width:200px;" type="button" onclick="window.location='dashboard_seller_headerprofile.php';" class="btn btn-primary">
		<br><br>
	</div>	
	</div>
	
	<div class="col-sm-2 features wow fadeInRight animated">
		<img id="mainProfileImg" src="users_images/<?=$sellers["logo"];?>">
		<input name="change_logo" id="change_logo" value="<?=v("change_logo");?>" style="width:200px;" type="button" onclick="window.location='dashboard_seller_photoprofile.php';" class="btn btn-primary">
		<br><br>
	</div>
	<div class="col-sm-10 fadeInRight animated">
		<div class="col-md-12 container">
			<ul class="col-sm-12 nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
				<li><a data-toggle="tab" href="#addresses"><?=v("addresses");?></a></li>
				<li><a data-toggle="tab" href="#banks"><?=v("banks");?></a></li>
				<li><a data-toggle="tab" href="#po"><?=v("PO");?></a></li>
				<li onclick="loadMessages();">
					<a data-toggle="tab" href="#message"><?=v("message");?><span class="notification-counter" style="visibility:hidden;" id="notifMessageTabCount"></span></a>
				</li>
			</ul>
			<br><br>
			<div class="col-sm-12 tab-content">
				<div id="profile" class="tab-pane fade in active">
					<?php include_once "dashboard_seller_profiles.php";?>
				</div><br>
				<div id="addresses" class="tab-pane fade"><?php include_once "dashboard_seller_addresses.php"; ?></div>
				<div id="banks" class="tab-pane fade"><?php include_once "dashboard_seller_banks.php"; ?></div>
				<div id="po" class="tab-pane fade"><?php include_once "dashboard_seller_po.php"; ?></div>
				<div id="message" class="tab-pane fade"><?php include_once "dashboard_messages.php"; ?></div>
			</div>
		</div>
		
	</div>
</div>