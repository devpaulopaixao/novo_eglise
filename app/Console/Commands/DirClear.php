<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use Carbon\Carbon;
class DirClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dir:clear';
/**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear files of directory';
/**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command = "rm -rf /home/u768054843/domains/yahoonet.br/public_html/teste/mailfolder/*";
        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
    }
}
