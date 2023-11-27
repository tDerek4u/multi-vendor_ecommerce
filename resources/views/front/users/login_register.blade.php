@extends('front.layout.layout')


@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>User Account</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('user/login-register') }}">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->

    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container ">
            <div class="row  justify-content-center align-items-center">
                <!-- Register -->
                <div class="col-lg-6 ">
                    <div class="reg-wrapper">



                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success_message') }}
                                <button type="button" class="close mt-4" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form id="userRegisterForm" action="javascript:;" id="a" class="register-form ">
                            @csrf
                            <h2 class="account-h2 u-s-m-b-20">User Register</h2>
                            <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order
                                status and history.</h6>
                            <div class="u-s-m-b-30">
                                <label for="userName">Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="userName" name="username" class="text-field mb-1"
                                    placeholder="User Name">
                                    <span class="text-danger" id="name_error"></span>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userMobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="userMobile" name="usermobile" class="text-field mb-1"
                                    placeholder="User Mobile">
                                    <span class="text-danger" id="mobile_error"></span>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userEmail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="userEmail" class="text-field mb-1" name="useremail"
                                    placeholder="User Email">
                                    <span class="text-danger" id="email_error"></span>

                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userPassword">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="userpassword" class="text-field mb-1 userpassword"
                                    placeholder="User Password" id="myInput_log_password">
                                    <span class="text-danger" id="password_error"></span> <br>
                                <input type="checkbox" class="fs-3" onclick="myFunction_log_password()">Show Password


                            </div>
                            <div class="u-s-m-b-30">
                                <label for="userPasswordConfirmation">Password Confirmation
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="user_password_confirmation"
                                    class="text-field mb-1 user_password_confirmation"
                                    placeholder="User Password Confirmation" id="myInput_log_password_con">
                                    <span class="text-danger" id="password_confirmation_error"></span> <br>
                                <input type="checkbox" class="fs-3" onclick="myFunction_log_password_con()">Show Password


                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box accept" id="accept" name="accept">

                                <label class="label-text no-color" for="accept">I’ve read and accept the
                                    <a href="terms-and-conditions.html" class="u-c-brand mb-3">terms & conditions</a>
                                </label> <br>
                                <br>
                                <span class="text-danger" id="accept_error"></span>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100 mb-1">Register</button>
    
                            </div>

                            <p class="login">Already registered? <a href="#">Sign In</a></p>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->


            </div>

            <div class="row  justify-content-center align-items-center">
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">

                        <form class="pt-3" action="javascript:;" id="login-form">
                            @csrf
                            <h2 class="account-h2 u-s-m-b-20">User Login</h2>
                            <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                            <div class="u-s-m-b-30">
                                <label for="user-name-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="useremail" name="useremail" class="text-field"
                                    placeholder="User Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="login-password">Password
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="userpassword" class="text-field mb-3 form-control"
                                    placeholder="User Password" id="myInput">

                                <input type="checkbox" class="fs-3" onclick="myFunction()">Show Password
                            </div>
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Login</button>
                            </div>
                            <p class="register mt-4">Not registered? <a href="#">Sign Up</a></p>

                        </form>
                    </div>
                </div>
                <!-- Login /- -->
            </div>

        </div>
    </div>
    <!-- Account-Page /- -->
@endsection
