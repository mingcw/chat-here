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
                                <img class="img-circle img-raised img-responsive" src="./img/avatar/default.png">
                                <span id="username">Rem Qange</span><br />
                                <span><a id="logout" href="javascript:;">Log Out</a></span>
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
                                <a href="create-room.html" class="btn btn-default"><i class="material-icons">group_add</i> Create Room</a>
                            </li>
                            <li role="presentation" class="text-muted rooms-info">
                                <p>512 Rooms, 1024 Users</p>
                            </li>
                        </ul>
                        <div class="rooms-list">
                            <ul class="room-item">
                                <li class="name">
                                    <a href="javascript:;" title="Rriamore Academy">
                                        <i class="material-icons text-danger">group</i> <span class="room-name">Rriamore Academy</span>
                                    </a>
                                </li>
                                <li class="creator text-center"><i class="material-icons text-info">account_circle</i> Calggc</li>
                                <li class="status">
                                    <dl>
                                        <dt class="text-muted">5/10</dt>
                                        <dd>
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style="width: 50%;" >
                                                <span class="sr-only">5/10</span>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                            <ul class="room-item">
                                <li class="name">
                                    <a href="javascript:;" title="Rriamore Academy">
                                        <i class="material-icons text-danger">group</i> <span class="room-name">Rriamore Academy</span>
                                    </a>
                                </li>
                                <li class="creator text-center"><i class="material-icons text-info">account_circle</i> Calggc</li>
                                <li class="status">
                                    <dl>
                                        <dt class="text-muted">5/10</dt>
                                        <dd>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style="width: 50%;" >
                                                <span class="sr-only">5/10</span>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                            <ul class="room-item">
                                <li class="name">
                                    <a href="javascript:;" title="Rriamore Academy">
                                        <i class="material-icons text-danger">group</i> <span class="room-name">Rriamore Academy</span>
                                    </a>
                                </li>
                                <li class="creator text-center"><i class="material-icons text-info">account_circle</i> Calggc</li>
                                <li class="status">
                                    <dl>
                                        <dt class="text-muted">5/10</dt>
                                        <dd>
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style="width: 50%;" >
                                                <span class="sr-only">5/10</span>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                            <ul class="room-item">
                                <li class="name">
                                    <a href="javascript:;" title="Rriamore Academy">
                                        <i class="material-icons text-danger">group</i> <span class="room-name">Rriamore Academy</span>
                                    </a>
                                </li>
                                <li class="creator text-center"><i class="material-icons text-info">account_circle</i> Calggc</li>
                                <li class="status">
                                    <dl>
                                        <dt class="text-muted">5/10</dt>
                                        <dd>
                                             <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="10" style="width: 50%;" >
                                                <span class="sr-only">5/10</span>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
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