@extends('admin.layout')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Products</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    All Products
                    <a href="{{ route('Product.create') }}" class="btn btn-outline-primary btn-sm float-end"> + Add Product</a>
                </div>
                <div class="card-body">
                    @include('flash_data')
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Color</th>
                            <th>Brand</th>
                            <th>Gender</th>
                            <th>Function</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->pr_code }}</td>
                                <td>{{ $product->pr_name }}</td>
                                <td><img width="100" height="100" src="{{ asset('products').'/'.$product->pr_image}}" alt="{{ $product->pr_name }}  "></td>
                                <td>{{ $product->pr_price }}</td>
                                <td>{{ $product->pr_sale_price }}</td>
                                <td>{{ $product->pr_color }}</td>
                               <td>{{ $product->productBrandData->name }}</td>
                                <td>{{ $product->pr_gender }}</td>
                                <td>{{ $product->pr_function }}</td>
                                <td>{{ $product->pr_stock }}</td>
                                <td style="max-width: 30px">
                                <a href="{{route('Product.edit',['Product'=> $product->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{route('admin-product-update-status',['Product'=>$product->id,'status'=>($product->is_active == '1') ? '0' :'1'])}}" class="btn btn-sm {{$product->is_active == '1' ? 'btn-danger' :'btn-success' }}"> {{$product->is_active == '1'? 'Deactivate' :'Active' }}</a>
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
