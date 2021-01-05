<?php

namespace App\Http\Controllers\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApiDespesasController extends Controller
{
    public function getDespesasEmAberto(){
        $despesas = DB::table('tbl_despesas')
          ->selectRaw("tbl_despesas.id,
          tbl_despesas.descricao,
          tbl_despesas.flg_status,
          tbl_despesas.valor,
          DATE_FORMAT(tbl_despesas.data_vencimento, '%d/%m/%Y') as data_vencimento,
          tbl_despesas.valor,DATE_FORMAT(tbl_despesas.data_pagamento, '%d/%m/%Y %h:%i:%s') as data_pagamento,
          tbl_despesas.observacao,
          tbl_despesas.created_at,
          tbl_despesas.updated_at")
          ->where('flg_status','=','A')
          ->get();

        return response()->json($despesas, 200);
      }

      public function getDespesasQuitadas(){
        $despesas = DB::table('tbl_despesas')
          ->selectRaw("tbl_despesas.id,
          tbl_despesas.descricao,
          tbl_despesas.flg_status,
          tbl_despesas.valor,
          DATE_FORMAT(tbl_despesas.data_vencimento, '%d/%m/%Y') as data_vencimento,
          tbl_despesas.valor,DATE_FORMAT(tbl_despesas.data_pagamento, '%d/%m/%Y %h:%i:%s') as data_pagamento,
          tbl_despesas.observacao,
          tbl_despesas.created_at,
          tbl_despesas.updated_at")
          ->where('flg_status','=','P')
          ->get();

        return response()->json($despesas, 200);
      }
}
