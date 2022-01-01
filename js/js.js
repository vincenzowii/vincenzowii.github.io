$('a[href*="#"]')
.not('[href="#"]')
.not('[href="#0"]')
.click(function(event) {
  if (
    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
    &&
    location.hostname == this.hostname
  ) {
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    if (target.length) {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 1000, function() {
        var $target = $(target);
        $target.focus();
        if ($target.is(":focus")) {
          return false;
        } else {
          $target.attr('tabindex','-1');
          $target.focus();
        };
      });
    }
  }
});

$('.dropdown-toggle').click(function (e) {
    e.preventDefault();
    $(this).parent().toggleClass('active');
})

$('.header__toggler').click(function (e) {
    e.preventDefault();
    $(this).children('.ico').toggle();
    $('#mobile-nav').slideToggle();
})


//menu open on click
$(".header__link").each(function(index) {



  $(this).click(function(event) {


    $(".header__link").each(function() {
      $(this).removeClass("header__link--visible");
      $(this).children().eq(2).removeClass("header__drop--visible");
    });



    $(this).children().eq(2).addClass("header__drop--visible");
    $(this).addClass("header__link--visible");

  });
});


$(document).click(function(e) {
    if (!$(e.target).is('.header__link, .header__link *')) {
      $(".header__link").each(function() {
        $(this).removeClass("header__link--visible");
        $(this).children().eq(2).removeClass("header__drop--visible");
      });
    }
});

/*$('button:not(.close):not(.not-ajax)').click(function (e) {
    e.preventDefault();
    var f = $(this).closest('form');
    var b = $(this);

    $(f).prop('disabled', true);
    $(b).prop('disabled', true);

    $.ajax({
        type: $(f).attr('method'),
        url: $(f).attr('action'),
        data: $(f).serialize(),
        beforeSend: function (xhr, opts) {
            $(b).addClass('spin').append('<div class="lds-dual-ring"></div>');
        },
        complete: function () {
            $(b).removeClass('spin').removeAttr('disabled').children('.lds-dual-ring').remove();
        }
    });
})*/
