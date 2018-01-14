$(function () {
    var user = 'mingcw',
        avatar = 'avatar1', // `default` 或 `avatar[1-18]`
        bubbles = ['gray', 'purple', 'blue', 'green', 'yellow', 'red'],
        bubble = bubbles[parseInt((Math.random() * 6))],
        music_type = 'cloud',
        player = new skPlayer({
            autoplay: true,
            listshow: false, // 设置为true时播放列表位置异常
            mode: 'listloop',
            music: {
                type: 'cloud',
                source: 317921676
            }
        });

    fix_offset_y(false);  // 必需
    // connection_lost(true);   // 测试
    new_message(1);       // 测试

    $('#post-one-btn').on('click', function(e) {
        e.preventDefault();
        $('#post-one-form').slideToggle('fast', fix_offset_y);
    });

    $('#post-message-area').keyup(function(e) {
        if (e.ctrlKey && e.keyCode == 13) { // 按下 Ctrl+Enter
            $('#submit-btn').click();
        }
    });

    $('#submit-btn').on('click', function(e) {
        e.preventDefault();

        $txt_area = $('#post-message-area');
        if (!$txt_area.val().trim()) { return false; }

        var content = $txt_area.val().trim();
        insert_one(content, user, avatar, bubble);
    });

    $('#users-list-btn').on('click', function(e) {
        e.preventDefault();
        $('#users-list').slideToggle('fast', fix_offset_y);
    });

    $('#unread-box').on('click', function(e) {
        $(this).hide('fast');
        $('html, body').animate({scrollTop: 0}, '50');
    });

    $(document).on('click', '.at-somebody', function(e) {
        e.preventDefault();

        $this = $(this);
        $txt_area = $('#post-message-area');
        $txt_area.val($txt_area.val() + $this.text() + ' ');
    });

    /** 音乐js start */

    $('#music-settings-btn').on('click', function(e) {
        e.preventDefault();
        $('#music-settings-modal').modal('toggle');
    });

    $('input[name="music-type"]').change(function(e) {
        e.preventDefault();

        var type = $(this).val().trim(),
            $cloud_group = $('.music-cloud-group'),
            $customize_group = $('.music-customize-group');

        if (type == 'cloud') {
            $cloud_group.removeClass('hidden');
            $customize_group.removeClass('hidden').addClass('hidden');
            music_type = type;
        } else if(type == 'file') {
            $customize_group.removeClass('hidden');
            $cloud_group.removeClass('hidden').addClass('hidden');
            music_type = type;
        }
    });

    $('#music-play-btn').on('click', function(e) {
        e.preventDefault();

        if (music_type == 'cloud') {
            var playist_id = parseInt($('input[name="netease-cloud-music-playist-id"]').val().trim());
            
            if (playist_id) {
                if (player) { // 全局的
                    player.destroy();
                }
                player = new skPlayer({
                    autoplay: true,
                    listshow: false, // 设置为true时播放列表位置异常
                    mode: 'listloop',
                    music: {
                        type: 'cloud',
                        source: playist_id
                    }
                });
            } else {
                alert_modal('Error Id: ' + playist_id);
            }
        } else if(music_type == 'file') {
            var name = $('input[name="music-name"]').val().trim() || 'Undefined',
                author = $('input[name="music-author"]').val().trim() || 'Undefined',
                src = $('input[name="music-src"]').val().trim() || '',
                cover = $('input[name="music-cover"]').val().trim() || '';

            if (src.match(/((http|https):\/\/([\w\-]+\.)+[\w\-]+(\/[\w\u4e00-\u9fa5\-\.\/?\@\%\!\&=\+\~\:\#\;\,]*)?)/ig)) {
                if (player) { // 全局的
                    player.destroy();
                }
                player = new skPlayer({
                    autoplay: true,
                    listshow: false, // 设置true时播放列表位置异常
                    mode: 'listloop',
                    music: {
                        type: 'file',
                        source: [
                            {
                                name: name,
                                author: author,
                                src: src,
                                cover: cover
                            }
                        ]
                    }
                });
            } else {
                alert_modal('Url is ' + (src?'invalid':'empty') );
            }
        } else{
             alert_modal('Unknown music type: ' + music_type);
        }
    });

    $(document).on('click', '#skPlayer .skPlayer-list-switch', function(e) {
        e.stopPropagation(); // 阻止事件传播（在捕获阶段）

        var $sk_player = $('#skPlayer'),
            $list = $sk_player.find('.skPlayer-list'),
            list_h = $list.height();

        if (!$list.is(':hidden')) {
            $list.animate({top: (-list_h) + 'px'}, 'fast');
        } else {
            $list.animate({top: (   0   ) + 'px'}, 'fast');
        }
    });
    
    $(document).on('click', function(e) {
        var $music_player = $('#music-player'),
            $sk_player = $('#skPlayer'),
            $list = $sk_player.find('.skPlayer-list'),
            sk_w = $sk_player.width();

        if (!$list.is(e.target)) {
            $sk_player.removeClass('skPlayer-list-on'); // 隐藏播放列表
        }

        if (!$music_player.is(e.target) && $music_player.has(e.target).length === 0 ) {
            $music_player.animate({left: (-sk_w) + 'px'}, 'fast'); // 隐藏播放器
            window.player_status = 'close';
        }
    });

    $('#player-switch-btn').click(function(e) {
        e.stopPropagation(); // 阻止事件传播（在捕获阶段）

        var $music_player = $('#music-player'), 
            $sk_player = $('#skPlayer'), 
            sk_w = $sk_player.width();

        if (window.player_status === 'open') {
            $music_player.animate({left: (-sk_w) + 'px'}, 'fast');
            window.player_status = 'close';
        } else {
            $music_player.animate({left: 0}, 'fast');
            window.player_status = 'open';
        }
    });
    /** 音乐js end */

});

// alert 框
function alert_modal(msg) {
    $('#alert-modal').find('.modal-body').html(msg).end().modal('show');
}

// 显示/隐藏`连接丢失`通知条
function connection_lost(is_show = true) {
    $obj = $('#connection-indicator');
    if (is_show) {
        $obj.removeClass('hidden');
    } else {
        $obj.removeClass('hidden').addClass('hidden');
    }
}

// 显示/隐藏`新消息`通知条
function new_message(counter, is_show = true) {
    var $msg_box = $('#unread-box');

    if (!is_show) {
        $msg_box.addClass('hidden');
    } else {
        counter = parseInt(counter);
        $msg_box.removeClass('hidden');
        $msg_box.children('.counter').text(counter);
        $msg_box.children('.single, .more').removeClass('hidden').addClass('hidden');
        if (counter === 1) {
            $msg_box.children('.single').removeClass('hidden');
        } else {
            $msg_box.children('.more').removeClass('hidden');
        }
        $msg_box.slideDown('fast');
    }
}

// 插入1条新发言
function insert_one(content, user, avatar, bubble) {
    var html = '<dl class="chat-item clearfix"><dt class="pull-left"><div class="text-center"><img class="img-rounded" src="./img/avatar/' + avatar + '.png" title="' + user + '"></div><div class="dropdown username text-white"><a href="javascript:;" data-toggle="dropdown" title="' + user + '">' + user + '</a><ul class="dropdown-menu"><li><a class="at-somebody" href="javascript:;">@' + user + '</a></li></ul></div></dt><dd class="pull-left"><p class="say bubble bubble-' + bubble + '">' + content + '</p></dd></dl>';
    $(html).prependTo('.chat-wrap');
    $('html, body').animate({scrollTop: 0}, 'fast');
    $('#unread-box').click();
}

// 修正.chat-wrap元素的margin-top值
function fix_offset_y(is_animate = true) {
    var h = $('.message-wrap').height();

    var $chat_wrap = $('.chat-wrap');
    if (is_animate) {
        $chat_wrap.animate({
            marginTop: (h+20) + 'px'
        }, 'fast');
    } else {
        $chat_wrap.css('margin-top', (h + 20) + 'px');
    }
}
