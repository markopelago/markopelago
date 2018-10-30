<?php 
	include_once "header.php";
	$step = $_GET["step"];
	if(!$step) $step = 1;
	if($__isloggedin && $step == 1){ javascript("window.location='index.php';"); exit(); }
	if(isset($_POST["next"])){
		if($_POST["password"] != $_POST["repassword"] || strlen($_POST["password"]) < 6 || strlen($_POST["password"]) > 8)
			$_SESSION["errormessage"] = v("password_error");
		
		if($db->fetch_single_data("a_users","id",["email" => $_POST["email"]]) > 0)
			$_SESSION["errormessage"] = v("email_already_in_use");
		
		if($_SESSION["errormessage"] == ""){
			$db->addtable("a_users");
			$db->addfield("marko_id");			$db->addvalue($_POST["marko_id"]);
			$db->addfield("group_id");			$db->addvalue("-1");
			$db->addfield("email");				$db->addvalue($_POST["email"]);
			$db->addfield("password");			$db->addvalue(base64_encode($_POST["password"]));
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("is_backofficer");	$db->addvalue(0);
			$db->addfield("status");			$db->addvalue(1);
			$db->addfield("phone");				$db->addvalue($_POST["phone"]);
			
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$user_id = $inserting["insert_id"];
				if(login_action($_POST["email"],$_POST["password"])){
					$db->addtable("buyers");
					$db->addfield("user_id");		$db->addvalue($user_id);
					$db->addfield("birthdate");		$db->addvalue($_POST["birthdate"]);
					$db->addfield("birthplace_id");	$db->addvalue($_POST["birthplace_id"]);
					$db->addfield("gender_id");		$db->addvalue($_POST["gender_id"]);
					$inserting = $db->insert();
					
					$token = randtoken(15).base64_encode("_signup_".$_POST["email"]);
					$db->addtable("a_users");	$db->where("id",$user_id);
					$db->addfield("token");		$db->addvalue($token);
					$db->update();
					$arr1 = ["{link}"];
					$arr2 = ["https://www.markopelago.com/email_confirmation.php?token=".$token];
					$body = read_file("html/email_signup_confirmation_id.html");
					$body = str_replace($arr1,$arr2,$body);
					sendingmail("Markopelago.com -- Email Konfirmasi",$_POST["email"],$body,"system@markopelago.com|Markopelago System");
					
					$_SESSION["message"] = v("signup_success");
					javascript("window.location='index.php';");
					exit();
				}
			} else {
				$_SESSION["errormessage"] = v("failed_sign_up");
			}
		}
	}
	$data = $_POST;
?>
<div class="container">
	<div class="row">
		<table width="80%"><tr><td valign="top" align="center">
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>&nbsp;</td>
					<td><br><br><img src="images/logo.png" height="75"></td>
				</tr>
				<tr>
					<td>
						<div class="register_page_background hidden-xs hidden-sm"></div>
					</td>
					<td>
						<div class="register_form_background">
							<form method="POST" autocomplete="off">
								<div class="form-group">
									<label>Marko ID</label><?=$f->input("marko_id",$data["marko_id"],"autocomplete='off' required placeholder='Marko ID...'","form-control");?>
								</div>
								<div class="form-group">
									<label><?=v("name");?></label><?=$f->input("name",$data["name"],"required autocomplete='off' placeholder='".v("name")."...'","form-control");?>
								</div>
								<div class="form-group">
									<label><?=v("email");?></label>
									<?=$f->input("email",$data["email"],"autocomplete='off' type='email' required placeholder='".v("email")."...'","form-control");?>
								</div>
								<div class="form-group">
									<label><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required autocomplete='off' placeholder='".v("phone")."...'","form-control");?>
								</div>
								<div class="form-group">
									<label><?=v("password");?></label><?=$f->input("password",$data["password"],"type='password' pattern='.{6,8}' required title='".v("range_characters")."' placeholder='".v("password")." (".v("range_characters").") ...'","form-control");?>
								</div>
								<div class="form-group">
									<label><?=v("repassword");?></label><?=$f->input("repassword",$data["repassword"],"type='password' required placeholder='".v("repassword")." ...'","form-control");?>
								</div>
								<div class="form-group">
									<button class="btn btn-default" type="submit"><?=v("register");?></button>
								</div>
							</form>
						</div>
					</td>
				</tr>
			</table>
		</td></tr></table>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>