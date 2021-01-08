<?php

use App\Menu;
use App\Igreja;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $igreja = Igreja::find(1);

        $igreja->menus()->create([
            'ordem' => 1,
            'titulo' => 'Home',
            'url' => '/home',
        ]);
        $igreja->menus()->create([
            'ordem' => 2,
            'titulo' => 'Sobre',
            'url' => '/sobre',
        ]);
        $igreja->menus()->create([
            'ordem' => 3,
            'titulo' => 'Contato',
            'url' => '/contato',
        ]);
        $menu = $igreja->menus()->create([
            'ordem' => 4,
            'titulo' => 'Conteudo'
        ]);

        $menu->submenus()->create([
            'ordem' => 1,
            'titulo' => 'Artigos',
            //'nivel' => 2,
            'igreja_id' => $igreja->id,
        ]);

        $menu->submenus()->create([
            'ordem' => 2,
            'titulo' => 'Notícias',
            //'nivel' => 2,
            'igreja_id' => $igreja->id,
        ]);

        $menu->submenus()->create([
            'ordem' => 3,
            'titulo' => 'Publicações',
            //'nivel' => 2,
            'igreja_id' => $igreja->id,
        ]);
    }
}
