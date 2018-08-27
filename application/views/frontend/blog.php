<div class="banner innerban">
  <div class="ban">
  <?php if(isset($banner) & !empty($banner)) { foreach($banner as $key=>$val){ ?>
    <div> <img src="<?php echo base_url().BANNER_UPLOAD_URL.$val['imagename']; ?>" alt=""> </div>
  <?php } } ?>
  </div>
  <div class="container">
    <div class="inbancont">
      <h1>dream come true</h1>
    </div>
  </div>
</div>
<div class="inner_cont">
  <div class="shortingarea">
    <div class="container">
      <div class="button-group filters-button-group">
        <button class="button is-checked" data-filter="*">all</button>
       	<?php if(isset($category) && !empty($category)) { foreach($category as $key=>$val) { ?>
        <button class="button" data-filter=".<?php echo $val['titleen'] ?>"><?php echo $val['titleen'] ?></button>
        <?php } } ?>
      </div>
      <div class="grid">
      <?php if(isset($blog) && !empty($blog)) { foreach($blog as $key=>$val) { ?>
        <div class="element-item <?php echo $val['categoryname']; ?>" data-category="<?php echo $val['categoryname']; ?>"> 
          <a href="<?php echo base_url().'blog-details/'.str_replace(' ', '-', strtolower($val['titleen'])).'/'.$val['id']; ?>">
              <img src="<?php echo ASSETS_URL.BLOG_IMAGE_UPLOAD_URL.$val['imagename'];?>" alt="">
              <h5><?php echo $val['titleen'];  ?></h5>
              <h6>Date <?php echo $val['datetime']; ?></h6>
          </a>
        </div>
      <?php } } ?>  
      </div>
    </div>
  </div>
</div>
