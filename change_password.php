<?php 
	include_once "header.php";
	if(isset($_POST["oldpassword"]) && isset($_POST["newpassword"]) && isset($_POST["repassword"])){
		$oldpassword = $db->fetch_single_data("a_users","password",["id" => $__user_id]);
		if($oldpassword == base64_encode($_POST["oldpassword"])){
			if($_POST["newpassword"] == $_POST["repassword"]){
				$db->addtable("a_users");	$db->where("id",$__user_id);
				$db->addfield("password");	$db->addvalue(base64_encode($_POST["newpassword"]));
				$updating = $db->update();
				if($updating["affected_rows"] > 0){
					$_SESSION["message"] = v("change_password_success");
					javascript("window.location=\"index.php\";");
					exit();
				} else {
					$_SESSION["errormessage"] = v("change_password_failed");
				}
			} else {
				$_SESSION["errormessage"] = v("password_error");
			}
		} else {
			$_SESSION["errormessage"] = v("password_error");
		}
		javascript("window.location=\"?\";");
		exit();
	}
?>
<div class="container">
	<h3 class="row well"><b><?=v("change_password");?></b></h3>
	<div class="row scrolling-wrapper">
		<div class="col-md-12 well">
			<form role="form" method="POST" autocomplete="off">
				<div class="form-group">
					<label><?=v("oldpassword");?></label><?=$f->input("oldpassword","","required placeholder='".v("oldpassword")."...' type='password'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("newpassword");?></label><?=$f->input("newpassword","","required placeholder='".v("newpassword")." (".v("range_characters").")...' type='password' pattern='.{6,8}'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("repassword");?></label><?=$f->input("repassword","","required placeholder='".v("repassword")."...' type='password'","form-control");?>
				</div>
				<div class="form-group">
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='index.php';\"","btn btn-warning");?>
					<?=$f->input("save",v("save"),"type='submit'","btn btn-primary");?>
				</div>
			</form>
		</div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>