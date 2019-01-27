<script>
	function change_category(category_id){
		document.getElementById("category_id").value = category_id;
		document.getElementById("c").value = category_id;
		document.getElementById("narrow_result_form").submit();
	}
</script>
<div class="frame_common">
	<div class="frame_title"><?=v("narrow_the_results");?></div>
	<form method="GET" id="narrow_result_form">
		<?=$f->input("category_id",$_GET["category_id"],"type='hidden'");?>
		<?=$f->input("s",$_GET["s"],"type='hidden'");?>
		<?=$f->input("c",$_GET["c"],"type='hidden'");?>
		<?=$f->input("sort_id",$_GET["sort_id"],"type='hidden'");?>
		<div class="frame_body">
			<div class="frame_subtitle"><?=v("keyword");?></div>
			<?=$f->input("keyword",$_GET["keyword"],"placeholder='".v("keyword")."...'","form-control");?>
			<br>
			<?php if(!$no_categories_filter){ ?>
				<div class="frame_subtitle"><?=v("categories");?></div>
				<?php
					$categories = $db->fetch_all_data("categories",[],"id IN (1,3,4,5,6,8,9,49)","id");
					foreach($categories as $key => $category){
						$img = "category_".$category["id"].".png";
						$isactive = ($category["id"] == $_GET["category_id"])?"style=\"color:#800000\"":"";
						?> <div><img src="assets/<?=$img;?>"><a <?=$isactive;?> href="javascript:change_category('<?=$category["id"];?>');"><?=$category["name_".$__locale];?></a></div> <?php
					}
				?>
			<?php } ?>
			
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
			<br>
			<div class="frame_subtitle"><?=v("sort");?></div>
			<div class="form-group">
				<?php 
					$sorts["most_match"] = v("most_match");
					$sorts["newest"] = v("newest");
					$sorts["highest_price"] = v("highest_price");
					$sorts["lowest_price"] = v("lowest_price");
				?>
				<?=$f->select("sort_id",$sorts,$_GET["sort_id"],"onchange=\"change_sort(this.value);\"","form-control");?>
			</div>
			<div class="form-group">
				<?=$f->input("search",strtoupper(v("search")),"type='submit' style='width:100%;'","btn btn-info");?>
			</div>
			
		</div>
	</form>
	<div class="frame_body">
		<div class="form-group">
			<button onclick="show_shopping_calculator();" class="btn btn-info" style="width:100%;"><img src="assets/tray_calc.png" width="30"><b><?=v("shopping_calculator");?></b></button>
		</div>
	</div>
</div>