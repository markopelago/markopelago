<?php
	echo "<button class='btn btn-primary' onclick=\"window.location='markoantar_rate_add.php'\"><span class='glyphicon glyphicon-plus-sign' title='".v("add_markoantar_rate")."'></span> ".v("add_markoantar_rate")."</button>";
	if(isset($_GET["delete_route"])){
		$db->addtable("forwarder_routes");	$db->where("id",$_GET["delete_route"]);	$db->delete_();
		javascript("window.history.pushState('','','?tabActive=markoantar_rates');");
	}
?>
<script>
	function change_is_route_active(route_id,value){
		$("#switch_caption_"+route_id).html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/vehicles.php?mode=change_is_route_active&route_id="+route_id+"&value="+value, function(returnval){
			$("#switch_caption_"+route_id).html(returnval);
		});
	}
	function delete_route(route_id){
		if(confirm("<?=v("confirm_delete");?>")){
			window.location = "?tabActive=markoantar_rates&delete_route="+route_id;
		}
	}
</script>
<br><br>
<div class="container">
	<?php
		$forwarder_routes = $db->fetch_all_data("forwarder_routes",[],"user_id='".$__user_id."' AND forwarder_id='".$__forwarder_id."'","id");
		if(count($forwarder_routes) <= 0){
			?> <tr class="danger"><td colspan="2" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
		} else {
			foreach($forwarder_routes as $forwarder_route){
				$vehicle = $db->fetch_all_data("forwarder_vehicles",[],"id='".$forwarder_route["vehicle_id"]."'")[0];
				$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $vehicle["vehicle_brand_id"]]);
				$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $vehicle["vehicle_type_id"]]);
				$source_location = get_location($forwarder_route["source_location_id"])[3]["name"]." ,".get_location($forwarder_route["source_location_id"])[1]["name"];
				$destination_location = get_location($forwarder_route["destination_location_id"])[3]["name"]." ,".get_location($forwarder_route["destination_location_id"])[1]["name"];
				$load_type = $db->fetch_single_data("load_types","name",["id" => $forwarder_route["load_type_id"]]);
				?>
					<div class="row">
						<div class="well col-md-11">
							<label class="switch">
								<input <?=($forwarder_route["is_active"])?"checked":"";?> onchange="change_is_route_active('<?=$forwarder_route["id"];?>',this.checked);" type="checkbox">
								<div class="switch_slider round">
									<div id="switch_caption_<?=$forwarder_route["id"];?>" class="switch_caption">
										<font color="<?=($forwarder_route["is_active"])?"#2196F3":"red";?>">
											<?=v(($forwarder_route["is_active"])?"active":"not_active");?>
										</font>
									</div>
								</div>
							</label>
							<div class="row">
								<div class="col-md-2"><b><?=$vehicle["nopol"];?></b><br><?=$vehicle_type;?> - <?=$vehicle_brand;?></div>
								<div class="col-md-3"><?=$source_location;?><br><?=$destination_location;?></div>
								<div class="col-md-3"><b><?=v("load_type");?></b><br><?=$load_type;?></div>
								<div class="col-md-4"><b><?=v("price");?></b><br>Rp. <?=format_amount($forwarder_route["price"]);?></div>
							</div>
							<button style="width:100%;" title="<?=v("edit");?>" class="btn btn-primary" onclick="window.location='markoantar_rate_edit.php?id=<?=$forwarder_route["id"];?>';"><span class="glyphicon glyphicon-edit"></span><?=v("edit");?></button>
						</div>
					</div>
				<?php
			}
		}
	?>
</div>