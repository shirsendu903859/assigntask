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
    <h1> Site Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Site Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-sitemap"></i>
            <h3 class="box-title">Site Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="sitemanageform" enctype="multipart/form-data">
              <div class="col-md-12">
              	<div class="col-md-3"><i class="fa fa-globe"></i> Site Title</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['title']; ?>" name="title" placeholder="Enter Site Title" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-globe"></i> Site Short Title</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['shorttitle']; ?>" name="shorttitle" placeholder="Enter Site Title" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-at"></i> Site Email</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['email']; ?>" name="email" placeholder="Enter Site Email" type="email">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-facebook-f"></i> Site Facebook Page URL</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['facebook']; ?>" name="facebook" placeholder="Enter Site Facebook Page URL" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-google-plus"></i> Site Google Plus URL</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['googleplus']; ?>" name="googleplus" placeholder="Site Google Plus URL" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-twitter"></i> Site Twitter URL</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['twitter']; ?>" name="twitter" placeholder="Site Twitter URL" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-linkedin"></i> Site Linkedin URL</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['instagram']; ?>" name="instagram" placeholder="Site Linkedin URL" type="text">
                </div>
                <div class="clearfix"></div>
                <!--<div class="col-md-3"><i class="fa fa-whatsapp"></i> Site Whatsapp No</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php //echo $sitedata['whatsapp']; ?>" name="whatsapp" placeholder="Site Whatsapp No" type="text">
                </div>
                <div class="clearfix"></div>-->
				<div class="col-md-3"><i class="fa fa-copyright"></i> Site Copyright Text</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['copyright']; ?>" name="copyright" placeholder="Site Copyright Text" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-cogs"></i> Site Version</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['version']; ?>" name="version" placeholder="Site Snapchat URL" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Site Slogan</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['slogan']; ?>" name="slogan" placeholder="Site Slogan" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-phone"></i> Site Phone</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['phone']; ?>" name="phone" placeholder="Site Phone" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-address-card-o"></i> Site Address</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $sitedata['address']; ?>" name="address" placeholder="Site Address" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updatesitemanage"><i class="fa fa-wrench"></i> Update Site Management</button> 
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