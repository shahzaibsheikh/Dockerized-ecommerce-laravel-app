@extends('admin.layout')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Orders</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    All Orders
                </div>
                <div class="card-body">
                    @include('flash_data')
                    <table id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>User Name</th>
                            <th>Sub Total</th>
                            <th>Tax Rate</th>
                            <th>Tax Amount</th>
                            <th>Shipping</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)

                            <tr>
                                <td>LV-{{ $order->id }}</td>
                                <td>{{ $order->user->full_name }}</td>
                                <td>@Money($order->order_sub_total)</td>
                                <td>{{ $order->order_tax_rate .'%'}}</td>
                                <td>@Money($order->order_tax_amount)</td>
                                <td>@Money($order->order_shipping)</td>
                                <td>@Money($order->order_amount)</td>
                                <td>{{$order->order_status }}</td>
                                <td>{{!empty($order->comment)?$order->comment :''}}</td>
                                <td>
                                <form method="POST" action="{{ route('update-order-status',['order'=> $order->id])}}">
                                    @csrf
                                    <select class="form-select" id="order_status"
                                                        aria-label="Default select example"
                                                        required="" name="order_status">
                                                    <option selected disabled>Select</option>
                                                    @foreach(\Illuminate\Support\Facades\Config::get('order_status') as $orderStatus)
                                                        <option value="{{ $orderStatus }}" @if($order->order_status == $orderStatus ){{ 'selected' }} @endif>{{ $orderStatus }}</option>
                                                    @endforeach
                                                </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                                </form>
                                <a href="{{route('order-line-items',['order'=> $order->id])}}" class="btn btn-sm btn-success">View LineItems</a>
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
