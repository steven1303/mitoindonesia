"use strict";

function ajaxLoad(filename, content) {
    content = typeof content !== 'undefined' ? content : 'content';
    $('.loading').show();
    $.ajax({
        type: "GET",
        url: filename,
        contentType: false,
        success: function (data) {
            $("#" + content).html(data);
            $('.loading').hide();
            if(data.stat == 'Warning'){
                error(data.stat, data.message);
            }
        },
        error: function (xhr, status, error) {
            alert(error);
        }
    });
}

