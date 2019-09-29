<?php	
	set_time_limit(0);
	ini_set('memory_limit', '-1');
?>
<?php include_once "head.php";?>
<?php include_once "../classes/simplexlsx.class.php";?>
<center><h3><b>Upload Harga Barang</b></h3></center><br>
<?php	
	if(isset($_POST["process"])) {
		$file_name = $_POST["file_name"];
		$xlsx = new SimpleXLSX("../goods_temp/".$file_name);
		$contents = $xlsx->rows($_POST["sheet"]);
		foreach($contents as $key => $rowdata){
			if($key > 0){
				if($rowdata[0] == "") break;
				
				$db->addtable("goods_prices");
				$db->where("goods_id",$rowdata[0]);
				$db->addfield("price");	$db->addvalue($rowdata[1]);
				$updating = $db->update();
				if($updating["affected_rows"] > 0){
					$successresult[$rowdata[0]] = $rowdata[1];
				} else {
					$failedresult[$rowdata[0]] = $rowdata[1];
				}
			}
		}
		echo "<b>Harga barang yang berhasil di update:</b><br>";
		echo "<table border='1'><tr><td><b>Goods Id</b></td><td><b>Goods Name</b></td><td><b>Price</b></td></tr>";
		foreach($successresult as $goods_id => $price){
			$goods_name = $db->fetch_single_data("goods","name",["id" => $goods_id]);
			$goods_price = $db->fetch_single_data("goods_prices","price",["goods_id" => $goods_id]);
			echo "<tr>
					<td>$goods_id</td>
					<td>$goods_name</td>
					<td align='right'>".format_amount($goods_price)."</td>
			</tr>";
		}
		echo "<table><br><br>";
		
		echo "<b>Harga barang yang gagal di update:</b><br>";
		echo "<table border='1'><tr><td><b>Goods Id</b></td><td><b>Goods Name</b></td><td><b>Price</b></td></tr>";
		foreach($failedresult as $goods_id => $price){
			$goods_name = $db->fetch_single_data("goods","name",["id" => $goods_id]);
			$goods_price = $db->fetch_single_data("goods_prices","price",["goods_id" => $goods_id]);
			echo "<tr>
					<td>$goods_id</td>
					<td>$goods_name</td>
					<td align='right'>".format_amount($goods_price)."</td>
			</tr>";
		}
		echo "<table><br>";
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
		<br>
		<a style="font-size:14px;font-weight:bolder;" href="goods_prices_example.xlsx">Download contoh template excel</a>
	</td></tr></table>	
<?php } ?>
<?php include_once "footer.php";?>