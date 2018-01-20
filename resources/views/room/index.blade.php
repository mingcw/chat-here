@extends('layouts.app')

@section('title', $room->name)

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/room.css') }}">
@endsection

@section('body')
<!-- Navbar will come here -->
<div class="message-wrap">
    <div class="menu-bar">
        <div class="clearfix menu-tool">
            <h4 class="room-name">
                {{-- <span class="room-name-capacity text-muted"><span id="current-number">{{ $room->number }}</span>/{{ $room->capacity }}</span> --}}
                <span class="room-name-title">{{ $room->name }}</span>
            </h4>
            <ul class="menu clearfix">
                <li><a id="post-one-btn" href="javascript:;"><i class="material-icons">chat</i></a></li>
                <li><a id="music-settings-btn" href="javascript:;"><i class="material-icons">library_music</i></a></li>
                <li><a id="users-list-btn" href="javascript:;"><i class="material-icons">account_circle</i></a></li>
                <li class="dropdown">
                    <a id="dropdown-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">settings</i></a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-settings">
                        <li><a href="{{ url('leave') }}" id="leave-room"><i class="material-icons">exit_to_app</i> Leave</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ url('logout') }}"><i class="material-icons">close</i> Log out</a></li>
                    </ul>
                </li>
            </ul>
            <span class="to-whom hidden">@<span></span><a href="javascript:;">(Cancel)</a></span>
        </div>
        <div id="post-one-form" class="post-wrap">
            <form action="" method="" role="form">
                <div class="form-group message-group">
                    <textarea name="message" id="post-message-area" class="form-control" maxlength="140"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="submit-btn" class="btn btn-default post-btn">Post (Enter)</button>
                </div>
            </form>
        </div>
    </div>
    <div id="connection-indicator" class="notification-bar text-center notification-warning hidden">Connection lost, reconnecting…</div>
    <div id="unread-box" class="notification-bar text-center notification-new hidden">
        <span class="counter">2</span>
        <span class="single hidden">new message</span>
        <span class="more">new messages</span>
    </div>
    <ul id="users-list" class="users-list clearfix">
        
    </ul>
</div>
<!-- end navbar -->

<div class="chat-wrap">
    
</div>

<!-- Audio Player -->
<div id="music-player">
    <div id="skPlayer"></div>
    <div id="player-switch-btn" class="switch-btn"><i class="material-icons">music_note</i></div>
</div>

<!-- Music Settings Modal Core -->
<div class="modal fade modal-chat" id="music-settings-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Music</h4>
      </div>
      <div class="modal-body">
        <div class="form-group music-type-group">
            <label>Type</label>
            <div class="radio">
                <label>
                    <input type="radio" name="music-type" value="cloud" checked=""><span class="circle"></span><span class="check"></span>
                    NetEase Cloud Music
                </label>
            </div>            
            <div class="radio">
                <label>
                    <input type="radio" name="music-type" value="file"><span class="circle"></span><span class="check"></span>
                    Customize
                </label>
            </div>
        </div>
        <div class="music-cloud-group">
            <div class="form-group label-floating is-empty">
                <label class="control-label">Playist ID</label>
                <input type="text" name="netease-cloud-music-playist-id" class="form-control" maxlength="12">
                <span class="material-input"></span>
            </div>
        </div>
        <div class="music-customize-group hidden">
            <div class="form-group label-floating is-empty">
                <label class="control-label">Name</label>
                <input type="text" name="music-name" class="form-control" maxlength="40">
                <span class="material-input"></span>
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label">Author</label>
                <input type="text" name="music-author" class="form-control" maxlength="40">
                <span class="material-input"></span>
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label">Url</label>
                <input type="text" name="music-src" class="form-control" maxlength="240">
                <span class="material-input"></span>
            </div>
            <div class="form-group label-floating is-empty">
                <label class="control-label">Cover Url</label>
                <input type="text" name="music-cover" class="form-control" maxlength="240">
                <span class="material-input"></span>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Close</button>
        <button type="button" id="music-play-btn" class="btn btn-info btn-simple">Play</button>
      </div>
    </div>
  </div>
</div>

<!-- Alert Modal Core -->
<div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-simple" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
    <script src="{{ asset('/js/skPlayer.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/swfobject.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/web_socket.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
    $(function () {
        var music_type = 'cloud';
        // var player = new skPlayer({
        //     autoplay: true,
        //     listshow: false, // 设置为true时播放列表位置异常
        //     mode: 'listloop',
        //     music: {
        //         type: 'cloud',
        //         source: 317921676
        //     }
        // });

        // connection_lost(true);   // 测试
        // new_message(1);       // 测试
        // system_notify('@mingcw has logged in.'); // 测试

        // 聊天框切换按钮
        $('#post-one-btn').on('click', function(e) {
            e.preventDefault();
            $('#post-one-form').slideToggle('fast', fix_offset_y);
        });

        //  Enter 发送消息(检测ctrl键用e.ctrlKey)
        $('#post-message-area').keyup(function(e) {
            if (e.keyCode == 13) {
                $('#submit-btn').click();
            }
        });

        // 发送消息
        $('#submit-btn').on('click', function(e) {
            e.preventDefault();

            var $txt_area = $('#post-message-area');
            var content = $txt_area.val().trim();

            if (!content) { 
                return false;
            }
            $txt_area.val('');
            if ($('.to-whom').is(':hidden')) { // 公聊
                $.post('{{ url("say") }}', {
                    type: 'all',
                    content: content,
                    _token: '{{ csrf_token() }}'
                }, function(data) {}, 'json');
            } else { // 私聊
                $.post('{{ url("say") }}', {
                    type: 'to',
                    to_uid: $('.to-whom').children('span').attr('id'),
                    to_uname: $('.to-whom').children('span').text(),
                    content: content,
                    _token: '{{ csrf_token() }}'
                }, function(data) {}, 'json');
            }
        });

        // 房间用户列表 切换按钮
        $('#users-list-btn').on('click', function(e) {
            e.preventDefault();
            $('#users-list').slideToggle('fast', fix_offset_y);
        });

        // 新消息条点击事件
        $('#unread-box').on('click', function(e) {
            $(this).hide('fast');
            $('html, body').animate({scrollTop: 0}, '50');
        });

        // @他/她
        $(document).on('click', '.at-somebody', function(e) {
            e.preventDefault();

            var $txt_area = $('#post-message-area');
            var $form = $('#post-one-form');

            $txt_area.val($txt_area.val() + ' ' + $(this).text() + ' ');
            if ($form.is(':hidden')) {
                $('#post-one-btn').click();
            }
            $('#post-message-area').removeClass('private').focus();
        });

        // 私聊
        $(document).on('click', '.dm', function(e) {
            e.preventDefault();

            if ($('#post-one-form').is(':hidden')) {
                $('#post-one-btn').click();
            }

            var $span = $('.to-whom').removeClass('hidden').children('span');
            var $a    = $(this).parent().prev().children('a');
            $span.attr('id', $(this).attr('id')).text($a.text().substr(1).replace('(me)', ''));
            $('#post-message-area').addClass('private').focus();
        });

        // 取消私聊
        $('.to-whom').on('click', 'a', function(e) {
            e.preventDefault();
            $(this).siblings('span').text('').parent('.to-whom').addClass('hidden');
            $('#post-message-area').removeClass('private');
        });

        /** Websocket js start */

        // Let the library know where WebSocketMain.swf is:
        WEB_SOCKET_SWF_LOCATION = '{{ url("/swf/WebSocketMain.swf") }}';

        // Write your code in the same way as for native WebSocket:
        (function connect() {
            var ws = new WebSocket("ws://" + document.domain + ":7272");
        
            ws.onopen = function() {
                connection_lost(false); // 隐藏连接丢失条
            };

            ws.onmessage = function(e) {
                var data = JSON.parse(e.data),
                    type = data.type || '';
                
                switch (type) {
                    case 'ping':
                        // console.log(data);
                        break;
                    case 'init':
                        $.post('{{ url("bind") }}', {
                            client_id: data.client_id,
                            _token: "{{ csrf_token() }}"
                        }, function(data) {}, 'json');
                        break;
                    case 'comein':
                        // console.log(data);
                        if (data.uname) { // 群发的系统通知：萌新进入
                            system_notify('@'+ data.uname + ' came in.');
                        }
                        if (data.users_list) { // 单发来的用户列表
                            flush_users_list(data.users_list); // 刷新用户列表
                        }
                        break;
                    case 'all':
                    case 'to' :
                        var html = '<dl class="chat-item clearfix">\
                                        <dt class="pull-left">\
                                            <div class="text-center">\
                                                <img class="img-rounded" src="{{ asset("/img/avatar/") }}'+ '/' + data.avatar + '.png" title="' + data.uname + '">\
                                            </div>\
                                            <div class="dropdown username text-white">\
                                                <a href="javascript:;" data-toggle="dropdown" title="' + data.uname + '">' + data.uname + '</a>\
                                                <ul class="dropdown-menu">\
                                                     <li><a class="at-somebody" id="'+ data.uid +'" href="javascript:;">@' + data.uname + '</a></li>\
                                                     <li><a class="dm" id="'+ data.uid +'" href="javascript:;">DM</a></li>\
                                                </ul>\
                                            </div>\
                                        </dt>\
                                        <dd class="pull-left">\
                                            <p class="say bubble bubble-' + data.bubble + '">' + data.content + '</p>\
                                        </dd>\
                                    </dl>';
                        $(html).prependTo('.chat-wrap');
                        $('html, body').animate({scrollTop: 0}, 'fast');
                        $('#unread-box').click();
                        break;
                    case 'close':
                        // 通知有人退出
                        system_notify('@' + data.uname + ' leaved out.');

                        // 请求新的用户列表
                        $.post('/flush', {
                            room_id: {{ $room_id }},
                            _token: '{{ csrf_token() }}'
                        }, function(data) { });
                        break;
                    case 'flush':
                        console.log('刷新用户列表：', data);
                        flush_users_list(data.users_list);
                        break;
                    default :
                        alert(e.data);
                }
            };

            ws.onerror = function() {
                console.log('连接出错');
            }

            ws.onclose = function() {
                console.log('连接关闭，正在重连');
                connection_lost(true); // 显示连接丢失
                connect(); // 重连
            };
        })();

        /** Websocket js end */

        /** 音乐js start */

        // 设置音乐
        $('#music-settings-btn').on('click', function(e) {
            e.preventDefault();
            $('#music-settings-modal').modal('toggle');
        });

        // 设置音乐类型
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

        // 播放
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

        // 播放列表显隐切换
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
        
        // 点击其他区域时，隐藏播放列表、播放器
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

        // 播放器收起/展开
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
            $msg_box.children('.single, .more').addClass('hidden');
            if (counter === 1) {
                $msg_box.children('.single').removeClass('hidden');
            } else {
                $msg_box.children('.more').removeClass('hidden');
            }
            $msg_box.slideDown('fast');
        }
    }

    // 系统通知
    function system_notify(content) {
        $('<p class="system notify"><i class="material-icons">lens</i> '+content+'</p>').prependTo('.chat-wrap');
    }

    // 修正.chat-wrap元素的margin-top值
    function fix_offset_y() {
        var h = $('.message-wrap').height();

        $('.chat-wrap').animate({
            marginTop: (h + 20) + 'px'
        }, 'fast');
    }

    // 刷新房间用户列表
    function flush_users_list(users_list) {
        var html = '';
        for (uid in users_list) {
            me = (users_list[uid]=='{{ $uname }}' ? '(me)' : '');
            html += '<li class="dropdown">\
                        <a href="javascript:;" data-toggle="dropdown" title="' + users_list[uid] + me +'"><i class="material-icons">account_circle</i> '+ users_list[uid] + me +'</a>\
                        <ul class="dropdown-menu">\
                            <li><a class="at-somebody" id="'+ uid +'" href="javascript:;">@'+ users_list[uid] +'</a></li>\
                            <li><a class="dm" id="'+ uid +'" href="javascript:;">DM</a></li>\
                        </ul>\
                     </li>';
        }
        $('#users-list').empty().append(html);
        // $('#current-number').text(users_list.length);
        fix_offset_y();
    }
    </script>
@endsection
