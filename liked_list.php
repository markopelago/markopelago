<?php include_once "homepage_header.php"; ?>
<?php include_once "footer_tray.php"; ?>
<script>
	function change_sort(sort_id){
		document.getElementById("sort_id").value = sort_id;
		document.getElementById("narrow_result_form").submit();
	}
</script>
<?php $no_categories_filter = true; ?>
<div style="height:20px;"></div>
<div class="container">
	<table <?=$__tblDesign100;?>>
		<tr>
			<?php if(!isMobile()){ ?>
			<td valign="top" style="width:225px;">
				<?php include_once "narrow_the_results.php";?>
			</td>
			<td style="width:30px;"></td>
			<?php } ?>
			<td valign="top">
				<?php include_once "liked_results.php";?>
			</td>
		</tr>
	</table>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>