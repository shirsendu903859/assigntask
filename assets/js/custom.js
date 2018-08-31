var BASEURL = $(document).find('.base_url').val();
var ASSETS_URL = $(document).find('.assets_url').val();
var LOGO_UPLOAD_URL = ASSETS_URL+'uploads/logo/';
var USER_IMAGE_UPLOAD_URL = ASSETS_URL+'uploads/user/';
var BANNER_UPLOAD_URL = ASSETS_URL+'uploads/banner/';
var attrblockhtml = $(document).find('.attrblock').html();
$(document).ready(function(){

	/*for banner insert*/
	$(document).on('click', '.saveplanmanagement', function(){
		var allformdata = new FormData($('.planmanagementform')[0]);
		var descen = CKEDITOR.instances.editor1.getData();
		allformdata.append('descriptionen', descen);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "plan/planmanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloading').show();
				$(document).find('.saveplanmanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloading').hide();
				var error = responce.error;
				var success = responce.success;
				if (success === 0) {
					$.toaster({ priority : 'error', title : 'Error', message : responce.msg});
					setTimeout(function(){ $(document).find('.saveplanmanagement').show(); }, 2000);
				} else {
					$.toaster({ priority : 'success', title : 'Success', message : responce.msg});
					setTimeout(function(){ location.reload(); }, 2000);
				}
			}
		});											 
	});

	/*for edit banner details data fetch*/
	$(document).on('click', '.editplandetails', function(){
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "plan/planmanagementfetchdatabyid/"+id,
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
					CKEDITOR.instances['editor2'].setData(responce.data.plan_details);
					$(document).find('.hiddeneditplanid').val(id);
					$('.plantitle').val(responce.data.plan_title);
					$('.plantype').val(responce.data.plan_duration);
					$('.planprice').val(responce.data.plan_price);
					$('#editmodal').modal('show');
				}
			}
		});
	});

	/*for update the banner*/
	$(document).on('click', '.editplanmanagement', function(){
		var allformdata = new FormData($('.editplanmanagementform')[0]);
		var desc = CKEDITOR.instances.editor2.getData();
		allformdata.append('descriptionen', desc);
		jQuery(".errormsg").hide();
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "plan/updateplanmanagement",
			data: allformdata,
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			dataType: "json",
			beforeSend: function() {
				$(document).find('.ajaxloadingmodal').show();
				$(document).find('.editservicemanagement').hide();
			},
			success: function(responce) {
				$(document).find('.ajaxloadingmodal').hide();
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
	
	/*for change the banner status*/
	$(document).on('click', '.changeplanstatus', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "plan/planmanagementchangestatus/"+id,
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
	$(document).on('click', '.deleteplan', function(){
		var obj = $(this);
		var id = $(this).data('id');
		jQuery.ajax({
			type: "POST",
			url: BASEURL + "plan/planmanagementdelete/"+id,
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

});