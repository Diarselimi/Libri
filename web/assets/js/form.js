/**
 * Created by diar on 16-11-21.
 */

var form = function () {
    $('')
};

$('input, select').on('input change', function () {
    var input = $(this);

    var button = input.closest('form').find('button[type=submit]');
    if(button.length == 0) {
        input.closest('form').submit();
    }
});

$('#book_to_shelf_shelf').on('input change', function () {
    var text = $('#book_to_shelf_shelf option:selected').text();
    if(text.toLowerCase() == 'read'){
        //show the modal to ask if he want's to make the book for sale or exchange
        $('#book_own_options').modal('show');
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
            //do some process here
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