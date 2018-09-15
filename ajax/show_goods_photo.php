<?php 
	include_once "../common.php";
	$goods_id = $_GET["goods_id"];
	$goods_photo_id = $_GET["goods_photo_id"];
	$filename = $db->fetch_single_data("goods_photos","filename",["id" => $goods_photo_id,"goods_id" => $goods_id]);
	if(!file_exists("../goods/".$filename)) $filename = "no_goods.png";
	$next_id = $db->fetch_single_data("goods_photos","id",["goods_id" => $goods_id,"id"=>$goods_photo_id.":>"],["id"]);
	$prev_id = $db->fetch_single_data("goods_photos","id",["goods_id" => $goods_id,"id"=>$goods_photo_id.":<"],["id DESC"]);
	if(!$next_id) $next_id = $db->fetch_single_data("goods_photos","id",["goods_id" => $goods_id],["id"]);
	if(!$prev_id) $prev_id = $db->fetch_single_data("goods_photos","id",["goods_id" => $goods_id],["id DESC"]);
?>
<?php if(isMobile()){ ?>
	<div style="height:360px;overflow: scroll;">
		<img  src="goods/<?=$filename;?>" style="width:600px;">
	</div>
<?php } else { ?>
	<img class="img-responsive" src="goods/<?=$filename;?>" style="width:100%">
<?php } ?>
<table width="100%">
	<tr>
		<td onclick="showGoodsPhoto('<?=$goods_id;?>','<?=$prev_id;?>');" nowrap><i style="font-size:40px;" class="fa fa-arrow-left"></i></td>
		<td onclick="showGoodsPhoto('<?=$goods_id;?>','<?=$next_id;?>');" align="right" nowrap><i style="font-size:40px;" class="fa fa-arrow-right"></i></td>
	</tr>
</table>