<?php
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
?>
<?php if($_GET["as"] == "seller"){ ?>
<link href="styles/jquery.guillotine.css" media="all" rel="stylesheet">
<script id="guillotinejs" src="scripts/jquery.guillotine.js?width=200&height=200"></script>
<form id="frmUploadPhoto" role="form" method="POST" autocomplete="off">
	<input type="hidden" name="seeker_photo" value="" id="seeker_photo" />
	<input type="hidden" name="form_x" value="" id="form_x" />
	<input type="hidden" name="form_y" value="" id="form_y" />
	<input type="hidden" name="form_w" value="" id="form_w" />
	<input type="hidden" name="form_h" value="" id="form_h" />
	<input type="hidden" name="form_scale" value="" id="form_scale" />
	<input type="hidden" name="form_angle" value="" id="form_angle" />
	<div class="col-md-12">
		 <div class="form-group">
			<label>Upload Image</label>
			<div class="input-group">
				<span class="input-group-btn">
					<span class="btn btn-default btn-file">
						Browse… <input type="file" id="imgInp" accept="image/*">
					</span>
				</span>
				<input type="text" class="form-control" readonly>
			</div>
			<br>
			<center>
			<div class="frame" style="border:1px solid grey;width:200px;height:200px;">
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