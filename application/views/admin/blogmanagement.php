<!-- Content Wrapper. Contains page content -->
<style>
.colorccc {
	color:#999;
}
.logodetails {
	float:right;
	cursor:pointer;
}
.pointer {
	margin-right:15px;
}
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Blog Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Blog Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-cogs"></i>
            <h3 class="box-title">Blog Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Blog</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="blogmanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Title<span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titleen" class="form-control" id="inputEmail3" placeholder="Blog Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Title <strong>(FR)</strong><span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titlefr" class="form-control" value="shdgvhg" id="inputEmail3" placeholder="Blog Title French">
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-bottom:15px;">
                  	<label class="control-label col-md-3">Blog Category <span class="required">*</span></label>
                    <div class="col-md-9 row">
                    <select class="form-control" name="category" style="margin-left:15px;">
                    	<option value="">Choose</option>
                        <?php foreach($category as $key => $val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['titleen']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-6" style="margin-bottom:15px; padding-right:15px; display:none;">
                  	<label class="control-label col-md-3">Blog Tag</label>
                    <select class="form-control" name="blogtag[]" multiple="multiple" style="margin-right:15px;">
                        <?php foreach($tag as $key => $val) { ?>
                        <option selected value="<?php echo $val['id']; ?>"><?php echo $val['titleen']; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor1" name="descriptionen" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor2" name="descriptionfr" rows="10" cols="80">ghsvhgvs</textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Short Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor3" name="descriptionshorten" rows="10" cols="80">sghdvs</textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Short Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor4" name="descriptionshortfr" rows="10" cols="80">hjsdsdvs</textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Blog Image </label>
                      <input name="blogimage[]" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Blog Image Here</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> 
                      	<img src="" class="previewimage1" style="width:100%; display:none;" /> 
                      </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveblogmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
                  <div class="errormsg alert alert-danger" style="display:none;"></div>
                  <div class="successmsg alert alert-success" style="display:none;"></div>
                </div>
              </div>
            </form>
            <input type="hidden" class="hiddenincval" value="2" />
            <!--Upload logo part ends here-->
          </div>
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Service</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Image</th>
                    <th>Title</th>
                    <!--<th>Title (FR)</th>-->
                    <th>Category</th>
                    <!--<th>Tag</th>-->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($blog as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php $imagenames = $val['imagename']; ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo ASSETS_URL.BLOG_IMAGE_UPLOAD_URL.$imagenames;?>" />
                      <span title="Enlarge The Logo" style="float:right" class="blogimagedetails onlypointer" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span> &nbsp; &nbsp;
                      </td>
                    <td><?php echo $val['titleen'];?></td>
                    <!--<td><?php //echo $val['titlefr']; ?></td>-->
                    <td><?php $cat = $this->db->get_where('blogcategory', array('id'=>$val['category']))->row_array(); echo $cat['titleen']; ?></td>
                    <!--<td><?php //$seg = explode(',',$val['tag']); foreach($seg as $i=>$v) { $tag1 = ''; $tag1 = $this->db->get_where('blogtag', array('id'=>$v))->row_array(); echo $tag1['titleen'].' ';  } ?></td>-->
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeblogstatus pointer" title="Change User Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeblogstatus pointer" title="Change blog Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editblogdetails pointer" title="Edit blog Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteblog pointer" title="Delete blog" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
                  </tr>
                  <?php } ?>
                  </tfoot>
                  
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--modal for enlarge the image-->
<div class="modal fade" id="modalforlogoenlarger" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="silderbody"></div>
    </div>
  </div>
</div>
<!--modal for edit the logo details-->
<div class="modal fade" id="editblogmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Service details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="editblogform" enctype="multipart/form-data">
            <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Title<span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titleen" class="form-control edittitleen" id="inputEmail3" placeholder="Blog Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Title <strong>(FR)</strong><span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titlefr" class="form-control edittitlefr" id="inputEmail3" placeholder="Blog Title French">
                    </div>
                  </div>
                  <div class="col-md-12" style="margin-bottom:15px;">
                  	<label class="control-label col-md-3">Blog Category</label>
                    <div class="col-md-9 row">
                    <select class="form-control editcategory" name="category" style="margin-left:15px;">
                    	<option value="">Choose</option>
                        <?php foreach($category as $key => $val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['titleen']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="col-md-6" style="margin-bottom:15px; padding-right:15px; display:none;">
                  	<label class="control-label col-md-3">Blog Tag</label>
                    <select class="form-control editblogtag" name="blogtag[]" multiple="multiple" style="margin-right:15px;">
                        <?php foreach($tag as $key => $val1) { ?>
                        <option value="<?php //echo $val1['id']; ?>"><?php echo $val1['titleen']; ?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor5" name="descriptionen" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor6" name="descriptionfr" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Short Description <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor7" name="shortdescriptionen" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12" style="display:none;">
                    <label for="inputEmail3" class="col-sm-3 control-label">Blog Short Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor8" name="shortdescriptionfr" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                  <div class="col-md-12 currentimages"></div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Blog Image </label>
                      <input name="blogimage[]" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Blog Image Here</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> 
                      	<img src="" class="previewimage1" style="width:100%; display:none;" /> 
                      </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
              	<input type="hidden" class="hiddeneditblogid" />
                <button type="button" class="btn btn-primary pull-right editblogmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                <div class="ajaxloading"><img src="<?php echo base_url('assets/images/ajaxloading.gif');?>" class="ajaxloadingimage" /></div>
                <div class="errormsg alert alert-danger" style="display:none;"></div>
                <div class="successmsg alert alert-success" style="display:none;"></div>
              </div>
              </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--modal for details text of the blog description-->
<div class="modal fade" id="modalforblogdesc" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="descbody" style="padding:20px;"></div>
    </div>
  </div>
</div>
