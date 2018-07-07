<?php
	if(isset($_POST["next"])){
		if($_POST["password"] != $_POST["repassword"] || strlen($_POST["password"]) < 6 || strlen($_POST["password"]) > 8)
			$_SESSION["errormessage"] = v("password_error");
		
		if($db->fetch_single_data("a_users","id",["email" => $_POST["email"]]) > 0)
			$_SESSION["errormessage"] = v("email_already_in_use");
		
		if($_SESSION["errormessage"] == ""){
			$db->addtable("a_users");
			$db->addfield("group_id");			$db->addvalue("-1");
			$db->addfield("email");				$db->addvalue($_POST["email"]);
			$db->addfield("password");			$db->addvalue(base64_encode($_POST["password"]));
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("is_backofficer");	$db->addvalue(0);
			$db->addfield("status");			$db->addvalue(1);
			$db->addfield("phone");				$db->addvalue($_POST["phone"]);
			if($_POST["is_taxable"]){
				$db->addfield("is_taxable");	$db->addvalue(1);
				$db->addfield("npwp");			$db->addvalue($_POST["npwp"]);
				$db->addfield("nppkp");			$db->addvalue($_POST["nppkp"]);
				$db->addfield("npwp_address");	$db->addvalue($_POST["npwp_address"]);
			}
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				if(login_action($_POST["email"],$_POST["password"])){
					$_SESSION["register_as"] = $_GET["as"];
					if($_GET["as"] == "seller"){
						$db->addtable("sellers");
						$db->addfield("user_id");	$db->addvalue($inserting["insert_id"]);
						$inserting = $db->insert();
					}
					javascript("window.location='?step=2';");
					exit();
				}
			} else {
				$_SESSION["errormessage"] = v("failed_sign_up");
			}
		}
	}
	$data = $_POST;
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
<form role="form" method="POST" autocomplete="off">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("email");?></label><?=$f->input("email",$data["email"],"type='email' required placeholder='".v("email")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("name");?></label><?=$f->input("name",$data["name"],"required placeholder='".v("name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("password");?></label><?=$f->input("password",$data["password"],"type='password' pattern='.{6,8}' required title='".v("range_characters")."' placeholder='".v("password")." (".v("range_characters").") ...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("repassword");?></label><?=$f->input("repassword",$data["repassword"],"type='password' required placeholder='".v("repassword")." ...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required placeholder='".v("phone")."...'","form-control");?>
		</div>
		
		<div class="form-group">
			<label><?=v("is_taxable");?></label><?=$f->input("is_taxable","1","type='checkbox' onclick='is_taxable_change(this.checked);'","form-control");?> <?=v("yes");?>
		</div>
		<div id="is_taxable_area" style="display:none">
			<div class="form-group">
				<label><?=v("npwp");?></label><?=$f->input("npwp",$data["npwp"],"placeholder='".v("npwp")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("nppkp");?></label><?=$f->input("nppkp",$data["nppkp"],"placeholder='".v("nppkp")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("npwp_address");?></label><?=$f->textarea("npwp_address",$data["npwp_address"],"placeholder='".v("npwp_address")."...'","form-control");?>
			</div>
		</div>
		
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>