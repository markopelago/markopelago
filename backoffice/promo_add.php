<?php include_once "head.php";?>
<div class="bo_title">Add Promo</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("promo");
		$db->addfield("name_id");				$db->addvalue(@$_POST["name_id"]);
		$db->addfield("name_en");				$db->addvalue(@$_POST["name_en"]);
		$db->addfield("price");					$db->addvalue(@$_POST["price"]);
		$db->addfield("disc");					$db->addvalue(@$_POST["disc"]);

		$inserting = $db->insert();
		echo "<pre>";
	print_r($inserting);
	echo "</pre>";
		if($inserting["affected_rows"] >= 0){
			$insert_id = $inserting["insert_id"];
			?><script> alert('Data Saved'); </script><?php
			?><script> window.location='<?=str_replace("_add","_list",$_SERVER["PHP_SELF"]);?>'; </script><?php
			// javascript("alert('Data Saved');");
			// javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			echo $inserting["error"];
			javascript("alert('Saving data failed');");
		}
	}
	
	
	$name_id			= $f->input("name_id",@$_POST["name_id"]);
	$name_en 			= $f->input("name_en",@$_POST["name_en"]);
	$price 		= $f->input("price",@$_POST["price"]);
	$disc 			= $f->input("price",@$_POST["disc"]);
	
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Name ID",$name_id));?>
		<?=$t->row(array("Name EN",$name_en));?>
		<?=$t->row(array("Harga",$price));?>
		<?=$t->row(array("Discount (%)",$disc));?>
		
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>