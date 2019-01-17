<?php 
	include_once "header.php";
	$step = $_GET["step"];
	if(!$step) $step = 1;
	if($__isloggedin && $step == 1){ javascript("window.location='index.php';"); exit(); }
	if(isset($_POST["save"])){
		$errors = array();
		$haserrors= false;
		if(!preg_match('/^[\w]+$/', $_POST["marko_id"])){
			$haserrors= true;
			$errors["marko_id"] = v("marko_id_invalid_char");
		}
		if(strlen($_POST["marko_id"]) < 6){
			$haserrors= true;
			$errors["marko_id"] = v("marko_id_invalid_length");
		}
		if($db->fetch_single_data("a_users","id",["marko_id" => $_POST["marko_id"]]) > 0){
			$haserrors= true;
			$errors["marko_id"] = v("marko_id_exist");
		}
		if($_POST["password"] != $_POST["repassword"]){
			$haserrors= true;
			$errors["password"] = v("password_error");
		}
		if($db->fetch_single_data("a_users","id",["email" => $_POST["email"]]) > 0){
			$haserrors= true;
			$errors["email"] = v("email_already_in_use");
		}
        if($db->fetch_single_data("a_users","id",["phone" => $_POST["phone"]]) > 0){
			$haserrors= true;
			$errors["phone"] = v("phone_already_in_use");
		}
        if($_POST["email"] == ''){
            $email = $_POST["marko_id"]."@markopelago.com";
            $send_email = false;
        }else{
            $email = $_POST["email"];
            $send_email = true;
        }
        
		
		if(!$haserrors){
			$db->addtable("a_users");
			$db->addfield("marko_id");			$db->addvalue(strtolower($_POST["marko_id"]));
			$db->addfield("group_id");			$db->addvalue("-1");
			$db->addfield("email");				$db->addvalue($email);
			$db->addfield("password");			$db->addvalue(base64_encode($_POST["password"]));
			$db->addfield("name");				$db->addvalue($_POST["name"]);
			$db->addfield("is_backofficer");	$db->addvalue(0);
			$db->addfield("status");			$db->addvalue(1);
			$db->addfield("phone");				$db->addvalue($_POST["phone"]);
			
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){
				$user_id = $inserting["insert_id"];
				if(login_action($email,$_POST["password"])){
					$db->addtable("buyers");
					$db->addfield("user_id");		$db->addvalue($user_id);
					$db->addfield("birthdate");		$db->addvalue($_POST["birthdate"]);
					$db->addfield("birthplace_id");	$db->addvalue($_POST["birthplace_id"]);
					$db->addfield("gender_id");		$db->addvalue($_POST["gender_id"]);
					$inserting = $db->insert();
					if($send_email == true){
                        $token = randtoken(15).base64_encode("_signup_".$_POST["email"]);
                        $db->addtable("a_users");	$db->where("id",$user_id);
                        $db->addfield("token");		$db->addvalue($token);
                        $db->update();
                        $arr1 = ["{link}"];
                        $arr2 = ["https://www.markopelago.com/email_confirmation.php?token=".$token];
                        $body = read_file("html/email_signup_confirmation_id.html");
                        $body = str_replace($arr1,$arr2,$body);
                        sendingmail("Markopelago.com -- Email Konfirmasi",$_POST["email"],$body,"system@markopelago.com|Markopelago System");
                    }
					
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
<script>
    function suggestion_markoid(name){
		$.get("ajax/suggest_markoid.php?mode=getMarkoID&name="+name, function(returnval){
			//alert(returnval);
			document.getElementById("marko_id").value = returnval;
			
		});
	}
</script>

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
								<?=$f->input("save","1","type='hidden'");?>
                                <div class="form-group required">
									<label class="control-label"><?=v("name");?></label><?=$f->input("name",$data["name"],"onchange=\"suggestion_markoid(this.value);\" required autocomplete='off' placeholder='".v("name")."...'","form-control");?>
								</div>
								<div class="form-group required">
									<?php 
										if($errors["marko_id"]){
											echo "<div class='callout top-left' style='margin-left:50px;'>".$errors["marko_id"]."</div>";
											$marko_id_style = "style=\"background-color:rgba(248,166,168,0.8);\"";
										}
									?>
									<label class="control-label">Marko ID</label><?=$f->input("marko_id",$data["marko_id"],$marko_id_style." autocomplete='off' required placeholder='Marko ID...'","form-control");?>
									<?php
										
									?>
								</div>
								<div class="form-group">
									<?php 
										if($errors["email"]){
											echo "<div class='callout top-left' style='margin-left:50px;'>".$errors["email"]."</div>";
											$email_style = "style=\"background-color:rgba(248,166,168,0.8);\"";
										}
									?>
									<label><?=v("email");?></label>
									<?=$f->input("email",$data["email"],$email_style." autocomplete='off' type='email' placeholder='".v("email")."...'","form-control");?>
								</div>
								<div class="form-group required">
                                    <?php 
										if($errors["phone"]){
											echo "<div class='callout top-left' style='margin-left:50px;'>".$errors["phone"]."</div>";
											$email_style = "style=\"background-color:rgba(248,166,168,0.8);\"";
										}
									?>
									<label class="control-label"><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required autocomplete='off' placeholder='".v("phone")."...'","form-control");?>
								</div>
								<div class="form-group required">
									<?php 
										if($errors["password"]){
											echo "<div class='callout top-left' style='margin-left:50px;'>".$errors["password"]."</div>";
											$password_style = "style=\"background-color:rgba(248,166,168,0.8);\"";
										}
									?>
									<label class="control-label"><?=v("password");?></label><?=$f->input("password",$data["password"],$password_style." type='password' required placeholder='".v("password")." ...'","form-control");?>
								</div>
								<div class="form-group required">
									<label class="control-label"><?=v("repassword");?></label><?=$f->input("repassword",$data["repassword"],"type='password' required placeholder='".v("repassword")." ...'","form-control");?>
								</div>
								<div class="form-group">
									<button class="btn btn-default" type="submit"><?=v("register");?></button>
								</div>
							</form>
							<p style="font-size: 0.8em"><?=v("you_will_receive_notifications");?></p>
						</div>
					</td>
				</tr>
			</table>
		</td></tr></table>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>