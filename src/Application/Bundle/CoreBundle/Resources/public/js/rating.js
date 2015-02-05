$(document).ready(function() {
    $('.solution-rating-value').on('change', 'input:radio', function(e) {
        var form = $(this).closest('form');
        var url = form.prop('action');
        $.post(url, form.serialize())
    });

    // @todo copypastacarbonara

    $("#solution_rating_rating_value").find("label").on('click', function() {
        $("#solution_rating_rating_value").find("label").removeClass('active');
        $(this).addClass('active');
    })

    $('[for="'+ $("#solution_rating_rating_value").find("input:checked").attr('id') + '"').addClass('active');
});