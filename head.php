<?php include_once "common.php"; ?>
<?php $cartcount = count($db->fetch_all_data("transactions",[],"buyer_user_id='".$__user_id."' AND status=0")); ?>
<!DOCTYPE html>
<html lang="<?=$_COOKIE["locale"];?>">
<head>
	<title><?=$__title_project;?></title>
	<meta charset="utf-8">
	<meta name="description" content="<?=$__project_description;?>">
	<meta name="author" content="<?=$__title_project;?>">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	
	<link rel="canonical" href="<?=$__canonical;?>">
	<link rel="shortcut icon" type="image/x-icon" href="images/icon.png">
	<link rel="stylesheet" href="styles/style.css">
	<link rel="stylesheet" href="styles/bootstrap.min.css">
	<link rel="stylesheet" href="styles/bootstrap-slider.css">
	<link rel="stylesheet" href="styles/animate.css">
	<link rel="stylesheet" href="styles/toastr.min.css">
	<link rel="stylesheet" href="styles/font-awesome.min.css">
	<link rel="stylesheet" href="styles/multiselect.css">
	
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script>
	<script src="scripts/toastr.min.js"></script>
	<script src="scripts/bootstrap-slider.js"></script>
	<script src="scripts/newWaterfall.js"></script>
	<script src="scripts/customs.js"></script>
	<script src="scripts/multiselect.js"></script>
	
	<script>
		var toastroptions = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-bottom-right",
			"preventDuplicates": false,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
			}
		function ajaxLoad(filename, content) {
			content = typeof content !== 'undefined' ? content : 'content';
			$('.loading').show();
			$.ajax({
				type: "GET",
				url: filename,
				contentType: false,
				success: function (data) {
					$("#" + content).html(data);
					$('.loading').hide();
				},
				error: function (xhr, status, error) {
					$("#" + content).html(xhr.responseText);
					$('.loading').hide();
				}
			});
		}
		function openNav() {
			<?php if(!$__isloggedin){ ?>
				document.getElementById("sidenavContent").innerHTML = "<div class='navbar-collapse'>"+document.getElementById("myMenu").innerHTML+"</div>";
			<?php } ?>
			document.getElementById("mySidenav").style.width = "90%";
		}
		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
		}
	</script>
</head>
<?php
	$userImage = $db->fetch_single_data("buyers","avatar",["user_id"=>$__user_id]);
	if($userImage == "") $userImage = $db->fetch_single_data("sellers","logo",["user_id"=>$__user_id]);
	if($userImage == "") $userImage = "nophoto.png";
				
	$mainMenu_lg .= "<li><a href=\"dashboard.php\">".v("my_dashboard")."<span class='notification-counter' style='visibility:hidden;' id='notifMyDashboardCount'></span></a></li>";
	$mainMenu_lg .= "<li><a href=\"dashboard.php?tabActive=message\">".v("message")."</a><span class='notification-counter' style='visibility:hidden;' id='notifMessageTabCount1'></span></li>";
	if($__isBackofficer)$mainMenu_lg .= "<li><a href=\"mysurvey.php\">".v("survey")."</a></li>";
	$mainMenu_lg .= "<li><a href=\"change_password.php\">".v("change_password")."</a></li>";
	$mainMenu_lg .= "<li class=\"sr-only\"><a href=\"index.php?locale=".$__anti_locale."\"><img class=\"localeFlag\" height=\"20\" src=\"icons/".$__anti_locale.".png\"></a></li>";
	$mainMenu_lg .= "<li><a href=\"?logout_action=1\">Logout</a></li>";
				
	$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=profile\">Profile</a></li>";
	$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard_avatar.php\">".v("change_avatar")."</a></li>";
	if($__seller_id > 0){
		$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=seller\">".v("profile_my_store")."</a></li>";
		$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard_seller_header.php\">".v("change_header")."</a></li>";
	}
	$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=addresses\">".v("addresses")."</a></li>";
	$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=banks\">".v("banks")."</a></li>";
	if($__seller_id > 0) $mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=goods\">".v("my_goods")."</a></li>";
	$mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=purchase_list\">".v("purchase_list")."<span class='notification-counter' style='visibility:hidden;' id='notifPurchaseListTabCount1'></span></a></li>";
	if($__seller_id > 0|| $__forwarder_id > 0)  $mainMenu_xs .= "<li ".$__showXSonly."><a href=\"dashboard.php?tabActive=store_sales_list\">".v("store_sales_list")."<span class='notification-counter' style='visibility:hidden;' id='notifStoreSalesListTabCount1'></span></a></li>";
	$mainMenu_xs .= "<li><a href=\"dashboard.php?tabActive=message\">".v("message")."<span class='notification-counter' style='visibility:hidden;' id='notifMessageTabCount1'></span></a></li>";
	if($__isBackofficer)$mainMenu_xs .= "<li><a href=\"mysurvey.php\">".v("survey")."</a></li>";
	$mainMenu_xs .= "<li><a href=\"change_password.php\">".v("change_password")."</a></li>";
	$mainMenu_xs .= "<li class=\"sr-only\"><a href=\"index.php?locale=".$__anti_locale."\"><img class=\"localeFlag\" height=\"20\" src=\"icons/".$__anti_locale.".png\"></a></li>";
	$mainMenu_xs .= "<li><a href=\"?logout_action=1\">Logout</a></li>";
?>
<body style="margin:0px;">
	<div id="mySidenav" class="navbar-default sidenav">
		<div class="menuTitle">
			MENU
			<div class="closebtn"><a href="javascript:void(0)" onclick="closeNav()">&times;</a></div>
		</div>
		<div class="container visible-xs-12" id="sidenavContent">
			<b><?=v("hello");?>, <?=$__fullname;?></b><br><img width="50" class="profile-img-card" src="users_images/<?=$userImage;?>">
			<div style="height:10px;"></div>
			<div class="navbar-collapse">
			<div class="header-cart" id="cartcount2"><a href="mycart.php"><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> <?=$cartcount;?></a></div><br>
			<div style="height:10px;"></div>
				<ul class="nav navbar-nav navbar-right">
					<?=$mainMenu_xs;?>
				</ul>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="modalTitle"></h4>
				</div>
				<div class="modal-body" id="modalBody"></div>
				<div class="modal-footer" id="modalFooter"></div>
			</div>
		</div>
	</div>
	
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<!-- Branding Image -->
				<a class="navbar-brand" href="index.php">
					<img src="images/logo.png" style="position:relative;top:-10px;height:40px;max-width: 200%;cursor:pointer;border:0px;" alt="<?=$__title_project;?>" title="<?=$__title_project;?>" onclick="window.location='index.php';">
				</a>
				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle" onclick="openNav()">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="notification-counter" style="visibility:hidden;" id="notifNavCount"></span>
				</button>
				<div class="search-container" id="headerSearch">
					<form action="products.php" class="navbar-form navbar-left">
						<div class="input-group">
							<?=$f->input("s",$_GET["s"]," placeholder='".v("search")."..'");?>
							<?php
								$categories[""] = "-- ".v("allcategories")." --";
								$_categories = $db->fetch_all_data("categories",[],"parent_id > 0","id");
								foreach($_categories as $_category){
									$categories[$_category["id"]] = $_category["name_".$__locale];
								}
							?>
							<?=$f->select("c",$categories,$_GET["c"]);?>
							<button class="btn btn-default" type="submit"><i style="color:white;" class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
			</div>

			<div id="myMenu" class="collapse navbar-collapse">
				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<?php if(!$__isloggedin){ ?>
						<li class="dropdown">
							<a href="register.php"><?=v("signup");?></a>
						</li>
						
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=v("signin");?> 
								<span class="caret"></span>
							</a>
							<ul id="ul_signin" class="dropdown-menu" role="menu">
								<li>
									<div class="col-sm-5">
										<div style="width:200px;" class="text-center">
											<?php $f->setAttribute("class='this_form_login'");?>
											<?=$f->start();?>
												<img width="100" class="profile-img-card hidden-xs" src="images/nophoto.png" />
												<p id="profile-name" class="profile-name-card"></p>
												<form class="form-signin">
													<input name="username" class="form-control" placeholder="Username" autocomplete="off" required autofocus>
													<div style="height:5px;"></div>
													<input name="password" type="password" class="form-control" placeholder="Password" required>
													<div style="height:5px;"></div>
													<?=$t->row([$f->input("login_action","Login","type='submit'","btn btn-link-1")]);?>
												</form>
											<?=$f->end();?>
										</div>
									</div>
								</li>
							</ul>
						</li>
					<?php } else { ?>
						<li class="dropdown">
							<div>
								<div class="header-cart" id="cartcount1">
									<a href="mycart.php"><span class="glyphicon glyphicon-shopping-cart" style="color:#800000;"></span> <?=$cartcount;?></a>
								</div>
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img height="30" class="profile-img-card" src="users_images/<?=$userImage;?>">&nbsp;<?=v("hello");?>, <?=$__fullname;?>
									<span class="notification-counter" style="visibility:hidden;" id="notifCount"></span>
									<span class="caret"></span>
								</a>
							</div>
							<ul class="dropdown-menu" role="menu" id="forSideMenu">
								<?=$mainMenu_lg;?>
							</ul>
						</li>
					<?php } ?>
						<li><a href="index.php?locale=<?=$__anti_locale;?>"><img class="localeFlag" height="20" src="icons/<?=$__anti_locale;?>.png"></a></li>
				</ul>
			</div>
		</div>
	</nav>