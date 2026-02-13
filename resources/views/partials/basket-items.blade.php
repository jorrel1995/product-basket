<div class="container pt-5">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4 class="m-0">Basket Items</h4>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-secondary" onclick="clearBasket()">Clear Basket</button>
                </div>
            </div>

        </div>
        <div class="card-body">

            @if (isset($basket) && count($basket) > 0)
                @include('partials.basket-item')
            @else
                <p>Basket is empty</p>
            @endif
        </div>
    </div>
</div>