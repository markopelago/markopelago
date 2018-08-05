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
		<thead> <?=$t->header(["","",v("name"),v("categories"),v("price"),v("condition"),v("stock"),v("unit"),v("description")]);?> </thead>
		<tbody>
			<?php
				$_goods = $db->fetch_all_data("goods",[],"seller_id='".$__seller_id."'","id");
				if(count($_goods) <= 0){
					?> <tr class="danger"><td colspan="9" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($_goods as $goods){
						$stock_in = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $goods["id"],"in_out" => "in"]);
						$stock_out = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $goods["id"],"in_out" => "out"]);
						$stock = $stock_in - $stock_out;
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
						echo $t->row(
							[
							 "<span title='".v("view")."' class='glyphicon glyphicon-search btn btn-primary' onclick=\"window.location='goods_view.php?id=".$goods["id"]."'\"></span>".
							 "&nbsp;<span title='".v("edit")."' class='glyphicon glyphicon-edit btn btn-primary' onclick=\"window.location='goods_edit.php?id=".$goods["id"]."'\"></span>".
							 "&nbsp;<span title='".v("delete")."' class='glyphicon glyphicon-remove btn btn-warning' onclick=\"delete_goods('".$goods["id"]."');\"></span>",
							 $img_goods_photo,
							 $goods["name"],
							 $categories,
							 format_amount($goods["price"]),
							 ($goods["is_new"] == 1)?v("new"):v("second_hand"),
							 $stock,
							 $db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]]),
							 "<pre style='width:400px;height:150px;'>".$goods["description"]."</pre>"],
							["class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 $onclick." class='nowrap'",
							 ],
							"style='cursor:pointer;'"
						);
					}
				}
			?>
		</tbody>
	</table>
</div>