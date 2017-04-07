$(document).ready(function () {
    $('.no_in_cart').click(function () {
        e = $(this);
        var id = $(this).attr('item');
        jQuery.ajax({
            url: '/ajax/ajax/basket/add',
            type: 'POST',
            dataType: 'html',
            data: {id:id},
            success: function(data) {
                $(e).text("В корзине");
                $(e).removeClass("no_in_cart");
                $(e).addClass("in_cart");
                $("body").append(data);
                $("#myBasket").modal('show');
                $('.clmm').click(function () {
                    $('#myBasket').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeAttr('class');
                    $('body').removeAttr('style');
                });
            }
        });
    });
    
    $('.count').change(function() {
        e = $(this);
        parent = $(e).parent().parent('div.basket_item');
        total = parent.find('span.totlat_item i');
        var cost = parseFloat(parent.find('span.basket_cost i').text()).toFixed(2);
        var count = e.val();
        var id = e.attr('item');
        total.text(cost*count);
        basket_total();
        jQuery.ajax({
            url: '/ajax/ajax/basket/count',
            type: 'POST',
            dataType: 'html',
            data: {id:id,count:count}
        });
    });
    
    if($('#total')) {
        basket_total();
    }
    
    $('.basket_empty').click(function() {
        jQuery.ajax({
            url: '/ajax/ajax/basket/empty',
            type: 'POST',
            dataType: 'html',
            success: function() {
                document.location.reload();
            }
        });
    });
    
    $('.basket_dell').click(function() {
        e = $(this);
        id = $(this).attr('item');
        jQuery.ajax({
            url: '/ajax/ajax/basket/dell',
            type: 'POST',
            dataType: 'html',
            data: {id:id},
            success: function() {
                $(e).parent().parent('div.basket_item').remove();
                basket_total();
            }
        });
    });
    
    $('.order_start').click(function() {
        $(this).css('display','none');
        $('.form-order').css('display','block');
    });
    
    $('#phone').mask("+7 999-999-99-99");
    $('#form_order').bind('submit', function () {
        valid_add();
        return false;
    });
    
    $('.reviews_add').click(function () {
        jQuery.ajax({
            url: '/ajax/ajax/reviews/show_form',
            type: 'POST',
            dataType: 'html',
            success: function(data) {
                $("body").append(data);
                $("#reviews").modal('show');
            }
        });
    });
    $('.fa-search').click(function() {
        if($('#form_search input[name="search"]').val().length > 2) {
            $('#form_search').submit();
        }
    });
});

function basket_total() {
    sum = 0;
    $('.totlat_item i').each(function(i,elem) {
        sum = sum+parseFloat($(this).text());
    });
    $('#total').text(sum);
}

function valid_add() {
    var error = 0;
    var sot_phone = $('#phone').val();
    var name = $('#name').val();
    if(sot_phone.length == 0) {
        var error = 1;
        clear_error('phone');
        set_error('phone', 'Заполните номер телефона');
    }
    if(name.length == 0) {
        var error = 1;
        clear_error('name');
        set_error('name', 'Заполните имя');
    }
    if (error == 0) {
        $.ajax({
            url: '/ajax/ajax/basket/order',
            type: 'POST',
            dataType: 'html',
            data: jQuery('#form_order').serialize(),
            beforeSend: function() {
                $("body").append('<div id="myOrder" class="modal fade"><div class="modal-dialog"><div class="modal-content"><div id="loader" style="text-align:center; padding:50px 0;"><img src="/public/images/loader.gif"></div></div></div></div>');
                $("#myOrder").modal('show');
            },
            success: function(data) {
                $('#myOrder').remove();
                $("body").append(data);
                $("#myOrder").modal('show');
                $('.clmm').click(function () {
                    $('#myOrder').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeAttr('class');
                    $('body').removeAttr('style');
                });
                $('#basket_list').html('<p>Корзина пустая</p>');
            },
            error: function(response) {
                alert('error');
            }
        });
    }
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