<div class="container hidden-sm hidden-md hidden-lg">
	<div class="row sub-title-area well">
		<div class="sub-title-text">
			<a class="btn btn-default" href="javascript:window.history.back();"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<?=strtoupper(v("address"));?>
		</div>
	</div>
</div>
<br><br>
<?php
	if(isset($_GET["addresses_change_primary"])){
		$db->addtable("user_addresses");$db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("0");
		$db->update();
		$db->addtable("user_addresses"); $db->where("id",$_GET["addresses_change_primary"]); $db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("1");
		$db->update();
		$_SESSION["message"]= v("data_saved_successfully");
	}
	if(isset($_GET["addresses_change_store"])){
		$db->addtable("user_addresses");$db->where("user_id",$__user_id);
		$db->addfield("default_seller");	$db->addvalue("0");
		$db->update();
		$db->addtable("user_addresses"); $db->where("id",$_GET["addresses_change_store"]); $db->where("user_id",$__user_id);
		$db->addfield("default_seller");	$db->addvalue("1");
		$db->update();
		$_SESSION["message"]= v("data_saved_successfully");
	}
	if(isset($_GET["deleting"])){
		$db->addtable("user_addresses"); $db->where("id",$_GET["deleting"]); $db->where("user_id",$__user_id); $db->where("default_buyer","0"); $db->delete_();
	}
	if($_SESSION["message"] == v("please_add_your_store_address")){
		echo "<div class='panel panel-warning'><div class='panel-heading'>".$_SESSION["message"]."</div></div>";
		$default_seller = "?default_seller=1";
	}
	echo "<button style='position:relative;display:inline;' class='btn btn-primary' onclick=\"window.location='user_address_add.php".$default_seller."'\">
		<span class='glyphicon glyphicon-plus-sign' title='".v("add_address")."'></span> ".v("add_address")."
	</button>";
	
?>
<script>
	function addresses_change_primary(user_address_id){
		window.location="?tabActive=addresses&addresses_change_primary="+user_address_id;
	}
	function addresses_change_store(user_address_id){
		window.location="?tabActive=addresses&addresses_change_store="+user_address_id;
	}
	function delete_address(user_address_id){
		if(confirm("<?=v("confirm_delete");?> ?")){
			window.location="?tabActive=addresses&deleting="+user_address_id;
		}
	}
</script>
<div class="container">
<div class="row scrolling-wrapper">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th></th>
				<th><?=v("address_name");?></th>
				<th><?=v("pic");?></th>
				<th><?=v("address");?></th>
				<th><?=v("phone");?></th>
				<th><?=v("primary_address");?></th>
				<?php if($__seller_id > 0){ ?> <th><?=v("store");?></th> <?php } ?>
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
						$primary_address = $f->input("primary_address",$user_address["id"],"onchange=\"addresses_change_primary('".$user_address["id"]."');\" type='radio' ".$checked);
						$checked = ($user_address["default_seller"]) ? "checked":"";
						$store_address = $f->input("store_address",$user_address["id"],"onchange=\"addresses_change_store('".$user_address["id"]."');\" type='radio' ".$checked);
						$locations = get_location($user_address["location_id"]);
						$location = $user_address["address"];
						$location .= "<br>".$locations[3]["name"];
						$location .= " ".$locations[2]["name"];
						$location .= "<br>".$locations[1]["name"];
						$location .= " ".$locations[0]["name"];
						if($locations[3]["zipcode"] != "") $location .= " - ".$locations[3]["zipcode"];
						?>
						<tr style="cursor:pointer;">
							<td class="nowrap">
								<?php 
									echo "<button class='btn btn-primary' onclick=\"window.location='user_address_edit.php?id=".$user_address["id"]."'\"><span class='glyphicon glyphicon-edit' title='".v("edit")."'></span></button>";
									if(!$user_address["default_buyer"])
										echo "&nbsp;<button class='btn btn-warning' onclick=\"delete_address('".$user_address["id"]."');\"><span class='glyphicon glyphicon-trash'  title='".v("delete")."'></span></button>";
								?>
							</td>
							<td class="nowrap"><?=$user_address["name"];?></td>
							<td class="nowrap"><?=$user_address["pic"];?></td>
							<td><?=$location;?></td>
							<td class="nowrap"><?=$user_address["phone"];?></td>
							<td align="center"><?=$primary_address;?></td>
							<?php if($__seller_id > 0){ ?> <td align="center"><?=$store_address;?></td> <?php } ?>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
</div>