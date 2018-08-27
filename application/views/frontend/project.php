<div class="inner_cont">
  <div class="contsruct innercons">
    <div class="container">
      <div class="row">
        <div class="col-sm-7">
          <div class="lft_pad">
            <h2><?php echo $data['one']; ?></h2>
            <?php echo $data['two']; ?>
          </div>
        </div>
        <div class="col-sm-5"> <img src="<?php echo base_url().RESOURCES_UPLOAD_URL.$data['imageone']; ?>" alt=""> </div>
      </div>
    </div>
  </div>
  <div class="going">
    <div class="container">
      <h2>ongoing projects</h2>
      <div class="respons">
      <?php if(isset($ongoing) && !empty($ongoing)) { foreach($ongoing as $key=>$val) {?>
        <div>
          <div class="ingoing">
            <h4><?php echo $val['title']; ?></h4>
            <img src="<?php echo base_url().SERVICE_UPLOAD_URL.$val['imagename']; ?>" alt="">
            <ul>
              <li>Name</li>
              <li><?php echo $val['unit']; ?></li>
            </ul>
            <ul>
              <li>Address</li>
              <li><?php echo $val['price']; ?></li>
            </ul>
          </div>
        </div>
      <?php } } ?>
      </div>
    </div>
  </div>
  <div class="going">
    <div class="container">
      <h2>sucessful excetution</h2>
      <div class="respons">
      <?php if(isset($complete) && !empty($complete)) { foreach($complete as $key=>$val) {?>
        <div>
          <div class="ingoing">
            <h4><?php echo $val['title']; ?></h4>
            <img src="<?php echo base_url().SERVICE_UPLOAD_URL.$val['imagename']; ?>" alt="">
            <ul>
              <li>Name</li>
              <li><?php echo $val['unit']; ?></li>
            </ul>
            <ul>
              <li>Address</li>
              <li><?php echo $val['price']; ?></li>
            </ul>
          </div>
        </div>
      <?php } } ?>
      </div>
    </div>
  </div>
</div>
