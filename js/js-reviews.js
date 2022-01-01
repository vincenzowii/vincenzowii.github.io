$(function() {
  $('#rate').barrating({
    theme: 'css-stars'
  });
});

function onloadCallback() {
  console.log('1');
}

$(".rws__card-reply-btn").each(function(index) {
  $(this).click(function() {
    $(this).toggleClass("rws__card-reply-btn--active");
    $(this).parent().next().toggleClass("rws__card-form--visible");
  });
});

$(".rws__card-rate-bar").each(function(index) {
  $(this).barrating({
    theme: 'fontawesome-stars'
  });
});

$('.feedback-rate').click(function () {
    var l = $(this);
    var t = $(l).data('type');
    var p = $(l).data('id');

    $.get({
        url: '/feedback/rate',
        data: {type: t, id: p},
    }).done(function (data) {
        if (data == 'ok') {
            $(l).children('span').text(parseInt($(l).children('span').text()) + 1);
            $(l).addClass('has-votes');
        }
    })
})
