<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlataformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicio()
    {
        return view('inicio');
    }

    public function registrar()
    {
        return view('registre-se');
    }
    
}
