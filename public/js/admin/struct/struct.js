function display_struct(id) {
    $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {id:id},
        url: '/ajax/ajax/struct/open/',
        success: function(data) {
            $('#structure').html(data);
        }
    });
}

function close_struct(id) {
    $.ajax({
        type: 'POST',
        dataType: 'html',
        data: {id:id},
        url: '/ajax/ajax/struct/close/',
        success: function(data) {
            $('#structure').html(data);
        }
    });
}