$('.add__info-show').click(function () {
    $(this).children('span').toggle();

    $(this).parent().parent().siblings('.cart__item-info-add').toggleClass('cart__item-info-add--active')
})
