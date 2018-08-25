<?php
	$cookie_name = "kanari_access";
	$cookie_value = "ok";
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
?>
<script> window.location = "../"; </script>
