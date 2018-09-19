<?php include_once "head.php";?>
<?php
	if($_GET["deleting"]){
		$db->addtable("goods");
		$db->where("id",$_GET["deleting"]);
		$db->delete_();
		?> <script> window.location="?";</script> <?php
	}
?>
<div class="bo_title">Goods</div>
<div id="bo_expand" onclick="toogle_bo_filter();">[+] View Filter</div>
<div id="bo_filter">
	<div id="bo_filter_container">
		<?=$f->start("filter","GET");?>
			<?=$t->start();?>
			<?php
				$categories = $f->select("category_id",$db->fetch_select_data("categories","id","name_en",["parent_id" => "0:>"],["name_en"],"",true),@$_GET["category_id"],"style='height:25px'");
				$seller = $f->select("seller_id",$db->fetch_select_data("sellers","id","name",null,["name"],"",true),@$_GET["seller_id"],"style='height:25px'");
				$name = $f->input("name",@$_GET["name"]);
			?>
			<?=$t->row(array("Category",$categories));?>
			<?=$t->row(array("Seller",$seller));?>
			<?=$t->row(array("Name",$name));?>
			<?=$t->end();?>
			<?=$f->input("page","1","type='hidden'");?>
			<?=$f->input("sort",@$_GET["sort"],"type='hidden'");?>
			<?=$f->input("do_filter","Load","type='submit' style='width:30%'");?>
			<?=$f->input("export","Export","type='button' style='width:30%' onclick=\"window.open('goods_export.php?category_id=".$_GET["category_id"]."&seller_id=".$_GET["seller_id"]."&name=".$_GET["name"]."&sort=".$_GET["sort"]."');\"");?>
			<?=$f->input("reset","Reset","type='button' style='width:30%' onclick=\"window.location='?';\"");?>
		<?=$f->end();?>
	</div>
</div>

<?php
	$whereclause = "";
	if(@$_GET["category_id"]!="") $whereclause .= "category_ids LIKE '%|".$_GET["category_id"]."|%' AND ";
	if(@$_GET["seller_id"]!="") $whereclause .= "seller_id = '".$_GET["seller_id"]."' AND ";
	if(@$_GET["name"]!="") $whereclause .= "(name LIKE '%".str_replace(" ","%",$_GET["name"])."%' OR description LIKE '%".str_replace(" ","%",$_GET["name"])."%') AND ";
	$maxrow = $db->get_maxrow("goods",substr($whereclause,0,-4));
	$start = getStartRow(@$_GET["page"],$_rowperpage);
	$paging = paging($_rowperpage,$maxrow,@$_GET["page"],"paging");
	
	$db->addtable("goods");
	if($whereclause != "") $db->awhere(substr($whereclause,0,-4));$db->limit($start.",".$_rowperpage);
	if(@$_GET["sort"] != "") $db->order($_GET["sort"]);
	$goods = $db->fetch_data(true);
?>
	<?=$f->input("add","Add","type='button' onclick=\"window.location='goods_add.php';\"");?>
	<?=$paging;?>
	<?=$t->start("","data_content");?>
	<?=$t->header(array("No",
		"<div onclick=\"sorting('name');\">Nama</div>",
						"<div onclick=\"sorting('barcode');\">Barcode</div>",
						"<div onclick=\"sorting('seller');\">Seller</div>",
						"<div onclick=\"sorting('category_ids');\">Category</div>",
						"<div onclick=\"sorting('price');\">Harga</div>",
						""));?>
	<?php foreach($goods as $no => $good){ ?>
		<?php
			
			$actions = 	"<a href=\"goods_edit.php?id=".$good["id"]."\">Edit</a> |
						<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$good["id"]."';}\">Delete</a>";
			
			
			$seller = $db->fetch_single_data("sellers","name",array("id"=>$good["seller_id"]));
			$category_ids = explode('|', $good["category_ids"]);
			$categories ="";
			foreach($category_ids as $num => $category_id){
				$category = $db->fetch_single_data("categories","name_id",array("id"=>$category_id));
				if ($category!=null) $categories.=$category. ", ";
			}
		?>
		<?=$t->row(
					array($no+$start+1,$good['name'],
					$good["barcode"],
					$seller,

					 $categories ,
			
					format_amount($good["price"],2),
					$actions),
					["align='right' valign='top'","","","","align='left'"]
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>