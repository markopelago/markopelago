<?php 
	include_once "header.php";
	if(!$__isBackofficer){ ?><script> window.location="index.php";</script><?php }
	$step = $_GET["step"]; if(!$step) $step = 1;
	$id = $_GET["id"];
	$template_id = $db->fetch_single_data("surveys","survey_template_id",["id"=>$id]);
?>
<div class="container">
	<h3 class="row well"><b>
		<?=($template_id == 1)?v("seller_survey"):"";?>
		<?=($template_id == 2)?v("forwarder_survey"):"";?>
	</b></h3>
	<div class="row scrolling-wrapper">
		<div class="col-md-12 well">
			<?php 
				if($step == "photo")	include_once "survey_form_photo.php";
				else if($step == 1)		include_once "survey_form_1.php";
				else if($step > 1)		include_once "survey_form_2.php";
			?>
		</div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>