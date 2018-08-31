<?php
	echo "<button class='btn btn-primary' onclick=\"window.location='goods_add.php'\"><span class='glyphicon glyphicon-plus-sign' title='".v("add_goods")."'></span> ".v("add_goods")."</button>";
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
<br><br>
<div class="container">
	<?php
		$_goods = $db->fetch_all_data("goods",[],"seller_id='".$__seller_id."'","id");
		if(count($_goods) <= 0){
			?> <tr class="danger"><td colspan="2" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
		} else {
			foreach($_goods as $goods){
				$stock_in = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $goods["id"],"in_out" => "in"]);
				$stock_out = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $goods["id"],"in_out" => "out"]);
				$stock = $stock_in - $stock_out;
				$category_ids = pipetoarray($goods["category_ids"]);
				$categories = "";
				foreach($category_ids as $category_id){ $categories .= $db->fetch_single_data("categories","name_".$__locale,["id" => $category_id]).", "; }
				$categories = substr($categories,0,-2);
				
				$img_goods_photo = "";
				$goods_photo = $db->fetch_all_data("goods_photos",[],"goods_id='".$goods["id"]."' ORDER BY seqno")[0];
				if($goods_photo["id"] > 0){
					$filename = $goods_photo["filename"];
					if($filename == "") $filename = "no_goods.png";
					$img_goods_photo = "<img src='goods/".$filename."' style=\"width:200px;\">";
				}
				?>
					<div class="row">
						<div class="well col-md-11">
							<?="<center><b>".$goods["name"]."</b> (".(($goods["is_new"] == 1)?v("new"):v("second_hand")).")<br><br>".
							"".$img_goods_photo."</center><br>".
							"<b>Rp. ".format_amount(get_goods_price($goods["id"])["display_price"])."</b><br>".
							$categories."<br>".
							v("stock")." : ".$stock." ".$db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]])."<br>".
							"<pre class='hidden-xs' style='width:100%;height:150px;'>".$goods["description"]."</pre>".
							"<button style='width:100%;' title='".v("view_detail")."' class='btn btn-primary' onclick=\"window.location='goods_view.php?id=".$goods["id"]."'\"><span class='glyphicon glyphicon-search'></span> ".v("view_detail")."</button>";?>
						</div>
					</div>
				<?php
			}
		}
	?>
</div>