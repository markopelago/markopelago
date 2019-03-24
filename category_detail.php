<?php include_once "homepage_header.php"; ?>
<?php include_once "footer_tray.php"; ?>
<script>
	var whatsapp_balloon = "none";
	function change_sort(sort_id){
		document.getElementById("sort_id").value = sort_id;
		document.getElementById("narrow_result_form").submit();
	}

	$(document).scroll(function(){ 
		$("#whatsapp_balloon").css("display","none");
		clearTimeout($.data(this, 'scrollTimer'));
	    $.data(this, 'scrollTimer', setTimeout(function() {
			$("#whatsapp_balloon").css("display","block");
	    }, 1500));
	});
	
	$(document).ready(function() {
		setTimeout(function(){ $("#whatsapp_balloon").css("display","block"); }, 1500);
	});
</script>
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
				<?php include_once "category_detail_results.php";?>
			</td>
		</tr>
	</table>
</div>
<?php if(isMobile() && $_GET["category_id"] == "49" && !$_COOKIE["android_apps"]){ ?>
	<a href="https://api.whatsapp.com/send?phone=6282161867793&text=" style="position:fixed;right:0px;bottom:20px;z-index:999;display:none;" id="whatsapp_balloon"><img src="icons/whatsapp.png" width="60"></a>
<?php } ?>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>