<li class="nav-item has-treeview {{ in_array(_route(), arr_seguranca()) ? 'menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-lock"></i>
        <p>
            Segurança
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        @if(\Auth::user()->hasRole('SuperAdmin'))
        <li class="nav-item">
            <a href="{{route('perfis.index')}}" class="nav-link {{ in_array(_route(),_perfis()) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Perfis de acesso</p>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a href="{{route('usuarios.index')}}" class="nav-link {{ in_array(_route(),_usuarios()) ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuários</p>
            </a>
        </li>

    </ul>

</li>
