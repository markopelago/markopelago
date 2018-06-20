<?php
	$locations = $db->fetch_select_data("locations","id","name_".$__locale,[],"parent_id,seqno");
?>
<script>
	var latlong = "";
	var geoSuccess = function(position) {
		document.getElementById("coordinate").value = position.coords.latitude+" ; "+position.coords.longitude;
	};
	function get_coordinate(){
		navigator.geolocation.getCurrentPosition(geoSuccess,geoSuccess);
	}
</script>
<form role="form" method="POST" autocomplete="off" onsubmit="return validation()" enctype="multipart/form-data">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("name");?></label><?=$f->input("name",$data["name"],"required placeholder='".v("name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("email");?></label><?=$f->input("email",$data["email"],"type='email' placeholder='".v("email")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required placeholder='".v("phone")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("address");?></label><?=$f->textarea("address",$data["address"],"required placeholder='".v("address")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("location");?></label><?=$f->select("locations",$locations,$data["location"],"required placeholder='".v("location")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("coordinate");?></label>
			<?=$f->input("coordinate",$data["coordinate"],"required placeholder='".v("coordinate")."...'","form-control");?>
			<?=$f->input("get_gps",v("get_coordinate"),"type='button' onclick='get_coordinate();'","btn btn-info");?>
		</div>
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>