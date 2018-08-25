<div class="container hidden-sm hidden-md hidden-lg">
	<div class="row sub-title-area well">
		<div class="sub-title-text">
			<a class="btn btn-default" href="javascript:window.history.back();"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<?=strtoupper(v("bank"));?>
		</div>
	</div>
</div>
<br><br>
<?php
	if(isset($_GET["banks_change_primary"])){
		$db->addtable("user_banks");$db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("0");
		$db->update();
		$db->addtable("user_banks"); $db->where("id",$_GET["banks_change_primary"]); $db->where("user_id",$__user_id);
		$db->addfield("default_buyer");	$db->addvalue("1");
		$db->update();
		$_SESSION["message"]= v("data_saved_successfully");
	}
	if(isset($_GET["deleting"])){
		$db->addtable("user_banks"); $db->where("id",$_GET["deleting"]); $db->where("user_id",$__user_id); $db->where("default_buyer","0"); $db->delete_();
	}
	echo "<button class='btn btn-primary' onclick=\"window.location='user_bank_add.php'\"><span class='glyphicon glyphicon-plus-sign' title='".v("add_bank")."'></span> ".v("add_bank")."</button>";
	
?>
<script>
	function banks_change_primary(user_bank_id){
		window.location="?tabActive=banks&banks_change_primary="+user_bank_id;
	}
	function delete_bank(user_bank_id){
		if(confirm("<?=v("confirm_delete");?> ?")){
			window.location="?tabActive=banks&deleting="+user_bank_id;
		}
	}
</script>
<div class="row scrolling-wrapper">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th></th>
				<th><?=v("bank");?></th>
				<th><?=v("account_name");?></th>
				<th><?=v("account_no");?></th>
				<th><?=v("branch");?></th>
				<th><?=v("primary_bank");?></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$user_banks = $db->fetch_all_data("user_banks",[],"user_id='".$__user_id."'","id");
				if(count($user_banks) <= 0){
					?> <tr class="danger"><td colspan="5" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($user_banks as $user_bank){
						$checked = ($user_bank["default_buyer"]) ? "checked":"";
						$primary_bank = $f->input("primary_bank",$user_bank["id"],"onchange=\"banks_change_primary('".$user_bank["id"]."');\" type='radio' ".$checked);
						?>
						<tr style="cursor:pointer;">
							<td class="nowrap">
								<?php 
									echo "<button class='btn btn-primary' onclick=\"window.location='user_bank_edit.php?id=".$user_bank["id"]."'\"><span class='glyphicon glyphicon-edit' title='".v("edit")."'></span></button>";
									if(!$user_bank["default_buyer"])
									echo "&nbsp;<button class='btn btn-warning' onclick=\"delete_bank('".$user_bank["id"]."'\"><span class='glyphicon glyphicon-trash' title='".v("delete")."'></span></button>";
								?>
							</td>
							<td class="nowrap"><?=$db->fetch_single_data("banks","name",["id" => $user_bank["bank_id"]]);?></td>
							<td class="nowrap"><?=$user_bank["name"];?></td>
							<td class="nowrap"><?=$user_bank["account_no"];?></td>
							<td class="nowrap"><?=$user_bank["branch"];?></td>
							<td align="center"><?=$primary_bank;?></td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>