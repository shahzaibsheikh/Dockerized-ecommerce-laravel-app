@extends('admin.layout')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Products</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="">Products List</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Add Product
                </div>
                <div class="card-body">
                    @include('flash_data')
                    <div class="album py-5" style="height:120vh;margin-top: -15%;margin-bottom: -15%;">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="card border-success" style="max-width: 75rem;padding: 2%;">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li> {{ $error }} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <hr>
                                @endif
                                <div class="card-body">
                                    <form method="POST" action="{{ route('product.store') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" id="name" name="pr_name"
                                                       placeholder="Titan Watch"
                                                       required="">
                                            </div>
                                            <div class="col">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="text" class="form-control" id="price" name="pr_price"
                                                       placeholder="15000"
                                                       required="">
                                            </div>
                                            <div class="col">
                                                <label for="sale_price" class="form-label">Sale Price</label>
                                                <input type="text" class="form-control" id="sale_price"
                                                       name="pr_sale_price"
                                                       placeholder="10000">
                                            </div>
                                            <div class="col">
                                                <label for="color" class="form-label">Color</label>
                                                <input type="text" class="form-control" id="pr_color" name="pr_color"
                                                       placeholder="Rose Gold"
                                                       required="">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="brand_id" class="form-label">Brand</label>
                                                <select class="form-select" id="brand_id"
                                                        aria-label="Default select example"
                                                        required="" name="brand_id">
                                                    <option selected disabled>Select</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="product_code" class="form-label">Product Code</label>
                                                <input type="text" class="form-control" id="pr_code"
                                                       name="pr_code"
                                                       placeholder="LV-123"
                                                       required="">
                                            </div>
                                            <div class="col">
                                                <label for="gender" class="form-label">Gender</label><br>
                                                <input type="radio" id="gender" name="pr_gender" value="male" checked>&nbsp;&nbsp;Male&nbsp;&nbsp;
                                                <input type="radio" id="gender" name="pr_gender" value="female">&nbsp;&nbsp;Female
                                                <input type="radio" id="gender" name="pr_gender" value="children">&nbsp;&nbsp;Children
                                                <input type="radio" id="gender" name="pr_gender" value="unisex">&nbsp;&nbsp;Unisex
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <div class="col-3">
                                                <label for="function" class="form-label">Function</label>
                                                <select class="form-select" id="function"
                                                        aria-label="Default select example"
                                                        required="" name="pr_function">
                                                    <option selected disabled>Select</option>
                                                    @foreach(\Illuminate\Support\Facades\Config::get('watch_function') as $value)
                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-3">
                                                <label for="stock" class="form-label">Stock</label>
                                                <input type="number" class="form-control" id="stock" name="pr_stock"
                                                       placeholder="100"
                                                       required="">
                                            </div>
                                            <div class="col">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" rows="3"
                                                          name="pr_description"
                                                          placeholder="description" required=""></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="image" class="form-label">Image</label><br>
                                                <input type="file" class="form-control-file" name="pr_image"
                                                       id="image">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="mb-3">
                                            <input type="submit" id="add_product"
                                                   value="Add Product"
                                                   class="btn btn-outline-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
