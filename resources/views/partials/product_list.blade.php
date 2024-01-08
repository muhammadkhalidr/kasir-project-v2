<div>
    <ul class="list-group" id="product-list">
        @forelse($products as $product)
            <li class="list-group-item" style="cursor:pointer;" data-id="{{ $product->id }}">{{ $product->judul }}</li>
        @empty
            <li class="list-group-item">Produk tidak ditemukan</li>
        @endforelse
    </ul>

    <ul class="list-group" id="id-product-list" style="display: none;">
        @forelse($id_products as $id_product)
            <li class="list-group-item" style="cursor:pointer;" data-id="{{ $id_product->id }}"></li>
        @empty
            <li class="list-group-item">ID Produk tidak ditemukan</li>
        @endforelse
    </ul>
</div>
