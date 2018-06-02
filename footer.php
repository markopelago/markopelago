	<footer>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 footer-about">
						<h4><?=v("about");?></h4>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						</p>
					</div>
					<div class="col-sm-4 footer-contact">
						<h4><?=v("contact");?></h4>
						<p><i class="fa fa-map-marker"></i> Komplek Rasuna Epicentrum, Jl. H R rasuna Said Jakarta, 12940, Indonesia</p>
						<p><i class="fa fa-phone"></i> Phone: +62 21 29941058</p>
						<p><i class="fa fa-envelope"></i> Email: <a href="mailto:info@warihFramework.com">info@warihFramework.com</a></p>
						<p><i class="fa fa-skype"></i> Skype: warihFramework</p>
					</div>
					<div class="col-sm-4 footer-links">
						<div class="row">
							<div class="col-sm-12">
								<h4><?=v("links");?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<p><a class="scroll-link" href="#top-content"><?=v("terms_and_conditions");?></a></p>
								<p><a class="scroll-link" href="#features"><?=v("privacy_policy");?></a></p>
								<p><a class="scroll-link" href="#video"><?=v("contact_us");?></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script>
		<?php if($__isloggedin){ ?>
		function checkMessageCount(){
			$.ajax({url: "ajax/messages.php?mode=checkMessageCount", success: function(result){
				loadNotifMessageCount(result);
			}});
			setTimeout(function(){ checkMessageCount(); }, 1000); 
		}
		<?php } ?>
		
		function session_checker(){
			$.ajax({url: "ajax/session_checker.php", success: function(result){
				if(result != "<?=$__isloggedin;?>"){
					window.location="index.php";
				}
			}});
			setTimeout(function(){ session_checker(); }, 60000);
		}
		$( document ).ready(function() { 
			setTimeout(function(){ session_checker(); }, 60000); 
			setTimeout(function(){ checkMessageCount(); }, 1000); 
		});
		
		<?php if(isset($_GET["tabActive"])){ ?>
				$('.nav-tabs a[href="#<?=$_GET["tabActive"];?>"]').tab('show');
			<?php if(isset($_GET["subtabActive"])){ ?>
				$('.nav-tabs a[href="#<?=$_GET["subtabActive"];?>"]').tab('show');
			<?php } ?>
		<?php } ?>
		
		<?php if(isset($_POST["tabActive"])){ ?>
				$('.nav-tabs a[href="#<?=$_POST["tabActive"];?>"]').tab('show');
		<?php } ?>

		<?php if(isset($_SESSION["message"]) && $_SESSION["message"] != ""){ ?> 
			toastr.success("<?=$_SESSION["message"];?>","",toastroptions);
			<?php $_SESSION["message"] = ""; ?>
		<?php } ?>
		
		<?php if(isset($_SESSION["errormessage"]) && $_SESSION["errormessage"] != ""){ ?> 
			toastr.warning("<?=$_SESSION["errormessage"];?>","",toastroptions);
			<?php $_SESSION["errormessage"] = ""; ?>
		<?php } ?>
	</script>
</body>
</html>