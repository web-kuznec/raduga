function translit(tag, table, update) {
    if($("#"+tag)) {
        var name = $("#"+tag).val();
        var id = null;
        if($("#id")) {
            var id = $("#id").val();
        }
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: {id:id,name:name,table:table},
            url: '/ajax/ajax/struct/translit',
            success: function(response) {
                var obj = $.parseJSON(response);
                if(obj.code == "ERROR_VATIDATION") {
                    if($("#"+update)) {
                        $("#"+update).val("Ошибка");
                    }
                } else {
                    if("#"+update) {
                        $("#"+update).val(obj.code);
                    }
                }
            }
        });
    }
}