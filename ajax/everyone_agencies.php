<?php include_once "../common.php"; ?>
	<div class="row">
		<table width="100%"><tr><td align="center"><h2><?=v("agencies");?></h2></td></tr></table>
		<div class="col-md-12">
		<ul id="waterfall">
		<?php
			$whereclause = "user_id IN (SELECT id FROM a_users WHERE role='3' AND verified = '1') ORDER BY RAND()";
			$agency_profiles = $db->fetch_all_data("agency_profiles",[],$whereclause,"","20");
			$ii = -1;
			foreach($agency_profiles as $agency_profile){
				$ii++;
				$name = $agency_profile["name"];
				$location = $db->fetch_single_data("locations","name_".$__locale,["id" => $agency_profile["location_id"]]);
		?>
			<li>
				<div class="thumbnail" style="margin:4px;cursor:pointer;" onclick="window.location='agency_details.php?id=<?=$agency_profile["user_id"];?>';">
					<img style="max-width: 200px;" src="user_images/<?=$agency_profile["photo"];?>">
					<div><b><?=$name;?></b><p><?=$location;?></p></div>
				</div>
			</li>
		<?php } ?>
		</ul>
		</div>
		<?=$f->input("agency_more","More","type='button' style='width:100%;' onclick=\"window.location='agencies.php';\"","btn btn-lg btn-info");?>
	</div>
	<script>
		$(document).ready(function ()
        {
            $('#waterfall').NewWaterfall({width: 220});
        });
	</script>