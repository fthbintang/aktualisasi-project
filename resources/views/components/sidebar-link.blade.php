@props(['href', 'icon', 'label'])

@php
    $path = ltrim(parse_url($href, PHP_URL_PATH), '/');

    if ($path === 'dashboard') {
        $isActive = request()->is($path) ? 'active' : '';
    } else {
        $isActive = request()->is($path) || request()->is($path . '/*') ? 'active' : '';
    }
@endphp

<li class="nav-item">
    <a class="nav-link {{ $isActive }}" href="{{ $href }}">
        <div
            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="{{ $icon }} text-dark text-sm opacity-10"></i>
        </div>
        <span class="nav-link-text ms-1">{{ $label }}</span>
    </a>
</li>
