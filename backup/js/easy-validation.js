$(document).ready(function() {
    $('.form-error').hide();

    // Contact Form
    $("input.send").click(function() {

        $('.form-error').hide();

        nombre = $('input#nombre').val();
        if (nombre == '') {
            $('span#nombre-error').show();
            $('input#nombre').focus();
            event.preventDefault();
        }

        email = $('input#email').val();
        if (email == '') {
            $('span#email-error').show();
            $('input#email').focus();
            event.preventDefault();
        }

        asunto = $('select#asunto').val();
        if (asunto == 'No hay Asunto') {
            $('span#asunto-error').show();
            $('select#asunto').focus();
            event.preventDefault();
        }
    });    
});
	