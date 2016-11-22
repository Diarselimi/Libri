/**
 * Created by diar on 16-11-21.
 */

var form = function () {
    $('')
};

$('input, select').on('input change', function () {
    var input = $(this);

    var button = input.closest('form').find('button');

    if(button.attr('type') != 'submit') {
        input.closest('form').submit();
    }
});

//this is for handling forms without refreshing the page !!
$('.submit_form_js').submit(function (e) {
    e.preventDefault();
    var currentForm = $(this);
    $.ajax({
        url: currentForm.attr('action'),
        data: currentForm.serializeArray(),
        type: 'POST',
        success: function (result) {
            console.log(result);
        }
    });
    return false;
});

//
$('input').on('keydown keyup', function (e) {

    if(!parseInt(String.fromCharCode(e.keyCode))) {
        return true;
    }

    var input = $(this);
    var temp = input.val() + '' + parseInt(String.fromCharCode(e.keyCode));

    if (parseInt(temp) > input.data('max_pages')) {
        input.parent().addClass('has-error');
        e.preventDefault();
        return false;
    }
});