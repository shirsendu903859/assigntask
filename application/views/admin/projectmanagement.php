<!-- Content Wrapper. Contains page content -->
<style>
.colorccc {
	color: #999;
}
.logodetails {
	float: right;
	cursor: pointer;
}
.pointer {
	margin-right: 15px;
}
</style>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Project Management <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Project Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-cogs"></i>
            <h3 class="box-title">Project Management</h3>
            <div class="pull-right">
              <button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Project</button>
            </div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;"> 
            <!--Upload logo part starts here-->
            <form class="managementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Project Title <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="title" class="form-control" id="inputEmail3" placeholder="Project Title">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Project Type <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="type">
                        <option value="">Choose Project Type</option>
                        <option value="0">Ongoing Project</option>
                        <option value="1">Sucessful Excetution</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Project Name <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="unit" class="form-control" id="inputEmail3" placeholder="Project Name">
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputEmail3" class="col-sm-3 control-label">Project Address <span class="required">*</span></label>
                    <div class="col-sm-9">
                      <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="Project Address">
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="">
                  <div class="">
                    <div class="form-group col-md-6">
                      <label for="exampleInputFile col-sm-3">Upload Project Image </label>
                      <input name="imageblue" class="imageuploader1 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                      <p class="help-block">Upload Project Image Here</p>
                    </div>
                    <div class="form-group col-md-6">
                      <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage1" style="width:100%; display:none;" /> </div>
                    </div>
                  </div>
                </div>
                <div class="checkbox">
                  <button type="button" class="btn btn-primary pull-right saveprojectmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  <div class="ajaxloading"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
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
              <h3 class="box-title">List of Projects</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th>Project Image</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($data as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php if($val['imagename'] != '') { ?>
                      <img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo ASSETS_URL.SERVICE_UPLOAD_URL.$val['imagename'];?>" /><span title="Enlarge The Logo" class="logodetails" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span>
                      <?php } ?></td>
                    <td><?php echo $val['title'];?></td>
                    <td><?php if($val['type'] == 0) { echo 'Ongoing Projects'; } if($val['type'] == 1) { echo 'Sucessful Excetution'; } ?></td>
                    <td><?php echo $val['unit']; ?></td>
                    <td><?php echo $val['price'];  ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changeprojectstatus pointer" title="Change Project Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changeprojectstatus pointer" title="Change Project Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editprojectdetails pointer" title="Edit Project Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deleteproject pointer" title="Delete Project" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
    <div class="modal-content" style="text-align:center;"> <img src="" id="modalimageid" class="img-responsive" width="100%" /> </div>
  </div>
</div>

<!--modal for edit the logo details-->
<div class="modal fade" id="editmodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Project details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <form class="editmanagementform" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Project Title <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="title" class="form-control edittitle" id="inputEmail3" placeholder="Project Title">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Project Type <span class="required">*</span></label>
                <div class="col-sm-9">
                  <select class="form-control edittype" name="projecttype">
                    <option value="">Choose Project Type</option>
                    <option value="0">Ongoing Project</option>
                    <option value="1">Sucessful Excetution</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Project Name <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="unit" class="form-control editunit" id="inputEmail3" placeholder="Project Name">
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail3" class="col-sm-3 control-label">Project Address <span class="required">*</span></label>
                <div class="col-sm-9">
                  <input type="text" name="price" class="form-control editprice" id="inputEmail3" placeholder="Project Address">
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
            <div class="">
              <div class="">
                <div class="form-group col-md-6">
                  <label for="exampleInputFile col-sm-3">Upload Project Image </label>
                  <input name="imageblue" class="imageuploader2 col-sm-9" data-inc="1" style="float:right;" id="exampleInputFile" type="file">
                  <p class="help-block">Upload Project Image Here</p>
                </div>
                <div class="form-group col-md-6">
                  <div class="logoimagenew col-md-6" style="height:100px; width:100px; border-radius:50%;"> <img src="" class="previewimage2" style="width:100%;" /> </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="checkbox">
              <input type="hidden" name="id" class="hiddenid" />
              <button type="button" class="btn btn-primary pull-right editprojectmanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
              <div class="ajaxloading"><img src="<?php echo ASSETS_URL.'assets/images/ajaxloading.gif';?>" class="ajaxloadingimage" /></div>
              <div class="errormsg alert alert-danger" style="display:none;"></div>
              <div class="successmsg alert alert-success" style="display:none;"></div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer"> </div>
    </div>
  </div>
</div>
<!--modal for details text of the service description-->
<div class="modal fade" id="modalforblogdesc" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="descbody" style="padding:20px;"></div>
    </div>
  </div>
</div>
