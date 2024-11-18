@extends('layout_user')
@section('content')

<!-- Product section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="{{$Product['pr_image']}}" alt="{{$Product['pr_name']}}" /></div>
            <div class="col-md-6">
                <div class="small mb-1">SKU: {{$Product['pr_code']}}</div>
                <h1 class="display-5 fw-bolder">{{$Product['pr_name']}}</h1>
                <div class="fs-5 mb-5">
                   @if (!empty($Product['pr_sale_price']) && $Product['pr_sale_price']>0)
                   <span class="text-decoration-line-through">{{ 'PKR. '.$Product['pr_price'] }}</span>
                   <span> {{ 'PKR. '.$Product['pr_sale_price'] }} </span>
                   @else
                   <span> {{ 'PKR. '.$Product['pr_price'] }} </span>
                   @endif

                </div>
                <p class="lead">{{ $Product['pr_description'] }}</p>
                <div class="d-flex">
                    <form id="product-form">
                        <input type="hidden" name="product_id" value="{{ $Product['id'] }}" >
                        <input class="form-control text-center me-3" name="pr_quantity" id="inputQuantity" step="any" type="number" min="1" value="1" style="max-width: 3rem" />
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Related items section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @foreach ( $RelatedProduct as $product)

            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Sale badge-->
                    @if (!empty($product['pr_sale_price']) && $product['pr_stock']>0)
                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale
                    </div>
                    @elseif (empty($product['pr_stock']) || $product['pr_stock']==0)
                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Out of Stock</div>
                  @endif
                    <!-- Product image-->
                    <img class="card-img-top" src="{{ $product['pr_image'] }}" alt="{{ $product['pr_name'] }}"/>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $product['pr_name'] }}</h5>
                            <!-- Product price-->
                            @if(!empty($product['pr_price']))
                            <span class="text-muted text-decoration-line-through">{{ 'PKR. '.$product['pr_price'] }}</span>
                            @endif
                            @if (!empty($product['pr_price']) && !empty($product['pr_sale_price']))
                             {{ 'PKR. '.$product['pr_sale_price'] }}
                             @endif
                        </div>
                              <h6 class="text-dark text-center mt-2">Gender: {{ $product['pr_gender']  }}</h6>
                              <h6 class="text-dark text-center mt-2">Function: {{ $product['pr_function']  }}</h6>
                    </div>

                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('product_info',['product'=>$product['pr_code'] ]) }}">View Product</a></div>
                    </div>
                </div>
              </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('footer_scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('product-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Get the form data
        const formData = new FormData(form);
        const fdata = {};
        formData.forEach((value, key) => {
        fdata[key] = value;
        });
        try {
            // Make the async AJAX request
            const response = await fetch("{{ route('Add_to_cart') }}", {
                method: 'POST',
                headers: {
                    // Don't set Content-Type when sending FormData
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(fdata),
            });

            const data = await response.json();

            if (!response.ok) {
                // Handle validation errors
                if (response.status === 422) {
                    let errorMessage = 'Validation failed:\n';
                    for (const [field, errors] of Object.entries(data.errors)) {
                        errorMessage += `${field}: ${errors.join(', ')}\n`;
                    }
                    throw new Error(errorMessage);
                }else if(response.status === 423){
                    throw new Error(data.errors ? JSON.stringify(data.errors) : 'Unexpected error');
                }
                throw new Error(data.message || 'Something went wrong');

            }

            // Success case
            toastr.success(data.message, 'Success');
            form.reset();

        } catch (error) {
            // Error handling
            toastr.error(error.message || 'An unexpected error occurred', 'Error');
            console.error('Error:', error);
        }
    });
});

</script>
@endsection


