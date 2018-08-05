<table class="table table-striped table-hover">
	<thead> <?=$t->header([v("invoice_at"),v("invoice_no"),v("store_name"),v("goods"),"Nominal","Status",""]);?> </thead>
	<tbody>
		<?php
			$transactions = $db->fetch_all_data("transactions",[],"status > 1 AND buyer_user_id='".$__user_id."' GROUP BY invoice_no","invoice_at DESC");
			if(count($transactions) <= 0){
				?> <tr class="danger"><td colspan="6" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
			} else {
				foreach($transactions as $transaction){
					$nominal = $db->fetch_single_data("transaction_payments","concat(total+uniqcode)",["invoice_no" => $transaction["invoice_no"]]);
					
					?>
					<tr onclick="window.open('mycart.php?cart_group=<?=$transaction["cart_group"];?>')" style="cursor:pointer;">
						<td class="nowrap"><?=format_tanggal($transaction["invoice_at"]);?></td>
						<td class="nowrap"><?=$transaction["invoice_no"];?></td>
						<td class="nowrap"><?=$store;?></td>
						<td class="nowrap"><?=$goods;?></td>
						<td class="nowrap"><?=format_amount($nominal);?></td>
						<td class="nowrap"><?=transactionList($transaction["status"]);?></td>
					</tr>
					<?php
				}
			}
		?>
	</tbody>
</table>