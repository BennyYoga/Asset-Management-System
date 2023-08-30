@php
    $menu = session('menu');
    $currentUrl = request()->url();
    $path = parse_url($currentUrl, PHP_URL_PATH);
    $path = rtrim($path, '/');
    $slashPart = substr($path, strrpos($path, '/'));
@endphp

<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo" style="text-align: left">
        <a href="index.html">
            <img src="{{ asset('images/logo/logo.svg') }}" class="w-100" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
        @foreach($menu as $menuItem)
    @php
        $parentItems = $menu->where('ParentId', $menuItem->MenuId);
        $isActive = $slashPart == substr($menuItem->MenuUrl, strrpos($menuItem->MenuUrl, '/'));
        $isParentActive = $parentItems->contains(function ($parentItem) use ($slashPart) {
        return $slashPart == substr($parentItem->MenuUrl, strrpos($parentItem->MenuUrl, '/'));
        });
    @endphp
    @if($menuItem->ParentId == 0)
        <li class="nav-item {{ $isActive ? 'active' : '' }} {{ $parentItems->count() ? 'nav-item-has-children' : '' }}">
            <a href="{{ $menuItem->MenuUrl }}" class="{{ $parentItems->count() ? 'collapsed' : '' }}"
               @if($parentItems->count())
                   data-bs-toggle="collapse" data-bs-target="#ddmenu_{{ $menuItem->MenuId }}"
                   aria-controls="ddmenu_{{ $menuItem->MenuId }}" aria-expanded="true" aria-label="Toggle navigation"
               @endif >
                <span class="icon">
                    <i class="{{ $menuItem->MenuIcon }}" aria-hidden="true"></i>
                </span>
                <span class="text">{{ $menuItem->MenuName }}</span>
            </a>
            @if($parentItems->count())
                <ul id="ddmenu_{{ $menuItem->MenuId }}" class="collapse dropdown-nav {{$isParentActive? 'show': '' }}">
                    @foreach($parentItems as $parentItem)
                        <li class="nav-item {{ $slashPart == substr($parentItem->MenuUrl, strrpos($parentItem->MenuUrl, '/')) ? 'active' : '' }}">
                            <a href="{{ $parentItem->MenuUrl }}" >
                                <span class="icon">
                                    <i class="{{ $parentItem->MenuIcon }}" aria-hidden="true"></i>
                                </span>
                                <span class="text">{{ $parentItem->MenuName }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endforeach
        </ul>
    </nav>
</aside>
<div class="overlay"></div>
