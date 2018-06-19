<?php include_once "common.php"; ?>
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
	
	<script src="scripts/jquery.min.js"></script>
	<script src="scripts/bootstrap.min.js"></script>
	<script src="scripts/toastr.min.js"></script>
	<script src="scripts/bootstrap-slider.js"></script>
	<script src="scripts/newWaterfall.js"></script>
	
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
		function loadNotifCount(elmId,count){
			if(count != 0){
				$("#" + elmId).html(count);
				$("#" + elmId).attr("style","visibility:visible");
			} else {
				$("#" + elmId).html("");
				$("#" + elmId).attr("style","visibility:hidden");
			}
		}
		function loadNotifMessageCount(count){
			try{ loadNotifCount("notifNavCount",count); } catch(e){}
			try{ loadNotifCount("notifCount",count); } catch(e){}
			try{ loadNotifCount("notifMessageCount",count); } catch(e){}
			try{ loadNotifCount("notifMessageTabCount",count); } catch(e){}
		}
		function openNav() {
			document.getElementById("sidenavContent").innerHTML = "<div class='navbar-collapse'>"+document.getElementById("myMenu").innerHTML+"</div>";
			document.getElementById("mySidenav").style.width = "300px";
		}
		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
		}
	</script>
</head>
<body style="margin:0px;">
	<div id="mySidenav" class="navbar-default sidenav">
		<div class="menuTitle">
			MENU
			<div class="closebtn"><a href="javascript:void(0)" onclick="closeNav()">&times;</a></div>
		</div>
		<div class="container" id="sidenavContent"></div>
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
				<div class="search-container">
					<form class="navbar-form navbar-left">
						<div class="input-group">
							<?=$f->input("s",$_GET["s"]," placeholder='".v("search")."..'");?>
							<?php
								$categories[""] = "-- ".v("allcategories")." --";
								$categories[1] = "Alat Berat";
								$categories[2] = "Antique";
								$categories[3] = "Budaya";
								$categories[4] = "Bahan Bangunan";
								$categories[5] = "Bengkel";
								$categories[6] = "Burung";
								$categories[7] = "Batik";
								$categories[8] = "Chemical";
								$categories[9] = "Electronic";
								$categories[10] = "Electrical";
								$categories[11] = "Fashion & Kecantikan";
								$categories[12] = "Herbs & Medicine";
								$categories[13] = "Hobi";
								$categories[14] = "IT";
								$categories[15] = "Kopi";
								$categories[16] = "Laboratory & Equipment";
								$categories[17] = "Makanan & Minuman";
								$categories[18] = "Oleh Oleh";
								$categories[19] = "Otomotif";
								$categories[20] = "Packaging";
								$categories[21] = "Tools";
							?>
							<?=$f->select("c",$categories,$_GET["c"]);?>
							<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</div>
			</div>

			<div id="myMenu" class="collapse navbar-collapse">
				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<?php if(!$__isloggedin){ ?>
						<li class="dropdown">
							<a href="register.php?as=null"><?=v("signup");?></a>
						</li>
						
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=v("signin");?> 
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li>
									<div class="col-sm-5">
										<div style="width:200px;" class="text-center">
											<?php $f->setAttribute("class='this_form_login'");?>
											<?=$f->start();?>
												<img width="100" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
												<p id="profile-name" class="profile-name-card"></p>
												<form class="form-signin">
													<input name="username" class="form-control" placeholder="Username" required autofocus>
													<div style="height:5px;"></div>
													<input name="password" type="password" class="form-control" placeholder="Password" autocomplete="new-password" required>
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
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<?=$__fullname;?> 
								<span class="notification-counter" style="visibility:hidden;" id="notifCount"></span>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="dashboard.php"><?=v("my_dashboard");?></a></li>
								<li>
									<a href="dashboard.php?tabActive=message">
										<?=v("message");?>
										<span class="notification-counter" style="visibility:hidden;" id="notifMessageCount"></span>
									</a>
								</li>
								<li><a href="?logout_action=1">Logout</a></li>
							</ul>
						</li>
					<?php } ?>
						<li><a href="index.php?locale=<?=$__anti_locale;?>"><img class="localeFlag" height="20" src="icons/<?=$__anti_locale;?>.png"></a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="header-start"></div>