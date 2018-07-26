<?php
	if($db->fetch_single_data("user_addresses","id",["user_id" => $__user_id]) > 0){ javascript("window.location='dashboard.php';"); exit(); }
	if(isset($_POST["next"])){
		$db->addtable("user_addresses");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("default_buyer");		$db->addvalue("1");
		$db->addfield("default_seller");	$db->addvalue("1");
		$db->addfield("default_forwarder");	$db->addvalue("1");
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		$db->addfield("phone");				$db->addvalue($_POST["phone"]);
		$db->addfield("address");			$db->addvalue($_POST["branch"]);
		$db->addfield("location_id");		$db->addvalue($_POST["subdistrict_id"]);
		$db->addfield("coordinate");		$db->addvalue($_POST["coordinate"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("window.location='?step=4';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_data");
		}
		
	}
	$pic = $db->fetch_single_data("a_users","name",["id" => $__user_id]);
	$phone = $db->fetch_single_data("a_users","phone",["id" => $__user_id]);
?>
<h3><b>ADDRESS</b></h3>
<form action="register.php?step=3" method="POST" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("name");?></label><?=$f->input("name","","required placeholder='".v("name")."... (".v("example_home_office").")'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("pic");?></label><?=$f->input("pic",$pic,"required placeholder='".v("pic")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("phone");?></label><?=$f->input("phone",$phone,"required placeholder='".v("phone")."...'","form-control");?>
		</div>
		<div class="form-group">
			<?php $provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["name_".$__locale],"",true); ?>
			<label><?=v("province");?></label> <?=$f->select("province_id",$provinces,$province_id,"required","form-control");?>
		</div>
		<div class="form-group" id="div_select_cities" style="display:none;">
			<label><?=v("city");?></label><div id="div_cities"></div>
		</div>
		<div class="form-group" id="div_select_district" style="display:none;">
			<label><?=v("district");?></label><div id="div_districts"></div>
		</div>
		<div class="form-group" id="div_select_subdistrict" style="display:none;">
			<label><?=v("subdistrict");?></label><div id="div_subdistricts"></div>
		</div>
		<div class="form-group">
			<label><?=v("address");?></label><?=$f->textarea("address",$address,"required placeholder='".v("address")."...'","form-control");?>
		</div>
	
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>