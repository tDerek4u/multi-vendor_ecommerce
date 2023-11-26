@extends('admin.layout.layout')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Catalouge Management</h3>
              <h6 class="font-weight-normal mb-0">Categories</h6>

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
              <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else  action="{{ url('admin/add-edit-category/' . $category['id']) }}"  @endif method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="category_name">Category Name</label>
                  <input type="text" class="form-control mb-2" id="category_name"  @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}" @else value="{{ old('category_name') }}" @endif placeholder="Category Name" name="category_name" >
                </div>
                <div class="form-group">
                    <label for="section_name">Select Section</label>
                    <select name="section_id" class="form-control" id="section_id" style="color: #000;">
                        <option value="">Select</option>
                        @foreach ($getSections as $section)
                            <option value="{{ $section['id'] }}" @if (!empty($category['section_id']) && $category['section_id'] == $section['id'])  selected @endif>{{ $section['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="" id="appendCategoriesLevel">
                    @include('admin.categories.append_categories_level')
                </div>
                <div class="form-group">
                    <label for="category_image">Category Image</label>
                    <input type="file" class="form-control mb-2" id="category_image" placeholder="Category Image" name="category_image" >
                    @if(!empty($category['category_image']))
                        <a class="text-decoration-none" href="{{ url('front/images/category_images/'.$category['category_image']) }}">View Image</a> &nbsp; | &nbsp;
                        <a href="javascript:void(0)" module="category-image" moduleid="{{ $category['id'] }}"  class="confirmDelete text-decoration-none">Delete
                        </a>
                    @endif
                </div>
                <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input type="text" class="form-control mb-2" id="category_discount"  @if(!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif placeholder="Category Discount" name="category_discount" >
                </div>
                <div class="form-group">
                    <label for="category_name">Category Description</label>
                    <textarea name="description" id="description" class="form-control" @if(!empty($category['description'])) @else value="{{ old('description') }}" @endif rows="3" placeholder="Category Description">{{ $category['description'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="url">Category URL</label>
                    <input type="text" class="form-control mb-2" id="url"  @if(!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif placeholder="Category URL" name="url" >
                </div>
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control mb-2" id="meta_title"  @if(!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif placeholder="Meta Title" name="meta_title" >
                </div>
                <div class="form-group">
                    <label for="meta_description"> Meta Description</label>
                    <input type="text" class="form-control mb-2" id="meta_description"  @if(!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif placeholder=" Meta Description" name="meta_description" >
                </div>
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control mb-2" id="meta_keywords"  @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif placeholder=" Meta Keywords" name="meta_keywords" >
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
