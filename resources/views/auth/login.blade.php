@extends('layouts.app')

@section('css')
@endsection

@section('js')
<script src="{{ asset('js/login.js') }}" defer></script>
@endsection

@section('content')
<div class="full-screen">
    <div class="row" style="height: 100%;">
        <div class="col login-left-side"></div>
        <div class="col login-right-side">
            <div class="login-form">
                <form id="loginForm">
                    <div>
                        <h2>Welcome to Client Manager</h2>
                        <p>Please Sing In</p>
                    </div>
                    @if(Session::has('sysmsg'))
                    <div class="alert alert-primary" role="alert">{{ Session::get('sysmsg') }}</div>
                    @endif
                    <div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email" autofocus />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="password" />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>

                        </div>
                    </div>
                </form>
                <div>
                    <p>Forgot Your Password? <a href="{{ route('password.request') }}">Click here</a>.</p>
                </div>
                <div>
                    <p>New to Client Manager? <a href="{{ route('register') }}">Sign Up now</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection