<?php

namespace App\Http\Controllers;

use App\Jobs\EnviaEmailBoasVindas;
use App\User;
use DB;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrarController extends Controller
{
    public function registrar(Request $request)
    {
        try {

            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'cpf' => 'required|cpf|unique:users,cpf',
                //'genre' => 'required',
                //'cell' => 'required',
                //'phone' => 'required',
                'cep' => 'required',
                'senha' => 'required',
                'rua' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'cidade' => 'required',
                'estado' => 'required',
                'terms_accept' => 'required',
            ];

            $message = [
                'name.required' => 'O nome é obrigatório.',
                'email.required' => 'O email é obrigatório.',
                'email.email' => 'Informe um e-mail válido.',
                'email.unique' => 'Esse e-mail já está cadastrado.',
                'cpf.required' => 'O cpf é obrigatório.',
                'cpf.unique' => 'Esse cpf já está cadastrado.',
                'genre.required' => 'O sexo/gênero é obrigatório.',
                'cell.required' => 'O número do celular é obrigatório.',
                'phone.required' => 'O telefone é obrigatório.',
                'cep.required' => 'O cep é obrigatório.',
                'rua.required' => 'O nome da rua é obrigatório.',
                'numero.required' => 'Informe o número do imóvel.',
                'bairro.required' => 'O nome do bairro é obrigatório.',
                'cidade.required' => 'O nome da cidade é obrigatório.',
                'estado.required' => 'A sigla do estado é obrigatória.',
                'terms_accept.required' => 'Leia e aceite nossos termos de serviço.',
            ];

            $validator = Validator::make($request->all(), $rules, $message);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            DB::beginTransaction();

            $senha = Hash::make($request->senha);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'rg' => $request->rg,
                'genre' => $request->genre,
                'phone' => $request->phone,
                'cell' => $request->tel,
                'password' => $senha,
                'terms_accept' => $request->terms_accept ? 'S' : 'N',
            ]);

            $user->endereco()->create([
                'cep' => $request->cep,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado
            ]);

            $user->assignRole([3]); //Usuário

            DB::commit();

            EnviaEmailBoasVindas::dispatch($request->email, $user->name, $request->email, $senha);

            if (Auth::loginUsingId($user->id, true)) {
                // Authentication passed...
                return redirect()->intended(route('home'));
            }

        } catch (Exception $e) {
            DB::rollback();
            _log('error', $e);
            return redirect()->back()->withInput()->withErrors(['message' => 'Ocorreu um erro! Contacte o suporte!']);
        }

    }
}
