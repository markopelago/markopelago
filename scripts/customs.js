$(document).ready( function() {
	var photo_is_ready = false;
	jQuery(function() {
		var picture = $("#photo_uploaded");
		// $( document ).ready(function() {
		picture.on("load", function(){
			picture.guillotine({eventOnChange: "guillotinechange"});
			var data = picture.guillotine("getData");
			for(var key in data) { $("#form_"+key).val(data[key]); }
			$("#rotate_left").click(function(){ picture.guillotine("rotateLeft"); });
			$("#fit").click(function(){ picture.guillotine("fit"); });
			$("#zoom_in").click(function(){ picture.guillotine("zoomIn"); });
			$("#zoom_out").click(function(){ picture.guillotine("zoomOut"); });
			$("#rotate_right").click(function(){ picture.guillotine("rotateRight"); });
			picture.on("guillotinechange", function(ev, data, action) {
				data.scale = parseFloat(data.scale.toFixed(4));
				for(var k in data) { $("#form_"+k).val(data[k]); }
			});
			picture.guillotine("rotateLeft");
			setTimeout(function(){ picture.guillotine("rotateRight"); },200);
			setTimeout(function(){ picture.guillotine("fit"); },200);
		});
	});
	 
	function croping_process(){
		seeker_photo.value = photo_uploaded.src;
		frmUploadPhoto.submit();
	}	
	
	
	
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this), label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
	});

	$('.btn-file :file').on('fileselect', function(event, label) {
		var input = $(this).parents('.input-group').find(':text'),
			log = label;
		if( input.length ) {
			input.val(log);
		} else {
			if( log ) alert(log);
		}
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();   
			reader.onload = function (e) { $('#photo_uploaded').attr('src', e.target.result); }
			reader.readAsDataURL(input.files[0]);
			photo_is_ready = true;
		}
	}
	$("#imgInp").change(function(){
		readURL(this);
	}); 	
	
	$("#province_id").change(function(){
		loadCities($("#province_id").val());
	});
});

$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
})


function loadNotifCount(elmId,count){
	if(count != 0){
		$("#" + elmId).html(count);
		$("#" + elmId).attr("style","visibility:visible");
	} else {
		$("#" + elmId).html("");
		$("#" + elmId).attr("style","visibility:hidden");
	}
}

function getParams(script_name) {
  // Find all script tags

  var scripts = document.getElementsByTagName("script");
  
  // Look through them trying to find ourselves

  for(var i=0; i<scripts.length; i++) {
    if(scripts[i].src.indexOf("/" + script_name) > -1) {
      // Get an array of key=value strings of params

      var pa = scripts[i].src.split("?").pop().split("&");

      // Split each key=value into array, the construct js object

      var p = {};
      for(var j=0; j<pa.length; j++) {
        var kv = pa[j].split("=");
        p[kv[0]] = kv[1];
      }
      return p;
    }
  }
  
  // No scripts match

  return {};
}

function loadCities(parent_id){
	$("#div_select_district").css({ "display": "none" });
	$("#div_select_subdistrict").css({ "display": "none" });
	if(parent_id > 0){
		$("#div_select_cities").css({ "display": "block" });
		$("#div_cities").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/locations.php?mode=loadCities&parent_id="+parent_id, function(returnval){
			$("#div_cities").html(returnval);
		});
	} else{
		$("#div_select_cities").css({ "display": "none" });
	}
}

function loadDistricts(parent_id){
	$("#div_select_subdistrict").css({ "display": "none" });
	if(parent_id > 0){
		$("#div_select_district").css({ "display": "block" });
		$("#div_districts").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/locations.php?mode=loadDistricts&parent_id="+parent_id, function(returnval){
			$("#div_districts").html(returnval);
		});
	} else{
		$("#div_select_district").css({ "display": "none" });
	}
}

function loadSubDistricts(parent_id){
	if(parent_id > 0){
		$("#div_select_subdistrict").css({ "display": "block" });
		$("#div_subdistricts").html("<img src='images/fancybox_loading.gif'>");
		$.get("ajax/locations.php?mode=loadSubDistricts&parent_id="+parent_id, function(returnval){
			$("#div_subdistricts").html(returnval);
		});
	} else{
		$("#div_select_subdistrict").css({ "display": "none" });
	}
}

function newMessage(sender_id,goods_id,user_id_as,user_id2_as){
	$.get( "ajax/messages.php?mode=loadMessageForm&sender_id="+sender_id+"&goods_id="+goods_id+"&user_id_as="+user_id_as+"&user_id2_as="+user_id2_as, function(modalBody) {
		modalBody = modalBody.split("|||");
		modalTitle = modalBody[0];
		modalFooter = modalBody[2];
		modalBody = modalBody[1];
		$('#modalTitle').html(modalTitle);
		$('#modalBody').html(modalBody);
		$('#modalFooter').html(modalFooter);
		$('#myModal').modal('show');
	});
}

function sendMessage(sender_id,textmessage,user_id_as,user_id2_as,send_mail){
	user_id_as = user_id_as || "";
	user_id2_as = user_id2_as || "";
	send_mail = send_mail || "";
	if(sender_id > 0 && textmessage != ""){
		$.ajax({url: "ajax/messages.php?mode=sendMessage&sender_id="+sender_id+"&message="+textmessage+"&user_id_as="+user_id_as+"&user_id2_as="+user_id2_as+"&send_mail="+send_mail, success: function(result){
			window.location="dashboard.php?tabActive=message";
		}});
	}
}

function loadInfo(mode){
	$.get( "ajax/info.php?mode="+mode, function(modalBody) {
		modalBody = modalBody.split("|||");
		modalTitle = modalBody[0];
		modalFooter = modalBody[2];
		modalBody = modalBody[1];
		$('#modalTitle').html(modalTitle);
		$('#modalBody').html(modalBody);
		$('#modalFooter').html(modalFooter);
		$('#myModal').modal('show');
	});
}

function loadShopping_progress(transaction_id){
	$.get( "ajax/transaction.php?mode=loadShoppingProgress&transaction_id="+transaction_id, function(modalBody) {
		modalBody = modalBody.split("|||");
		modalTitle = modalBody[0];
		modalFooter = modalBody[2];
		modalBody = modalBody[1];
		$('#modalTitle').html(modalTitle);
		$('#modalBody').html(modalBody);
		$('#modalFooter').html(modalFooter);
		$('#myModal').modal('show');
	});
}