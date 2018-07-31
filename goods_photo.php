<?php include_once "homepage_header.php"; ?>
<div class="container">
	<div class="row">	
		<h2 class="well"><?=strtoupper(v("goods_photos"));?></h2>
		<h3><?=$db->fetch_single_data("goods","name",["id" => $_GET["id"]]);?></h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<?=$f->input("add_goods_photo",v("add_goods_photo"),"onclick=\"window.location='goods_photo_add.php'\" type='button'","btn btn-primary");?>
				<?=$f->input("back_to_dashboard",v("back_to_dashboard"),"onclick=\"window.location='dashboard.php'\" type='button'","btn btn-warning");?>
			</div>
		</div>
	</div>
	<div class="row">
		<?php 
			$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id='".$_GET["id"]."' ORDER BY seqno");
			if(count($goods_photos) <= 0){
				?> <table class="table table-striped table-hover"><tr class="danger"><td colspan="9" align="center"><b><?=v("data_not_found");?></b></td></tr></table> <?php
			} else {
				foreach($goods_photos as $goods_photo){
					?> <div class="img-thumbnail"> 
						<img src="products/<?=$goods_photo["filename"];?>" alt="#"> 
						<div style="height:20px;"></div>
						<div class="form-group">
							<?=$f->input("delete",v("delete"),"onclick=\"delete_goods_photo('".$goods_photo["id"]."');\" type='button' style='width:100%''","btn btn-warning");?>
						</div>
					</div> <?php 
				}
			} 
		?>
	</div>
</div>
<div style="height:20px;"></div>
<?php include_once "footer.php";