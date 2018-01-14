$(function(){
    $('#settings-btn').on('click', function(e) {
        e.preventDefault();
        $('#settings-modal').modal('toggle');
    });
    $('#settings-modal li').on('click', function(e) {
        var $avatar = $('#avatar');

        $(this).toggleClass('active').siblings().removeClass('active');
        
        if (is_checked($(this))) {
            $avatar.val($(this).children('img').attr('data-avatar'));
        } else {
            $avatar.val('');
        }
    });
})

function is_checked(obj) {
    if (obj && (typeof HTMLElement === "function" || typeof HTMLElement === "object") && obj instanceof HTMLElement) { 
        return obj.getAttribute('class').indexOf('active') !== -1;
    } else if (obj && obj.length && (typeof jQuery==="function" || typeof jQuery==="object") && obj instanceof jQuery) {
        return obj.hasClass('active');
    } else {
        alert('Undefined type: ' + obj);
        return false;
    }
    
}