@if(sizeof($data) > 0)
<div class="row">
    @foreach($data as $row)
    <div class="col-md-4 pb-4">
        <div class="card bg-light h-100">
            @if ($row->cover)
            <img class="card-img-top" src="{{$row->cover}}" alt="{{$row->nome}}">
            @endif
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col-12">
                        <h2><b>{{$row->nome}}</b></h2>

                        <p class="text-muted text-sm">
                            <b>Sobre: </b> {{$row->sobre}}
                        </p>

                        <ul class="ml-4 fa-ul text-muted">
                            <li class="small"><span class="fa-li">
                                <i class="fas fa-lg fa-building"></i>
                                </span> Endereço: {{"$row->rua $row->numero, $row->bairro $row->cidade-$row->estado"}}<!--Demo Street 123, Demo City 04312, NJ-->
                            </li>
                            <li class="small mt-2"><span class="fa-li">
                                <i class="fas fa-lg fa-phone"></i>
                                </span> Telefone: {{$row->telefone}}
                            </li>
                            <li class="small mt-2"><span class="fa-li">
                                <i class="fas fa-lg fa-user"></i>
                                </span> Criador: {{$row->criador}}
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit"
                        data-id="{{$row->id}}" data-nome="{{$row->nome}}" data-cep="{{$row->cep}}" data-sobre="{{$row->sobre}}"
                        data-telefone="{{$row->telefone}}" data-rua="{{$row->rua}}" data-numero="{{$row->numero}}" data-complemento="{{$row->complemento}}"
                        data-bairro="{{$row->bairro}}" data-cidade="{{$row->cidade}}" data-estado="{{$row->estado}}"
                        data-pais="{{$row->pais}}">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="#" class="btn btn-sm btn-danger delete" data-id="{{$row->id}}" data-nome="{{$row->nome}}">
                        <i class="fas fa-trash"></i> Excluir
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row">
    {!! $data->links() !!}
</div>

@else
<tr>
    <td colspan="3" class="text-center">Nenhum registro encontrado</td>
</tr>
@endif
