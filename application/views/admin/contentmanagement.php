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
                    <th>Assign</th>
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
                    <td><a href="<?php echo base_url('admin/assigncontent/'.$val['id']) ?>" class="btn btn-primary">Assign Statement</a></td>
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
