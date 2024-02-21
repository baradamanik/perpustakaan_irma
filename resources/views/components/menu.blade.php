<nav class="nav flex-column">
    @foreach ($list as $item)
        <a class="nav-link {{ isset($item['children']) ? 'collapsed' : '' }}" 
           data-toggle="{{ isset($item['children']) ? 'collapse' : '' }}" 
           href="{{ isset($item['children']) ? '#'.Str::slug($item['label']) : route($item['route']) }}">
            @if (isset($item['icon'])) <!-- Tambahkan pengecekan untuk kunci 'icon' -->
                <i class="icon-menu {{ $item['icon'] }}"></i>
            @endif
            {{ $item['label'] }}
        </a>
        @if (isset($item['children']))
            <div class="collapse {{ $isActive($item['label']) ? 'show' : '' }}" id="{{ Str::slug($item['label']) }}">
            <ul>  
            @foreach ($item['children'] as $child)
                    <a class="nav-link {{ $isActive($child['label']) ? 'active' : '' }}" href="{{ route($child['route']) }}">
                        @if (isset($child['icon'])) <!-- Tambahkan pengecekan untuk kunci 'icon' -->
                            <i class="icon-menu {{ $child['icon'] }}"></i>
                        @endif
                        {{ $child['label'] }}
                    </a>
                @endforeach
</ul>
            </div>
        @endif
    @endforeach
</nav>
