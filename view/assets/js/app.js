'use strict';

function triggerAlert(into, level, title, message) {
    $('#'+into).html('');
    var dismissButton = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    $('<div></div>').addClass('alert').addClass('alert-dismissable').addClass('alert-'+level)
            .html(dismissButton + '<strong>'+title+'!</strong> '+message).appendTo('#'+into);
}

$('#loginForm').submit(function (event) {
    event.preventDefault();

    function toggleDisabled() {
        var button = $('#loginButton');
        button.prop('disabled', !(button.prop('disabled')));
    }

    toggleDisabled();

    var userValue = $('#username').val(),
        passValue = $('#password').val();

    if(!userValue || !passValue) {
        triggerAlert('loginAlert', 'danger', 'Failure', 'Username or password incorrect');
        toggleDisabled();
        return;
    }

    $.post(window.base + '/authorize/', {user: userValue, pass: passValue}, null, 'json').done(function (response) {
        if(response.error) {
            triggerAlert('loginAlert', 'danger', 'Failure', response.error);
            toggleDisabled();
        } else {
            triggerAlert('loginAlert', 'success', 'Success', 'redirecting...');
            window.location.replace(response.to);
        }
    }).fail(function () {
        triggerAlert('loginAlert', 'danger', 'Failure', 'Something went wrong. Try again?');
        toggleDisabled();
    });
});