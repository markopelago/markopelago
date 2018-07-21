<<<<<<< HEAD
<?php include_once "head.php";?>
<div class="bo_title">Edit Vehicle Type</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("vehicle_brands");$db->where("id",$_GET["id"]);
		$db->addfield("name");$db->addvalue($_POST["name"]);
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
	
	$db->addtable("vehicle_brands");$db->where("id",$_GET["id"]);$db->limit(1);$veh = $db->fetch_data();
		$name = $f->input("name",$veh["name"]);

	
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
          <?=$t->row(array("Name",$name));?>
        
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
=======
<?php include_once "head.php";?>
<div class="bo_title">Edit Vehicle Type</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("vehicle_brands");$db->where("id",$_GET["id"]);
		$db->addfield("name");$db->addvalue($_POST["name"]);
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
	
	$db->addtable("vehicle_brands");$db->where("id",$_GET["id"]);$db->limit(1);$veh = $db->fetch_data();
		$name = $f->input("name",$veh["name"]);

	
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
          <?=$t->row(array("Name",$name));?>
        
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
>>>>>>> ce5a7f3cd9fe74544b32b77f2e30a309e14e673e
<?php include_once "footer.php";?>