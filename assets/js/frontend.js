// JavaScript Document
var BASEURL = $(document).find('.base_url').val();
var ASSETSURL = $(document).find('.asset_url').val();
var SMALLLOADER = '<img class="smalloading" src="'+ASSETSURL+'assets/images/loadersmall.gif">';

$(document).ready(function(){

$(document).on('change', '.usertyperegistration', function(){
	var value = $(this).val();
	if(value == 'individual') {
		$(document).find('.individual').show();
		$(document).find('.institution').hide();
	}
	else if(value == 'institution') {
		$(document).find('.individual').hide();
		$(document).find('.institution').show();
	}
	else {
		$(document).find('.individual').hide();
		$(document).find('.institution').hide();
	}
});

$(document).on('click', '.showhidepass', function(){
	if($(this).prev().attr('type') == 'password') {
		$(this).children().first().removeClass('fa-eye');
		$(this).children().first().addClass('fa-eye-slash');
		$(this).prev().attr('type', 'text');
	} else {
		$(this).children().first().removeClass('fa-eye-slash');
		$(this).children().first().addClass('fa-eye');
		$(this).prev().attr('type', 'password');
	}
});

$(document).on('keyup','.confirmpass', function(){
	var pass = $(this).parent().prev().children().first().next().val();
	var conpass = $(this).val();
	if(pass != conpass) {
		$(this).addClass('redborder');	
	}
	else {
		$(this).removeClass('redborder');
	}
});

$(document).on('click', '.submituserregistration', function(){
		var obj = $(this);													
		var allformdata = new FormData($('.formdata')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "becomeacustomer",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				obj.html('Registering... '+SMALLLOADER);
				obj.prop('disabled', true);
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					/*setTimeout(function(){ window.location.href = BASEURL; }, 2000);*/
					obj.html('Registering');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					setTimeout(function(){ window.location.href = BASEURL+'login'; }, 2000);
				}
			}
		});											 
});

$(document).on('click', '.submitserviceneeder', function(){
	
		var postalcodehidden = $(document).find('.postalcodehidden').val();
		if(postalcodehidden == '') {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please check your address field'});
			return false;
		}

		var otpcheck = $(document).find('.otpcheck').val();
		if(otpcheck != 1) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please confirm your mobile number'});
			return false;
		}
		
		var email = $(document).find('.emailfield').val();
		var confirmemail = $(document).find('.emailconfirm').val();
		if(email != confirmemail) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Confirm Email does not matched with Email'});
			return false;
		}
		
		var pass = $(document).find('.pass').val();
		var conpass = $(document).find('.conpass').val();
		if(pass != conpass) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Confirm Password does not matched with Password'});
			return false;
		}
		
		var obj = $(this);													
		var allformdata = new FormData($('.form')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/servicregistration",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Registering... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					obj.html('Register');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					setTimeout(function(){ window.location.href = BASEURL+'login'; }, 2000);
					
				}
			}
		});											 														 
});

$(document).on('click', '.contactbtn', function(){
	var fname = $(document).find('.fname').val();
	var lname = $(document).find('.lname').val();
	var phone = $(document).find('.phone').val();
	var subject = $(document).find('.subject').val();
	var msg = $(document).find('.msg').val();
		
	jQuery.ajax({
		type: "POST",
		url: BASEURL+"user/conatctform",
		data: { 
			'fname' : fname,
			'lname' : lname,
			'phone' : phone,
			'subject' : subject,
			'msg' : msg,
		  }, 
		dataType: "json",
		success: function(response) {
			var error = response.error;
			var success = response.success;
			if (success === 0) {
				$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
				return false;
			} else {
				$.toaster({ priority : 'success', title : 'Success', message : response.msg});
				$(document).find('.fname').val('');
				$(document).find('.lname').val('');
				$(document).find('.phone').val('');
				$(document).find('.subject').val('');
				$(document).find('.msg').val('');
				return false;
			}
		}
	});
});

$(document).on('change', '.regtypestep1', function(){
	if($(this).val() == 'no') {
		window.location.href = BASEURL + 'service-needer-registration';
	}
});

$(document).on('change', '.regtypestep2', function(){
	if($(this).val() == 'no') {
		window.location.href = BASEURL + 'offer-your-service';
	}
});

$(document).on('click', '.checkpostalcode', function(){
	var obj = $(this);												 
	var address = $(document).find('.posatlcodeaddress').val();
	if(address != '') {
		jQuery.ajax({
			type: "POST",
			dataType: "text",
			url: BASEURL+"user/getdetailsfromaddress/",
			data: { 'address' : address, }, 
			beforeSend: function() {
				obj.html('Checking... '+SMALLLOADER);
				obj.prop('disabled', true);
			},
			success: function(response) {
				if(response == 'blank') {
					$.toaster({ priority : 'danger', title : 'Error', message : 'Please choose an address with in Quebec'});
					$(document).find('.postalcodehidden').val('');
					obj.html('CONFIRM');
					obj.prop('disabled', false);
					return false;
				}
				else {
					var allpostcodes = $(document).find('.hiddenpostcode').val();
					var postcodearray = allpostcodes.split(',');
					
					var check = 0;
					$(postcodearray).each(function(index, value){
						if(value == response) {
							check = 1;	
						}
					});
					if(check == 0) {
						$.toaster({ priority : 'danger', title : 'Error', message : 'Please give an address with in Quebec'});
						$(document).find('.postalcodehidden').val('');
						obj.html('CONFIRM');
						obj.prop('disabled', false);
						return false;
					} else {					
						$(document).find('.postalcodehidden').val(response);
						obj.html('CONFIRM');
						obj.prop('disabled', false);
						$.toaster({ priority : 'success', title : 'Error', message : 'Postal Code Confirmed'});
					}
				}
			}
		});
	}
	else {
		$.toaster({ priority : 'danger', title : 'Error', message : 'Please give an address'});
		$(document).find('.postalcodehidden').val('');
		return false;
	}
});

$(document).on('click', '.checkmobile', function(){
	$(document).find('.otpsend').hide();											 
	var obj = $(this);												 
	var cellno = $(document).find('.cellno').val();
	if(cellno != '' && cellno.length == 10) {
		jQuery.ajax({
			type: "POST",
			url: BASEURL+"user/sendotp/",
			beforeSend: function() {
				obj.html('Checking... '+SMALLLOADER);
				obj.prop('disabled', true);
			},
			success: function(response) {
				console.log(response);
				$(document).find('.hiddenotp').val(response);
				$(document).find('.otpsend').show();
				obj.html('Confirm');
				obj.prop('disabled', false);
				return false;
				$.isNumeric(str);
			}
		});
	}
	else {
		$.toaster({ priority : 'danger', title : 'Error', message : 'Please give an cell number'});
		return false;
	}
});

$(document).on('keyup', '.otpenter', function(){
	$(this).addClass('redborder');											 
	if($(this).val().length == 4){
		if($(this).val() == $('.hiddenotp').val()) {
			$(document).find('.otpcheck').val(1);
			$(this).removeClass('redborder');
			$.toaster({ priority : 'success', title : 'Success', message : 'OTP Match'});
		} else {
			$(this).addClass('redborder');
			$.toaster({ priority : 'danger', title : 'Error', message : 'Entered OTP is not correct'});
		}
	}
});

$(document).on('click', '.submitfirststep', function(){
		var postalcodehidden = $(document).find('.postalcodehidden').val();
		if(postalcodehidden == '') {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please check your address field'});
			return false;
		}

		var otpcheck = $(document).find('.otpcheck').val();
		if(otpcheck != 1) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please confirm your mobile number'});
			return false;
		}
		
		var email = $(document).find('.emailfield').val();
		var confirmemail = $(document).find('.emailconfirm').val();
		if(email != confirmemail) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Confirm Email does not matched with Email'});
			return false;
		}
		
		var pass = $(document).find('.pass').val();
		var conpass = $(document).find('.conpass').val();
		if(pass != conpass) {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Confirm Password does not matched with Password'});
			return false;
		}
		
		var obj = $(this);													
		var allformdata = new FormData($('.formstep1')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/offeryourservice",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Registering... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					obj.html('Register');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					$(document).find('.hiddenuserid').val(response.userid);
					$(document).find('.steponearea').hide();
					$(document).find('.steptwoarea').show();
				}
			}
		});											 
});

$(document).on('change', '.qualificationcheckbox', function(){
	if($(this).is(':checked')) {
		if($(this).val() == 'Other') {
			$(document).find('.otheredublock').show();
		} else {
			$(document).find('.otheredublock').hide();
		}
	} else {
		$(document).find('.otheredublock').hide();	
	}
});

$(document).on('change', '.paytype', function(){
	if($(this).val() == 'hour') {
		$(document).find('.hourrate').show();
		$(document).find('.fixedrate').hide();
	} else if($(this).val() == 'fix') {
		$(document).find('.hourrate').hide();
		$(document).find('.fixedrate').show();
	}
});

$(document).on('change', '.servicetype', function(){
	$('.subservicetypeblock').hide();						  
	$(this).parent().next().show();												  
});

$(document).on('click', '.secondstepsubmit', function(){
		
		var obj = $(this);													
		var allformdata = new FormData($('.steptwoform')[0]);
		allformdata.append('userid', $(document).find('.hiddenuserid').val());
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/offeryourservice",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Registering... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					obj.html('Register');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					$(document).find('.hiddenuserid').val(response.userid);
					$(document).find('.steponearea').hide();
					$(document).find('.steptwoarea').hide();
					$(document).find('.stepthreearea').show();
				}
			}
		});											 
});

$(".imageuploader").change(function () {
		var obj = $(this);							 
    	filePreview(this, 'previewimage');
		obj.next().css('background', '#31B444');
		obj.next().html('Uploaded <i class="fa fa-check"></i>');
});

$(document).on('click', '.fourthstepsubmit', function(){
	var obj = $(this);												  
	var allformdata = new FormData($('.fourthstepform')[0]);	
	allformdata.append('userid', $(document).find('.hiddenuserid').val());
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/offeryourservice",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				obj.html('Registering... '+SMALLLOADER);
				obj.prop('disabled', true);
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					obj.html('Register');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					$(document).find('.hiddenuserid').val(response.userid);
					$(document).find('.steponearea').hide();
					$(document).find('.steptwoarea').hide();
					$(document).find('.stepthreearea').hide();
					$(document).find('.stepfourtharea').hide();
					$(document).find('.stepfiftharea').show();
				}
			}
		});	
});

$(document).on('click', '.finalregistration', function(){
	if($('.finaltermscheck').is(':checked')) {
		$.toaster({ priority : 'success', title : 'Error', message : 'You have successfully registerd. Please login to view your dashboard'});
		setTimeout(function(){ window.location.href = BASEURL+'login'; }, 2000);
	} else {
		$.toaster({ priority : 'danger', title : 'Error', message : 'Please accept the code of conduct to proceed'});
	}
});

$(document).on('click', '.submitevenpopup', function(){
	var obj = $(this);												  
	var allformdata = new FormData($('.eventaddform')[0]);	
	allformdata.append('userid', $(document).find('.hiddenuserid').val());
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/addavailabledates",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Saving... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					/*obj.html('Register');
					obj.prop('disabled', false);*/
				} else {
					$(response.dates).each(function(index,value){
						$('.date_cell').each(function(innerindex, innerval){
							if($(this).attr('date') == value.date) {
								$('<div class="tmDetails"><small>'+value.time+'</small></div>').insertAfter($(this).children().first().next());
								/*$('<a href="javascript:void(0)" class="editsetuptime"><div class="tmDetails"><small>'+value.time+'</small><i class="fas fa-pencil-alt"></i></div></a>').insertAfter($(this).children().first().next());*/
							}
						});						
					});
					close_popup('event_add');					
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					
				}
			}
		});													 
});

$(document).on('click', '.editsetuptime', function(){
	var userid = $(document).find('.hiddenuserid').val();
	var date = $(this).parent().attr('date');
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/gettimeforworker",
			data: { 
					'date' : date, 
					'userid' : userid 
				  },
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Saving... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				$(document).find('.editfromtime').val(response.dates.starttime);
				$(document).find('.edittotime').val(response.dates.endtime);
				$(document).find('.hiddeneditdatemodal').val(response.dates.date);
				$('#editmodal').modal('show');	
				$(document).find('.modal-backdrop').hide();
			}
		});	
});

$(document).on('click', '.updateavailabletimeedit', function(){
	var userid = $(document).find('.hiddenuserid').val();
	var date = $(document).find('.hiddeneditdatemodal').val();
	var fromtime = $(document).find('.editfromtime').val();
	var totime = $(document).find('.edittotime').val();
	
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/updatetimeforworker",
			data: { 
					'date' : date, 
					'userid' : userid,
					'fromtime' : fromtime, 
					'totime' : totime,
				  },
			dataType: "json",
			beforeSend: function() {
				/*obj.html('Saving... '+SMALLLOADER);
				obj.prop('disabled', true);*/
			},
			success: function(response) {
				console.log(response); return false;
				$(document).find('.editfromtime').val(response.dates.starttime);
				$(document).find('.edittotime').val(response.dates.endtime);
				$(document).find('.hiddeneditdatemodal').val(date);
				$('#editmodal').modal('show');	
				$(document).find('.modal-backdrop').hide();
			}
		});							 
});

$(document).on('click', '.calendardone', function(){
	$.toaster({ priority : 'success', title : 'Success', message : 'Lets move to the next step'});
	$(document).find('.stepthreearea').hide();
	$(document).find('.stepfourtharea').show();
});

	
$(document).on('click', '.buttonforlogin', function(){
	var obj = $(this);												  
	var allformdata = new FormData($('.workerlogin')[0]);	
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/login",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				obj.html('Please Wait... '+SMALLLOADER);
				obj.prop('disabled', true);
			},
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
					obj.html('Login');
					obj.prop('disabled', false);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
					setTimeout(function(){ window.location.href = response.url; }, 2000);
				}
			}
		});								 
});	

$(document).on('change', '.serachmainservice', function(){
	var obj = $(this);													
	var value = $(this).val();
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/getsubservicebyparent/"+value,
			success: function(response) {
				$(document).find('.subcategorysearchhome').html(response);
			}
		});	
});

$(document).on('change', '.serachmainservicefr', function(){
	var obj = $(this);													
	var value = $(this).val();
	jQuery.ajax({
			type: "POST",
			url: BASEURL + "user/getsubservicebyparentfr/"+value,
			success: function(response) {
				$(document).find('.subcategorysearchhomefr').html(response);
			}
		});	
});


$(document).on('change', '.chooseidentitydocumenttype', function(){
	var type = $(this).val();
	var file = $(document).find('.uploadidentitydocument').val();
		
	if(type != '' && file != '') {
		var allformdata = new FormData($('.identitycheckupload')[0]);
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "jobfinder/identitycheckupload",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
				}
			}
		});	
	
	} else {
		$.toaster({ priority : 'danger', title : 'Error', message : 'Please choose a document type and also upload the file'});
	}

});

$(document).on('change', '.uploadidentitydocument', function(){
	var type = $(this).val();
	var file = $(document).find('.chooseidentitydocumenttype').val();
		
	if(type != '' && file != '') {
		var allformdata = new FormData($('.identitycheckupload')[0]);
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "jobfinder/identitycheckupload",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				var error = response.error;
				var success = response.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : response.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : response.msg});
				}
			}
		});	
	
	} else {
		$.toaster({ priority : 'danger', title : 'Error', message : 'Please choose a document type and also upload the file'});
	}

});
	

$({ Counter: 0 }).animate({ Counter: $('.counter1').text()}, { duration: 5000, easing: 'swing', step: function() { $('.counter1').text(Math.ceil(this.Counter)); } });
$({ Counter: 0 }).animate({ Counter: $('.counter2').text()}, { duration: 5000, easing: 'swing', step: function() { $('.counter2').text(Math.ceil(this.Counter)); } });
$({ Counter: 0 }).animate({ Counter: $('.counter3').text()}, { duration: 5000, easing: 'swing', step: function() { $('.counter3').text(Math.ceil(this.Counter)); } });
$({ Counter: 0 }).animate({ Counter: $('.counter4').text()}, { duration: 5000, easing: 'swing', step: function() { $('.counter4').text(Math.ceil(this.Counter)); } });

	
$(".geocomplete").geocomplete({ country: 'ca', }).bind("geocode:result", function(event, result){$.log("Result: " + result.formatted_address);}).bind("geocode:error", function(event, status){$.log("ERROR: " + status);}).bind("geocode:multiple", function(event, results){$.log("Multiple: " + results.length + " results found");});
	
$("#find").click(function(){$("#geocomplete").trigger("geocode");});
	
$("#examples a").click(function(){$("#geocomplete").val($(this).text()).trigger("geocode"); return false; });	
	
$( ".datepicker" ).datepicker({
	 dateFormat:"dd-mm-yy",
});
	
	
$('.js-example-basic-single').select2();	
	
});




function validateEmail(email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( email );
}

function filePreview(input, targetclass) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.' + targetclass).attr('src', e.target.result);
			$('.' + targetclass).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}



/*for event calendar*/
// ajax call to get event detail from database.
function get_calendar_data(target_div,year,month){
	$.ajax({
		type:'POST',
		url:ASSETSURL+'functions.php',
		data:'fun_type=get_calender_full&year='+year+'&month='+month,
		success:function(html){
			$('#'+target_div).html(html);
		}
	});
}

function get_events_information(date){
	$.ajax({
		type:'POST',
		url:ASSETSURL+'functions.php',
		data:'fun_type=get_events_information&date='+date,
		success:function(html){
			$('#event_list').html(html);
			$('#event_add').slideUp('slow');
			$('#event_list').slideDown('slow');
		}
	});
}


function getdaynameshir(date) {
	var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	var d=new Date(date.split("-").reverse().join("/"));
	var a = new Date(d);
	var dayname = weekday[parseInt(a.getDay())];	
	return dayname;
}

function getdmyformatshir(date) {
	//var d=new Date(date.split("-").reverse().join("-"));
	var d=new Date(date);
	var dd=d.getDate();
	if(dd < 10) { dd = '0'+dd; }
	var mm=d.getMonth()+1;
	if(mm < 10) { mm = '0'+mm; }
	var yy=d.getFullYear();
	var newdate=dd+"-"+mm+"-"+yy;
	
	return newdate;
}

function getnextdateshir(date) {
	var d=new Date(date.split("-").reverse().join("/"));
	var actualDate = new Date(d);
	var nextDate = new Date(actualDate.getFullYear(), actualDate.getMonth(), actualDate.getDate()+1);
	
	var dmy = getdmyformatshir(nextDate);
	return dmy;
}

function getprevdateshir(date) {
	var d=new Date(date.split("-").reverse().join("/"));
	var actualDate = new Date(d);
	var nextDate = new Date(actualDate.getFullYear(), actualDate.getMonth(), actualDate.getDate()-1);
	
	var dmy = getdmyformatshir(nextDate);
	return dmy;
}


/*
* function name add_event_information
* Description :- Add Event inforation as per date wise
* parameter :- date
*/
function add_event_information(date){
	$('#eventDate').val(date);
	
	$(document).find('.hiddendateonmodal').val(date);
	
	var newdate = getdmyformatshir(date);
	var dayname = getdaynameshir(newdate);
	var nextdaydate = '';
	
	if(dayname == 'Sunday') { var daycount = 1; }
	if(dayname == 'Monday') { var daycount = 2; }
	if(dayname == 'Tuesday') { var daycount = 3; }
	if(dayname == 'Wednesday') { var daycount = 4; }
	if(dayname == 'Thursday') { var daycount = 5; }
	if(dayname == 'Friday') { var daycount = 6; }
	if(dayname == 'Saturday') { var daycount = 7; }
	
	if(daycount == 1) {
		$(document).find('.weekevendate1').val(newdate);
		
		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate2').val(nextdaydate);		
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate3').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate4').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate5').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate6').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 2) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate2').val(newdate);		
		
		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate3').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate4').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate5').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate6').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 3) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate2').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate3').val(newdate);
		
		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate4').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate5').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate6').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 4) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate3').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate2').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate4').val(newdate);
		
		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate5').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate6').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 5) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate4').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate3').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate2').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate5').val(newdate);
		
		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate6').val(nextdaydate);
		nextdaydate = getnextdateshir(nextdaydate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 6) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate5').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate4').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate3').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate2').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate6').val(newdate);

		nextdaydate = getnextdateshir(newdate);
		$(document).find('.weekevendate7').val(nextdaydate);
	}
	
	if(daycount == 7) {
		prevdaydate = getprevdateshir(newdate);
		$(document).find('.weekevendate6').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate5').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate4').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate3').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate2').val(prevdaydate);
		prevdaydate = getprevdateshir(prevdaydate);
		$(document).find('.weekevendate1').val(prevdaydate);
		
		$(document).find('.weekevendate7').val(newdate);
	}
	
	 
	
	
	$('#eventDateView').html(dayname+' '+newdate);
	$('#event_list').slideUp('slow');
	$('#event_add').slideDown('slow');
}

/*
*  below code used for save event information into databse. and set message event created successfully.
*/
$(document).ready(function(){

	$('#add_event_informationBtn').on('click',function(){
		var date = $('#eventDate').val();
		var title = $('#eventTitle').val();
		$.ajax({
			type:'POST',
			url:ASSETSURL+'functions.php',
			data:'fun_type=add_event_information&date='+date+'&title='+title,
			success:function(msg){
				if(msg == 'ok'){
					var dateSplit = date.split("-");
					$('#eventTitle').val('');
					alert('Event Created.');
					get_calendar_data('calendar_div',dateSplit[0],dateSplit[1]);
				}else{
					alert('Sorry some issues please try again later.');
				}
			}
		});
	});
});

$(document).ready(function(){
	$('.date_cell').mouseenter(function(){
		date = $(this).attr('date');
		$(".date_popup_wrap").fadeOut();
		$("#date_popup_"+date).fadeIn();	
	});
	$('.date_cell').mouseleave(function(){
		$(".date_popup_wrap").fadeOut();		
	});
	$('.month_dropdown').on('change',function(){
		get_calendar_data('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
	});
	$('.year_dropdown').on('change',function(){
		get_calendar_data('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
	});
	$(document).click(function(){
		$('#event_list').slideUp('slow');
	});

});


// Closed popup string	
function close_popup(event_id)
{
	$('#'+event_id).css('display','none');
}



