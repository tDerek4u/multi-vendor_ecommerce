<?php
    use App\Models\ProductsFilter;
?>
@extends('admin.layout.layout')

@section('content')
     <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Filters Values</h4>

                  <a style="max-width: 163px; float: right; display: inline-block" href="{{ url('admin/add-edit-filter-value') }}" class="btn btn-block btn-primary">Add Filter Values</a>
                  <a style="max-width: 163px; float: left; display: inline-block" href="{{ url('admin/filters') }}" class="btn btn-block btn-primary">View Filters</a>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <div class="table-responsive pt-3">
                    <table id="filters_values" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                                ID
                          </th>
                          <th>
                                Filter ID
                          </th>
                          <th>
                                Filter Name
                          </th>
                          <th>
                                Filter Value
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
                        @foreach ($filtersvalues as $filtervalue)
                        <tr>
                          <td>
                            {{ $filtervalue['id'] }}
                          </td>
                          <td>
                            {{ $filtervalue['filter_id'] }}
                          </td>
                          <td>
                            <?php
                                echo $getFilterName = ProductsFilter::getFilterName($filtervalue['filter_id']);
                            ?>
                          </td>
                          <td>
                            {{ $filtervalue['filter_value'] }}
                          </td>
                          <td>
                            @if($filtervalue['status'] == 1 )
                            <a href="javascript:void(0)" class="updateFilterValueStatus" id="filtervalue-{{ $filtervalue['id'] }}" filtervalue_id="{{ $filtervalue['id'] }}">
                             <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle" status="Active">
                             </i>
                            </a>
                            @else
                            <a href="javascript:void(0)" class="updateFilterValueStatus" id="filtervalue-{{ $filtervalue['id'] }}" filtervalue_id="{{ $filtervalue['id'] }}">
                               <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle-outline"  status="Inactive">
                             </i>
                            </a>
                            @endif
                          </td>
                          <td>
                               <a href="{{ url('admin/add-edit-filter-value/'.$filtervalue['id']) }}">
                                <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                               </a>
                               <a href="javascript:void(0)" module="filtervalue" moduleid="{{ $filtervalue['id'] }}"  class="confirmDelete">
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
