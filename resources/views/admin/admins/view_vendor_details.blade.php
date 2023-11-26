@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Vendor Details</h3>

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

        <div class="row">

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Persoanl Information</h4>

                      <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control mb-2" id="vendor_name" value="{{ $vendorDetails['vendor_personal']['name'] }}" placeholder="" name="" readonly>
                      </div>
                      <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" class="form-control mb-2" id="" value="{{ $vendorDetails['vendor_personal']['address'] }}" placeholder="" name="" readonly>
                      </div>
                      <div class="form-group">
                        <label for="">City</label>
                        <input type="text" class="form-control mb-2" id=""  value="{{ $vendorDetails['vendor_personal']['city'] }}"  placeholder="" name="" readonly>
                      </div>
                      <div class="form-group">
                        <label for="">State</label>
                        <input type="text" class="form-control mb-2" id="" value="{{ $vendorDetails['vendor_personal']['state'] }}"  placeholder="" name="" readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_country">Country</label>
                        <input type="text" class="form-control mb-2" id="vendor_country" value="{{ $vendorDetails['vendor_personal']['country'] }}" placeholder="Country" name="vendor_country" readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_pincode">Pincode</label>
                        <input type="text" class="form-control mb-2" id="vendor_pincode"  value="{{ $vendorDetails['vendor_personal']['pincode'] }}" placeholder="Pincode" name="vendor_pincode" readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_personal']['mobile'] }}" name="vendor_mobile" readonly>
                    </div>
                    @if(!empty( $vendorDetails['image'] ))
                      <div class="form-group">
                        <label for="image">Photo</label>  <br>
                            <img src="{{ url('admin/images/photos/' . $vendorDetails['image']) }}" style="width: 200px;" alt="" readonly>

                        </div>
                    @endif

                  </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Business Information</h4>

                      <div class="form-group">
                        <label for="vendor_name">Shop Name</label>
                        <input type="text" class="form-control mb-2" id="vendor_name" value="{{ $vendorDetails['vendor_business']['shop_name'] }}" placeholder="Name" name="vendor_name"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_address">Shop Address</label>
                        <input type="text" class="form-control mb-2" id="vendor_address" value="{{ $vendorDetails['vendor_business']['shop_address'] }}" placeholder="Address" name="vendor_address"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_city">Shop City</label>
                        <input type="text" class="form-control mb-2" id="vendor_city"  value="{{ $vendorDetails['vendor_business']['shop_city'] }}"  placeholder="City" name="vendor_city"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_state">Shop State</label>
                        <input type="text" class="form-control mb-2" id="vendor_state" value="{{ $vendorDetails['vendor_business']['shop_state'] }}"  placeholder="State" name="vendor_state"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_country">Shop Country</label>
                        <input type="text" class="form-control mb-2" id="vendor_country" value="{{ $vendorDetails['vendor_business']['shop_country'] }}" placeholder="Country" name="vendor_country"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_pincode">Shop Pincode</label>
                        <input type="text" class="form-control mb-2" id="vendor_pincode"  value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}" placeholder="Pincode" name="vendor_pincode"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Shop Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Shop Website</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['shop_website'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Shop Email</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['shop_email'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Address Proof</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['address_proof'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Business License Number</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['business_license_number'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">GST Number</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['gst_number'] }}" name="vendor_mobile"  readonly>
                      </div>
                      <div class="form-group">
                        <label for="vendor_mobile">PAN Number</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" value="{{ $vendorDetails['vendor_business']['pan_number'] }}" name="vendor_mobile"  readonly>
                      </div>
                    @if(!empty( $vendorDetails['vendor_business']['address_proof_image'] ))
                      <div class="form-group">
                        <label for="image">Photo</label>  <br>
                            <img src="{{ url('admin/images/proofs/' . $vendorDetails['vendor_business']['address_proof_image']) }}" style="width: 400px;" alt="" readonly>
                        </div>
                    @endif
                  </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bank Information</h4>
                  <p class="card-description">

                  </p>

                    <div class="form-group">
                      <label for="">Account Name</label>
                      <input type="text" class="form-control mb-2" id="" value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" placeholder="" name=""  readonly>
                    </div>
                    <div class="form-group">
                      <label for="">Bank Name</label>
                      <input type="text" class="form-control mb-2" id="vendor_address" value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" placeholder="" name=""  readonly>
                    </div>
                    <div class="form-group">
                      <label for="">Account Number</label>
                      <input type="text" class="form-control mb-2" id="vendor_city"  value="{{ $vendorDetails['vendor_bank']['account_number'] }}"  placeholder="" name=""  readonly>
                    </div>
                    <div class="form-group">
                      <label for="">Bank IFSC Code</label>
                      <input type="text" class="form-control mb-2" id="vendor_state" value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}"  placeholder="" name=""  readonly>
                    </div>
                </div>
              </div>
          </div>


        </div>




        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->

  </div>
@endsection
