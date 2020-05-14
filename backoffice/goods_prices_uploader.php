<?php	
	set_time_limit(0);
	ini_set('memory_limit', '-1');
?>
<?php include_once "head.php";?>
<?php include_once "../classes/simplexlsx.class.php";?>
<center><h3><b>Upload Daftar Barang</b></h3></center><br>
<?php	
	if(isset($_POST["process"])) {
		$file_name = $_POST["file_name"];
		$xlsx = new SimpleXLSX("../goods_temp/".$file_name);
		$contents = $xlsx->rows($_POST["sheet"]);
		foreach($contents as $key => $rowdata){
			if($key > 0){
				if($rowdata[0] == "") break;
				
				$db->addtable("goods");
				$db->addfield("seller_id");			$db->addvalue("103");
				$db->addfield("category_ids");		$db->addvalue("|".$rowdata[1]."|");
				$db->addfield("unit_id");			$db->addvalue($rowdata[2]);
				$db->addfield("name");				$db->addvalue($rowdata[3]);
				$db->addfield("description");		$db->addvalue($rowdata[4]);
				$db->addfield("weight");			$db->addvalue($rowdata[5]);
				$db->addfield("dimension");			$db->addvalue($rowdata[6]);
				$db->addfield("is_new");			$db->addvalue("1");
				$db->addfield("price");				$db->addvalue("0");
				$db->addfield("disc");				$db->addvalue("0");
				$db->addfield("availability_days");	$db->addvalue("1");
				$db->addfield("forwarder_ids");		$db->addvalue("|42||43|");
				$db->addfield("self_pickup");		$db->addvalue("1");
				$db->addfield("pickup_location_id");$db->addvalue("759");
				$db->addfield("is_displayed");		$db->addvalue("1");
				$inserting = $db->insert();
				if($inserting["affected_rows"] > 0){
					$goods_id = $inserting["insert_id"];
					$db->addtable("goods_prices");
					$db->addfield("goods_id");	$db->addvalue($goods_id);
					$db->addfield("qty");		$db->addvalue("1");
					$db->addfield("price");		$db->addvalue($rowdata[7]);
					$db->addfield("commission");$db->addvalue("5");
					$db->insert();
					$filename = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).date("YmdHis")."377.jpg";
					$db->addtable("goods_photos");
					$db->addfield("goods_id");	$db->addvalue($goods_id);
					$db->addfield("seqno");		$db->addvalue("1");
					$db->addfield("filename");	$db->addvalue($filename);
					$db->addfield("caption");	$db->addvalue("");
					$db->insert();
					$successresult[$goods_id] = $filename;
				}
			}
		}
		echo "<b>Barang yang berhasil di upload:</b><br>";
		echo "<table border='1'><tr><td><b>Goods Id</b></td><td><b>Goods Name</b></td><td><b>Price</b></td><td><b>Photo Filename</b></td></tr>";
		foreach($successresult as $goods_id => $filename){
			$goods_name = $db->fetch_single_data("goods","name",["id" => $goods_id]);
			$goods_price = $db->fetch_single_data("goods_prices","price",["goods_id" => $goods_id]);
			echo "<tr>
					<td>$goods_id</td>
					<td>$goods_name</td>
					<td align='right'>".format_amount($goods_price)."</td>
					<td>$filename</td>
			</tr>";
		}
		echo "<table><br><br>";
		unlink("../goods_temp/".$file_name);
	}
	if(isset($_POST["upload"])) {
		$file_name = date("YmdHis").".xlsx";
		move_uploaded_file($_FILES['xlsx']['tmp_name'],"../goods_temp/".$file_name);
		$xlsx = new SimpleXLSX("../goods_temp/".$file_name);
?>
	<table width="100%"><tr><td align="center">
		<table width="100"><tr><td nowrap>
			<?=$f->start();?>
				<fieldset>
					Choose Sheet: <?=$f->select("sheet",$xlsx->sheetNames());?><br><br>
					<?=$f->input("process","Process","type='submit'","btn_sign");?>
				</fieldset>
				<?=$f->input("file_name",$file_name,"type='hidden'");?>
			<?=$f->end();?>
		</td></tr></table>	
	</td></tr></table>	
<?php	
	}
?>

<?php if(!isset($_POST["upload"])) { ?>
	<table width="100%"><tr><td align="center">
		<table width="100"><tr><td nowrap>
		<?=$f->start("","POST","","enctype=\"multipart/form-data\"");?>
			Choose File for Upload : <?=$f->input("xlsx","","type='file' accept='.xlsx'");?>
			<br><br>
			<?=$f->input("upload","Upload","type='submit'","btn_sign");?>
		<?=$f->end();?>
		</td></tr></table>
	</td></tr></table>	
<?php } ?>
<?php include_once "footer.php";?>