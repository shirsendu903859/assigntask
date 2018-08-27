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
    <h1> User Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Assign Content</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User Details</h3>
            </div>
            <!-- /.box-header -->
            
            <?php if($this->session->flashdata('successmsg') != '') { ?>
            	<div class="col-md-12 alert alert-success"><?php echo $this->session->flashdata('successmsg'); ?></div>
            <?php } ?>
            
            <?php if($this->session->flashdata('errormsg') != '') { ?>
            	<div class="col-md-12 alert alert-danger"><?php echo $this->session->flashdata('errormsg'); ?></div>
            <?php } ?>
            
            
            <div class="box-body">
              <div class="row" style="padding:15px;">
              	<div class="col-md-6">
                	<div class="row">
                    	<div class="col-md-3"><strong style="font-size:15px;">Account Name :</strong></div>
                        <div class="col-md-9"><?php echo $user['accountname']; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                	<div class="row">
                    	<div class="col-md-3"><strong style="font-size:15px;">Account Type :</strong></div>
                        <div class="col-md-9"><?php echo $user['accounttype']; ?></div>
                    </div>
                </div>
              </div>
              
              <div class="row uploadarea">
              	<div class="col-md-12">
                	<div class="col-md-6">Upload the content to assign it to <?php echo $user['accountname']; ?></div>
                    <div class="col-md-6">
                    <form action="<?php echo base_url('admin/savecontent/'.$user['id']); ?>" method="post" enctype="multipart/form-data">
                    	<input type="file" name="file[]" class="form-control" multiple required>
                        <input type="hidden" name="userid" value="<?php echo $user['id']; ?>">
                    	<p style="color:#999; margin-top:10px;">Upload multiple files</p>
                        <button type="submit" class="btn btn-primary" style="float:right;"><i class="fa fa-check"></i> Assign</button>
                    </form>
                    </div>
                </div>
              </div>
              
              <div class="row">
              	<div class="col-md-12">
                	<label class="control-label">Already added files </label>
                    <?php
					if(!empty($filedata)) {
                    	foreach($filedata as $key=>$val) {
					?>
                    	<div class="col-md-12" style="padding:15px; border:1px solid #eee;">
                        	<div class="col-md-10"><a href="<?php echo base_url(PRODUCT_UPLOAD_URL.$val['encryptname']);?>" target="_blank"><?php echo $val['actualname']; ?></a></div>
                            <div class="col-md-2"><a href="javascript:void(0)" data-url='<?php echo base_url('admin/deletefile/'.$val['id'].'/'.$user['id']);?>' class="btn btn-danger deletecontent"><i class="fa fa-trash"></i> Delete</a></div>
                        </div>
                    <?php } } ?>
                </div>
              </div>
              
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
