<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p class="text-primary">Home</p>
    </a>
</li>
<li class="nav-item {{ Request::is('partner/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('partner/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p class="text-primary">
        Partner
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formPartner') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-primary">Crea Partner</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('showPartner') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-primary">Mostra Partner</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item {{ Request::is('prodotto/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('prodotto/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shopping-bag"></i>
        <p class="text-primary">
            Prodotti
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formProdotto') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-primary">Crea Prodotti</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('showProdotti') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="text-primary">Mostra Prodotti</p>
            </a>
        </li>
    </ul>
</li>
