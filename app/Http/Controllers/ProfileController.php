<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $roles = collect(Auth::user()->getRoleNames()->toArray())->implode('-');

        return view('perfil.index', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'avatar_blob' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->avatar_blob) {
            //Salvando imagem em base64
            $blob = base64_encode(file_get_contents($request->avatar_blob));

            $user->avatar_blob = "data:image/" . $request->avatar_blob->getClientOriginalExtension() . ";base64," . $blob;
        }

        $user->endereco()->delete();
        $user->endereco()->create([
            'cep' => $request->cep,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade
        ]);

        if ($user->save()) {
            $notification = array(
                'message' => ' Dados pessoais atualizados com sucesso!',
                'alert-type' => 'success',
            );

            return redirect()->route('perfil')
                ->with($notification);
        } else {
            $notification = array(
                'message' => ' Ocorreu um erro ao tentar atualizar os dados pessoais. \n Contacte o suporte!',
                'alert-type' => 'error',
            );

            return redirect()->route('perfil')
                ->with($notification);
        }
    }

    public function novaSenha(Request $request)
    {
        $user = Auth::user();

        $user->password = Hash::make($request->password);

        if ($user->save()) {
            $notification = array(
                'message' => ' Senha atualizada com sucesso!',
                'alert-type' => 'success',
            );

            return redirect()->route('perfil')
                ->with($notification);
        } else {
            $notification = array(
                'message' => ' Ocorreu um erro ao tentar atualizar a senha. \n Contacte o suporte!',
                'alert-type' => 'error',
            );

            return redirect()->route('perfil')
                ->with($notification);
        }

    }

}
