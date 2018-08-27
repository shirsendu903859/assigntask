<div class="banner">
  <div class="mainban"> 
    <!-- <div class="left_pic same">
      <img src="images/banner1.png" alt="">
    </div>
    <div class="right_pic same">
      <img src="images/banner2.png" alt="">
    </div>-->
    <div class="ban">
    <?php if(isset($bannerdata) && !empty($bannerdata)) { foreach($bannerdata as $key=>$val) { ?>
      <div> <img src="<?php echo base_url().BANNER_UPLOAD_URL.$val['imagename']; ?>" alt=""> </div>
    <?php } } ?>
    </div>
    <div class="clearfix"></div>
    <div class="social">
      <ul>
      <?php if(isset($sitedata['facebook']) && $sitedata['facebook'] != '') { ?>
        <li><a href="<?php echo $sitedata['facebook']; ?>"><i class="fa fa-facebook-f"></i></a></li>
      <?php } ?>
      <?php if(isset($sitedata['twitter']) && $sitedata['twitter'] != '') { ?>
        <li><a href="<?php echo $sitedata['twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
      <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container">
    <div class="banner_contact">
      <div class="navigation">
        <nav>
          <ul>
            <li><a class="anir" href="#wholeconst">about us</a></li>
            <li><a class="anir" href="#what_we">what we offer?</a></li>
            <li><a class="anir" href="#servicesweprovide">services</a></li>
            <li><a href="<?php echo base_url('blog'); ?>">blog</a></li>
            <li><a class="anir" href="#testimonialblock">testimonial</a></li>
            <!--<li class="pro"><a href="<?php //echo base_url('project'); ?>">Project</a></li>-->
          </ul>
        </nav>
      </div>
      <div class="small_nav"></div>
      <div class="right_text">
        <ul>
          <li><a href="<?php echo base_url('project'); ?>">Project</a></li>
          <!--<li>completedprojects</li>-->
        </ul>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
<div class="inner_cont">
  <div class="what_we" id="what_we">
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
          <div class="we_box">
            <h3>WHAT WE OFFER ?</h3>
            <?php echo $content['one']; ?>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="responsive">
          <?php if(isset($offer) && !empty($offer)) { foreach($offer as $key=>$val) { ?>
            <div>
              <div class="lorem same_agn">
                <div class="imgsec"> <img src="<?php echo base_url().SERVICE_UPLOAD_URL.$val['imagename']; ?>" alt=""> </div>
                <?php echo $val['description']; ?>
                <h4><?php echo $val['title'] ?></h4>
              </div>
            </div>
          <?php } } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="wholeconst" id="wholeconst">
    <div class="contsruct">
      <div class="container">
        <div class="row">
          <div class="col-sm-7">
            <div class="lft_pad">
              <h2>we construct <span>experience</span></h2>
              <?php echo $content['two']; ?>
            </div>
          </div>
          <div class="col-sm-5"> <img src="<?php echo base_url().RESOURCES_UPLOAD_URL.$content['image1']; ?>" alt=""> </div>
        </div>
      </div>
    </div>
    <div class="contsruct">
      <div class="container">
        <div class="row">
          <div class="col-sm-7">
            <div class="lft_pad">
              <h2>we construct <span>experience</span></h2>
              <?php echo $content['three']; ?>
            </div>
          </div>
          <div class="col-sm-5"> <img src="<?php echo base_url().RESOURCES_UPLOAD_URL.$content['image2']; ?>" alt=""> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="service" id="servicesweprovide">
    <div class="container">
      <h2>service we provide</h2>
      <!--carosel-->
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <div class="row">
          <div class="col-sm-7"> 
            <!-- Indicators -->
            <ol class="carousel-indicators">
              <?php if(isset($service) && !empty($service)) { foreach($service as $key=>$val) { ?>
              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?>" id="<?php echo $key; ?>" class="<?php if($key == 0) { ?> active <?php } ?>"><span><?php echo $val['title']; ?></span></li>
              <?php } } ?>
            </ol>
            
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
            <?php if(isset($service) && !empty($service)) { foreach($service as $key=>$val) { ?>
              <div class="item <?php if($key == 0) { ?> active <?php } ?>">
                <div class="text_slide">
                  <?php echo $val['description']; ?>
                </div>
              </div>
            <?php } } ?>
            </div>
          </div>
          <div class="col-sm-5">
            <ol class="extra_pointer">
              <?php if(isset($service) && !empty($service)) { foreach($service as $key=>$val) { ?>
              <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?>" id="<?php echo $key; ?>" class="<?php if($key == 0) { ?> active <?php } ?>"><span><?php echo $val['title']; ?></span></li>
              <?php } } ?>
              <!--<li data-target="#carousel-example-generic" data-slide-to="1" id="two" ><span>Lorem dolor tincidunt</span></li>
              <li data-target="#carousel-example-generic" data-slide-to="2" id="three"><span>consectetur adipiscing</span></li>
              <li data-target="#carousel-example-generic" data-slide-to="3" id="four"><span>consectetur elit</span></li>-->
            </ol>
          </div>
        </div>
      </div>
      
      <!--end--> 
      
    </div>
  </div>
  <div class="client" id="testimonialblock">
    <div class="container">
      <h2>what client speak about us</h2>
      <div class="owl-demo">
        <div class="owl-carousel owl-theme">
        <?php if(isset($testimonial) && !empty($testimonial)) { foreach($testimonial as $key=>$val) { ?>
          <div class="item">
            <div class="maincont"> <i class="fas fa-quote-left"></i>
              <?php echo $val['testimonial']; ?>
              <h4><?php echo $val['name']; ?></h4>
            </div>
          </div>
        <?php } } ?>
          <!--<div class="item">
            <div class="maincont"> <i class="fas fa-quote-left"></i>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In maximus ipsum quis pellentesque gravida. Vivamus sit amet tortor at risus luctus iaculis. Phasellus enim metus, venenatis in enim ac, sagittis accumsan ligula. Phasellus cursus, lectus eget consequat mollis, magna orci varius quam, at euismod augue ex id nisl. Duis pulvinar tincidunt nunc, vitae ultrices sem bibendum in. Vestibulum commodo velit sit amet maximus sollicitudin. Vivamus convallis et felis eu sagittis.Aenean erat velit, interdum sit amet orci non, convallis viverra massa. Praesent quis vestibulum nibh. Aliquam tempus diam ut rutrum dapibus. Pellentesque pellentesque ligula non porttitor volutpat. Aenean in enim ac nunc ornare molestie. Integer et tincidunt arcu. Integer rutrum dolor eget nisl egestas semper. In enim urna, blandit sit amet scelerisque quis, fermentum in libero. Sed suscipit fermentum metus mattis vulputate. Nunc a mi consequat, pretium orci vel, egestas tortor. Vestibulum id felis erat. Quisque eros risus, interdum sit amet diam eu, tincidunt mattis mi. Mauris egestas augue vehicula enim semper imperdiet.</p>
              <h4>LOREM IPSUM</h4>
            </div>
          </div>
          <div class="item">
            <div class="maincont"> <i class="fas fa-quote-left"></i>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In maximus ipsum quis pellentesque gravida. Vivamus sit amet tortor at risus luctus iaculis. Phasellus enim metus, venenatis in enim ac, sagittis accumsan ligula. Phasellus cursus, lectus eget consequat mollis, magna orci varius quam, at euismod augue ex id nisl. Duis pulvinar tincidunt nunc, vitae ultrices sem bibendum in. Vestibulum commodo velit sit amet maximus sollicitudin. Vivamus convallis et felis eu sagittis.Aenean erat velit, interdum sit amet orci non, convallis viverra massa. Praesent quis vestibulum nibh. Aliquam tempus diam ut rutrum dapibus. Pellentesque pellentesque ligula non porttitor volutpat. Aenean in enim ac nunc ornare molestie. Integer et tincidunt arcu. Integer rutrum dolor eget nisl egestas semper. In enim urna, blandit sit amet scelerisque quis, fermentum in libero. Sed suscipit fermentum metus mattis vulputate. Nunc a mi consequat, pretium orci vel, egestas tortor. Vestibulum id felis erat. Quisque eros risus, interdum sit amet diam eu, tincidunt mattis mi. Mauris egestas augue vehicula enim semper imperdiet.</p>
              <h4>LOREM IPSUM</h4>
            </div>
          </div>-->
        </div>
        <div class="bar">
          <div class="slide-progress"></div>
        </div>
      </div>
    </div>
  </div>
</div>
