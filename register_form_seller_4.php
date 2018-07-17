<?php
	if(isset($_POST["finish"])){
		$db->addtable("sellers");			$db->where("user_id",$__user_id);
		$db->addfield("name");				$db->addvalue($_POST["name"]);
		$db->addfield("description");		$db->addvalue($_POST["description"]);
		$db->addfield("pic");				$db->addvalue($_POST["pic"]);
		
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["register_as"] = "";
			javascript("window.location='index.php';"); 
		} else {
			$_SESSION["errormessage"] = v("saving_data_failed");
		}
	}
	$data = $_POST;
?>
<form role="form" method="POST" autocomplete="off">				
	<div class="col-md-12">
		<div class="form-group">
			<label><?=v("store_name");?></label><?=$f->input("name",$data["name"],"type='name' required placeholder='".v("store_name")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("description");?></label><?=$f->textarea("description",$data["description"],"required placeholder='".v("description")."...'","form-control");?>
		</div>
		<div class="form-group">
			<label><?=v("pic");?></label><?=$f->input("pic",$data["pic"],"required placeholder='".v("pic")."...'","form-control");?>
		</div>
	
		
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("finish",v("finish"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>