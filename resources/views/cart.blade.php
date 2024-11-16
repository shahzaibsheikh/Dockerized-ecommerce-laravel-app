@extends('layout_user')
@section('content')
<!-- Header-->
<div class="container" style="margin-top: 10%;margin-bottom: 5%">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        @include('flash_data')
        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Cart</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            <div class="cart-container">
                                <div class="cart-head">
                                    <div class="table-responsive">
                                        <table class="table table-borderless">

                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Photo</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Price</th>
                                                <th scope="col" class="text-right">Total</th>
                                            </tr>
                                            </thead>
                                            @php
                                             $sr=1;
                                            @endphp
                                            @if(!empty($cartData['carts']))
                                            @foreach ($cartData['carts'] as $key => $item)
                                            @if (is_array($item['product']))
                                            <tbody>
                                        <form method="post" action="{{ route('Cart.store') }}" >
                                            @csrf
                                            <tr>
                                                <th scope="row">{{$sr++}}</th>
                                                <td><img
                                                    src="{{ $item['product']['pr_image'] ?? '' }}"
                                                    class="img-fluid" width="35" alt="product"></td>
                                                <td>{{ $item['product']['pr_name'] ?? '' }}</td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="number" class="form-control cart-qty" min="0"
                                                               name="cartQty[{{ $item['id'] }}]" id="cartQty" value="{{ $item['pr_quantity'] ??  1}}">
                                                    </div>
                                                </td>
                                                <td>PKR{{ !empty($item['product']['pr_sale_price']) && $item['product']['pr_sale_price'] > 0  ? $item['product']['pr_sale_price'] :  $item['product']['pr_price'] }}</td>
                                                <td class="text-right">PKR{{ !empty($item['product']['pr_sale_price']) && $item['product']['pr_sale_price'] > 0  ? ($item['product']['pr_sale_price'] * $item['pr_quantity'] ) :  $item['product']['pr_price'] * $item['pr_quantity']}}</td>
                                            </tr>
                                            </tbody>
                                            @endif
                                         @endforeach
                                        @endif
                                        </table>
                                    </div>
                                </div>
                                <div class="cart-body">
                                    <div class="row">
                                        <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                            <div class="order-note">

<!--                                                    <div class="form-group">-->
<!--                                                        <div class="input-group">-->
<!--                                                            <input type="search" class="form-control"-->
<!--                                                                   placeholder="Coupon Code" aria-label="Search"-->
<!--                                                                   aria-describedby="button-addonTags">-->
<!--                                                            <div class="input-group-append">-->
<!--                                                                <button class="input-group-text" type="submit"-->
<!--                                                                        id="button-addonTags">Apply-->
<!--                                                                </button>-->
<!--                                                            </div>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
                                                    <div class="form-group">
                                                        <label for="specialNotes">Special Note for this order:</label>
                                                        <textarea class="form-control" name="specialNotes"
                                                                  id="specialNotes" rows="3"
                                                                  placeholder="Message here"> @if(!empty($cartData['comment']['body'])) {{  $cartData['comment']['body'] }}  @endif </textarea>
                                                    </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                            <div class="order-total table-responsive ">
                                                <table class="table table-borderless text-right">
                                                    <tbody>
                                                    <tr>
                                                        <td>Sub Total :</td>
                                                        <td>PKR {{ $subtotal }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping :</td>
                                                        <td>PKR {{ $shipping }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax({{$tax}}%) :</td>
                                                        <td>PKR {{ round($taxAmount) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="f-w-7 font-18"><h4>Amount :</h4></td>
                                                        <td class="f-w-7 font-18"><h4>PKR {{ round($total)}}</h4></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-footer text-right">
                                    <button type="submit" class="btn btn-outline-primary my-1"><i class="fa fa-pencil" aria-hidden="true"></i>
                                        &nbsp;Update Cart
                                    </button>
                            </form>
                                    <a href="{{ route('Store-Order') }}" class="btn btn-outline-success my-1"><i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        &nbsp;Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>


@include('store_locator')
@endsection


{{--  @section('store_locator')
@include('store_locator')
@endsection --}}
