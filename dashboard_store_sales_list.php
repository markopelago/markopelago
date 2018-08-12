<form method="GET">
	<?=$f->input("tabActive",$_GET["tabActive"],"type='hidden'");?>
	<table>
		<?php 
			echo $t->row(
				["<b>".v("po_at").":</b><br>".$f->input("po_at1",$_GET["po_at1"],"style='display: inline !important;width:auto !important;' type='date'","form-control") ." - ".
				 $f->input("po_at2",$_GET["po_at2"],"style='display: inline !important;width:auto !important;' type='date'","form-control"),
				 "<b>Status:</b><br>".$f->select("status",transactionstatuses(),$_GET["status"],"style='display: inline !important;width:auto !important;'","form-control"),
				 "<br><button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-search'></span></button>",
				]);
		?>
	</table>
</form>
<br>
<table class="table table-striped table-hover">
	<thead> <?=$t->header(["",v("po_at"),v("po_no"),v("buyer"),v("goods"),"Total (Rp)","Status",""]);?> </thead>
	<tbody>
		<?php
			$whereclause = "status > 2 AND seller_user_id='".$__user_id."'";
			if($_GET["po_at1"] != "") 	$whereclause .= " AND po_at >= '".$_GET["po_at1"]."'";
			if($_GET["po_at2"] != "") 	$whereclause .= " AND po_at <= '".$_GET["po_at2"]."'";
			if($_GET["status"] != "")	 $whereclause .= " AND status = '".$_GET["status"]."'";
			$transactions = $db->fetch_all_data("transactions",[],$whereclause." GROUP BY po_no","po_at DESC");
			if(count($transactions) <= 0){
				?> <tr class="danger"><td colspan="6" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
			} else {
				foreach($transactions as $transaction){
					$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
					$goods_names = "";
					$total = 0;
					$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$transaction["po_no"]."')");
					foreach($transaction_details as $transaction_detail){
						$goods_names .= $db->fetch_single_data("goods","name",["id" => $transaction_detail["goods_id"]])."<br>";
						$total += $transaction_detail["total"];
					}
					$goods_names = substr($goods_names,0,-4);
					$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$transaction["po_no"]."')");
					foreach($transaction_forwarders as $transaction_forwarder){
						$total += $transaction_forwarder["total"];
					}
					$viewUrl = "mypo.php?po_no=".$transaction["po_no"];
					?>
					<tr>
						<td class="nowrap"><a href="<?=$viewUrl;?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a></td>
						<td class="nowrap"><?=format_tanggal($transaction["po_at"]);?></td>
						<td class="nowrap"><?=$transaction["po_no"];?></td>
						<td class="nowrap"><?=$buyer;?></td>
						<td class="nowrap"><?=$goods_names;?></td>
						<td class="nowrap" align="right"><?=format_amount($total);?></td>
						<td class="nowrap"><?=transactionList($transaction["status"]);?></td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>