<div style="height:20px;"></div>
<?php 
	if(isset($_POST["save"])){
		$db->addtable("a_users");		$db->where("id",$__user_id);
		$db->addfield("name");			$db->addvalue($_POST["name"]);
		$db->addfield("is_taxable");	$db->addvalue($_POST["name"]);
		if($_POST["is_taxable"] == "1"){
			$db->addfield("npwp");			$db->addvalue($_POST["npwp"]);
			$db->addfield("nppkp");			$db->addvalue($_POST["nppkp"]);
			$db->addfield("npwp_address");	$db->addvalue($_POST["npwp_address"]);
		}
		
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("update_profile_success");
		} else {
			$_SESSION["errormessage"] = v("update_profile_failed");
		}
	}
?>
<script>
	function is_taxable_change(elmChecked){
		if(elmChecked == true){
			document.getElementById("is_taxable_area").style.display = "block";
			document.getElementById("npwp").required = true;
			document.getElementById("npwp_address").required = true;
		} else {
			document.getElementById("is_taxable_area").style.display = "none";
			document.getElementById("npwp").required = false;
			document.getElementById("npwp_address").required = false;
		}
	}
</script>
<form method="POST" >
	<div class="col-sm-9 fadeInRight animated">
		<div class="col-md-12">
			<div class="form-group">
				<label><?=v("name");?></label><?=$f->input("name",$__user["name"],"required placeholder='".v("name")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("is_taxable");?></label><?=$f->input("is_taxable","1","type='checkbox' onclick='is_taxable_change(this.checked);'","form-control");?> <?=v("yes");?>
			</div>
			<div id="is_taxable_area" style="display:none">
				<div class="form-group">
					<label><?=v("npwp");?></label><?=$f->input("npwp",$__user["npwp"],"placeholder='".v("npwp")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("nppkp");?></label><?=$f->input("nppkp",$__user["nppkp"],"placeholder='".v("nppkp")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("npwp_address");?></label><?=$f->textarea("npwp_address",$__user["npwp_address"],"placeholder='".v("npwp_address")."...'","form-control");?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<?=$f->input("save",v("save"),"type='submit' width='75%'","btn btn-primary");?>
	</div>	
</form>
<div style="height:20px;"></div>
<br><br>