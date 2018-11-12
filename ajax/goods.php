<?php 
	include_once "../common.php";
	$mode = $_GET["mode"];
	if($mode == "change_is_displayed"){
		$goods_id = $_GET["goods_id"];
		$value = $_GET["value"];
		if($value == "true"){
			$db->addtable("goods");
			$db->where("id",$goods_id);
			$db->addfield("is_displayed");	$db->addvalue(1);
			if($db->update()["affected_rows"] > 0) echo "<font color='#2196F3'>".v("displayed")."</font>";
		}
		if($value == "false"){
			$db->addtable("goods");
			$db->where("id",$goods_id);
			$db->addfield("is_displayed");	$db->addvalue(0);
			if($db->update()["affected_rows"] > 0) echo "<font color='red'>".v("not_displayed")."</font>";
		}
	}
	
	if($mode == "goods_like"){
		$goods_id = $_GET["goods_id"];
		$isliked = $db->fetch_single_data("goods_liked","id",["goods_id" => $goods_id,"user_id" => $__user_id]);
		if($isliked > 0){
			$db->addtable("goods_liked");
			$db->where("goods_id",$goods_id);
			$db->where("user_id",$__user_id);
			$db->delete_();
		} else {
			$db->addtable("goods_liked");
			$db->addfield("goods_id");	$db->addvalue($goods_id);
			$db->addfield("user_id");	$db->addvalue($__user_id);
			$db->insert();
		}
		echo $db->fetch_single_data("goods_liked","concat(count(*))",["goods_id" => $goods_id]);
	}
	if($mode == "goods_isliked"){
		$goods_id = $_GET["goods_id"];
		echo $db->fetch_single_data("goods_liked","id",["goods_id" => $goods_id,"user_id" => $__user_id]) * 1;
	}
?>