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
    <h1> Banner Management <small>Website Banner</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Banner Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-picture-o"></i>
            <h3 class="box-title">Banner Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Banner</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="bannermanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-9">
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="exampleInputFile">Upload Banner</label>
                        <input name="image" class="uploadnewlogouploader" id="exampleInputFile" type="file">
                        <p class="help-block">Upload your Banner here</p>
                      </div>
                      <div class="form-group col-md-6">
                        <div class="logoimagenew" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="newlogouploadclass" style="width:100%; display:none;" /> </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Choose Page to apply</label>
                    <select class="form-control" name="page">
                      <option value="">Choose Page</option>
                      <?php if(isset($page) && !empty($page)) {
								foreach($page as $key=>$val) { ?>
                      <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>
                <div class="row" style="display:none;">
                  <div class="col-md-3"> Banner Caption <strong>(English)</strong></div>
                  <div class="col-md-9 form-group">
                    <textarea id="editor1" name="captionen" rows="10" cols="30">dd</textarea>
                  </div>
                </div>
                <div class="row" style="display:none;">
                  <div class="col-md-3"> Banner Caption <strong>(French)</strong></div>
                  <div class="col-md-9 form-group">
                    <textarea id="editor2" name="captionfr" rows="10" cols="30">jhh</textarea>
                  </div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right savebannermanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
                  <div class="errormsg alert alert-danger" style="display:none;"></div>
                  <div class="successmsg alert alert-success" style="display:none;"></div>
                </div>
              </div>
            </form>
            <!--Upload logo part ends here-->
          </div>
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Banners</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th width="10%">Banner</th>
                    <!--<th>Caption (En)</th>
                    <th>Caption (Fr)</th>-->
                    <th>Applied Page</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($banner as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php if($val['imagename'] != '') { ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo ASSETS_URL.BANNER_UPLOAD_URL.$val['imagename'];?>" /><span title="Enlarge The Logo" class="logodetails" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span>
                      <?php } ?></td>
                    <!--<td><?php echo $val['texten'];?></td>
                    <td><?php echo $val['textfr'];?></td>
                    --><td><?php
                    	$pagedata = $this->db->get_where('pages', array('id'=>$val['page']))->row_array();
						echo $pagedata['title'];
                    	 ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changebannerstatus pointer" title="Change Banner Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changebannerstatus pointer" title="Change Banner Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editbannerdetails pointer" title="Edit Banner Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deletebanner pointer" title="Delete Banner" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
                  </tr>
                  <?php } ?>
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
    <div class="modal-content"> <img src="" id="modalimageid" class="img-responsive" /> </div>
  </div>
</div>
<!--modal for edit the logo details-->
<div class="modal fade" id="editbannermodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Banner details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="editbannerform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group col-md-12">
                <label for="exampleInputEmail1">Choosen Page</label>
                <select class="form-control editpage" name="pageedit">
                  <option value="">Choose Page</option>
                  <?php if(isset($page) && !empty($page)) {
                        foreach($page as $key=>$val) { ?>
                  <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
            <div class="checkbox">
              <div class="col-md-6">
                <div class="modalbannerimage" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="showbannerinmodalforedit" style="width:100%;" /> </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputFile">Change Banner</label>
                  <input name="bannerimage" class="bannerimageuploadforedit" id="exampleInputFile" type="file">
                  <p class="help-block">Upload your new Banner here</p>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3" style="display:none;"> Banner Caption <strong>(English)</strong></div>
              <div class="col-md-9 form-group" style="display:none;">
                <textarea id="editor3" class="bannertextediten" name="texten" rows="10" cols="30"></textarea>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3" style="display:none;"> Banner Caption <strong>(French)</strong></div>
              <div class="col-md-9 form-group" style="display:none;">
                <textarea id="editor4" class="bannertexteditfr" name="textfr" rows="10" cols="30"></textarea>
              </div>
              <div class="clearfix"></div>
              <input type="hidden" name="hiddeneditbannerid" value="" class="hiddeneditbannerid" />
              <button type="button" class="btn btn-primary pull-right editbannermanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
              <div class="ajaxloadingmodal"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
              <div class="errormsgmodal alert alert-danger" style="display:none;"></div>
              <div class="successmsgmodal alert alert-success" style="display:none;"></div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer" style="border:none;">
      </div>
    </div>
  </div>
</div>
