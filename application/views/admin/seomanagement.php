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
    <h1> SEO Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">SEO Management</li>
    </ol>
  </section>
  <!-- Main content -->
  <?php $pageid = $this->uri->segment(3); 
  	$pagedetails = $this->db->get_where('pages', array('id'=>$pageid))->row_array();
  	
	$seodetails = $this->db->get_where('seomanagement', array('pageid'=>$pageid))->row_array();

  ?>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-slack"></i>
            <h3 class="box-title"><?php echo $pagedetails['title'];  ?> SEO Management</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <form class="sitemanageform" enctype="multipart/form-data">
              <div class="col-md-12">
              	<div class="col-md-3"><i class="fa fa-slack"></i> Meta Description</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $seodetails['description']; ?>" name="description" placeholder="Enter Meta Description" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-slack"></i> Meta Keywords</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $seodetails['keyword']; ?>" name="keyword" placeholder="Enter Meta Keywords Separete by a comma" type="text">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-slack"></i> Meta Author</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $seodetails['author']; ?>" name="author" placeholder="Enter Meta Author" type="email">
                </div>
                <input type="hidden" name="pageid" value="<?php echo $pageid; ?>" />
                <div class="clearfix"></div>
                <div class="col-md-3"><i class="fa fa-slack"></i> Meta Title</div>
                <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="<?php echo $seodetails['title']; ?>" name="title" placeholder="Enter Meta Title" type="email">
                </div>
                <input type="hidden" name="pageid" value="<?php echo $pageid; ?>" />
                <div class="clearfix"></div>
                <div class="col-md-12" style="text-align:right;">
                	<button type="button" class="btn btn-primary updateseomanage"><i class="fa fa-wrench"></i> Update SEO Management</button> 
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