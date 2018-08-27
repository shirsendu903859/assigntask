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
      <li class="active">User Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-users"></i>
            <h3 class="box-title">User Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add User</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="usermanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Account Name <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="accountname" class="form-control" id="inputEmail3" placeholder="Account Name">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Account Type <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="accounttype" class="form-control" id="inputEmail3" placeholder="Account Type">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Account Number <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="accountnumber" class="form-control" id="inputEmail3" placeholder="Account Number">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Email <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="email" class="form-control" id="inputEmail3" placeholder="Email">
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
                    <label for="inputEmail3" class="col-sm-3 control-label">Phone <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="phone" class="form-control" id="inputEmail3" placeholder="Phone">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Password <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="password" class="form-control passwordfield" id="inputEmail3" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="col-sm-6">
                      <button type="button" class="autogenpass btn btn-info"><i class="fa fa-key" aria-hidden="true"></i> Autogenerate Password</button>
                      <input type="hidden" class="AUTOGEN_PASSWORD_LENGTH" value="<?php echo AUTOGEN_PASSWORD_LENGTH; ?>">
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
              <h3 class="box-title">List of Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Account Name</th>
                    <th>Account Type </th>
                    <th>Account Number </th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($user as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php echo $val['accountname']; ?></td>
                    <td><?php echo $val['accounttype'];?></td>
                    <td><?php echo $val['accountnumber'];?></td>
                    <td><?php echo $val['email']; ?></td>
                    <td><?php echo $val['phone']; ?></td>
                    <td><?php echo $val['address']; ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeuserstatus pointer" title="Change User Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeuserstatus pointer" title="Change User Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="edituserdetails pointer" title="Edit User Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteuser pointer" title="Delete User" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
        <h4 class="modal-title">Edit the user details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="edituserform" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Account Name</label>
                <input class="form-control editaccountname" id="exampleInputEmail1" name="accountname" placeholder="Enter User Account Name" type="text">
                <input type="hidden" name="hiddenaccountname" class="editaccountname" />
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Account Type</label>
                <input class="form-control editaccounttype" id="exampleInputEmail1" name="accounttype" placeholder="Enter User Account Type" type="text">
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Account Number</label>
                <input class="form-control editaccountnumber" id="exampleInputEmail1" name="accountnumber" placeholder="Enter User Account Number" type="text">
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
                <label for="exampleInputEmail1">Phone</label>
                <input class="form-control editphone" id="exampleInputEmail1" name="phone" placeholder="Enter User Phone" type="text">
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Change Password</label>
                <input class="form-control passwordfieldedit" id="exampleInputEmail1" name="password" placeholder="Enter New Password" type="text">
              </div>
              <div class="form-group col-md-6">
                <button type="button" class="autogenpass2 btn btn-info" style="margin-top:24px;"><i class="fa fa-key" aria-hidden="true"></i> Autogenerate Password</button>
                <input class="AUTOGEN_PASSWORD_LENGTH" value="10" type="hidden">
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
