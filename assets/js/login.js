// JavaScript Document
var BASEURL = $(document).find('.base_url').val()+'admin/';

$(document).ready(function(){
	/*for login*/
	$(document).on('click', '.loginbutton', function(){
		var allformdata = new FormData($('.loginform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "login",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			/*beforeSend: function() {
				jQuery("#productblockid").append(loader);
			},*/
			success: function(responce) {
				/*jQuery(".ajaxLoader").remove();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$('.errormsg').html(responce.msg);
					$('.errormsg').show();
					$('.errormsg').delay(3000).fadeOut('slow');
				} else {
					window.location.href = BASEURL;
				}
			}
		});											 
	});
});