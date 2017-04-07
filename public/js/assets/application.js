$(function() {

  /*-----------------------------------------------------------------------------------*/
  /*  Anchor Link
  /*-----------------------------------------------------------------------------------*/
  $('a[href*=*#]').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
      || location.hostname == this.hostname) {

      var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    if (target.length) {
      $('html,body').animate({
        scrollTop: target.offset().top
      }, 1000);
        return false;
      }
    }
  });

  /*-----------------------------------------------------------------------------------*/
  /*  Tooltips
  /*-----------------------------------------------------------------------------------*/
  $('.tooltip-side-nav').tooltip();
  
});
$(document).ready(function(){
    if($('#subscribe')) {
        $('#subscribe').bind('submit', function() {
            subscribe();
            return false;
        });
    }
});

function subscribe() {
    jQuery.ajax({
        url: '/ajax/ajax/subscribe/',
        type: 'POST',
        dataType: 'html',
        data: jQuery('#subscribe').serialize(), 
        success: function(response) {
            var obj = jQuery.parseJSON(response);
            if(obj.code == "added") {
                alert('спасибо за подписку');
            } else if(obj.code == "isset") {
                alert('вы уже подписаны');
            } else if(obj.code == "not_valid_email") {
                alert('не верно указан email');
            }
            else {
                alert('error');
            }
        },
        error: function(response) {
            alert('error');
        }
    });
}