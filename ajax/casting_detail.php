<?php 
	include_once "../common.php";
	$id = $_GET["id"];
	$casting = $db->fetch_all_data("jobs",[],"id = '$id'")[0];
	$work_category_ids = "";
	foreach(pipetoarray($casting["work_category_ids"]) as $work_category_id){
		$work_category_ids .= $db->fetch_single_data("work_categories","name",["id" => $work_category_id]).", ";
	} $work_category_ids = substr($work_category_ids,0,-2);
	$model_category_ids = "";
	foreach(pipetoarray($casting["model_category_ids"]) as $model_category_id){
		$model_category_ids .= $db->fetch_single_data("model_categories","name_".$__locale,["id" => $model_category_id]).", ";
	} $model_category_ids = substr($model_category_ids,0,-2);
	$age = $casting["age_min"]." - ".$casting["age_max"];
	if($casting["image"] == "" || !file_exists("post_images/".$casting["image"])) $casting["image"] = "no_image.png";
	$job_giver_name = $js->get_fullname($casting["job_giver_user_id"]);
?>									
	<div class="row">
		<div class="col-sm-4">
			<img class="img-responsive" style="margin-top:10px" src="post_images/<?=$casting["image"];?>"><br>
			<b><?=$job_giver_name;?></b>
		</div>
		<div class="col-sm-8">
			<div><h3><?=$casting["title"];?></h3></div>
			<table class="table table-striped">
				<tbody>
					<tr>
						<?php if($casting["casting_start"] != "0000-00-00" && $casting["casting_end"] != "0000-00-00"){ ?>
						<td><b>Casting At</b></td>
						<td><?=format_tanggal($casting["casting_start"],"d M Y");?> to <?=format_tanggal($casting["casting_end"],"d M Y");?></td>
						<?php } ?>
					</tr>	
					<tr>
						<?php if($casting["start_at"] != "0000-00-00" && $casting["end_at"] != "0000-00-00"){ ?>
						<td><b>Event At</b></td>
						<td><?=format_tanggal($casting["start_at"],"d M Y");?> to <?=format_tanggal($casting["end_at"],"d M Y");?></td>
						<?php } ?>
					</tr>
					<tr><td><b>Categories</b></td><td><?=$work_category_ids;?></td></tr>
					<tr><td><b>For</b></td><td><?=$model_category_ids;?></td></tr>
					<tr><td><b>Age</b></td><td><?=$age;?></td></tr>
					<tr><td><b>Description</b></td><td><?=str_replace(chr(13).chr(10),"<br>",$casting["description"]);?></td></tr>
					<tr><td><b>Requirement</b></td><td><?=str_replace(chr(13).chr(10),"<br>",$casting["requirement"]);?></td></tr>
				</tbody>
			</table>
		</div>
	</div>