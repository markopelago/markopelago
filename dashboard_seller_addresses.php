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
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover({
				trigger : 'hover',
				html : true
			});
		
			$("#province_id").change(function(){
				loadCities($("#province_id").val());
			});
		});

		function loadCities(parent_id){
			$("#div_cities").html("<img src='images/fancybox_loading.gif'>");
			$.get("ajax/locations.php?mode=loadCities&parent_id="+parent_id, function(returnval){
				$("#div_cities").html(returnval);
			});
		}
		
		function loadDistricts(parent_id){
			$("#div_districts").html("<img src='images/fancybox_loading.gif'>");
			$.get("ajax/locations.php?mode=loadDistricts&parent_id="+parent_id, function(returnval){
				$("#div_districts").html(returnval);
			});
		}
		
		function loadSubDistricts(parent_id){
			$("#div_subdistricts").html("<img src='images/fancybox_loading.gif'>");
			$.get("ajax/locations.php?mode=loadSubDistricts&parent_id="+parent_id, function(returnval){
				$("#div_subdistricts").html(returnval);
			});
		}
	</script>
	<style>
		.tbl_detail td{
			padding-right:30px;
			text-align:center;
		}
	</style>
		<form method="POST" action="?tabActive=addresses">
			<div class="col-sm-9 fadeInRight animated">
				<div class="col-md-12">
					<div class="form-group">
						<?php //$provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["seqno"],"",true);
							  $provinces = $db->selected_to_string("locations","id","name_".$__locale,$values,$separator);
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
	<br><br>