/* global $, jQuery */
'use strict';

function triggerAlert(into, level, title, message) {
    $('#'+into).html('');
    var dismissButton = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    $('<div></div>').addClass('alert').addClass('alert-dismissable').addClass('alert-'+level)
            .html(dismissButton + '<strong>'+title+'!</strong> '+message).appendTo('#'+into);
}

function toggleDisabled(selector) {
    if (!(selector instanceof jQuery)) {
        selector = $('#' + selector);
    }
    selector.prop('disabled', !(selector.prop('disabled')));
}

$('#loginForm').submit(function (event) {
    var userValue = $('#username').val(),
        passValue = $('#password').val(),
        button = $('#loginButton');

    event.preventDefault();

    toggleDisabled(button);

    if(!userValue || !passValue) {
        triggerAlert('loginAlert', 'danger', 'Failure', 'Username or password incorrect');
        toggleDisabled(button);
        return;
    }

    $.post(window.base + '/authorize/', {user: userValue, pass: passValue}, null, 'json').done(function (response) {
        if(response.error) {
            triggerAlert('loginAlert', 'danger', 'Failure', response.error);
            toggleDisabled(button);
        } else {
            triggerAlert('loginAlert', 'success', 'Success', 'redirecting...');
            window.location.replace(response.to);
        }
    }).fail(function () {
        triggerAlert('loginAlert', 'danger', 'Failure', 'Something went wrong. Try again?');
        toggleDisabled(button);
    });
});

$('#pass-change').submit(function (event) {
    var pass = $('#pass-change-pass').val(),
        repass = $('#pass-change-retype').val(),
        button = $('#pass-change-button');

    event.preventDefault();

    toggleDisabled(button);

    if(pass === '' || (pass !== repass)) {
        triggerAlert('pass-change-alert', 'danger', 'Failure', 'Passwords do not match!');
        toggleDisabled(button);
        return;
    }

    $.post(window.base + '/changePassword/', {pass: pass}, null, 'json')
     .done(function (response) {
        if(response.error) {
            triggerAlert('pass-change-alert', 'danger', 'Failure', response.error);
            toggleDisabled(button);
        } else {
            triggerAlert('pass-change-alert', 'success', 'Success', 'Password Changed');
            toggleDisabled(button);
            $('#pass-change').get(0).reset();
            $('#pass-change-modal').modal('hide');
        }
     })
     .fail(function () {
        triggerAlert('pass-change-alert', 'danger', 'Failure', 'Something went wrong. Try again?');
        toggleDisabled(button);
     });
});