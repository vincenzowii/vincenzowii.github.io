/**
 * Indusrabbit - SMM Panel script
 * Domain: https://indusrabbit.com/
 * Codecanyon Item: https://codecanyon.net/item/indusrabbit-smm-panel/19821624
 *
 */
$(function () {
    $(document).on("click", ".btn-delete-record", function (e) {
        $button = $(this);
        bootbox.confirm({
            message: "Are you sure to delete the record?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-default'
                }
            },
            callback: function (result) {
                // Indusrabbit SMM Panle
                if (result) {
                    $button.parents('form').submit();
                }
            }
        });
    });
});
