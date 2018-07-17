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
});

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