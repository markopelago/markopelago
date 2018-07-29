<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Invoice No</th>
			<th>Buyer</th>
			<th>Nominal</th>
			<th>Status</th>
			<th>Transaction At</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$transactions = $db->fetch_all_data("transactions",[],"status > 1 AND seller_user_id='".$__user_id."' GROUP BY invoice_no");
			if(count($transactions) <= 0){
				?> <tr class="danger"><td colspan="5" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
			} else {
				foreach($transactions as $transaction){
					$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
					$nominal = $db->fetch_single_data("transaction_payments","concat(total+uniqcode)",["invoice_no" => $transaction["invoice_no"]]);
					$status = $f->select("status",["2" => "Paid","3" => "On Process"],$transaction["status"],"onchange=\"window.location='?changeStatus='+this.value+'&invoice_no=".$transaction["invoice_no"]."'\"");
					?>
					<tr onclick="window.open('mycart.php?cart_group=<?=$transaction["cart_group"];?>')" style="cursor:pointer;">
						<td class="nowrap"><?=$transaction["invoice_no"];?></td>
						<td class="nowrap"><?=$buyer;?></td>
						<td class="nowrap"><?=format_amount($nominal);?></td>
						<td class="nowrap"><?=$status;?></td>
						<td class="nowrap"><?=format_tanggal($invoice_no["transaction_at"]);?></td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>