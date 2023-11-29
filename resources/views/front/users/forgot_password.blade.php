@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Lost Password</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:;">Lost Password</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Lost-password-Page -->
<div class="page-lost-password u-s-p-t-80">
    <div class="container">
        <div class="page-lostpassword">
            <h2 class="account-h2 u-s-m-b-20">Forgot Password ?</h2>
            <h6 class="account-h6 u-s-m-b-30">Enter your email below and we will send you a link to reset your password.</h6>
            <form id="forgotForm" action="javascript:;">
                <div class="w-50">
                    <div class="u-s-m-b-13">
                        <label for="user-name-email">Email
                            <span class="astk">*</span>
                        </label>
                        <input type="text" id="forgot_email" class="text-field mb-1" placeholder="Email">
                        <span id="email_error" class="text-danger "></span>
                </div>
                <div class="m-b-45">
                    <button class="button button-outline-secondary w-100">Login</button>
                </div>
                <div class="page-anchor mt-2">
                    <a href="{{ url('user/login-register') }}">
                        <i class="fas fa-long-arrow-alt-left u-s-m-r-9"></i>Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Lost-Password-Page /- -->
@endsection
