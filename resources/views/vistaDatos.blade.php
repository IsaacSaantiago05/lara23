<h1>Holiss ITIs23

@foreach ($pro as $product)
    <p>{{ $product->name }} - {{ $product->price }}</p>
    
@endforeach