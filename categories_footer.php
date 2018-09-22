<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("allcategories");?></div>
	</div>
	<div class="row">
		<table class="table-categories all-categories">
			<tr>
			<?php 
				unset($categories);
				$categories = $db->fetch_all_data("categories",[],"parent_id = 0","id");
				foreach($categories as $key => $category){
					if(($key)%4 == 0) echo "</tr><tr>";
			?>
				<td width="25%">
					<a href="category_detail.php?id=<?=$category["id"];?>" style="color:grey;">
						<div class="caption"><p><?=$category["name_".$__locale];?></p></div>
					</a>
				</td>
			<?php
				}
			?>
			<?php
				$key++;
				while(($key)%4 != 0){
					$key++;
					echo "<td></td>";
				}
			?>
			</tr>
		</table>
	</div>
</div>
<div style="height:40px;"></div>