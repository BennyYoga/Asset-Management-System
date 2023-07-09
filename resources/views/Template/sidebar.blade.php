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
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ Request::routeIs('location.index') ? 'active' : '' }}">
                <a href="{{route('location.index')}}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Locations</span>
                </a>
            </li>
            <li class="nav-item nav-item-has-children {{Request::routeIs('item.*') ? 'active' : '' }}">
                <a href="#0" class="collapsed" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path fill="currentColor" d="M16 17V19H2V17S2 13 9 13 16 17 16 17M12.5 7.5A3.5 3.5 0 1 0 9 11A3.5 3.5 0 0 0 12.5 7.5M15.94 13A5.32 5.32 0 0 1 18 17V19H22V17S22 13.37 15.94 13M15 4A3.39 3.39 0 0 0 13.07 4.59A5 5 0 0 1 13.07 10.41A3.39 3.39 0 0 0 15 11A3.5 3.5 0 0 0 15 4Z" />
                        </svg>
                    </span>
                    <span class="text">Item</span>
                </a>
                <ul id="ddmenu_1" class="collapse dropdown-nav {{(Request::routeIs('item.*') or Request::routeIs('itemreq.*')) ? 'show' : '' }}">
                    <li>
                        <a href="{{route('item.index')}}" class="mb-1 {{ Request::routeIs('item.*') ? 'active' : '' }}"> Item Data </a>
                        <a href="{{route('itemreq.index')}}" class="mb-1 {{ Request::routeIs('itemreq.*') ? 'active' : '' }}"> Item Requisition </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->