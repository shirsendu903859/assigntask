// JavaScript Document
var BASEURL = $(document).find('.base_url').val()+'admin/';
var ASSETS_URL = $(document).find('.assets_url').val();
var LOGO_UPLOAD_URL = ASSETS_URL+'uploads/logo/';
var USER_IMAGE_UPLOAD_URL = ASSETS_URL+'uploads/user/';
var BANNER_UPLOAD_URL = ASSETS_URL+'uploads/banner/';
var attrblockhtml = $(document).find('.attrblock').html();

$(document).ready(function(){	
	/*for search in the admin side panel starts*/
	$(".searchtype").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".tree li").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	/*for search in the admin side panel ends*/
	
	/*for logo insert*/
	$(document).on('click', '.savelogomanagement', function(){
		var allformdata = new FormData($('.logomanagementform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "logomanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savelogomanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savelogomanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for logo details image*/
	$(document).on('click', '.logodetails', function(){
		var imageurl = $(this).prev().attr('src');
		$(document).find('#modalimageid').attr('src', imageurl);
		$('#modalforlogoenlarger').modal('show');
	});
	
	/*for edit logo details data fetch*/
	$(document).on('click', '.editlogodetails', function(){
		var logoid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "logomanagementfetchdatabyid/"+logoid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$(document).find('.editlogoalt').val(responce.data.alt);
					$(document).find('.editlogotitle').val(responce.data.title);
					$(document).find('.editlogoheight').val(responce.data.height);
					$(document).find('.editlogowidth').val(responce.data.width);
					$(document).find('.showlogoinmodalforedit').attr('src', LOGO_UPLOAD_URL+responce.data.imagename);
					$(document).find('.hiddeneditloogid').val(logoid);
					$('#editlogomodal').modal('show');
				}
			}
		});
	});
	
	
	
	$(".imageuploader1").change(function () {
    	filePreview(this, 'previewimage1');
	});
	$(".imageuploader2").change(function () {
    	filePreview(this, 'previewimage2');
	});
	$(".imageuploader3").change(function () {
    	filePreview(this, 'previewimage3');
	});
	$(".imageuploader4").change(function () {
    	filePreview(this, 'previewimage4');
	});
	
	$(".logoimageuploadforedit").change(function () {
    	filePreview(this, 'showlogoinmodalforedit');
	});
	
	$(".uploadnewlogouploader").change(function () {
    	filePreview(this, 'newlogouploadclass');
	});
	
	$(".userimageuploadforedit").change(function () {
    	filePreview(this, 'showuserinmodalforedit');
	});
	
	$(document).on('change', '.uploadnewproductimage', function(){
        imagesPreview(this, 'div.showimage');
    });

	
	$(document).on('click', '.addlogodialougeshow', function(){
		$(document).find('.addlogodialougebox').toggle();
	});
	
	/*for update the logo*/
	$(document).on('click', '.editlogomanagement', function(){
		var allformdata = new FormData($('.editlogoform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "updatelogomanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editlogomanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editlogomanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editlogomodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for change the logo status*/
	$(document).on('click', '.changelogostatus', function(){
		var obj = $(this);
		var logoid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "logomanagementchangestatus/"+logoid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						$(document).find('.statusicon').removeClass('fa-thumbs-o-up');
						$(document).find('.statusicon').addClass('fa-thumbs-o-down');
						setTimeout(function(){ 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
						}, 1000);
						setTimeout(function(){ $.toaster({ priority : 'success', title : 'Success', message : responce.msg}) }, 1000);
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	/*for delete the logo*/
	$(document).on('click', '.deletelogo', function(){
		var obj = $(this);
		var logoid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "logomanagementdelete/"+logoid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 1000);
				}
			}
		});
	});
	
	$(document).on('click', '.autogenpass', function(){
		var passlen = $(document).find('.AUTOGEN_PASSWORD_LENGTH').val();
		var autogenpass = randomPassword(passlen);
		$(document).find('.passwordfield').val(autogenpass);
	});
	
	$(document).on('click', '.autogenpass2', function(){
		var passlen = $(document).find('.AUTOGEN_PASSWORD_LENGTH').val();
		var autogenpass = randomPassword(passlen);
		$(document).find('.passwordfieldedit').val(autogenpass);
	});
	
	/*for inserting the user data*/
	$(document).on('click', '.saveusermanagement', function(){
		var allformdata = new FormData($('.usermanagementform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savelogomanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savelogomanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for inserting the vehicle data*/
	$(document).on('click', '.savevehiclemanagement', function(){
		var allformdata = new FormData($('.usermanagementform')[0]);
		var desc = CKEDITOR.instances.editor1.getData();
		allformdata.append('description', desc);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "vehicle-type-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveusermanagement').hide();
			},
			success: function(responce) {
				
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveusermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for inserting the fair data*/
	$(document).on('click', '.savefairmanagement', function(){
		
		var starthour = $(document).find('.starthour').val();
		var startminute = $(document).find('.startminute').val();
		var startmeridian = $(document).find('.startmeridian').val();
		var endhour = $(document).find('.endhour').val();
		var endminute = $(document).find('.endminute').val();
		var endmeridian = $(document).find('.endmeridian').val();
		
		if(starthour == '' || startminute == '' || startmeridian == '' || endhour == '' || endminute == '' || endmeridian == '') {
			$.toaster({ priority : 'error', title : 'Error', message : 'Please fill up all the fields'});
			setTimeout(function(){ $(document).find('.savefairmanagement').show(); }, 2000);
			return false;
		}
		else {
			if(startmeridian == 'PM') { starthour = parseInt(starthour) + parseInt(12); }
			if(endmeridian == 'PM') { endhour = parseInt(endhour) + parseInt(12); }

			min = endminute-startminute;
			hour_carry = 0;
			if(min < 0){
				min += 60;
				hour_carry += 1;
			}
			hour = endhour-starthour-hour_carry;
			min = ((min/60)*100).toString()
			diff = hour + ":" + min.substring(0,2);	
		}
		
		if(hour < 0) {
			$.toaster({ priority : 'error', title : 'Error', message : 'Please choose end time greater than start time'});
			setTimeout(function(){ $(document).find('.savefairmanagement').show(); }, 2000);
			return false;	
		}
		else {
			var allformdata = new FormData($('.usermanagementform')[0]);
			jQuery(".errormsg").hide();
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "fare-management",
				data: allformdata,
				mimeType: "multipart/form-data",
				contentType: false,
				cache: false,
				processData: false,
				dataType: "json",
				beforeSend: function() {
					$(document).find('.ajaxloading').show();
					$(document).find('.savefairmanagement').hide();
				},
				success: function(responce) {
					$(document).find('.ajaxloading').hide();
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
						setTimeout(function(){ $(document).find('.savefairmanagement').show(); }, 2000);
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 2000);
					}
				}
			});
		}
	});
	
	
	/*for fetching the number of seats on car choose*/
	$(document).on('change', '.cartypebookingform', function(){
		var cartype = $(this).val();
		if(cartype == '') {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please choose a vehicle type'});			
		}
		else {
			jQuery.ajax({
			type: "POST",
			url: BASEURL+"user/getseatfromvehicleid",
			data: { 'cartype' : cartype }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : responce.msg});	
					return false;
				} else {
					$(document).find('.numberofseat').html(responce.data);
					return false;
				}
			}
		});	
		}
	});
	
	/*for fetching the number of seats on car choose*/
	$(document).on('change', '.editcartypebookingform', function(){
		var cartype = $(this).val();
		if(cartype == '') {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please choose a vehicle type'});			
		}
		else {
			jQuery.ajax({
			type: "POST",
			url: BASEURL+"user/getseatfromvehicleid",
			data: { 'cartype' : cartype }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'danger', title : 'Error', message : responce.msg});	
					return false;
				} else {
					$(document).find('.editnumberofseat').html(responce.data);
					return false;
				}
			}
		});	
		}
	});
	
	
	/*for delete the User*/
	$(document).on('click', '.deleteuser', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var userid = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "user-management",
				data: { 
						'tag' : 'deleteuser', 
						'userid' : userid 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	/*for delete the Vehicle*/
	$(document).on('click', '.deletevehicle', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var vehicleid = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "vehicle-type-management",
				data: { 
						'tag' : 'deleteuser', 
						'vehicleid' : vehicleid 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	/*for delete the Vehicle*/
	$(document).on('click', '.deletefare', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "fare-management",
				data: { 
						'tag' : 'deleteuser', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	/*for edit user details data fetch*/
	$(document).on('click', '.edituserdetails', function(){
		var obj = $(this);
		var userid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user-management",
			data: { 
					'tag' : 'edituser',
					'type' : 'get',
					'userid' : userid ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$(document).find('.editdrivername').val(responce.data.name);
					$(document).find('.editvehicletype').val(responce.data.vehicletype);
					$(document).find('.editvehiclenumber').val(responce.data.vehiclenumber);
					$(document).find('.editemail').val(responce.data.email);					
					$(document).find('.editaddress').val(responce.data.address);
					$(document).find('.editphone').val(responce.data.phone);
					$(document).find('.hiddenuseridedit').val(userid);
					$('#editusermodal').modal('show');
				}
			}
		});
	});
	
	/*for edit vehicle details data fetch*/
	$(document).on('click', '.editvehicledetails', function(){
		var obj = $(this);
		var vehicleid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "vehicle-type-management",
			data: { 
					'tag' : 'editvehicle',
					'type' : 'get',
					'vehicleid' : vehicleid ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$(document).find('.editvehiclename').val(responce.data.title);
					$(document).find('.editluggage').val(responce.data.luggage);
					$(document).find('.editseat').val(responce.data.seat);
					$(document).find('.hiddenvehicleidedit').val(vehicleid);
					$('#editusermodal').modal('show');
				}
			}
		});
	});
	
	/*for edit vehicle details data fetch*/
	$(document).on('click', '.editfaredetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "fare-management",
			data: { 
					'tag' : 'editfare',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$(document).find('.editmaxkm').val(responce.data.maxkm);
					$(document).find('.editamount').val(responce.data.amount);
					
					var startsegment = responce.data.starttime.split(':');
					if(startsegment[0] > 12) {
						var starthour = parseInt(startsegment[0]) - parseInt(12);
						var startminute = startsegment[1];
						var startmeridian = 'PM';
					}
					else {
						var starthour = startsegment[0];
						var startminute = startsegment[1];
						var startmeridian = 'AM';
					}
					if(starthour < 10) {
						starthour = '0'+starthour;	
					}
					
					$(document).find('.editstarthour').val(starthour);
					$(document).find('.editstartminute').val(startminute);
					$(document).find('.editstartmeridian').val(startmeridian);
										
					var endsegment = responce.data.endtime.split(':');
					if(endsegment[0] > 12) {
						var endhour = parseInt(endsegment[0]) - parseInt(12);
						var endminute = endsegment[1];
						var endmeridian = 'PM';
					}
					else {
						var endhour = endsegment[0];
						var endminute = endsegment[1];
						var endmeridian = 'AM';
					}
					if(endhour < 10) {
						endhour = '0'+endhour;	
					}
					
					$(document).find('.editendhour').val(endhour);
					$(document).find('.editendminute').val(endminute);
					$(document).find('.editendmeridian').val(endmeridian);
					
					$(document).find('.editcartypebookingform').val(responce.data.vehicletype);
					
					var x = 1;
					var html = '';
					html = '<option value="">Choose</option>';
					for(x=1; x<=responce.seatcount; x++) {
						html += '<option value="'+x+'">'+x+'</option>';
					}
					$(document).find('.editnumberofseat').html(html);
					$(document).find('.editnumberofseat').val(responce.data.numberofseat);
					
					$(document).find('.hiddenfareidedit').val(id);
					$('#editusermodal').modal('show');
				}
			}
		});
	});
	
	/*for update the user*/
	$(document).on('click', '.editusermanagement', function(){
		var obj = $(this);
		var userid = $('.hiddenedituserid').val();													
		var allformdata = new FormData($('.edituserform')[0]);
		allformdata.append('tag', 'edituser');
		allformdata.append('type', 'post');
		allformdata.append('userid', userid);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "user-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editusermanagement').hide();
			},
			success: function(responce) {
				
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editusermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editusermodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for update the vehicle*/
	$(document).on('click', '.editvehiclemanagement', function(){
		var obj = $(this);
		var userid = $('.hiddenvehicleidedit').val();													
		var allformdata = new FormData($('.edituserform')[0]);
		allformdata.append('tag', 'editvehicle');
		allformdata.append('type', 'post');
		allformdata.append('userid', userid);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "vehicle-type-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editvehiclemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editvehiclemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editusermodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for update the fare*/
	$(document).on('click', '.editfaremanagement', function(){
		var obj = $(this);
		var id = $('.hiddenfareidedit').val();													
		var allformdata = new FormData($('.edituserform')[0]);
		allformdata.append('tag', 'editfare');
		allformdata.append('type', 'post');
		allformdata.append('id', id);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "fare-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editfaremanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editfaremanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editusermodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});

	$(document).on('click', '.addimagebtn', function(){
		var hiddenincval = $(document).find('.hiddenincval').val();											 
		$('<div class=""><div class="form-group col-md-6"> <label for="exampleInputFile col-sm-3">Upload Blog Image (Optional)</label> <input name="blogimage[]" class="showbeforeupload col-sm-9" data-inc="'+hiddenincval+'" style="float:right;" id="exampleInputFile" type="file"><p class="help-block">Upload Blog Image Here</p></div><div class="form-group col-md-6"><div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="newlogouploadclass'+hiddenincval+'" style="width:100%; display:none;"></div><div class="addimagediv col-md-6" style="margin-top:20px;"><button class="btn btn-primary addimagebtn" type="button"><i class="fa fa-plus"></i> Add Image</button></div></div></div>').insertAfter($(this).parent().parent().parent());	
	
		$(this).parent().html($('<button type="button" class="btn btn-primary deleteimagebtn"><i class="fa fa-times"></i> Delete Image</button>'));
		var newhiddenincval = parseInt(hiddenincval) + parseInt(1);
		$(document).find('.hiddenincval').val(newhiddenincval);
	});
	
	$(document).on('click', '.deleteimagebtn', function(){
		$(this).parent().parent().parent().remove();													
	});
	
	/*for inserting the user data*/
	$(document).on('click', '.saveblogmanagement', function(){
		var allformdata = new FormData($('.blogmanagementform')[0]);
		var descen = CKEDITOR.instances.editor1.getData();
		var descfr = CKEDITOR.instances.editor2.getData();
		var shortdescen = CKEDITOR.instances.editor3.getData();
		var shortdescfr = CKEDITOR.instances.editor4.getData();
		allformdata.append('descriptionen', descen);
		allformdata.append('descriptionfr', descfr);
		allformdata.append('shortdescriptionen', shortdescen);
		allformdata.append('shortdescriptionfr', shortdescfr);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savelogomanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveblogmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveservicemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		var descen = CKEDITOR.instances.editor1.getData();
		var descfr = CKEDITOR.instances.editor2.getData();
		
		var shortdescen = CKEDITOR.instances.editor3.getData();
		var shortdescfr = CKEDITOR.instances.editor4.getData();
		
		allformdata.append('descriptionen', descen);
		allformdata.append('descriptionfr', descfr);
		
		allformdata.append('shortdescriptionen', shortdescen);
		allformdata.append('shortdescriptionfr', shortdescfr);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "service-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveservicemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveservicemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveoffermanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		var desc = CKEDITOR.instances.editor1.getData();
		allformdata.append('description', desc);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "offer",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveservicemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveoffermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	
	$(document).on('click', '.savetestimonialemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		var desc = CKEDITOR.instances.editor1.getData();
		
		allformdata.append('testimonial', desc);
				
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "testimonial-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savetestimonialemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savetestimonialemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveresourcemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		var descen = CKEDITOR.instances.editor1.getData();
		var descfr = CKEDITOR.instances.editor2.getData();
		
		allformdata.append('texten', descen);
		allformdata.append('textfr', descfr);
				
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "resource-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveresourcemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveresourcemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.savesubservicemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		var overview = CKEDITOR.instances.editor1.getData();
		var offerings = CKEDITOR.instances.editor2.getData();
		var specialization = CKEDITOR.instances.editor3.getData();
		
		allformdata.append('overview', overview);
		allformdata.append('offerings', offerings);
		allformdata.append('specialization', specialization);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "sub-service-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savesubservicemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savesubservicemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.savefaqtopicrvicemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-topic-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savefaqtopicrvicemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savefaqtopicrvicemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveratesemanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "rates-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveratesmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveratesemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveblogtopicmanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-category-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveblogtopicmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveblogtopicmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.saveblogtagmanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-tag-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveblogtagmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveblogtagmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.savefaqmanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savefaqmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savefaqmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	
	$(document).on('click', '.deleteservice', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "service-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deleteoffer', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "offer",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deleteresource', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "resource-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deletetestimonial', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "testimonial-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deletefaqtopic', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "faq-topic-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	
	
	$(document).on('click', '.deleteblogcategory', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "blog-category-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deleteblogtag', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "blog-tag-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('click', '.deletefaq', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "faq-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});
	
	$(document).on('change', '.showbeforeupload', function() {
		var incid = $(this).data('inc');
    	filePreview(this, 'newlogouploadclass'+incid);
	});
	
	$(document).on('click', '.blogimagedetails', function(){
		var obj = $(this);
		var blogid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: { 
					'tag' : 'fetchimage',
					'blogid' : blogid ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					var data = responce.data;
					var html = '';
					if(data.length != 0) {
						html += '<div id="myCarousel" class="carousel slide" data-ride="carousel"> <ol class="carousel-indicators">';
						$(data).each(function(index,value) {
							if(index==0) { var activeclass = 'active'; } else { var activeclass = ''; }
  							html += '<li data-target="#myCarousel" data-slide-to="'+index+'" class="'+activeclass+'"></li>';	
						});
						html +='</ol><div class="carousel-inner">';
						$(data).each(function(index,value) {
							if(index==0) { var activeclass = 'active'; } else { var activeclass = ''; }
  							html += '<div class="item '+activeclass+'"> <img style="width:100%; height:auto;" src="'+value+'" alt="Chicago"> </div>';	
						});
						html +='</div><a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a> </div>';
					}
					$(document).find('.silderbody').html(html);
					$('#modalforlogoenlarger').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.descdetails', function(){
		var obj = $(this);
		var blogid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: { 
					'tag' : 'fetchdescription',
					'blogid' : blogid ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					var data = responce.data;
					$(document).find('.descbody').html(data);
					$('#modalforblogdesc').modal('show');
				}
			}
		});
	});
	
	/*for change the blog status*/
	$(document).on('click', '.changeblogstatus', function(){
		var obj = $(this);
		var blogid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: { 
					'tag' : 'statuschange', 
					'blogid' : blogid 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changeservicestatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "service-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changeofferstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "offer",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changefaqtopicstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-topic-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changeblogcategorystatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-category-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changeblogtagstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-tag-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changefaqstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changetestimonialstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "testimonial-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	$(document).on('click', '.changeresourcestatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "resource-management",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	/*for change the user status*/
	$(document).on('click', '.changeuserstatus', function(){
		if (confirm("Are you sure?")) {
			var obj = $(this);
			var userid = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "user-management",
				data: { 
						'tag' : 'statuschange', 
						'userid' : userid 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						if(responce.data == 1) { 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
						if(responce.data == 0) { 
							obj.children().first().removeClass('fa-thumbs-o-up');
							obj.children().first().addClass('fa-thumbs-o-down');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
					}
				}
			});
		}
		else {
			return false;	
		}
	});
	
	/*for change the vehicle status*/
	$(document).on('click', '.changevehiclestatus', function(){
		if (confirm("Are you sure?")) {
			var obj = $(this);
			var userid = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "vehicle-type-management",
				data: { 
						'tag' : 'statuschange', 
						'vehicleid' : userid 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						if(responce.data == 1) { 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
						if(responce.data == 0) { 
							obj.children().first().removeClass('fa-thumbs-o-up');
							obj.children().first().addClass('fa-thumbs-o-down');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
					}
				}
			});
		}
		else {
			return false;	
		}
	});
	
	/*for change the vehicle status*/
	$(document).on('click', '.changefarestatus', function(){
		if (confirm("Are you sure?")) {
			var obj = $(this);
			var userid = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "fare-management",
				data: { 
						'tag' : 'statuschange', 
						'id' : userid 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						if(responce.data == 1) { 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
						if(responce.data == 0) { 
							obj.children().first().removeClass('fa-thumbs-o-up');
							obj.children().first().addClass('fa-thumbs-o-down');
							$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						}
					}
				}
			});
		}
		else {
			return false;	
		}
	});
	
	/*for delete the content already assgined*/
	$(document).on('click', '.deletecontent', function(){
		if (confirm("Are you sure?")) {
			var url = $(this).data('url');
			window.location.href = url;
		}
		else {
			return false;	
		}
	});
	
	/*for delete the blog*/
	$(document).on('click', '.deleteblog', function(){
		var obj = $(this);
		var blogid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: { 
					'tag' : 'deleteblog', 
					'blogid' : blogid 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 1000);
				}
			}
		});
	});
	
	/*for edit blog details data fetch*/
	$(document).on('click', '.editblogdetails', function(){
		var obj = $(this);
		var blogid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: { 
					'tag' : 'editblog',
					'type' : 'get',
					'blogid' : blogid ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					var html = '';
					
					html += '<img src="'+data.imagename+'" width="100px" height="100px" />';
					
					$(document).find('.hiddeneditblogid').val(data.id);
					$(document).find('.currentimages').html(html);
					
					$(document).find('.edittitleen').val(data.titleen);
					$(document).find('.edittitlefr').val(data.titlefr);
					$(document).find('.editcategory').val(data.category);
					
					/*var splittag = data.blogtag.split(',');
					$(splittag).each(function(i,v){
											  
					});*/
					//$(document).find('.editblogtag').val(data.blogtag);
					
					CKEDITOR.instances['editor5'].setData(data.descriptionen);
					CKEDITOR.instances['editor6'].setData(data.descriptionfr);
					CKEDITOR.instances['editor7'].setData(data.shortdescriptionen);
					CKEDITOR.instances['editor8'].setData(data.shortdescriptionfr);
					$('#editblogmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editservicedetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "service-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.blueimageblock').html('<img src="'+data.blueimage+'" class="img-responsive">');
					$(document).find('.blackimageblock').html('<img src="'+data.blackimage+'" class="img-responsive">');
					
					$(document).find('.edittitleen').val(data.titleen);
					$(document).find('.edittitlefr').val(data.titlefr);
					$(document).find('.hiddenid').val(data.id);
					CKEDITOR.instances['editor5'].setData(data.descriptionen);
					CKEDITOR.instances['editor6'].setData(data.descriptionfr);
					CKEDITOR.instances['editor7'].setData(data.shortdescriptionen);
					CKEDITOR.instances['editor8'].setData(data.shortdescriptionfr);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editofferdetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "offer",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.blueimageblock').html('<img src="'+data.imagepath+'" class="img-responsive">');
					
					
					$(document).find('.edittitle').val(data.title);
					$(document).find('.hiddenid').val(data.id);
					CKEDITOR.instances['editor2'].setData(data.description);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.edittestimonialdetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "testimonial-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;

					$(document).find('.editname').val(responce.data.name);
					$(document).find('.hiddenid').val(responce.data.id);
					CKEDITOR.instances['editor2'].setData(responce.data.testimonial);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editresourcedetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "resource-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;

					$(document).find('.editimage').attr('src', responce.data.image);					
					$(document).find('.edittitleen').val(responce.data.titleen);
					$(document).find('.edittitlefr').val(responce.data.titlefr);
					$(document).find('.editcategoryen').val(responce.data.categoryen);
					$(document).find('.editcategoryfr').val(responce.data.categoryfr);
					$(document).find('.editurl').val(responce.data.url);
					$(document).find('.hiddenid').val(responce.data.id);
					CKEDITOR.instances['editor3'].setData(responce.data.texten);
					CKEDITOR.instances['editor4'].setData(responce.data.textfr);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editsubservicedetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "sub-service-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.edittitleen').val(data.title);
					$(document).find('.hiddenid').val(data.id);
					CKEDITOR.instances['editor2'].setData(data.description);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editfaqtitledetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-topic-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.edittitleen').val(data.titleen);
					$(document).find('.edittitlefr').val(data.titlefr);
					$(document).find('.hiddenid').val(data.id);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editblogcategorydetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-category-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.edittitleen').val(data.titleen);
					$(document).find('.edittitlefr').val(data.titlefr);
					$(document).find('.hiddenid').val(data.id);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editblogtagdetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-tag-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.edittitleen').val(data.titleen);
					$(document).find('.edittitlefr').val(data.titlefr);
					$(document).find('.hiddenid').val(data.id);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.editfaqdetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-management",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.editopic').val(data.topic);
					$(document).find('.editquestionen').val(data.questionen);
					$(document).find('.editquestionfr').val(data.questionfr);
					$(document).find('.editansweren').val(data.answeren);
					$(document).find('.editanswerfr').val(data.answerfr);
					$(document).find('.hiddenid').val(data.id);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
	$(document).on('click', '.deleteblogimage', function(){
		$(this).parent().parent().remove();													 
	});
	
	$(document).on('click', '.deleteserviceimage', function(){
		$(this).parent().parent().remove();													 
	});
	
	/*for update the blog*/
	$(document).on('click', '.editblogmanagement', function(){
		var obj = $(this);
		var blogid = $('.hiddeneditblogid').val();													
		var allformdata = new FormData($('.editblogform')[0]);
		
		allformdata.append('descriptionen', CKEDITOR.instances.editor5.getData());
		allformdata.append('descriptionfr', CKEDITOR.instances.editor6.getData());
		allformdata.append('shortdescriptionen', CKEDITOR.instances.editor7.getData());
		allformdata.append('shortdescriptionfr', CKEDITOR.instances.editor8.getData());
		
		allformdata.append('tag', 'editblog');
		allformdata.append('type', 'post');
		allformdata.append('blogid', blogid);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editusermanagement').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editblogmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editblogmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editservicemanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		var descen = CKEDITOR.instances.editor5.getData();
		var descfr = CKEDITOR.instances.editor6.getData();
		
		var shortdescen = CKEDITOR.instances.editor7.getData();
		var shortdescfr = CKEDITOR.instances.editor8.getData();
		
		allformdata.append('descriptionen', descen);
		allformdata.append('descriptionfr', descfr);
		
		allformdata.append('shortdescriptionen', shortdescen);
		allformdata.append('shortdescriptionfr', shortdescfr);													
				
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "service-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editservicemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editoffermanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		var desc = CKEDITOR.instances.editor2.getData();
		allformdata.append('description', desc);
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "offer/",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editoffermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.edittestimonialmanagementupdate', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		var desc = CKEDITOR.instances.editor2.getData();
		allformdata.append('testimonial', desc);
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "testimonial-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editoffermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});

	
	$(document).on('click', '.editresourcemanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		var testimonialen = CKEDITOR.instances.editor3.getData();
		var testimonialfr = CKEDITOR.instances.editor4.getData();
		
		allformdata.append('texten', testimonialen);
		allformdata.append('textfr', testimonialfr);
				
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "resource-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editresourcemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editsubservicemanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		var desc = CKEDITOR.instances.editor2.getData();
		
		allformdata.append('description', desc);
		
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "sub-service-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editsubservicemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editfaqtopicmanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-topic-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editfaqtopicmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editblogcategorymanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-category-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editblogcategorymanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editblogtagmanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "blog-tag-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editblogtagmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.editfaqmanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "faq-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();*/
			},
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editfaqmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	$(document).on('click', '.updateadminprofile', function(){
		var allformdata = new FormData($('.adminprofile')[0]);
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "profile",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.updateadminprofile').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateadminprofile').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	$(document).on('click', '.updatesitemanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "site-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updatesitemanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	$(document).on('click', '.updateaboutmanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);
		var longtext = CKEDITOR.instances.editor1.getData();
		allformdata.append('texten', longtext);
		var shorttext = CKEDITOR.instances.editor2.getData();
		allformdata.append('textfr', shorttext);
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "about-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateaboutmanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	$(document).on('click', '.updateprocessmanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);

		allformdata.append('one', CKEDITOR.instances.editor1.getData());
		allformdata.append('two', CKEDITOR.instances.editor2.getData());
		allformdata.append('three', CKEDITOR.instances.editor3.getData());
		allformdata.append('four', CKEDITOR.instances.editor4.getData());
		allformdata.append('five', CKEDITOR.instances.editor5.getData());
		allformdata.append('six', CKEDITOR.instances.editor6.getData());
		allformdata.append('seven', CKEDITOR.instances.editor7.getData());
		allformdata.append('eight', CKEDITOR.instances.editor8.getData());
		allformdata.append('nine', CKEDITOR.instances.editor9.getData());
		allformdata.append('ten', CKEDITOR.instances.editor10.getData());
		allformdata.append('eleven', CKEDITOR.instances.editor11.getData());
		allformdata.append('twelve', CKEDITOR.instances.editor12.getData());
		allformdata.append('thirteen', CKEDITOR.instances.editor13.getData());
		allformdata.append('fourteen', CKEDITOR.instances.editor14.getData());
		allformdata.append('fifteen', CKEDITOR.instances.editor15.getData());
		allformdata.append('sixteen', CKEDITOR.instances.editor16.getData());
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "process-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateprocessmanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	
	$(document).on('click', '.updatehomeoagecontent', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);

		allformdata.append('one', CKEDITOR.instances.editor1.getData());
		allformdata.append('two', CKEDITOR.instances.editor2.getData());
		allformdata.append('three', CKEDITOR.instances.editor3.getData());
				
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "homepagemanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updatehomeoagecontent').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	
	$(document).on('click', '.updatetermsmanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);
		var longtext = CKEDITOR.instances.editor1.getData();
		allformdata.append('texten', longtext);
		var shorttext = CKEDITOR.instances.editor2.getData();
		allformdata.append('textfr', shorttext);
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "terms-and-conditions",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updatetermsmanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	
	$(document).on('click', '.updateprivacymanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);
		var longtext = CKEDITOR.instances.editor1.getData();
		allformdata.append('texten', longtext);
		var shorttext = CKEDITOR.instances.editor2.getData();
		allformdata.append('textfr', shorttext);
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "privacy-policy-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateprivacymanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
	/*for adding category*/
	$(document).on('click', '.savecategorymanagement', function(){
		var allformdata = new FormData($('.categorymanagementform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "category-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savecategorymanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savecategorymanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for change the category status*/
	$(document).on('click', '.changecategorystatus', function(){
		var obj = $(this);
		var categoryid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "category-management",
			data: { 
					'tag' : 'statuschange', 
					'categoryid' : categoryid 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	/*for update the category*/
	$(document).on('click', '.editcategorydetails', function(){
		var obj = $(this);
		var categoryid = $(this).data('id');
		$(this).parent().prev().children().first().attr('disabled', false);
		$(this).parent().prev().prev().children().first().attr('disabled', false);
		$('<span class="saveeditedcategorydetails pointer" title="Edit Category Details" data-id="'+categoryid+'"><i class="fa fa-check fa-2x" style="color:#00CC00;"></i></span><span class="canceleditcategorydetails pointer" title="Edit Category Details" data-id="'+categoryid+'"><i class="fa fa-times fa-2x" style="color:#f00;"></i></span>').insertAfter(obj);
		$(this).hide();
	});
	
	$(document).on('click', '.canceleditcategorydetails', function(){
		$(this).prev().hide();
		$(this).prev().prev().show();
		$(this).parent().prev().children().first().attr('disabled', true);
		$(this).parent().prev().prev().children().first().attr('disabled', true);
		$(this).hide();
	});
	
	$(document).on('click', '.saveeditedcategorydetails', function(){
		var obj = $(this);
		var categoryid = $(this).data('id');
		var parent = $(this).parent().prev().children().first().val();
		var title = $(this).parent().prev().prev().children().first().val();
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "category-management",
			data: { 
					'tag' : 'editcategory',
					'categoryid' : categoryid,
					'title' : title,
					'parent' : parent
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});
		
	});
	
	
	/*for adding attribute*/
	$(document).on('click', '.saveattributemanagement', function(){
		var allformdata = new FormData($('.attributemanagementform')[0]);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "attribute-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveattributemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveattributemanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for change the attribute status*/
	$(document).on('click', '.changeattributestatus', function(){
		var obj = $(this);
		var attributeid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "attribute-management",
			data: { 
					'tag' : 'statuschange', 
					'attributeid' : attributeid 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});
	
	/*for update the attribute*/
	$(document).on('click', '.editattributedetails', function(){
		var obj = $(this);
		var attributeid = $(this).data('id');
		$(this).parent().prev().children().first().attr('disabled', false);
		$(this).parent().prev().prev().children().first().attr('disabled', false);
		$('<span class="saveeditedattributedetails pointer" title="Edit Attribute Details" data-id="'+attributeid+'"><i class="fa fa-check fa-2x" style="color:#00CC00;"></i></span><span class="canceleditattributedetails pointer" title="Edit Attribute Details" data-id="'+attributeid+'"><i class="fa fa-times fa-2x" style="color:#f00;"></i></span>').insertAfter(obj);
		$(this).hide();
	});
	
	$(document).on('click', '.canceleditattributedetails', function(){
		$(this).prev().hide();
		$(this).prev().prev().show();
		$(this).parent().prev().children().first().attr('disabled', true);
		$(this).parent().prev().prev().children().first().attr('disabled', true);
		$(this).hide();
	});
	
	$(document).on('click', '.saveeditedattributedetails', function(){
		var obj = $(this);
		var attributeid = $(this).data('id');
		var parent = $(this).parent().prev().children().first().val();
		var title = $(this).parent().prev().prev().children().first().val();
		
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "attribute-management",
			data: { 
					'tag' : 'editattribute',
					'attributeid' : attributeid,
					'title' : title,
					'parent' : parent
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});
		
	});
	
	$(document).on('change', '.parentattribute', function(){
		var obj = $(this);												  
		var attributeid = $(this).val();
		if(attributeid !== 'Choose Product Attribute') {
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "add-product",
				data: { 
						'tag' : 'getchild',
						'attributeid' : attributeid,
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						var html = '';
						var data = responce.data;
						if(data.length != 0) {
							html += '<div class="col-md-3">Product Child Attribute</div><div class="col-md-9 form-group">';
							html += '<select class="form-control childattribute" name="childattribute[]" multiple="multiple">';	
							$(data).each(function(index, val){
								html += '<option value="'+val.id+'">'+val.title+'</option>';
							});
							html += '</select></div><div class="clearfix"></div>';
						}
						obj.parent().next().next().html(html);
						$(document).find('.childattribute').select2();
					}
				}
			});
		}
		else {
			obj.parent().next().next().html('');	
		}
	});
	
	$(document).on('click', '.addattribute', function(){
		$(attrblockhtml).insertBefore($(this).parent());										 
    });
	
	
	$(document).on('click', '.addproductbtn', function(){
		var allformdata = new FormData($('.addproductform')[0]);
		var desc = CKEDITOR.instances.editor1.getData();
		allformdata.append('description', desc);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "add-product",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.addproductbtn').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveblogmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ window.location.href = BASEURL + 'product-management' }, 2000);
				}
			}
		});											 
	});
	
	/*for banner insert*/
	$(document).on('click', '.savebannermanagement', function(){
		var allformdata = new FormData($('.bannermanagementform')[0]);
		var descen = CKEDITOR.instances.editor1.getData();
		allformdata.append('texten', descen);
		var descfr = CKEDITOR.instances.editor2.getData();
		allformdata.append('textfr', descfr);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "banner-management",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.savebannermanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.savebannermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for banner details image*/
	$(document).on('click', '.bannerdetails', function(){
		var imageurl = $(this).prev().attr('src');
		$(document).find('#modalimageid').attr('src', imageurl);
		$('#modalforbannerenlarger').modal('show');
	});
	
	/*for edit banner details data fetch*/
	$(document).on('click', '.editbannerdetails', function(){
		var bannerid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "bannermanagementfetchdatabyid/"+bannerid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					CKEDITOR.instances['editor3'].setData(responce.data.texten);
					CKEDITOR.instances['editor4'].setData(responce.data.textfr);
					$(document).find('.showbannerinmodalforedit').attr('src', BANNER_UPLOAD_URL+responce.data.imagename);
					$(document).find('.hiddeneditbannerid').val(bannerid);
					$('.editpage').val(responce.data.page);
					$('#editbannermodal').modal('show');
				}
			}
		});
	});
	
	$(".bannerimageuploadforedit").change(function () {
    	filePreview(this, 'showbannerinmodalforedit');
	});
	
	$(".bannerimageuploadforedit2").change(function () {
    	filePreview(this, 'showbannerinmodalforedit2');
	});
	
	
	$(".uploadnewbanneruploader").change(function () {
    	filePreview(this, 'newbanneruploadclass');
	});
		
	/*for update the banner*/
	$(document).on('click', '.editbannermanagement', function(){
		var allformdata = new FormData($('.editbannerform')[0]);
		var desc = CKEDITOR.instances.editor2.getData();
		allformdata.append('description', desc);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "updatebannermanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editbannermanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editbannermanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editbannermodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
	/*for change the banner status*/
	$(document).on('click', '.changebannerstatus', function(){
		var obj = $(this);
		var bannerid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "bannermanagementchangestatus/"+bannerid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						/*$(document).find('.statusicon').removeClass('fa-thumbs-o-up');
						$(document).find('.statusicon').addClass('fa-thumbs-o-down');*/
						setTimeout(function(){ 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
						}, 1000);
						setTimeout(function(){ $.toaster({ priority : 'success', title : 'Success', message : responce.msg}) }, 1000);
					}
					if(responce.data == 0) { 
						setTimeout(function(){ 
							obj.children().first().removeClass('fa-thumbs-o-up');
							obj.children().first().addClass('fa-thumbs-o-down');
						}, 1000);
						setTimeout(function(){ $.toaster({ priority : 'success', title : 'Success', message : responce.msg}) }, 1000);
					}
				}
			}
		});
	});
	
	/*for change the banner status*/
	$(document).on('click', '.changecustomerstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "customermanagement/",
			data: { 
					'tag' : 'getchild',
					'attributeid' : attributeid,
				  },
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						/*$(document).find('.statusicon').removeClass('fa-thumbs-o-up');
						$(document).find('.statusicon').addClass('fa-thumbs-o-down');*/
						setTimeout(function(){ 
							obj.children().first().removeClass('fa-thumbs-o-down');
							obj.children().first().addClass('fa-thumbs-o-up');
						}, 1000);
						setTimeout(function(){ $.toaster({ priority : 'success', title : 'Success', message : responce.msg}) }, 1000);
					}
					if(responce.data == 0) { 
						setTimeout(function(){ 
							obj.children().first().removeClass('fa-thumbs-o-up');
							obj.children().first().addClass('fa-thumbs-o-down');
						}, 1000);
						setTimeout(function(){ $.toaster({ priority : 'success', title : 'Success', message : responce.msg}) }, 1000);
					}
				}
			}
		});
	});
	
	/*for delete the banner*/
	$(document).on('click', '.deletebanner', function(){
		var obj = $(this);
		var bannerid = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "bannermanagementdelete/"+bannerid,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 1000);
				}
			}
		});
	});
	
	
	$(document).on('change', '.parentservice', function(){
		var id = $(this).val();
		if(id != '') {
			$(document).find('.subservice').val('');
			$(document).find('.hiddenoption').hide();
			$(document).find('.showoption'+id).show();
		} else {
			$.toaster({ priority : 'error', title : 'Error', message : 'Please choose a service'});
		}
	});
	
	
	$(document).on('click', '.viewidentity', function(){
		var obj = $(this);
		var id = $(this).data('val');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "admin/identitydocumentview/"+id,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				$(document).find('#modalimageid').attr('src', response.imagename);
				$(document).find('#modalforlogoenlarger').modal('show');
			}
		});
	});	
	
	$(document).on('click', '.approveidentity', function(){
		var obj = $(this);
		var id = $(this).data('val');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "admin/approveidentity/"+id,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				$.toaster({ priority : 'success', title : 'Success', message : response.msg});
				setTimeout(function(){ location.reload(); }, 1000);
			}
		});
	});
	
	$(document).on('click', '.declineidentity', function(){
		var obj = $(this);
		var id = $(this).data('val');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "admin/declineidentity/"+id,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			success: function(response) {
				$.toaster({ priority : 'success', title : 'Success', message : response.msg});
				setTimeout(function(){ location.reload(); }, 1000);
			}
		});
	});
	
	
	$(document).on('click', '.updateseomanage', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "seomanagementupdate",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.updateseomanage').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateseomanage').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});
	
		$(document).on('click', '.saveprojectmanagement', function(){
		var allformdata = new FormData($('.managementform')[0]);
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "projectmanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveprojectmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveprojectmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
		$(document).on('click', '.changeprojectstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "projectmanagement",
			data: { 
					'tag' : 'statuschange', 
					'id' : id 
				  }, 
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {
					if(responce.data == 1) { 
						obj.children().first().removeClass('fa-thumbs-o-down');
						obj.children().first().addClass('fa-thumbs-o-up');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
					if(responce.data == 0) { 
						obj.children().first().removeClass('fa-thumbs-o-up');
						obj.children().first().addClass('fa-thumbs-o-down');
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					}
				}
			}
		});
	});


    	$(document).on('click', '.editprojectdetails', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "projectmanagement",
			data: { 
					'tag' : 'edit',
					'type' : 'get',
					'id' : id ,
				},
			dataType: "json",
			success: function(responce) {
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
				} else {					
					var data = responce.data;
					
					$(document).find('.previewimage2').attr('src', data.imagepath);
					
					$(document).find('.edittitle').val(data.title);
					$(document).find('.edittype').val(data.type);
					$(document).find('.editunit').val(data.unit);
					$(document).find('.editprice').val(data.price);
					$(document).find('.hiddenid').val(data.id);
					$('#editmodal').modal('show');
				}
			}
		});
	});
	
		$(document).on('click', '.editprojectmanagement', function(){
		var obj = $(this);
		var allformdata = new FormData($('.editmanagementform')[0]);
		allformdata.append('tag', 'edit');
		allformdata.append('type', 'post');
		
		
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "projectmanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editprojectmanagement').hide();*/
			},
			success: function(responce) {
				
				/*$(document).find('.ajaxloadingmodal').hide();*/
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.editprojectmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){$('#editmodal').modal('hide') }, 2000);
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});
	
		$(document).on('click', '.updateprojectpagecontent', function(){
		var allformdata = new FormData($('.sitemanageform')[0]);

		allformdata.append('two', CKEDITOR.instances.editor1.getData());
				
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "projectpage",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				/*$(document).find('.ajaxloading').show();
				$(document).find('.updatesitemanage').hide();*/
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.updateprojectpagecontent').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 														
	});

	$(document).on('click', '.deleteproject', function(){
		if (confirm("Are you sure you want to delete?")) {											
			var obj = $(this);
			var id = $(this).data('id');
			jQuery.ajax({
				type: "POST",
				url: BASEURL + "project-management",
				data: { 
						'tag' : 'delete', 
						'id' : id 
					  }, 
				dataType: "json",
				success: function(responce) {
					var error = responce.error;
					var success = responce.success;
					if (success === 0) {
						$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					} else {
						$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
						setTimeout(function(){ location.reload(); }, 1000);
					}
				}
			});
		}
		else { return false; }
	});




	
});

function getcurrentdatetime() {
	var currentdate = new Date(); 
    var datetime = "Now: " + currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();

	alert(datetime);
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

/*for multiple image preview*/
function imagesPreview (input, placeToInsertImagePreview) {
	if (input.files) {
		var filesAmount = input.files.length;
		for (i = 0; i < filesAmount; i++) {
			var reader = new FileReader();
			reader.onload = function(event) {
				var html = '';
				html += '<div class="col-md-3">';
				html += '<img class="multipleimagepreviewclass" src="'+event.target.result+'">';
				html += '</div>';
				$(html).appendTo(placeToInsertImagePreview);
			}
		reader.readAsDataURL(input.files[i]);
		}
	}
};

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

$(document).ready(function(){
"use strict";
/*for initializing the datatable*/
$('#example1').DataTable();
/*for initializing the ck editor*/
CKEDITOR.replace('editor1');
CKEDITOR.replace('editor2');
CKEDITOR.replace('editor3');
CKEDITOR.replace('editor4');
CKEDITOR.replace('editor5');
CKEDITOR.replace('editor6');
CKEDITOR.replace('editor7');
CKEDITOR.replace('editor8');
CKEDITOR.replace('editor9');
CKEDITOR.replace('editor10');
CKEDITOR.replace('editor11');
CKEDITOR.replace('editor12');
CKEDITOR.replace('editor13');
CKEDITOR.replace('editor14');
CKEDITOR.replace('editor15');
CKEDITOR.replace('editor16');
//Timepicker
/*$('.timepicker').timepicker({
	explicitMode:'true',
	minuteStep: 1,
});*/
});