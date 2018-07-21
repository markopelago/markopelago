<?php include_once "head.php";?>
<div class="bo_title">Edit Promo</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("promo");$db->where("id",$_GET["id"]);
		$db->addfield("name_id");$db->addvalue($_POST["name_id"]);
		$db->addfield("name_en");$db->addvalue($_POST["name_en"]);
		$db->addfield("price");$db->addvalue($_POST["price"]);
		$db->addfield("disc");$db->addvalue($_POST["disc"]);
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
	
	$db->addtable("promo");$db->where("id",$_GET["id"]);$db->limit(1);$unit = $db->fetch_data();
	$name_id = $f->input("name_id",$unit["name_id"]);
	$name_en = $f->input("name_en",$unit["name_en"]);
	$price = $f->input("price",$unit["price"]);
	$disc = $f->input("disc",$unit["disc"]);
	
?>
<?=$f->start("","POST","","enctype='multipart/form-data'");?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Nama ID",$name_id));?>
        <?=$t->row(array("Nama EN",$name_en));?>
        <?=$t->row(array("Price",$price));?>
        <?=$t->row(array("Disc",$disc));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_edit","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>