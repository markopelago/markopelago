<?php if(!isMobile()){ ?>
	<div class="container">
		<div class="row sub-title-area">
			<div class="sub-title-text"><?=v("allcategories");?></div>
		</div>
	</div>
	<table class="table_footer_categories_area">
		<tr>
			<td align="center">
				<div class="container">
					<table class="table-categories all-categories">
						<tr>
						<?php 
							unset($categories);
							$categories = $db->fetch_all_data("categories",[],"parent_id = 0","id");
							foreach($categories as $key => $category){
								if(($key)%4 == 0) echo "</tr><tr>";
								$img = "category_".$category["id"].".png";
						?>
							<td width="25%">
								<a href="category_detail.php?category_id=<?=$category["id"];?>" style="color:grey;">
									<div class="caption"><p><img src="assets/<?=$img;?>"><?=$category["name_".$__locale];?></p></div>
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
			</td>
		</tr>
	</table>
<?php } ?>