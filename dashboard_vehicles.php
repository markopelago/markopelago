<?php
	echo "<button class='btn btn-primary' onclick=\"window.location='vehicle_add.php'\"><span class='glyphicon glyphicon-plus-sign' title='".v("add_vehicle")."'></span> ".v("add_vehicle")."</button>";
	if(isset($_GET["delete_goods"])){
		$db->addtable("forwarder_vehicles");	$db->where("id",$_GET["delete_vehicle"]);	$db->delete_();
		javascript("window.history.pushState('','','?tabActive=vehicles');");
	}
?>
<script>
	function change_is_active(vehicle_id,value){
		$("#switch_caption_"+vehicle_id).html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/vehicles.php?mode=change_is_active&vehicle_id="+vehicle_id+"&value="+value, function(returnval){
			$("#switch_caption_"+vehicle_id).html(returnval);
		});
	}
	function delete_goods(vehicle_id){
		if(confirm("<?=v("confirm_delete");?>")){
			window.location = "?tabActive=vehicles&delete_vehicle="+vehicle_id;
		}
	}
</script>
<br><br>
<div class="container">
	<?php
		$vehicles = $db->fetch_all_data("forwarder_vehicles",[],"user_id='".$__user_id."'","id");
		if(count($vehicles) <= 0){
			?> <tr class="danger"><td colspan="2" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
		} else {
			foreach($vehicles as $vehicle){
				$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $vehicle["vehicle_brand_id"]]);
				$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $vehicle["vehicle_type_id"]]);
				$dimension = $vehicle["dimension_load_l"]."cm x ".$vehicle["dimension_load_w"]."cm x ".$vehicle["dimension_load_h"]."cm";
				?>
					<div class="row">
						<div class="well col-md-11">
							<label class="switch">
								<input <?=($vehicle["is_active"])?"checked":"";?> onchange="change_is_active('<?=$vehicle["id"];?>',this.checked);" type="checkbox">
								<div class="switch_slider round">
									<div id="switch_caption_<?=$vehicle["id"];?>" class="switch_caption">
										<font color="<?=($vehicle["is_active"])?"#2196F3":"red";?>">
											<?=v(($vehicle["is_active"])?"active":"not_active");?>
										</font>
									</div>
								</div>
							</label>
							<div class="row">
								<div class="col-md-2"><b><?=$vehicle["nopol"];?></b><br><?=$vehicle_type;?> - <?=$vehicle_brand;?></div>
								<div class="col-md-2"><b><?=v("dimension");?></b><br><?=$dimension;?></div>
								<div class="col-md-3"><b><?=v("max_load");?></b><br><?=$vehicle["max_load"];?> Kg</div>
								<div class="col-md-5"><b><?=v("description");?></b><br><pre><?=$vehicle["description"];?></div>
							</div>
							<button style="width:100%;" title="<?=v("edit");?>" class="btn btn-primary" onclick="window.location='vehicle_edit.php?id=<?=$vehicle["id"];?>';"><span class="glyphicon glyphicon-edit"></span><?=v("edit");?></button>
						</div>
					</div>
				<?php
			}
		}
	?>
</div>