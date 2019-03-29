<?php
	include_once "document_root_path.php";
	include_once "common.php";
	$_SESSION["username"] = "";
	$goods_ids = "156,157,158,159,160,161,162,163,164,165,188,197,205,213,221";
	$user_id_old = 36;
	$seller_id_old = 26;
	$user_id_new = 377;
	$seller_id_new = 103;

	$num_goods_deleted = 0;
	$num_goods = 0;
	$num_goods_prices = 0;
	$num_goods_photos = 0;

	$_goods = $db->fetch_all_data("goods",[],"seller_id = '".$seller_id_old."' AND id IN (".$goods_ids.")");
	foreach($_goods as $key => $goods){
		$goods_id_new = $db->fetch_single_data("goods","id",["seller_id" => $seller_id_new,"name" => $goods["name"].":LIKE","weight" => $goods["weight"]]);
		if($goods_id_new > 0){
			echo $goods["id"].$__enter;
			$num_goods_deleted++;
			$db->addtable("goods"); $db->where("id",$goods_id_new); $db->delete_();
			$db->addtable("goods_prices"); $db->where("goods_id",$goods_id_new); $db->delete_();
			$filename = $db->fetch_single_data("goods_photos","filename",["goods_id"=> $goods_id_new]);
			unlink("goods/".$filename);
			$db->addtable("goods_photos"); $db->where("goods_id",$goods_id_new); $db->delete_();
		}

		$db->addtable("goods");
		$db->addfield("barcode");			$db->addvalue($goods["barcode"]);
		$db->addfield("seller_id");			$db->addvalue($seller_id_new);
		$db->addfield("category_ids");		$db->addvalue($goods["category_ids"]);
		$db->addfield("color_ids");			$db->addvalue($goods["color_ids"]);
		$db->addfield("unit_id");			$db->addvalue($goods["unit_id"]);
		$db->addfield("promo_id");			$db->addvalue($goods["promo_id"]);
		$db->addfield("name");				$db->addvalue($goods["name"]);
		$db->addfield("description");		$db->addvalue($goods["description"]);
		$db->addfield("weight");			$db->addvalue($goods["weight"]);
		$db->addfield("dimension");			$db->addvalue($goods["dimension"]);
		$db->addfield("is_new");			$db->addvalue($goods["is_new"]);
		$db->addfield("price");				$db->addvalue($goods["price"]);
		$db->addfield("disc");				$db->addvalue($goods["disc"]);
		$db->addfield("availability_days");	$db->addvalue($goods["availability_days"]);
		$db->addfield("forwarder_ids");		$db->addvalue($goods["forwarder_ids"]);
		$db->addfield("self_pickup");		$db->addvalue($goods["self_pickup"]);
		$db->addfield("pickup_location_id");$db->addvalue($goods["pickup_location_id"]);
		$db->addfield("is_displayed");		$db->addvalue($goods["is_displayed"]);
		$inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$num_goods++;
			$goods_id_new = $inserting["insert_id"];

			$goods_prices = $db->fetch_all_data("goods_prices",[],"goods_id = '".$goods["id"]."'");
			foreach($goods_prices as $goods_price){
				$db->addtable("goods_prices");
				$db->addfield("goods_id");		$db->addvalue($goods_id_new);
				$db->addfield("qty");			$db->addvalue($goods_price["qty"]);
				$db->addfield("price");			$db->addvalue($goods_price["price"]);
				$db->addfield("commission");	$db->addvalue($goods_price["commission"]);
				$inserting = $db->insert();
				if($inserting["affected_rows"] > 0) $num_goods_prices++;
			}

			$goods_photos = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'");
			foreach($goods_photos as $goods_photo){
				$photo_old = $goods_photo["filename"];
				$ext = pathinfo($photo_old, PATHINFO_EXTENSION);
				$photo_new = substr("0000000",0,7-strlen($goods_photo["id"])).$goods_photo["id"].date("Ymdhis").$user_id_new.".".$ext;
				if (copy("goods/".$photo_old, "goods/".$photo_new)) {
					$db->addtable("goods_photos");
					$db->addfield("goods_id");		$db->addvalue($goods_id_new);
					$db->addfield("seqno");			$db->addvalue($goods_photo["seqno"]);
					$db->addfield("filename");		$db->addvalue($photo_new);
					$db->addfield("caption");		$db->addvalue($goods_photo["caption"]);
					$inserting = $db->insert();
					if($inserting["affected_rows"] > 0) $num_goods_photos++;
				}
			}
		}
	}
	echo "Deleted : ".$num_goods_deleted.$__enter;
	echo "Goods : ".$num_goods.$__enter;
	echo "Goods Prices : ".$num_goods_prices.$__enter;
	echo "Goods Photos : ".$num_goods_photos.$__enter;
?>