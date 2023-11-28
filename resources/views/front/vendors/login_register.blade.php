@extends('front.layout.layout')


@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Vendor Account</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('vendor/login-register') }}">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container " >
            <div class="row d-flex">
                <!-- Register -->
                <div class="col-lg-6 " >
                    <div class="reg-wrapper">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           {{ Session::get('success') }}
                           <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        @endif



                         @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           {{ Session::get('success_message') }}
                           <button type="button" class="close mt-4" data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        @endif

                        <form id="vendorRegisterForm" action="{{ url('vendor/register') }}" method="post" id="a" class="register-form ">
                            @csrf
                            <h2 class="account-h2 u-s-m-b-20">Vendor Register</h2>
                            <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status and history.</h6>
                            <div class="u-s-m-b-30">
                                <label for="vendorName">Name
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorName" name="name" class="text-field mb-3" placeholder="Vendor Name">

                                @if ($errors->has('name'))
                                <span class="error text-danger">{{ $errors->first('name') }}</span>
                                @endif


                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorMobile">Mobile
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorMobile" name="mobile" class="text-field mb-3" placeholder="Vendor Mobile">
                                @if ($errors->has('mobile'))
                                <span class="error text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorEmail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="text"  class="text-field mb-3" name="email" placeholder="Vendor Email">
                                @if ($errors->has('email'))
                                <span class="error text-danger">{{ $errors->first('email') }}</span>
                                @endif

                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorPassword">Password
                                    <span class="astk">*</span>
                                </label>



                                <input type="password"  name="password"  class="text-field mb-3" placeholder="Vendor Password" id="myInput_log_password">
                                <input type="checkbox" class="fs-3" onclick="myFunction_log_password()">Show Password

                                @if ($errors->has('password'))
                                <span class="error text-danger">{{ $errors->first('password') }}</span>
                                @endif


                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorPasswordConfirmation">Password Confirmation
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="password_confirmation" class="text-field mb-3" placeholder="Vendor Password Confirmation"  id="myInput_log_password_con">

                                <input type="checkbox" class="fs-3" onclick="myFunction_log_password_con()">Show Password

                                @if ($errors->has('password_confirmation'))
                                <span class="error text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box"  id="accept" name="accept">
                                <label class="label-text no-color" for="accept">I’ve read and accept the
                                    <a href="terms-and-conditions.html" class="u-c-brand mb-3">terms & conditions</a>
                                </label> <br>
                                <br>
                                @if ($errors->has('accept'))
                                <span class="error text-danger">{{ $errors->first('accept') }}</span>
                                @endif
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100 mb-3">Register</button>
                                <span class="text-center mt-4 text-danger">Wait before until show success message !</span>
                            </div>

                            <p class="login">Already registered? <a href="#">Sign In</a></p>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->

                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           {{ Session::get('error_message') }}
                           <button type="button" class="close " data-dismiss="alert" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        @endif
                            <form action="{{ url('admin/login') }}" method="post" id="login-form" >
                                @csrf
                                <h2 class="account-h2 u-s-m-b-20">Vendor Login</h2>
                                <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                                <div class="u-s-m-b-30">
                                    <label for="user-name-email">Email
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="text" id="vendorEmail" name="email" class="text-field" placeholder="Vendor Email">

                                </div>
                                <div class="u-s-m-b-30">
                                    <label for="login-password">Password
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="password" name="password" class="text-field mb-3 form-control vendorPassword" placeholder="Vendor Password" id="myInput">

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
