<?php
	echo $f->input("add_goods",v("add_goods"),"onclick=\"window.location='goods_add.php'\" type='button'","btn btn-primary");
	if(isset($_GET["delete_goods"])){
		$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id = '".$_GET["delete_goods"]."'");
		foreach($goods_photos as $goods_photo){
			unlink("goods/".$goods_photo["filename"]);
		}
		$db->addtable("goods_photos");	$db->where("goods_id",$_GET["delete_goods"]); $db->delete_();
		$db->addtable("goods");	$db->where("id",$_GET["delete_goods"]);	$db->delete_();
		javascript("window.history.pushState('','','?tabActive=goods');");
	}
?>
<script>
	function delete_goods(goods_id){
		if(confirm("<?=v("confirm_delete");?>")){
			window.location = "?tabActive=goods&delete_goods="+goods_id;
		}
	}
</script>
<div class="row scrolling-wrapper">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th></th>
				<th><?=v("name");?></th>
				<th><?=v("categories");?></th>
				<th><?=v("description");?></th>
				<th><?=v("price");?></th>
				<th><?=v("condition");?></th>
				<th><?=v("stock");?></th>
				<th><?=v("unit");?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$_goods = $db->fetch_all_data("goods",[],"seller_id='".$__seller_id."'","id");
				if(count($_goods) <= 0){
					?> <tr class="danger"><td colspan="9" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($_goods as $goods){
						$stock = 0;
						$category_ids = pipetoarray($goods["category_ids"]);
						$categories = "";
						foreach($category_ids as $category_id){ $categories .= $db->fetch_single_data("categories","name_".$__locale,["id" => $category_id])."; "; }
						$categories = substr($categories,0,-2);
						
						$img_goods_photo = "";
						$goods_photo = $db->fetch_all_data("goods_photos",[],"goods_id='".$goods["id"]."' ORDER BY seqno")[0];
						if($goods_photo["id"] > 0){
							$filename = $goods_photo["filename"];
							$img_goods_photo = "<img src='goods/".$filename."' width='80'>";
						}
						$onclick = "onclick=\"window.location='goods_view.php?id=".$goods["id"]."';\"";
						?>
						<tr style="cursor:pointer;">
							<td><?=$img_goods_photo;?></td>
							<td <?=$onclick;?> class="nowrap"><?=$goods["name"];?></td>
							<td <?=$onclick;?> class="nowrap"><?=$categories;?></td>
							<td <?=$onclick;?> class="nowrap"><?=$goods["description"];?></td>
							<td <?=$onclick;?> class="nowrap" align="right"><?=format_amount($goods["price"]);?></td>
							<td <?=$onclick;?> class="nowrap"><?=($goods["is_new"] == 1)?v("new"):v("second_hand");?></td>
							<td <?=$onclick;?> class="nowrap" align="right"><?=$stock;?></td>
							<td <?=$onclick;?> class="nowrap" align="right"><?=$db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]]);?></td>
							<td class="nowrap">
								<?php 
									echo $f->input("view",v("view"),"onclick=\"window.location='goods_view.php?id=".$goods["id"]."'\" type='button'","btn btn-primary");
									echo "&nbsp;".$f->input("edit",v("edit"),"onclick=\"window.location='goods_edit.php?id=".$goods["id"]."'\" type='button'","btn btn-primary");
									echo "&nbsp;".$f->input("delete",v("delete"),"onclick=\"delete_goods('".$goods["id"]."');\" type='button'","btn btn-warning");
								?>
							</td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>