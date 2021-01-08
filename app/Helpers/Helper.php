<?php
use Illuminate\Support\Str;
use Illuminate\Http\Request;

function _home(){
    return array(
     'home'
 );
}

function arr_seguranca(){
 return array(
     'usuarios.index',
     'usuarios.create',
     'usuarios.edit',
     'perfis.index',
     'perfis.create',
     'perfis.edit'
 );
}

function _perfis(){
    return array(
     'perfis.index',
     'perfis.create',
     'perfis.edit'
 );
}

function _usuarios(){
    return array(
     'usuarios.index',
     'usuarios.create',
     'usuarios.edit'
 );
}

function getIgreja(Request $request){
    return \App\Igreja::find($request->session()->get('igreja_id'));
}

function onlyNumbers($value)
{
    return preg_replace( '/[^0-9]/', '', $value );
}

function _route(){
    return \Route::currentRouteName();
}

function consisteVeiculo($id){
    \App\Veiculos::where('id', $id)
    ->update(['str' => Str::uuid()]);
}

function format_date($date){
    $str = explode('/', $date);
    return ($str[2] . '-' . $str[1] . '-' . $str[0]);
}

function dmy($date){
 return \Carbon\Carbon::parse($date)->format('d/m/Y');
}

function dmy_time($date){
 return \Carbon\Carbon::parse($date)->format('d/m/Y H:i:s');
}

function _replace($char,$str){
    return str_replace($char, '', $str);
}

function _replaceINDV($char,$prm,$str){
    return str_replace($char, $prm, $str);
}

function getUUID(){
    return \Illuminate\Support\Str::uuid();
}

function _log($tipo, $mensagem){
    switch($tipo){
        case "emergency":
            \Log::emergency($mensagem);
            break;
        case "alert":
            \Log::alert($mensagem);
            break;
        case "critical":
            \Log::critical($mensagem);
            break;
        case "error":
            \Log::error($mensagem);
            break;
        case "warning":
            \Log::warning($mensagem);
        case "notice":
            \Log::notice($mensagem);
            break;
        case "info":
            \Log::info($mensagem);
            break;
        case "debug":
            \Log::debug($mensagem);
            break;
    }
}

/**
 * create time range by CodexWorld
 *
 * @param mixed $start start time, e.g., 7:30am or 7:30
 * @param mixed $end   end time, e.g., 8:30pm or 20:30
 * @param string $interval time intervals, 1 hour, 1 mins, 1 secs, etc.
 * @param string $format time format, e.g., 12 or 24
 */
function create_time_range($start, $end, $interval = '30 mins', $format = '12') {
    $startTime = strtotime($start);
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12') ? 'g:i:s A' : 'G:i:s';

    $current   = time();
    $addTime   = strtotime('+'.$interval, $current);
    $diff      = $addTime - $current;

    $times = array();
    while ($startTime < $endTime) {
        $times[] = date($returnTimeFormat, $startTime);
        $startTime += $diff;
    }
    $times[] = date($returnTimeFormat, $startTime);
    return $times;
}

function showQuery($query)
{
  return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
      $binding = addslashes($binding);
      return is_numeric($binding) ? $binding : "'{$binding}'";
  })->toArray());
}
