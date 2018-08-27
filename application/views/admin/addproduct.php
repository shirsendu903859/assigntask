<!-- Content Wrapper. Contains page content -->
<style>
.colorccc { color:#999; }
.logodetails { float:right; cursor:pointer; }
.pointer { margin-right:15px; }
.checkbox { display:inline; }
label { font-weight:normal; }
.multipleimagepreviewclass { max-width:100%; }
.select2-selection__choice { color: #333 !important; }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Site Management </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('admin/product-management');?>">Product Management</a></li>
      <li class="active">Add Product</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header"> <i class="fa fa-plus"></i>
            <h3 class="box-title">Add Product</h3>
          </div>
          <!-- /.box -->
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <form class="addproductform" enctype="multipart/form-data">
                <div class="col-md-12">
                  <div class="col-md-3">Product Title</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" value="" name="title" placeholder="Enter Product Title" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Product Category</div>
                  <div class="col-md-9 form-group">
                    <select class="form-control" class="categoryselect" name="category">
                      <?php if(isset($category) && !empty($category)) { ?>
                      <option>Choose Product Category</option>
                      <?php foreach($category as $key=>$val) { ?>
                      <option value="<?php echo $val['id']; ?>" <?php if($val['parent'] == 0) { ?> style="font-weight:800;" <?php } ?>><?php echo $val['title']; ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                  <div class="clearfix"></div>
                  <div class="attrblock">
                    <div class="col-md-3">Product Attribute</div>
                    <div class="col-md-9 form-group">
                      <select class="form-control parentattribute" name="parentattribute[]">
                        <?php if(isset($attribute) && !empty($attribute)) { ?>
                        <option>Choose Product Attribute</option>
                        <?php foreach($attribute as $key=>$val) { ?>
                        <option value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?></option>
                        <?php } } ?>
                      </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="childattr"></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-12" style="margin-bottom:15px;">
                    <button class="btn btn-primary addattribute pull-right" type="button"><i class="fa fa-plus"></i> Add Another Attribute</button>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3"> Product Description</div>
                  <div class="col-md-9 form-group">
                    <textarea id="editor1" name="description" rows="10" cols="80"></textarea>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3"> Stock</div>
                  <div class="col-md-9 form-group">
                    <label class="col-md-4">In Stock: &nbsp;&nbsp; <input type="checkbox" name="stockstatus" value="<?php echo IN_STOCK; ?>" class="checkbox" /></label>
                    <label class="col-md-4">Out Of Stock: &nbsp;&nbsp; <input type="checkbox" name="stockstatus" value="<?php echo OUT_OF_STOCK; ?>" class="checkbox" /></label>
                    <label class="col-md-4">Coming Soon: &nbsp;&nbsp; <input type="checkbox" name="stockstatus" value="<?php echo COMING_SOON; ?>" class="checkbox" /></label>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3"> Quantity</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="" name="quantity" placeholder="Enter Product Quantity" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Original Price</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="" name="price" placeholder="Enter Product Original Price" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Discounted Price</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="" name="discountprice" placeholder="Enter Discount Price" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Merchant Name</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="" name="merchant" placeholder="Enter Merchant Name" type="text">
                  </div>
                  <div class="col-md-3">Upload Product Image</div>
                  <div class="col-md-9 form-group">
                    <input name="productimage[]" multiple class="uploadnewproductimage col-sm-9" data-inc="1" style="margin-top:4px;" id="exampleInputFile" type="file">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Shipping Charge</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="50" name="shipping" placeholder="Enter Shipping Charges ( INR )" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-3">Delivery</div>
                  <div class="col-md-9 form-group">
                    <input class="form-control" id="exampleInputEmail1" value="10" name="delivrey" placeholder="Enter Delivery Days" type="text">
                  </div>
                  <div class="clearfix"></div>
                  <div class="clearfix"></div>
                  <div class="form-group col-md-12">
                      <div class="logoimagenew col-md-3" style="height:100px; width:100px;"> <img src="" class="newlogouploadclass1" style="width:100%; display:none;" /> </div>
                      <div class="showimage">
                      
                      </div>
                  <div class="clearfix"></div>
                  <div class="col-md-12" style="text-align:right;">
                    <button type="button" class="btn btn-primary addproductbtn"><i class="fa fa-shopping-bag"></i>&nbsp; Add Product</button>
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
