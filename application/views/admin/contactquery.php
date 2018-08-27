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
    <h1> Contact Query <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contact Query</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-info-circle"></i>
            <h3 class="box-title">Contact Query</h3>
            <div class="pull-right">
              <!--<button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Driver</button>-->
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="usermanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Driver Name <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="Driver Name">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Driver Phone <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="phone" class="form-control" id="inputEmail3" placeholder="Driver Phone">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Driver Email <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="email" class="form-control" id="inputEmail3" placeholder="Driver Email">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Type <span class="required">*</span></label>
                    <div class="col-sm-9">
                    <?php if(isset($vehicletype) && !empty($vehicletype)) { ?>
                    	<select class="form-control" name="vehicletype">
                        	<option value="">Chooose Vehicle Type</option>
						<?php foreach($vehicletype as $key=>$val) { ?>
                    		<option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                    	<?php } ?>
                        </select>
                    <?php }?>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Address <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <textarea name="address" class="form-control" cols="3" placeholder="Address"></textarea>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Vehicle Number <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="vehiclenumber" class="form-control" id="inputEmail3" placeholder="Vehicle Number">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="checkbox">
                  <!--<label>
                  <input name="active" value="1" type="checkbox">
                  Set as active </label>-->
                  <button type="button" class="btn btn-primary pull-right saveusermanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
              <h3 class="box-title">List of Queries</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Time</th>
                    <!--<th>Action</th>-->
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['fname'].' '.$val['lname']; ?></td>
                    <td><?php echo $val['phone']; ?></td>
                    <td><?php echo $val['subject']; ?></td>
                    <td><?php echo $val['msg']; ?></td>
                    <td><?php echo date("d-m-Y h:i:s", strtotime($val['datetime'])); ?></td>
                    <!--<td width="15%">--><?php //if($val['status'] == 1) { ?>
                      <!--<span class="changeuserstatus pointer" title="Change User Status" data-id=<?php //echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>-->
                      <?php //} else { ?>
                      <!--<span class="changeuserstatus pointer" title="Change User Status" data-id=<?php //echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>-->
                      <?php //} ?>
                      <!--<span class="edituserdetails pointer" title="Edit User Details" data-id="<?php //echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span>-->
                      <!--<span class="sendreply pointer" title="Reply" data-id="<?php echo $val['id']?>"><i class="fa fa-reply fa-2x" style="color:#09F;" aria-hidden="true"></i></span> 
                      <span class="deletequery pointer" title="Delete User" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>-->
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
        <h4 class="modal-title">Edit the driver details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="edituserform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Driver Name</label>
                <input class="form-control editdrivername" id="exampleInputEmail1" name="name" placeholder="Enter Driver Name" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vehicle Type</label>
                 <?php if(isset($vehicletype) && !empty($vehicletype)) { ?>
                    <select class="form-control editvehicletype" name="vehicletype">
                        <option value="">Chooose Vehicle Type</option>
                    <?php foreach($vehicletype as $key=>$val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                    <?php } ?>
                    </select>
                <?php }?>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Phone</label>
                <input class="form-control editphone" id="exampleInputEmail1" name="phone" placeholder="Enter User Phone Number" type="text">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Email</label>
                <input class="form-control editemail" id="exampleInputEmail1" name="email" placeholder="Enter User Email" type="text">
                <input type="hidden" name="previousemail" class="editemail" />
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Address</label>
                <textarea class="form-control editaddress" name="address" placeholder="Enter User Address"></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vehicle Number</label>
                <input class="form-control editvehiclenumber" id="exampleInputEmail1" name="vehiclenumber" placeholder="Enter Vehicle Number" type="text">
                <input type="hidden" name="hiddeneditdrivername" class="editaccountname" />
              </div>
              <div class="clearfix"></div>
              <div class="col-md-12">
              <input type="hidden" name="useridedit" class="hiddenuseridedit" />
              	<button type="button" class="btn btn-primary pull-right editusermanagement"><i class="fa fa-floppy-o"></i>&nbsp;Save</button>
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
