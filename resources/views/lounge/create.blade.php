@extends('layouts.app')

@section('title', 'Create Room')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/create-room.css') }}">
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
                    <div class="card card-create">
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
                        <div class="sr-only card-header">
                            <h4 class="text-muted">Create Room</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" role="form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="form-name">Room name</label>
                                    <input type="text" class="form-control" id="form-name" name="name" value="" maxlength="20" required="" autofocus="">
                                </div>
                                <div class="form-group">
                                    <label for="form-description">Room description</label>
                                    <input type="text" class="form-control" id="form-description" name="description" value="" maxlength="140">
                                </div>
                                <div class="form-group">
                                    <label for="form-limit text-lg">User capacity</label>
                                    <select class="form-control" id="form-limit" name="capacity" required="">
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                    </select>
                                </div>
                                <div class="pull-right">
                                  <a href="javascript:;" class="btn btn-sm btn-default" onclick="javascript:history.go(-1);">Back</a>
                                  <input type="submit" class="btn btn-sm btn-primary" value="Create Room">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
