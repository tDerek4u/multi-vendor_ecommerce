@extends('admin.layout.layout')

@section('content')
     <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  {{--  <h3 class="font-weight-bold">Catalouge Management</h3>  --}}
                  <h4 class="card-title">Home Page Banners</h4>

                  <a style="max-width: 150px; float: right; display: inline-block" href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-primary">Add Banner</a>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif

                  <div class="table-responsive pt-3">
                    <table id="banners" class="table table-bordered banners">
                      <thead>
                        <tr>
                          <th>
                                ID
                          </th>
                          <th>
                                Image
                          </th>
                          <th>
                                Type
                          </th>
                          <th>
                                Link
                          </th>
                          <th>
                                Title
                          </th>
                          <th>
                                Alt
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
                        @foreach ($banners as $banner)
                        <tr>
                          <td>
                            {{ $banner['id'] }}
                          </td>
                          <td>
                            @if(!empty($banner['image']))
                                <a href="{{ asset('front/images/banner_images/'.$banner['image']) }}" target="_blank">
                                    <img style="width: 350px; height: 150px;" src="{{ asset('front/images/banner_images/'.$banner['image']) }}" alt="">
                                </a>
                            @else
                                <img style="width: 350px; height: 150px;" src="{{ asset('front/images/product_images/small/NoImage.png') }}" alt="">
                            @endif
                          </td>
                          <td>
                            {{ $banner['type'] }}
                          </td>
                          <td>
                            {{ $banner['link'] }}
                          </td>
                          <td>
                            {{ $banner['title'] }}
                          </td>
                          <td>
                            {{ $banner['alt'] }}
                          </td>
                          <td>
                            @if($banner['status'] == 1 )
                            <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}">
                             <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle" status="Active">
                             </i>
                            </a>
                            @else
                            <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}">
                               <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle-outline"  status="Inactive">
                             </i>
                            </a>
                            @endif
                          </td>
                          <td>
                               <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}">
                                <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                               </a>
                               <a href="javascript:void(0)" module="banner" moduleid="{{ $banner['id'] }}"  class="confirmDelete">
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
