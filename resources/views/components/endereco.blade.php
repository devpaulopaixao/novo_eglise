@push('script')
<script>
    $('input[name="cep"]').mask('00.000-000');

    $(document).on('blur', "input[name='cep']", function(){
        var parser = /^[0-9]{8}$/;
        var cep = $(this).val().replace(/\D/g, '');

        if((cep != '')&&(parser.test(cep))){
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("input[name='rua']").val(dados.logradouro);
                    $("input[name='complemento']").val(dados.complemento);
                    $("input[name='bairro']").val(dados.bairro);
                    $("input[name='cidade']").val(dados.localidade);
                    $("input[name='estado']").val(dados.uf);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    $("input[name='rua']").val(null);
                    $("input[name='complemento']").val(null);
                    $("input[name='bairro']").val(null);
                    $("input[name='cidade']").val(null);
                    $("input[name='estado']").val(null);
                }
            });
        }
    });

</script>
@endpush

<div class="col-xs-6 col-sm-12 col-md-4">
    <div class="form-group">
        <strong>CEP:</strong>
        <input type="text" name="cep" class="form-control" maxlength="10" value="{{isset($cep) ? $cep : old('cep')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-8">
    <div class="form-group">
        <strong>Rua:</strong>
        <input type="text" name="rua" class="form-control" value="{{isset($rua) ? $rua : old('rua')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-3">
    <div class="form-group">
        <strong>Número:</strong>
        <input type="text" name="numero" class="form-control" value="{{isset($numero) ? $numero : old('numero')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-9">
    <div class="form-group">
        <strong>Complemento:</strong>
        <input type="text" name="complemento" class="form-control" value="{{isset($complemento) ? $complemento : old('complemento')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Bairro:</strong>
        <input type="text" name="bairro" class="form-control" value="{{isset($bairro)? $bairro : old('bairro')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Cidade:</strong>
        <input type="text" name="cidade" class="form-control" value="{{isset($cidade)? $cidade : old('cidade')}}">
    </div>
</div>
<div class="col-xs-6 col-sm-12 col-md-2">
    <div class="form-group">
        <strong>UF:</strong>
        <input type="text" name="estado" class="form-control" maxlength="2" value="{{isset($estado) ? $estado : old('estado')}}">
    </div>
</div>
