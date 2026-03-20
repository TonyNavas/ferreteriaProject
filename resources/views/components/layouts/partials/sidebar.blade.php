@php
    $links = [
        [
            'header' => 'Principal',
        ],
        [
            'name' => 'Inicio',
            'icon' => 'fa fa-home',
            'href' => route('inicio'),
            'active' => Request::is('inicio') ? 'active' : '',
        ],
        [
            'header' => 'Inventario',
        ],
        [
            'name' => 'Inventario',
            'icon' => 'fas fa-luggage-cart',
            'active' => Request::is('admin/categorias*') || Request::is('admin/productos*') || Request::is('admin/almacen*'),
            'submenu' => [
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
                    'name' => 'Almacen',
                    'icon' => 'fas fa-warehouse',
                    'href' => route('warehouse.index'),
                    'active' => Request::is('admin/almacen*') ? 'active' : '',
                ],
            ],
        ],

        [
            'name' => 'Compras',
            'icon' => 'fas fa-shopping-cart',
            'active' =>  Request::is('admin/proveedores*') || Request::is('admin/ordenes-compra*') || Request::is('admin/compras*'),
            'submenu' => [
                [
                    'name' => 'Proveedores',
                    'icon' => 'fas fa-truck',
                    'href' => route('supplier.index'),
                    'active' => Request::is('admin/proveedores*') ? 'active' : '',
                ],
                [
                    'name' => 'Ordenes de compra',
                    'icon' => 'fas fa-clipboard-list',
                    'href' => route('purchaseorder.index'),
                    'active' => Request::is('admin/ordenes-compra*') ? 'active' : '',
                ],
                [
                    'name' => 'Compras',
                    'icon' => 'fas fa-dolly',
                    'href' => route('purchase.index'),
                    'active' => Request::is('admin/compras*') ? 'active' : '',
                ],
            ],
        ],

        [
            'name' => 'Ventas',
            'icon' => 'fas fa-cash-register',
            'active' => false,
            'submenu' => [
                [
                    'name' => 'Clientes',
                    'icon' => 'fas fa-users',
                    'href' => route('customer.index'),
                    'active' => Request::is('admin/clientes*') ? 'active' : '',
                ],
                [
                    'name' => 'Cotizaciones',
                    'href' => '#',
                    'active' => false,
                ],
                [
                    'name' => 'Ventas',
                    'href' => '#',
                    'active' => false,
                ],
            ],
        ],

        [
            'name' => 'Movimientos',
            'icon' => 'fas fa-random',
            'active' => false,
            'submenu' => [
                [
                    'name' => 'Entradas y salidas',
                    'href' => '#',
                    'active' => false,
                ],
                [
                    'name' => 'Transferencias',
                    'href' => '#',
                    'active' => false,
                ],
            ],
        ],

        [
            'name' => 'Reportes',
            'icon' => 'fas fa-chart-line',
            'active' => false,
            'submenu' => [
                [
                    'name' => 'Entradas y salidas',
                    'href' => '#',
                    'active' => false,
                ],
                [
                    'name' => 'Transferencias',
                    'href' => '#',
                    'active' => false,
                ],
            ],
        ],

        [
            'header' => 'Configuracion',
        ],

        [
            'name' => 'Usuarios',
            'icon' => 'fas fa-users',
            'href' => '#',
            'active' => false,
        ],

        [
            'name' => 'Roles y permisos',
            'icon' => 'fas fa-user-shield',
            'href' => '#',
            'active' => false,
        ],

        [
            'name' => 'Ajustes',
            'icon' => 'fas fa-cogs',
            'href' => '#',
            'active' => false,
        ],
    ];
@endphp


<aside class="main-sidebar sidebar-light-primary elevation-1">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">FerreteriaVictoria</span>
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
                    @isset($link['header'])
                        <li class="nav-header">{{ $link['header'] }}</li>
                        @continue
                    @endisset

                    <li class="nav-item {{ isset($link['submenu']) && $link['active'] ? 'menu-open' : '' }}">

                        <a href="{{ $link['href'] ?? '#' }}" class="nav-link {{ $link['active'] ? 'active' : '' }}">
                            <i class="nav-icon {{ $link['icon'] }}"></i>
                            <p>
                                {{ $link['name'] }}
                                @isset($link['submenu'])
                                    <i class="right fas fa-angle-left"></i>
                                @endisset
                            </p>
                        </a>

                        @isset($link['submenu'])
                            <ul class="nav nav-treeview">
                                @foreach ($link['submenu'] as $item)
                                    <li class="nav-item">
                                        <a href="{{ $item['href'] }}"
                                            class="nav-link {{ $item['active'] ? 'active' : '' }}">
                                            <i class="{{ $item['icon'] ?? 'far fa-circle nav-icon' }}"></i>

                                            <p>{{ $item['name'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endisset
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
