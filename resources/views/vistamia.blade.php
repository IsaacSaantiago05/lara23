<h1>Json AntonioG</h1>

@foreach($argc as $mia)
    <div style="border:1px solid #FFEEE; margin:7px; padding:7px;">
        <h3>{{$mia['position']}}</h3>

        <a href="{{ route('tj.detalle', $mia['position']) }}">
            <button style="cursor:pointer;">
                Ver detalle
            </button>
        </a>
    </div>
@endforeach