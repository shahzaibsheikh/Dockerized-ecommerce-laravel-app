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

                <h1 class="mt-4">Edit brand</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{route('Brand.index')}}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">brands</li>
                </ol>      
        <!-- Brand page navigation-->
        <div class="row">
            <div class="col-xl-4">
                <!-- image picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header"><h5>image Picture</h5></div>
                    <div class="card-body text-center">
                        <!-- image picture image-->
                        <img width="120" height="100" class="img-Brand-image rounded-circle mb-2"
                             src="{{asset('brands/'.$brand['brand']['image'])}}" alt="">
                                <!-- image picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <form method="POST" action="{{ route('admin-brand-update-picture',['Brand'=>$brand['brand']['id']] ) }}"  enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                        <div class="row mb-3">

                              <div class="col mb-3">
                                    <input type="file" class="form-control" id="image" name="image"
                                           placeholder="image"
                                           required="">
                                </div>
                    
                                <button class="btn btn-outline-primary" type="submit">Upload New Image</button>
                            
                             </div>
                        </form>
                        <!-- image picture upload button-->
                    
                    </div>
                </div>
            </div>
           
            <div class="col-xl-8">
                <!-- Brand details card-->
                <div class="card mb-4">
                   
                    <div class="card-header"><h5>Brand Details</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('Brand.update',['Brand'=>$brand['brand']['id']])}}"  enctype="multipart/form-data">
                        @csrf
                        @method('PUT')    
                        <div class="row mb-3">
                                <div class="col">
                                    <label for="fname" class="form-label" > Name</label>
                                    <input type="text" value="{{$brand['brand']['name']}}" class="form-control" id="name" name="name"
                                           placeholder="Meet"
                                           required="">
                                </div>
                                <div class="col">
                                    <label for="lname" class="form-label">Description</label>
                                           <textarea name="description" class="form-control" id="">{{$brand['brand']['description']}}</textarea>
                                </div>
                            </div>
                         
                            <br>
                            <div class="mb-3">
                                <input type="submit" name="update" id="update" value="Update Brand"
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