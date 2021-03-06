	<footer>
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 footer-about">
						<h4><?=v("about");?></h4>
						<p>
							Markopelago.com adalah platform yang dibangun bersama dengan visi pemerataan kesempatan berkembang untuk semua lapisan dunia usaha; khususnya di Indonesia. Bisa dipahami bahwa definisi dunia usaha tidak tak terbatas hanya mengenai perusahaan; namun menyangkut hal lebih luas yaitu mengenai ekosistem bisnis. Markopelago.com dibangun untuk memudahkan semua pelaku dunia usaha berinteraksi secara hangat di platform kami dalam ekosistem bisnis yang hangat, bersahabat, berintegritas dan tentu saling menguntungkan. Kami membuka kesempatan untuk seluruh pelaku usaha untuk menjadi pengguna Markopelago.com baik sebagai penjual maupun pembeli dalam atmosfir yang lain daripada marketplace lainnya. Tidak ada yang mengenal Indonesia lebih baik dari kita.
						</p>
					</div>
					<div class="col-sm-4 footer-contact">
						<h4><?=v("contact");?></h4>
						<p><image src="icons\iconpin.png"></i> PT. Markopelago Indonesia Persada</p>
						
						<p><image src="icons\iconemail.png"></i> <a href="mailto:csmarkopelago@gmail.com">Email: csmarkopelago@gmail.com</a></p>
						<p><image src="icons\iconig.png"></i> <a href="https://www.instagram.com/markopelago/">IG: markopelago</a></p>
						<p><image src="icons\iconfb.png"></i> <a href="https://www.facebook.com/marko.pelago.73">Facebook: markopelago indonesia</a></p>
						<p><image src="icons\iconyt.png"></i> <a href="https://www.youtube.com/channel/UCZM1TAGwxOoR27mbxhJMQwQ">Youtube: markopelago indonesia</p>
						<p><image src="icons\icontwitter.png"></i> <a href="https://twitter.com/markopelago">Twitter: @markopelago</a></p>
					</div>
					<div class="col-sm-4 footer-links">
						<div class="row">
							<div class="col-sm-12">
								<h4><?=v("links");?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<p><a class="scroll-link" href="javascript:loadInfo('terms_and_conditions');"><?=v("terms_and_conditions");?></a></p>
								<!--p><a class="scroll-link" href="javascript:loadInfo('privacy_policy');"><?=v("privacy_policy");?></a></p-->
								<p><a class="scroll-link" href="javascript:loadInfo('contact_us');"><?=v("contact_us");?></a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script>
		<?php if($__isloggedin){ ?>
			var totalcount = 0;
			var totalDashboardcount = 0;
			function checkCounter(){
				totalcount = 0;
				totalDashboardcount = 0;
				$.ajax({url: "ajax/messages.php?mode=checkMessageCount", success: function(result){
					totalcount = totalcount + (result*1);
					try{ loadNotifCount("notifMessageCount",result); } catch(e){}
					try{ loadNotifCount("notifMessageTabCount",result); } catch(e){}
					try{ loadNotifCount("notifMessageTabCount1",result); } catch(e){}
	
					$.ajax({url: "ajax/purchase_list.php?mode=checkPurchaseList", success: function(result){
						totalcount = totalcount + (result*1);
						totalDashboardcount = totalDashboardcount + (result*1);
						try{ loadNotifCount("notifPurchaseListTabCount",result); } catch(e){}
						try{ loadNotifCount("notifPurchaseListTabCount1",result); } catch(e){}
						
						$.ajax({url: "ajax/purchase_list.php?mode=checkStoreSalesList", success: function(result){
							totalcount = totalcount + (result*1);
							totalDashboardcount = totalDashboardcount + (result*1);
							try{ loadNotifCount("notifStoreSalesListTabCount",result); } catch(e){}
							try{ loadNotifCount("notifStoreSalesListTabCount1",result); } catch(e){}
							
							$.ajax({url: "ajax/purchase_list.php?mode=checkDeliveringGoods", success: function(result){
								totalcount = totalcount + (result*1);
								totalDashboardcount = totalDashboardcount + (result*1);
								try{ loadNotifCount("notifDeliveringGoodsTabCount",result); } catch(e){}
								try{ loadNotifCount("notifDeliveringGoodsTabCount1",result); } catch(e){}
								try{ loadNotifCount("notifDeliveringGoodsTabCount2",result); } catch(e){}
								
								try{ loadNotifCount("notifNavCount",totalcount); } catch(e){}
								try{ loadNotifCount("notifCount",totalcount); } catch(e){}
								try{ loadNotifCount("notifMyDashboardCount",totalDashboardcount); } catch(e){}
								if(totalcount > 0){ document.getElementsByTagName('title')[0].innerHTML = "<?="(";?>"+totalcount+"<?=") ".$__title_project;?>"; }
							}});
							
						}});
						
					}});
				}});
				setTimeout(function(){ checkCounter(); }, 2000); 
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
			<?php if($__isloggedin){ ?> checkCounter(); <?php } ?>
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
	<?php $_SESSION["last_page"] = $_SERVER["PHP_SELF"];?>
</body>
</html>