<?php
	if($db->fetch_single_data("user_banks","id",["user_id" => $__user_id]) > 0){ javascript("window.location='dashboard.php';"); exit(); }
	if(isset($_POST["next"])){
		$db->addtable("user_banks");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("default_buyer");		$db->addvalue("1");
		$db->addfield("default_seller");	$db->addvalue("1");
		$db->addfield("default_forwarder");	$db->addvalue("1");
		$db->addfield("bank_id");			$db->addvalue($_POST["bank_id"]);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("account_no");		$db->addvalue($_POST["account_no"]);
		$db->addfield("branch");			$db->addvalue($_POST["branch"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			javascript("window.location='dashboard.php';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_data");
		}
	}
	$account_name = $db->fetch_single_data("a_users","name",["id" => $__user_id]);
?>
<h3><b>BANK</b></h3>
<form action="register.php?step=3" method="POST" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("bank");?></label><?=$f->select("bank_id",$db->fetch_select_data("banks","id","name",[],["name"],"",true),$user_bank["bank_id"],"required placeholder='".v("bank_name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("account_name");?></label><?=$f->input("name",$account_name,"required placeholder='".v("account_name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("account_no");?></label><?=$f->input("account_no",$user_bank["account_no"],"required placeholder='".v("account_no")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("branch");?></label><?=$f->input("branch",$user_bank["branch"],"placeholder='".v("branch")."...'","form-control");?>
		</div>
	
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>