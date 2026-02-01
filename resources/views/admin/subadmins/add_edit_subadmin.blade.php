@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Admin {{$title}}</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row g-4">
                    <!--begin::Col-->
                    {{-- <div class="col-12">
                        <div class="callout callout-info">
                            For detailed documentation of Form visit
                            <a href="https://getbootstrap.com/docs/5.3/forms/overview/" target="_blank"
                                rel="noopener noreferrer" class="callout-link">
                                Bootstrap Form
                            </a>
                        </div>
                    </div> --}}
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <!--begin::Quick Example-->
                        <div class="card card-primary card-outline mb-4">
                            <!--begin::Header-->
                            <div class="card-header">
                                <div class="card-title">{{ $title }}</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Form-->
                            {{-- validation begins --}}
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                    <strong>Error: </strong> {{ Session::get('error_message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                    <strong>Success: </strong> {{ Session::get('success_message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                    <strong>Error: </strong> {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach

                            <form name="subadminForm" id="subadminForm" method="POST"
                                action="{{ url('admin/add-edit-subadmin/request') }}" enctype="multipart/form-data">
                                @csrf

                                @if (!empty($subadmindata['id']))
                                    <input type="hidden" name="id" value="{{ $subadmindata['id'] }}">
                                @endif
                                <!--begin::Body-->
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            aria-describedby="emailHelp" placeholder="Enter admin Email"
                                            @if (!empty($subadmindata['email'])) value="{{ $subadmindata['email'] }}"readonly @endif  style="background-color: #ccc"/>
                                    </div>
                                     <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter admin password"
                                           />
                                        {{-- @if (!empty($subadmindata['password'])) value="{{ $subadmindata['password'] }}" @endif  --}}
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter admin Name"
                                           @if (!empty($subadmindata['name'])) value="{{ $subadmindata['name'] }} @endif  "/>
                                        
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter admin Mobile Number"
                                            @if (!empty($subadmindata['mobile'])) value="{{ $subadmindata['mobile'] }}"@endif />
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image">
                                        @if (!empty($subadmindata['image']))
                                            <div id="profileImageBlock">
                                                <a target="_blank"
                                                    href="{{ url('admin/images/photos/' . $subadmindata['image']) }}">View</a>
                                                <input type="hidden" name="current_image" value="{{$subadmindata['image']}}">
                                            </div>
                                        @endif
                                    </div>

                                </div>
                                <!--end::Body-->
                                <!--begin::Footer-->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <!--end::Footer-->
                            </form>
                            <!--end::Form-->

                            <!--end::Form-->
                            <!--begin::JavaScript-->
                            <script>
                                // Example starter JavaScript for disabling form submissions if there are invalid fields
                                (() => {
                                    'use strict';

                                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                    const forms = document.querySelectorAll('.needs-validation');

                                    // Loop over them and prevent submission
                                    Array.from(forms).forEach((form) => {
                                        form.addEventListener(
                                            'submit',
                                            (event) => {
                                                if (!form.checkValidity()) {
                                                    event.preventDefault();
                                                    event.stopPropagation();
                                                }

                                                form.classList.add('was-validated');
                                            },
                                            false,
                                        );
                                    });
                                })();
                            </script>
                            <!--end::JavaScript-->
                        </div>
                        <!--end::Form Validation-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
