// JavaScript Document
var BASEURL = $(document).find('.base_url').val();

$(document).ready(function(){	
	
	/*for user login*/
	$(document).on('click', '.userloginbutton', function(){
		var allformdata = new FormData($('.userloginform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.savelogomanagement').hide();*/
			},
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : responce.msg});
					/*setTimeout(function(){ $(document).find('.savelogomanagement').show(); }, 2000);*/
				} else {
					window.location.href = BASEURL + 'chat';
				}
			}
		});											 
	});
	
	/*for chat popup*/
	$('#live-chat header').on('click', function() {
		$('.chat').slideToggle(300, 'swing');
		$('.chat-message-counter').fadeToggle(300, 'swing');
	});
	$('.chat-close').on('click', function(e) {
		e.preventDefault();
		$('#live-chat').fadeOut(300);
	});

	/*for sending the message*/
	$(document).on('keyup', '.chatfield', function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){										   
			var msg = $(document).find('.chatfield').val();
			var encryptedmsg = base64(msg, 1);
			if(msg != '') {
				jQuery.ajax({
					type: "POST",
					url: BASEURL + "user/sendmsg",
					data: { 'msg' : encryptedmsg },
					dataType: "json",
					beforeSend: function() {
						/*$(document).find('.ajaxloading').show();
						$(document).find('.savelogomanagement').hide();*/
					},
					success: function(responce) {
						var error = responce.error;
						var success = responce.success;
						if (success === 0) {
							$.toaster({ priority : 'danger', title : 'Error', message : responce.msg});
						} else {
							var html = '<div class="chat-message clearfix senderblock"> <img src="http://gravatar.com/avatar/" alt="" height="32" width="32"><div class="chat-message-content clearfix"> <span class="chat-time">'+responce.datetime+'</span><h5>John Doe</h5><p>'+msg+'</p></div></div><hr>';
							$(document).find('.chat-history').append(html);
							$(document).find('.chatfield').val('');
							$(".chat-history").animate({ scrollTop: $('.chat-history').prop("scrollHeight") }, 1000);
						}
					}
				});	
			}
		}
	});

	window.setInterval(function(){ randomcheckmsg(); }, 1000);
	$(".chat-history").animate({ scrollTop: $('.chat-history').prop("scrollHeight") }, 1000);

    /*$('.owl-carousel').owlCarousel({
		loop: true,
		margin: 10,
		responsiveClass: true,
		responsive: {
		  0: {
			items: 1,
			nav: true
		  },
		  600: {
			items: 3,
			nav: false
		  },
		  1000: {
			items: 5,
			nav: true,
			loop: false,
			margin: 20
		  }
		}
	  });
*/

});


function base64(string, type) {

	// Create Base64 Object
	var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

	if(type === 1) { // Encode the String
		var encodedString = Base64.encode(string);
		return encodedString;
	}
	if(type === 0) { // Decode the String
		var decodedString = Base64.decode(encodedString);
		return decodedString;
	}
}

function randomcheckmsg() {
	var loggedinuser = $(document).find('.hiddenuserid').val();
	jQuery.ajax({
		type: "POST",
		url: BASEURL + "user/randomcheckmsg",
		dataType: "json",
		success: function(responce) {
			var html = '';
			$(responce).each(function(key, val){
				if(val.sender == loggedinuser) {
					if(val.sender == 1) { var name = 'John Doe'; } else if(val.sender == 2) { var name = 'Marco Biedermann'; }
					if(val.sender == 1) { var image = 'http://gravatar.com/avatar/'; } else if(val.sender == 2) { var image = 'http://gravatar.com/avatar/2c0ad52fc5943b78d6abe069cc08f320?s=32'; }
					html += '<div class="chat-message clearfix senderblock"> <img src="'+image+'" alt="" width="32" height="32"><div class="chat-message-content clearfix"> <span class="chat-time">'+val.datetime+'</span><h5>'+name+'</h5><p>'+val.msg+'</p></div></div><hr>';
				}
				else if(val.reciever == loggedinuser) {
					if(val.reciever == 1) { var name = 'Marco Biedermann'; } else if(val.reciever == 2) { var name = 'John Doe'; }
					if(val.reciever == 1) { var image = 'http://gravatar.com/avatar/2c0ad52fc5943b78d6abe069cc08f320?s=32'; } else if(val.reciever == 2) { var image = 'http://gravatar.com/avatar/'; }
					html += '<div class="chat-message clearfix recieverblock"> <img src="'+image+'" alt="" width="32" height="32"><div class="chat-message-content clearfix"> <span class="chat-time">'+val.datetime+'</span><h5>'+name+'</h5><p>'+val.msg+'</p></div></div><hr>';
				}
			});
			$(document).find('.chat-history').html(html);
		}
	});	
}