
<?php include_once "head.php";?>
<div class="bo_title">Edit Unit</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("units");$db->where("id",$_GET["id"]);
		$db->addfield("name_id");$db->addvalue($_POST["name_id"]);
		$db->addfield("name_en");$db->addvalue($_POST["name_en"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){

			?><script> alert('Data Saved'); </script><?php
			?><script> window.location='<?=str_replace("_edit","_list",$_SERVER["PHP_SELF"]);?>'; </script><?php 
			// javascript("alert('Data 
		} else {
			javascript("alert('Saving data failed');");
		}
	}
	
	$db->addtable("units");$db->where("id",$_GET["id"]);$db->limit(1);$pay = $db->fetch_data();
		$name_id = $f->input("name_id",$pay["name_id"]);
	$name_en = $f->input("name_en",$pay["name_en"]);
	
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
          <?=$t->row(array("Name ID",$name_id));?>
        <?=$t->row(array("Name EN",$name_en));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>

<?php include_once "footer.php";?>