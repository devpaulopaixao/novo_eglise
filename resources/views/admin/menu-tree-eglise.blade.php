<div id="tree" class="tree">
    <ul>
        <li>
            <div><span><i class="icon-folder-open"></i> Raíz</span>
                <div class="float-right">
                    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-create-menu"><i class="fa fa-plus"></i> Menu</a>
                </div>
            </div>
            <ul>
                @foreach($menus as $menu)
                    <li>
                        <div><span><i class="icon-folder-open"></i> {{"$menu->ordem - $menu->titulo"}}</span>
                            <div class="float-right">
                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-create-submenu" data-id="{{$menu->id}}"><i class="fa fa-plus"></i> Submenu</a>
                                <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-menu" data-id="{{$menu->id}}" data-titulo="{{$menu->titulo}}" data-ordem="{{$menu->ordem}}" data-url="{{$menu->url}}"><i class="fa fa-edit"></i> Menu</a>
                                <a class="btn btn-danger btn-sm delete" href="#" data-id="{{$menu->id}}" data-titulo="{{$menu->titulo}}"><i class="fa fa-trash"></i> Menu</a>
                            </div>
                        </div>
                        <ul>
                            @foreach($menu->submenus()->get() as $submenu)
                                <li>
                                    <div><span><i class="icon-minus-sign"></i> {{"$submenu->ordem - $submenu->titulo"}}</span>
                                        <div class="float-right">
                                            <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-create-submenu" data-id="{{$submenu->id}}"><i class="fa fa-plus"></i> Submenu</a>
                                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-submenu" data-id="{{$submenu->id}}" data-menu_id="{{$submenu->menu_id}}" data-titulo="{{$submenu->titulo}}" data-url="{{$submenu->url}}" data-ordem="{{$submenu->ordem}}"><i class="fa fa-edit"></i> Submenu</a>
                                            <a class="btn btn-danger btn-sm delete" href="#" data-id="{{$submenu->id}}" data-titulo="{{$submenu->titulo}}"><i class="fa fa-trash"></i> Submenu</a>
                                        </div>
                                    </div>
                                    <ul>
                                        @foreach($submenu->submenus()->get() as $subsubmenu)
                                            <li>
                                                <div><span><i class="icon-leaf"></i> {{$subsubmenu->titulo}}</span>
                                                    <div class="float-right">
                                                        <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-edit-subsubmenu" data-id="{{$subsubmenu->id}}" data-nome="{{$subsubmenu->nome}}" data-link="{{$subsubmenu->link}}" data-ordem="{{$subsubmenu->ordem}}" data-id="{{$subsubmenu->id_submenu}}"><i class="fa fa-edit"></i> Submenu</a>
                                                        <a class="btn btn-danger btn-sm delete" href="#" data-id="{{$subsubmenu->id}}" data-titulo="{{$subsubmenu->titulo}}"><i class="fa fa-trash"></i> Submenu</a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</div>