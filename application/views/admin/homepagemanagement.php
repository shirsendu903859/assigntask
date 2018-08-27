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
    <h1> Home Page Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Home Page Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-details"></i>
            <h3 class="box-title">Home Page Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="sitemanageform" enctype="multipart/form-data">
              <div class="col-md-12">
              	<div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> What We Offer </div>
                <div class="col-md-9 form-group">
                    <textarea id="editor1" name="one" class="texten" rows="10" cols="80"><?php echo $data['one'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top:30px; margin-bottom:30px;">
                <div class="modalbannerimage" style="height:100px; width:100px; border-radius:50%;"> <img src="<?php echo base_url().RESOURCES_UPLOAD_URL.$data['image1']; ?>" class="showbannerinmodalforedit" style="width:100%;" /> </div>
              </div>
                <div class="col-md-6" style="margin-top:30px; margin-bottom:30px;">
                <div class="form-group">
                  <label for="exampleInputFile">Choose Image for Section One in Home Page</label>
                  <input name="image1" class="bannerimageuploadforedit" id="exampleInputFile" type="file">
                  <p class="help-block">Upload your Image for Section One in Home Page</p>
                </div>
              </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Section One </div>
                <div class="col-md-9 form-group">
                    <textarea id="editor2" name="two" class="texten" rows="10" cols="80"><?php echo $data['two'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6" style="margin-top:30px; margin-bottom:30px;">
                <div class="modalbannerimage" style="height:100px; width:100px; border-radius:50%;"> <img src="<?php echo base_url().RESOURCES_UPLOAD_URL.$data['image2']; ?>" class="showbannerinmodalforedit2" style="width:100%;" /> </div>
              </div>
                <div class="col-md-6" style="margin-top:30px; margin-bottom:30px;">
                <div class="form-group">
                  <label for="exampleInputFile">Choose Image for Section Two in Home Page</label>
                  <input name="image2" class="bannerimageuploadforedit2" id="exampleInputFile" type="file">
                  <p class="help-block">Upload your Image for Section One in Home Page</p>
                </div>
              </div>
                <div class="clearfix"></div>
                <div class="col-md-3" style="margin-top:20px;"><i class="fa fa-volume-up"></i> Section Two</div>
                <div class="col-md-9 form-group" style="margin-top:20px;">
                    <textarea id="editor3" name="three" class="texten" rows="10" cols="80"><?php echo $data['three'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updatehomeoagecontent"> Update</button> 
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