<?php

namespace App\View\Components;

use Illuminate\View\Component;

class endereco extends Component
{

    public $cep;
    public $rua;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $cep = '',
        $rua = '',
        $numero = '',
        $complemento = '',
        $bairro = '',
        $cidade = '',
        $estado = '') {
        $this->cep = $cep;
        $this->rua = $rua;
        $this->numero = $numero;
        $this->complemento = $complemento;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.endereco');
    }
}
