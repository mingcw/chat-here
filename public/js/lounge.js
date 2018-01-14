$(function () {
    $('#serachInput').keyup(function (e) {
        var objs = null,
            $this = $(this),
            filter = $this.val().trim();

        if (filter) {
            objs =  $('.rooms-list').find('.room-name');
            $(objs).each(function(i, obj) {
                $obj = $(obj);
                if ($obj.text().toUpperCase().indexOf(filter.toUpperCase()) !== -1) {
                    $obj.parents('.room-item').show();
                } else {
                    $obj.parents('.room-item').hide();
                }
            });
        } else {
            $('.rooms-list').children('.room-item').show();
        }
    });
})