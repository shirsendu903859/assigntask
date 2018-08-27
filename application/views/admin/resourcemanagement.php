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
    <h1> Resource Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Resource Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-file-text"></i>
            <h3 class="box-title">Resource Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Resource</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="managementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Title <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titleen" class="form-control" id="inputEmail3" placeholder="Title English">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Title <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titlefr" class="form-control" id="inputEmail3" placeholder="Title French">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Category <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="categoryen" class="form-control" id="inputEmail3" placeholder="Category English">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Category <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="categoryfr" class="form-control" id="inputEmail3" placeholder="Category French">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Redirect URL <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="url" class="form-control" id="inputEmail3" placeholder="URL">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Description <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor1" name="texten" rows="10" cols="30"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor2" name="textfr" rows="10" cols="30"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Image of the Resource </label>
                      <input name="image" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Image of the Resource</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage1" style="width:100%; display:none;" /> </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveresourcemanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
              <h3 class="box-title">List of Resources</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Image</th>
                    <th>Title (EN)</th>
                    <th>Title (FR)</th>
                    <th>Category (EN)</th>
                    <th>Category (FR)</th>
                    <th>Description (EN)</th>
                    <th>Description (FR)</th>
                    <th>URL</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(!empty($data)) { foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php if($val['image'] != '') { ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo ASSETS_URL.RESOURCES_UPLOAD_URL.$val['image'];?>" /><span title="Enlarge The Image" class="logodetails" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span>
                      <?php } ?></td>
                    <td><?php echo $val['titleen'];?></td>
                    <td><?php echo $val['titlefr'];?></td>
                    <td><?php echo $val['categoryen'];?></td>
                    <td><?php echo $val['categoryfr'];?></td>
                    <td><?php echo $val['texten'];?></td>
                    <td><?php echo $val['textfr'];?></td>
                    <td><?php echo $val['url'];?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeresourcestatus pointer" title="Change Service Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeresourcestatus pointer" title="Change Service Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editresourcedetails pointer" title="Edit Service Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteresource pointer" title="Delete Service" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
                  </tr>
                  <?php } } ?>
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
    <div class="modal-content" style="text-align:center;"> <img src="" id="modalimageid" class="img-responsive" width="100%" /> </div>
  </div>
</div>

<!--modal for edit the logo details-->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Testimonial details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
    	<form class="editmanagementform" enctype="multipart/form-data">
          <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Title <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titleen" class="form-control edittitleen" id="inputEmail3" placeholder="Title English">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Title <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titlefr" class="form-control edittitlefr" id="inputEmail3" placeholder="Title French">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Category <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="categoryen" class="form-control editcategoryen" id="inputEmail3" placeholder="Category English">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Category <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="categoryfr" class="form-control editcategoryfr" id="inputEmail3" placeholder="Category French">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Redirect URL <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="url" class="form-control editurl" id="inputEmail3" placeholder="URL">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Description <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor3" name="texten" class="edittexten" rows="10" cols="30"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Description <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor4" name="textfr" class="edittextfr" rows="10" cols="30"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Image of the Resource </label>
                      <input name="image" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Image of the Resource</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage1 editimage" style="width:100%;" /> </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
                  <input type="hidden" name="id" class="hiddenid" />
                  <button type="button" class="btn btn-primary pull-right editresourcemanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
                  <div class="errormsg alert alert-danger" style="display:none;"></div>
                  <div class="successmsg alert alert-success" style="display:none;"></div>
                </div>
              </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!--modal for details text of the service description-->
<div class="modal fade" id="modalforblogdesc" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="descbody" style="padding:20px;"></div>
    </div>
  </div>
</div>

