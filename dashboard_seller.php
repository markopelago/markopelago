<?php
	if(isset($_POST["save_seller"])){
		$db->addtable("sellers");
		if($__seller_id > 0)				$db->where("user_id",$__user_id);
		else {
			$db->addfield("user_id");		$db->addvalue($__user_id);
		}
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("description");		$db->addvalue($_POST["description"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		if($__seller_id > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='?tabActive=seller';"); 
			exit();
		} else {
			$_SESSION["errormessage"] = v("saving_data_failed");
		}
	}
	$seller = $db->fetch_all_data("sellers",[],"user_id = '".$__user_id."'")[0];
?>
<script>
	function register_as_seller_now(){
		$("#panel_not_a_seller").css({"display":"none"});
		$("#seller_form_area").css({"display":"block"});
	}
</script>
<div id="panel_not_a_seller" style="display:<?=($__seller_id > 0)?"none":"block";?>">
	<div class="panel panel-warning">
		<div class="panel-heading"><?=v("you_not_yet_seller");?></div>
		<div class="panel-body"><?=v("register_as_seller_now");?>? <?=$f->input("yes",v("yes"),"type='button' onclick=\"register_as_seller_now();\"","btn btn-primary");?></div>
	</div>
</div>
<div id="seller_form_area" style="display:<?=($__seller_id > 0)?"block":"none";?>;">
	<?php if($__seller_id > 0){ ?>
	<center>
		<div><img id="mainProfileImg" src="users_images/<?=($__seller["logo"] == "")?"nologo.jpg":$__seller["logo"];?>"></div>
		<div><input name="change_logo" id="change_logo" value="<?=v("change_logo");?>" style="width:200px;position:relative;top:-32px;" type="button" onclick="window.location='dashboard_seller_logo.php';" class="btn btn-primary"></div>
		<br><br>
	</center>
	<?php } ?>
	<form role="form" method="POST" autocomplete="off">	
		<div class="col-md-12">
			<div class="form-group">
				<label><?=v("store_name");?></label><?=$f->input("name",$seller["name"],"type='name' required placeholder='".v("store_name")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("description");?></label><?=$f->textarea("description",$seller["description"],"required placeholder='".v("description")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("pic");?></label><?=$f->input("pic",$seller["pic"],"required placeholder='".v("pic")."...'","form-control");?>
			</div>	
			
			<div class="form-group">
				<?=$f->input("save_seller",v("save"),"type='submit'","btn btn-primary");?>
			</div>
		</div>
	</form>
</div>