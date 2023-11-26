<?php
    use App\Models\Category;
?>
@extends('admin.layout.layout')


@section('content')
     <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Filters</h4>


                  <a style="max-width: 163px; float: left; display: inline-block" href="{{ url('admin/filters-values') }}" class="btn btn-block btn-primary">View Filter Values</a>
                  <a style="max-width: 150px; float: right; display: inline-block" href="{{ url('admin/add-edit-filter') }}" class="btn btn-block btn-primary">Add Filter</a>
                  @if(Session::has('success_message'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                     {{ Session::get('success_message') }}
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  @endif
                  <div class="table-responsive pt-3">
                    <table id="filters" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                                ID
                          </th>
                          <th>
                                Filter Name
                          </th>
                          <th>
                                Filter Column
                          </th>
                          <th>
                                Categories
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
                        @foreach ($filters as $filter)
                        <tr>
                          <td>
                            {{ $filter['id'] }}
                          </td>
                          <td>
                            {{ $filter['filter_name'] }}
                          </td>
                          <td>
                            {{ $filter['filter_column'] }}
                          </td>
                          <td>
                            <?php
                                $catIds = explode(",",$filter['cat_ids']);

                                foreach($catIds as $key => $catId){
                                    $category_name = Category::getCategoryName($catId);
                                    echo $category_name. " ";
                                }
                            ?>
                          </td>
                          <td>
                            @if($filter['status'] == 1 )
                            <a href="javascript:void(0)" class="updateFilterStatus" id="filter-{{ $filter['id'] }}" filter_id="{{ $filter['id'] }}">
                             <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle" status="Active">
                             </i>
                            </a>
                            @else
                            <a href="javascript:void(0)" class="updateFilterStatus" id="filter-{{ $filter['id'] }}" filter_id="{{ $filter['id'] }}">
                               <i style="font-size: 25px;" class="mdi mdi-checkbox-blank-circle-outline"  status="Inactive">
                             </i>
                            </a>
                            @endif
                          </td>
                          <td>
                               <a href="{{ url('admin/add-edit-filter/'.$filter['id']) }}">
                                <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                               </a>
                               <a href="javascript:void(0)" module="filter" moduleid="{{ $filter['id'] }}"  class="confirmDelete">
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
