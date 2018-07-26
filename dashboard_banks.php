<?php 
	$banks = $db->fetch_all_data("user_banks",[],"user_id='".$__user_id."'")[0];
?>
	
	<div class="col-sm-9 fadeInRight animated">
		<div class="col-md-12">
			<div class="form-group">
				<label><?=v("bank_name");?></label><?=$f->input("bank_name",$banks["name"],"required placeholder='".v("bank_name")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("account_no");?></label><?=$f->input("account_no",$banks["account_no"],"required placeholder='".v("account_no")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("branch");?></label><?=$f->input("branch",$banks["branch"],"required placeholder='".v("branch")."...'","form-control");?>
			</div>
		</div>
	</div>
<br><br>