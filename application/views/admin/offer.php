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
    <h1> What We Offer <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">What We Offer</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-cogs"></i>
            <h3 class="box-title">What We Offer</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Offer</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="managementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Offer Title <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="Offer Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Offer Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor1" name="description" rows="10" cols="30"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Offer Icon </label>
                      <input name="imageblue" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Offer Icon Here</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage1" style="width:100%; display:none;" /> </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveoffermanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo base_url().'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
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
                    <th>Offer Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php if($val['imagename'] != '') { ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo base_url().SERVICE_UPLOAD_URL.$val['imagename'];?>" /><span title="Enlarge The Logo" class="logodetails" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span>
                      <?php } ?></td>
                    <td><?php echo $val['title'];?></td>
                    <td><?php echo $val['description'];?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeofferstatus pointer" title="Change Offer Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeofferstatus pointer" title="Change Offer Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editofferdetails pointer" title="Edit Offer Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteoffer pointer" title="Delete Offer" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
    <div class="modal-content" style="text-align:center;"> <img src="" id="modalimageid" class="img-responsive" width="100%" /> </div>
  </div>
</div>

<!--modal for edit the logo details-->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Service details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
    	<form class="editmanagementform" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-12">
                <label for="inputEmail3" class="col-sm-3 control-label">Offer Title <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="title" class="form-control edittitle" id="inputEmail3" placeholder="Offer Title">
                </div>
              </div>
              <div class="form-group col-md-12">
                <label for="inputEmail3" class="col-sm-3 control-label">Offer Description <span class="required">*</span></label>
                <div class="col-sm-9">
                  <textarea id="editor2" name="description" class="editdescription" rows="10" cols="30">blank</textarea>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
              <div class="">
                <div class="form-group col-md-4">
                  <label for="exampleInputFile col-sm-3">Upload Offer Icon </label>
                  <input name="imageblue" class="imageuploader3 col-sm-9" data-inc="1" style="float:left; width:100%;" id="exampleInputFile" type="file">
                  <p class="help-block">Upload Offer Icon Here</p>
                </div>
                <div class="form-group col-md-4">
                  <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage3" style="width:100%; display:none;" /> </div>
                </div>
                <div class="form-group col-md-4 blueimageblock"></div>
              </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="checkbox">
              <input type="hidden" name="id" class="hiddenid" />
              <button type="button" class="btn btn-primary pull-right editoffermanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
              <div class="ajaxloading"><img src="<?php echo base_url().'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
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
