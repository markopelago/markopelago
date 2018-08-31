<?php
	include_once "header.php";
	if($__seller_id != $db->fetch_single_data("goods","seller_id",["id" => $_GET["goods_id"]])){
		$_SESSION["errormessage"] = v("you_dont_have_access");
		javascript("window.location='dashboard.php?tabActive=goods'");
		exit();
	}
	if(isset($_GET["goods_price_id"])){
		$db->addtable("goods_prices");
		$db->where("id",$_GET["goods_price_id"]);
		$db->where("goods_id",$_GET["goods_id"]);
		$db->delete_();
		javascript("window.history.pushState('','','?goods_id=".$_GET["goods_id"]."');");
	}
	if(isset($_POST["save_goods_prices"])){
		$db->addtable("goods_prices");
		if($_GET["edit"] > 0){
			$db->where("id",$_GET["edit"]);
			$db->where("goods_id",$_GET["goods_id"]);
		}
		$db->addfield("goods_id");			$db->addvalue($_GET["goods_id"]);
		$db->addfield("qty");				$db->addvalue($_POST["qty"]);
		$db->addfield("price");				$db->addvalue($_POST["price"]);
		$db->addfield("commission");		$db->addvalue($_POST["commission"]);
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
	$goods_prices = $db->fetch_all_data("goods_prices",[],"goods_id = '".$_GET["goods_id"]."' ORDER BY id");
?>
<script>
	function delete_goods_price(goods_price_id){
		if(confirm("<?=v("confirm_delete");?>")){
			window.location = "?goods_id=<?=$_GET["goods_id"];?>&goods_price_id="+goods_price_id;
		}
	}
	function price_calculation(){
		$("#div_display_price").html( ($("#price").val() * 1) + ($("#price").val() * $("#commission").val() / 100));
	}
</script>
<div class="container">
	<div class="row">	
		<h3 class="well"><?=strtoupper(v("goods_prices"));?></h3>
		<h4><b><?=$db->fetch_single_data("goods","name",["id" => $_GET["goods_id"]]);?></b></h4>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<button class="btn btn-warning" onclick="window.location='goods_view.php?id=<?=$_GET["goods_id"];?>';"><span class="glyphicon glyphicon-arrow-left"></span> <?=v("back");?></button>
				<button class="btn btn-primary" onclick="window.location='?add=1&goods_id=<?=$_GET["goods_id"];?>';"><span class="glyphicon glyphicon-plus"></span> <?=v("add_goods_prices");?></button>
			</div>
		</div>
	</div>
</div>
<?php
	if($_GET["add"] > 0 || $_GET["edit"] > 0 || count($goods_prices) <= 0){	
		$goods_price = $db->fetch_all_data("goods_prices",[],"id='".$_GET["edit"]."' AND goods_id='".$_GET["goods_id"]."'")[0];
		$txt_qty = $f->input("qty",$goods_price["qty"],"required type='number' step='any'","form-control");
		$txt_price = $f->input("price",$goods_price["price"],"onkeyup='price_calculation();' required type='number' step='any'","form-control");
		$txt_commission = $f->input("commission",$goods_price["commission"],"onkeyup='price_calculation();' required type='number' step='any'","form-control");
		
		$btn_save = $f->input("save_goods_prices",v("save"),"type='submit'","btn btn-primary");
		if(count($goods_prices) > 0) $btn_save .= "&nbsp;".$f->input("cancel",v("cancel"),"type='button' onclick=\"window.location='?goods_id=".$_GET["goods_id"]."'\"","btn btn-warning");
		if($_GET["add"] > 0 || count($goods_prices) <= 0) $panelHeading = v("add_goods_prices");
		if($_GET["edit"] > 0) $panelHeading = v("edit_goods_prices");
		$display_price = $goods_price["price"] + ($goods_price["price"] * $goods_price["commission"] / 100);
?>
		<div class="container">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"><?=$panelHeading;?></div>
					<div class="panel-body">
						<div class="col-md-12">
							<form method="POST" action="?add=<?=$_GET["add"];?>&edit=<?=$_GET["edit"];?>&goods_id=<?=$_GET["goods_id"];?>">
								<div class="form-group"><label><?=v("min_qty");?></label><?=$txt_qty;?></div>
								<div class="form-group"><label><?=v("price");?> (Rp.)</label><?=$txt_price;?></div>
								<div class="form-group"><label><?=v("commission");?> (%)</label><?=$txt_commission;?></div>
								<div class="form-group"><label><?=v("display_price");?></label><div id="div_display_price"><?=format_amount($display_price);?></div></div>
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
			<tbody>
			<thead> <?=$t->header([v("min_qty"),v("price"),v("commission"),v("display_price"),""]);?> </thead>
				<?php
					if(count($goods_prices) <= 0){
						echo $t->row(["<b>".v("data_not_found")."</b>"],["colspan='5' align='center'"],"","danger");
					} else {
						foreach($goods_prices as $goods_price){
							$display_price = $goods_price["price"] + ($goods_price["price"] * $goods_price["commission"] / 100);
							$btn_edit = $f->input("edit",v("edit"),"onclick=\"window.location='?edit=".$goods_price["id"]."&goods_id=".$_GET["goods_id"]."';\" type='button'","btn btn-primary");
							$btn_edit .= "&nbsp;".$f->input("delete",v("delete"),"onclick=\"delete_goods_price('".$goods_price["id"]."');\" type='button'","btn btn-warning");
							echo $t->row([$goods_price["qty"],format_amount($goods_price["price"]),$goods_price["commission"],format_amount($display_price),$btn_edit]);
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php include_once "footer.php"; ?>