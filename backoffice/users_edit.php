<?php include_once "head.php";?>
<div class="bo_title">Edit User</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("a_users");				$db->where("id",$_GET["id"]);
		$db->addfield("group_id");				$db->addvalue($_POST["group_id"]);
		$db->addfield("email");					$db->addvalue($_POST["email"]);
		$db->addfield("name");					$db->addvalue($_POST["name"]);
		if($_POST["password"] !="" ) {
			$db->addfield("password");			$db->addvalue(base64_encode($_POST["password"]));
		}
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			javascript("alert('Data Saved');");
			javascript("window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			javascript("alert('Saving data failed');");
		}
	}
	
	$db->addtable("a_users");$db->where("id",$_GET["id"]);$db->limit(1);$users = $db->fetch_data();
	$sel_group 			= $f->select("group_id",$db->fetch_select_data("a_groups","id","name",null,array("name")),$users["group_id"]);
	$txt_email 			= $f->input("email",$users["email"]);
	$txt_password 		= $f->input("password","","type='password'");
	$txt_name 			= $f->input("name",$users["name"]);
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Group",$sel_group));?>
		<?=$t->row(array("Email",$txt_email));?>
		<?=$t->row(array("Password",$txt_password));?>
		<?=$t->row(array("Name",$txt_name));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>