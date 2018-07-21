<?php include_once "head.php";?>
<div class="bo_title">Edit Goods</div>
<?php
	if(isset($_POST["save"])){
		$categoriyids = implode("|", @$_POST['category_ids']);
$categoriyids = mysqli_real_escape_string( mysqli_connect("localhost","root","","markopelago"),$categoriyids); 
		$db->addtable("goods");$db->where("id",$_GET["id"]);
		$db->addfield("name");				$db->addvalue(@$_POST["name"]);
		$db->addfield("seller_id");					$db->addvalue(@$_POST["seller_id"]);
		$db->addfield("unit_id");				$db->addvalue(@$_POST["unit_id"]);
		$db->addfield("promo_id");				$db->addvalue(@$_POST["promo_id"]);
		$db->addfield("barcode");				$db->addvalue(@$_POST["barcode"]);
		$db->addfield("category_ids");				$db->addvalue($categoriyids);
		$db->addfield("description");				$db->addvalue(@$_POST["description"]);
		$db->addfield("weight");				$db->addvalue(@$_POST["weight"]);
		$db->addfield("dimension");				$db->addvalue(@$_POST["dimension"]);
		$db->addfield("disc");				$db->addvalue(@$_POST["disc"]);
		$db->addfield("availability_days");				$db->addvalue(@$_POST["availability_days"]);
		$db->addfield("price");					$db->addvalue(@$_POST["price"]);
		$db->addfield("is_new");					$db->addvalue(@$_POST["is_new"]);
		$db->addfield("updated_at");		$db->addvalue(date("Y-m-d H:i:s"));
		$db->addfield("updated_by");		$db->addvalue($__username);
		$db->addfield("updated_ip");		$db->addvalue($_SERVER["REMOTE_ADDR"]);
		$updating = $db->update();
		if($updating["affected_rows"] >= 0){
			
			?><script> alert('Data Saved'); </script><?php
				?><script> window.location='<?=str_replace("_edit","_list",$_SERVER["PHP_SELF"]);?>'; </script><?php // javascript("alert('Data Saved');");
			// javascript("window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';");
		} else {
			echo $updating["error"];
			javascript("alert('Saving data failed');");
		}
	}
	
	$db->addtable("goods");$db->where("id",$_GET["id"]);$db->limit(1);$good = $db->fetch_data();
	
	$seller 			=  $f->select("seller_id",$db->fetch_select_data("sellers","id","name",null,array("name")),$good["group_id"]);
	$name 			= $f->input("name",@$good["name"]);
	$barcode 			= $f->input("barcode",@$good["barcode"]);
	$seller_id 		= $f->input("seller_id",@$good["seller_id"]);
	$price 			= $f->input("price",@$good["price"]);
	$description 			= $f->input("description",@$good["description"]);
	$unit_id 			= $f->input("unit_id",@$good["unit_id"]);
	$promo_id 			= $f->input("promo_id",@$good["promo_id"]);
	$category_ids 			= $f->input("category_ids",@$good["category_ids"]);
	$weight 			= $f->input("weight",@$good["weight"]);
	$dimension 			= $f->input("dimension",@$good["dimension"]);
	$disc 			= $f->input("disc",@$good["disc"]);
	$is_new 			= $f->input("is_new",@$good["is_new"]);
	$availability_days 			= $f->input("availability_days",@$good["availability_days"]);
	$categorii_ids = explode('|', $good["category_ids"]);
	$categorie="";
$db->addtable("categories"); 
			$categories= $db->fetch_data(true);
foreach ($categories as $key => $categorii) {

				$checked = "";
				foreach($categorii_ids as $category){if($categorii['id'] == $category){$checked = "checked";}}
				$categorie .= $f->input("category_ids[]","".$categorii['id']."","type='checkbox' ".$checked).$categorii['name_id'];
			
				}



	?>
<?=$f->start();?>
	<?=$t->start("","editor_content");?>
        <?=$t->row(array("Seller",$seller));?>
		<?=$t->row(array("Nama",$name));?>
		<?=$t->row(array("Barcode",$barcode));?>
		<?=$t->row(array("Harga",$price));?>
		<?=$t->row(array("description",$description));?>
		<?=$t->row(array("unit_id",$unit_id));?>
		<?=$t->row(array("promo_id",$promo_id));?>
		<tr class=""><td data-content="" valign="top" nowrap="">category</td ><td data-content="" valign="top" style="display: contents;" nowrap=""><?php echo $categorie; ?></td></tr>
		<?=$t->row(array("weight",$weight));?>
		<?=$t->row(array("dimension",$dimension));?>
		<?=$t->row(array("disc",$disc));?>;
		<?=$t->row(array("is_new",$is_new));?>;
		<?=$t->row(array("availability_days",$availability_days));?>
	<?=$t->end();?>
	<?=$f->input("save","Save","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_add","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?=$f->end();?>
<?php include_once "footer.php";?>