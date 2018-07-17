<?php include_once "head.php";?>
<?php
	if($_GET["deleting"]){
		$db->addtable("promo");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		?> <script> window.location="?";</script> <?php
	}
?>
<div class="bo_title">Promo</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php	
				$name = $f->input("name",@$_GET["name"]);
			?>
			<?=$t->row(array("Name",$name));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit'");?>
			<?=$f->input("reset","Reset","type='button' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if(@$_GET["name"]!="") $whereclause .= "(name_id LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' OR name_en LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."') AND ";
	echo $whereclause;
	$maxrow = $db->get_maxrow("promo",substr($whereclause,0,-4));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("promo");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$promos = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='promo_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('name_id');\">Name (ID)</div>",
						"<div onclick=\"sorting('name_en');\">Name (EN)</div>",
						"<div onclick=\"sorting('price');\">Price</div>",
						"<div onclick=\"sorting('disc');\">Disc (%)</div>",
						"<div onclick=\"sorting('created_at');\">Created at</div>",
						""));?>
	<?php foreach($promos as $no => $promo){ ?>
		<?php
			
			$actions = 	"<a href=\"promo_edit.php?id=".$promo["id"]."\">Edit</a> |
						<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$promo["id"]."';}\">Delete</a>";
		?>
		<?=$t->row(
					array($no+$start+1,
					"<a href=\"promo_edit.php?id=".$promo["id"]."\">".$promo["name_id"]."</a>",
					"<a href=\"promo_edit.php?id=".$promo["id"]."\">".$promo["name_en"]."</a>",
					format_amount($promo["price"],2),
					$promo["disc"],
					$promo["created_at"],
					$actions),
					["align='right' valign='top'","","","","align='right'"]
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>