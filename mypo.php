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
			$transaction = $db->fetch_all_data("transactions",[],"id = '".$_POST["transaction_id"]."' AND seller_user_id = '".$__user_id."'")[0];
			$transaction_forwarder_receipt_no = $db->fetch_single_data("transaction_forwarder","receipt_no",["transaction_id" => $transaction["id"]]);
			$db->addtable("transaction_forwarder");	$db->where("transaction_id",$transaction["id"]);
			$db->addfield("receipt_no");	$db->addvalue($_POST["receipt_no"]);
			if($transaction_forwarder_receipt_no == ""){
				$db->addfield("receipt_at");	$db->addvalue($__now);
			}
			$updating = $db->update();
			
			$buyer_email = $db->fetch_single_data("a_users","email",["id" => $transaction["buyer_user_id"]]);
			$forwarder_name = $db->fetch_single_data("transaction_forwarder","concat(name,'(',courier_service,')')",["transaction_id" => $transaction["id"]]);
			
			$arr1 = ["{invoice_no}","{forwarder_name}","{forwarder_receipt_no}","{forwarder_receipt_at}"];
			$arr2 = [$transaction["invoice_no"],$forwarder_name,$_POST["receipt_no"],format_tanggal(substr($__now,0,10),"dMY")];
			$body = read_file("html/email_shipping_process_id.html");
			$body = str_replace($arr1,$arr2,$body);
			sendingmail("Markopelago.com -- Pengiriman Pesanan ".$invoice_no,$buyer_email,$body,"system@markopelago.com|Markopelago System");
			
			$db->addtable("transactions");	$db->where("id",$transaction["id"]); $db->where("seller_user_id",$__user_id);
			$db->addfield("sent_at");		$db->addvalue($__now);
			$db->addfield("status");		$db->addvalue(5);
			$updating = $db->update();
			$_SESSION["message"] = v("goods_was_delivered");
		} else {
			$_SESSION["errormessage"] = v("please_enter_the_shipping_receipt_number");
		}
		javascript("window.location='?po_no=".$po_no."';");
		exit();
	}
	if($_GET["changeStatus"] == 4 || $_GET["changeStatus"] == 5){
		$db->addtable("transactions");	$db->where("po_no",$po_no); $db->where("seller_user_id",$__user_id);
		$db->addfield("process_at");	$db->addvalue($__now);
		$db->addfield("status");		$db->addvalue($_GET["changeStatus"]);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			if($_GET["changeStatus"] == 4) $_SESSION["message"] = v("this_po_has_been_processed");
			if($_GET["changeStatus"] == 5) {
				$db->addtable("transaction_forwarder");	$db->where("transaction_id",$_GET["transaction_id"]);
				$db->addfield("markoantar_status");		$db->addvalue(1);
				$db->addfield("markoantar_status1_at");	$db->addvalue($__now);
				$updating = $db->update();
				
				$forwarder_user_id = $db->fetch_single_data("transaction_forwarder","forwarder_user_id",["transaction_id" => $_GET["transaction_id"]]);
				$message = "Barang dari ".$db->fetch_single_data("sellers","name",["user_id" => $__user_id])." atas PO: ".$po_no." sudah siap di antar, silakan lihat pada menu ".v("list_of_delivering_goods").". Terima Kasih!";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($forwarder_user_id);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
				
				$_SESSION["message"] = v("goods_ready_for_pickup_by_markoantar");
			}
			javascript("window.location='?po_no=".$po_no."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
?>
<script>
	function changeStatus(status,transaction_id,receipt_no,markoantar){
		transaction_id = transaction_id || "";
		receipt_no = receipt_no || "";
		markoantar = markoantar || "";
		var txtConfirm = "";
		if(status == 4){
			if(confirm("<?=v("are_you_sure_to_process_this_po");?> ? ")){
				window.location = "?po_no=<?=$po_no;?>&changeStatus="+status;
			}
		} 
		if(status == 5){
			if(markoantar == "markoantar"){
				if(confirm("<?=v("are_you_sure_goods_ready_pickup");?> ? ")){
					window.location = "?po_no=<?=$po_no;?>&changeStatus="+status+"&transaction_id="+transaction_id;
				}	
			} else {
				modalTitle 	= "	<?=v("goods_was_delivered");?> ";
				modalBody	= "<form id=\"frmPoDelivered\" method='POST' action='?po_no=<?=$po_no;?>'>";
				modalBody	+= "	<input type='hidden' name='savingPoDelivered' value='1'>";
				modalBody 	+= "	<div class='form-group'>";
				modalBody 	+= "		<label><?=v("please_enter_the_shipping_receipt_number");?> :</label>";
				modalBody 	+= "		<input name='receipt_no' value='"+receipt_no+"' class='form-control' placeholder='<?=v("shipping_receipt_number");?>' required>";
				modalBody 	+= "		<input name='transaction_id' type='hidden' value='"+transaction_id+"'>";
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
	}
</script>

<div class="container">
    <div class="row">
		<div class="common_title"><span class="glyphicon glyphicon-list-alt" style="color:#800000;"></span> &nbsp;Purchase Order</div>
	</div>
</div>
<div class="container">
    <div class="row">
		<table class="table table-bordered" width="100%">
			<?php 
				foreach($transactions as $transaction){
					$transaction_details = $db->fetch_all_data("transaction_details",[],"id = '".$transaction["id"]."'")[0];
					$goods  = $db->fetch_all_data("goods",[],"id = '".$transaction_details["goods_id"]."'")[0];
					$goods_photos  = $db->fetch_all_data("goods_photos",[],"goods_id = '".$goods["id"]."'","seqno")[0];
					if(!file_exists("goods/".$goods_photos["filename"])) $goods_photos["filename"] = "no_goods.png";
					$units  = $db->fetch_all_data("units",[],"id = '".$transaction_details["unit_id"]."'")[0];
					$transaction_forwarder = $db->fetch_all_data("transaction_forwarder",[],"transaction_id = '".$transaction["id"]."'")[0];
					
					$total = $transaction_details["total"] + $transaction_forwarder["total"];
					$total_tagihan += $total;
					$status = $db->fetch_single_data("transactions","status",["id" => $transaction["id"]]);
			?>
			<tr>
				<td colspan="4">
					<div class="col-md-2">
						<img src="goods/<?=$goods_photos["filename"]?>" style="width:120px;"> 
					</div>
					<div class="col-md-10">
						<b><?=$goods["name"]?></b><br>
						<?=$transaction_details["qty"]?> <?=$units["name_".$__locale]?> x Rp <?=format_amount($transaction_details["price"])?><br>
						<?=v("weight_per_unit");?> : <?=($goods["weight"]/1000);?> Kg<br>
						<?php if($status == "5" && $transaction_forwarder["forwarder_user_id"] <= 0) echo "<div style='width:220px;padding-top:5px;padding-bottom:5px;margin-bottom:10px;font-size:14px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-send '></span> ".v("goods_was_delivered")."</div>"; ?>
						<?php if($status == "5" && $transaction_forwarder["forwarder_user_id"] <= 0) echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."','".$transaction_forwarder["receipt_no"]."');\">".v("edit_receipt_no")."</button>"; ?>
						<?php if($status == "4" && $transaction_forwarder["forwarder_user_id"] <= 0) echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."');\">".v("update_goods_was_delivered")."</button>"; ?>
						<?php if($status == "4" && $transaction_forwarder["forwarder_user_id"] > 0) echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."','','markoantar');\">".v("goods_ready_for_pickup_by_markoantar")."</button>"; ?>
						<?php if($status == "5" && $transaction_forwarder["forwarder_user_id"] > 0 && $transaction_forwarder["markoantar_status"] > 0) 
								echo "<div class='alert alert-warning'>".$db->fetch_single_data("markoantar_statuses","name_".$__locale,["id" => $transaction_forwarder["markoantar_status"]])."</div>"; ?>
					</div>
				</td>
				<td colspan="2" align="right" nowrap>
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
						
						$onclickSendMessage = "onclick=\"newMessage('".$transaction["buyer_user_id"]."',".$goods["id"].",'seller','buyer');\"";
						$btn_chat = "<div><button class='btn btn-primary btn-blue' ".$onclickSendMessage."><span class='glyphicon glyphicon-envelope'></span>&nbsp;".v("send_message_to_buyer")."</button></div>";
					?>
					<?=$transaction_forwarder["user_address_phone"];?>
					<?=$btn_chat;?>
				</td>
			</tr>
			<tr>
				<td colspan="3" width="70%"> 
					<?php
						if($transaction_forwarder["forwarder_user_id"] > 0){
							$vehicle_id = $db->fetch_single_data("forwarder_routes","vehicle_id",["user_id" => $transaction_forwarder["forwarder_user_id"],"id" => $transaction_forwarder["courier_service"]]);
							$forwarder_vehicle = $db->fetch_all_data("forwarder_vehicles",[],"user_id = '".$transaction_forwarder["forwarder_user_id"]."' AND id = '".$vehicle_id."'")[0];
							$vehicle_type = $db->fetch_single_data("vehicle_types","name",["id" => $forwarder_vehicle["vehicle_type_id"]]);
							$vehicle_brand = $db->fetch_single_data("vehicle_brands","name",["id" => $forwarder_vehicle["vehicle_brand_id"]]);
							$transaction_forwarder["courier_service"] = $vehicle_type." ".$vehicle_brand;
							$onclickSendMessage = "onclick=\"newMessage('".$transaction_forwarder["forwarder_user_id"]."','0','seller','markoantar');\"";
							$btn_chat = "<div><button class='btn btn-primary btn-blue' ".$onclickSendMessage."><span class='glyphicon glyphicon-envelope'></span>&nbsp;".v("send_message_to_markoantar")."</button></div>";
							if($status == "4") $wait_for_pickup = "<div class='alert alert-warning'>".v("wait_for_pickup")."</div>";
						}
					?>
					<u><?=v("courier_service");?> :</u><br> <?=($transaction_forwarder["forwarder_user_id"] > 0)?"Marko Antar ":"";?><?=$transaction_forwarder["name"];?> -- <?=explode(" (",$transaction_forwarder["courier_service"])[0];?>
					<?php
						// echo $wait_for_pickup;
						echo $btn_chat;
						if($status >= "5" && $transaction_forwarder["receipt_at"] != "0000-00-00 00:00:00") {
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
				<td align="right"><h4><b><?=v("total_bill");?> : &nbsp;&nbsp;Rp. <?=format_amount($total_tagihan)?></b></h4></td>
			</tr>
		</table>
		<br>
		<?php 
			if($status == "3")	echo $f->input("process_po",v("process_this_po"),"style=\"width:100%;\" onclick=\"changeStatus(4);\"","btn btn-success");
		?>
    </div>
</div>
<div style="height:40px;"></div>


<?php include_once "footer.php"; ?>