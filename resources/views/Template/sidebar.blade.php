<!-- ======== sidebar-nav start =========== -->
@php
    $menu = session('menu');
    $role = session('role')->RoleName;
@endphp
<head>
@push('css')
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
@endpush
</head>

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo" style="text-align: left">
        <a href="index.html">
            <img src="{{asset('images/logo/logo.svg')}}" class="w-100" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
        @foreach($menu as $menuItem)
        <li class="nav-item {{ Request($menuItem->MenuUrl) ? 'active' : '' }}">
            <a href="{{ $menuItem->MenuUrl}}">
                <span class="icon"> 
                    <i class="fa fa-home" aria-hidden="true"></i>
                </span>
                <span class="text">{{$menuItem->MenuName}}</span>
            </a>
        </li>
        @endforeach
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
<!-- ======== sidebar-nav end =========== -->