$('.faq-item').click(function () {
    $(this).toggleClass('active');
    $(this).children('.faq-item__content').slideToggle();
})

$('#faq-list li a').click(function () {
    $('#faq-list li a').each(function () {
        $(this).removeClass('active');
    })
    $(this).addClass('active');
})

$('#faq-list li a').first().addClass('active');

$('#faq-search input').on('change keyup paste', function() {
    if ($(this).val() != '') {
        $('.faq-item:contains("' + $(this).val() + '")').show().siblings().hide();
    }
    else {
        $('.faq-group').children('*').show();
    }
})
