@extends('admin.layout.layout')
@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="cols-sm-6">
                        <h3 class="mb-0">Admin Management</h3>
                    </div>
                    <div class="cols-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sub admins</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Sud Admins</h3>
                            <a style="max-width:150px; float:right; display:inline-block;" href="{{url('admin/add-edit-subadmin')}}" class="btn btn-block btn-primary">Add Sub Admins</a>
                        </div>

                        <div class="card-body">
                             @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                    <strong>Success: </strong> {{ Session::get('success_message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <table id="subadmins" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subadmins as $subadmin)
                                        <tr>
                                            <td>{{ $subadmin->id }}</td>
                                            <td>{{ $subadmin->name }}</td>
                                            <td>{{ $subadmin->mobile }}</td>
                                            <td>{{ $subadmin->email }}</td>
                                            <td>
                                                @if ($subadmin->status == 1)
                                                    <a class="updateSubadminStatus" data-subadmin-id="{{ $subadmin->id }}"
                                                        href="javascript:void(0)" style="color:#3f6ed3">
                                                      <i class="fa-solid fa-toggle-on" data-status="Active"></i></a>
                                                        
                                                @else 
                                                  <a class="updateSubadminStatus" data-subadmin-id="{{ $subadmin->id }}"
                                                        href="javascript:void(0)" style="color:gray">
                                                      <i class="fa-solid fa-toggle-off" data-status="Inactive"></i></a>
                                                        
                                                @endif
                                                &nbsp;&nbsp;<a style="color:red" href="{{url('admin/delete-subadmin/'.$subadmin->id)}}" title="Delete Subadmin"><i class="fa-solid fa-trash"></i></a>&nbsp;&nbsp; <a href="{{url('admin/add-edit-subadmin/'.$subadmin->id)}}"><i class="fa-solid fa-user-pen"></i></a>
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
    </main>
   
@endsection
