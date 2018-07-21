<?php include_once "homepage_header.php"; ?>
<?php
	if(!$__isloggedin){
		?> <script> window.location = "index.php"; </script> <?php
		exit();
	}
?>
<?php include_once "main_container.php"; ?>
	<script>	
		function showGalery(model_album_id,mode){
			mode = mode || 0;
			$.get( "ajax/show_galery.php?model_album_id="+model_album_id+"&mode="+mode, function(modalBody) {
				modalFooter = "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Close</button>";
				$('#modalTitle').html("");
				$('#modalTitle').parent().css( "display", "none" );
				$('#modalBody').html(modalBody);
				$('#modalFooter').html(modalFooter);
				$('#myModal').modal('show');
			});
		}
		
		function delete_album(seqno){
			if(confirm("<?=v("are_you_sure_you_want_to_delete_this_photo");?>")){
				modeSaving.value="deleting";
				delete_seqno.value=seqno;
				frmAlbum.submit();
			}
		}
		<?php if($_POST["modeSaving"] == "addingPhoto"){ ?>
			$( document ).ready(function() {
				$("HTML, BODY").animate({scrollTop : $('html,body').height()-800 },800);
			});
		<?php } ?>
	</script>

	<style>
		.tbl_detail td{
			padding-right:30px;
			text-align:center;
		}
	</style>
	<?php include_once "dashboard_seller.php"; ?>

<?php include_once "main_container_end.php"; ?>
<?php include_once "footer.php"; ?>