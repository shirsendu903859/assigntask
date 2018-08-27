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
    <h1> Coupon Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Coupon Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-rss"></i>
            <h3 class="box-title">Coupon Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Coupon</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="blogmanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Coupon Title <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="Blog Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Coupon Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor1" name="description" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveblogmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo base_url('assets/images/ajaxloading.gif');?>" class="ajaxloadingimage" /></div>
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
              <h3 class="box-title">List of Coupons</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Blog Image</th>
                    <th>Blog Title</th>
                    <th>Blog Description</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php //foreach($blog as $key=>$val) { ?>
                  <!--<tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php
                        	$imagenames = $val['imagename'];
							$imagenamearray = explode(STRING_DELIMETER,$imagenames);
							$countimage = count($imagenamearray);
						?>
                      <?php if($countimage != 0 && $imagenamearray[0] != '') { ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo base_url().BLOG_IMAGE_UPLOAD_URL.$imagenamearray[0];?>" />
                      <?php if($countimage > 1) { ?>
                      <span style="float:right; margin-left:5px; margin-right:5px;"> +
                      <?php $rem = intval($countimage) - intval(1); echo $rem; ?>
                      </span>
                      <?php } ?>
                      <span title="Enlarge The Logo" style="float:right" class="blogimagedetails onlypointer" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span> &nbsp; &nbsp;
                      <?php } else { ?>
                      <img class="nouser" height="25" width="25" style="border-radius:50%" src="<?php echo base_url('assets/images/nouser.png')?>" />
                      <?php } ?></td>
                    <td><?php echo $val['title'];?></td>
                    <td><div class="col-md-10"> <?php echo  substr(stripslashes(strip_tags($val['description'])), 0, 30); ?> </div>
                      <div class="col-md-2"> <span title="Read The Full Description" class="descdetails onlypointer" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span> </div></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeblogstatus pointer" title="Change User Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeblogstatus pointer" title="Change blog Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editblogdetails pointer" title="Edit blog Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteblog pointer" title="Delete blog" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
                  </tr>-->
                  <?php //} ?>
                  </tbody>
                  
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
        <h4 class="modal-title">Edit the blog details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="editblogform" enctype="multipart/form-data">
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="inputEmail3" class="col-sm-3 control-label">Blog Title <span class="required">*</span></label>
                  <div class="col-sm-9">
                    <input type="text" name="title" class="form-control editblogtitle" id="inputEmail3" placeholder="Blog Title">
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputEmail3" class="col-sm-3 control-label">Blog Description <span class="required">*</span></label>
                  <div class="col-sm-9">
                    <textarea id="editor2" name="description" class="editblogdesc" rows="10" cols="80"></textarea>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="row currentimages" style="margin-bottom:20px;">              	
              </div>
              <div class="">
                <div class="">
                  <div class="form-group col-md-6">
                    <label for="exampleInputFile col-sm-3">Upload Blog Image (Optional)</label>
                    <input name="blogimage[]" class="uploadnewbloguploader col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                    <p class="help-block">Upload Blog Image Here</p>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="newlogouploadclass1" style="width:100%; display:none;" /> </div>
                    <div class="addimagediv col-md-6" style="margin-top:20px;">
                      <button type="button" class="btn btn-primary addimagebtn"><i class="fa fa-plus"></i> Add Image</button>
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
