<?php $_COOKIE["android_apps"] = 1; include_once "../common.php"; echo $db->fetch_single_data("apps_version","version",["id" => "1"]); ?>
