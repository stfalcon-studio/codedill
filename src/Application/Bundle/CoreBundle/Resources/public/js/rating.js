$(document).ready(function() {
    $('.solution-rating-value').on('change', 'input:radio', function(e) {
        var form = $(this).closest('form');
        var url = form.prop('action');
        $.post(url, form.serialize());
    });
});