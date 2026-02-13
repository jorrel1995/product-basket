<div class="row align-items-center">
    @foreach ($basket as $item)

        <div class="col-7">
            {{ $item['name'] }}
        </div>

        <div class="col-5 text-end">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">Quantity</span>
                        </div>
                        <input type="number" class="form-control rounded-0" aria-label="Small"
                            aria-describedby="inputGroup-sizing-sm" value="{{ $item['quantity'] }}"
                            oninput="clearTimeout(this.delay); this.delay = setTimeout(() => updateQuantity({{ $item['id'] }}, this.value), 1500)">
                    </div>
                </div>
                <div class="col-3">
                    &pound;{{ $item['total'] ?? 0 }}
                </div>
                <div class="col-3">
                    <button class="btn btn-danger w-100" onclick="deleteProduct({{ $item['id'] }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>

        </div>
    @endforeach
</div>