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
    <h1> Attribute Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Attribute Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-list-alt"></i>
            <h3 class="box-title">Attribute Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Attribute</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="attributemanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Attribute Title <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="Attribute Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Choose Parent </label>
                    <div class="col-sm-9">
                      <select class="form-control" name="parent">
                      	<option value="0">Choose Parent Attribute</option>
                        <?php foreach($attributedata as $key=>$val) { ?>
                        <option value="<?php echo $val['id']?>" <?php if($val['parent'] == 0) { ?> style="font-weight:800;" <?php } ?>><?php echo $val['title']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveattributemanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo base_url('assets/images/ajaxloading.gif');?>" class="ajaxloadingimage" /></div>
                  <div class="errormsg alert alert-danger" style="display:none;"></div>
                  <div class="successmsg alert alert-success" style="display:none;"></div>
                </div>
              </div>
            </form>
            <input type="hidden" class="hiddenincval" value="2" />
            <!--Upload logo part ends here-->
          </div>
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Attributes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Attribute Title</th>
                    <th>Parent Attribute</th>
                    <th style="width:17% !important;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($attributedata as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><input type="text" class="edittitleval form-control" disabled value="<?php echo $val['title']; ?>"></td>
                    <td>
                        <select class="form-control" name="editparentval form-control" disabled>
                            <option <?php if($val['parent'] == 0) { ?> selected <?php } ?> value="0">-</option>
							<?php foreach($attributedata as $keypre=>$valpre) { ?>
                            <option <?php if($val['parent'] == $valpre['id']) { ?> selected <?php } ?> value="<?php echo $valpre['id']?>" <?php if($valpre['parent'] == 0) { ?> style="font-weight:800;" <?php } ?>><?php echo $valpre['title']; ?></option>
							<?php } ?>
                        </select>
					
	                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeattributestatus pointer" title="Change Attribute Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeattributestatus pointer" title="Change Attribute Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editattributedetails pointer" title="Edit Attribute Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> 
                      <!--<span class="deleteattribute pointer" title="Delete Attribute" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span>--></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  
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
    <div class="modal-content">
      <div class="silderbody"></div>
    </div>
  </div>
</div>
<!--modal for edit the logo details-->
<div class="modal fade" id="editcategorymodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the blog details</h4>

      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
          <form class="editcategoryform" enctype="multipart/form-data">
            <div class="row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Category Title <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control categorytitlemodal" id="inputEmail3" placeholder="Category Title">
                    </div>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="inputEmail3" class="col-sm-3 control-label">Choose Parent </label>
                    <div class="col-sm-9">
                      <select class="form-control" name="parent" class="categoryparentmodal">
                      	<option class="val0" value="0">Choose Parent Category</option>
                        <?php foreach($categorydata as $key=>$val) { ?>
                        <option class="<?php echo 'val'.$val['id']; ?>" value="<?php echo $val['id']?>" <?php if($val['parent'] == 0) { ?> style="font-weight:800;" <?php } ?>><?php echo $val['title']; ?></option>                 
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="hiddencategoryid" >
                  <div class="clearfix"></div>
                </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--modal for details text of the blog description-->
<div class="modal fade" id="modalforblogdesc" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="descbody" style="padding:20px;"></div>
    </div>
  </div>
</div>
