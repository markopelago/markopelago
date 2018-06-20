<?php include_once "header.php"; ?>
<?php if(!$__isBackofficer){ ?><script> window.location="index.php";</script><?php } ?>
<div class="container">
	<h2 class="well col-md-12"><b><?=v("survey");?></b></h2>
	<div class="row">
		<div class="col-md-12">
			<a href="survey_add.php?template_id=1" class="btn btn-info"><?=v("seller_survey");?></a>
			<a href="survey_add.php?template_id=2" class="btn btn-info"><?=v("forwarder_survey");?></a>
		</div>
	</div>
	<div class="row">
	<div class="col-md-12"><h3><?=v("my_survey_histories");?></h3></div>
	</div>
	<div class="row scrolling-wrapper">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th><?=v("name");?></th>
					<th><?=v("phone");?></th>
					<th>Email</th>
					<th><?=v("location");?></th>
					<th class="nowrap"><?=v("survey_date");?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$surveys = $db->fetch_all_data("surveys",[],"user_id='".$__user_id."'","id DESC","100");
					if(count($surveys) <= 0){
						?> <tr class="danger"><td colspan="5" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
					} else {
						foreach($surveys as $survey){
							?>
							<tr onclick="window.location='survey_edit.php?id=<?=$survey["id"];?>'" style="cursor:pointer;">
								<td class="nowrap"><?=$survey["name"];?></td>
								<td class="nowrap"><?=$survey["phone"];?></td>
								<td class="nowrap"><?=$survey["email"];?></td>
								<td class="nowrap"><?=$db->fetch_single_data("locations","name_".$__locale,["id"=>$survey["location_id"]]);?></td>
								<td class="nowrap"><?=format_tanggal($survey["surveyed_at"]);?></td>
							</tr>
							<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<div style="height:40px;"></div>
<?php include_once "footer.php"; ?>