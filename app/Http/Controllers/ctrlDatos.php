<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;

class ctrlDatos extends Controller
{
    public function AccesoDatosVista(){
        try {
            $pro = Product::all();
        } catch (QueryException $e) {
            session()->now('error', 'La tabla products aun no existe en Railway. Ejecuta las migraciones y vuelve a desplegar.');
            $pro = collect();
        }

        Return view('vistaDatos')->with(compact('pro')); // 2. enviarlos a la vista
    }

    public function AccesoDatosLink(){ 
        
    $enlace = Http::get('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/refs/heads/master/json/regions.json');
        $traductorjson = $enlace->json(); // 1. obtener el json de la url
        
       Return View('vistaDatosLink')->with(compact('traductorjson')); // 2. enviar el json a la vista
       
    }

    public function AccesoApi(){

    $enlacee = Http::get('https://holisss.mundoiti.com');

    $trjson = $enlacee->json(); // 1. obtener el json de la url

    Return View('vistaApi')->with(compact('trjson')); // 2. enviar el json a la vista


    }

    public function AccesoApiMia(){

    $apiMia = Http::get('https://sitioagrdzzz.netlify.app');

    $argc = $apiMia->json(); 

    Return View('vistamia')->with(compact('argc')); 


    }

    public function detalle($position){
    $enlace = Http::get('https://raw.githubusercontent.com/sharmadhiraj/free-json-datasets/refs/heads/master/datasets/world-population-by-country-2020.json');

    $traductorjson = $enlace->json(); 

    $deta = collect($traductorjson)->firstWhere('position', (int) $position); // Buscar por valor de position

    Return View('vistadetalle')->with(compact('deta')); 

    }
}
