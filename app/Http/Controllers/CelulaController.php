<?php

namespace App\Http\Controllers;
use Auth;
use App\Celula;
use Illuminate\Http\Request;

class CelulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:celula-list', ['only' => ['index', 'store']]);
        $this->middleware('permission:celula-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:celula-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:celula-delete', ['only' => ['destroy']]);

        //Check if user as member of any church
        $this->middleware(function ($request, $next) {
            
            if(!$request->session()->has('igreja_id')){
                return redirect()->route('home');
            }

            return $next($request);
        });
    }

    public function filter(Request $request)
    {
        $query = Celula::select('*')
            ->where(function ($query) use ($request) {
                if ($request->search) {
                    $query->where('nome', 'like', "%{$request->search}%");
                }
            })->orderBy('created_at', 'DESC');
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
            ->setPath('/celulas');

        return view('celulas.index', compact('data'));
    }

    public function fetch_data(Request $request)
    {
        $data = $this->filter($request)
            ->paginate(12)
            ->appends($request->all())
            ->setPath('/celulas');

        return response()->json([
            'html' => view('celulas.pagination', compact('data'))->render(),
        ]);
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

            if (Celula::where('nome', $request->nome)->count() > 0) {
                return response()->json([
                    'message' => "Erro ao realizar o cadastro. A célula {$request->nome} já existe no cadastro",
                ], 400);
            }

            Auth::user()->celulas()->create([
                'nome' => $request->nome
            ]);

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/celulas');

            return response()->json([
                'message' => 'Célula cadastrado com sucesso!',
                'html' => view('celulas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possível cadastrar uma nova célula.Contacte o suporte!',
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Celula  $data
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            Celula::where('id', $request->id)
                ->update($request->except(['id', '_token']));

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/celulas');

            return response()->json([
                'html' => view('celulas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possível atualizar a célula </b>{$request->nome}</b>.Contacte o suporte!',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Celula  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            Celula::where('id', $id)->delete();

            $data = $this->filter($request)
                ->paginate(12)
                ->appends($request->all())
                ->setPath('/celulas');

            return response()->json([
                'message' => 'Célula excluída com sucesso!',
                'html' => view('celulas.pagination', compact('data'))->render(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Não foi possível excluir a célula com id</b>{$id}</b>.Contacte o suporte!',
            ], 400);
        }
    }
}
