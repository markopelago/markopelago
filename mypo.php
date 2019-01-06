<?php include_once "header.php"; ?>
<?php
    $po_no = $_GET["po_no"];
	$transactions = $db->fetch_all_data("transactions",[],"po_no = '".$po_no."' AND seller_user_id = '".$__user_id."'");
	if(count($transactions) <= 0){
		javascript("window.location='index.php';");
		exit();
	}
	if(isset($_POST["savingPoDelivered"]) && $_POST["savingPoDelivered"] == 1){
		$is_self_pickup = $db->fetch_single_data("transaction_forwarder","id",["transaction_id" => $_POST["transaction_id"],"name" => "self_pickup"]);
		$transaction = $db->fetch_all_data("transactions",[],"id = '".$_POST["transaction_id"]."' AND seller_user_id = '".$__user_id."'")[0];
		if($is_self_pickup <= 0){
			if($_POST["receipt_no"] != ""){
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
		} else {
			if($_POST["user_address"] != ""){
				$receipt_no = generate_self_pickup_receipt_no();
				$db->addtable("transaction_forwarder");	$db->where("transaction_id",$transaction["id"]);
				$db->addfield("pickup_address_id");		$db->addvalue($_POST["user_address"]);
				$db->addfield("receipt_no");			$db->addvalue($receipt_no);
				$db->addfield("receipt_at");			$db->addvalue($__now);
				$db->addfield("markoantar_status");		$db->addvalue(1);
				$db->addfield("markoantar_status1_at");	$db->addvalue($__now);
				$updating = $db->update();
				
				$buyer_email = $db->fetch_single_data("a_users","email",["id" => $transaction["buyer_user_id"]]);
				$forwarder_name = $db->fetch_single_data("transaction_forwarder","concat(name,'(',courier_service,')')",["transaction_id" => $transaction["id"]]);
				$user_address = $db->fetch_all_data("user_addresses",[],"id = '".$_POST["user_address"]."' AND user_id = '".$transaction["seller_user_id"]."'")[0];
				$locations = get_location($user_address["location_id"]);
				$seller_pic = $user_address["pic"];
				$pickup_address = $user_address["address"]."<br>".$locations[3]["name"].", ".$locations[2]["name"]."<br>".$locations[1]["name"].", ".$locations[0]["name"].", ".$locations[3]["zipcode"];
				
				$arr1 = ["{invoice_no}","{receipt_no}","{seller_pic}","{pickup_address}"];
				$arr2 = [$transaction["invoice_no"],$receipt_no,$seller_pic,$pickup_address];
				$body = read_file("html/email_goods_ready_to_pickup_id.html");
				$body = str_replace($arr1,$arr2,$body);
				sendingmail("Markopelago.com -- Pengambilan Pesanan ".$invoice_no,$buyer_email,$body,"system@markopelago.com|Markopelago System");
				
				$message = "Pesanan Anda dengan nomor Invoice: ".$transaction["invoice_no"]." sudah dapat di Ambil. Silakan cek pada menu Daftar Pembelian";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($transaction["buyer_user_id"]);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
				
				$db->addtable("transactions");	$db->where("id",$transaction["id"]); $db->where("seller_user_id",$__user_id);
				$db->addfield("sent_at");		$db->addvalue($__now);
				$db->addfield("status");		$db->addvalue(5);
				$updating = $db->update();
				$_SESSION["message"] = markoantar_status(1);
			} else {
				$_SESSION["errormessage"] = v("please_select_goods_pickup_address");
			}
		}
		javascript("window.location='?po_no=".$po_no."';");
		exit();
	}
	
	if($_GET["changeStatus"] == 5) {
		$transaction_id = $_GET["transaction_id"];
		$forwarder_id = $_GET["forwarder_id"];
		$db->addtable("transactions");	$db->where("id",$transaction_id); $db->where("seller_user_id",$__user_id);
		$db->addfield("process_at");	$db->addvalue($__now);
		$db->addfield("status");		$db->addvalue("5");
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$forwarder_user_id = $db->fetch_single_data("forwarders","user_id",["id" => $forwarder_id]);
			$forwarder_name = $db->fetch_single_data("forwarders","name",["id" => $forwarder_id]);
			$db->addtable("transaction_forwarder");	$db->where("transaction_id",$transaction_id);
			$db->addfield("forwarder_id");			$db->addvalue($forwarder_id);
			$db->addfield("forwarder_user_id");		$db->addvalue($forwarder_user_id);
			$db->addfield("name");					$db->addvalue($forwarder_name);
			$db->addfield("markoantar_status");		$db->addvalue(1);
			$db->addfield("markoantar_status1_at");	$db->addvalue($__now);
			$updating = $db->update();
			
			$message = "Barang dari ".$db->fetch_single_data("sellers","name",["user_id" => $__user_id])." atas PO: ".$po_no." sudah siap di antar, silakan lihat pada menu ".v("list_of_delivering_goods").". Terima Kasih!";
			$db->addtable("notifications");
			$db->addfield("user_id");		$db->addvalue($forwarder_user_id);
			$db->addfield("message");		$db->addvalue($message);
			$inserting = $db->insert();
			
			$_SESSION["message"] = v("goods_ready_for_pickup_by_markoantar");
		}
		javascript("window.location='?po_no=".$po_no."';");
		exit();
	}
	
	if($_GET["changeStatus"] == 4 || $_GET["changeStatus"] == 6){
		$db->addtable("transactions");	$db->where("po_no",$po_no); $db->where("seller_user_id",$__user_id);
		$db->addfield("process_at");	$db->addvalue($__now);
		$db->addfield("status");		$db->addvalue($_GET["changeStatus"]);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			if($_GET["changeStatus"] == 4) $_SESSION["message"] = v("this_po_has_been_processed");
			if($_GET["changeStatus"] == 6){
				$transaction = $db->fetch_all_data("transactions",[],"id = '".$_GET["transaction_id"]."' AND seller_user_id = '".$__user_id."'")[0];
				
				$db->addtable("transaction_forwarder");	$db->where("transaction_id",$_GET["transaction_id"]);
				$db->addfield("markoantar_status");		$db->addvalue(4);
				$db->addfield("markoantar_status4_at");	$db->addvalue($__now);
				$updating = $db->update();
				
				$message = "Pesanan Anda dengan nomor Invoice: ".$transaction["invoice_no"]." sudah di Ambil, Terima Kasih";
				$db->addtable("notifications");
				$db->addfield("user_id");		$db->addvalue($transaction["buyer_user_id"]);
				$db->addfield("message");		$db->addvalue($message);
				$inserting = $db->insert();
			}
			javascript("window.location='?po_no=".$po_no."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
	$user_addresses = $db->fetch_select_data("user_addresses","id","name",["user_id " => $__user_id]);
	$user_address_default = $db->fetch_single_data("user_addresses","id",["user_id" => $__user_id, "default_seller" => "1"]);
?>
<script>
	function changeStatus(status,transaction_id,receipt_no,mode){
		transaction_id = transaction_id || "";
		receipt_no = receipt_no || "";
		mode = mode || "";
		var txtConfirm = "";
		if(status == 4){
			if(confirm("<?=v("are_you_sure_to_process_this_po");?> ? ")){
				window.location = "?po_no=<?=$po_no;?>&changeStatus="+status;
			}
		} 
		if(status == 5){
			if(mode == "markoantar"){
				$.get("ajax/transaction.php?mode=pick_markoantar_form&transaction_id="+transaction_id, function(returnval){
					document.getElementById("div_pick_markoantar_"+transaction_id).innerHTML = returnval;					
				});
			} else if(mode == "self_pickup"){
				modalTitle 	= "	<?=markoantar_status(1);?> ";
				modalBody	= "<form id=\"frmPoDelivered\" method='POST' action='?po_no=<?=$po_no;?>'>";
				modalBody	+= "	<input type='hidden' name='savingPoDelivered' value='1'>";
				modalBody 	+= "	<div class='form-group'>";
				modalBody 	+= "		<label><?=v("goods_pickup_address");?> :</label>";
				modalBody 	+= "		<?=str_replace('"','\"',$f->select("user_address",$user_addresses,$user_address_default,"","form-control"));?> ";
				modalBody 	+= "		<input name='transaction_id' type='hidden' value='"+transaction_id+"'>";
				modalBody 	+= "	</div>";
				modalBody 	+= "</form>";
				modalFooter = "<button type=\"button\" class=\"btn btn-primary\" onclick=\"frmPoDelivered.submit();\"><?=v("save");?></button>";
				modalFooter += "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\"><?=v("cancel");?></button>";
				$('#modalTitle').html(modalTitle);
				$('#modalBody').html(modalBody);
				$('#modalFooter').html(modalFooter);
				$('#myModal').modal('show');
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
		if(status == 6){
			if(confirm("<?=v("are_you_sure_goods_received");?> ? ")){
				window.location = "?po_no=<?=$po_no;?>&changeStatus="+status+"&transaction_id="+transaction_id;
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
						<?php 
							if($status == "5" && $transaction_forwarder["forwarder_user_id"] <= 0 && $transaction_forwarder["name"] != "self_pickup"){
								echo "<div style='width:220px;padding-top:5px;padding-bottom:5px;margin-bottom:10px;font-size:14px;text-align:center;' class='alert alert-success'><span class='glyphicon glyphicon-send '></span> ".v("goods_was_delivered")."</div>"; 
								echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."','".$transaction_forwarder["receipt_no"]."');\">".v("edit_receipt_no")."</button>"; 
							}
							if($status == "5" && $transaction_forwarder["name"] == "self_pickup"){
								echo "<div class='alert alert-success'>".v("goods_ready_for_pickup")."</div>";
								echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(6,'".$transaction["id"]."');\">".transactionList(6)."</button>"; 
							}
							if($status == "6" && $transaction_forwarder["name"] == "self_pickup"){
								echo "<div class='alert alert-success'>".v("goods_received")."</div>";
							}
							if($status == "4" && $transaction_forwarder["forwarder_user_id"] <= 0) {
								if($transaction_forwarder["name"] == "self_pickup"){
									echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."','','self_pickup');\">".markoantar_status(1)."</button>";
								} else {
									echo "<button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."');\">".v("update_goods_was_delivered")."</button>";
								}
							}
						?>
						<?php if($status == "4" && $transaction_forwarder["forwarder_user_id"] > 0) echo "<div id='div_pick_markoantar_".$transaction["id"]."'><button class='btn btn-success' style=\"\" onclick=\"changeStatus(5,'".$transaction["id"]."','','markoantar');\">".v("goods_ready_for_pickup_by_markoantar")."</button></div>"; ?>
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
						$btn_chat = "";
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
						$courier_service = $transaction_forwarder["name"]." -- ".explode(" (",$transaction_forwarder["courier_service"])[0];
						if($transaction_forwarder["name"] == "self_pickup"){
							$courier_service = v("self_pickup");
						}
					?>
					<u><?=v("courier_service");?> :</u><br> <?=($transaction_forwarder["forwarder_user_id"] > 0)?"Marko Antar ":"";?><?=$courier_service;?>
					<!--<u><?=v("courier_service");?> :</u><br> <?=($transaction_forwarder["forwarder_user_id"] > 0)?"Marko Antar":$courier_service;?>-->
					<?php
						// echo $wait_for_pickup;
						if($status >= "5") echo $btn_chat;
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
					<?=v(($transaction_forwarder["name"] == "self_pickup")?"administration_fee":"shipping_charges");?><br> Rp <?=format_amount($transaction_forwarder["total"])?>
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