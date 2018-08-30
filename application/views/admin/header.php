<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!--<link rel="icon" href="<?php echo ASSETS_URL.'assets/frontend/'; ?>images/favicon.png">-->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!--select2 css-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- Bootstrap time Picker -->
  <!--<link rel="stylesheet" href="<?php echo ASSETS_URL.'assets/'; ?>plugins/timepicker/bootstrap-timepicker.min.css">-->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>  
	.ajaxloading { float: right; height: 50px; width: 50px; display:none; }
	.ajaxloadingmodal { float: right; height: 50px; width: 50px; display:none; }
	.ajaxloadingimage { width: 100%; }
	.pointer { cursor: pointer; }
	.fa-thumbs-o-down { color:#f00; }
	.fa-thumbs-o-up { color:#0C0; }
	.required { color:#f00; }
	.onlypointer { cursor:pointer; }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini" onLoad="display_ct();">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(''); ?>" class="logo">
    <?php $sitemanagementdata = getsitemanagementdata(); ?>
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo $sitemanagementdata['shorttitle'] ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $sitemanagementdata['title'] ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <?php 
        $identitydocument = $this->db->get_where('identitydocument', array('status'=>0))->result_array();
		$identitycount = count($identitydocument);
		$count = count($identitydocument);
        ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
          <?php
          	$admindata = getadmindata();
		  ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo ASSETS_URL.ADMIN_DP_UPLOAD_URL.$admindata['imagename']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $admindata['firstname'].' '.$admindata['lastname']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo ASSETS_URL.ADMIN_DP_UPLOAD_URL.$admindata['imagename']; ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $admindata['firstname'].' '.$admindata['lastname']?> - Admin
                  <script type="text/javascript">
					function display_c(){
					var refresh=1000; // Refresh rate in milli seconds
					mytime=setTimeout('display_ct()',refresh)
					}
					
					function display_ct() {
					var strcount
					var x = new Date()
					var datetime = "Now: " + x.getDate() + "/"
                					+ (x.getMonth()+1)  + "/" 
                					+ x.getFullYear() + " @ "  
                					+ x.getHours() + ":"  
                					+ x.getMinutes() + ":" 
                					+ x.getSeconds();
					document.getElementById('ct').innerHTML = datetime;
					tt=display_c();
					}
				  </script>

                  <small id="ct"></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('admin/profile'); ?>" class="btn btn-primary btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url('admin/logout'); ?>" class="btn btn-primary btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url().ADMIN_DP_UPLOAD_URL.$admindata['imagename']; ?>" style="height:35px; width:35px;" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $admindata['firstname'].' '.$admindata['lastname']?></p>
          <a href="javascript:void(0)"><i class="fa fa-circle text-success" style="color:#00ff11"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <div class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control searchtype" autocomplete="off" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Control Panel</li>
        <li class="<?php if($this->uri->segment(2) == '') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'sub-service-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/sub-service-management'); ?>">
            <i class="fa fa-cogs"></i> <span>Service Management</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'plan-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/plan-management'); ?>">
            <i class="fa fa-cogs"></i> <span>Plan Management</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'offer') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/offer'); ?>">
            <i class="fa fa-cogs"></i> <span>Offer Management</span>
          </a>
        </li>
       <li class="<?php if($this->uri->segment(2) == 'banner-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/banner-management'); ?>">
            <i class="fa fa-picture-o"></i> <span>Banner Management</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'site-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/site-management'); ?>">
            <i class="fa fa-sitemap"></i> <span>Site Management</span>
          </a>
        </li>
        <li class="treeview <?php if($this->uri->segment(2) == 'blog-management' || $this->uri->segment(2) == 'blog-tag-management' || $this->uri->segment(2) == 'blog-category-management') { echo 'active'; }?>">
          <a href="javascript:void(0);">
            <i class="fa fa-rss"></i>
           <span>Blog Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(2) == 'blog-category-management') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/blog-category-management'); ?>"><i class="fa fa-rss"></i> <span>Category Management</span></a>
        	</li>
           <li class="<?php if($this->uri->segment(2) == 'blog-management') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/blog-management'); ?>"><i class="fa fa-rss"></i> <span>Blog Management</span></a>
        	</li>
          </ul>
        </li>
        <li class="treeview <?php if($this->uri->segment(2) == 'homepagemanagement') { echo 'active'; }?>">
          <a href="javascript:void(0);">
            <i class="fa fa-file-text"></i>
           <span>Pages Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(2) == 'homepagemanagement') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/homepagemanagement'); ?>"><i class="fa fa-file-text"></i> <span>Home Page</span></a>
        	</li>
        	<li class="<?php if($this->uri->segment(2) == 'project-page-management') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/project-page-management'); ?>"><i class="fa fa-file-text"></i> <span>Project Page</span></a>
        	</li>
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'testimonial-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/testimonial-management'); ?>">
            <i class="fa fa-comments"></i> <span>Testimonial Management</span>
          </a>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'project-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/project-management'); ?>">
            <i class="fa fa-building-o"></i> <span>Project Management</span>
          </a>
        </li>
        <li class="treeview <?php if($this->uri->segment(2) == 'seo-management') { echo 'active'; }?>">
          <a href="javascript:void(0);">
            <i class="fa fa-file-text"></i>
           <span>SEO Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($this->uri->segment(3) == '1') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/seo-management/1'); ?>"><i class="fa fa-file-text"></i> <span>Home Page</span></a>
        	</li> 
            <li class="<?php if($this->uri->segment(3) == '2') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/seo-management/2'); ?>"><i class="fa fa-file-text"></i> <span>Blog Page</span></a>
        	</li>
        	<li class="<?php if($this->uri->segment(3) == '3') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/seo-management/3'); ?>"><i class="fa fa-file-text"></i> <span>Blog Details Page</span></a>
        	</li> 
            <li class="<?php if($this->uri->segment(3) == '4') { echo 'active'; }?>">
          		<a href="<?php echo base_url('admin/seo-management/4'); ?>"><i class="fa fa-file-text"></i> <span>Project Page</span></a>
        	</li>
        	
          </ul>
        </li>
        <li class="<?php if($this->uri->segment(1) == 'newsletter-management') { echo 'active'; }?>">
          <a href="<?php echo base_url('admin/newsletter'); ?>">
            <i class="fa fa-envelope"></i> <span>Newsletter Management</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>