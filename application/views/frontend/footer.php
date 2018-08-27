<?php $sitemanagementdata = getsitemanagementdata(); ?>
<footer>
  <div class="container">
    <div class="inputarea">
      <input type="email" class="newsletter" placeholder="ENTER EMAIL ADDRESS">
      <input type="button" class="newsletterbtn" value="submit">
    </div>
    <div class="clearfix"></div>
    <ul>
      <li><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo base_url('blog'); ?>">Blog</a></li>
      <li><a href="<?php echo base_url('project'); ?>">Project</a></li>
      <li><a href="<?php echo base_url('sitemap.xml'); ?>" target="_blank">Sitemap</a></li>
      
    </ul>
        <p>
        <a style="font-size:14px;" href="tel:<?php echo $sitemanagementdata['phone']; ?>"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $sitemanagementdata['phone']; ?></a> 
        |
	     <a style="font-size:14px;" href="https://goo.gl/maps/m5cbbtwEgMw" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> <?php echo $sitemanagementdata['address']; ?> </a>
	     </p>
	
        
    
    <p><?php echo $sitemanagementdata['copyright']; ?></p>
  </div>
</footer>
</div>
<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>js/bootstrap.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>js/jquery.meanmenu.js"></script> 
<script src="https://use.fontawesome.com/373a347df2.js"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/frontend/'); ?>js/slick.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>js/owl.carousel.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/frontend/'); ?>js/jquery.sudoSlider.min.js"></script> 
<script src="<?php echo base_url('assets/frontend/'); ?>js/custom.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
<script src="<?php echo base_url('assets/frontend/'); ?>js/ie10-viewport-bug-workaround.js"></script>
<script src="<?php echo base_url('assets/'); ?>js/jquery.toaster.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    $(document).on('click', '.newsletterbtn', function(){
		var email = $(document).find('.newsletter').val();
		if(email == '') {
			$.toaster({ priority : 'danger', title : 'Error', message : 'Please type an valid email address'});
		} 
		else {
			 if (validateEmail(email)) {
	            jQuery.ajax({
					type: "POST",
					url: '<?php echo base_url('user/newsletter'); ?>',
					data: { 
							'email' : email,
						},
					dataType: "json",
					success: function(responce) {
						var error = responce.error;
						var success = responce.success;
						if (success === 0) {
							$.toaster({ priority : 'danger', title : 'Error', message : responce.msg});
						} else {
							$.toaster({ priority : 'success', title : 'Error', message : responce.msg});
							$(document).find('.newsletter').val('');
						}
					}
				});
	        }
	        else {
	            $.toaster({ priority : 'danger', title : 'Error', message : 'Please type an valid email address'});
				return false;
	        }	
		}
	});
	
	function validateEmail(sEmail) {
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if (filter.test(sEmail)) {
			return true;
		}
		else {
			return false;
		}
	}

});

</script>
<script type="text/javascript">
$(document).on('click', '.anir', function(){
  document.getElementById("myNav").style.width = "0%";
  var width  = $( document ).width();
  var inc = 0;
  /*if(width < 768) {
   inc = -46;
  }*/
  if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
   || location.hostname == this.hostname) {

   var target = $(this.hash);
   target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
     $('html,body').animate({
      scrollTop: (target.offset().top + inc)
    }, 1000);
    return false;
   }
  }
 }); 
 
 
 $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
      document.getElementById("myNav").style.width = "0%";
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
 
</script>


</body></html>