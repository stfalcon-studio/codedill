$(document).ready(function () {
    $('#descr-btn').click(function () {
        $(this).text(function (i, old) {
            return old == 'Hide description' ? 'Show description' : 'Hide description';
        });
    });
    $('#add_solution_codeMode').on('change', function() {
        var editor = ace.edit("add_solution_code_ace");
        editor.getSession().setMode(this.value);
    });
});
