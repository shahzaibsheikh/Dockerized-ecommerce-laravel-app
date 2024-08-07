@extends('admin.layout')
@section('content')
<main>
<div class="container h-100" style="margin: 7% 0% 7% 15%;">
    <div class="container-xl px-4 mt-4">
        @include('flash_data')
    @if($errors->any())
                   <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                   </div>
                @endif

                <h1 class="mt-4">Add Brands</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{route('admin-home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('Brand.index')}}">Brand List</a></li>
                    <li class="breadcrumb-item active">Brands</li>  
                </ol>      
        <!-- Account page navigation-->
        <div class="row">
           
            <div class="col-xl-8">
                <!-- Brands details card-->
                <div class="card mb-4">
                   
                    <div class="card-header"><h5>Brands Details</h5></div>
                    <div class="card-body">
                        <form method="post" action="{{ route('Brand.store')}}" enctype="multipart/form-data">
                        @csrf
                 
                        <div class="row mb-3">
                                <div class="col">
                                    <label for="fname" class="form-label" >Name</label>
                                    <input type="text" value="" class="form-control" id="product_name" name="product_name"
                                           placeholder="Meet"
                                           required="">
                                </div>
                                <div class="col">
                                    <label for="lname" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description"></textarea>
                                </div>
                            </div>
                           
                            <div class="row mb-3">

                            <div class="col">
                                    <label for="Image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image">
                                    
                                </div>
                    
                                <div class="col">
                                    <label for="gender" class="form-label">Status</label><br>
                                    <input type="radio" id="gender" name="status" value="0"  >&nbsp;&nbsp;Not  Active&nbsp;&nbsp;
                                    <input type="radio" id="gender" name="status" value="1" >&nbsp;&nbsp;Active
                                </div>
                            </div>
                            <br>
                            <div class="mb-3">
                                <input type="submit" name="update" id="update" value="Update Profile"
                                       class="btn btn-outline-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</main>

@endsection