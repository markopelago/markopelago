<?php
	echo $f->input("add_goods",v("add_goods"),"onclick=\"window.location='goods_add.php'\" type='button'","btn btn-primary");
?>
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
				$_goods = $db->fetch_all_data("goods",[],"user_id='".$__user_id."'","id");
				if(count($_goods) <= 0){
					?> <tr class="danger"><td colspan="9" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($_goods as $goods){
						$stock = 0;
						$categories = "";
						?>
						<tr style="cursor:pointer;">
							<td><?=$goods_photo;?></td>
							<td class="nowrap"><?=$goods["name"];?></td>
							<td class="nowrap"><?=$categories;?></td>
							<td class="nowrap"><?=$goods["description"];?></td>
							<td class="nowrap" align="right"><?=$goods["price"];?></td>
							<td class="nowrap"><?=($goods["is_new"] == 1)?v("new"):v("second_hand");?></td>
							<td class="nowrap" align="right"><?=$stock;?></td>
							<td class="nowrap" align="right"><?=$db->fetch_single_data("units","name_".$__locale,["id" => $goods["unit_id"]]);?></td>
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