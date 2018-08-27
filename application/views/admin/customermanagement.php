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
    <h1> Customer Management <small>Need Care Giver</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Customer Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-users"></i>
            <h3 class="box-title">Customer Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Customers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Customer ID</th>
                    <th>Customer Type</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['customerid'] ?></td>
                    <td><?php echo ucwords($val['customertype']);?></td>
                    <td><?php echo $val['details']['fname'].' '.$val['details']['lname'];?></td>
                    <td><?php echo $val['email']; ?></td>
                    <td width="8%" class="text-center"><?php if($val['status'] == 1) { ?>
                      <span class="changecustomerstatus pointer" title="Change Customer Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changecustomerstatus pointer" title="Change Customer Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      </td>
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
              <div class="col-md-3"> Banner Caption <strong>(English)</strong></div>
              <div class="col-md-9 form-group">
                <textarea id="editor3" class="bannertextediten" name="texten" rows="10" cols="30"></textarea>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-3"> Banner Caption <strong>(French)</strong></div>
              <div class="col-md-9 form-group">
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
