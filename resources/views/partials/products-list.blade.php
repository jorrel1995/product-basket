<div class="container pt-5">
    <div class="row align-items-center">

        @forelse($products as $product)
            <div class="col-3">
                <h4 class="mb-3">
                    {{ $product->name }}
                    <span id="price-{{ $product->id }}"
                        class="fw-bold rounded text-success float-end">&pound;{{ $product->price }}</span>
                </h4>
                <div class="mb-2">
                    @if($product->stock > 0)
                        <span class="badge bg-success">Available stock: {{ $product->stock }}</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>

                <div class="input-group">
                    <input type="text" class="form-control" id="quantity-{{ $product->id }}" placeholder="Quantity"
                        @if($product->stock == 0) disabled @endif>
                    <div class="input-group-append">
                        <button class="btn btn-primary" data-product-id="{{ $product->id }}" type="button"
                            @if($product->stock == 0) disabled @endif>Add</button>
                    </div>
                </div>
            </div>
        @empty
            <p>No products found</p>
        @endforelse

    </div>
</div>