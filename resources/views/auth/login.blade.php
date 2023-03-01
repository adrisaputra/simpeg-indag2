@extends('layouts.app')

@section('content')
<div class="login-box">
            <div class="login-box-body">
                <div class="text-center">
                    <img src="{{ asset('/upload/logo/simpeg-indag.png') }}" alt="Chris Wood" class="img-fluid" style="height: 80px;max-width: 100%;max-height: 100%;" >
                </div><br>
                <!-- Start Form Login -->
                <form method="POST" action="{{ url('login_w') }}" method="POST" enctype="multipart/form-data">
                @csrf
               
                    @if ($message = Session::get('status'))
                        <p class="alert text-center" style="color: #ffffff;background-color: #dd4b39;border-color: #d73925;">
                            {{ $message }}
                        </p>
                    @endif

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ old('name') }}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <hr style="border: 0.5px dashed #d2d6de">
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-facebook btn-block btn-flat">Sign In</button>
                        </div>
                    </div>
                </form>
                <!-- End Form Login -->

                <hr style="border: 0.5px dashed #d2d6de">
            </div>
        </div>

@endsection