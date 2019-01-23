<div class="panel-group" id="panel_filter_group_delivering">
	<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#panel_filter_group_delivering" href="#panel_filter_delivering">
			<h3 class="panel-title"><b>Filter</b></h3>
			<span class="pull-right panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
		</div>
		<div id="panel_filter_delivering" class="panel-collapse collapse">
			<div class="panel-body" style="background-color:#e7e7e7;">
				<form method="GET">
					<?=$f->input("tabActive","list_of_delivering_goods","type='hidden'");?>
					<div class="form-group">
						<label><?=v("pickup_at");?></label> 
						<div class="col-md-5">
							<?=$f->input("markoantar_status1_at1",$_GET["markoantar_status1_at1"],"type='date'","form-control");?>
						</div>
						<div class="col-md-1"><center><?=v("to");?></center></div>
						<div class="col-md-5">
							<?=$f->input("markoantar_status1_at2",$_GET["markoantar_status1_at2"],"type='date'","form-control");?>
						</div>
					</div>
					<?php if(!isMobile()) echo "<br><br>";?>
					<div class="form-group">
						<label>Status</label>
						<?=$f->select("markoantar_status",$db->fetch_select_data("markoantar_statuses","id","name_".$__locale,[],[],"",true),$_GET["markoantar_status"],"style='display: inline !important;width:auto !important;'","form-control");?>
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
		<thead> <?=$t->header(["",v("date"),v("po_no"),v("seller"),v("pickup_location"),v("destination_location"),"Status"]);?> </thead>
		<tbody>
			<?php
				$whereclause = "markoantar_status > 0 AND forwarder_user_id='".$__user_id."'";
				if($_GET["tabActive"] == "list_of_delivering_goods"){
					if($_GET["markoantar_status1_at1"] != "") 	$whereclause .= " AND date(markoantar_status1_at) >= '".$_GET["markoantar_status1_at1"]."'";
					if($_GET["markoantar_status1_at2"] != "") 	$whereclause .= " AND date(markoantar_status1_at) <= '".$_GET["markoantar_status1_at2"]."'";
					if($_GET["markoantar_status"] != "")	 $whereclause .= " AND markoantar_status = '".$_GET["markoantar_status"]."'";					
				}
				$transaction_forwarders = $db->fetch_all_data("transaction_forwarder",[],$whereclause,"markoantar_status1_at DESC");
				if(count($transaction_forwarders) <= 0){
					?> <tr class="danger"><td colspan="8" align="center"><b><?=v("data_not_found");?></b></td></tr> <?php
				} else {
					foreach($transaction_forwarders as $transaction_forwarder){
						$cart_group = $db->fetch_single_data("transactions","cart_group",["id" => $transaction_forwarder["transaction_id"]]);
						if(!$cart_group) $cart_group = $transaction_forwarder["cart_group"];
						if(!$cart_groups[$cart_group]){
							$cart_groups[$cart_group] = 1;
							$seller_user_id = $db->fetch_single_data("transactions","seller_user_id",["id" => $transaction_forwarder["transaction_id"]]);
							if(!$seller_user_id) $seller_user_id = $db->fetch_single_data("sellers","user_id",["id" => $transaction_forwarder["seller_id"]]);
							$po_no = $db->fetch_single_data("transactions","po_no",["id" => $transaction_forwarder["transaction_id"]]);
							if(!$po_no) $po_no = $db->fetch_single_data("transactions","po_no",["cart_group" => $cart_group,"seller_user_id" => $seller_user_id]);
							$seller = $db->fetch_single_data("sellers","name",["user_id" => $seller_user_id]);
							$pickup_locations = get_location($transaction_forwarder["pickup_location_id"]);
							$destination_locations = get_location($transaction_forwarder["user_address_location_id"]);
							$viewUrl = "my_delivering_goods.php?deliver_id=".$transaction_forwarder["id"];
							?>
							<tr>
								<td class="nowrap"><a href="<?=$viewUrl;?>" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></a></td>
								<td class="nowrap"><?=format_tanggal($transaction_forwarder["markoantar_status1_at"]);?></td>
								<td class="nowrap"><?=$po_no;?></td>
								<td class="nowrap"><?=$seller;?></td>
								<td class="nowrap"><?=$pickup_locations[3]["name"].", ".$pickup_locations[1]["name"];?></td>
								<td class="nowrap"><?=$destination_locations[3]["name"].", ".$destination_locations[1]["name"];?></td>
								<td class="nowrap"><?=markoantar_status($transaction_forwarder["markoantar_status"]);?></td>
							</tr>
							<?php
						}
					}
				}
			?>
		</tbody>
	</table>
</div>