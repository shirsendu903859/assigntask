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
    <h1> Fare Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Fare Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-title"></i>
            <h3 class="box-title">Fare Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Fare</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="usermanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Maximum KM <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="maxkm" class="form-control" id="inputEmail3" placeholder="Maximum KM ">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Fair Amount <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="amount" class="form-control" id="inputEmail3" placeholder="Fair Amount">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Start Time <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-md-4">
                          <label class="control-label">Hour</label>
                          <select class="form-control starthour" name="starthour">
                            <option value="">Choose</option>
                            <?php for($i=1; $i<=12; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label">Minute</label>
                          <select class="form-control startminute" name="startminute">
                            <option value="">Choose</option>
                            <?php for($i=0; $i<=59; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label">Meridian</label>
                          <select class="form-control startmeridian" name="startmeridian">
                            <option value="">Choose</option>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">End Time <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <div class="row">
                        <div class="col-md-4">
                          <label class="control-label">Hour</label>
                          <select class="form-control endhour" name="endhour">
                            <option value="">Choose</option>
                            <?php for($i=1; $i<=12; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label">Minute</label>
                          <select class="form-control endminute" name="endminute">
                            <option value="">Choose</option>
                            <?php for($i=0; $i<=59; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label">Meridian</label>
                          <select class="form-control endmeridian" name="endmeridian">
                            <option value="">Choose</option>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Type <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <select class="form-control cartypebookingform" name="vehicletype">
                        <option value="">Choose</option>
                        <?php if(isset($vehicletype) && !empty($vehicletype)) { foreach($vehicletype as $key=>$val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                        <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">No of Seat Occupied <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <select class="form-control numberofseat" name="numberofseat">
                        <option>Choose</option>
                      </select>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="checkbox">
                  <!--<label>
                  <input name="active" value="1" type="checkbox">
                  Set as active </label>-->
                  <button type="button" class="btn btn-primary pull-right savefairmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
              <h3 class="box-title">List of Fare plan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Max KM</th>
                    <th>Amount </th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Vehicle</th>
                    <th>Passenger</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($faremanagement as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['maxkm']; ?></td>
                    <td><?php echo $val['amount']; ?></td>
                    <td><?php echo $val['starttime']; ?></td>
                    <td><?php echo $val['endtime']; ?></td>
                    <td><?php 
							if(isset($vehicletype) && !empty($vehicletype)) { foreach($vehicletype as $key2=>$val2) {
								if($val2['id'] == $val['vehicletype']) { echo $val2['title']; }
							} }
						?></td>
                    <td><?php echo $val['numberofseat']; ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changefarestatus pointer" title="Change Vehicle Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changefarestatus pointer" title="Change Vehicle Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editfaredetails pointer" title="Edit Vehicle Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deletefare pointer" title="Delete Vehicle" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
  <div class="modal-dialog modal-lg">
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
                <label for="inputEmail3" class="col-sm-3 control-label">Maximum KM <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="maxkm" class="form-control editmaxkm" id="inputEmail3" placeholder="Maximum KM ">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Fair Amount <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="amount" class="form-control editamount" id="inputEmail3" placeholder="Fair Amount">
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Start Time <span class="required">*</span></label>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="control-label">Hour</label>
                      <select class="form-control editstarthour" name="starthour">
                        <option value="">Choose</option>
                        <?php for($i=1; $i<=12; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="control-label">Minute</label>
                      <select class="form-control editstartminute" name="startminute">
                        <option value="">Choose</option>
                        <?php for($i=0; $i<=59; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="control-label">Meridian</label>
                      <select class="form-control editstartmeridian" name="startmeridian">
                        <option value="">Choose</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">End Time <span class="required">*</span></label>
                <div class="col-sm-9">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="control-label">Hour</label>
                      <select class="form-control editendhour" name="endhour">
                        <option value="">Choose</option>
                        <?php for($i=1; $i<=12; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="control-label">Minute</label>
                      <select class="form-control editendminute" name="endminute">
                        <option value="">Choose</option>
                        <?php for($i=0; $i<=59; $i++) {
											if($i < 10) { $i = '0'.$i; } ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="control-label">Meridian</label>
                      <select class="form-control editendmeridian" name="endmeridian">
                        <option value="">Choose</option>
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Type <span class="required">*</span></label>
                <div class="col-sm-9">
                  <select class="form-control editcartypebookingform" name="vehicletype">
                    <option value="">Choose</option>
                    <?php if(isset($vehicletype) && !empty($vehicletype)) { foreach($vehicletype as $key=>$val) { ?>
                    <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                    <?php } } ?>
                  </select>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">No of Seat Occupied <span class="required">*</span></label>
                <div class="col-sm-9">
                  <select class="form-control editnumberofseat" name="numberofseat">
                    <option>Choose</option>
                  </select>
                </div>
              </div>
              <div class="clearfix"></div>
              <div class="col-md-12">
              <input type="hidden" name="fareidedit" class="hiddenfareidedit" />
              	<button type="button" class="btn btn-primary pull-right editfaremanagement" style="margin-top:20px;"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer" style="margin-top:43px;"> </div>
    </div>
  </div>
</div>
