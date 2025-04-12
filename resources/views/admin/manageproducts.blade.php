{{-- resources/views/admin/manageproducts.blade.php --}}
@foreach ($products as $product)
    {{ $product->name }} - {{ $product->price }} - {{ $product->description }}
@endforeach