<?php 
	include_once "../common.php";
	$agency_user_id = $_GET["agency_user_id"];
	$model_user_id = $_GET["model_user_id"];
	$mode = $_GET["mode"];
	$isRejected = "";
	
	$agency_model_id = $db->fetch_single_data("agency_models","id",["agency_user_id" => $agency_user_id,"model_user_id"=>$model_user_id]);
	$wherearray = ["agency_user_id" => $agency_user_id,"model_user_id" => $model_user_id];
	if($mode == "already_member"){
		$wherearray["join_status"] = "2";
		$whereNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2", "id"=>$agency_model_id.":>"];
		$wherePrev = ["agency_user_id" => $agency_user_id, "join_status"=>"2", "id"=>$agency_model_id.":<"];
		$wherePrevNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2"];
	}
	if($mode == "join_requests"){
		$wherearray["mode"] = "1";
		$wherearray["join_status"] = "2:<>";
		$whereNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "1", "id"=>$agency_model_id.":>"];
		$wherePrev = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "1", "id"=>$agency_model_id.":<"];
		$wherePrevNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "1"];
	}
	if($mode == "join_offers"){
		$wherearray["mode"] = "2";
		$wherearray["join_status"] = "2:<>";
		$whereNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "2", "id"=>$agency_model_id.":>"];
		$wherePrev = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "2", "id"=>$agency_model_id.":<"];
		$wherePrevNext = ["agency_user_id" => $agency_user_id, "join_status"=>"2:<>", "mode" => "2"];
	}
	if($mode == "join_requests" || $mode == "join_offers"){
		$joinStatus = $db->fetch_single_data("agency_models","join_status",["id"=>$agency_model_id]);
		if($joinStatus == "0"){
			$db->addtable("agency_models");	$db->where("id",$agency_model_id);
			$db->addfield("join_status");	$db->addvalue("1");
			$db->update();
		}
		if($joinStatus == "3") $isRejected = "<span class='reject-icon2'>".v("rejected")."</span>";
	}
	
	if($db->fetch_single_data("agency_models","id",$wherearray) <= 0){
		?> <script> $( document ).ready(function() { $('#myModal').modal('hide'); }); </script> <?php
		exit();
	}
	$fullname = $db->fetch_single_data("model_profiles","concat(first_name,' ',middle_name,' ',last_name)",["user_id" => $model_user_id]);
	$photo = $db->fetch_single_data("model_profiles","photo",["user_id" => $model_user_id]);
	
	$next_id = $db->fetch_single_data("agency_models","model_user_id",$whereNext,["id"]);
	$prev_id = $db->fetch_single_data("agency_models","model_user_id",$wherePrev,["id DESC"]);
	if(!$next_id) $next_id = $db->fetch_single_data("agency_models","model_user_id",$wherePrevNext,["id"]);
	if(!$prev_id) $prev_id = $db->fetch_single_data("agency_models","model_user_id",$wherePrevNext,["id DESC"]);
	
	$model_profile = $db->fetch_all_data("model_profiles",[],"user_id='".$model_user_id."'")[0];
?>
<h3><b><?=$fullname;?></b></h3>
<?php if($mode == "join_requests" && $joinStatus < 2){ ?>
<input onclick="joinRequestUpdate('<?=$agency_model_id;?>','2');" type="button" class="btn btn-success" value="<?=v("accept");?>">
<input onclick="joinRequestUpdate('<?=$agency_model_id;?>','3');" type="button" class="btn btn-warning" value="<?=v("reject");?>">
<?php } ?>
|||
<div class="row">
	<div class="col-sm-6 features wow fadeInRight animated">
		<img class="img-responsive" src="user_images/<?=$photo;?>" style="width:100%">
		<?=$isRejected;?>
		<br>
		<div style="width:100%;border-top:1px solid #888;"></div>
			<table class="tbl_detail">
				<tr>
					<td>Hair</td><td>Eyes</td><td>Height</td>
					<?php if($model_profile["model_category_ids"] != 1) { ?>
					<td>Bust</td>
					<?php } ?>
				</tr>
				<tr><td style="height:6px;"></td></tr>
				<tr style="font-weight:bolder;">
					<td nowrap><?=$db->fetch_single_data("hair_colors","name",["id" => $model_profile["hair_color_id"]]);?></td>
					<td nowrap><?=$db->fetch_single_data("eye_colors","name",["id" => $model_profile["eye_colors_id"]]);?></td>
					<td nowrap><?=$model_profile["height"]*1;?> cm</td>
					<?php if($model_profile["model_category_ids"] != 1) { ?>
					<td nowrap><?=$model_profile["bust"];?></td>
					<?php } ?>
				</tr>
			</table>
		<div style="width:100%;border-top:1px solid #888;"></div>
		<div style="width:100%;border-top:1px solid #888;margin-top:10px;"></div>
			<table class="tbl_detail">
				<tr>
					<td>chest</td><td>Waist</td><td>Hips</td><td>Shoe</td>
				</tr>
				<tr><td style="height:6px;"></td></tr>
				<tr style="font-weight:bolder;">
					<td nowrap><?=$model_profile["chest"]*1;?> cm</td>
					<td nowrap><?=$model_profile["waist"]*1;?> cm</td>
					<td nowrap><?=$model_profile["hips"]*1;?> cm</td>
					<td nowrap><?=$model_profile["shoe"]*1;?></td>
				</tr>
			</table>
		<div style="width:100%;border-top:1px solid #888;"></div>
	</div>
	<div class="col-sm-6 features wow fadeInRight animated">
		<?=v("nationality");?> : 
		<div class="container" style="width:100%"><?=$db->fetch_single_data("nationalities","name",["id" => $model_profile["nationality_id"]]);?></div>
		<div style="width:100%;border-top:1px solid #888;"></div>
		
		<?=v("gender");?> :
		<div class="container" style="width:100%"> <?=$db->fetch_single_data("genders","name",["id" =>$model_profile["gender_id"]]);?> </div>
		<div style="width:100%;border-top:1px solid #888;"></div>

		<?=v("birth_at");?> :
		<div class="container" style="width:100%"> <?=format_tanggal($model_profile["birth_at"],"d F Y");?> </div>
		<div style="width:100%;border-top:1px solid #888;"></div>
		
		<?=v("model_category");?> : 
		<div class="container" style="width:100%"><?=$db->fetch_single_data("model_categories","name_".$__locale,["id" => $model_profile["model_category_ids"]]);?></div>
		<div style="width:100%;border-top:1px solid #888;"></div>

		<?=v("address");?> :
		<div class="container" style="width:100%">
			<?=str_replace([chr(10),chr(13)],["<br>",""],$model_profile["address"]);?><br>
			<?=$db->fetch_single_data("locations","name_".$__locale,["id" =>$model_profile["location_id"]]);?>
		</div>
		<div style="width:100%;border-top:1px solid #888;"></div>

		<?php if($model_profile["ig"]!=""){ ?> Instagram :<div class="container" style="width:100%"><?=$model_profile["ig"];?></div><?php } ?>
		<?php if($model_profile["fb"]!=""){ ?> Facebook:<div class="container" style="width:100%"><?=$model_profile["fb"];?></div><?php } ?>
		<?php if($model_profile["tw"]!=""){ ?> Twitter :<div class="container" style="width:100%"><?=$model_profile["tw"];?></div><?php } ?>
		<?php if($model_profile["ig"]!="" || $model_profile["fb"]!="" || $model_profile["tw"]!=""){ ?> <div style="width:100%;border-top:1px solid #888;"></div> <?php } ?>
		
	</div>
</div>
<table width="100%">
	<tr>
		<td nowrap>
			<i onclick="detailAgencyModel('<?=$agency_user_id;?>','<?=$prev_id;?>','<?=$mode;?>');" style="font-size:40px;" class="fa fa-arrow-left"></i>
		</td>
		<td align="right" nowrap>
			<i onclick="detailAgencyModel('<?=$agency_user_id;?>','<?=$next_id;?>','<?=$mode;?>');" style="font-size:40px;" class="fa fa-arrow-right"></i>
		</td>
	</tr>
</table>