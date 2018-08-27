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
    <h1> Rates Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Rates Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-money"></i>
            <h3 class="box-title">Rates Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Rates</button>
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
                    <label for="inputEmail3" class="col-sm-3 control-label">Amount/Month <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="amount" class="form-control" id="inputEmail3" placeholder="Amount">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Discount Text</label>
                    <div class="col-sm-9">
                      <input type="text" name="discount" class="form-control" id="inputEmail3" placeholder="Left blank if not applicable">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">View all service provider? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <label class="control-label col-md-3"> Yes
                      	<input type="radio" name="viewallprovider" checked="checked" value="1" style="margin-left:20px;" />
                      </label>
                      <label class="control-label col-md-3"> No
                      	<input type="radio" name="viewallprovider" value="0" style="margin-left:20px;" />
                      </label>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Contact all service provider? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <label class="control-label col-md-3"> Yes
                      	<input type="radio" name="contactallprovider" checked="checked" value="1" style="margin-left:20px;" />
                      </label>
                      <label class="control-label col-md-3"> No
                      	<input type="radio" name="contactallprovider" value="0" style="margin-left:20px;" />
                      </label>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Post regular jobs? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="regularjob">
                      	<option value="">Choose</option>
						<option value="0">No</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="Unlimited">Unlimited</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Post urgent jobs? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="urgentjob">
                      	<option value="">Choose</option>
						<option value="0">No</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="Unlimited">Unlimited</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Book & pay your service provider for free? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <label class="control-label col-md-3"> Yes
                      	<input type="radio" name="bookpay" checked="checked" value="1" style="margin-left:20px;" />
                      </label>
                      <label class="control-label col-md-3"> No
                      	<input type="radio" name="bookpay" value="0" style="margin-left:20px;" />
                      </label>
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Background check for service provider? <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <label class="control-label col-md-3"> Yes
                      	<input type="radio" name="backgroundcheck" checked="checked" value="1" style="margin-left:20px;" />
                      </label>
                      <label class="control-label col-md-3"> No
                      	<input type="radio" name="backgroundcheck" value="0" style="margin-left:20px;" />
                      </label>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveratesemanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
              <h3 class="box-title">List of Ratess</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Title (EN)</th>
                    <th>Title (FR)</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['titleen'];?></td>
                    <td><?php echo $val['titlefr'];?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changefaqtopicstatus pointer" title="Change Service Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changefaqtopicstatus pointer" title="Change Service Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editfaqtitledetails pointer" title="Edit Service Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deletefaqtopic pointer" title="Delete Service" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
    <div class="modal-content" style="text-align:center;"> <img src="" id="modalimageid" class="img-responsive" width="100%" /> </div>
  </div>
</div>

<!--modal for edit the logo details-->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Rates details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
    	<form class="editmanagementform" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Topic Title <strong>(EN)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titleen" class="form-control edittitleen" id="inputEmail3" placeholder="Topic Title English">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Topic Title <strong>(FR)</strong> <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="titlefr" class="form-control edittitlefr" id="inputEmail3" placeholder="Topic Title French">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
            <div class="clearfix"></div>
            <div class="checkbox">
              <input type="hidden" name="id" class="hiddenid" />
              <button type="button" class="btn btn-primary pull-right editfaqtopicmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
