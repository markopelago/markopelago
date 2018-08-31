<?php
	include_once "common.php";
	$_goods = $db->fetch_all_data("goods");
	foreach($_goods as $goods){
		if($db->fetch_single_data("goods_prices","id",["goods_id" => $goods["id"]]) <= 0){
			$price = $goods["price"] - ($goods["price"] * 5/105);
			$db->addtable("goods_prices");
			$db->addfield("goods_id");	$db->addvalue($goods["id"]);
			$db->addfield("qty");		$db->addvalue("1");
			$db->addfield("price");		$db->addvalue($price);
			$db->addfield("commission");$db->addvalue(5);
			$inserting = $db->insert();
			echo "<br>".$inserting["sql"];
			
		}
	}
?>