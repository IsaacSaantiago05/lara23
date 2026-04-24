<h1>Lista de datos de la API</h1>

@foreach($trjson as $ap)
    <div style="border:1px solid #FFEEE; margin:7px; padding:7px;">
        <h3>{{$ap['title']}}</h3>
    </div>
@endforeach