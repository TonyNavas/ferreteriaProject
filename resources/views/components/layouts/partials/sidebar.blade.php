@php
    $links = [
        [
            'name' => 'Inicio',
            'icon' => 'fa fa-home',
            'href' => route('inicio'),
            'active' => Request::is('inicio') ? 'active' : '',
        ],
        [
            'header' => 'ADMINISTRAR PAGINA',
        ],
        [
            'name' => 'Categorías',
            'icon' => 'fas fa-th-large',
            'href' => route('category.index'),
            'active' => Request::is('admin/categorias*') ? 'active' : '',
        ],
        [
            'name' => 'Productos',
            'icon' => 'fas fa-box',
            'href' => route('product.index'),
            'active' => Request::is('admin/productos*') ? 'active' : '',
        ],
                [
            'name' => 'Clientes',
            'icon' => 'fas fa-users',
            'href' => route('customer.index'),
            'active' => Request::is('admin/clientes*') ? 'active' : '',
        ],
    ];
@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Ferreteria</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @foreach ($links as $link)
                    <li class="nav-item">

                        @isset($link['header'])
                        <li class="nav-header">{{ $link['header'] }}</li>
                    @else
                        <a href="{{ $link['href'] }}" class="nav-link {{ $link['active'] }}">
                            <i class="nav-icon {{ $link['icon'] }}"></i>
                            <p>
                                {{ $link['name'] }}
                            </p>
                        </a>
                    @endisset
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>

</aside>
