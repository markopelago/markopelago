<?php include_once "header.php"; ?>
<?php
    $po_no = $_GET["po_no"];
	$transactions = $db->fetch_all_data("transactions",[],"po_no = '".$po_no."' AND seller_user_id = '".$__user_id."'");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	if(isset($_POST["savingPoDelivered"]) && $_POST["savingPoDelivered"] == 1){
		if($_POST["receipt_no"] != ""){
			foreach($transactions as $transaction){
				$db->addtable("transaction_forwarder");	$db->where("transaction_id",$transaction["id"]);
				$db->addfield("receipt_no");	$db->addvalue($_POST["receipt_no"]);
				$db->addfield("receipt_at");	$db->addvalue($__now);
				$updating = $db->update();
				
				$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id = '".$transaction["id"]."'");
				foreach($transaction_details as $transaction_detail){
					$db->addtable("goods_histories");
					$db->addfield("seller_user_id");	$db->addvalue($__user_id);
					$db->addfield("transaction_id");	$db->addvalue($transaction["id"]);
					$db->addfield("goods_id");			$db->addvalue($transaction_detail["goods_id"]);
					$db->addfield("in_out");			$db->addvalue("out");
					$db->addfield("qty");				$db->addvalue($transaction_detail["qty"]);
					$db->addfield("notes");				$db->addvalue($transaction_detail["notes"]);
					$db->addfield("history_at");		$db->addvalue($__now);
					$inserting = $db->insert();
				}
			}
			$db->addtable("transactions");	$db->where("po_no",$po_no); $db->where("seller_user_id",$__user_id);
			$db->addfield("status");		$db->addvalue(5);
			$updating = $db->update();
			$_SESSION["message"] = v("po_was_delivered");
		} else {
			$_SESSION["errormessage"] = v("please_enter_the_shipping_receipt_number");
		}
		javascript("window.location='?po_no=".$po_no."';");
		exit();
	}
	if($_GET["changeStatus"] > 3){
		$db->addtable("transactions");	$db->where("po_no",$po_no); $db->where("seller_user_id",$__user_id);
		$db->addfield("status");		$db->addvalue($_GET["changeStatus"]);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			if($_GET["changeStatus"] == 4) $_SESSION["message"] = v("this_po_has_been_processed");
			if($_GET["changeStatus"] == 5) $_SESSION["message"] = v("po_was_delivered");
			javascript("window.location='?po_no=".$po_no."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
	$status = $db->fetch_single_data("transactions","status",["po_no" => $po_no]);
?>
<script>
	function changeStatus(status){
		var txtConfirm = "";
		if(status == 4){
			if(confirm("<?=v("are_you_sure_to_process_this_po");?> ? ")){
				window.location = "?po_no=<?=$po_no;?>&changeStatus="+status;
			}
		} 
		if(status == 5){
			modalTitle 	= "	<?=v("po_was_delivered");?> ";
			modalBody	= "<form id=\"frmPoDelivered\" method='POST' action='?po_no=<?=$po_no;?>'>";
			modalBody	+= "	<input type='hidden' name='savingPoDelivered' value='1'>";
			modalBody 	+= "	<div class='form-group'>";
			modalBody 	+= "		<label><?=v("please_enter_the_shipping_receipt_number");?> :</label>";
			modalBody 	+= "		<input name='receipt_no' class='form-control' placeholder='<?=v("shipping_receipt_number");?>' required>";
			modalBody 	+= "	</div>";
			modalBody 	+= "</form>";
			modalFooter = "<button type=\"button\" class=\"btn btn-primary\" onclick=\"frmPoDelivered.submit();\"><?=v("save");?></button>";
			modalFooter += "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\"><?=v("cancel");?></button>";
			$('#modalTitle').html(modalTitle);
			$('#modalBody').html(modalBody);
			$('#modalFooter').html(modalFooter);
			$('#myModal').modal('show');
		}
	}
</script>
<div style="height:20px;"></div>
<div class="container">
	<div class="row sub-title-area" style="border-bottom: 1px solid #ccc;">
		<div class="sub-title-text">
            <span class="glyphicon glyphicon-list-alt" style="color:#800000;"></span> &nbsp;Purchase Order
		</div>
	</div>
    <div class="row">
        <div style="height:20px;"></div>
        <div class="panel panel-default">
            <div class="panel-body">
				<table class="table table-bordered" width="100%">
					<?php 
						foreach($transactions as $transaction){
							$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
							$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
							$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
							$units  = $db->fetch_all_data("units",[],"id = '".$transaction_details["unit_id"]."'")[0];
							$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];
							
							$total = $transaction_details["total"] + $transaction_forwarder["total"];
							$total_tagihan += $total;
					?>
					<tr>
						<td colspan="4">
							<div class="col-md-2">
								<img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
							</div>
							<div class="col-md-10">
								<b><?=$goods["name"]?></b><br>
								<?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp <?=format_amount($transaction_details["price"])?><br>
								<?=v("weight_per_unit");?> : <?=($goods["weight"]/1000);?> Kg
							</div>
						</td>
						<td colspan="2" align="right">
							Sub Total<br>
							Rp. <?=format_amount($transaction_details["total"])?>
						</td>   
					</tr>
					<tr>
						<td colspan="5">
							<u><?=v("delivery_destination");?> :</u><br><br>
							<b><?=$transaction_forwarder["user_address_pic"];?></b> <br>
							<?=$transaction_forwarder["user_address"];?> <br>
							<?php
								$locations = get_location($transaction_forwarder["user_address_location_id"]);
								echo $locations[3]["name"].", ".$locations[2]["name"]."<br>";
								echo $locations[1]["name"].", ".$locations[0]["name"],", ".$locations[3]["zipcode"]."<br>";
							?>
							<?=$transaction_forwarder["user_address_phone"];?>                                    
						</td>
					</tr>
					<tr>
						<td colspan="3" width="70%"> 
							<u><?=v("courier_service");?> :</u><br> <?=$transaction_forwarder["name"];?> -- <?=explode(" (",$transaction_forwarder["courier_service"])[0];?>
							<?php
								if($status == "5" && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
									echo "<br><b>".v("delivered_at").": ".format_tanggal($transaction_forwarder["receipt_at"]);
									echo "<br>".v("shipping_receipt_number").": ".$transaction_forwarder["receipt_no"]."</b>";
								}
							?>
						</td>
						<td nowrap width="15%" align="right">
							<?=v("weight");?><br> <?=($transaction_forwarder["weight"]*$transaction_forwarder["qty"]/1000);?> Kg
						</td> 
						<td nowrap width="15%" align="right">
							<?=v("shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
						</td>
					</tr>
					<tr>
						<td colspan="6" align="right"><b> Total : Rp <?=format_amount($total)?></b></td>
					</tr>
					<tr><td colspan="6"></td></tr>
					<?php } ?>
				</table>
				<table width="100%">
					<tr>
						<td align="right"><b><?=v("total_bill");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></td>
					</tr>
				</table>
            </div>
        </div>
		<?php 
			if($status == "3")	echo $f->input("process_po",v("process_this_po"),"style=\"width:100%;\" onclick=\"changeStatus(4);\"","btn btn-success");
			if($status == "4")	echo $f->input("po_delivered",v("po_was_delivered"),"style=\"width:100%;\" onclick=\"changeStatus(5);\"","btn btn-success");
			if($status == "5")	echo "<div style='width:100%;font-size:20px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-send '></span> ".v("po_was_delivered")."</div>";
		?>
    </div>
</div>
<div style="height:40px;"></div>


<?php include_once "footer.php"; ?>