<?php include_once "homepage_header.php"; ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active">
			<img src="images/main1.jpg">
			<div class="carousel-overlay"></div>
		</div>
		<div class="item">
			<img src="images/main2.jpg">
			<div class="carousel-overlay"></div>
		</div>
		<div class="item">
			<img src="images/main3.jpg">
			<div class="carousel-overlay"></div>
		</div>
		<div class="item">
			<img src="images/main4.jpg">
			<div class="carousel-overlay"></div>
		</div>
	</div>
	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
		<span class="sr-only">Next</span>
	</a>
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
		<li data-target="#myCarousel" data-slide-to="3"></li>
	</ol>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-6" style="position:absolute;top:0px;">
				<div class="r-form-1-top"> 
					<img src="images/logo.png"> adalah Indonesia
				</div>
				<div class="r-form-1-bottom">
					<p class="subtitle">Berdaya di negeri sendiri</p>
					<p class="description">Human-Based Marketplace platform to boost up your busines</p>
				<?php if(!$__isloggedin){ ?>
					<div class="top-buttons">
						<a class="btn btn-link-2 scroll-link" href="register.php"><?=v("register");?></a>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("categories");?></div>
		<div class="view-all-text"><a href="#"><?=v("view_all");?></a></div>
	</div>
	<div class="scrolling-wrapper categories">
		<?php 
			unset($categories);
			$categories = $db->fetch_all_data("categories",[],"parent_id > 0","id");
			foreach($categories as $key => $category){
		?>
			<div class="img-thumbnail">
				<a href="category_detail.php?id=<?=$category["id"];?>">
					<img src="icons/categories/<?=$category["id"].".png";?>" alt="#">
					<div class="caption"><p><?=$category["name_".$__locale];?></p></div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("hot_products");?></div>
		<div class="view-all-text"><a href="#"><?=v("view_all");?></a></div>
	</div>
	<div class="scrolling-wrapper">
		<?php 
			$products = $db->fetch_all_data("goods",[],"1=1 ORDER BY RAND() LIMIT 10");
			foreach($products as $product){
				$img = $db->fetch_single_data("goods_photos","filename",["goods_id"=>$product["id"]],["seqno"]);
		?>
			<div class="img-thumbnail">
				<a href="product_detail.php?id=<?=$product["id"];?>">
					<img src="goods/<?=$img;?>" alt="#">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price"><p>Rp. <?=format_amount($product["price"]);?> / <?=$db->fetch_single_data("units","name_".$__locale,["id" => $product["unit_id"]]);?></p></div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area">
		<div class="sub-title-text"><?=v("recommended_sellers");?></div>
		<div class="view-all-text"><a href="#"><?=v("view_all");?></a></div>
	</div>
	<div class="scrolling-wrapper">
		<?php 
			$sellers[0] = ["id"=>"001","img"=>"Sutrisno.jpg","name"=>"Sutrisno","city"=>"Semarang"];
			$sellers[1] = ["id"=>"002","img"=>"Bambang.jpg","name"=>"Bambang","city"=>"Surabaya"];
			$sellers[2] = ["id"=>"003","img"=>"Frank.jpg","name"=>"Frank","city"=>"Palembang"];
			$sellers[3] = ["id"=>"004","img"=>"Jamilah.jpg","name"=>"Jamilah","city"=>"Jakarta"];
			$sellers[4] = ["id"=>"005","img"=>"Nurrochman.jpg","name"=>"Nurrochman","city"=>"Pontianak"];
			foreach($sellers as $seller){
		?>
			<div class="img-thumbnail">
				<a href="seller_detail.php?id=<?=$seller["id"];?>">
					<img src="sellers/<?=$seller["img"];?>" alt="#">
					<div class="caption"><p><?=$seller["name"];?></p></div>
					<div class="price"><p><?=$seller["city"];?></p></div>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>