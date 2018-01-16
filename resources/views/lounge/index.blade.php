@extends('layouts.app')

@section('title', 'Lounge')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/lounge.css') }}">
@endsection

@section('body')
<div class="wrapper">
    <!-- you can use the class main-raised if you want the main area to be as a page with shadows -->
    <div class="main">
        <div class="container">

            <!-- here you can add your content -->
            <div class="row">
                <div class="col-md-4 col-md-push-8">
                    <!-- side bar -->
                   <div class="sidebar">
                        <ul class="profile">
                            <li class="user-info clearfix">
                                <img class="img-circle img-raised img-responsive" src="{{ asset('/img/avatar/' . $avatar . '.png') }}">
                                <span id="username">{{ $uname }}</span><br />
                                <span><a id="logout" href="/logout">Log Out</a></span>
                            </li>
                        </ul>
                        <div class="card sidebar-box room-filter-wrap">
                            <div class="form-group">
                              <input id="serachInput" type="text" class="form-control" placeholder="Search Room...">
                            </div>
                        </div>
                        <div class="card sidebar-box welcome">
                            <p>Talk to a stranger here.</p>
                            <p>"Simplicity does not precede complexity, but follows it" -- Alan Perlis</p>
                        </div>
                   </div>

                </div>
                <div class="col-md-8 col-md-pull-4">
                    <!-- chat part -->
                    <div class="card chat-wrap">
                        <ul class="nav-wrap">
                            <li role="presentation">
                                <a href="{{ url('create') }}" class="btn btn-default"><i class="material-icons">group_add</i> Create Room</a>
                            </li>
                            <li role="presentation" class="text-muted rooms-info">
                                <p>{{ $room_count }} Rooms, {{ $user_count }} Users</p>
                            </li>
                        </ul>
                        <div class="rooms-list">
                            @foreach($rooms as $room)
                                <ul class="room-item">
                                    <li class="name">
                                        <a href="/room/{{ $room->id}}" title="{{ $room->description or $room->name}}">
                                            <i class="material-icons text-danger">group</i> <span class="room-name">{{ $room->name }}</span>
                                        </a>
                                    </li>
                                    <li class="creator text-center"><i class="material-icons text-info">account_circle</i> {{ $room->username }}</li>
                                    <li class="status">
                                        <dl>
                                            <dt class="text-muted">{{ $room->number }}/{{ $room->capacity }}</dt>
                                            <dd>
                                                 <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $room->number }}" aria-valuemin="0" aria-valuemax="{{ $room->capacity }}" style="width: {{ $room->number / $room->capacity * 100 }}%" >
                                                    <span class="sr-only">5/10</span>
                                                    </div>
                                                </div>
                                            </dd>
                                        </dl>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- footer -->
            <div class="row">
                 <div class="col-md-8">
                    <footer class="text-white text-center">
                        Copyright @2018 mingcw · GitHub
                    </footer>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('/js/lounge.js') }}" type="text/javascript"></script>
@endsection