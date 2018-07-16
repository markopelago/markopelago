<header class="fixedHeader">
	<table width="100%">
		<tr>
			<td>&nbsp;</td>
			<td align="center" width="1100">
				<table style="background-color: rgba(255, 255, 255, 0.0);height:60px;width:100%;" cellpadding="0" cellspacing="0">
					<tr>
						<td nowrap width="1">
							<img src="../images/logo.png" style="height:52px;cursor:pointer;border:0px;" alt="<?=$__title_project;?>" title="<?=$__title_project;?>" onclick="window.location='index.php';">
						</td>
						<td style="width:30px;" align="left" nowrap>
						<td align="left" valign="top" nowrap>
							<!--MENU-->
							<nav id="primary_nav_wrap">
								<ul>
									<?php
										if($__isloggedin){
											$db->addtable("a_backoffice_menu"); $db->addfield("id,name,url"); $db->where("parent_id",0); $db->order("seqno");
											$arrmenu = $db->fetch_data(true);
											foreach($arrmenu as $menu){
												if($__menu_ids[$menu["id"]]){
													echo "<li class='bo_menu'><a href='".$menu["url"]."'>".$menu["name"]."</a>";
													$db->addtable("a_backoffice_menu"); $db->addfield("id,name,url"); $db->where("parent_id",$menu["id"]); $db->order("seqno");
													$arrsubmenu = $db->fetch_data(true);
													if(count($arrsubmenu) > 0){
														echo "<ul class='ul_submenu'>";
														foreach($arrsubmenu as $submenu){
															if($__menu_ids[$submenu["id"]]){
															echo "<li><a href='".$submenu["url"]."'>".$submenu["name"]."</a></li>";
															}
														}
														echo "</ul>";
													}
													echo "</li>";
													echo "<li>&nbsp;</li>";
												}
											}
											echo "<li class='bo_menu'><a href='index.php?logout_action=1'>LOGOUT</a></li>";
										}
									?>
								</ul>
							</nav>
							<!--END MENU-->
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<?php if($__isloggedin){ ?>
								<b>Welcome, <?=$__fullname;?></b>
							<?php } ?>
						</td>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</header>
<div style="height:80px;"></div>