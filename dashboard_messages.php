<br>
<div id="dashboard_messages"></div>
<script>
	function sendMessage(thread_id,sender_id,textmessage){
		$.ajax({url: "ajax/messages.php?mode=sendMessage&thread_id="+thread_id+"&sender_id="+sender_id+"&message="+textmessage, success: function(result){
			$("#dashboard_messages").html(result);
		}});
	}
	function loadConversations(thread_id){
		$.ajax({url: "ajax/messages.php?mode=loadconversations&thread_id="+thread_id, success: function(result){
			$("#conversations").html(result);
		}});
	}
	function loadDetailMessage(id){
		$.ajax({url: "ajax/messages.php?mode=loaddetail&id="+id, success: function(result){
			$("#dashboard_messages").html(result);
		}});
	}
	function loadMessages(){
		$.ajax({url: "ajax/messages.php?mode=loadList", success: function(result){
			$("#dashboard_messages").html(result);
		}});
	}
	loadMessages();
</script>