<?php
	include_once "homepage_header.php";
	if(isset($_POST["save_bank"])){
		$db->addtable("user_banks");
		$db->addfield("user_id");			$db->addvalue($__user_id);
		$db->addfield("bank_id");			$db->addvalue($_POST["bank_id"]);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("account_no");		$db->addvalue($_POST["account_no"]);
		$db->addfield("branch");			$db->addvalue($_POST["branch"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='dashboard.php?tabActive=banks';");
			exit();
		} else {
			$_SESSION["error_message"] = v("failed_saving_data");
		}
	}
?>
<div class="row">	
	<div class="container">
		<h4 class="well"><b><?=strtoupper(v("add_bank"));?></b></h4>
	</div>
	<div class="container">
		<form method="POST">
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
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php?tabActive=banks';\"","btn btn-warning");?>
					<?=$f->input("save_bank",v("save"),"type='submit'","btn btn-primary");?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php";