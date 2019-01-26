<?php include_once "homepage_header.php"; ?>
<?php include_once "footer_tray.php"; ?>
<?php
	if($_GET["s"] == ""){
		$_SESSION["errormessage"] = v("please_type_your_serach");
		javascript("window.location='index.php';");
		exit();
	}
?>
<script>
	function change_sort(sort_id){
		document.getElementById("sort_id").value = sort_id;
		document.getElementById("narrow_result_form").submit();
	}
	
	function change_search_mode(mode){
		document.getElementById("goods_tab_img").src="assets/goods_tab_inactive.png";
		document.getElementById("sellers_tab_img").src="assets/sellers_tab_inactive.png";
		document.getElementById(mode+"_tab_img").src="assets/"+mode+"_tab_active.png";
		$('#goods_tab_span').removeClass('active').addClass('inactive');
		$('#sellers_tab_span').removeClass('active').addClass('inactive');
		$('#'+mode+'_tab_span').removeClass('inactive').addClass('active');
		$('#div_goods_results').hide();
		$('#div_sellers_results').hide();
		$('#div_'+mode+'_results').show();
	}
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
				<div class="goods_list_search_result"><?=v("search_result");?> <div class="search_result_value">"<?=$_GET["s"];?>"</div></div><br><br>
				<div class="searchpage_tab_area">
					<a href="javascript:change_search_mode('goods');">
						<img class="searchpage_img_tab" id="goods_tab_img" src="assets/goods_tab_active.png">&nbsp;&nbsp;<span id="goods_tab_span" class="searchpage_span_tab active"><?=v("goods");?>
					</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="javascript:change_search_mode('sellers');">
						<img class="searchpage_img_tab" id="sellers_tab_img" src="assets/sellers_tab_inactive.png">&nbsp;&nbsp;<span id="sellers_tab_span" class="searchpage_span_tab inactive"><?=v("seller");?>
					</a>
					<div class="searchpage_underline_tab"></div>
				</div>
				<div id="div_goods_results">
					<?php include_once "products_results.php";?>
				</div>
				<div id="div_sellers_results" style="display:none;">
					<?php include_once "sellers_results.php";?>
				</div>
			</td>
		</tr>
	</table>
</div>
<div style="height:40px;"></div>
<?php include_once "categories_footer.php"; ?>
<?php include_once "footer.php"; ?>