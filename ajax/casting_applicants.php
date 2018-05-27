<?php 
	include_once "../common.php";
	$id = $_GET["id"];
	$applicants = $db->fetch_all_data("applied_jobs",[],"job_id = '$id' AND job_giver_user_id='$__user_id'","created_at DESC");
?>									
	<div class="row">
		<?php 
			if(count($applicants) > 0){
				foreach($applicants as $applicant){
					$role = $js->get_role($applicant["user_id"]);
					if($role == 3){
						$profile = $db->fetch_all_data("agency_profiles",[],"user_id='".$applicant["user_id"]."'")[0];
						if($profile["photo"] == "" || !file_exists("../user_images/".$profile["photo"])) $profile["photo"] = "nophoto.png";
						$detailFile = "agency_details.php";
					}
					if($role == 5){
						$profile = $db->fetch_all_data("model_profiles",[],"user_id='".$applicant["user_id"]."'")[0];
						if($profile["photo"] == "" || !file_exists("../user_images/".$profile["photo"])) $profile["photo"] = "nophoto.png";
						$profile["name"] = $profile["first_name"]." ".$profile["middle_name"]." ".$profile["last_name"];
						$detailFile = "model_details.php";
					}
					?>
					<div class="col-sm-12" style="margin:4px;cursor:pointer;" onclick="window.open('<?=$detailFile;?>?user_id=<?=$applicant["user_id"];?>');">
						<div class="col-sm-3">
							<img style="margin-top:10px" width="100" src="user_images/<?=$profile["photo"];?>">
							<?php if($role == 3){ echo "<h2>".v("agency")."</h2>"; } ?>
							<?php if($role == 5){ echo "<h2>".v("model")."</h2>"; } ?>
						</div>
						<div class="col-sm-9">
							<div><h3><?=$profile["name"];?></h3></div>
							<?php if($role == 5){ ?>
								<h3><?=v("nationality");?> : <b><?=$db->fetch_single_data("nationalities","name",["id" => $profile["nationality_id"]]);?></b></h3>
								<div style="width:100%;border-top:1px solid #888;"></div>
								
								<?=v("gender");?> :
								<div class="container" style="width:100%"> <?=$db->fetch_single_data("genders","name",["id" =>$profile["gender_id"]]);?> </div>
								<div style="width:100%;border-top:1px solid #888;"></div>
								
								<?=v("birth_at");?> :
								<div class="container" style="width:100%"> <?=format_tanggal($profile["birth_at"],"d M Y");?> </div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									<table class="tbl_detail">
										<tr>
											<td>Hair</td><td>Eyes</td><td>Height</td>
											<?php if($profile["model_category_ids"] != 1) { ?>
											<td>Bust</td>
											<?php } ?>
										</tr>
										<tr><td style="height:10px;"></td></tr>
										<tr style="font-weight:bolder;">
											<td><?=$db->fetch_single_data("hair_colors","name",["id" => $profile["hair_color_id"]]);?></td>
											<td><?=$db->fetch_single_data("eye_colors","name",["id" => $profile["eye_colors_id"]]);?></td>
											<td><?=$profile["height"]*1;?> cm</td>
											<?php if($profile["model_category_ids"] != 1) { ?>
											<td><?=$profile["bust"];?></td>
											<?php } ?>
										</tr>
									</table>
									<div style="width:100%;border-top:1px solid #888;"></div>
									<br>
									<div style="width:100%;border-top:1px solid #888;"></div>
									<table class="tbl_detail">
										<tr>
											<td>chest</td><td>Waist</td><td>Hips</td><td>Shoe</td>
										</tr>
										<tr><td style="height:10px;"></td></tr>
										<tr>
											<td><?=$profile["chest"]*1;?> cm</td>
											<td><?=$profile["waist"]*1;?> cm</td>
											<td><?=$profile["hips"]*1;?> cm</td>
											<td><?=$profile["shoe"]*1;?></td>
										</tr>
									</table>
								<div style="width:100%;border-top:1px solid #888;"></div>

								<?=v("model_category");?> : 
								<div class="container" style="width:100%"><?=$db->fetch_single_data("model_categories","name_".$__locale,["id" => $profile["model_category_ids"]]);?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>

								<?=v("address");?> :
								<div class="container" style="width:100%">
									<?=str_replace([chr(10),chr(13)],["<br>",""],$profile["address"]);?><br>
									<?=$db->fetch_single_data("locations","name_".$__locale,["id" =>$profile["location_id"]]);?>
								</div>
								<div style="width:100%;border-top:1px solid #888;"></div>

								<?php if($profile["ig"]!=""){ ?> Instagram :<div class="container" style="width:100%"><?=$profile["ig"];?></div><?php } ?>
								<?php if($profile["fb"]!=""){ ?> Facebook:<div class="container" style="width:100%"><?=$profile["fb"];?></div><?php } ?>
								<?php if($profile["tw"]!=""){ ?> Twitter :<div class="container" style="width:100%"><?=$profile["tw"];?></div><?php } ?>
								<?php if($profile["ig"]!="" || $profile["fb"]!="" || $profile["tw"]!=""){ ?> <div style="width:100%;border-top:1px solid #888;"></div> <?php } ?>
							<?php } ?>
							<?php if($role == 3){ ?>
								PIC :
									<div class="container" style="width:100%"><?=$profile["pic"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									<?=v("idcard");?> :
									<div class="container" style="width:100%"><?=$profile["idcard"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									Address :
									<div class="container" style="width:100%">
										<?=str_replace([chr(10),chr(13)],["<br>",""],$profile["address"]);?><br>
										<?=$db->fetch_single_data("locations","name_".$__locale,["id"=>$profile["location_id"]])." - ".$profile["zipcode"];?>
									</div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									Phone :
									<div class="container" style="width:100%"><?=$profile["phone"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									Cellphone :
									<div class="container" style="width:100%"><?=$profile["cellphone"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									Web :
									<div class="container" style="width:100%"><?=$profile["web"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
									<?=v("nationality");?> :
									<div class="container" style="width:100%"><?=$db->fetch_single_data("nationalities","name",["id"=>$profile["nationality_id"]]);?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
								<?php if($profile["ig"]!=""){ ?> Instagram :<div class="container" style="width:100%"><?=$profile["ig"];?></div><?php } ?>
								<?php if($profile["fb"]!=""){ ?> Facebook:<div class="container" style="width:100%"><?=$profile["fb"];?></div><?php } ?>
								<?php if($profile["tw"]!=""){ ?> Twitter :<div class="container" style="width:100%"><?=$profile["tw"];?></div><?php } ?>
								<?php if($profile["ig"]!="" || $profile["fb"]!="" || $profile["tw"]!=""){ ?> <div style="width:100%;border-top:1px solid #888;"></div> <?php } ?>

									<?=v("about");?> :
									<div class="container" style="width:100%"><?=$profile["about"];?></div>
								<div style="width:100%;border-top:1px solid #888;"></div>
							<?php } ?>
						</div>
					</div>
					<div class="col-sm-12" style="padding-bottom:10px;border-bottom:1px solid #aaa;width:100%;"></div>
					<?php 
				} 
			} else {
				echo "<span class='col-sm-12 well' style='color:red;'>".v("data_not_found")."</span>";
			}				
		?>
	</div>