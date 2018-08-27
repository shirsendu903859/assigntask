// JavaScript Document


$(window).on('load', function() { // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(350).css({'overflow-x':'hidden'});
})

var BASE_URL = "index.html";

jQuery(document).ready(function () {
	jQuery('.navigation nav').meanmenu();
	
	
	
});

 /***WOW.prototype.addBox = function(element) {
    this.boxes.push(element);
  };

  var wow = new WOW();
  wow.init();


  $('.wow').on('scrollSpy:exit', function() {
    $(this).css({
      'visibility': 'hidden',
      'animation-name': 'none'
    }).removeClass('animated');
    wow.addBox(this);
  }).scrollSpy();


***/


/**$(document).ready(function(){						
			var sudoSlider = $("#slider2").sudoSlider({
				responsive: true,
				 auto:true,
				 speed: 2000,
				 pause:4000,
                prevNext:true,
				numeric:false,
				continuous:true,
                slideCount: 1,
				effect: 'slide'
			});
			
		});
		$(document).ready(function() {
     
      var owl = $("#owl-demo-ban");
     
      owl.owlCarousel({
          items : 1, //10 items above 1000px browser width
          itemsDesktop : [1000,1], //5 items between 1000px and 901px
          itemsDesktopSmall : [900,1], // betweem 900px and 601px
          itemsTablet: [600,1], //2 items between 600 and 0
          itemsMobile : [479,1], // itemsMobile disabled - inherit from itemsTablet option
		   autoPlay : true,
		   navigation : true,
		  pagination : false
      });
     
     
     
    });
		
    $(document).ready(function() {
     
      var owl = $("#owl-demo");
     
      owl.owlCarousel({
          items : 3, //10 items above 1000px browser width
          itemsDesktop : [1000,2], //5 items between 1000px and 901px
          itemsDesktopSmall : [900,2], // betweem 900px and 601px
          itemsTablet: [600,2], //2 items between 600 and 0
          itemsMobile : [479,1], // itemsMobile disabled - inherit from itemsTablet option
		   autoPlay : true,
		   navigation : true,
		  pagination : false
      });
     
     
     
    });
	
	 $(document).ready(function() {
     
      var owl = $("#owl-demo-two");
     
      owl.owlCarousel({
          items : 3, //10 items above 1000px browser width
          itemsDesktop : [1000,2], //5 items between 1000px and 901px
          itemsDesktopSmall : [900,2], // betweem 900px and 601px
          itemsTablet: [600,2], //2 items between 600 and 0
          itemsMobile : [479,1], // itemsMobile disabled - inherit from itemsTablet option
		   autoPlay : true,
		   navigation : true,
		  pagination : false
      });
     
     
     
    });***/






 equalheight = function(container){
 var currentTallest = 0,
      currentRowStart = 0,
      rowDivs = new Array(),
      $el,
      topPosition = 0;
  $(container).each(function() {
    $el = $(this);
    $($el).height('auto')
    topPostion = $el.position().top;
    if (currentRowStart != topPostion) {
      for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
     rowDivs.length = 0; // empty the array
      currentRowStart = topPostion;
      currentTallest = $el.height();
      rowDivs.push($el);
    } else {
      rowDivs.push($el);
      currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
   }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
      rowDivs[currentDiv].height(currentTallest);
    }
  });
 }


$(window).load(function(){
 
  equalheight('.same');
  equalheight('.imgsec');
   equalheight('.same_agn');
    equalheight('.lorem p');
});

  
$(window).resize(function(){
  equalheight('.same');
  equalheight('.imgsec');
   equalheight('.same_agn');
    equalheight('.lorem p');
 
  
});



$('.respons').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,

  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


$('.responsive').slick({
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 2,
  slidesToScroll: 1,

  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


$('.ban').slick({
  dots: true,
  nav:false,
  infinite: true,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,

  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		 nav:false
        
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		nav:false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
		nav:false
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});

$(document).ready(function(){
    $("#one").click(function(){
        $("#one").addClass("active");
		$("#two").removeClass("active");
		 $("#three").removeClass("active");
		   $("#four").removeClass("active");
    });
	$("#one_one").click(function(){
        $("#one").addClass("active");
		$("#two").removeClass("active");
		 $("#three").removeClass("active");
		   $("#four").removeClass("active");
    });
	$("#two").click(function(){
        $("#one").removeClass("active");
		 $("#two").addClass("active");
		  $("#three").removeClass("active");
		   $("#four").removeClass("active");
    });
	$("#one_two").click(function(){
        $("#one").removeClass("active");
		 $("#two").addClass("active");
		  $("#three").removeClass("active");
		   $("#four").removeClass("active");
    });
	
	$("#three").click(function(){
        $("#one").removeClass("active");
		 $("#two").removeClass("active");
		  $("#three").addClass("active");
		   $("#four").removeClass("active");
    });
	
	$("#one_three").click(function(){
        $("#one").removeClass("active");
		 $("#two").removeClass("active");
		  $("#three").addClass("active");
		   $("#four").removeClass("active");
    });
	
	$("#four").click(function(){
        $("#one").removeClass("active");
		 $("#two").removeClass("active");
		  $("#three").removeClass("active");
		   $("#four").addClass("active");
    });
	
	$("#one_four").click(function(){
        $("#one").removeClass("active");
		 $("#two").removeClass("active");
		  $("#three").removeClass("active");
		   $("#four").addClass("active");
    });
});

$('.carousel').carousel({
    interval: false
}); 


initSlider();

function initSlider() {
  $(".owl-carousel").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
	dots:false,
    onInitialized: startProgressBar,
    onTranslate: resetProgressBar,
    onTranslated: startProgressBar
  });
}


function startProgressBar() {
  // apply keyframe animation
  $(".slide-progress").css({
    width: "100%",
    transition: "width 5000ms"
	
  });
}

function resetProgressBar() {
  $(".slide-progress").css({
    width: 0,
    transition: "width 0s"
  });
}

function openNav() {
    document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}



// external js: isotope.pkgd.js

// init Isotope
var $grid = $('.grid').isotope({
  itemSelector: '.element-item',
  layoutMode: 'fitRows'
});
// filter functions
var filterFns = {
  // show if number is greater than 50
  numberGreaterThan50: function() {
    var number = $(this).find('.number').text();
    return parseInt( number, 10 ) > 50;
  },
  // show if name ends with -ium
  ium: function() {
    var name = $(this).find('.name').text();
    return name.match( /ium$/ );
  }
};
// bind filter button click
$('.filters-button-group').on( 'click', 'button', function() {
  var filterValue = $( this ).attr('data-filter');
  // use filterFn if matches value
  filterValue = filterFns[ filterValue ] || filterValue;
  $grid.isotope({ filter: filterValue });
});
// change is-checked class on buttons
$('.button-group').each( function( i, buttonGroup ) {
  var $buttonGroup = $( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    $buttonGroup.find('.is-checked').removeClass('is-checked');
    $( this ).addClass('is-checked');
  });
});
