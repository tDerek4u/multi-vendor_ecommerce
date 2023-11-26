@extends('admin.layout.layout')

@section('content')
     <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="font-weight-bold">Catalouge Management</h3>
                  <h4 class="card-title">Categories</h4>


                  <a style="max-width: 150px; float: right; display: inline-block" href="{{ url('admin/add-edit-category') }}" class="btn btn-block btn-primary">Add Category</a>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <div class="table-responsive pt-3">
                    <table id="categories" class="table table-bordered categories">
                      <thead>
                        <tr>
                          <th>
                                ID
                          </th>
                          <th>
                                Category
                          </th>
                          <th>
                                Parent Category
                          </th>
                          <th>
                                Section
                          </th>
                          <th>
                                URL
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
                        @foreach ($categories as $category)
                        @if(isset($category['parent_category']['category_name']) && !empty($category['parent_category']['category_name']) )
                           @php $parent_category = $category['parent_category']['category_name'] @endphp

                        @else
                            @php
                                $parent_category = "Root";
                            @endphp
                        @endif
                        <tr>
                          <td>
                            {{ $category['id'] }}
                          </td>

                          <td>
                            {{ $category['category_name'] }}
                          </td>
                          <td>
                            {{ $parent_category }}
                          </td>
                          <td>
                            {{ $category['section']['name'] }}
                          </td>
                          <td>
                            {{ $category['url'] }}
                          </td>
                          <td>
                            @if($category['status'] == 1 )
                            <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id="{{ $category['id'] }}">
                             <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle" status="Active">
                             </i>
                            </a>
                            @else
                            <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $category['id'] }}" category_id="{{ $category['id'] }}">
                               <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle-outline"  status="Inactive">
                             </i>
                            </a>
                            @endif
                          </td>
                          <td>
                               <a href="{{ url('admin/add-edit-category/'.$category['id']) }}">
                                <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                               </a>
                               <a href="javascript:void(0)" module="category" moduleid="{{ $category['id'] }}"  class="confirmDelete">
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
