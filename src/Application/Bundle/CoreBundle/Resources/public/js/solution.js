$(document).ready(function () {
    $('#descr-btn').click(function () {
        $(this).text(function (i, old) {
            return old == 'Hide description' ? 'Show description' : 'Hide description';
        });
    });
});
