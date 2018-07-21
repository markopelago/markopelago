	<?php 
		if(isset($_POST["save"])){
			$db->addtable("sellers");
			$db->where("user_id",$__user_id);
			$db->addfield("name");              	$db->addvalue($_POST["name"]);
			$db->addfield("description");           $db->addvalue($_POST["description"]);
			$db->addfield("pic");             		$db->addvalue($_POST["pic"]);
			$inserting = $db->update();
			if($inserting["affected_rows"] > 0){
				$_SESSION["message"] = v("update_profile_success");
			} else {
				$_SESSION["errormessage"] = v("update_profile_failed");
			}
		}
		$sellers = $db->fetch_all_data("sellers",[],"user_id='".$__user_id."'")[0];
		$email = $db->fetch_single_data("a_users","email",["id"=>$__user_id]);
		
		
	?>
	<?php include_once "main_container.php"; ?>
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover({
				trigger : 'hover',
				html : true
			});
		});
	</script>
	<style>
		.tbl_detail td{
			padding-right:30px;
			text-align:center;
		}
	</style>
		<?php 
			//$model_profile = $db->fetch_all_data("model_profiles",[],"user_id='".$_GET["user_id"]."'")[0];
		?>
		
	<form method="POST" >
		<div class="col-sm-9 fadeInRight animated">
			<div class="col-md-12">
				<div class="form-group">
					<label><?=v("name");?></label><?=$f->input("name",$sellers["name"],"required placeholder='".v("name")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("description");?></label><?=$f->textarea("description",$sellers["description"],"required placeholder='".v("description")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("pic");?></label><?=$f->input("pic",$sellers["pic"],"required placeholder='".v("pic")."...'","form-control");?>
				</div>
				<div class="form-group">
					<label><?=v("email");?></label><?=$f->input("email",$email,"required readonly placeholder='".v("email")."...'","form-control");?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<?=$f->input("save",v("save"),"type='submit' width='75%'","btn btn-primary");?>
			<!--input name="save" value="<?=v("save");?>" style="width:75%;" type="button" class="btn btn-primary"--><br><br>
		</div>	
	</form>
		<br><br>