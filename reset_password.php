<?php  
	include_once "header.php";
	if($__isloggedin){
		javascript("window.location='index.php';");
		exit();
	}
	$user_id = $db->fetch_single_data("a_users","id",["token" => $_GET["token"]]);
	if(!$user_id){
		$_SESSION["errormessage"] = v("request_reset_password_token_expired");
		javascript("window.location='index.php';");
		exit();
	}
	
	if(isset($_POST["newpassword"]) && isset($_POST["repassword"])){
		if($_POST["newpassword"] == $_POST["repassword"]){
			$db->addtable("a_users");	$db->where("id",$user_id);
			$db->addfield("password");	$db->addvalue(base64_encode($_POST["newpassword"]));
			$db->addfield("token");		$db->addvalue("");
			$updating = $db->update();
			if($updating["affected_rows"] > 0){
				$_SESSION["message"] = v("change_password_success").", ".v("please_relogin");
				javascript("window.location=\"index.php\";");
				exit();
			} else {
				$_SESSION["errormessage"] = v("change_password_failed");
			}
		} else {
			$_SESSION["errormessage"] = v("password_error");
		}
	}
?>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<h4 class="well"><b><?=v("reset_password_instruction");?></b></h4>
	</div>
	<div class="row well">
		<div class="col-md-12">
			<div style="height:20px;"></div>
			<form role="form" method="POST" autocomplete="off">
				<div class="form-group">
					<label><?=v("newpassword");?></label><?=$f->input("newpassword","","required placeholder='".v("newpassword")." (".v("range_characters").")...' type='password' pattern='.{6,8}'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("repassword");?></label><?=$f->input("repassword","","required placeholder='".v("repassword")."...' type='password'","form-control");?>
				</div>
				<div class="form-group">
					<?=$f->input("send",v("send"),"type='submit' style='float:right;'","btn btn-primary");?>
				</div>
			</form>
		</div>
	</div>
</div>
<div style="height:20px;"></div>
<?php  include_once "footer.php"; ?>