@extends('admin.layout')
@section('content')
<main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
                <div class="card mb-4">
                    @include('flash_data')
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        All Users
                        <a href="add_new_user.html" class="btn btn-outline-primary btn-sm float-end"> + Add User</a>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Contact</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach($users as $user)
                            <tr>
                                <td>{{$user->full_name}}</td>
                                <td>{{$user->role_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->gender}}</td>
                                <td>{{$user->mobile}}</td>
                                <td>{{$user->CountryData->name}}</td>
                                <td style="max-width: 30px">
                                    <a href="{{route('admin-user-edit',['id'=>$user->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{route('admin-user-update-status',['id'=>$user->id,'status'=>($user->is_active == '1') ? '0' :'1'])}}" class="btn btn-sm {{$user->is_active == '1' ? 'btn-danger' :'btn-success' }}"> {{$user->is_active == '1'? 'Deactivate' :'Active' }}</a>
                                </td>
                            </tr>
                            @endforeach             
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

@endsection