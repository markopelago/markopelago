<div class="panel-group" id="panel_filter_group_purchase">
	<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#panel_filter_group_purchase" href="#panel_filter_purchase">
			<h3 class="panel-title"><b>Filter</b></h3>
			<span class="pull-right panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
		</div>
		<div id="panel_filter_purchase" class="panel-collapse collapse">
			<div class="panel-body" style="background-color:#e7e7e7;">
				<form method="GET">
					<?=$f->input("tabActive","purchase_list","type='hidden'");?>
					<div class="form-group">
						<label><?=v("invoice_at");?></label> 
						<div class="col-md-5">
							<?=$f->input("invoice_at1",$_GET["invoice_at1"],"type='date'","form-control") ;?>
						</div>
						<div class="col-md-1"><center><?=v("to");?></center></div>
						<div class="col-md-6">
							<?=$f->input("invoice_at2",$_GET["invoice_at2"],"type='date'","form-control");?>
						</div>
					</div>
					<div class="form-group">
						<label>Status</label>
						<?=$f->select("status_purchase_list",transactionstatuses(),$_GET["status_purchase_list"],"style='display: inline !important;width:auto !important;'","form-control");?>
					</div>
					<div class="form-group"><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> <?v("search");?></button></div>
				</form>
			</div>
		</div>
	</div>
</div>
<br>
<div class="row scrolling-wrapper">
	<table class="table table-striped table-hover">
		<thead> <?=$t->header(["",v("invoice_at"),v("invoice_no"),v("store_name"),v("goods"),"Total (Rp)","Status"]);?> </thead>
		<tbody>
			<?php
				$whereclause = "status >= 1 AND buyer_user_id='".$__user_id."'";
				if($_GET["tabActive"] == "purchase_list"){
					if($_GET["invoice_at1"] != "") 	$whereclause .= " AND invoice_at >= '".$_GET["invoice_at1"]."'";
					if($_GET["invoice_at2"] != "") 	$whereclause .= " AND invoice_at <= '".$_GET["invoice_at2"]."'";
					if($_GET["status_purchase_list"] != "")	 	$whereclause .= " AND status = '".$_GET["status_purchase_list"]."'";
				}
				$transactions = $db->fetch_all_data("transactions",[],$whereclause." GROUP BY invoice_no,po_no","invoice_at DESC");
				if(count($transactions) <= 0){
					?> <tr class="danger"><td colspan="8" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($transactions as $transaction){
						$goods_names = "";
						$seller_ids = "";
						$total = 0;
						$cart_group = $transaction["cart_group"];
						$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE invoice_no = '".$transaction["invoice_no"]."' AND po_no = '".$transaction["po_no"]."')");
						$need_review_ids = "";
						foreach($transaction_details as $transaction_detail){
							$goods_names .= $db->fetch_single_data("goods","name",["id" => $transaction_detail["goods_id"]])."<br>";
							$total += $transaction_detail["total"];
							if($transaction["status"] == 7 && $transaction_detail["is_reviewed"] == 0) $need_review_ids .= $transaction_detail["transaction_id"].",";
							$seller_ids .= $db->fetch_single_data("goods","seller_id",["id" => $transaction_detail["goods_id"]]).",";
						}
						$need_review_ids = substr($need_review_ids,0,-1);
						$seller_ids = substr($seller_ids,0,-1);
						$goods_names = substr($goods_names,0,-4);
						$seller_names = "";
						$statuses = "";
						$sellers = $db->fetch_all_data("sellers",[],"id IN (".$seller_ids.")");
						foreach($sellers as $seller){ 
							$seller_names .= $db->fetch_single_data("sellers","name",["id" => $seller["id"]])."<br>"; 
							$transaction_status = $db->fetch_single_data("transactions","status",["cart_group" => $cart_group,"seller_user_id" => $seller["user_id"]]);
							$statuses .= transactionList($transaction_status)."<br>"; 
						}
						$seller_names = substr($seller_names,0,-4);
						$statuses = substr($statuses,0,-4);
						$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"cart_group = '".$cart_group."' AND seller_id = '".$seller["id"]."'");
						foreach($transaction_forwarders as $transaction_forwarder){
							$total += $transaction_forwarder["total"];
						}
						$viewUrl = "myinvoice.php?cart_group=".$transaction["cart_group"];
						if($transaction["status"] > 3) $viewUrl = "myinvoice.php?invoice_no=".$transaction["invoice_no"];
						$status = transactionList($transaction["status"]);
						$is_cod = $db->fetch_single_data("transaction_payments","id",["cart_group" => $transaction["cart_group"],"payment_type_id" => "-1"]);
						if($is_cod && $transaction["status"] == "3") $status = v("wait_for_process_from_seller");
						$btn_delete = "";
						if($transaction["status"] <= 1){
							$deleteUrl = "javascript:delete_purchase_list('".$transaction["invoice_no"]."')";
							$btn_delete = "&nbsp;<a href=\"".$deleteUrl."\" class=\"btn btn-warning\" title=\"".v("delete")."\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
						}
						$tr_style = "";
						if($transaction["status"] == 1 || 
							$transaction["status"] == 2 || 
							$transaction["status"] == 5 || 
							$transaction["status"] == 6 || 
							$need_review_ids != "") $tr_style = "style='background-color:#faebcc;'";
						?>
						<tr <?=$tr_style;?>>
							<td class="nowrap">
								<a href="<?=$viewUrl;?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a><?=$btn_delete;?>
								<?php if($need_review_ids != ""){ ?>
									<a href="javascript:loadReview('<?=$need_review_ids;?>');"><img src="assets/review.png" height="25"></a>
								<?php } ?>
							</td>
							<td class="nowrap"><?=format_tanggal($transaction["invoice_at"]);?></td>
							<td class="nowrap"><?=$transaction["invoice_no"];?></td>
							<td class="nowrap"><?=$seller_names;?></td>
							<td class="nowrap"><?=$goods_names;?></td>
							<td class="nowrap" align="right"><?=format_amount($total);?></td>
							<td class="nowrap"><?=$statuses;?></td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>