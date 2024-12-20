<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-boxes"></i>
            {{-- <i class="fa-solid fa-motorcycle"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">EGATE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == 'customer.dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('customer.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li
        class="nav-item {{ Route::currentRouteName() == 'customer.approval.index' || Route::currentRouteName() == 'customer.approval.create' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('customer.approval.index') }}">
            <i class="fa fa-fw fa-cube"></i>
            <span>Approvals</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Database
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li
        class="nav-item {{ Route::currentRouteName() == 'customer.database.part.index' ||
        Route::currentRouteName() == 'customer.database.service.index' ||
        Route::currentRouteName() == 'customer.database.part.import.index' ||
        Route::currentRouteName() == 'customer.database.service.import.index'
            ? 'active'
            : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-database"></i>
            <span>DB</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Databases</h6>
                <a class="collapse-item" href="{{ route('customer.database.part.index') }}">Parts</a>
                <a class="collapse-item" href="{{ route('customer.database.service.index') }}">Services</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->


    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
