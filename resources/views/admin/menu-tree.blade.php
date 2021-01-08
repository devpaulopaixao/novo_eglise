<div id="test" class="tree">
    <ul>
        <li class="parent_li"><span>Raiz</span>
            <div class="float-right pl-5">
                <a class="btn btn-success btn-sm menu_action" data-toggle="modal" data-target="#modal-incluir-menu"><i class="fa fa-plus"></i> Menu</a>
            </div>
            <ul>
                @foreach ($menus as $menu)
                    <li class="parent_li"><span>{{ $menu->titulo }}</span>
                        <div class="float-right">
                            <a class="btn btn-success btn-sm menu_action" data-toggle="modal" data-target="#modal-incluir-menu"><i class="fa fa-plus"></i> Menu</a>
                        </div>
                        <ul>
                            @foreach ($menu->submenus()->get() as $submenu)
                                <li class="parent_li"><span>{{ $submenu->titulo }}</span>
                                    <!--<ul>
                                        <li class="parent_li"><span>Test 1</span>
                                            <ul></ul>
                                        </li>
                                        <li class="parent_li"><span>Test 2</span>
                                            <ul></ul>
                                        </li>
                                        <li class="parent_li"><span>Test 3</span>
                                            <ul></ul>
                                        </li>
                                    </ul>-->
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</div>
