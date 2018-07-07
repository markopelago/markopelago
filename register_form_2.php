<?php 
	if($_GET["as"] == "seller"){
		include_once "func.crop_image.php";
		$photoW = 200;
		$photoH = 200;
		if(isset($_POST["next"])){
			$error = "";
			$_type = $_FILES["logo"]["type"];
			$_size = $_FILES["logo"]["size"];
			$_error = $_FILES["logo"]["error"];
			$_filename = basename($_FILES["logo"]["name"]);
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
				$filetemp = "logo".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$__user_id.".".$_file_ext;
				if (move_uploaded_file($_FILES["logo"]["tmp_name"], "users_temp/".$filetemp)){
					$db->addtable("sellers");	$db->where("user_id",$__user_id);
					$db->addfield("logo");		$db->addvalue($filetemp);
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
						javascript("window.location='?step=3';"); 
						exit();
					}
				} else {
					$error = v("error_upload_image");
				}
			}
		}
?>
<link href="styles/jquery.guillotine.css" media="all" rel="stylesheet">
<script id="guillotinejs" src="scripts/jquery.guillotine.js?width=<?=$photoW;?>&height=<?=$photoH;?>"></script>
<form action="register.php?step=2" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="mode_photo" value="logo">
	<input type="hidden" name="form_x" value="" id="form_x" />
	<input type="hidden" name="form_y" value="" id="form_y" />
	<input type="hidden" name="form_w" value="" id="form_w" />
	<input type="hidden" name="form_h" value="" id="form_h" />
	<input type="hidden" name="form_scale" value="" id="form_scale" />
	<input type="hidden" name="form_angle" value="" id="form_angle" />
	<div class="col-md-12">
		 <div class="form-group">
			<label><?=v("upload_photo");?></label>
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						<?=v("browse");?>... <input type="file" name="logo" id="imgInp" accept="image/*">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			<br>
			<center>
			<div class="frame" style="border:1px solid grey;width:<?=$photoW;?>px;height:<?=$photoH;?>px;">
				<img id="photo_uploaded">
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
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>
<?php } ?>
<?php if($_GET["as"] == "buyer"){ ?>
	<?php
		if(isset($_POST["next"])){
			$db->addtable("buyers");
			$db->addfield("user_id");			$db->addvalue($__user_id);
			$db->addfield("birthdate");			$db->addvalue($_POST["birthdate"]);
			$db->addfield("birthplace_id");		$db->addvalue($_POST["location_id"]);
			$db->addfield("gender_id");			$db->addvalue($_POST["gender_id"]);
			
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0){ 
				javascript("window.location='?step=3';"); 
			} else {
				$_SESSION["errormessage"] = v("saving_data_failed");
			}
		}
		$data = $_POST;
		$locations = $db->fetch_select_data("locations","id","name_".$__locale,[],"parent_id,seqno");
	?>
	<form role="form" method="POST" autocomplete="off">				
		<div class="col-md-12">
			<div class="form-group">
				<label><?=v("birth_at");?></label><?=$f->input("birthdate",$data["birthdate"],"type='date' required placeholder='".v("store_name")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("birth_place");?></label><?=$f->select("location_id",$locations,$data["location_id"],"required placeholder='".v("birth_place")."...'","form-control");?>
			</div>
			<div class="form-group">
				<label><?=v("gender");?></label><?=$f->select("gender_id",$db->fetch_select_data("genders","id","name_".$__locale),$data["gender_id"],"required placeholder='".v("gender")."...'","form-control");?>
			</div>
			
			
			<div class="form-group">
				<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='mysurvey.php';\"","btn btn-warning");?>
				<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
			</div>
		</div>
	</form>
<?php } ?>