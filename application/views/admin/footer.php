<footer class="main-footer" style="min-height:50px;">
<?php $sitemanagementdata = getsitemanagementdata(); ?>
  <div class="pull-right hidden-xs"> <b>Version</b> <?php echo $sitemanagementdata['version']; ?> </div>
  <strong><?php echo $sitemanagementdata['copyright']; ?></strong>
</footer>

<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<input type="hidden" class="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" class="assets_url" value="<?php echo ASSETS_URL; ?>">
<!-- ./wrapper -->
<!-- jQuery 3 -->
<!--<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>-->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ASSETS_URL.'assets/'; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<!--<script src="<?php echo ASSETS_URL.'assets/'; ?>frontend/js/bootstrap-timepicker.min.js"></script>-->
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- DataTables -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>dist/js/demo.js"></script>
<!--toaster js-->
<script src="<?php echo ASSETS_URL.'assets/'; ?>js/jquery.toaster.js"></script>
<!--select2 js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/morris.js/morris.min.js"></script>
<!-- CK Editor -->
<script src="<?php echo ASSETS_URL.'assets/'; ?>bower_components/ckeditor/ckeditor.js"></script>
<!--custom added js-->
<script src="<?php echo ASSETS_URL.'assets/'; ?>js/common.js"></script>
</body></html>