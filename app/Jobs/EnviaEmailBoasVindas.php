<?php

namespace App\Jobs;

use App\Mail\EmailSemAnexo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviaEmailBoasVindas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $receiver;
	public $nome;
	public $email;
	public $senha;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dest, $nome, $email, $senha)
    {
        $this->receiver = $dest;
		$this->nome = $nome;
		$this->email = $email;
		$this->senha = $senha;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		$conteudo = '<h3>Bem-vindo ao Eglise, ' . $this->nome . '!</h3>' .
			'<p>Aproveite todo nosso conteúdo, que pode ser acessado através do endereço <a href="https://www.eglise.com.br/login"><b>https://www.eglise.com.br/login</b></a>.</p>' .
			'<p>Utilize os seguintes dados para entrar:</p>' .
			'<ol>' .
			'<li>email: "' . $this->email . '".</li>' .
			'<li>senha: "' . $this->senha . '".</li>' .
			'</ol>' .
			'<p>Em caso de problema ou dúvida, entre em contato conosco, através deste <a href="https://www.eglise.com.br/contato">link</a>.</p>';

        Mail::to($this->receiver)
            ->send(new EmailSemAnexo("Bem-vindo ao Eglise!", $conteudo));
    }
}
