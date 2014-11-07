$(document).ready(function() {
    $('#rating-form input[name="rating"]').change(function(e) {
        var form = $('#rating-form');
        var url = form.prop('action');
        $.post(url, form.serialize());
    });
});