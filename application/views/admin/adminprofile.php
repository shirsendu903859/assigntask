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
    <h1> Profile Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-shield"></i>
            <h3 class="box-title">Profile Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="adminprofile" enctype="multipart/form-data">
              <div class="col-md-12">
              	<div class="col-md-3">Username</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $admindata['username']; ?>" placeholder="Enter Username" readonly type="text">
                    <span style="color:#999;">Username Can't be change</span>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">First Name</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" name="firstname" value="<?php echo $admindata['firstname']; ?>" placeholder="Enter First Name" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">Last Name</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" name="lastname" value="<?php echo $admindata['lastname']; ?>" placeholder="Enter Last Name" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">Email</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" name="email" value="<?php echo $admindata['email']; ?>" placeholder="Enter Email" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">Admin New Password</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" name="newpassword" placeholder="Enter New Password" type="password">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">Admin Confirm Password</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" name="confirmpassword" placeholder="Enter Confirm Password" type="password">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">Admin Display Photo</div>
                <div class="col-md-9">
                	<div class="col-md-6">
                    <input class="uploadnewlogouploader" id="exampleInputEmail1" name="image" placeholder="" type="file">
                    <span style="color:#999;">Upload your image here</span>
                	</div>
                    <div class="col-md-6">
                    <div class="logoimagenew" style="height:100px; width:100px; border-radius:50%;">
            			<img src="<?php echo ASSETS_URL.ADMIN_DP_UPLOAD_URL.$admindata['imagename']; ?>" class="newlogouploadclass" style="width:100%;" style="display:none;" />
                	</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updateadminprofile"><i class="fa fa-wrench"></i> Update Profile</button> 
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