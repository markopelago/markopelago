<?php include_once "head.php";?>
<div class="bo_title">Add Banks</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("categories");
		$db->addfield("parent_id");$db->addvalue($_POST["parent_id"]);
		$db->addfield("name_id");$db->addvalue($_POST["name_id"]);
		$db->addfield("name_en");$db->addvalue($_POST["name_en"]);
		$db->addfield("created_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("created_by");		$db->addvalue($__username);
		$db->addfield("created_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] >= 0){
			$insert_id = $inserting["insert_id"];
			?><script> alert('Data Saved'); </script><?php
			?><script> window.location='<?=str_replace("_add","_list",$_SERVER["PHP_SELF"]);?>'; </script><?php
		} else {
			javascript("alert('Saving data failed');");
		}
	}
	
	$name_id = $f->input("name_id",$_POST["name_id"]);
	$name_en = $f->input("name_en",$_POST["name_en"]);
	$parent_id = $f->input("parent_id",$_POST["parent_id"]);
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Parent ID",$parent_id));?>
        <?=$t->row(array("Nama ID",$name_id));?>
        <?=$t->row(array("Nama EN",$name_en));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>