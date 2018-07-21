<?php $_SERVER["HTTP_REFERER"] = "groups_list.php"; ?>
<?php include_once "head.php";?>
	<?php
	if($_POST["save"]){
		$db->addtable("a_backoffice_menu_privileges");
		$db->where("group_id",$_GET["id"]);
		$db->delete_();
		foreach($_POST["is_check"] as $menu_id => $value){			
			$db->addtable("a_backoffice_menu_privileges");
			$db->addfield("group_id");				$db->addvalue($_GET["id"]);
			$db->addfield("a_backoffice_menu_id");	$db->addvalue($menu_id);	
			$db->addfield("privilege");				$db->addvalue(1);
			$db->addfield("updated_at");			$db->addvalue(date("Y-m-d H:i:s"));
			$db->addfield("updated_by");			$db->addvalue($__username);
			$db->addfield("updated_ip");			$db->addvalue($_SERVER["REMOTE_ADDR"]);
			$inserting = $db->insert();
		}
		echo "<font color='blue'>Data Saved</font>";
	}
	?>
	<fieldset>
	<legend class="bo_title">Privilege for <?=$db->fetch_single_data("groups","name",array("id"=>$_GET["id"]));?></legend>
	<form method="POST" action="?id=<?=$_GET["id"];?>">
	<?php
			$db->addtable("a_backoffice_menu"); $db->addfield("id,name"); $db->where("parent_id",0); $db->order("seqno");
			$arrmenu = $db->fetch_data(true);
			foreach($arrmenu as $menu){
				$checked = "";
				if($db->fetch_single_data("a_backoffice_menu_privileges","privilege",array("group_id"=>$_GET["id"],"a_backoffice_menu_id"=>$menu["id"])) > 0){$checked = "checked";}
				echo $f->input("is_check[".$menu["id"]."]","1","type='checkbox' ".$checked).$menu["name"];
				$db->addtable("a_backoffice_menu"); $db->addfield("id,name"); $db->where("parent_id",$menu["id"]); $db->order("seqno");
				$arrsubmenu = $db->fetch_data(true);
				if(count($arrsubmenu) > 0){
					echo "<ul style='list-style-type:none'>";
					foreach($arrsubmenu as $submenu){
						$checked = "";
						if($db->fetch_single_data("a_backoffice_menu_privileges","privilege",array("group_id"=>$_GET["id"],"a_backoffice_menu_id"=>$submenu["id"])) > 0){$checked = "checked";}
						echo "<a><li>".$f->input("is_check[".$submenu["id"]."]","1","type='checkbox' ".$checked).$submenu["name"]."</a></li>";
					}
					echo "</ul>";
				}
				echo "<li style='list-style-type:none'></li>";
			}
			echo "<br>";
			
		
	?>
	<?=$f->input("save","Update","type='submit'");?> <?=$f->input("back","Back","type='button' onclick=\"window.location='groups_list.php';\"");?>
	</form>	
	</fieldset>
<?php include_once "footer.php";?>