@extends('admin.layout.layout')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">Banner Management</h3>
              <h6 class="font-weight-normal mb-0">Home Page Banners</h6>

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
              <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}" @else  action="{{ url('admin/add-edit-banner/' . $banner['id']) }}"  @endif method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="image">Banner Image</label>
                    <input type="file" class="form-control mb-2" id="image" placeholder="Banner Image" name="image" >
                    @if(!empty($banner['image']))
                        <a class="text-decoration-none" href="{{ url('front/images/banner_images/'.$banner['image']) }}">View Image</a> &nbsp; | &nbsp;
                        <a href="javascript:void(0)" module="banner-image" moduleid="{{ $banner['id'] }}"  class="confirmDelete text-decoration-none">Delete
                        </a>
                    @endif
                </div>

                <div class="form-group">
                    <label for="banner_type">Banner Type</label>
                    <select name="banner_type" id="banner_type" class="form-control" required>
                        <option value="">Select</option>
                        <option @if(!empty($banner['type']) || $banner['type'] == "Slider") selected @endif value="Slider">Slider</option>
                        <option @if(!empty($banner['type']) || $banner['type'] == "Fix") selected @endif value="Fix">Fix</option>
                    </select>
                  </div>

                <div class="form-group">
                    <label for="banner_title">Banner Title</label>
                    <input type="text" class="form-control mb-2" id="banner_title"  @if(!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif placeholder="Banner Title" name="banner_title" >
                  </div>

                <div class="form-group">
                    <label for="banner_link">Banner Link</label>
                    <input type="text" class="form-control mb-2" id="banner_link"  @if(!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif placeholder="Banner Link" name="banner_link" >
                  </div>

                <div class="form-group">
                    <label for="banner_alter">Banner Alternate Text</label>
                    <input type="text" class="form-control mb-2" id="banner_alter"  @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif placeholder="Banner Alternate Text" name="banner_alter" >
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
