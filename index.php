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
					<div class="top-buttons">
						<a class="btn btn-link-2 scroll-link" href="register.php?investor=1"><?=v("register_as_seller");?></a>
						<a class="btn btn-link-2 scroll-link" href="register.php?investor=1"><?=v("register_as_buyer");?></a>
					</div>
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
			$categories[0] = ["id"=>"001","img"=>"agr.png","name"=>"Agriculture"];
			$categories[1] = ["id"=>"002","img"=>"alb.png","name"=>"Alat Berat"];
			$categories[2] = ["id"=>"003","img"=>"antique.png","name"=>"Antique"];
			$categories[3] = ["id"=>"004","img"=>"bdy.png","name"=>"Budaya"];
			$categories[4] = ["id"=>"005","img"=>"bhb.png","name"=>"Bahan Bangunan"];
			$categories[5] = ["id"=>"006","img"=>"bkl.png","name"=>"Bengkel"];
			$categories[6] = ["id"=>"007","img"=>"brg.png","name"=>"Burung"];
			$categories[7] = ["id"=>"008","img"=>"btk.png","name"=>"Batik"];
			$categories[8] = ["id"=>"009","img"=>"cmcl.png","name"=>"Chemical"];
			$categories[9] = ["id"=>"010","img"=>"elct.png","name"=>"Electronic"];
			$categories[10] = ["id"=>"011","img"=>"elct2.png","name"=>"Electrical"];
			$categories[11] = ["id"=>"012","img"=>"fashion.png","name"=>"Fashion & Kecantikan"];
			$categories[12] = ["id"=>"013","img"=>"h&m.png","name"=>"Herbs & Medicine"];
			$categories[13] = ["id"=>"014","img"=>"hoby.png","name"=>"Hobi"];
			$categories[14] = ["id"=>"015","img"=>"it.png","name"=>"IT"];
			$categories[15] = ["id"=>"016","img"=>"kopi.png","name"=>"Kopi"];
			$categories[16] = ["id"=>"017","img"=>"lab.png","name"=>"Laboratory & Equipment"];
			$categories[17] = ["id"=>"018","img"=>"makan.png","name"=>"Makanan & Minuman"];
			$categories[18] = ["id"=>"019","img"=>"oleh.png","name"=>"Oleh Oleh"];
			$categories[19] = ["id"=>"020","img"=>"otomotif.png","name"=>"Otomotif"];
			$categories[20] = ["id"=>"021","img"=>"packaging.png","name"=>"Packaging"];
			$categories[21] = ["id"=>"022","img"=>"tools.png","name"=>"Tools"];
			foreach($categories as $key => $category){
		?>
			<div class="img-thumbnail">
				<a href="category_detail.php?id=<?=$category["id"];?>">
					<img src="icons/categories/<?=$category["img"];?>" alt="#">
					<div class="caption"><p><?=$category["name"];?></p></div>
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
			$products[0] = ["id"=>"001","img"=>"001.jpg","name"=>"Gula Aren","price"=>"50000","perunit"=>"Kg"];
			$products[1] = ["id"=>"002","img"=>"002.jpg","name"=>"Kopi Khas Madura Cap Pusaka","price"=>"100000","perunit"=>"Bungkus"];
			$products[2] = ["id"=>"003","img"=>"003.jpg","name"=>"Pastel Asap Oleh-oleh Khas Jepara","price"=>"55000","perunit"=>"Bungkus"];
			$products[3] = ["id"=>"004","img"=>"004.jpg","name"=>"Telor Asin","price"=>"50000","perunit"=>"Kg"];
			$products[4] = ["id"=>"005","img"=>"005.jpg","name"=>"Rengginag Teri Gangsar Jaya","price"=>"50000","perunit"=>"Bungkus"];
			$products[5] = ["id"=>"006","img"=>"006.jpg","name"=>"Bawang Goreng Itikurih","price"=>"90000","perunit"=>"Toples"];
			$products[6] = ["id"=>"007","img"=>"007.jpg","name"=>"Pisang Nugget Swedeppp PINUS","price"=>"80000","perunit"=>"Bungkus"];
			$products[7] = ["id"=>"008","img"=>"008.jpg","name"=>"DR. FARIS Indonesian Footwear","price"=>"350000","perunit"=>"Pasang"];
			$products[8] = ["id"=>"009","img"=>"009.jpg","name"=>"Jakarte Punye Gaye T-Shirt","price"=>"150000","perunit"=>"Pcs"];
			$products[9] = ["id"=>"010","img"=>"010.jpg","name"=>"Topi Batik","price"=>"70000","perunit"=>"Pcs"];
			foreach($products as $product){
		?>
			<div class="img-thumbnail">
				<a href="product_detail.php?id=<?=$product["id"];?>">
					<img src="products/<?=$product["img"];?>" alt="#">
					<div class="caption"><p><?=$product["name"];?></p></div>
					<div class="price"><p>Rp. <?=format_amount($product["price"]);?> / <?=$product["perunit"];?></p></div>
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