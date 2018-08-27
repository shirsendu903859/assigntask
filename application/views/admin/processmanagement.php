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
    <h1> About Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">About Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-details"></i>
            <h3 class="box-title">About Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="sitemanageform" enctype="multipart/form-data">
              <div class="col-md-12">
              	<label class="control-label" style="width: 100%;text-align: center;font-size: 18px;font-weight: normal;margin-bottom: 15px;">How it works for <strong>customers</strong></label>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Choose the best provider <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor1" name="one" class="texten" rows="10" cols="80"><?php echo $data['one'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Choose the best provider <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor2" name="two" class="texten" rows="10" cols="80"><?php echo $data['two'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Book according to your schedule <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor3" name="three" class="texten" rows="10" cols="80"><?php echo $data['three'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Book according to your schedule <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor4" name="four" class="texten" rows="10" cols="80"><?php echo $data['four'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Pay with peace of mind <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor5" name="five" class="texten" rows="10" cols="80"><?php echo $data['five'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Pay with peace of mind <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor6" name="six" class="texten" rows="10" cols="80"><?php echo $data['six'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Rate and evaluate <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor7" name="seven" class="texten" rows="10" cols="80"><?php echo $data['seven'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Rate and evaluate <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor8" name="eight" class="texten" rows="10" cols="80"><?php echo $data['eight'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                
                
                
                
                <label class="control-label" style="width: 100%;text-align: center;font-size: 18px;font-weight: normal;margin-bottom: 15px; margin-top:15px;">How it works for <strong>providers</strong></label>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Create your profile <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor9" name="nine" class="texten" rows="10" cols="80"><?php echo $data['nine'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Create your profile <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor10" name="ten" class="texten" rows="10" cols="80"><?php echo $data['ten'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Customize your profile <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor11" name="eleven" class="texten" rows="10" cols="80"><?php echo $data['eleven'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Customize your profile <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor12" name="twelve" class="texten" rows="10" cols="80"><?php echo $data['twelve'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Find a job according to your schedule <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor13" name="thirteen" class="texten" rows="10" cols="80"><?php echo $data['thirteen'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Find a job according to your schedule <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor14" name="fourteen" class="texten" rows="10" cols="80"><?php echo $data['fourteen'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Get paid for each service <strong>(EN)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor15" name="fifteen" class="texten" rows="10" cols="80"><?php echo $data['fifteen'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-volume-up"></i> Get paid for each service <strong>(FR)</strong></div>
                <div class="col-md-9 form-group">
                    <textarea id="editor16" name="sixteen" class="texten" rows="10" cols="80"><?php echo $data['sixteen'] ?></textarea>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updateprocessmanage"> Update</button> 
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