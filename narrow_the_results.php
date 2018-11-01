<div class="frame_common">
	<div class="frame_title"><?=v("narrow_the_results");?></div>
	<form method="GET">
		<?=$f->input("id",$_GET["id"],"type='hidden'");?>
		<div class="frame_body">
			<div class="frame_subtitle"><?=v("categories");?></div>
			<?php
				$categories = $db->fetch_all_data("categories",[],"id IN (1,2,3,4,5,6,8,9)","id");
				foreach($categories as $key => $category){
					$img = "category_".$category["id"].".png";
					$isactive = ($category["id"] == $_GET["id"])?"style=\"color:#800000\"":"";
					?> <div><img src="assets/<?=$img;?>"><a <?=$isactive;?> href="?id=<?=$category["id"];?>"><?=$category["name_".$__locale];?></a></div> <?php
				}
			?>
			
			<br>
			<div class="frame_subtitle"><?=v("seller_location");?></div>
			<?php $provinces = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => 0],["name_".$__locale],"",true); ?>
			<?=$f->select("province_id",$provinces,$_GET["province_id"],"","form-control");?>
			<div class="form-group" id="div_select_cities" style="display:<?=($_GET["province_id"] > 0) ? "block":"none";?>;">
				<?php $cities = $db->fetch_select_data("locations","id","name_".$__locale,["parent_id" => $_GET["province_id"]],["name_".$__locale],"",true); ?>
				<label><?=v("city");?></label><div id="div_cities"><?=$f->select("city_id",$cities,$_GET["city_id"]," onchange=\"loadDistricts(this.value);\"","form-control");?></div>
			</div>
			
			<br>
			<div class="frame_subtitle"><?=v("price");?></div>
			<div class="form-group">
				<?=$f->input("price_min",$_GET["price_min"],"type='number' min='0' placeholder='".v("price_min")."...'","form-control");?>
			</div>
			<div class="form-group">
				<?=$f->input("price_max",$_GET["price_max"],"type='number' min='0' placeholder='".v("price_max")."...'","form-control");?>
			</div>
			<div class="form-group">
				<?=$f->input("search",strtoupper(v("search")),"type='submit' style='width:100%;'","btn btn-info");?>
			</div>
			
		</div>
	</form>
</div>