@extends('admin.layout')
@section('content')
<main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Brands</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{route('admin-home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Brands</li>
                </ol>
                <div class="card mb-4">
                    @include('flash_data')
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        All Brands
                        <a href="{{ route('Brand.create') }}" class="btn btn-outline-primary btn-sm float-end"> + Add Brand</a>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                              @foreach($Brands as $brand)
                             <tr>
                                <td>{{$brand->name}}</td>
                                <td><img width="100" height="100" src="{{ asset('brands').'/'.$brand->image}}" alt=""></td>
                                <td>{{$brand->description}}</td>
                                <td style="max-width: 30px">
                                    <a href="{{route('Brand.edit',['Brand'=>$brand->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="{{route('admin-brand-update-status',['Brand'=>$brand->id,'status'=>($brand->is_active == '1') ? '0' :'1'])}}" class="btn btn-sm {{$brand->is_active == '1' ? 'btn-danger' :'btn-success' }}"> {{$brand->is_active == '1'? 'Deactivate' :'Active' }}</a>
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