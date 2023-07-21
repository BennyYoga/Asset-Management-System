<!-- ======== sidebar-nav start =========== -->
<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo" style="text-align: left">
        <a href="index.html">
            <img src="{{asset('images/logo/logo.svg')}}" class="w-100" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item {{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{route('dashboard.index')}}">
                    <span class="icon">
                        <svg width="25" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('location.index') ? 'active' : '' }}">
                <a href="{{route('location.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M10,2V4.26L12,5.59V4H22V19H17V21H24V2H10M7.5,5L0,10V21H15V10L7.5,5M14,6V6.93L15.61,8H16V6H14M18,6V8H20V6H18M7.5,7.5L13,11V19H10V13H5V19H2V11L7.5,7.5M18,10V12H20V10H18M18,14V16H20V14H18Z" />
                        </svg>
                    </span>
                    <span class="text">Locations</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('inventory.index') ? 'active' : '' }}">
                <a href="{{route('inventory.index')}}">
        </ul>
        <ul>
            <li class="nav-item {{ Request::routeIs('item.index') ? 'active' : '' }}">
                <a href="{{route('item.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M12,18.54L19.37,12.8L21,14.07L12,21.07L3,14.07L4.62,12.81L12,18.54M12,16L3,9L12,2L21,9L12,16M12,4.53L6.26,9L12,13.47L17.74,9L12,4.53Z" />
                        </svg>
                    </span>
                    <span class="text">Inventory</span>
                </a>
            </li>
            <li class="nav-item nav-item-has-children {{Request::routeIs('item.*') ? 'active' : '' }}">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M21 3H3V9H21V3M19 7H5V5H19V7M14.5 11C14.78 11 15 11.22 15 11.5V13H9V11.5C9 11.22 9.22 11 9.5 11H14.5M18 13.09V10H20V13.09C19.67 13.04 19.34 13 19 13C18.66 13 18.33 13.04 18 13.09M13 19C13 19.7 13.13 20.37 13.35 21H4V10H6V19H13M22.5 17.25L17.75 22L15 19L16.16 17.84L17.75 19.43L21.34 15.84L22.5 17.25Z" />
                        </svg>
                    </span>
                    <span class="text">Item</span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav {{(Request::routeIs('item.*') or Request::routeIs('itemreq.*')) ? 'show' : '' }}">
                    <li>
                        <a href="{{route('item.index')}}" class="mb-1 {{ Request::routeIs('item.*') ? 'active' : '' }}"> Item Data </a>
                        <a href="{{route('itemreq.index')}}" class="mb-1 {{ Request::routeIs('itemreq.*') ? 'active' : '' }}"> Item Requisition </a>
                        <a href="{{route('itemproc.index')}}" class="mb-1 {{ Request::routeIs('itemproc.*') ? 'active' : '' }}"> Item Procurement </a>
                        <a href="{{route('itemtransfer.index')}}" class="mb-1 {{ Request::routeIs('itemtransfer.*') ? 'active' : '' }}"> Item Transfer </a>
                        <a href="{{route('itemuse.index')}}" class="mb-1 {{ Request::routeIs('itemuse.*') ? 'active' : '' }}"> Item Use </a>
                        <a href="{{route('itemdis.index')}}" class="mb-1 {{ Request::routeIs('itemdis.*') ? 'active' : '' }}"> Item Disposing </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul>
            <li class="nav-item {{ Request::routeIs('category.index') ? 'active' : '' }}">
                <a href="{{route('category.index')}}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Category</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="nav-item {{ Request::routeIs('project.index') ? 'active' : '' }}">
                <a href="{{route('project.index')}}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Project</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->