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
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	
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
	</script>
</head>
<body style="margin:0px;">
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
	
	<nav class="navbar navbar-default navbar-fixed-top fadeInLeft animated">
		<div class="container">
			<div class="navbar-header">
				<!-- Collapsed Hamburger -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="notification-counter" style="visibility:hidden;" id="notifNavCount"></span>
				</button>
				<!-- Branding Image -->
				<a class="navbar-brand" href="index.php">
					<img src="images/logo.png" style="position:relative;top:-10px;height:40px;max-width: 200%;cursor:pointer;border:0px;" alt="<?=$__title_project;?>" title="<?=$__title_project;?>" onclick="window.location='index.php';">
				</a>
			</div>
			

			<div class="collapse navbar-collapse" id="app-navbar-collapse">
				<!-- Right Side Of Navbar -->
				<ul class="nav navbar-nav navbar-right">
					<!--li><a href="news.php"><?=v("news");?></a></li-->
					<li class="dropdown">
						<a href="models.php" class="dropdown-toggle"><?=v("models");?> <span class="caret"></span></a>
						<ul class="dropdown-menu wow fadeInLeft animated" role="menu">
							<?php 
								$model_categories = $db->fetch_all_data("model_categories");
								foreach($model_categories as $model_category){
									echo "<li><a href='models.php?filter_model_category=".$model_category["id"]."&filter_search=Search'>".$model_category["name_".$__locale]."</a></li>";
								}
							?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="castings.php" class="dropdown-toggle"><?=v("castings");?> <span class="caret"></span></a>
						<ul class="dropdown-menu wow fadeInLeft animated" role="menu">
							<li><a href="castings.php"><?=v("see_all_castings");?></a></li>
							<?php 
								if($__role == 3 || $__role == 4){
									$urlPostCasting = "dashboard.php?tabActive=jobs&post_a_job=1";
								} else {
									$urlPostCasting = "#";
									$jsPostCasting = "onclick=\"toastr.warning('".v("you_have_to_registered_as_a_agency_or_corporate")."','',toastroptions);\"";
								}
							?>
							<li><a href="<?=$urlPostCasting;?>" <?=$jsPostCasting;?>><?=v("post_casting");?></a></li>
						</ul>
					</li>
					<li><a href="agencies.php"><?=v("agencies");?></a></li>
					<li style="width:100px;"><a></a></li>
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
									<div class="col-sm-5 fadeInLeft animated">
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
							<a href="#" class="dropdown-toggle">
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