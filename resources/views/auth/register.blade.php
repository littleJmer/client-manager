@extends('layouts.app')

@section('css')
@endsection

@section('js')
<script src="{{ asset('js/login.js') }}" defer></script>
@endsection

@section('content')
<div class="full-screen">
    <div class="row" style="height: 100%;">
        <div class="col login-left-side register-bg"></div>
        <div class="col login-right-side">
            <div class="login-form">
                <form id="registerForm">
                    <div>
                        <h2>Sign Up to Client Manager</h2>
                        <p>Create your account</p>
                    </div>
                    <div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name" autofocus />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email" />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" />
                            <div class="invalid-feedback show"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>

                        </div>
                    </div>
                </form>
                <div>
                    <p>Do you already have an account? <a href="{{ route('login') }}">Sign In now</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection