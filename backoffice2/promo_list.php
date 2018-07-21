<?php include_once "head.php";?>
<?php
	if($_GET["deleting"]){
		$db->addtable("promo");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		?> <script> window.location="?";</script> <?php
	}
?>
<div class="bo_title">Master Promo</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$parent_id = $f->input("parent_id",@$_GET["parent_id"]);
                $name_id = $f->input("name_id",@$_GET["name_id"]);
			?>
			<?=$t->row(array("Nama_ID",$name_id));?>
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
	if(@$_GET["name_id"]!="") $whereclause .= "(name_id LIKE '%".$_GET["name_id"]."%') AND ";
	
	$db->addtable("promo");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("promo");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$promo = $db->fetch_data(true);
?>

	<?=$f->input("add","Add","type='button' onclick=\"window.location='promo_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
                        "<div onclick=\"sorting('name_id');\">Name_ID</div>",
                        "<div onclick=\"sorting('name_en');\">Name_EN</div>",
                        "<div onclick=\"sorting('price');\">Price</div>",
                        "<div onclick=\"sorting('disc');\">Disc</div>",
						""));?>
	<?php foreach($promo as $no => $promo){ ?>
		<?php
			$actions = "<a href=\"promo_edit.php?id=".$promo["id"]."\">Edit</a> |
						<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$promo["id"]."';}\">Delete</a> |

						";
		?>
		<?=$t->row(
					array($no+$start+1,
						$promo["name_id"],
						$promo["name_en"],
						$promo["price"],
						$promo["disc"],
						$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
<?php include_once "footer.php";?>