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
    <h1> Privacy Policy Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Privacy Policy Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-details"></i>
            <h3 class="box-title">Privacy Policy Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="sitemanageform" enctype="multipart/form-data">
              <div class="col-md-12">
                <div class="clearfix"></div>
              	<div class="col-md-3"><i class="fa fa-volume-up"></i> Content <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor1" name="texten" class="texten" rows="10" cols="80"><?php echo $sitedata['texten'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Content <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor2" name="textfr" class="textfr" rows="10" cols="80"><?php echo $sitedata['textfr'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updateprivacymanage"> Update</button> 
                </div>
              </div>
            </form>
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