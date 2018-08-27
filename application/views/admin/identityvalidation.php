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
    <h1> Identity Validation <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Identity Validation</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-id-card-o"></i>
            <h3 class="box-title">Identity Validation</h3>
          </div>
          
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Identity Validation</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Document Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['userdata']['fname'].' '.$val['userdata']['lname'];?></td>
                    <td><?php echo $val['userdata']['email'];?></td>
                    <td>Candidate</td>
                    <td><?php echo $val['documenttype'];?></td>
                    <td width="15%">
                        <button type="button" title="View The Document" class="btn btn-info viewidentity" data-val="<?php echo $val['id']?>"><i class="fa fa-eye"></i></button>
                        <button type="button" title="Approve The Document" class="btn btn-success approveidentity" data-val="<?php echo $val['id']?>"><i class="fa fa-check"></i></button>
                        <button type="button" title="Decline The Document" class="btn btn-danger declineidentity" data-val="<?php echo $val['id']?>"><i class="fa fa-trash"></i></button>
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
    <div class="modal-content" style="text-align:center;"> <img src="" id="modalimageid" class="img-responsive" width="100%" /> </div>
  </div>
</div>

<!--modal for edit the logo details-->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Faq Topic details</h4>
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
