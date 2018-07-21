<?php include_once "head.php";?>
<?php
	if($_GET["deleting"]){
		$db->addtable("vehicle_brands");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		?> <script> window.location="?";</script> <?php
	}
?>
<div class="bo_title">Vehicle Type List</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$name_id = $f->input("name_id",@$_GET["name_id"]);
                $name_en = $f->input("name_en",@$_GET["name_en"]);
			?>
			<?=$t->row(array("Name ID",$name_id));?>
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
	
	$db->addtable("vehicle_brands");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($_max_counting);
	$maxrow = count($db->fetch_data(true));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("vehicle_brands");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$vehicle_brands = $db->fetch_data(true);
?>

	<?=$f->input("add","Add","type='button' onclick=\"window.location='vehbrand_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
						"<div onclick=\"sorting('id');\">ID</div>",
                        "<div onclick=\"sorting('name');\">Name</div>",
						""));?>
	<?php foreach($vehicle_brands as $no => $vehicle_brand){ ?>
		<?php
			$actions = "<a href=\"vehbrand_edit.php?id=".$vehicle_brand["id"]."\">Edit</a> |
						<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$vehicle_brand["id"]."';}\">Delete</a> |

						";
		?>
		<?=$t->row(
					array($no+$start+1,
						$vehicle_brand["id"],
						$vehicle_brand["name"],
						$actions),
					array("align='right' valign='top'","")
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
<?php include_once "footer.php";?>