<?php 
	include_once "header.php";
	if(!$__isBackofficer){ ?><script> window.location="index.php";</script><?php }
	$template_id = $_GET["template_id"];
?>
<div class="container">
	<h3 class="row well"><b>
		<?=($template_id == 1)?v("add_seller_survey"):"";?>
		<?=($template_id == 2)?v("add_forwarder_survey"):"";?>
	</b></h3>
	<div class="row scrolling-wrapper">
		<div class="col-md-12 well"><?php include_once "survey_form_1.php";?></div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>