<?php 
	$_exportname = "Goods.xls";
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=".$_exportname);
	header("Pragma: no-cache");
	header("Expires: 0");
	include_once "common.php";
?>
<h4><b>PRODUK</b></h4>
<?php
	$whereclause = "";
	if(@$_GET["category_id"]!="") $whereclause .= "category_ids LIKE '%|".$_GET["category_id"]."|%' AND ";
	if(@$_GET["seller_id"]!="") $whereclause .= "seller_id = '".$_GET["seller_id"]."' AND ";
	if(@$_GET["name"]!="") $whereclause .= "(name LIKE '%".str_replace(" ","%",$_GET["name"])."%' OR description LIKE '%".str_replace(" ","%",$_GET["name"])."%') AND ";
	
	$db->addtable("goods");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));
	if($_GET["sort"] == "") $_GET["sort"] = "seller_id";
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$goods = $db->fetch_data(true);
	
	echo $t->start("border='1'","data_content");
	echo $t->header(["No","Nama Toko","Produk","Merk","Kategori","Area","Alamat","Pemilik","PIC Markopelago"]);
	foreach($goods as $no => $good){
		$category_ids = explode('|', $good["category_ids"]);
		$categories ="";
		foreach($category_ids as $num => $category_id){
			$category = $db->fetch_single_data("categories","name_id",array("id"=>$category_id));
			if ($category!=null) $categories.=$category. ", ";
		}
		$seller = $db->fetch_all_data("sellers",[],"id='".$good["seller_id"]."'")[0];
		$location_id = $db->fetch_single_data("user_addresses","location_id",["user_id" => $seller["user_id"],"default_seller" => "1"]);
		$address = $db->fetch_single_data("user_addresses","address",["user_id" => $seller["user_id"],"default_seller" => "1"]);
		
		echo $t->row([$no+1,
					$seller["name"],
					$good["name"],
					"",
					$categories,
					get_location($location_id)["caption"],
					$address,
					$seller["pic"],
					""
					],
					["align='right' valign='top'",""]
				);
	}
	echo $t->end();
?>