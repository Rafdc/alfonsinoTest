<aside class="main-sidebar sidebar-bgcolor elevation-2">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('img/logo.png') }}"
             alt="Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light text-primary h4"><b>{{ config('app.name') }}</b></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
