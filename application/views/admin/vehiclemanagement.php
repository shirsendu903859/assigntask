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
    <h1> Vehicle Type Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Vehicle Type Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-car"></i>
            <h3 class="box-title">Vehicle Type Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Vehicle Type</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="usermanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Type Name <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="Vehicle Name">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">No of Seats <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="seat" class="form-control" id="inputEmail3" placeholder="No of Seat">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Carry Luggage Available <span class="required">*</span></label>
                    <div class="col-sm-9">
                       	<select class="form-control" name="luggage">
                        	<option value="">Choose</option>
                    		<option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Caption <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="caption" class="form-control" id="inputEmail3" placeholder="Vehicle Caption">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Description <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea id="editor1" name="description" rows="10" cols="80"></textarea>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">No of Doors <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="doors" class="form-control" id="inputEmail3" placeholder="No of Doors">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Fuel <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="fuel" class="form-control" id="inputEmail3" placeholder="Fuel">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Service Image </label>
                      <input name="blogimage[]" class="uploadnewbloguploader col-sm-9" multiple data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Service Image Here</p>
                    </div>
                <div class="clearfix"></div>
                </div>
                <div class="checkbox">
                  <!--<label>
                  <input name="active" value="1" type="checkbox">
                  Set as active </label>-->
                  <button type="button" class="btn btn-primary pull-right savevehiclemanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo base_url('assets/images/ajaxloading.gif');?>" class="ajaxloadingimage" /></div>
                  <div class="errormsg alert alert-danger" style="display:none;"></div>
                  <div class="successmsg alert alert-success" style="display:none;"></div>
                </div>
              </div>
            </form>
            <!--Upload logo part ends here-->
          </div>
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Vehicle Types</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Vehicle Type Name</th>
                    <th>Max Seat </th>
                    <th>Luggage</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($vehicletype as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['title']; ?></td>
                    <td><?php echo $val['seat']; ?></td>
                    <td><?php if($val['luggage'] == 1) { echo 'Yes'; } else { echo 'No'; } ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changevehiclestatus pointer" title="Change Vehicle Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changevehiclestatus pointer" title="Change Vehicle Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editvehicledetails pointer" title="Edit Vehicle Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deletevehicle pointer" title="Delete Vehicle" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
                  </tr>
                  <?php } ?>
                  </tfoot>
                  
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
<div class="modal fade" id="editusermodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the vehicle details</h4>
      </div>
      <div class="modal-body" style="height:170px;">
        <div class="col-md-12">
          <form class="edituserform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vehicle Type Name</label>
                <input class="form-control editvehiclename" id="exampleInputEmail1" name="title" placeholder="Enter Vehicle Name" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Carry Luggage Available</label>
                    <select class="form-control editluggage" name="luggage">
                        <option value="">Chooose</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">No of Seats </label>
                <input class="form-control editseat" id="exampleInputEmail1" name="seat" placeholder="Enter No of Seats" type="text">
              </div>
              <div class="clearfix"></div>
              <div class="col-md-12">
              <input type="hidden" name="vehicleidedit" class="hiddenvehicleidedit" />
              	<button type="button" class="btn btn-primary pull-right editvehiclemanagement"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
      <div class="modal-footer" style="margin-top:43px;">
        
      </div>
    </div>
  </div>
</div>
