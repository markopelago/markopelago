<?php
	include_once "header.php";
	include_once "func.crop_image.php";
	$photoW = 200;
	$photoH = 200;
	if(isset($_POST["save"])){
		$error = "";
		$_type = $_FILES["avatar"]["type"];
		$_size = $_FILES["avatar"]["size"];
		$_error = $_FILES["avatar"]["error"];
		$_filename = basename($_FILES["avatar"]["name"]);
		$_file_ext = strtolower(pathinfo($_filename,PATHINFO_EXTENSION));
		
		$error = "";
		foreach ($allowed_image_types as $mime_type => $ext) {
			if($_type == $mime_type){
				$error = "";
				break;
			}else{
				$error = "Only <strong>".$image_ext."</strong> images accepted for upload<br />";
			}
		}
		if($_error != 0) { $error = v("error_upload_image"); }
		if($_size > ($max_file*1048576)) { $error = str_replace("{max_file}",$max_file,v("image_to_big")); }
		if($error == ""){
			$oldfile = $__buyer["avatar"];
			$filetemp = "avatar".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$__user_id.".".$_file_ext;
			if (move_uploaded_file($_FILES["avatar"]["tmp_name"], "users_temp/".$filetemp)){
				$db->addtable("buyers");	$db->where("user_id",$__user_id);
				$db->addfield("avatar");	$db->addvalue($filetemp);
				$updating = $db->update();
				if($updating["affected_rows"] > 0){
					$srcimg = "users_temp/".$filetemp;
					$destimg = "users_images/".$filetemp;
					$scale = $_POST["form_scale"];
					$srcwidth = $_POST["form_w"];
					$srcheight = $_POST["form_h"];
					$srcx = $_POST["form_x"];
					$srcy = $_POST["form_y"];
					resizeThumbnailImage_mobile($destimg, $srcimg, $srcwidth, $srcheight, $srcx, $srcy, $photoW, $photoH, $scale);
					chmod($srcimg, 0777);
					unlink($srcimg);
					unlink("users_images/".$oldfile);
					$_SESSION["message"] = v("image_saved_successfully");
					javascript("window.location='dashboard.php';");
					exit();
				}
			} else {
				$error = v("error_upload_image");
			}
		} else {
			$_SESSION["errormessage"] = $error;
		}
	}
?>
<link href="styles/jquery.guillotine.css" media="all" rel="stylesheet">
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area well">
		<div class="sub-title-text">
			<?=strtoupper(v("change_avatar"));?>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">	
		<script id="guillotinejs" src="scripts/jquery.guillotine.js?width=<?=$photoW;?>&height=<?=$photoH;?>"></script>
		<form method="POST" enctype="multipart/form-data">
			<input type="hidden" name="save" value="1">
			<input type="hidden" name="mode_photo" value="avatar">
			<input type="hidden" name="form_x" value="" id="form_x" />
			<input type="hidden" name="form_y" value="" id="form_y" />
			<input type="hidden" name="form_w" value="" id="form_w" />
			<input type="hidden" name="form_h" value="" id="form_h" />
			<input type="hidden" name="form_scale" value="" id="form_scale" />
			<input type="hidden" name="form_angle" value="" id="form_angle" />
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							<?=v("browse");?>... <input type="file" name="avatar" id="imgInp" accept="image/*">
						</span>
					</span>
					<input type="text" class="form-control" readonly>
				</div>
				<br>
				<center>
				<div class="frame" style="border:1px solid grey;width:<?=$photoW;?>px;height:<?=$photoH;?>px;">
					<img id="photo_uploaded" src="users_images/<?=$__buyer["avatar"];?>">
				</div>
				</center>
				<br>
				
				<div id="controls" class="">
				  <a href="#" id="rotate_left" title="Rotate left"><i class="fa fa-rotate-left"></i></a>
				  <a href="#" id="zoom_out" title="Zoom out"><i class="fa fa-search-minus"></i></a>
				  <a href="#" id="fit" title="Fit image"><i class="fa fa-arrows-alt"></i></a>
				  <a href="#" id="zoom_in" title="Zoom in"><i class="fa fa-search-plus"></i></a>
				  <a href="#" id="rotate_right" title="Rotate right"><i class="fa fa-rotate-right"></i></a>
				</div>
			</div>
			
			<div class="form-group">
				<?=$f->input("btn_save_goods",v("save"),"type='submit' style='display:none;'","btn btn-primary");?>
				<button class="btn btn-warning" onclick="javascript:window.history.back();"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
				<button style="float:right;" class="btn btn-primary" onclick="btn_save_goods.click();"><?=v("save");?> <span class="glyphicon glyphicon-arrow-right"></span></button>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php";