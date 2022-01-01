$('.add__bottom-row').children('button').click(function (e) {
    e.preventDefault();
    $(this).parent().parent().parent().parent().submit();
})

$('.add__bottom-cart').on('click', function(e) {
    e.preventDefault();

    var b = $(this);
    var form = $(this).parent().parent().parent().parent();

    $.ajax({
        url: $(form).attr('action'),
        type: 'post',
        data: $(form).serialize(),
        success: function (data) {
            $('.alert').remove();
            $('body').append('<div class="alert alert-success">' + data.text + '</div>');
            $('.header__value').children('span').text(data.sum);
            if (data.count > 0 && $('.header__indicator').length == 0) {
                $('.header__cart-img').append('<div class="header__indicator"></div>');
            }
            if (data.result == 'success') {
                $(b).addClass('active');
            }
        }
    });

    return false;
})

$('.dropbtn').click(function () {
    $(this).toggleClass('active').siblings('.add-dropdown').toggleClass('show');
})

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("add-dropdown");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        $(openDropdown).siblings().removeClass('active');
      }
    }
  }
}

$('.add__input-count').keyup(function() {
    var g = $(this).data('good');
    var p = $(this).data('price');

    $('.add__bottom-value--value[data-good="' + g + '"]').text($(this).val());
    $('.add__bottom-price--sum[data-good="' + g + '"]').text(parseInt($(this).val()));
    $('.add__bottom-price--sum[data-good="' + g + '"]').text(parseFloat((p / 1000 * $(this).val())).toFixed(2));
})

$('.add__input-posts').keyup(function() {
    var g = $(this).data('good');
    var p = $(this).data('price');

    $('.add__bottom-price--sum[data-good="' + g + '"]').text(parseFloat((p / 1000 * $(this).val() * $('.add__input-count[data-good="' + g + '"]').val())).toFixed(2));
})
