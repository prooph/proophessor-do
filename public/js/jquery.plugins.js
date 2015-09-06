//jQuery Additions
(function( $ ) {

    $.postJSON = function(url, data, settings) {
        if (typeof settings == 'undefined') settings = {};
        return $.ajax(url, $.extend({
            contentType : 'application/json; charset=UTF-8',
            type: "POST",
            data : JSON.stringify(data),
            dataType : 'json',
            dataFilter : function (data, dataType) {
                if (! data && dataType == "json") return "{}";
                return data;
            }
        }, settings))
    }

    $.putJSON = function(url, data, settings) {
        if (typeof settings == 'undefined') settings = {};
        return $.ajax(url, $.extend({
            contentType : 'application/json; charset=UTF-8',
            type: "PUT",
            data : JSON.stringify(data),
            dataType : 'json',
            dataFilter : function (data, dataType) {
                if (! data && dataType == "json") return "{}";
                return data;
            }
        }, settings))
    }

    $.failNotify = function(xhr) {
        if (typeof xhr.responseJSON == 'undefined') {
            xhr.responseJSON = {status : 500, title : 'Unknown Server Error', detail : 'Unknown Server response received'}
        }

        $.notify('['+ xhr.status +'] '+xhr.responseJSON.message, {
            className : 'error',
            clickToHide: true,
            autoHide: false
        });
    }

    $.appErrorNotify = function(msg) {
        $.notify(msg, {
            className : 'error',
            clickToHide: true,
            autoHide: false
        });
    }

})( jQuery );


//Settings
$(function() {
    $.notify.defaults({
        globalPosition: 'bottom left'
    });
});

