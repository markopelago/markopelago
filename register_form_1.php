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
					$db->addtable("buyers");
					$db->addfield("user_id");		$db->addvalue($inserting["insert_id"]);
					$db->addfield("birthdate");		$db->addvalue($_POST["birthdate"]);
					$db->addfield("birthplace_id");	$db->addvalue($_POST["birthplace_id"]);
					$db->addfield("gender_id");		$db->addvalue($_POST["gender_id"]);
					$inserting = $db->insert();
					javascript("window.location='?step=2';");
					exit();
				}
			} else {
				$_SESSION["errormessage"] = v("failed_sign_up");
			}
		}
	}
	$data = $_POST;
	$provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],"seqno","",true);
	$locations = array();
	$locations[""] = "";
	foreach($provinces as $province_id => $province){
		if($province_id > 0){
			$cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $province_id],"seqno","",true);
			foreach($cities as $city_id => $city){
				$locations[$city_id] = $city;
			}
		}
	}
	asort($locations);
	
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
<form method="POST" autocomplete="off">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("email");?></label><?=$f->input("email",$data["email"],"autocomplete='off' type='email' required placeholder='".v("email")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("name");?></label><?=$f->input("name",$data["name"],"required autocomplete='off' placeholder='".v("name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("password");?></label><?=$f->input("password",$data["password"],"type='password' pattern='.{6,8}' required title='".v("range_characters")."' placeholder='".v("password")." (".v("range_characters").") ...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("repassword");?></label><?=$f->input("repassword",$data["repassword"],"type='password' required placeholder='".v("repassword")." ...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("phone");?></label><?=$f->input("phone",$data["phone"],"required autocomplete='off' placeholder='".v("phone")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("birth_place");?></label><?=$f->select("birthplace_id",$locations,$data["birthplace_id"],"required placeholder='".v("birth_place")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("birth_at");?></label><?=$f->input("birthdate",$data["birthdate"],"type='date' required placeholder='".v("birth_at")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("gender");?></label><?=$f->select("gender_id",$db->fetch_select_data("genders","id","name_".$__locale,"","","",true),$data["gender_id"],"required ","form-control");?>
		</div>
		
		<div class="form-group">
			<?=$f->input("is_taxable","1","type='checkbox' onclick='is_taxable_change(this.checked);'","form-control");?> <?=v("is_taxable");?>
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
			<?=$f->input("terms_and_conditions_agreed","1","type='checkbox' required","form-control");?> <?=v("terms_and_conditions_agreed");?>
		</div>
		
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='index.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>