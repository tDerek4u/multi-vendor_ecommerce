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
                        <a href="javascript:;">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->

    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container ">
            <div class="row d-flex">
                <!-- Account -->
                <div class="col-lg-6">
                    <div class="">
                            <form class="userAccountDetails" action="javascript:;" id="login-form">
                                @csrf
                                <h2 class="account-h2 u-s-m-b-20">Update Contact Details</h2>
                                <h4 class="text-danger" id="error_message"></h4> <br>

                                <div class="u-s-m-b-30">
                                    <label for="user-email">Email
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" value="{{ Auth::user()->email }}" style="border-color: red" readonly
                                        placeholder="Email">

                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-name">Name
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-name" name="user-name" value="{{ Auth::user()->name }}"
                                        placeholder="Email" required>
                                        <span class="text-danger" id="user-name_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-address">Address
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-address" name="user-address" value="{{ Auth::user()->address }}"
                                        placeholder="Address" >
                                        <span class="text-danger" id="address_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-city">City
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-city" name="user-city" value="{{ Auth::user()->city }}"
                                        placeholder="City" >
                                        <span class="text-danger" id="city_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-state">State
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-state" name="user-state" value="{{ Auth::user()->state }}"
                                        placeholder="State" >
                                        <span class="text-danger" id="state_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-country">Shop Country</label>
                                    <select name="user-country" style="color:black" id="user-country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country['country_name'] }}" @if($country['country_name'] == Auth::user()->country ) selected  @endif>{{ $country['country_name'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="country_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-pincode">Pincode
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-pincode" name="user-pincode" value="{{ Auth::user()->pincode }}"
                                        placeholder="Pincode" >
                                        <span class="text-danger" id="pincode_error"></span> <br>
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-mobile">Mobile
                                        <span class="astk">*</span>
                                    </label>
                                    <input  class="text-field" type="text" id="user-mobile" name="user-mobile" value="{{ Auth::user()->mobile }}"
                                        placeholder="Mobile" required>
                                        <span class="text-danger" id="mobile_error"></span> <br>
                                </div>

                                <div class="m-b-45">
                                    <button class="button button-outline-secondary w-100">Update  <i class="fa  " style="font-size: 15px;"></i></button>
                                </div>
                            </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="">
                            <form class="userLoginForm" action="javascript:;" id="login-form">
                                @csrf
                                <h2 class="account-h2 u-s-m-b-20">Update Password</h2>
                                <h4 class="text-danger" id="error_message"></h4> <br>

                                <div class="u-s-m-b-30">
                                    <label for="user-current-password">Current Password
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="password" id="user-current-password"  class="text-field" >
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-new-password">New Password
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="password" id="user-new-password"  class="text-field" >
                                </div>

                                <div class="u-s-m-b-30">
                                    <label for="user-confirm-password">Confirm Password
                                        <span class="astk">*</span>
                                    </label>
                                    <input type="password" id="user-confirm-password"  class="text-field" >
                                </div>

                                <div class="m-b-45">
                                    <button class="button button-primary w-100">Update</button>
                                </div>
                            </form>
                    </div>
                </div>
                <!-- Account /- -->
            </div>

        </div>
    </div>
    <!-- Account-Page /- -->
@endsection
