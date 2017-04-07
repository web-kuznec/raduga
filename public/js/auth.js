jQuery(document).ready(function() {
    
    /* Навешиваем событие на submit авторизации */
    if(jQuery('#login-form')) {
        jQuery('#login-form').bind('submit', function() {
            ajaxauth();
            return false;
        });
    }
});

function ajaxauth() {
    var name = jQuery('#username').val();
    var pass = jQuery('#password').val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'html',
        data: {username: name, password: pass},
        url: '/ajax/ajax/auth/',
        //data: jQuery('#login-form').serialize(), 
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            if(obj.code == "success") {
                document.location.reload();
            } else if(obj.code == "not users") {
                clear_error('password');
                jQuery('#login-form').attr('novalidate','novalidate');
                set_error('username', 'Введите логин');
            }
            else {
                clear_error('username');
                jQuery('#login-form').attr('novalidate','novalidate');
                set_error('password', 'Введите пароль');
            }
        },
        error: function(response) {
            alert('error');
        }
    });
}

function clear_error(id) {
    jQuery('#'+id).parent().find('.has-error').remove();
    jQuery('#'+id).parent().removeClass('has-error');
    jQuery('#'+id).removeAttr('aria-describedby');
    jQuery('#'+id).removeAttr('aria-invalid');
}

function set_error(id, text) {
    jQuery('#'+id).parent().addClass('has-error');
    jQuery('#'+id).parent().find('.has-error').remove();
    jQuery('#'+id).attr('aria-describedby', 'username-error');
    jQuery('#'+id).attr('aria-invalid', 'true');
    jQuery('#'+id).after('<span id="username-error" class="has-error">'+text+'</span>');
}

function exitus() {
    jQuery.ajax({
        url: '/ajax/ajax/auth/exit',
        type: 'POST',
        dataType: 'html',
        success: function() {
            location.reload();
        },
        error: function(response) {
            alert('error');
        }
     });
}