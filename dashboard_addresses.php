<?php 
	if(isset($_POST["save"])){
		$db->addtable("user_addresses");
		$db->where("user_id",$__user_id);
		$db->addfield("location_id");              	$db->addvalue($_POST["subdistrict"]);
		$inserting = $db->update();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("update_profile_success");
		} else {
			$_SESSION["errormessage"] = v("update_profile_failed");
		}
	}
	$address = $db->fetch_single_data("user_addresses","address",["user_id"=>$__user_id]);
?>
<form method="POST" action="?tabActive=addresses">
	<div class="col-sm-9 fadeInRight animated">
		<div class="col-md-12">
			<div class="form-group">
				<?php $provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["seqno"],"",true);
				?>
				<label><?=v("province");?></label> <?=$f->select("province_id",$provinces,$province_id,"required","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("province");?></label><div id="div_cities"></div>
			</div>
			<div class="form-group">
				<label><?=v("district");?></label><div id="div_districts"></div>
			</div>
			<div class="form-group">
				<label><?=v("subdistrict");?></label><div id="div_subdistricts"></div>
			</div>
			<div class="form-group">
				<label><?=v("address");?></label><?=$f->textarea("address",$address,"required placeholder='".v("description")."...'","form-control");?>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<?=$f->input("save",v("save"),"type='submit' width='75%'","btn btn-primary");?>
	</div>
</form>