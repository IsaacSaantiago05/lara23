<h1>Lista de datos de la API</h1>

@foreach($traductorjson as $tj)
    <div style="border:1px solid #FFEEE; margin:7px; padding:7px;">
        <h3>{{$tj['id']}}</h3>
    </div>
@endforeach