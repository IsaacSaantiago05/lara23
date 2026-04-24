<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ctrlBienvenida extends Controller
{
    public function Bienvenidos(){
        return view('welcome');
    }

    public function sumar(){
        return 5 + 4;
    }

    public function Datosumar($n1){
        //obtener datos de la url, y sumarlos
        Return("si funciona");
    }

    public function DatosumarDos($n1, $n2){
        return "La suma es:" . $n1 + $n2;


    }

    public function DatosumarTres($n1, $n2){
        $datos = $n1 + $n2;
        $resultado = "La suma es:" . $datos;
        return view('welcome', compact('n1', 'n2', 'datos'));
       
        //mostrar datos en la vista welcome, con el resultado de la suma
    }
}