<?php  
	include_once "header.php";
	if($__isloggedin){
		javascript("window.location='index.php';");
		exit();
	}
	if(isset($_POST["send"])){
		$user_id = $db->fetch_single_data("a_users","id",["email" => $_POST["email"]]);
		if($user_id > 0){
			$token = $db->fetch_single_data("a_users","token",["id" => $user_id]);
			if($token == ""){
				$token = randtoken(15).base64_encode("_resetpass_".$_POST["email"]);
				$db->addtable("a_users");	$db->where("id",$user_id);
				$db->addfield("token");		$db->addvalue($token);
				$db->update();				
			}
			$link = "https://www.markopelago.com/reset_password.php?token=".$token;
			$body = read_file("html/email_forgot_password_id.html");
			$body = str_replace(["{email}","{link}",chr(13).chr(10)],[$_POST["email"],$link,"<br>"],$body);
			sendingmail("Markopelago.com -- ".v("reset_password_instruction"),$_POST["email"],$body,"system@markopelago.com|Markopelago System");
			$_SESSION["message"] = v("reset_password_instruction_sent");
			javascript("window.location='index.php';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("your_email_not_exist");
		}
	}
?>
<div style="height:20px;"></div>
<div class="container">
	<div class="row">
		<h4 class="well"><b><?=v("forgot_password");?></b></h4>
	</div>
	<div class="row well">
		<div class="col-md-12">
			<?=v("request_reset_password");?>
			<div style="height:20px;"></div>
			<form role="form" method="POST" autocomplete="off">
				<div class="form-group">
					<?=$f->input("email","","required placeholder='".v("email")."...' type='email'","form-control");?>
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