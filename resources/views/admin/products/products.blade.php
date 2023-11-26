@extends('admin.layout.layout')

@section('content')
     <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">Catalouge Management</h3>
                  <h4 class="card-title">Products</h4>


                  <a style="max-width: 150px; float: right; display: inline-block" href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-primary">Add Product</a>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <div class="table-responsive pt-3">
                    <table id="products" class="table table-bordered products">
                      <thead>
                        <tr>
                          <th>
                                ID
                          </th>
                          <th>
                                Product Name
                          </th>
                          <th>
                                Product Code
                          </th>
                          <th>
                                Product Color
                          </th>
                          <th>
                                Product Image
                          </th>
                          <th>
                                Category
                          </th>
                          <th>
                                Section
                          </th>
                          <th>
                                Brand
                          </th>
                          <th>
                                Added By
                          </th>
                          <th>
                                Status
                          </th>
                          <th>
                                Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($products as $product)
                        <tr>
                          <td>
                            {{ $product['id'] }}
                          </td>
                          <td>
                            {{ $product['product_name'] }}
                          </td>
                          <td>
                            {{ $product['product_code'] }}
                          </td>
                          <td>
                            {{ $product['product_color'] }}
                          </td>
                          <td class="text-center">
                            @if(!empty($product['product_image']))
                                <a href="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" target="_blank">
                                    <img style="width: 150px; height: 150px;" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" alt="">
                                </a>
                            @else
                                <img style="width: 150px; height: 150px;" src="{{ asset('front/images/product_images/small/NoImage.png') }}" alt="">
                            @endif
                          </td>
                          <td>
                            {{ $product['category']['category_name'] }}
                          </td>
                          <td>
                            {{ $product['section']['name'] }}
                          </td>
                          <td>
                            {{ $product['brand']['name'] }}
                          </td>
                          <td>
                            @if(Auth::guard('admin')->user()->type == "vendor")
                                {{ ucfirst(Auth::guard('admin')->user()->name) }}
                            @else
                            @if($product['admin_type'] == 'vendor')
                                <a target="_blank" class="text-decoration-none" href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ ucfirst($product['admin_type']) }}</a>
                                @else
                                    {{ ucfirst($product['admin_type']) }}
                            @endif
                            @endif
                          </td>
                          <td>
                            @if($product['status'] == 1 )
                            <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}">
                             <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle " status="Active">
                             </i>
                            </a>
                            @else
                            <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}">
                               <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle-outline "  status="Inactive">
                             </i>
                            </a>
                            @endif
                          </td>
                          <td>
                               <a href="{{ url('admin/add-edit-product/'.$product['id']) }}" title="Edit Product">
                                <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                               </a>
                               <a href="{{ url('admin/add-edit-attributes/'.$product['id']) }}" title="Add Edit Attribute">
                                <i style="font-size: 25px;" class="mdi mdi-plus-box"></i>
                               </a>
                               <a href="{{ url('admin/add-images/'.$product['id']) }}" title="Add Multiple Images">
                                <i style="font-size: 25px;" class="mdi mdi-animation"></i>
                               </a>
                               <a href="javascript:void(0)" module="product" moduleid="{{ $product['id'] }}"  class="confirmDelete" title="Delete Product">
                                <i style="font-size: 25px;" class="mdi mdi-delete"></i>
                               </a>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
@endsection
