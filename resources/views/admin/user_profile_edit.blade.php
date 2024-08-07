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

                <h1 class="mt-4">Edit User</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{route('admin-home')}}"> Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>      
        <!-- Account page navigation-->
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header"><h5>Profile Picture</h5></div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img width="120" height="100" class="img-account-profile rounded-circle mb-2"
                             src="{{asset('profiles/'.$data['user']['profile'])}}" alt="">
                                <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <form method="POST" action="{{ route('admin-user-update-picture',['id'=>$data['user']['id']] ) }}" enctype="multipart/form-data">
                          @csrf
                          @method('PUT')
                        <div class="row mb-3">

                              <div class="col mb-3">
                                    <input type="file" class="form-control" id="profile" name="profile"
                                           placeholder="profile"
                                           required="">
                                </div>
                    
                                <button class="btn btn-outline-primary" type="submit">Upload New Image</button>
                            
                             </div>
                        </form>
                        <!-- Profile picture upload button-->
                    
                    </div>
                </div>
            </div>
           
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                   
                    <div class="card-header"><h5>Account Details</h5></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin-user-update',['id'=>$data['user']['id']])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')    
                        <div class="row mb-3">
                                <div class="col">
                                    <label for="fname" class="form-label" >First Name</label>
                                    <input type="text" value="{{$data['user']['first_name']}}" class="form-control" id="fname" name="first_name"
                                           placeholder="Meet"
                                           required="">
                                </div>
                                <div class="col">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" value="{{$data['user']['last_name']}}" class="form-control" id="lname" name="last_name"
                                           placeholder="Shah"
                                           required="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" value="{{$data['user']['email']}}" class="form-control" id="email" name="email"
                                           placeholder="name@example.com" required="">
                                </div>
                                <div class="col">
                                    <label for="mobile" class="form-label">Contact Number</label>
                                    <input type="tel" value="{{$data['user']['mobile']}}" class="form-control" id="mobile" name="mobile"
                                           placeholder="1234567890" required="">
                                </div>
                            </div>
                            <div class="row mb-3">
                    
                                <div class="col">
                                    <label for="gender" class="form-label">Role</label><br>
                                    <input type="radio" id="gender" name="role_id" value="0"  @if ($data['user']['role_id'] == '0') {{'checked'}} @endif >&nbsp;&nbsp;User&nbsp;&nbsp;
                                    <input type="radio" id="gender" name="role_id" value="1" @if ($data['user']['role_id'] == '1') {{'checked'}} @endif >&nbsp;&nbsp;Admin
                                </div>

                                <div class="col">
                                    <label for="gender" class="form-label">Gender</label><br>
                                    <input type="radio" id="gender" name="gender" value="Male"  {{$data['user']['gender'] == 'Male' ?'checked':''}} >&nbsp;&nbsp;Male&nbsp;&nbsp;
                                    <input type="radio" id="gender" name="gender" value="Female" {{$data['user']['gender'] == 'Female' ?'checked':''}} >&nbsp;&nbsp;Female
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" rows="3" name="address"
                                              placeholder="address" required="">{{$data['user']['address']}}</textarea>
                                </div>
                                <div class="col">
                                    <label for="inputCountry" class="form-label">Country</label>
                                    <select class="form-select" id="inputCountry"
                                            aria-label="Default select example"
                                            required="" name="country">
                                        <option disabled selected>Select</option>
                                        @foreach($data['countries'] as $countries )
                                        <option value="{{$countries['id']}}" {{$countries['id']==$data['user']['country'] ?'selected':''}}>{{$countries['name']}}</option>
                                         @endforeach
                                    </select>
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