<?php
	if(isset($_POST["save_markoantar"])){
		$db->addtable("forwarders");
		if($__forwarder_id > 0)				$db->where("user_id",$__user_id);
		else {
			$db->addfield("user_id");		$db->addvalue($__user_id);
		}
		$db->addfield("name");				$db->addvalue($__marko_id);
		if($__forwarder_id > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='?tabActive=vehicles';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("saving_data_failed");
		}
	}
?>
<script>
	function register_as_markoantar_now(){
		$("#panel_not_a_markoantar").css({"display":"none"});
		$("#markoantar_form_area").css({"display":"block"});
	}
	function cancel_register_as_markoantar_now(){
		$("#panel_not_a_markoantar").css({"display":"block"});
		$("#markoantar_form_area").css({"display":"none"});
	}
</script>
<div id="panel_not_a_markoantar" style="display:<?=($__forwarder_id > 0)?"none":"block";?>">
	<div class="panel panel-warning">
		<div class="panel-heading"><?=v("you_not_yet_markoantar");?></div>
		<div class="panel-body"><?=v("register_as_markoantar_now");?>? <?=$f->input("yes",v("yes"),"type='button' onclick=\"register_as_markoantar_now();\"","btn btn-primary");?></div>
	</div>
</div>
<div id="markoantar_form_area" style="display:<?=($__forwarder_id > 0)?"block":"none";?>;">
	<?php if($__forwarder_id <= 0){ ?>
		<form role="form" method="POST" autocomplete="off">	
			<div class="panel panel-success">
				<div class="panel-heading">
					<?=v("register_as_markoantar_confirmation");?>
					<?=$f->input("save_markoantar",v("agree"),"type='submit'","btn btn-primary");?>
					<?=$f->input("not_agree",v("no"),"type='button' onclick=\"cancel_register_as_markoantar_now();\"","btn btn-warning");?>
				</div>
			</div>
		</form>
	<?php } ?>
</div>