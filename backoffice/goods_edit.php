<?php include_once "head.php";?>
<div class="bo_title">Edit Goods</div>
<?php
	if(isset($_POST["save"])){
		$db->addtable("goods");
		$db->addfield("store_id");				$db->addvalue(@$_POST["store_id"]);
		$db->addfield("name");					$db->addvalue(@$_POST["name"]);
		$db->addfield("link_marko");				$db->addvalue(@$_POST["link_marko"]);
		$db->addfield("price");					$db->addvalue(@$_POST["price"]);
		$db->addfield("detail");					$db->addvalue(@$_POST["detail"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			
			?><script> alert('Data Saved'); </script><?php
			?><script> window.location='<?=str_replace("_add","_list",$_SERVER["PHP_SELF"]);?>'; </script><?php
			// javascript("alert('Data Saved');");
			// javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			echo $inserting["error"];
			javascript("alert('Saving data failed');");
		}
	}
	
	$db->addtable("goods");$db->where("id",$_GET["id"]);$db->limit(1);$good = $db->fetch_data();
	echo "<pre>";
	print_r($good);
	echo "</pre>";
	$store_id 			= $f->select("store_id",$db->fetch_select_data("stores","id","name",null,array("name"),"",true),$good["store_id"]);
	$name 			= $f->input("name",@$good["name"]);
	$link_marko 		= $f->input("link_marko",@$good["link_marko"]);
	$price 			= $f->input("price",@$good["price"]);
	$detail 			= $f->input("detail",@$good["detail"]);
?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Store",$store_id));?>
		<?=$t->row(array("Nama",$name));?>
		<?=$t->row(array("URL",$link_marko));?>
		<?=$t->row(array("Harga",$price));?>
		<?=$t->row(array("Detail",$detail));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>