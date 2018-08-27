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
    <h1> Logo Management <small>Website Logo</small> </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Logo Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-shield"></i>
            <h3 class="box-title">Logo Management</h3>
            <div class="pull-right"><button class="btn btn-primary addlogodialougeshow"><i class="fa fa-plus"></i> Add Logo</button></div>
          </div>
          <div class="box-body pad table-responsive addlogodialougebox" style="display:none;">
            <!--Upload logo part starts here-->
            <form class="logomanagementform" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="exampleInputFile">Upload Logo</label>
                  <input name="logoimage" class="uploadnewlogouploader" id="exampleInputFile" type="file">
                  <p class="help-block">Upload your logo here</p>
                </div>
                <div class="form-group col-md-6">
                	<div class="logoimagenew" style="height:100px; width:100px; border-radius:50%;">
            			<img src="" class="newlogouploadclass" style="width:100%;" style="display:none;" />
                	</div>
                </div>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Alt</label>
                    <input class="form-control" id="exampleInputEmail1" name="alt" placeholder="Enter Alt Value" type="text">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Title</label>
                    <input class="form-control" id="exampleInputEmail1" name="title" placeholder="Enter Title Value" type="text">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Height</label>
                    <input class="form-control" id="exampleInputEmail1" name="height" placeholder="Enter Height Value" type="tel">
                    <p class="colorccc">Left blank for auto height</p>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="exampleInputEmail1">Width</label>
                    <input class="form-control" id="exampleInputEmail1" name="width" placeholder="Enter Width Value" type="tel">
                    <p class="colorccc">Left blank for auto width</p>
                  </div>
                </div>
                <div class="checkbox">
                  <!--<label>
                  <input name="active" value="1" type="checkbox">
                  Set as active </label>-->
                  <button type="button" class="btn btn-primary pull-right savelogomanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
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
              <h3 class="box-title">List of Logos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sr No.</th>
                    <th width="10%">Logo</th>
                    <th>Alt</th>
                    <th>Title</th>
                    <th>Height</th>
                    <th>Width</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($logo as $key=>$val) { ?>
                  <tr>
                    <td><?php echo intval($key) + 1; ?></td>
                    <td><?php if($val['imagename'] != '') { ?><img class="myImg" id="myImg<?php echo $key; ?>" height="25" width="25" style="border-radius:50%" src="<?php echo base_url().LOGO_UPLOAD_URL.$val['imagename'];?>" /><span title="Enlarge The Logo" class="logodetails" data-id="<?php echo $val['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i></span><?php } ?></td>
                    <td><?php echo $val['alt'];?></td>
                    <td><?php echo $val['title'];?></td>
                    <td><?php if($val['height'] == '') { echo 'Auto'; } else { echo $val['height']; } ?></td>
                    <td><?php if($val['width'] == '') { echo 'Auto'; } else { echo $val['width']; } ?></td>
                    <td width="15%"><?php if($val['status'] == 1) { ?>
                      <span class="changelogostatus pointer" title="Change Logo Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-up fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } else { ?>
                      <span class="changelogostatus pointer" title="Change Logo Status" data-id=<?php echo $val['id'];?>><i class="fa fa-thumbs-o-down fa-2x statusicon" aria-hidden="true"></i></span>
                      <?php } ?>
                      <span class="editlogodetails pointer" title="Edit Logo Details" data-id="<?php echo $val['id']?>"><i class="fa fa-pencil-square-o fa-2x" style="color:#09F;" aria-hidden="true"></i></span> <span class="deletelogo pointer" title="Delete Logo" data-id="<?php echo $val['id']?>"><i class="fa fa-trash-o fa-2x" style="color:#f00;" aria-hidden="true"></i></span></td>
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
<div class="modal fade" id="editlogomodal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit the Logo details</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <div class="col-md-12">
        <form class="editlogoform" enctype="multipart/form-data">
          <div class="row">
            <div class="form-group col-md-3">
              <label for="exampleInputEmail1">Alt</label>
              <input class="form-control editlogoalt" id="exampleInputEmail1" name="alt" placeholder="Enter Alt Value" type="text">
            </div>
            <div class="form-group col-md-3">
              <label for="exampleInputEmail1">Title</label>
              <input class="form-control editlogotitle" id="exampleInputEmail1" name="title" placeholder="Enter Title Value" type="text">
            </div>
            <div class="form-group col-md-3">
              <label for="exampleInputEmail1">Height</label>
              <input class="form-control editlogoheight" id="exampleInputEmail1" name="height" placeholder="Enter Height Value" type="tel">
              <p class="colorccc">Left blank for auto height</p>
            </div>
            <div class="form-group col-md-3">
              <label for="exampleInputEmail1">Width</label>
              <input class="form-control editlogowidth" id="exampleInputEmail1" name="width" placeholder="Enter Width Value" type="tel">
              <p class="colorccc">Left blank for auto width</p>
            </div>
          </div>
          <div class="checkbox">
          	<div class="col-md-6">
          		<div class="modallogoimage" style="height:100px; width:100px; border-radius:50%;">
            		<img src="" class="showlogoinmodalforedit" style="width:100%;" />
                </div>
            </div>
            <div class="col-md-6">
            	<div class="form-group">
                  <label for="exampleInputFile">Change Logo</label>
                  <input name="logoimage" class="logoimageuploadforedit" id="exampleInputFile" type="file">
                  <p class="help-block">Upload your new logo here</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <input type="hidden" name="hiddeneditloogid" value="" class="hiddeneditloogid" />
            <button type="button" class="btn btn-primary pull-right editlogomanagement"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            <div class="ajaxloadingmodal"><img src="<?php echo base_url('assets/images/ajaxloading.gif');?>" class="ajaxloadingimage" /></div>
            <div class="errormsgmodal alert alert-danger" style="display:none;"></div>
            <div class="successmsgmodal alert alert-success" style="display:none;"></div>
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
