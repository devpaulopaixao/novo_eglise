<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Igreja;
use App\Membros;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function cadastrarIgreja(Request $request)
    {
        try {

            if (Igreja::where('nome', $request->nome)->count() > 0) {
                return response()->json([
                    'message' => "Erro ao realizar o cadastro. A igreja {$request->nome} já existe no cadastro",
                ], 400);
            }

            $user = Auth::user();

            $igreja = Igreja::create([
                'nome' => $request->nome,
                'user_id' => $user->id,
            ]);

            $igreja->endereco()->create([
                'cep' => $request->cep,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado
            ]);

            Membros::create([
                'igreja_id' => $igreja->id,
                'user_id' => $user->id,
            ]);

            $user->assignRole([2]);//Concede permissão de administrador da igreja

            $notification = array(
                'message' => "Igreja {{$igreja->nome}} cadastrada com sucesso!",
                'alert-type' => 'success',
            );

            return redirect()->route('home')->with($notification);

        } catch (Exception $e) {
            $notification = array(
                'message' => "Erro ao incluir igreja! Contacte o suporte!",
                'alert-type' => 'error',
            );

            return redirect()->route('home')->with($notification);
        }
    }

}
