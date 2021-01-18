<?php

namespace App\Http\Controllers;

use App\Igreja;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inicio($url)
    {

        $id = \App\ConfiguracaoIgreja::where('url', $url)->get()->pluck('igreja_id');

        if(isset($id[0])){
            $igreja = Igreja::find($id[0]);
            $config = $igreja->configuracao()->get();

            return view('layouts.templates.template' . $config[0]->template_id . '.index', compact('igreja','config'));

        }else{
            return response()->view('errors.404', [], 404);
        }

    }

}
