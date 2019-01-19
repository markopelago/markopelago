<script>
	function loadReview(transaction_ids){
		$.get("ajax/transaction.php?mode=reviewForm&transaction_ids="+transaction_ids, function(returnval){
			$('#modalTitle').html("<img src='assets/review.png' height='20'> &nbsp;<?=v("review");?>");
			$('#modalBody').html(returnval);
			$('#modalFooter').html("<button type=\"button\" class=\"btn btn-primary\" onclick=\"form_review.submit();\"><?=v("save");?></button>");
			$('#myModal').modal('show');
		});
	}
	
	function showReview(transaction_ids){
		$.get("ajax/transaction.php?mode=showReview&transaction_ids="+transaction_ids, function(returnval){
			$('#modalTitle').html("<img src='assets/review.png' height='20'> &nbsp;<?=v("review");?>");
			$('#modalBody').html(returnval);
			$('#modalFooter').html("<button type=\"button\" class=\"btn btn-warning\" data-dismiss=\"modal\"><?=v("close");?></button>");
			$('#myModal').modal('show');
		});
	}
</script>
<?php
	if(isset($_POST["saving_review"])){
		$is_reviewed = false;
		foreach($_POST["review_level"] as $transaction_id => $review_level){
			$buyer_user_id = $db->fetch_single_data("transactions","buyer_user_id",["id" => $transaction_id]);
			if($buyer_user_id == $__user_id){
				$review_description = $_POST["review_description"][$transaction_id];
				$db->addtable("transaction_details");	$db->where("transaction_id",$transaction_id);
				if($review_level > 0){
					$db->addfield("is_reviewed");		$db->addvalue("1");
					$db->addfield("review_level");		$db->addvalue($review_level);
				}
				$db->addfield("review_at");				$db->addvalue($__now);
				$db->addfield("review_description");	$db->addvalue($review_description);
				$updating = $db->update();
				if($updating["affected_rows"] > 0 && $review_level > 0) $is_reviewed = true;
			}
		}
		if($is_reviewed) $_SESSION["message"] = v("review_saved_successfully");
		javascript("window.location=\"?".$_SERVER["QUERY_STRING"]."\"");
		exit();
	}
?>