@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection

@section('body')
<!-- Navbar will come here -->
<nav class="navbar navbar-transparent" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/"><i class="fa fa-paper-plane"></i> Chat Here</a>
        </div>
    </div>
</nav>
<!-- end navbar -->

<div class="wrapper">
    <!-- you can use the class main-raised if you want the main area to be as a page with shadows -->
    <div class="main">
        <div class="container">

            <!-- here you can add your content -->
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="card card-login">
                        <div class="card-header">
                            <div class="logo">
                                <i class="fa fa-paper-plane text-primary"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="login-form" method="post" action="">
                                {{ csrf_field() }}
                                <div class="input-group hidden">
                                    <input id="avatar" type="hidden" name="avatar" id="inputAvatar" class="form-control" value="">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons text-primary">face</i>
                                    </span>
                                    <input type="text" class="form-control" name="username" placeholder="Username" maxlength="20" required="" autofocus="" autocomplete="off">
                                </div>
                                <p class="text-center">
                                    <a href="javascript:;" id="settings-btn">Settings</a>
                                </p>
                                <p class="text-center">
                                    <button type="submit" class="btn btn-round btn-primary">Log In</button>
                                </p>
                                @if (count($errors) > 0)
                                    <div id="alert-danger" class="alert alert-danger">
                                        <div class="container-fluid">
                                          <div class="alert-icon">
                                            <i class="material-icons">error_outline</i>
                                          </div>
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                          </button>
                                          @foreach ($errors->all() as $error)
                                          {{ $error }}<br>
                                          @endforeach
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Core -->
<div class="modal fade modal-chat" id="settings-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Avatar</h4>
      </div>
      <div class="modal-body">
        <div class="settings-avatar">
            <ul class="container-fluid row">
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar1.png') }}" data-avatar="avatar1" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar2.png') }}" data-avatar="avatar2" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar3.png') }}" data-avatar="avatar3" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar4.png') }}" data-avatar="avatar4" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar5.png') }}" data-avatar="avatar5" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar6.png') }}" data-avatar="avatar6" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar7.png') }}" data-avatar="avatar7" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar8.png') }}" data-avatar="avatar8" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar9.png') }}" data-avatar="avatar9" alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar10.png') }}" data-avatar="avatar10"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar11.png') }}" data-avatar="avatar11"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar12.png') }}" data-avatar="avatar12"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar13.png') }}" data-avatar="avatar13"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar14.png') }}" data-avatar="avatar14"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar15.png') }}" data-avatar="avatar15"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar16.png') }}" data-avatar="avatar16"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar17.png') }}" data-avatar="avatar17"  alt=""></li>
                <li class="col-xs-3 col-md-4"><img class="img-circle img-responsive" src="{{ asset('img/avatar/avatar18.png') }}" data-avatar="avatar18"  alt=""></li>
            </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info btn-simple" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('/js/login.js') }}" type="text/javascript"></script>
@endsection
