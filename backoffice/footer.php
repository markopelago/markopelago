<?php if(!$_isexport){ ?>
</div>
		<br>
		<br>
		<br>
		<div class="footer_area" id="footer_area">
			<div>
				<br>
				<?=$t->start("width='900'");?>
					<?=$t->row(array("COPYRIGHT &copy; ".date("Y")." ".strtoupper($__title_project)." ALL RIGHTS RESERVED."),array("align='middle' style='color:#333;'"));?>
				<?=$t->end();?>
				<br>
			</div>
		</div>
	</body>
</html>
<?php } ?>