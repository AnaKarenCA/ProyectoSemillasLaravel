<!-- Botón para abrir/cerrar menú -->
<button id="menuToggle" class="menu-toggle">
    <span class="material-symbols-outlined open-icon">menu</span>
</button>

<!-- Menú lateral -->
<nav class="menu" id="menu">
    <ul>
        @foreach ($menus as $menu)
            <li>
                <a href="{{ url($menu->url) }}">
                    <span class="material-symbols-outlined">{{ $menu->icono }}</span>
                    <span>{{ $menu->nombre }}</span>
                </a>

            </li>
        @endforeach
    </ul>
</nav>
