<?php 
	include_once "../common.php";
	include_once "../func.sendingmail.php";
	function getSenderInfo($sender_id,$sender_as){
		global $db;
		if($sender_as == "buyer" || $sender_as == ""){
			$sender = $db->fetch_single_data("a_users","name",["id"=>$sender_id]);
			$img = $db->fetch_single_data("buyers","avatar",["user_id"=>$sender_id]);
			if($img == "") $img = $db->fetch_single_data("sellers","logo",["user_id"=>$sender_id]);
			if($img == "") $img = "nophoto.png";
			if(!file_exists("../users_images/".$img)) $img = "nophoto.png";
			$photo = "users_images/".$img;
		}
		if($sender_as == "seller"){
			$sender = $db->fetch_single_data("sellers","name",["user_id"=>$sender_id]);
			$img = $db->fetch_single_data("sellers","logo",["user_id"=>$sender_id]);
			if($img == "") $img = $db->fetch_single_data("buyers","avatar",["user_id"=>$sender_id]);
			if($img == "") $img = "nologo.jpg";
			if(!file_exists("../users_images/".$img)) $img = "nologo.jpg";
			$photo = "users_images/".$img;
		}
		if($sender_as == "markoantar"){
			$sender = $db->fetch_single_data("forwarders","name",["user_id"=>$sender_id]);
			$img = $db->fetch_single_data("sellers","logo",["user_id"=>$sender_id]);
			if($img == "") $img = $db->fetch_single_data("sellers","logo",["user_id"=>$sender_id]);
			if($img == "") $img = "nophoto.png";
			if(!file_exists("../users_images/".$img)) $img = "nophoto.png";
			$photo = "users_images/".$img;
		}
		$arrreturn["name"] = $sender;
		$arrreturn["photopath"] = $photo;
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
		$user_id_as = ($_GET["user_id_as"] == "")?"buyer":$_GET["user_id_as"];
		$user_id2_as = ($_GET["user_id2_as"] == "")?"seller":$_GET["user_id2_as"];
		$send_mail = $_GET["send_mail"];
		
		if($message != ""){
			if($thread_id <=0){
				$thread_id = $db->fetch_single_data("messages","thread_id",[],["thread_id DESC"]);
				$thread_id++;
			}
			$db->addtable("messages");
			$db->addfield("thread_id");	$db->addvalue($thread_id);
			$db->addfield("user_id");	$db->addvalue($__user_id);
			$db->addfield("user_id2");	$db->addvalue($sender_id);
			$db->addfield("user_id_as");$db->addvalue($user_id_as);
			$db->addfield("user_id2_as");$db->addvalue($user_id2_as);
			$db->addfield("message");	$db->addvalue($message);
			$db->addfield("status");	$db->addvalue(0);
			$inserting = $db->insert();

			$message = $db->fetch_single_data("a_users","name",["id" => $__user_id]).": ".$message;
			$db->addtable("notifications");
			$db->addfield("user_id");		$db->addvalue($sender_id);
			$db->addfield("message");		$db->addvalue($message);
			$inserting = $db->insert();
			
			if($send_mail){
				$seller_name = $db->fetch_single_data("sellers","concat(pic,' - ',name)",["user_id" => $sender_id]);
				$seller_email = $db->fetch_single_data("a_users","email",["id" => $sender_id]);
				$buyer_name = $db->fetch_single_data("a_users","name",["id" => $__user_id]);
				$arr1 = ["{seller_name}","{buyer_name}"];
				$arr2 = [$seller_name,$buyer_name];
				$body = read_file("../html/email_inbox_notification_id.html");
				$body = str_replace($arr1,$arr2,$body);
				sendingmail("Markopelago.com -- Ada yang ingin `ngobrol` dengan Anda",$seller_email,$body,"system@markopelago.com|Markopelago System");
				
			}
			
			$_GET["id"] = $inserting["insert_id"];
		}
		$mode = "loaddetail";
	}
	
	if($mode == "loadList"){
		$messages = $db->fetch_all_data("messages",[],"(user_id = '".$__user_id."' OR user_id2 = '".$__user_id."') AND id IN (SELECT MAX(id) FROM messages GROUP BY thread_id)","created_at DESC","50");
		if(count($messages) > 0){
			echo "<table width='100%'>";
			foreach($messages as $message){
				if($message["user_id"] == $__user_id){
					$sender_id = $message["user_id2"];
					$sender_as = $message["user_id2_as"];
				} else {
					$sender_id = $message["user_id"];
					$sender_as = $message["user_id_as"];
				}
				$arrsender = getSenderInfo($sender_id,$sender_as);
				$sender = $arrsender["name"];
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
			if($message["user_id"] == $__user_id){
				$sender_id = $message["user_id2"];
				$sender_as = $message["user_id2_as"];
			} else {
				$sender_id = $message["user_id"];
				$sender_as = $message["user_id_as"];
			}
			$arrsender = getSenderInfo($sender_id,$sender_as);
			$thread_id = $db->fetch_single_data("messages","thread_id",["id" => $id]);
			?>
			<div class="row">
				<div class="col-sm-1">
					<img src="<?=$arrsender["photopath"];?>" width="50">
				</div>
				<div class="col-sm-10">
					<b><?=$arrsender["name"];?></b>
				</div>
				<div class="col-sm-1">
					<button class="btn btn-warning" onclick="loadMessages();"><?=v("back");?></button>
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
					setTimeout(function(){ refreshMessage(); }, 5000);
				}
				refreshMessage();
			</script>
			<?php
		} else {
			?><script> loadMessages(); </script><?php
		}
	}
	if($mode == "loadMessageForm"){
		$sender_id = $_GET["sender_id"];
		$goods_id = $_GET["goods_id"];
		$user_id_as = $_GET["user_id_as"];
		if($user_id_as == "undefined") $user_id_as= "";
		$user_id2_as = $_GET["user_id2_as"];
		if($user_id2_as == "undefined") $user_id2_as= "";
		if($goods_id > 0){ $message = v("goods")." ".$db->fetch_single_data("goods","name",["id" => $goods_id])." : "; }
		if($user_id2_as == "buyer") echo v("send_message_to_buyer")."|||";
		if($user_id2_as == "seller") echo v("send_message_to_seller")."|||";
		if($user_id2_as == "markoantar") echo v("send_message_to_markoantar")."|||";
		echo "<div class=\"form-group\">";
		echo $f->textarea("message",$message,"style=\"height:100px !important;width:100% !important;\" required placeholder='".v("message")."...'","form-control");
		echo "</div>|||";
		echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"sendMessage('".$sender_id."',document.getElementById('message').value,'".$user_id_as."','".$user_id2_as."','1')\">".v("send")."</button>";
		echo "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">".v("cancel")."</button>";
	}
?>