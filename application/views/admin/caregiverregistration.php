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
      <li class="active">Caregiver Registration</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-users"></i>
            <h3 class="box-title">Caregiver Registration</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="manageform" enctype="multipart/form-data">
              <div class="row">
              	<div class="col-md-6 form-group">
                	<label class="control-label">Choose Service</label>
                    <select class="form-control parentservice" name="parentservice">
                    	<option value="">Choose</option>
                        <?php if(isset($service) && !empty($service)) { foreach($service as $key=>$val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['titleen']; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-6 form-group">
                	<label class="control-label">Choose Sub Service</label>
                    <select class="form-control subservice" name="subservice">
                    	<option value="">Choose</option>
                        <?php if(isset($service) && !empty($service)) { foreach($service as $key=>$val) { 
								if(isset($val['subservice']) && !empty($val['subservice'])) { foreach($val['subservice'] as $innerkey=>$innerval) { ?>
                        <option class="hiddenoption showoption<?php echo $val['id']; ?>" style="display:none;" value="<?php echo $innerval['id']; ?>" ><?php echo $innerval['titleen']; ?></option>
                        <?php } } } } ?>
                    </select>
                </div>
              </div>
              <div class="row" class="fieldtypeblock">
              	<div class="col-md-3">
                	<label class="control-label">Choose Field Type</label>
                </div>
                <div class="col-md-6">
                    <select class="form-control fieldtype" name="fieldtype">
                        <option value="">Choose</option>
                        <?php if(isset($input) && !empty($input)) { foreach($input as $key=>$val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo ucwords($val['type']); ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-primary addfield"><i class="fa fa-plus"></i> Add</button></div>
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



<!--text start-->
<div class="row">
	<div class="col-md-"
</div>
<!--text end-->