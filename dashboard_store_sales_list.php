<div class="panel-group" id="panel_filter_group_store">
	<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#panel_filter_group_store" href="#panel_filter_store">
			<h3 class="panel-title"><b>Filter</b></h3>
			<span class="pull-right panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
		</div>
		<div id="panel_filter_store" class="panel-collapse collapse">
			<div class="panel-body" style="background-color:#e7e7e7;">
				<form method="GET">
					<?=$f->input("tabActive","store_sales_list","type='hidden'");?>
					<div class="form-group">
						<label><?=v("po_at");?></label> 
						<div class="col-md-5">
							<?=$f->input("po_at1",@$_GET["po_at1"],"type='date'","form-control");?>
						</div>
						<div class="col-md-1"><center><?=v("to");?></center></div>
						<div class="col-md-5">
							<?=$f->input("po_at2",@$_GET["po_at2"],"type='date'","form-control");?>
						</div>
					</div>
					<?php if(!isMobile()) echo "<br><br>";?>
					<div class="form-group">
						<label>Status</label>
						<?=$f->select("status_store_sales_list",transactionstatuses(),$_GET["status_store_sales_list"],"style='display: inline !important;width:auto !important;'","form-control");?>
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
		<thead> <?=$t->header(["",v("po_at"),v("po_no"),v("buyer"),v("goods"),"Total (Rp)","Status"]);?> </thead>
		<tbody>
			<?php
				$whereclause = "status = 2 AND seller_user_id='".$__user_id."'";
				if($_GET["tabActive"] == "store_sales_list"){
					if($_GET["po_at1"] != "") 	$whereclause .= " AND po_at >= '".$_GET["po_at1"]."'";
					if($_GET["po_at2"] != "") 	$whereclause .= " AND po_at <= '".$_GET["po_at2"]."'";
					if($_GET["status_store_sales_list"] != "")	 $whereclause .= " AND status = '".$_GET["status_store_sales_list"]."'";
				}
				$transactions1 = $db->fetch_all_data("transactions",[],$whereclause." GROUP BY invoice_no","id DESC");
			
			
				$whereclause = "status > 2 AND seller_user_id='".$__user_id."'";
				if($_GET["tabActive"] == "store_sales_list"){
					if($_GET["po_at1"] != "") 	$whereclause .= " AND po_at >= '".$_GET["po_at1"]."'";
					if($_GET["po_at2"] != "") 	$whereclause .= " AND po_at <= '".$_GET["po_at2"]."'";
					if($_GET["status_store_sales_list"] != "")	 $whereclause .= " AND status = '".$_GET["status_store_sales_list"]."'";					
				}
				$transactions2 = $db->fetch_all_data("transactions",[],$whereclause." GROUP BY po_no","po_at DESC");
				$transactions = array_merge($transactions1,$transactions2);
				if(count($transactions) <= 0){
					?> <tr class="danger"><td colspan="8" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($transactions as $transaction){
						$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
						$goods_names = "";
						$total = 0;
						$has_review_ids = "";
						if($transaction["po_no"] != "") $transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$transaction["po_no"]."')");
						else $transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE invoice_no = '".$transaction["invoice_no"]."' AND seller_user_id='".$__user_id."')");
						foreach($transaction_details as $transaction_detail){
							$goods_names .= $db->fetch_single_data("goods","name",["id" => $transaction_detail["goods_id"]])."<br>";
							$total += $transaction_detail["total"];
							if($transaction_detail["review_id_read"] == 0 && $transaction_detail["is_reviewed"] == 1) $has_review_ids .= $transaction_detail["transaction_id"].",";
						}
						$has_review_ids = substr($has_review_ids,0,-1);
						$goods_names = substr($goods_names,0,-4);
						// if($transaction["po_no"] != "") $transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$transaction["po_no"]."')");
						// else  $transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE invoice_no = '".$transaction["invoice_no"]."' AND seller_user_id='".$__user_id."')");
						// foreach($transaction_forwarders as $transaction_forwarder){
							// $total += $transaction_forwarder["total"];
						// }
						if($transaction["po_no"] != "") $viewUrl = "mypo.php?po_no=".$transaction["po_no"];
						else $viewUrl = "mypo.php?invoice_no=".$transaction["invoice_no"];
						$status = transactionList($transaction["status"]);
						$is_cod = $db->fetch_single_data("transaction_payments","id",["cart_group" => $transaction["cart_group"],"payment_type_id" => "-1"]);
						if($is_cod && $transaction["status"] == "3") $status = v("wait_for_process_from_seller");
						$btn_delete = "";
						if($is_cod && $transaction["status"] <= 3){
							$btn_delete = "&nbsp;<a href=\"javascript:delete_po('".$transaction["po_no"]."');\" class=\"btn btn-warning\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
						}
						$tr_style = "";
						if($transaction["status"] == 2 || $transaction["status"] == 3 || $transaction["status"] == 4 || $has_review_ids != "") $tr_style = "style='background-color:#faebcc;'";
						?>
						<tr <?=$tr_style;?>>
							<td class="nowrap">
								<a href="<?=$viewUrl;?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a>
								<?php if($has_review_ids != ""){ ?>
									<a href="javascript:showReview('<?=$has_review_ids;?>');"><img src="assets/review.png" height="25"></a>
								<?php } ?>
								<?=$btn_delete;?>
							</td>
							<td class="nowrap"><?=format_tanggal($transaction["po_at"]);?></td>
							<td class="nowrap"><?=$transaction["po_no"];?></td>
							<td class="nowrap"><?=$buyer;?></td>
							<td class="nowrap"><?=$goods_names;?></td>
							<td class="nowrap" align="right"><?=format_amount($total);?></td>
							<td class="nowrap"><?=$status;?></td>
						</tr>
						<?php
					}
				}
			?>
		</tbody>
	</table>
</div>