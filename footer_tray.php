<?php if(isMobile()){ ?>
	<?php 
		$subcategory_ids = str_replace("||",",",sel_to_pipe($_GET["subcategory_ids"])); $subcategory_ids = str_replace("|","",$subcategory_ids);
	?>
	<script>
		$(document).ready( function() {
			window.addEventListener("scroll", function (event) {
				if(this.scrollY > 50 && this.oldScroll <= this.scrollY){
					$("#footer_tray").fadeOut( "fast", function() {});
				}
				if(this.oldScroll > this.scrollY){
					$("#footer_tray").fadeIn( "fast", function() {});
				}
				this.oldScroll = this.scrollY;
			});
			
			$('#subcategories').multiselect({
				checkboxName: function(option){ return 'subcategory_ids[]'; },
				nonSelectedText: '<?=v("choose_categories");?>'
			});
			$("#subcategories").val("<?=$subcategory_ids;?>".split(","));
			$("#subcategories").multiselect("refresh");
		});
		function tray_sort_click(){
			document.getElementById("tray_sort_body").style.width = "100%";
		}
		function tray_filter_click(){
			document.getElementById("tray_filter_body").style.width = "100%";
		}
		function closeBottomNav(){
			document.getElementById("tray_sort_body").style.width = "0";
			document.getElementById("tray_filter_body").style.width = "0";
		}
	</script>
	<div class="footer_tray" id="footer_tray">
		<div class="container">
			<div class="row">
				<table width="100%">
					<tr>
						<td width="50%" align="center" onclick="tray_sort_click();">
							<img src="assets/tray_sort.png" width="30"><br><b><?=v("sort");?></b>
						</td>
						<td align="center" onclick="tray_filter_click();">
							<img src="assets/tray_filter.png" width="30"><br><b><?=v("filter");?></b>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div id="tray_sort_body" class="navbar-default sidenav">
		<div class="menuTitle">
			<?=strtoupper(v("sort"));?>
			<div class="closebtn"><a href="javascript:void(0)" onclick="closeBottomNav()">&times;</a></div>
		</div>
		<div class="container" id="sidenavContent">
			<ul class="nav navbar-nav navbar-right">
				<li <?=($_GET["sort_id"] == "most_match" || !$_GET["sort_id"])?"class='active'":"";?>>	<a href="javascript:change_sort('most_match');"><?=v("most_match");?></a></li>
				<li <?=($_GET["sort_id"] == "newest")?"class='active'":"";?>>		<a href="javascript:change_sort('newest');"><?=v("newest");?></a></li>
				<li <?=($_GET["sort_id"] == "highest_price")?"class='active'":"";?>>	<a href="javascript:change_sort('highest_price');"><?=v("highest_price");?></a></li>
				<li <?=($_GET["sort_id"] == "lowest_price")?"class='active'":"";?>>	<a href="javascript:change_sort('lowest_price');"><?=v("lowest_price");?></a></li>
			</ul>
		</div>
	</div>
	<div id="tray_filter_body" class="navbar-default sidenav">
		<div class="menuTitle">
			<?=strtoupper(v("filter"));?>
			<div class="closebtn"><a href="javascript:void(0)" onclick="closeBottomNav()">&times;</a></div>
		</div>
		<div class="container" id="sidenavContent">
			<form method="GET" id="narrow_result_form">
				<?=$f->input("category_id",$_GET["category_id"],"type='hidden'");?>
				<?=$f->input("s",$_GET["s"],"type='hidden'");?>
				<?=$f->input("c",$_GET["c"],"type='hidden'");?>
				<?=$f->input("sort_id",$_GET["sort_id"],"type='hidden'");?>
				<div class="frame_body">				
					<div class="frame_subtitle"><?=v("keyword");?></div>
					<?=$f->input("keyword",$_GET["keyword"],"placeholder='".v("keyword")."...'","form-control");?>
					<br>
					<?php
						if(!$no_categories_filter){
							$subcategories = $db->fetch_select_data("categories","id","name_".$__locale,["parent_id"=>$_GET["category_id"]],["id"]);
							if(count($subcategories) > 0){
								?> <div class="frame_subtitle"><?=v("categories");?></div> <?=$f->select("subcategories",$subcategories,"","multiple=\"multiple\"","form-control");?> <br> <?php 
							}
						} 
					?>
					
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
	</div>	
<?php } ?>