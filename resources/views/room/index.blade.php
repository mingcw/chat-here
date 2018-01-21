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
                <input type="text" name="netease-cloud-music-playlist-id" class="form-control" maxlength="12">
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
                <label class="control-label">Url (must)</label>
                <input type="text" name="music-src" class="form-control" maxlength="240">
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
    <script src="{{ asset('js/room.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var global_url_web_socket_swf_location = '{{ url("/swf/WebSocketMain.swf") }}';
        var global_url_bind = '{{ url("bind") }}';
        var global_url_say = '{{ url("say") }}';
        var global_url_flush = '{{ url("flush") }}';
        var global_url_music = '{{ url("music") }}';
        var global_csrf_token = '{{ csrf_token() }}';
        var global_uname = '{{ $uname }}';
        var global_room_id = {{ $room_id }};
        var global_asset_avatar = '{{ asset("/img/avatar") }}';
    </script>
@endsection
