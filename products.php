<?php include_once "header.php"; ?>
<?php
	if($_GET["s"] == ""){
		$_SESSION["errormessage"] = v("please_type_your_serach");
		javascript("window.location='index.php';");
		exit();
	}
?>
<div style="height:20px;"></div>
<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<?php if(!isMobile()){ ?>
			<td valign="top" style="width:225px;">
				<?php include_once "narrow_the_results.php";?>
			</td>
			<td style="width:30px;"></td>
			<?php } ?>
			<td valign="top">
				<?php include_once "products_results.php";?>
			</td>
		</tr>
	</table>
</div>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>