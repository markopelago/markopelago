<?php
	$parent_for = $_GET["parent_for"];
	if(!$parent_for) $parent_for = 0;
	if($parent_for > 0){ $parent_for_1 = $parent_for - 1; $step_1 = $step; }
	if($parent_for == 0) $step_1 = 1;
	$backurl = "?id=".$id."&step=".$step_1."&parent_for=".$parent_for_1;
	$data = $db->fetch_all_data("survey_details",[],"survey_id='".$id."'");
	if(count($data) <= 0){
		$templates = $db->fetch_all_data("survey_template_details",[],"survey_template_id='".$template_id."'");
		foreach($templates as $template){
			$db->addtable("survey_details");
			$db->addfield("survey_id");		$db->addvalue($id);
			$db->addfield("parent_id");		$db->addvalue($template["parent_id"]);
			$db->addfield("seqno");			$db->addvalue($template["seqno"]);
			$db->addfield("title");			$db->addvalue($template["title"]);
			$db->addfield("question");		$db->addvalue($template["question"]);
			$db->addfield("answers");		$db->addvalue($template["answers"]);
			$inserting = $db->insert();
		}
	}
	if(isset($_POST["next"])){
		foreach($_POST["answer"] as $survey_detail_id => $answer){
			$db->addtable("survey_details");
			$db->where("survey_id","(SELECT id FROM surveys WHERE user_id='".$__user_id."')","s","IN");
			$db->where("id",$survey_detail_id);
			$db->addfield("answer");			$db->addvalue($answer);
			$updating = $db->update();
		}
		
		$nexturl = "?id=".$id."&step=2&parent_for=".($parent_for+1);
		if($db->fetch_all_data("survey_details",["id"],"survey_id='".$id."' AND parent_id='0'","seqno")[$parent_for+1]["id"] <= 0) $nexturl = "?id=".$id."&step=photo";
		
		javascript("window.location=\"".$nexturl."\";");
	}
	$locations = $db->fetch_select_data("locations","id","name_".$__locale,[],"parent_id,seqno");
	if(!$data["surveyed_at"]) $data["surveyed_at"] = substr($__now,0,10);
	$parent = $db->fetch_all_data("survey_details",[],"survey_id='".$id."' AND parent_id='0'","seqno")[$parent_for];
?>
<form role="form" method="POST" autocomplete="off">
	<h3><b><?=$parent["title"];?></b></h3>
	<div class="col-md-12">
		<?php
			$survey_details = $db->fetch_all_data("survey_details",[],"survey_id='".$id."' AND parent_id='".$parent["id"]."'","seqno");
			foreach($survey_details as $survey_detail){
				if($survey_detail["answers"] != ""){
					$answers = "";
					$_answers = unserialize(base64_decode($survey_detail["answers"]));
					foreach($_answers as $key => $_answer){
						$checked = "";
						if($survey_detail["answer"] == $key) $checked = "checked";
						$answers .= $f->input("answer[".$survey_detail["id"]."]",$key,"type='radio' ".$checked)."&nbsp;".$_answer."&nbsp;&nbsp;";
					}
				} else {
					$answers = $f->textarea("answer[".$survey_detail["id"]."]",$survey_detail["answer"],"","form-control");
				}
		?>
			<div class="form-group">
				<label class="survey-label"><?=$survey_detail["question"];?></label>
				<?=$answers;?>
			</div>
		<?php 
			}
		?>
		<div class="form-group">
			<?=$f->input("back",v("back"),"type='button' onclick=\"window.location='".$backurl."';\"","btn btn-warning");?>
			<?=$f->input("next",v("next"),"type='submit'","btn btn-primary");?>
		</div>
	</div>
</form>