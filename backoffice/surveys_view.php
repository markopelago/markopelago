<?php include_once "head.php";?>
<div class="bo_title">Survey View</div>
<style>
.survey-photo img{
	width:300px;
}
.survey-photo {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border .2s ease-in-out;
	width:300px;
	font-size:12px;
	font-weight:bolder;
}
</style>

<?php
	$survey = $db->fetch_all_data("surveys",[],"id='".$_GET["id"]."'")[0];
	$surveyor_name = $db->fetch_single_data("a_users","name",["id" => $survey["user_id"]]);
	$surveyor_phone = $db->fetch_single_data("a_users","phone",["id" => $survey["user_id"]]);
	$location = $db->fetch_single_data("locations","name_id",["id" => $survey["location_id"]]);
	$survey_id = $survey["id"];
?>
<?=$t->start("","editor_content");?>
	<?=$t->row(["Nama Surveyor",$surveyor_name]);?>
	<?=$t->row(["No HP",$surveyor_phone]);?>
	<?=$t->row([""],["colspan='2'"]);?>
	<?=$t->row([""],["colspan='2'"]);?>
	<?=$t->row(["<b>Informasi Personal Calon Seller / Merchant</b>"],["colspan='2'"]);?>
	<?=$t->row(["Nama",$survey["name"]]);?>
	<?=$t->row(["Phone",$survey["phone"]]);?>
	<?=$t->row(["Email",$survey["email"]]);?>
	<?=$t->row(["Alamat",$survey["address"]]);?>
	<?=$t->row(["Location",$location]);?>
<?=$t->end();?>
<?php
	$survey_details = $db->fetch_all_data("survey_details",[],"survey_id='".$survey_id."' AND parent_id='0'","seqno");
	foreach($survey_details as $survey_detail){
		echo $t->start("","data_content");
			echo $t->header(["<b>".$survey_detail["title"]."</b>"],["colspan='3'"]);
			$_survey_details = $db->fetch_all_data("survey_details",[],"survey_id='".$survey_id."' AND parent_id='".$survey_detail["id"]."'","seqno");
			foreach($_survey_details as $_survey_detail){
				$answer = $_survey_detail["answer"];
				if($_survey_detail["answers"] != ""){
					$arrAnswers = unserialize(base64_decode($_survey_detail["answers"]));
					$answer = $arrAnswers[$answer];
				}
				echo $t->row([$_survey_detail["seqno"],$_survey_detail["question"],$answer],["align='right' valign='top' width='2%'","valign='top' width='78%'","valign='top' width='20%'"]);
			}
		echo $t->end();
	}
?>
<br>
<?php
	$survey_photos = $db->fetch_all_data("survey_photos",[],"survey_id='".$survey_id."'","seqno");
	foreach($survey_photos as $survey_photo){
		?>
		<div class="survey-photo">
			<img src="../surveys/<?=$survey_photo["filename"];?>">
			<?=$survey_photo["caption"];?>
		</div>
		<?php
	}
?>
	
<?=$f->input("back","Back","type='button' onclick=\"window.location='".str_replace("_view","_list",$_SERVER["PHP_SELF"])."';\"");?>
<?php include_once "footer.php";?>