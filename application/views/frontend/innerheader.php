<!DOCTYPE html>
<html lang="en">
<head>
    <?php
      $sitemanagementdata = getsitemanagementdata();
      ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="<?php echo $seo['description']; ?>">
<meta name="keywords" content="<?php echo $seo['keyword']; ?>">
<meta name="author" content="<?php echo $seo['author']; ?>">
<link rel="icon" href="favicon.ico">
<title><?php echo $seo['title']; ?></title>
<!-- Bootstrap core CSS -->

<link href="<?php echo base_url('assets/frontend/'); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="<?php echo base_url('assets/frontend/'); ?>css/sudo.css" rel="stylesheet">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/'); ?>css/owl.theme.default.css" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/'); ?>css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/'); ?>css/owl.theme.css" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/'); ?>css/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/'); ?>css/slick.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/'); ?>css/slick-theme.css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="<?php echo base_url('assets/frontend/'); ?>css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="wrapper">
<header data-spy="affix" data-offset-top="10" class="menu">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 col-xs-6">
          <div class="logo"><a href="<?php echo base_url(); ?>">PATCY CON</a></div>
        </div>
        <div class="col-sm-7 col-xs-6">
          <div class="right_side"> <a style="font-size:14px;" href="tel:<?php echo $sitemanagementdata['phone']; ?>" class="desktop"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $sitemanagementdata['phone']; ?> </a> 
	     <a style="font-size:14px;" href="https://goo.gl/maps/m5cbbtwEgMw" target="_blank" class="desktop">  <i class="fa fa-home" aria-hidden="true"></i> <?php echo $sitemanagementdata['address']; ?> </a>
	     
		  <a style="font-size:14px;" href="tel:<?php echo $sitemanagementdata['phone']; ?>" class="mobile">
		      <i class="fa fa-phone" aria-hidden="true"></i> </a>
		  <a style="font-size:14px; margin-left:10px;" class="mobile" href="https://goo.gl/maps/m5cbbtwEgMw"><i class="fa fa-home" aria-hidden="true"></i></a>
        </div>
      </div>
      <img src="<?php echo base_url('assets/frontend/'); ?>images/menu-icon.png" class="micon" onclick="openNav()"> </div>
    <div id="myNav" class="overlay"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content"> 
        <a href="<?php echo base_url(); ?>">home</a> 
        <a class="anir" href="<?php echo base_url(); ?>#wholeconst">about us</a> 
        <a class="anir" href="<?php echo base_url(); ?>#what_we">what we do</a>
        <a  class="anir" href="<?php echo base_url(); ?>#servicesweprovide">services</a>
        <a href="<?php echo base_url('blog'); ?>">blog</a> 
        <a class="anir" href="<?php echo base_url(); ?>#testimonialblock">testimonial</a> 
        <!--<a href="#">our team</a>-->
        <a href="<?php echo base_url('project'); ?>">Project</a>
      </div>
    </div>
  </header>