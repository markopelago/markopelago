<?php
	include_once "homepage_header.php";
	if($__seller_id != $db->fetch_single_data("goods","seller_id",["id" => $_GET["id"]])){
		$_SESSION["errormessage"] = v("you_dont_have_access");
		javascript("window.location='dashboard.php?tabActive=goods'");
		exit();
	}
	include_once "func.crop_image.php";
	$photoW = 400;
	$photoH = 400;
	if(isset($_POST["save"])){
		$error = "";
		$_type = $_FILES["goods"]["type"];
		$_size = $_FILES["goods"]["size"];
		$_error = $_FILES["goods"]["error"];
		$_filename = basename($_FILES["goods"]["name"]);
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
			$filetemp = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).date("Ymdhis").$__user_id.".".$_file_ext;
			if (move_uploaded_file($_FILES["goods"]["tmp_name"], "goods_temp/".$filetemp)){
				$seqno = $db->fetch_single_data("goods_photos","seqno",["goods_id" => $_GET["id"]],["seqno DESC"]); $seqno++;
				$db->addtable("goods_photos");
				$db->addfield("goods_id");	$db->addvalue($_GET["id"]);
				$db->addfield("seqno");		$db->addvalue($seqno);
				$db->addfield("filename");	$db->addvalue($filetemp);
				$inserting = $db->insert();
				if($inserting["affected_rows"] > 0){
					$srcimg = "goods_temp/".$filetemp;
					$destimg = "goods/".$filetemp;
					$scale = $_POST["form_scale"];
					$srcwidth = $_POST["form_w"];
					$srcheight = $_POST["form_h"];
					$srcx = $_POST["form_x"];
					$srcy = $_POST["form_y"];
					resizeThumbnailImage_mobile($destimg, $srcimg, $srcwidth, $srcheight, $srcx, $srcy, $photoW, $photoH, $scale);
					chmod($srcimg, 0777);
					unlink($srcimg);
					javascript("window.location='goods_photo.php?id=".$_GET["id"]."';");
					exit();
				}
			} else {
				$error = v("error_upload_image");
			}
		} else {
			$_SESSION["errormessage"] = $error;
		}
	}
	echo $error;
?>
<link href="styles/jquery.guillotine.css" media="all" rel="stylesheet">
<div class="row">	
	<div class="container">
		<h2 class="well"><?=strtoupper(v("add_goods_photo"));?></h2>
		<h3><?=$db->fetch_single_data("goods","name",["id" => $_GET["id"]]);?></h3>
	</div>
	<div class="container">
		<script id="guillotinejs" src="scripts/jquery.guillotine.js?width=<?=$photoW;?>&height=<?=$photoH;?>"></script>
		<form method="POST" enctype="multipart/form-data">
			<input type="hidden" name="mode_photo" value="goods">
			<input type="hidden" name="form_x" value="" id="form_x" />
			<input type="hidden" name="form_y" value="" id="form_y" />
			<input type="hidden" name="form_w" value="" id="form_w" />
			<input type="hidden" name="form_h" value="" id="form_h" />
			<input type="hidden" name="form_scale" value="" id="form_scale" />
			<input type="hidden" name="form_angle" value="" id="form_angle" />
			<div class="col-md-12">
				 <div class="form-group">
					<div class="input-group">
						<span class="input-group-btn">
							<span class="btn btn-default btn-file">
								<?=v("browse");?>... <input type="file" name="goods" id="imgInp" accept="image/*">
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
					<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='dashboard.php';\"","btn btn-warning");?>
					<?=$f->input("save",v("save"),"type='submit'","btn btn-primary");?>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once "footer.php"; ?>