<?php
	include_once "document_root_path.php";
	include_once "common.php";
	$_SESSION["username"] = "";
	$goods_ids = "157,159,162,164,166,168,253,300,303,304,305,306,309,311,312,313,314,315,319,322,323,339,340,345,346,348,349,352,353,354,362,364,365,366,368,372,443,444,445,457,459,460,461,462,469,470,471,543,549,554,558,563,567,568,569,596,603,637,641,642,643,646,653,654,659,680,682,685,686,687,692,693,694,695,696,697,701,707,729,788,789,790,849,854,919,925,940,942,943,1044,1111,1113,1143,1170,1171,1172,1173,1175,1176,1179,1188,1189,1190,1204,1205,1206,170,171,177,216,257,267,268,269,271,291,292,296,435,475,480,481,482,503,575,577,578,580,689,716,717,719,764,772,773,774,777,778,779,843,847,1078,1091,1094,1097,1098,1101,1139,1140,1154,1191,1212,1213,181,183,185,186,187,190,195,196,206,214,237,239,242,246,250,251,254,255,258,262,272,336,358,360,361,370,371,373,374,377,378,379,382,383,385,386,387,392,397,419,420,421,422,423,424,425,431,432,464,465,468,516,525,639,644,645,649,661,662,663,669,678,679,681,683,684,688,709,713,714,727,733,734,735,736,738,739,742,744,745,746,747,752,754,756,757,759,760,761,762,766,767,768,769,780,781,782,784,927,930,950,952,954,960,1048,1049,1051,1053,1054,1055,1059,1060,1066,1073,1081,1082,1108,1109,1116,1117,1118,1119,1120,1121,1122,1123,1124,1125,1126,1127,1128,1129,1130,1131,1132,1134,1135,1136,1138,1141,1142,1145,1146,1207,1208,1209,184,221,222,223,224,225,226,283,302,308,363,367,369,455,507,508,509,664,665,690,1083,1084,227,228,229,230,231,243,505,506,526,527,581,388,390,393,398,399,400,401,404,408,409,436,437,668,670,671,673,677,724,203,235,259,263,264,279,280,281,285,582,647,887,916,1069,1071,1080,1089,1102,1103,1104,1133,1137,1174,1193,1194,156,158,160,161,163,165,167,169,172,173,174,175,176,178,179,180,182,188,189,191,192,193,194,197,198,201,202,204,205,207,208,209,210,211,212,215,217,238,245,249,252,260,265,290,298,301,320,321,441,452,456,476,479,538,723,748,765,842,969,1045,1046,1047,1050,1052,1056,1057,1058,1062,1063,1064,1067,1068,1070,1072,1074,1079,1086,1095,1144,1147,1182,1192,1210,1211,232,233,234,236,244,297,299,375,376,483,485,486,487,514,515,517,518,519,520,521,522,523,524,533,614,617,626,627,628,629,630,631,632,633,634,635,691,771,785,985,996,1021,1031,1085,1181,350,351,355,356,357,359,496,497,498,499,500,501,636,638,640,955,956,959,968,1167,1168,1169,199,200,213,240,241,248,256,261,266,310,316,324,327,328,329,330,337,338,341,347,380,381,384,405,407,412,413,414,415,416,417,426,440,448,449,450,451,453,454,467,477,478,484,494,502,539,541,542,544,545,546,547,548,550,551,552,553,557,561,562,564,565,566,570,571,572,574,576,583,584,585,586,587,588,589,590,591,592,593,594,595,597,600,601,602,604,605,606,607,608,609,610,611,612,613,615,616,618,619,620,621,622,623,624,625,648,650,651,652,655,656,657,658,660,666,667,675,698,699,700,702,703,704,705,706,708,710,711,712,715,718,720,721,726,730,776,783,786,792,793,794,795,796,797,798,799,800,801,802,803,804,805,806,819,820,834,850,851,852,853,855,862,863,864,865,866,867,868,869,870,871,872,873,874,875,876,877,878,879,880,881,882,896,900,901,903,904,906,907,908,909,910,913,914,918,931,932,933,944,949,951,953,957,958,961,963,964,966,967,970,973,975,977,980,981,982,986,987,988,990,992,993,994,995,998,999,1000,1001,1002,1003,1004,1005,1006,1007,1008,1012,1017,1042,1061,1065,1090,1092,1093,1099,1100,1105,1106,1148,1149,1150,1151,1152,1153,1155,1156,1157,1158,1159,1160,1161,1162,1163,1164,1165,1166,1177,1178";

	$user_id_old = 36;
	$seller_id_old = 26;
	$user_id_new = 377;
	$seller_id_new = 103;

	$num_goods_deleted = 0;
	$num_goods = 0;
	$num_goods_prices = 0;
	$num_goods_photos = 0;
	$num_goods_histories = 0;

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
			$db->addtable("goods_histories"); $db->where("goods_id",$goods_id_new); $db->delete_();
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

			$db->addtable("goods_histories");
			$db->addfield("seller_user_id");$db->addvalue($user_id_new);
			$db->addfield("transaction_id");$db->addvalue(0);
			$db->addfield("goods_id");		$db->addvalue($goods_id_new);
			$db->addfield("in_out");		$db->addvalue("in");
			$db->addfield("qty");			$db->addvalue(1000);
			$db->addfield("notes");			$db->addvalue("Stok Awal");
			$db->addfield("history_at");	$db->addvalue(date("Y-m-d H:i:s"));
			$inserting = $db->insert();
			if($inserting["affected_rows"] > 0) $num_goods_histories++;
		}
	}
	echo "Deleted : ".$num_goods_deleted.$__enter;
	echo "Goods : ".$num_goods.$__enter;
	echo "Goods Prices : ".$num_goods_prices.$__enter;
	echo "Goods Photos : ".$num_goods_photos.$__enter;
	echo "Goods Histories : ".$num_goods_histories.$__enter;
?>