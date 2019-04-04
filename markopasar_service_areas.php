<?php include_once "homepage_header.php"; ?>
<?php
	if(isset($_GET["markopasar_seller_id"]) && basename($_SESSION["last_page"]) == basename($_SERVER["PHP_SELF"])){
		$_SESSION["markopasar_seller_id"] = $_GET["markopasar_seller_id"];
		if($_SESSION["referrer"]!="") $redirect = $_SESSION["referrer"];
		else $redirect = "category_detail.php?category_id=49";
		$_SESSION["referrer"] = "";
		?><script> window.location = "<?=$redirect;?>"; </script><?php
		exit();
	}
?>
<div style="height:20px;padding-bottom:85px;text-align: center;"><h1>Pilih Area Layanan</h1></div>
<div class="container">
	<table <?=$__tblDesign100;?>>
		<tr>
			<td valign="top">
				<div class="goods_list">
					<table width="100%">
						<tr>
							<td style="width:20%;padding:5px;"><a href="?markopasar_seller_id=26"><img style="width:100%;height:auto;" src="assets/markopasar_service_area_1.png"></a></td>
							<td style="width:20%;padding:5px;"><a href="?markopasar_seller_id=103"><img style="width:100%;height:auto;" src="assets/markopasar_service_area_2.png"></a></td>
						</tr>
						<tr>
							<td style="width:20%;padding:5px;"><a href="?markopasar_seller_id=26"><img style="width:100%;height:auto;" src="assets/markopasar_service_area_3.png"></a></td>
							<td style="width:20%;padding:5px;"><a href="?markopasar_seller_id=26"><img style="width:100%;height:auto;" src="assets/markopasar_service_area_4.png"></a></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<div style="height:40px;padding-bottom:<?=(!isMobile())?"60px":"25%";?>;text-align: center;"><h1>Nantikan layanan di kota kota lainnya</h1></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>