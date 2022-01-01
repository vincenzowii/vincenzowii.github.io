$(document).ready(function () {
    var letCollapseWidth = false,
        paddingValue = 30,
        sumWidth = $('.navbar-right-block').width() + $('.navbar-left-block').width() + $('.navbar-brand').width() + paddingValue;

    $(window).on('resize', function () {
        navbarResizerFunc();
    });

    var navbarResizerFunc = function navbarResizerFunc() {
        if (sumWidth <= $(window).width()) {
            if (letCollapseWidth && letCollapseWidth <= $(window).width()) {
                $('#navbar').addClass('navbar-collapse');
                $('#navbar').removeClass('navbar-collapsed');
                $('nav').removeClass('navbar-collapsed-before');
                letCollapseWidth = false;
            }
        } else {
            $('#navbar').removeClass('navbar-collapse');
            $('#navbar').addClass('navbar-collapsed');
            $('nav').addClass('navbar-collapsed-before');
            letCollapseWidth = $(window).width();
        }
    };

    if ($(window).width() >= 768) {
        navbarResizerFunc();
    }
});

<!-- A_basit Custom JQuery -->

$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
if ($(window).width() < 1199) {
  $('#wrapper').removeClass('toggled');
} else {
  $('#wrapper').addClass('toggled');
}

$(window).scroll(function() {    
  var scroll = $(window).scrollTop();

  if (scroll >= 50) {
    $(".dashboard nav.navbar").addClass("purpleNav");
  } else {
    $("nav.navbar").removeClass("purpleNav");
  }
});

$(document).ready(function() {
  	var windowHeight = $(window).height();
  	var	logoHeight = $('.sideBarLogo').height();
  	var finalHeight = (windowHeight - 66); 
    	$('ul.sidebar-nav').css({
      	height: finalHeight + "px"
    });  
});
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
