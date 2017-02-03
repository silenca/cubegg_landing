$(document).ready(function() {

    // mobile menu
    // ------------------------------------------------------------
    $('.j-mobile').on('click', function() {
        $('.j-header').addClass('j-header--open');
    });

    $('.j-header').on('click', function() {
        $('.j-header').removeClass('j-header--open');
    });

    $('.j-header__wrap').on('click', function(e) {
        e.stopPropagation();
    });


    // contact form
    // ------------------------------------------------------------
    $('.j-form__submission').on('submit', function(e) {
        e.preventDefault();
        var $form = $('.j-form__submission');
        var email = $form.find('input[type=email]').val();
        var name = $form.find('input[type=text]').val();
        var message = $form.find('textarea').val();
        $.post('/contact.php', {email: email, name: name, message: message}, function(respopnse) {
            if (respopnse.result == 'ok') {
                $('.j-form__submission, .j-form__h1').hide();
                $('.j-form__success').show();
                $form.find('input').val('');
                $form.find('textarea').val('');
            } else {
                //TODO Error handler
            }
        }, 'json');
        
    });

    $('.j-form__success__more').on('click', function() {
        $('.j-form__success').hide();
        $('.j-form__submission, .j-form__h1').show();
    });


}); // end ready