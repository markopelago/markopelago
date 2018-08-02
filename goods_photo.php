<?php 
	include_once "homepage_header.php"; 
	if($__seller_id != $db->fetch_single_data("goods","seller_id",["id" => $_GET["id"]])){
		$_SESSION["errormessage"] = v("you_dont_have_access");
		javascript("window.location='dashboard.php?tabActive=goods'");
		exit();
	}
	if(isset($_GET["delete_goods_photo"])){
		$filedelete = $db->fetch_single_data("goods_photos","filename",["id"=>$_GET["delete_goods_photo"],"goods_id" => $_GET["id"]]);
		$db->addtable("goods_photos");	$db->where("id",$_GET["delete_goods_photo"]);	$db->where("goods_id",$_GET["id"]); $db->delete_();
		unlink("goods/".$filedelete);
		$goods_photos = $db->fetch_all_data("goods_photos",[],"id > '".$_GET["delete_goods_photo"]."'");
		foreach($goods_photos as $goods_photo){
			$db->addtable("goods_photos");	$db->where("id",$goods_photo["id"]);
			$db->addfield("seqno");			$db->addvalue($goods_photo["seqno"]-1);
			$db->update();
		}
		javascript("window.history.pushState('','','?id=".$_GET["id"]."');");
	}
?>
<script>
	function delete_goods_photo(goods_photo_id){
		if(confirm("<?=v("are_you_sure_delete_photo");?>")){
			window.location = "?id=<?=$_GET["id"];?>&delete_goods_photo="+goods_photo_id;
		}
	}
</script>
<div class="container">
	<div class="row">	
		<h2 class="well"><?=strtoupper(v("goods_photos"));?></h2>
		<h3><?=$db->fetch_single_data("goods","name",["id" => $_GET["id"]]);?></h3>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<?=$f->input("add_goods_photo",v("add_goods_photo"),"onclick=\"window.location='goods_photo_add.php?id=".$_GET["id"]."'\" type='button'","btn btn-primary");?>
				<?=$f->input("back_to_dashboard",v("back_to_dashboard"),"onclick=\"window.location='dashboard.php?tabActive=goods'\" type='button'","btn btn-warning");?>
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
						<img src="goods/<?=$goods_photo["filename"];?>" alt="#"> 
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
<?php include_once "footer.php"; ?>