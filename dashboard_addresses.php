<?php
	if(isset($_GET["change_primary"])){
		$db->addtable("user_addresses");$db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("0");
		$db->update();
		$db->addtable("user_addresses"); $db->where("id",$_GET["change_primary"]); $db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("1");
		$db->update();
		$_SESSION["message"]= v("data_saved_successfully");
	}
	if(isset($_GET["deleting"])){
		$db->addtable("user_addresses"); $db->where("id",$_GET["deleting"]); $db->where("user_id",$__user_id); $db->where("default_buyer","0"); $db->delete_();
	}
	echo $f->input("add_address",v("add_address"),"onclick=\"window.location='user_address_add.php'\" type='button'","btn btn-primary");
?>
<script>
	function change_primary(user_address_id){
		window.location="?tabActive=addresses&change_primary="+user_address_id;
	}
	function delete_address(user_address_id){
		if(confirm("<?=v("confirm_delete");?> ?")){
			window.location="?tabActive=addresses&deleting="+user_address_id;
		}
	}
</script>
<div class="row scrolling-wrapper">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th><?=v("address_name");?></th>
				<th><?=v("pic");?></th>
				<th><?=v("address");?></th>
				<th><?=v("phone");?></th>
				<th><?=v("primary_address");?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$user_addresses = $db->fetch_all_data("user_addresses",[],"user_id='".$__user_id."'","id");
				if(count($user_addresses) <= 0){
					?> <tr class="danger"><td colspan="5" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($user_addresses as $user_address){
						$checked = ($user_address["default_buyer"]) ? "checked":"";
						$primary_address = $f->input("primary_address",$user_address["id"],"onchange=\"change_primary('".$user_address["id"]."');\" type='radio' ".$checked);
						$locations = get_location($user_address["location_id"]);
						$location = $user_address["address"];
						$location .= "<br>".$locations[3]["name"];
						$location .= " ".$locations[2]["name"];
						$location .= "<br>".$locations[1]["name"];
						$location .= " ".$locations[0]["name"];
						if($locations[3]["zipcode"] != "") $location .= " - ".$locations[3]["zipcode"];
						?>
						<tr style="cursor:pointer;">
							<td class="nowrap"><?=$user_address["name"];?></td>
							<td class="nowrap"><?=$user_address["pic"];?></td>
							<td><?=$location;?></td>
							<td class="nowrap"><?=$user_address["phone"];?></td>
							<td align="center"><?=$primary_address;?></td>
							<td class="nowrap">
								<?php 
									echo $f->input("edit",v("edit"),"onclick=\"window.location='user_address_edit.php?id=".$user_address["id"]."'\" type='button'","btn btn-primary");
									if(!$user_address["default_buyer"])
										echo "&nbsp;".$f->input("delete",v("delete"),"onclick=\"delete_address('".$user_address["id"]."');\" type='button'","btn btn-warning");
								?>
							</td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>