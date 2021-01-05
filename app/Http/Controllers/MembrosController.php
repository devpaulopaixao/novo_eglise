<?php

namespace App\Http\Controllers;

use Auth;
use App\Igreja;
use App\Membros;
use Illuminate\Http\Request;

class MembrosController extends Controller
{

    public function conectar(Request $request)
    {
        try {           
            $igreja = Igreja::findOrFail($request->igreja_id);
            $user = Auth::user();
            Membros::create([
                'igreja_id' => $igreja->id,
                'user_id' => $user->id,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'message' => "{$user->name} conectou-se à igreja {$igreja->nome} com sucesso!"
                ]);
            }else{
                redirect()->route('home');
            }
        } catch (\Exception $e) {
            _log("error", $e);
        }
    }

    public function desconectar(Request $request)
    {
        try {           
            $igreja = Igreja::findOrFail($request->igreja_id);
            $user = Auth::user();

            Membros::where('igreja_id', $igreja->id)->where('user_id', $user->id)->delete();

            if ($request->ajax()) {
                return response()->json([
                    'message' => "{$user->name} desconectou-se da igreja {$igreja->nome} com sucesso!"
                ]);
            }else{
                redirect()->route('home');
            }
        } catch (\Exception $e) {
            _log("error", $e);
        }
    }

}
