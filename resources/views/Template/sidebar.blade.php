<!-- ======== sidebar-nav start =========== -->
@php
    $menu = session('menu');
    $role = session('role')->RoleName;
@endphp
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            @if($role === 'SuperAdmin')
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
            @endif
            @if($menu->contains('MenuId', 7.2) || $role === 'SuperAdmin' || $role === 'Admin Local')
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
            @endif
        </ul>
        <ul>
            <li class="nav-item {{ Request::routeIs('item.index') ? 'active' : '' }}">
            </li>
            @if($menu->contains('MenuId', 9) || $role === 'SuperAdmin' || $role === 'Admin Local')
            <li class="nav-item nav-item-has-children {{Request::routeIs('item.*') ? 'active' : '' }}">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M21 3H3V9H21V3M19 7H5V5H19V7M14.5 11C14.78 11 15 11.22 15 11.5V13H9V11.5C9 11.22 9.22 11 9.5 11H14.5M18 13.09V10H20V13.09C19.67 13.04 19.34 13 19 13C18.66 13 18.33 13.04 18 13.09M13 19C13 19.7 13.13 20.37 13.35 21H4V10H6V19H13M22.5 17.25L17.75 22L15 19L16.16 17.84L17.75 19.43L21.34 15.84L22.5 17.25Z" />
                        </svg>
                    </span>
                    <span class="text">Item</span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav {{(Request::routeIs('item.*') or Request::routeIs('category.*')) ? 'show' : '' }}">
                    <li>
                        <a href="{{route('category.index')}}" class="mb-1 {{ Request::routeIs('category.*') ? 'active' : '' }}"> Category </a>
                        <a href="{{route('item.index')}}" class="mb-1 {{ Request::routeIs('item.*') ? 'active' : '' }}"> Item </a>
                    </li>
                </ul>
                @endif
        @if($role === 'SuperAdmin' || $role === 'Admin Local')
        <ul>
            <li class="nav-item {{ Request::routeIs('user.index') ? 'active' : '' }}">
                <a href="{{route('user.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                           <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                        </svg>
                    </span>
                    <span class="text">User</span>
                </a>
            </li>
        </ul>
        @endif
        <ul>
        @if($role === 'SuperAdmin' || $role === 'Admin Local')
            <li class="nav-item {{ Request::routeIs('project.index') ? 'active' : '' }}">
                <a href="{{route('project.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                        <path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1Zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5v-1Zm-2 0h1v1A2.5 2.5 0 0 0 6.5 5h3A2.5 2.5 0 0 0 12 2.5v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2Z"/>
                        </svg>
                    </span>
                    <span class="text">Project</span>
                </a>
            </li>
        @endif
        </ul>
        <ul>
        @if($role === 'SuperAdmin' || $role === 'Admin Local')
            <li class="nav-item nav-item-has-children {{Request::routeIs('item.*') ? 'active' : '' }}">
                <a href="#1" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M21 3H3V9H21V3M19 7H5V5H19V7M14.5 11C14.78 11 15 11.22 15 11.5V13H9V11.5C9 11.22 9.22 11 9.5 11H14.5M18 13.09V10H20V13.09C19.67 13.04 19.34 13 19 13C18.66 13 18.33 13.04 18 13.09M13 19C13 19.7 13.13 20.37 13.35 21H4V10H6V19H13M22.5 17.25L17.75 22L15 19L16.16 17.84L17.75 19.43L21.34 15.84L22.5 17.25Z" />
                        </svg>
                    </span>
                    <span class="text">Request</span>
                </a>
                <ul id="ddmenu_2" class="collapse dropdown-nav {{(Request::routeIs('item.*') or Request::routeIs('itemreq.*','itemproc.*','itemtransfer.*','itemuse.*','itemdis.*')) ? 'show' : '' }}">
                    <li>
                        <a href="{{route('itemreq.index')}}" class="mb-1 {{ Request::routeIs('itemreq.*') ? 'active' : '' }}"> Requisition </a>
                        <a href="{{route('itemproc.index')}}" class="mb-1 {{ Request::routeIs('itemproc.*') ? 'active' : '' }}"> Procurement </a>
                        <a href="{{route('itemtransfer.index')}}" class="mb-1 {{ Request::routeIs('itemtransfer.*') ? 'active' : '' }}"> Transfer </a>
                        <a href="{{route('itemuse.index')}}" class="mb-1 {{ Request::routeIs('itemuse.*') ? 'active' : '' }}"> Use </a>
                        <a href="{{route('item.index')}}" class="mb-1 {{ Request::routeIs('item.*') ? 'active' : '' }}"> Maintenance </a>
                        <a href="{{route('itemdis.index')}}" class="mb-1 {{ Request::routeIs('itemdis.*') ? 'active' : '' }}"> Disposing </a>
                    </li>
                </ul>
            </li>
        @endif
        </ul>
        <ul>
            </li>
            <li class="nav-item nav-item-has-children {{Request::routeIs('item.*') ? 'active' : '' }}">
                <a href="#2" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_3" aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M21 3H3V9H21V3M19 7H5V5H19V7M14.5 11C14.78 11 15 11.22 15 11.5V13H9V11.5C9 11.22 9.22 11 9.5 11H14.5M18 13.09V10H20V13.09C19.67 13.04 19.34 13 19 13C18.66 13 18.33 13.04 18 13.09M13 19C13 19.7 13.13 20.37 13.35 21H4V10H6V19H13M22.5 17.25L17.75 22L15 19L16.16 17.84L17.75 19.43L21.34 15.84L22.5 17.25Z" />
                        </svg>
                    </span>
                    <span class="text">Approval</span>
                </a>
                <ul id="ddmenu_3" class="collapse dropdown-nav {{(Request::routeIs('item.*') or Request::routeIs('itemreq.*','itemproc.*','itemtransfer.*','itemuse.*','itemdis.*')) ? 'show' : '' }}">
                    <li>
                        <a href="{{route('itemreq.index')}}" class="mb-1 {{ Request::routeIs('itemreq.*') ? 'active' : '' }}"> Requisition </a>
                        <a href="{{route('itemproc.index')}}" class="mb-1 {{ Request::routeIs('itemproc.*') ? 'active' : '' }}"> Procurement </a>
                        <a href="{{route('itemtransfer.index')}}" class="mb-1 {{ Request::routeIs('itemtransfer.*') ? 'active' : '' }}"> Transfer </a>
                        <a href="{{route('itemuse.index')}}" class="mb-1 {{ Request::routeIs('itemuse.*') ? 'active' : '' }}"> Use </a>
                        <a href="{{route('item.index')}}" class="mb-1 {{ Request::routeIs('item.*') ? 'active' : '' }}"> Maintenance </a>
                        <a href="{{route('itemdis.index')}}" class="mb-1 {{ Request::routeIs('itemdis.*') ? 'active' : '' }}"> Disposing </a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul>
            <li class="nav-item {{ Request::routeIs('inventory.index') ? 'active' : '' }}">
                <a href="{{route('inventory.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                            <path d="M12,18.54L19.37,12.8L21,14.07L12,21.07L3,14.07L4.62,12.81L12,18.54M12,16L3,9L12,2L21,9L12,16M12,4.53L6.26,9L12,13.47L17.74,9L12,4.53Z" />
                        </svg>
                    </span>
                    <span class="text">Inventory</span>
                </a>
            </li>
        </ul>

        <ul>
            <li class="nav-item {{ Request::routeIs('role.index') ? 'active' : '' }}">
                <a href="{{route('role.index')}}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                        </svg>
                    </span>
                    <span class="text">Role</span>
                </a>
            </li>
        </ul>
        <li class="nav-item {{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{route('dashboard.index')}}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('dashboard.index') ? 'active' : '' }}">
                <a href="{{route('dashboard.index')}}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Settings</span>
                </a>
            </li>
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->