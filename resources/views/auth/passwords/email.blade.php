@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center"> -->
<!-- <div class="col-md-8"> -->
<div class="full-screen">
    <div class="row" style="height: 100%;">
        <div class="col login-left-side psw1-bg"></div>
        <div class="col login-right-side">

            <div class="login-form">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail
                                    Address') }}</label> -->

                                <div class="col-md-12">
                                    <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div>
                                <p>Do you already have an account? <a href="{{ route('login') }}">Sign In now</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<!-- </div>
</div> -->
@endsection