<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "addaddress"){
?>	
	<div class="container">
		<div class="row col-md-6">
			<form method="POST" role="form" autocomplete="off">
				<input type="hidden" name="addaddress" value="1">
				<div class="form-group">
					<label><?=v("address_type");?></label><?=$f->input("name",$name,"required placeholder='".v("address_type")."... (".v("example_home_office").")'","form-control");?>
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
					<?=$f->input("save_address",v("save"),"type='submit'","btn btn-primary");?>
				</div>
			</form>
		</div>
	</div>
<?php
	}
?>