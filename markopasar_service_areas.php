<?php include_once "homepage_header.php"; ?>
<?php
	if(isset($_GET["markopasar_seller_id"])){
		$_SESSION["markopasar_seller_id"] = $_GET["markopasar_seller_id"];
		?><script> window.location = "category_detail.php?category_id=49"; </script><?php
		exit();
	}
?>
<div style="height:20px;"></div>
<div class="container">
	<table <?=$__tblDesign100;?>>
		<tr>
			<td valign="top">
				<div class="goods_list">
					<table width="100%">
						<tr>
						<?php
							$category_ids = [51,52,53,54];
							foreach($category_ids as $key => $category_id){
								// jakarta,tangsel
								// bekasi,depok
								if($key == 1)
									$hreflink = "?markopasar_seller_id=103";
								else
									$hreflink = "?markopasar_seller_id=26";

								echo "<td style=\"width:20%;padding:5px;\"><a href='".$hreflink."'><img style=\"width:100%;height:auto;\" src=\"assets/category_".$category_id.".png\"></a></td>";
								if(($key+1)%2 == 0) echo "</tr><tr>";
							}
						?>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php if(isMobile() && $_GET["category_id"] == "49"){ ?>
	<a href="https://api.whatsapp.com/send?phone=6282161867793&text=" style="position:fixed;right:0px;bottom:20px;z-index:999;display:none;" id="whatsapp_balloon"><img src="icons/whatsapp.png" width="60"></a>
<?php } ?>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>