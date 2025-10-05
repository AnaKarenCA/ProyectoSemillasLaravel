<!-- Botón para abrir/cerrar menú -->
<button id="menuToggle" class="menu-toggle">
    <span class="material-symbols-outlined open-icon">menu</span>
</button>

<!-- Menú lateral -->
<nav class="menu" id="menu">
    <ul>
        @foreach ($menus as $menu)
            @if ($menu->url !== '/logout')
                <li>
                    <a href="{{ url($menu->url) }}">
                        <span class="material-symbols-outlined">{{ $menu->icono }}</span>
                        <span>{{ $menu->nombre }}</span>
                    </a>
                </li>
            @else
                {{-- Aquí el botón de Cerrar sesión --}}
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-link text-white" style="text-decoration:none; display:flex; align-items:center; gap:8px;">
                            <span class="material-symbols-outlined">{{ $menu->icono }}</span>
                            <span>{{ $menu->nombre }}</span>
                        </button>
                    </form>
                </li>
            @endif
        @endforeach
    </ul>
</nav>
