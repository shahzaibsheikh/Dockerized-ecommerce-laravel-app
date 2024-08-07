@extends('layout_user')
@section('content')

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
                        <form method="POST" action="{{ route('profile-img-update')}}" enctype="multipart/form-data">
                          @csrf
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
                        <form method="POST" action="{{ route('profile-update')}}" enctype="multipart/form-data">
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
        <!-- Orders Section -->
        <div class="row">
            <div class="col-xl">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header"><h5>My Orders</h5></div>
                    <div class="card-body text-center">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product</th>
                                <th scope="col">Date</th>
                                <th scope="col">Price</th>
                                <th scope="col">Shipping Charge</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td scope="row">1</td>
                                <td>Titan Watch</td>
                                <td>17-02-2022</td>
                                <td>₹1000</td>
                                <td>₹00</td>
                                <td>5</td>
                                <td>₹5000</td>
                                <td>Delivered</td>
                            </tr>
                            <tr>
                                <td scope="row">2</td>
                                <td>Police Watch</td>
                                <td>17-02-2022</td>
                                <td>₹1000</td>
                                <td>₹00</td>
                                <td>5</td>
                                <td>₹5000</td>
                                <td>Attempted Delivery</td>
                            </tr>
                            <tr>
                                <td scope="row">3</td>
                                <td>Rolex Watch</td>
                                <td>17-02-2022</td>
                                <td>₹1000</td>
                                <td>₹00</td>
                                <td>5</td>
                                <td>₹5000</td>
                                <td>Confirmed</td>
                            </tr>
                            <tr>
                                <td scope="row">4</td>
                                <td>Tag Heuer Watch</td>
                                <td>17-02-2022</td>
                                <td>₹1000</td>
                                <td>₹00</td>
                                <td>5</td>
                                <td>₹5000</td>
                                <td>Out for delivery</td>
                            </tr>
                            <tr>
                                <td scope="row">5</td>
                                <td>Titan Watch</td>
                                <td>17-02-2022</td>
                                <td>₹1000</td>
                                <td>₹00</td>
                                <td>5</td>
                                <td>₹5000</td>
                                <td>On its way</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

