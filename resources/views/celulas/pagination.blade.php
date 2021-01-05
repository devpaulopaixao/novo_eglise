@if(sizeof($data) > 0)
<div class="row">
    @foreach($data as $row)
    <div class="col-md-4 pb-4">
        <div class="card bg-light h-100">
            <div class="card-header text-muted border-bottom-0">
                {{$row->nome}}
            </div>
            <div class="card-body pt-2">
                <div class="row">
                    <div class="col-12">
                        <h2 class="lead"><b>Nicole Pearson</b></h2>

                        <p class="text-muted text-sm">
                            <b>Sobre: </b> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua
                        </p>
                        <p class="text-muted text-sm">
                            <b>Criada por: </b> {{\App\User::where('id', $row->user_id)->pluck('name')[0]}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit"
                        data-id="{{$row->id}}" data-nome="{{$row->nome}}">
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
