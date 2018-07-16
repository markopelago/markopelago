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
				$store = $f->select("store",$db->fetch_select_data("stores","id","name",[],[],"",true),@$_GET["store"],"style='height:25px'");
				$name = $f->input("name",@$_GET["name"]);
			?>
			<?=$t->row(array("Store",$store));?>
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
	if(@$_GET["store"]!="") $whereclause .= "store_id = '".$_GET["store"]."' AND ";
	if(@$_GET["name"]!="") $whereclause .= "name LIKE '"."%".str_replace(" ","%",$_GET["name"])."%"."' AND ";
	echo $whereclause;
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
						"<div onclick=\"sorting('store_id');\">Store</div>",
						"<div onclick=\"sorting('link_marko');\">URL</div>",
						"<div onclick=\"sorting('name');\">Name</div>",
						"<div onclick=\"sorting('price');\">Harga</div>",
						""));?>
	<?php foreach($goods as $no => $good){ ?>
		<?php
			
			$actions = 	"<a href=\"goods_edit.php?id=".$good["id"]."\">Edit</a> |
						<a href='#' onclick=\"if(confirm('Are You sure to delete this data?')){window.location='?deleting=".$good["id"]."';}\">Delete</a>";
			
			
			$store = $db->fetch_single_data("stores","name",["id"=>$good["store_id"]]);
			
		?>
		<?=$t->row(
					array($no+$start+1,"<a href=\"goods_edit.php?id=".$good["id"]."\">".$store."</a>",
					$good["link_marko"],
					$good["name"],
					format_amount($good["price"],2),
					$actions),
					["align='right' valign='top'","","","","align='right'"]
				);?>
	<?php } ?>
	<?=$t->end();?>
	<?=$paging;?>
	
<?php include_once "footer.php";?>