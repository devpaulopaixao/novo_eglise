<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getEmpresas(){
      $empresas = DB::table('tbl_sge_escolas')
        ->select('COD_IDENT_EMPRE','TXT_NOMEX_EMPRE')
        ->where('FLG_SITUA_EMPRE','=','A')
        ->whereNotIn('COD_IDENT_EMPRE', ['000','HOT','007','999','CBJ','HSC','PBA'])
        ->orderBy('TXT_NOMEX_EMPRE','ASC')
        ->get();
      return response()->json($empresas, 200);
    }

    public function getAnos($empresa){
      $anos = DB::table('tbl_sge_anosletivos')
      ->select('NUM_ANOXX_LETIV')
      ->where('COD_IDENT_EMPRE','=',$empresa)
      ->orderBy('NUM_ANOXX_LETIV','DESC')
      ->get();
      return response()->json($anos, 200);
    }

    public function getCursos($empresa,$ano){
      $cursos = DB::table('tbl_sge_cursos')
      ->select('COD_IDENT_CURSO','TXT_DESCR_CURSO')
      ->where('COD_IDENT_EMPRE','=',$empresa)
      ->where('NUM_ANOXX_LETIV','=',$ano)
      ->orderBy('TXT_DESCR_CURSO','ASC')
      ->get();
      return response()->json($cursos, 200);
    }

    public function getSeries($empresa,$ano,$curso){
      $series = DB::table('tbl_sge_series')
      ->select('COD_IDENT_SERIE','TXT_DESCR_SERIE')
      ->where('COD_IDENT_EMPRE','=',$empresa)
      ->where('NUM_ANOXX_LETIV','=',$ano)
      ->where('COD_IDENT_CURSO','=',$curso)
      ->orderBy('TXT_DESCR_SERIE','ASC')
      ->get();
      return response()->json($series, 200);
    }

    public function getDisciplinas($empresa,$ano,$curso,$serie){
      $disciplinas = DB::table('tbl_sge_disciplinas')
      ->select('tbl_sge_disciplinas.COD_IDENT_DISPL','tbl_sge_disciplinas.TXT_NOMEX_DISPL')
      ->join("tbl_sge_seriesxdisciplinas",function($join){
            $join->on("tbl_sge_seriesxdisciplinas.COD_IDENT_DISPL","=","tbl_sge_disciplinas.COD_IDENT_DISPL")
                ->on("tbl_sge_seriesxdisciplinas.COD_IDENT_EMPRE","=","tbl_sge_disciplinas.COD_IDENT_EMPRE")
                ->on("tbl_sge_seriesxdisciplinas.NUM_ANOXX_LETIV","=","tbl_sge_disciplinas.NUM_ANOXX_LETIV");
        })
      ->where('tbl_sge_disciplinas.COD_IDENT_EMPRE','=',$empresa)
      ->where('tbl_sge_disciplinas.NUM_ANOXX_LETIV','=',$ano)
      ->where('tbl_sge_seriesxdisciplinas.COD_IDENT_CURSO','=',$curso)
      ->where('tbl_sge_seriesxdisciplinas.COD_IDENT_SERIE','=',$serie)
      ->orderBy('tbl_sge_disciplinas.TXT_NOMEX_DISPL','ASC')
      ->get();
      return response()->json($disciplinas, 200);
    }

    public function getTurmas($empresa,$ano,$curso,$serie){
      $turmas = DB::table('tbl_sge_turmas')
      ->select('COD_IDENT_TURMA','TXT_DESCR_TURMA')
      ->where('COD_IDENT_EMPRE','=',$empresa)
      ->where('NUM_ANOXX_LETIV','=',$ano)
      ->where('COD_IDENT_CURSO','=',$curso)
      ->where('COD_IDENT_SERIE','=',$serie)
      ->orderBy('COD_IDENT_TURMA','ASC')
      ->get();
      return response()->json($turmas, 200);
    }

    public function getPlanejamento($empresa,$curso,$serie,$turma,$etapa,$disciplina,$ano){
      $planejamento = DB::table('tbl_SGE_PLANOS_AVALIACAO')
      ->select('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_ATIVD AS ATIVIDADE','tbl_SGE_PLANOS_AVALIACAO.FLG_TIPOX_ATIVD AS TIPO',
               'tbl_SGE_PLANOS_AVALIACAO.TXT_DESCR_ATIVD AS DESCRICAO','tbl_SGE_PLANOS_AVALIACAO.MEM_DETLH_ATIVD AS DETALHE',
               'tbl_SGE_PLANOS_AVALIACAO.VLR_PONTS_ATIVD AS VALOR','tbl_SGE_DISCIPLINAS.TXT_NOMEX_DISPL',
               'tbl_SGE_PLANOS_AVALIACAO.DAT_REALZ_ATIVD','tbl_SGE_PLANOS_AVALIACAO.TXT_ATIVD_UUIDX AS UUID')
      ->join("tbl_SGE_DISCIPLINAS",function($join){
            $join->on("tbl_SGE_DISCIPLINAS.COD_IDENT_DISPL","=","tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL")
                ->on("tbl_SGE_DISCIPLINAS.COD_IDENT_EMPRE","=","tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE")
                ->on("tbl_SGE_DISCIPLINAS.NUM_ANOXX_LETIV","=","tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV");
        })
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE','=',$empresa)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_CURSO','=',$curso)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_SERIE','=',$serie)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA','=',$turma)
        //->where('tbl_SGE_PLANOS_AVALIACAO.FLG_IDENT_ETAPA','=',$etapa)
        ->whereIn('FLG_IDENT_ETAPA', ($etapa == 'T') ? ['1','2','3','4'] : [$etapa])
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL','=',$disciplina)
        ->where('tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV','=',$ano)
        ->orderBy('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA','ASC')
        ->get();

      return response()->json($planejamento, 200);
    }

    public function getPlano($empresa,$curso,$serie,$turma,$etapa,$ano){

      $data = [];

      $disciplinas = $this->listaDeDisciplinas($empresa,$ano,$curso,$serie);
      $planos = $this->listaDePlanos($empresa,$curso,$serie,$turma,$etapa,$ano);

      foreach ($disciplinas as $key => $disciplina) {
        $data['planejamento'][$key] = [
          'codigo' => $disciplina->COD_IDENT_DISPL,
          'nome' => $disciplina->TXT_NOMEX_DISPL,
          'planos' => []
        ];

        foreach ($planos as $index => $plano) {
          if($plano->COD_IDENT_DISPL == $data['planejamento'][$key]['codigo']){
            $data['planejamento'][$key]['planos'][$index] = (array)$plano;
          }
        }
      }

      //return json_encode($data);

      return response()->json($data, 200);

    }

    public function listaDeDisciplinas($empresa,$ano,$curso,$serie){
        $disciplinas = DB::table('tbl_sge_disciplinas')
        ->select('tbl_sge_disciplinas.COD_IDENT_DISPL','tbl_sge_disciplinas.TXT_NOMEX_DISPL')
        ->join("tbl_sge_seriesxdisciplinas",function($join){
              $join->on("tbl_sge_seriesxdisciplinas.COD_IDENT_DISPL","=","tbl_sge_disciplinas.COD_IDENT_DISPL")
                  ->on("tbl_sge_seriesxdisciplinas.COD_IDENT_EMPRE","=","tbl_sge_disciplinas.COD_IDENT_EMPRE")
                  ->on("tbl_sge_seriesxdisciplinas.NUM_ANOXX_LETIV","=","tbl_sge_disciplinas.NUM_ANOXX_LETIV");
          })
        ->where('tbl_sge_disciplinas.COD_IDENT_EMPRE','=',$empresa)
        ->where('tbl_sge_disciplinas.NUM_ANOXX_LETIV','=',$ano)
        ->where('tbl_sge_seriesxdisciplinas.COD_IDENT_CURSO','=',$curso)
        ->where('tbl_sge_seriesxdisciplinas.COD_IDENT_SERIE','=',$serie)
        ->orderBy('tbl_sge_disciplinas.TXT_NOMEX_DISPL','ASC')
        ->get();
        return $disciplinas;
    }

    public function listaDePlanos($empresa,$curso,$serie,$turma,$etapa,$ano){
      $planos = DB::table('tbl_SGE_PLANOS_AVALIACAO')
      ->select('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_ATIVD AS ATIVIDADE','tbl_SGE_PLANOS_AVALIACAO.FLG_TIPOX_ATIVD AS TIPO',
               'tbl_SGE_PLANOS_AVALIACAO.TXT_DESCR_ATIVD AS DESCRICAO','tbl_SGE_PLANOS_AVALIACAO.MEM_DETLH_ATIVD AS DETALHE',
               'tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL','tbl_SGE_PLANOS_AVALIACAO.VLR_PONTS_ATIVD AS VALOR','tbl_SGE_DISCIPLINAS.TXT_NOMEX_DISPL',
               'tbl_SGE_PLANOS_AVALIACAO.DAT_REALZ_ATIVD','tbl_SGE_PLANOS_AVALIACAO.TXT_ATIVD_UUIDX AS UUID')
      ->join("tbl_SGE_DISCIPLINAS",function($join){
            $join->on("tbl_SGE_DISCIPLINAS.COD_IDENT_DISPL","=","tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL")
                ->on("tbl_SGE_DISCIPLINAS.COD_IDENT_EMPRE","=","tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE")
                ->on("tbl_SGE_DISCIPLINAS.NUM_ANOXX_LETIV","=","tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV");
        })
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE','=',$empresa)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_CURSO','=',$curso)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_SERIE','=',$serie)
        ->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA','=',$turma)
        //->where('tbl_SGE_PLANOS_AVALIACAO.FLG_IDENT_ETAPA','=',$etapa)
        ->whereIn('FLG_IDENT_ETAPA', ($etapa == 'T') ? ['1','2','3','4'] : [$etapa])
        //->where('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL','=',$disciplina)
        ->where('tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV','=',$ano)
        ->orderBy('tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA','ASC')
        ->get();

      return $planos;
    }

    /*
    SELECT tbl_SGE_PLANOS_AVALIACAO.DAT_REALZ_ATIVD,tbl_SGE_DISCIPLINAS.TXT_NOMEX_DISPL AS DISCIPLINA,tbl_SGE_PLANOS_AVALIACAO.FLG_IDENT_ETAPA AS ETAPA,tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_ATIVD AS ATIVIDADE,tbl_SGE_PLANOS_AVALIACAO.FLG_TIPOX_ATIVD AS TIPO,
    tbl_SGE_PLANOS_AVALIACAO.TXT_DESCR_ATIVD AS DESCRICAO,tbl_SGE_PLANOS_AVALIACAO.MEM_DETLH_ATIVD AS DETALHE,tbl_SGE_PLANOS_AVALIACAO.VLR_PONTS_ATIVD AS VALOR,tbl_SGE_PLANOS_AVALIACAO.TXT_ATIVD_UUIDX AS UUID
    FROM DB_SGE_SCHOOL.tbl_SGE_PLANOS_AVALIACAO PA
    INNER JOIN DB_SGE_SCHOOL.tbl_SGE_DISCIPLINAS DI
    ON tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE = tbl_SGE_DISCIPLINAS.COD_IDENT_EMPRE AND tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_DISPL = tbl_SGE_DISCIPLINAS.COD_IDENT_DISPL AND tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV = tbl_SGE_DISCIPLINAS.NUM_ANOXX_LETIV
    WHERE tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_EMPRE = '001'
    AND tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_CURSO = '2'
    AND tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_SERIE = '7'
    AND tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA = '32' #TURMA GÁLATAS
    AND tbl_SGE_PLANOS_AVALIACAO.FLG_IDENT_ETAPA = '3'
    AND tbl_SGE_PLANOS_AVALIACAO.NUM_ANOXX_LETIV = '2019'
    ORDER BY tbl_SGE_DISCIPLINAS.TXT_NOMEX_DISPL,tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_TURMA,tbl_SGE_PLANOS_AVALIACAO.COD_IDENT_ATIVD;
    */

}
