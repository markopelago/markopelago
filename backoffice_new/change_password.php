<?php include_once "head.php";?>
<div class="bo_title">Change Password</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("a_users");					$db->where("id",$__user_id);
		$db->addfield("password");				$db->addvalue(base64_encode($_POST["password"]));
		$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");			$db->addvalue($__username);
		$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			javascript("alert('Data Berhasil tersimpan');");
		} else {
			javascript("alert('Data gagal tersimpan');");
		}
	}
	
	$txt_password 				= $f->input("password","","type='password'");
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
		<?=$t->row(array("New Password",$txt_password));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?>
<?=$f->end();?>
<?php include_once "footer.php";?>