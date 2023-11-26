@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Settings</h3>
              <h6 class="font-weight-normal mb-0">Update shop Details</h6>

            </div>
            <div class="col-12 col-xl-4">
             <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                 <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <a class="dropdown-item" href="#">January - March</a>
                  <a class="dropdown-item" href="#">March - June</a>
                  <a class="dropdown-item" href="#">June - August</a>
                  <a class="dropdown-item" href="#">August - November</a>
                </div>
              </div>
             </div>
            </div>
          </div>
        </div>
      </div>


      @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Persoanl Information</h4>
                    @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                       {{ Session::get('success_message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                    </div>
                    @endif
                   @if(Session::has('error_message'))
                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong> Error: </strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                   </div>
                   @endif

                   @if($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          @foreach ($errors->all() as $error)
                              <li> {{ $error }} </li>
                          @endforeach
                          <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                  @endif

                    <p class="card-description">
                      Basic form layout
                    </p>
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label >Vendor Username/Email</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Role Type</label>
                        <input  class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control mb-2" id="vendor_name" value="{{ Auth::guard('admin')->user()->name }}" placeholder="Name" name="vendor_name" >
                      </div>
                      <div class="form-group">
                        <label for="vendor_address">Address</label>
                        <input type="text" class="form-control mb-2" id="vendor_address" value="{{ $vendorDetails['address'] }}" placeholder="Address" name="vendor_address" >
                      </div>
                      <div class="form-group">
                        <label for="vendor_city">City</label>
                        <input type="text" class="form-control mb-2" id="vendor_city"  value="{{ $vendorDetails['city'] }}"  placeholder="City" name="vendor_city" >
                      </div>
                      <div class="form-group">
                        <label for="vendor_state">State</label>
                        <input type="text" class="form-control mb-2" id="vendor_state"  value="{{ $vendorDetails['state'] }}"  placeholder="State" name="vendor_state" >

                    </div>
                      <div class="form-group">
                        <label for="vendor_country">Country</label>
                        <select name="vendor_country" id="vendor_country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country['country_name'] }}" @if($country['country_name'] == $vendorDetails['country'] ) selected  @endif>{{ $country['country_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="form-group">
                        <label for="vendor_pincode">Pincode</label>
                        <input type="text" class="form-control mb-2" id="vendor_pincode"  value="{{ $vendorDetails['pincode'] }}" placeholder="Pincode" name="vendor_pincode" >
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ Auth::guard('admin')->user()->mobile }}" name="vendor_mobile" >
                    </div>
                      <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="vendor_image" placeholder="Image" value="{{ Auth::guard('admin')->user()->image }}" name="vendor_image" >
                        @if(!empty(Auth::guard('admin')->user()->image)) <br>
                          <a target="_blank" class="" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                          <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                        @endif
                    </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
        </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Business Information</h4>
                    @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                       {{ Session::get('success_message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                    </div>
                    @endif
                   @if(Session::has('error_message'))
                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong> Error: </strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                   </div>
                   @endif

                   @if($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          @foreach ($errors->all() as $error)
                              <li> {{ $error }} </li>
                          @endforeach
                          <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                  @endif

                    <p class="card-description">
                      Basic form layout
                    </p>
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label >Vendor Username/Email</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Role Type</label>
                        <input  class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly>
                      </div>
                      <div class="form-group">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" class="form-control mb-2" id="shop_name" value="{{ $vendorDetails['shop_name'] }}" placeholder="Shop Name" name="shop_name" >
                      </div>
                      <div class="form-group">
                        <label for="shop_address">Shop Address</label>
                        <input type="text" class="form-control mb-2" id="shop_address" value="{{ $vendorDetails['shop_address'] }}" placeholder="Address" name="shop_address" >
                      </div>
                      <div class="form-group">
                        <label for="shop_city">Shop City</label>
                        <input type="text" class="form-control mb-2" id="shop_city"  value="{{ $vendorDetails['shop_city'] }}"  placeholder="City" name="shop_city" >
                      </div>
                      <div class="form-group">
                        <label for="shop_state">Shop State</label>
                        <input type="text" class="form-control mb-2" id="shop_state"  value="{{ $vendorDetails['shop_state'] }}"  placeholder="State" name="shop_state" >
                      </div>
                      <div class="form-group">
                        <label for="shop_country">Shop Country</label>
                        <select name="shop_country" style="color:black" id="shop_country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country['country_name'] }}" @if($country['country_name'] == $vendorDetails['shop_country'] ) selected  @endif>{{ $country['country_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                      <div class="form-group">
                        <label for="shop_pincode">Shop Pincode</label>
                        <input type="text" class="form-control mb-2" id="shop_pincode"  value="{{ $vendorDetails['shop_pincode'] }}" placeholder="Pincode" name="shop_pincode" >
                      </div>
                      <div class="form-group">
                        <label for="shop_mobile">Shop Mobile</label>
                        <input type="text" class="form-control" id="shop_mobile" placeholder="Mobile" value="{{ $vendorDetails['shop_mobile'] }}" name="shop_mobile" >
                    </div>
                    <div class="form-group">
                        <label for="shop_website">Shop Website</label>
                        <input type="text" class="form-control" id="shop_website" placeholder="Website" value="{{ $vendorDetails['shop_website'] }}" name="shop_website" >
                    </div>
                    <div class="form-group">
                        <label for="shop_email">Shop Email</label>
                        <input type="text" class="form-control" id="shop_email" placeholder="Website" value="{{ $vendorDetails['shop_email'] }}" name="shop_email" >
                    </div>
                      <div class="form-group">
                        <label for="address_proof">Address Proof</label>
                        <select name="address_proof" id="address_proof" class="form-control ">
                            <option value="">Select</option>
                            <option value="Passport" @if($vendorDetails['address_proof'] == "Passport") selected @endif>Passport</option>
                            <option value="Voting Card"   @if($vendorDetails['address_proof'] == "Voting Card") selected @endif>Voting Card</option>
                            <option value="PAN"  @if($vendorDetails['address_proof'] == "PAN") selected @endif>PAN</option>
                            <option value="Driving License"  @if($vendorDetails['address_proof'] == "Driving License") selected @endif>Driving License</option>
                            <option value="Aadhar Card"  @if($vendorDetails['address_proof'] == "Aadhar Card") selected @endif>Aadhar Card</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="business_license_number">Business License</label>
                        <input type="text" class="form-control mb-2" id="business_license_number"  value="{{ $vendorDetails['business_license_number'] }}" placeholder="Business License" name="business_license_number" >
                    </div>
                    <div class="form-group">
                        <label for="gst_number">GST Number</label>
                        <input type="text" class="form-control mb-2" id="gst_number"  value="{{ $vendorDetails['gst_number'] }}" placeholder="GST Number" name="gst_number" >
                    </div>
                    <div class="form-group">
                        <label for="pan_number">PAN Number</label>
                        <input type="text" class="form-control mb-2" id="pan_number"  value="{{ $vendorDetails['pan_number'] }}" placeholder="PAN Number" name="pan_number" >
                    </div>
                      <div class="form-group">
                        <label for="image">Address Proof Image</label>
                        <input type="file" class="form-control" id="address_proof_image" placeholder="Image" value="{{ $vendorDetails['address_proof_image'] }}" name="address_proof_image" >
                        @if(!empty(Auth::guard('admin')->user()->image)) <br>
                          <a target="_blank" class="" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image'] ) }}">View Image</a>
                          <input type="hidden" name="current_address_proof_image" value="{{ $vendorDetails['address_proof_image'] }}">
                        @endif
                    </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
        </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Bank Information</h4>
                    @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                       {{ Session::get('success_message') }}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                    </div>
                    @endif
                   @if(Session::has('error_message'))
                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong> Error: </strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                   </div>
                   @endif

                   @if($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          @foreach ($errors->all() as $error)
                              <li> {{ $error }} </li>
                          @endforeach
                          <button type="button" class="close mt-2" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                  @endif

                    <p class="card-description">
                      Basic form layout
                    </p>
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        <label >Vendor Username/Email</label>
                        <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Account Holder</label>
                        <input  class="form-control" name="account_holder_name" value="{{ $vendorDetails['account_holder_name'] }}" placeholder="Account Holder Name">
                      </div>
                      <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control mb-2" id="bank_name" value="{{ $vendorDetails['bank_name'] }}" placeholder="Bank Name" name="bank_name" >
                      </div>
                      <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control mb-2" id="account_number" value="{{ $vendorDetails['account_number'] }}" placeholder="Account Number" name="account_number" >
                      </div>
                      <div class="form-group">
                        <label for="bank_ifsc_code">Bank IFSC CODE</label>
                        <input type="text" class="form-control mb-2" id="bank_ifsc_code"  value="{{ $vendorDetails['bank_ifsc_code'] }}"  placeholder="Bank IFSC Code" name="bank_ifsc_code" >
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
        </div>
        @endif





        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->

  </div>
@endsection
