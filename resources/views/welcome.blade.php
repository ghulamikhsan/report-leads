@extends('layouts.Auth.master')
@section('title')
    Login Account
@endsection

@section('content')
    <div class="card card-outline card-success">
        <div class="card-header text-center">
            <a href="{{ url('/') }}" class="h1"><b>Login</b></a>
        </div>
        <div class="card-body">
            <!--<p class="login-box-msg">Sign in to start your session</p>-->

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off" required>
                    @error('email')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    @error('password')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-5"></div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-success">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <!--<p class="mb-0">-->
            <!--    <a href="{{route('register')}}" class="text-center">Register a new membership</a>-->
            <!--</p>-->
        </div>
        <!-- /.card-body -->
    </div>
@endsection
