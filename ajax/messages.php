<?php 
	include_once "../common.php";
	function getSenderInfo($sender_id){
		global $db;
		$sender = $db->fetch_single_data("a_users","name",["id"=>$sender_id]);
		$role = $db->fetch_single_data("a_users","role",["id"=>$sender_id]);
		$photofield = "photo";
		if($role == "2"){ 
			$profiletable = "personal_profiles";
			$arrreturn["role_name"] = "Personal User";
		}
		if($role == "3"){
			$profiletable = "agency_profiles";
			$arrreturn["role_name"] = "Agency";
		}
		if($role == "5"){
			$profiletable = "model_profiles";
			$arrreturn["role_name"] = "Model";
		}
		if($role == "4"){
			$profiletable = "corporate_profiles";
			$arrreturn["role_name"] = "Corporate";
			$photofield = "logo";
		}
		$photo = "user_images/".$db->fetch_single_data($profiletable,$photofield,["user_id" => $sender_id]);
		$arrreturn["name"] = $sender;
		$arrreturn["role"] = $role;
		$arrreturn["photopath"] = $photo;
		if($role < 2 || $role > 5){
			$arrreturn["name"] = "warihFramework";
			$arrreturn["role"] = $role;
			$arrreturn["photopath"] = "images/logo.png";
			$arrreturn["role_name"] = "Admin";
		}
		return $arrreturn;
	}
	
	$mode = $_GET["mode"];
	if($mode == "checkMessageCount"){
		echo $db->fetch_single_data("messages","count(0)",["user_id2" => $__user_id,"status" => "0"]);
	}
	
	if($mode == "sendMessage"){
		$thread_id = $_GET["thread_id"];
		$_GET["id"] = $db->fetch_single_data("messages","id",["thread_id" => $thread_id],["id DESC"]);
		$sender_id = $_GET["sender_id"];
		$message = sanitasi($_GET["message"]);
		if($message != ""){
			if($thread_id <=0){
				$thread_id = $db->fetch_single_data("messages","thread_id",[],["thread_id DESC"]);
				$thread_id++;
			}
			$db->addtable("messages");
			$db->addfield("thread_id");	$db->addvalue($thread_id);
			$db->addfield("user_id");	$db->addvalue($__user_id);
			$db->addfield("user_id2");	$db->addvalue($sender_id);
			$db->addfield("message");	$db->addvalue($message);
			$db->addfield("status");	$db->addvalue(0);
			$inserting = $db->insert();
			$_GET["id"] = $inserting["insert_id"];
		}
		$mode = "loaddetail";
	}
	
	if($mode == "loadList"){
		$messages = $db->fetch_all_data("messages",[],"(user_id = '".$__user_id."' OR user_id2 = '".$__user_id."') AND id IN (SELECT MAX(id) FROM messages GROUP BY thread_id)","created_at DESC","50");
		if(count($messages) > 0){
			echo "<table width='100%'>";
			foreach($messages as $message){
				if($message["user_id"] == $__user_id) $sender_id = $message["user_id2"];
				else $sender_id = $message["user_id"];
				$arrsender = getSenderInfo($sender_id);
				$sender = $arrsender["name"];
				$role = $arrsender["role"];
				$photo = $arrsender["photopath"];
				if($message["status"] == 0) $message["message"] = "<b><i>".$message["message"]."</i></b>";
		?>
			<tr>
				<td>
					<div class="col-sm-12" style="cursor:pointer;" onclick="loadDetailMessage('<?=$message["id"];?>');">
						<div class="row equal-heights">
							<div class="col-sm-1">
								<img src="<?=$photo;?>" width="50">
							</div>
							<div class="col-sm-11">
								<div>
									<b><?=$sender;?></b>
									<div style="position:relative;float:right;color:grey;font-size:10px;"><?=format_tanggal($message["created_at"],"dmY",true);?></div>
								</div>
								<div>
									<?=$message["message"];?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12" style="padding-bottom:10px;border-bottom:1px solid #aaa;width:100%;"></div>
				</td>
			</tr>
		<?php
			}
			echo "</table>";
		} else {
			echo "<span class='col-sm-12 well' style='color:red;'>".v("message_not_found")."</span>";
		}
	}
	
	if($mode == "loadconversations"){
		$thread_id = $_GET["thread_id"];
		$messages = $db->fetch_all_data("messages",[],"thread_id = '".$thread_id."' AND (user_id='$__user_id' OR user_id2='$__user_id')","created_at DESC","1000");
		foreach($messages as $message){
			if($message["user_id2"] == $__user_id){
				$class = "bs-callout-success bs-callout-left";
				if($message["status"] == "0"){
					$db->addtable("messages"); $db->where("id",$message["id"]);
					$db->addfield("status");	$db->addvalue(1);
					$db->update();
				}
			} else {
				$class = "bs-callout-info bs-callout-right";
			}
			?>
			<div class="bs-callout <?=$class;?>">
				<?=$message["message"];?>
				<div style="position:relative;float:right;color:grey;font-size:10px;top:0px;"><?=format_tanggal($message["created_at"],"dmY",true);?></div>
			</div>
			<?php
		}
	}
	if($mode == "loaddetail"){
		$id = $_GET["id"];
		$message = $db->fetch_all_data("messages",[],"id = '".$id."' AND (user_id='$__user_id' OR user_id2='$__user_id')")[0];
		if($message["id"] != ""){
			if($message["user_id"] == $__user_id) $sender_id = $message["user_id2"];
			else $sender_id = $message["user_id"];
			$arrsender = getSenderInfo($sender_id);
			$thread_id = $db->fetch_single_data("messages","thread_id",["id" => $id]);
			?>
			<div class="row">
				<div class="col-sm-1">
					<img src="<?=$arrsender["photopath"];?>" width="50">
				</div>
				<div class="col-sm-11">
					<b><?=$arrsender["name"];?></b><br>
					<i>(<?=$arrsender["role_name"];?>)</i>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="form-group">
					<div class="col-sm-10">
						<input type="text" class="form-control" id="txtmessage" onkeyup="if(event.keyCode == '13'){ sendMessage('<?=$thread_id;?>','<?=$sender_id;?>',txtmessage.value); }">
					</div>
					<div class="col-sm-1">
						<button class="btn info" onclick="sendMessage('<?=$thread_id;?>','<?=$sender_id;?>',txtmessage.value);">Send</button>
					</div>
					<div class="col-sm-1"></div>
				</div>
			</div>
			<div id="conversations"></div>
			<script>
				function refreshMessage(){
					loadConversations('<?=$thread_id;?>');
					setTimeout(function(){ refreshMessage(); }, 1000);
				}
				setTimeout(function(){ refreshMessage(); }, 1000);
			</script>
			<?php
		} else {
			?><script> loadMessages(); </script><?php
		}
	}
?>