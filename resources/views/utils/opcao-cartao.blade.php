<div class="row">

    <div class="col-md-12">
        <div class="form-group">
            <strong for="c-nome">Nome impresso no cartão</strong>
            <input type="text" name="cardname" value="" size="40" class="form-control" id="cardname" required>
            <div class="invalid-feedback">Informe o nome impresso no cartão</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <strong for="c-num">Número do cartão</strong>
            <input type="text" id="cardnum" name="cardnum" value="" size="40" class="form-control" required
                maxlength="19" onkeyup="fnc_onlynumber(this)">
            <div class="invalid-feedback">Informe o n° do cartão</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <strong for="c-num">Validade(Mês)</strong>
            <select name="cardmonth" id="cardmonth" class="form-control">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <strong for="c-num">Validade(Ano)</strong>
            @php
            $year = \Carbon\Carbon::now()->format('Y');
            @endphp
            <select name="cardyear" id="cardyear" class="form-control">
                @for ($i = 0; $i <= 10; $i++)
                    <option value="{{ $year + $i }}">{{ $year + $i }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <strong for="c-digito">CVV</strong>
            <input type="text" id="carddigito" name="carddigito" value="" size="40" class="form-control" required maxlength="3"
                onkeyup="fnc_onlynumber(this)">
            <div class="invalid-feedback">Informe o dígito verificador</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <strong for="valor">Valor do contrato</strong>
            <input type="text" id="valor" name="valor" value="R$ 1.800,00" size="40" class="form-control"
                aria-invalid="false" readonly="">
        </div>
    </div>
</div>
