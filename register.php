<?php 
	include_once "header.php";
	$step = $_GET["step"];
	if(!$step) $step = 1;
	if($__isloggedin && $step == 1){ javascript("window.location='index.php';"); exit(); }
?>
<div class="container">
	<h3 class="row well"><b> <?=v("register");?></b></h3>
	<div class="row">
		<div class="col-md-12 well">
			<?php include_once "register_form_".$step.".php"; ?>
		</div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>