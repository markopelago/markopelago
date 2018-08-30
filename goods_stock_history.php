<?php
	include_once "header.php";
	if($__seller_id != $db->fetch_single_data("goods","seller_id",["id" => $_GET["goods_id"]])){
		$_SESSION["errormessage"] = v("you_dont_have_access");
		javascript("window.location='dashboard.php?tabActive=goods'");
		exit();
	}
	if(isset($_GET["goods_history_id"])){
		$db->addtable("goods_histories");
		$db->where("id",$_GET["goods_history_id"]);
		$db->where("seller_user_id",$__user_id);
		$db->where("goods_id",$_GET["goods_id"]);
		$db->delete_();
		javascript("window.history.pushState('','','?goods_id=".$_GET["goods_id"]."');");
	}
	if(isset($_POST["save_goods_stock_history"])){
		$db->addtable("goods_histories");
		if($_GET["edit"] > 0){
			$db->where("id",$_GET["edit"]);
			$db->where("goods_id",$_GET["goods_id"]);
			$db->where("seller_user_id",$__user_id);
		}
		$db->addfield("seller_user_id");	$db->addvalue($__user_id);
		$db->addfield("goods_id");			$db->addvalue($_GET["goods_id"]);
		$db->addfield("sku");				$db->addvalue($_POST["sku"]);
		$db->addfield("in_out");			$db->addvalue($_POST["in_out"]);
		$db->addfield("qty");				$db->addvalue($_POST["qty"]);
		$db->addfield("notes");				$db->addvalue($_POST["notes"]);
		$db->addfield("history_at");		$db->addvalue($_POST["history_at"]);
		if($_GET["edit"] > 0) $inserting = $db->update();
		else $inserting = $db->insert();
		if($inserting["affected_rows"] > 0){
			$_SESSION["message"] = v("data_saved_successfully");
			javascript("window.location='?goods_id=".$_GET["goods_id"]."';");
			exit();
		} else {
			$_SESSION["errormessage"] = v("failed_saving_data");
		}
	}
	$goods_histories = $db->fetch_all_data("goods_histories",[],"seller_user_id = '".$__user_id."' AND goods_id = '".$_GET["goods_id"]."' ORDER BY history_at DESC");
	$stock_in = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["goods_id"],"in_out" => "in"]);
	$stock_out = $db->fetch_single_data("goods_histories","concat(sum(qty))",["seller_user_id" => $__user_id,"goods_id" => $_GET["goods_id"],"in_out" => "out"]);
	$stock = $stock_in - $stock_out;
?>
<script>
	function delete_goods_history(goods_history_id){
		if(confirm("<?=v("confirm_delete");?>")){
			window.location = "?goods_id=<?=$_GET["goods_id"];?>&goods_history_id="+goods_history_id;
		}
	}
</script>
<div class="container">
	<div class="row">	
		<h3 class="well"><?=strtoupper(v("stock_history"));?></h3>
		<h4><b><?=$db->fetch_single_data("goods","name",["id" => $_GET["goods_id"]]);?></b></h4>
		<b><?=v("current_stock");?> : <?=$stock;?></b>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<button class="btn btn-warning" onclick="window.location='goods_view.php?id=<?=$_GET["goods_id"];?>';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
				<button class="btn btn-primary" onclick="window.location='?add=1&goods_id=<?=$_GET["goods_id"];?>';"><span class="glyphicon glyphicon-plus"></span> <?=v("add_goods_stock_history");?></button>
			</div>
		</div>
	</div>
</div>
<?php
	if($_GET["add"] > 0 || $_GET["edit"] > 0 || count($goods_histories) <= 0){	
		$goods_history = $db->fetch_all_data("goods_histories",[],"id='".$_GET["edit"]."' AND seller_user_id='".$__user_id."' AND goods_id='".$_GET["goods_id"]."'")[0];
		$goods_history["history_at"] = ($goods_history["history_at"]=="")?$goods_history["history_at"]=date("Y-m-d"):$goods_history["history_at"];
		$txt_history_at = $f->input("history_at",substr($goods_history["history_at"],0,10),"required type='date'","form-control");
		$txt_sku = $f->input("sku",$goods_history["sku"],"","form-control");
		$sel_in_out = $f->select("in_out",["in" => v("in"),"out" => v("out")],$goods_history["in_out"],"","form-control");
		$txt_qty = $f->input("qty",$goods_history["qty"],"required type='number' step='any'","form-control");
		$txt_notes = $f->textarea("notes",$goods_history["notes"],"required placeholder=\"".v("example_first_stock")."...\"","form-control");
		$btn_save = $f->input("save_goods_stock_history",v("save"),"type='submit'","btn btn-primary");
		if(count($goods_histories) > 0) $btn_save .= "&nbsp;".$f->input("cancel",v("cancel"),"type='button' onclick=\"window.location='?goods_id=".$_GET["goods_id"]."'\"","btn btn-warning");
		if($_GET["add"] > 0 || count($goods_histories) <= 0) $panelHeading = v("add_goods_stock_history");
		if($_GET["edit"] > 0) $panelHeading = v("edit_goods_stock_history");
?>
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"><?=$panelHeading;?></div>
					<div class="panel-body">
						<div class="col-md-12">
							<form method="POST" action="?add=<?=$_GET["add"];?>&edit=<?=$_GET["edit"];?>&goods_id=<?=$_GET["goods_id"];?>">
								<div class="form-group"><label><?=v("date");?></label><?=$txt_history_at;?></div>
								<div class="form-group"><label>SKU</label><?=$txt_sku;?></div>
								<div class="form-group"><label><?=v("in_out");?></label><?=$sel_in_out;?></div>
								<div class="form-group"><label><?=v("qty");?></label><?=$txt_qty;?></div>
								<div class="form-group"><label><?=v("notes");?></label><?=$txt_notes;?></div>
								<div class="form-group"><?=$btn_save;?></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>
<div class="container">
	<div class="row scrolling-wrapper">	
		<table class="table table-striped table-hover">
			<thead> <?=$t->header([v("date"),v("po_number"),"SKU",v("in_out"),v("qty"),v("notes")]);?> </thead>
			<tbody>
				<?php
					if(count($goods_histories) <= 0){
						echo $t->row(["<b>".v("data_not_found")."</b>"],["colspan='7' align='center'"],"","danger");
					} else {
						foreach($goods_histories as $goods_history){
							$withhour = (substr($goods_history["history_at"],11,8) == "00:00:00")?false:true;
							$po_number = $db->fetch_single_data("transactions","po_no",["id" => $goods_history["transaction_id"]]);
							$btn_edit = "";
							if($po_number == ""){
								$btn_edit = $f->input("edit",v("edit"),"onclick=\"window.location='?edit=".$goods_history["id"]."&goods_id=".$_GET["goods_id"]."';\" type='button'","btn btn-primary");
								$btn_edit .= "&nbsp;".$f->input("delete",v("delete"),"onclick=\"delete_goods_history('".$goods_history["id"]."');\" type='button'","btn btn-warning");
							}
							echo $t->row([format_tanggal($goods_history["history_at"],"dMY",$withhour),$po_number,$goods_history["sku"],v($goods_history["in_out"]),$goods_history["qty"],$goods_history["notes"],$btn_edit],
										  ["valign='top'","valign='top'","valign='top'","valign='top'","align='right'","valign='top'"]);
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php include_once "footer.php"; ?>