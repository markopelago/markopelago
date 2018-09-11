<?php 
	if($_GET["export"]){
		$_exportname = "Outbound.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=".$_exportname);
		header("Pragma: no-cache");
		header("Expires: 0");
		$_GET["do_filter"]="Load";
		$_isexport = true;
	}
	include_once "head.php";
?>
<?php 
	if($_GET["seller_paid"] == "1"){
		$db->addtable("transactions");  
		$db->where("po_no",$_GET["po_no"]);
		$db->addfield("seller_paid");	$db->addvalue(1);
		$db->addfield("seller_paid_at");$db->addvalue($__now);
		$db->addfield("seller_paid_by");$db->addvalue($__username);
		$updating = $db->update();
		if($updating["affected_rows"] > 0){
			$_SESSION["message"] = "Status berhasil diubah";
			?><script> window.location='po_list.php'; </script><?php
			exit();
		} else {
			$_SESSION["errormessage"] = "Status gagal diubah";
		}
	}
?>

<script>
	function seller_paid(po_no){
		if(confirm("Anda yakin sudah membayar ke seller yang bersangkutan?")){
			window.location="?po_no="+po_no+"&seller_paid=1";
		}
	}
</script>
<?php if(!$_isexport){ ?>
	<div class="bo_title">OUTBOUND</div>
	<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
	<div id="bo_filter">
		<div id="bo_filter_container">
			<?=$f->start("filter","GET");?>
				<?=$t->start();?>
				<?php
					$txt_seller = $f->input("txt_seller",@$_GET["txt_seller"]);
					$txt_buyer = $f->input("txt_buyer",@$_GET["txt_buyer"]);
					$sel_status = $f->select("sel_status",["" => "","1" => "Transaction not yet done","2" => "Unpaid", "3" => "Paid"],@$_GET["sel_status"],"style='height:20px;'");
					$txt_transaction_at = $f->input("txt_transaction_at1",$_GET["txt_transaction_at1"],"type='date' style='width:150px;'")." to ";
					$txt_transaction_at .= $f->input("txt_transaction_at2",$_GET["txt_transaction_at2"],"type='date' style='width:150px;'");
				?>
				<?=$t->row(array("Seller",$txt_seller));?>
				<?=$t->row(array("Buyer",$txt_buyer));?>
				<?=$t->row(array("Status",$sel_status));?>
				<?=$t->row(array("Transaction At",$txt_transaction_at));?>
				<?=$t->end();?>
				<?=$f->input("page","1","type='hidden'");?>
				<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
				<?=$f->input("do_filter","Load","type='submit' style='width:180px;'");?>
				<?=$f->input("export","Export to Excel","type='submit' style='width:180px;'");?>
				<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\" style='width:180px;'");?>
			<?=$f->end();?>
		</div>
	</div>
<?php } else { ?>
	<h2><b>OUTBOUND</b></h2>
<?php } ?>
<?php
	$whereclause = "";
	if(@$_GET["txt_seller"]!="") $whereclause .= "seller_user_id IN (SELECT id FROM a_users WHERE email LIKE '%".$_GET["txt_seller"]."%' UNION SELECT user_id FROM sellers WHERE name LIKE '%".$_GET["txt_seller"]."%') AND ";
	if(@$_GET["txt_buyer"]!="") $whereclause .= "buyer_user_id IN (SELECT id FROM a_users WHERE email LIKE '%".$_GET["txt_buyer"]."%' OR name LIKE '%".$_GET["txt_buyer"]."%') AND ";
	if(@$_GET["sel_status"]!=""){
		if($_GET["sel_status"]=="1") $whereclause .= "status < 7 AND ";
		if($_GET["sel_status"]=="2") $whereclause .= "status >= 7 AND seller_paid = 0 AND ";
		if($_GET["sel_status"]=="3") $whereclause .= "status >= 7 AND seller_paid <> 0 AND ";
		
	}
	if(@$_GET["txt_transaction_at1"]!="") $whereclause .= "date(transaction_at) >= '".$_GET["txt_transaction_at1"]."' AND ";
	if(@$_GET["txt_transaction_at2"]!="") $whereclause .= "date(transaction_at) <= '".$_GET["txt_transaction_at2"]."' AND ";
	$whereclause .= "status >= 3 GROUP BY po_no";
	if(@$_GET["sort"] != "") $order = $_GET["sort"]; else $order = "";
	$carts = $db->fetch_all_data("transactions",[],$whereclause,$order,"100000");
?>
	<?php if($_isexport){ $_tableattr = "border='1'"; }?>
	<?=$t->start($_tableattr,"data_content");?>
	<?=$t->header(["No",
					"PO No",
					"Seller",
					"Buyer",
					"Total",
					"commission",
					"Payment to Seller",
					"Seller Bank",
					"<div onclick=\"sorting('status');\">Status</div>",
					"<div onclick=\"sorting('transaction_at');\">Transaction At</div>",
					""]);?>
	<?php 
		foreach($carts as $no => $cart){
			$totgross = 0;
			$total = 0;
			$transaction = $db->fetch_all_data("transactions",[],"po_no = '".$cart["po_no"]."'")[0];
			$transaction_details = $db->fetch_all_data("transaction_details",[],"transaction_id IN (SELECT id FROM transactions WHERE po_no = '".$cart["po_no"]."')");
			foreach($transaction_details as $transaction_detail){
				$totgross += ($transaction_detail["gross"] * $transaction_detail["qty"]);
				$total += $transaction_detail["total"];
			}
			$commission = $total - $totgross;
			$transaction_payments = $db->fetch_all_data("transaction_payments",[],"cart_group = '".$cart["cart_group"]."'")[0];
			$seller = $db->fetch_single_data("sellers","name",["user_id" => $transaction["seller_user_id"]]);
			$seller_bank = $db->fetch_single_data("user_banks","concat('a/n: ',name,'<br>',(SELECT name FROM banks WHERE id=bank_id),' : ',account_no)",["user_id" => $transaction["seller_user_id"],"default_seller" => 1]);
			$buyer = $db->fetch_single_data("a_users","name",["id" => $transaction["buyer_user_id"]]);
		
			if($transaction["status"] < 7){
				$status = "<b style='color:red;'>Transaction Not Yet Done</b>";
			}else if($transaction["seller_paid"] == "0"){
				$status = "Unpaid<br>".$f->input("paid","Paid Now","type='button' onclick=\"seller_paid('".$cart["po_no"]."');\"");
			} else {
				$status = "<b style='color:blue;'>Seller Paid At ".$transaction["seller_paid_at"]."</b>";
			}
			$actions = 	"<a href=\"po_view.php?po_no=".$cart["po_no"]."\">View</a>";
			echo $t->row(
				[$no+$start+1,
				$cart["po_no"],
				$seller,
				$buyer,
				format_amount($total),
				format_amount($commission),
				"<b>".format_amount($totgross)."</b>",
				$seller_bank,
				$status,
				$transaction["transaction_at"],
				$actions],
				["align='right' valign='top'","","","","align='right' valign='top'","align='right' valign='top'","align='right' valign='top'",""]
			);
		} 
	?>
	<?=$t->end();?>
	
<?php include_once "footer.php";?>