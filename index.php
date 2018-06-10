<?php include_once "homepage_header.php"; ?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		<li data-target="#myCarousel" data-slide-to="1"></li>
		<li data-target="#myCarousel" data-slide-to="2"></li>
	</ol>
	<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<div class="item active"><img src="images/main1.jpg"></div>
		<div class="item"><img src="images/main2.jpg"></div>
		<div class="item"><img src="images/main3.jpg"></div>
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
</div>
<?php include_once "footer.php"; ?>