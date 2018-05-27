<?php include_once "common.php"; ?>
<?php $_rowperpage = 200; ?>
<?php $_max_counting = $db->max_counting; ?>
<?php if($_role != 0){ ?><script> window.location="../index.php";</script><?php } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if(!$_isexport){ ?>
<html>
	<head>
		<meta property="og:image" content="../images/logo.png">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=8;" />
		<link rel="Shortcut Icon" href="../favicon.ico">
		<title id="titleid"><?=$__title_project;?> - BackOffice</title>
		
		<script src="../scripts/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="../scripts/jquery.fancybox.js"></script>
		<script type="text/javascript" src="../calendar/calendar.js"></script>
		<script type="text/javascript" src="../calendar/lang/calendar-en.js"></script>
		<script type="text/javascript" src="../calendar/calendar-setup.js"></script>

		<link rel="stylesheet" type="text/css" href="../styles/style.css">
		<link rel="stylesheet" type="text/css" href="backoffice.css">
		<link rel="stylesheet" type="text/css" href="../calendar/calendar-win2k-cold-1.css">
		<link rel="stylesheet" type="text/css" href="../styles/jquery.fancybox.css" media="screen" />
		<link rel="stylesheet" href="../font/font.css">
		<script>
			var global_respon = new Array();
			function get_ajax(x_url,target_elm,done_function){
				$( document ).ready(function() {
					$.ajax({url: x_url, success: function(result){
						try{ $("#"+target_elm).html(result); } catch(e){}
						try{ $("#"+target_elm).val(result); } catch(e){}
						try{ global_respon[target_elm] = result; } catch(e){}
						try{ eval(done_function || ""); } catch(e){}
					}});
				});
			}
			
			function popup_message(message,mode,actionAfterClose){
				mode = mode || "";
				actionAfterClose = actionAfterClose || "";
				$.fancybox.open({
					content:"<div style='overflow:auto;'><table class='popup_message "+mode+"'><tr><td>"+message+"</td></tr></table></div>",
					afterClose: function(){ try{ eval(actionAfterClose); } catch(e){} }
				});
			}
			
			function toogle_bo_filter(){
				var bo_filter_container = document.getElementById('bo_filter_container'),
				style = window.getComputedStyle(bo_filter_container),
				bo_filter_container_display = style.getPropertyValue('display');
				if(bo_filter_container_display == "none") {
					bo_filter_container.style.display="block";
					bo_expand.innerHTML="[-] Hide Filter";
				}
				if(bo_filter_container_display == "block") {
					bo_filter_container.style.display="none";
					bo_expand.innerHTML="[+] View Filter";
				}
			}
			
			function changepage(numpage){
				page.value = numpage;
				filter.submit();
			}

			function sorting(field){
				var current_sort = sort.value;
				current_sort = current_sort.replace(" DESC","");
				if((current_sort == field && sort.value.indexOf(" DESC") > 0) || current_sort != field){
					sort.value = field;
				} else {
					sort.value = field + " DESC";
				}
				filter.submit();
			}
			
			function openwindow(url){ window.open(url,"","width=1100,height=800,scrollbars=yes"); }
		</script>
	</head>
	<body id="bodyid" style="margin:0px;">
		<?php include_once "menu.php";?>
		<?php
			if($__isloggedin){
		?>
			<script> $("body").css({"background-color":"white"});</script>
			<div style="width:95%;margin-top:20px;margin-left:20px;margin-right:20px;">
			<?php if(!$__is_allowed){ ?>
				Forbidden Page!
			<?php 
					include_once "footer.php";
					exit(); 
				} 
			?>
		<?php 
			} else {
				?>
				<script> $("body").css({"background-color":"white"});</script>
				<div style="width:95%;margin-top:20px;margin-left:20px;margin-right:20px;">
					<?php include_once "login_page.php";?>
				</div>
				<?php
				include_once "footer.php";
				exit();
			}  
		?>
		<script> $("body").css({"background-color":"white"});</script>
<div style="width:95%;margin-top:20px;margin-left:20px;margin-right:20px;">

<?php } ?>