@extends('admin.layout.layout')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Catalouge Management</h3>
              <h6 class="font-weight-normal mb-0">Filters</h6>

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
              <h4 class="card-title">{{ $title }}</h4>
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
              <form class="forms-sample" @if(empty($filter['id'])) action="{{ url('admin/add-edit-filter') }}" @else  action="{{ url('admin/add-edit-filter/' . $filter['id']) }}"  @endif method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category_name">Select Category</label>
                    <select name="category_id[]" style="height: 200px" class="form-control text-dark" id="category_id" multiple>
                        <option value="">Select</option>
                        @foreach ($categories as $section)
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach ($section['categories'] as $category)
                                <option @if (!empty($filter['category_id'] == $category['id'])) selected @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;--&nbsp;{{ $category['category_name'] }}</option>
                                @foreach ($category['subcategories'] as $subcategory)
                                    <option @if (!empty($filter['category_id'] == $subcategory['id'])) selected @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{ $subcategory['category_name'] }}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                  <label for="filter_name">Filter Name</label>
                  <input type="text" class="form-control mb-2" id="filter_name"  @if(!empty($filter['filter_name'])) value="{{ $filter['filter_name'] }}" @else value="{{ old('filter_name') }}" @endif placeholder="Filter Name" name="filter_name" >
                </div>
                <div class="form-group">
                    <label for="filter_column">Filter Column</label>
                    <input type="text" class="form-control mb-2" id="filter_column"  @if(!empty($filter['filter_column'])) value="{{ $filter['filter_column'] }}" @else value="{{ old('filter_column') }}" @endif placeholder="Filter Column" name="filter_column" >
                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
              </form>
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
