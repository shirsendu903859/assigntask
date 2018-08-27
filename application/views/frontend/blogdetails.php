<div class="banner">
  <div class="mainban"> 
    <img src="<?php echo ASSETS_URL.BLOG_IMAGE_UPLOAD_URL.$data['imagename'];?>" alt=""> </div>
</div>
<div class="inner_cont">
  <div class="shortingarea blgdtls">
    <div class="container">
      <div class="row">
        <div class="col-sm-7">
          <h2><?php echo $data['titleen']; ?></h2>
          <h4>posted on <?php echo $data['datetime'] ?></h4>
          <?php echo $data['descriptionen'] ?>
        </div>
      </div>
    </div>
  </div>
</div>
