<?php

namespace App\Http\Controllers;

use App\Igreja;
use Auth;
use Illuminate\Http\Request;

class IgrejaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:igreja-list', ['only' => ['index', 'store']]);
        $this->middleware('permission:igreja-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:igreja-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:igreja-delete', ['only' => ['destroy']]);
    }

    public function filter(Request $request)
    {
        $query = Igreja::select(
            'igrejas.id',
            'igrejas.nome',
            'igrejas.sobre',
            'igrejas.telefone',
            'users.name as criador',
            'enderecos.cep',
            'enderecos.rua',
            'enderecos.numero',
            'enderecos.complemento',
            'enderecos.bairro',
            'enderecos.cidade',
            'enderecos.estado',
            'enderecos.pais',
        )
            ->join('enderecos', 'igrejas.id', '=', 'enderecos.igreja_id')
            ->join('users', 'igrejas.user_id', '=', 'users.id')
            ->where(function ($query) use ($request) {
                if ($request->search) {
                    $query->where('igrejas.nome', 'like', "%{$request->search}%");
                }
            })->orderBy('igrejas.created_at', 'DESC');
        return $query;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->filter($request)
            ->paginate(12)
            ->appends($request->all())
            ->setPath('/igrejas');

        return view('igrejas.index', compact('data'));
    }

    public function fetch_data(Request $request)
    {
        $data = $this->filter($request)
            ->paginate(12)
            ->appends($request->all())
            ->setPath('/igrejas');

        return response()->json([
            'html' => view('igrejas.pagination', compact('data'))->render(),
        ]);
    }

    public function igreja(Request $request)
    {

        $igreja = Igreja::find($request->session()->get('igreja_id'));
        $configuracao = $igreja->configuracao()->get();
        $endereco = $igreja->endereco()->get();
        $menus = $igreja->menus()->where('menu_id', null)->orderBy('ordem', 'ASC')->get();

        return view('admin.igreja', compact('igreja', 'configuracao', 'endereco', 'menus'));
    }

    public function configurar(Request $request)
    {

        try {

            $igreja = Igreja::find($request->session()->get('igreja_id'));

            if ($igreja->configuracao()->count() == 0) {
                $igreja->configuracao()->create(
                    $request->except('_token', 'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado')
                );
            }
            $igreja->configuracao()->update(
                $request->except('_token', 'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado')
            );

            if ($request->logotipo) {
                //Salvando imagem em base64
                $logo = base64_encode(file_get_contents($request->logotipo));

                $igreja->configuracao()->update([
                    'logotipo' => "data:image/" . $request->logotipo->getClientOriginalExtension() . ";base64," . $logo,
                ]);
            }

            if ($request->favicon) {
                //Salvando imagem em base64
                $fav = base64_encode(file_get_contents($request->favicon));

                $igreja->configuracao()->update([
                    'favicon' => "data:image/" . $request->favicon->getClientOriginalExtension() . ";base64," . $fav,
                ]);
            }

            $igreja->endereco()->update([
                "cep" => $request->cep,
                "rua" => $request->rua,
                "numero" => $request->numero,
                "complemento" => $request->complemento,
                "bairro" => $request->bairro,
                "cidade" => $request->cidade,
                "estado" => $request->estado,
            ]);
        } catch (\Exception $e) {
            //nothing
        }

        return redirect()->route('igreja');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if (Igreja::where('nome', $request->nome)->count() > 0) {
                return response()->json([
                    'message' => "Erro ao realizar o cadastro. A igreja {$request->nome} já existe no cadastro",
                ], 400);
            }

            $igreja = Igreja::create([
                'nome' => $request->nome,
                'user_id' => Auth::user()->id,
            ]);

            $igreja->endereco()->create([
                'cep' => $request->cep,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
            ]);

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/igrejas');

            return response()->json([
                'message' => 'Igreja cadastrada com sucesso!',
                'html' => view('igrejas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possível cadastrar uma nova igreja.Contacte o suporte!',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Igreja  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $igreja = Igreja::find($request->id);

            $igreja->update($request->except(['id', '_token']));

            $igreja->endereco()->delete();
            $igreja->endereco()->create([
                'cep' => $request->cep,
                'rua' => $request->rua,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
            ]);

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/igrejas');

            return response()->json([
                'html' => view('igrejas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => "Não foi possível atualizar a igreja </b>{$request->nome}</b>.Contacte o suporte!",
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Igreja  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Igreja::where('id', $id)->delete();

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/igrejas');

            return response()->json([
                'message' => 'Igreja excluída com sucesso!',
                'html' => view('igrejas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => "Não foi possível excluir a igreja com id</b>{$id}</b>.Contacte o suporte!",
            ], 400);
        }
    }
}
