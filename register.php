<?php 
	include_once "header.php";
	if(isset($_SESSION["register_as"])) $_GET["as"] = $_SESSION["register_as"];
	if(!$_GET["as"]) $_GET["as"] = "null";
	$step = $_GET["step"];
	if(!$step && $_GET["as"] != "null") $step = 1;
	if($__isloggedin && $step == 1){ javascript("window.location='index.php';"); exit(); }
?>
<div class="container">
	<h3 class="row well"><b>
		<?php
			$title_as = "";
			$titleClass = "col-md-12";
			if(isset($_GET["as"]) && $_GET["as"] != "null"){
				echo v("register_as_".$_GET["as"]);
			} else {
				echo "<div style='width:380px;'>";
				echo v("register_as")."&nbsp;";
				echo $f->select("as",[""=>"","seller" => v("seller"), "buyer" => v("buyer")],"","class='form-control' style=\"width:200px;position:relative;float:right;\" onchange=\"window.location='?as='+this.value;\"");
				echo "</div>";
			}
		?>
	</b></h3>
	<div class="row">
		<div class="col-md-12 well">
			<?php 
				if($step == 1) include_once "register_form_".$step.".php";
				else if($step > 1) include_once "register_form_".$_GET["as"]."_".$step.".php";
			?>
		</div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>