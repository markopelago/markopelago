<?php
	include_once "header.php";
	include_once "func.crop_image.php";
?>
<div class="container">
	<h3 class="row well"><b><?=v("change_header");?></b></h3>
	<div class="row">
		<div class="col-md-12 well">
			<?php 
				
				$photoW = 1100;
				$photoH = 200;
				if(isset($_POST["next"])){
					$error = "";
					$_type = $_FILES["header_image"]["type"];
					$_size = $_FILES["header_image"]["size"];
					$_error = $_FILES["header_image"]["error"];
					$_filename = basename($_FILES["header_image"]["name"]);
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
						$filetemp = "header".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).$__user_id.".".$_file_ext;
						if (move_uploaded_file($_FILES["header_image"]["tmp_name"], "users_temp/".$filetemp)){
							$db->addtable("sellers");	$db->where("user_id",$__user_id);
							$db->addfield("header_image");		$db->addvalue($filetemp);
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
								javascript("window.location='dashboard.php?tabActive=seller';"); 
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
			<form method="POST" enctype="multipart/form-data">
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
									<?=v("browse");?>... <input type="file" name="header_image" id="imgInp" accept="image/*">
								</span>
							</span>
							<input type="text" class="form-control" readonly>
						</div>
						<br>
						<center>
						<div class="frame header-image-frame">
							<img id="photo_uploaded" src="users_images/<?=($__seller["header_image"] == "")?"no_header.jpg":$__seller["header_image"];?>">
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
						<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php';\"","btn btn-warning");?>
						<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>