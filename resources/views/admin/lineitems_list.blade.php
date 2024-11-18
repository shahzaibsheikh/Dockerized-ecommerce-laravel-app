@extends('admin.layout')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Line Items</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Line Items</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    @include('flash_data')
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Customer Name</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($lineitems as $item)

                            <tr>
                                <td>LV-{{$item->order_id }}</td>
                                <td>{{ $item->user->full_name }}</td>
                                <td>{{ $item->productData->pr_name}}</td>
                                <td>{{ $item->quantity}}</td>
                                <td>@Money($item->product_price)</td>
                                <td>@Money($item->total_price)</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
