<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center justify-content-center rounded-2" style="width: 30px; height: 30px; background-color: var(--primary-forest); color: #fff;">
            <i class="bi bi-tree-fill fs-7"></i>
        </div>
        <span style="font-weight: 800; letter-spacing: -0.02em;">ENTERPRISE ERP</span>
    </div>

    <!-- Search in Sidebar -->
    <div class="px-3 pt-3 pb-2">
        <div class="position-relative">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 fs-8 text-muted"></i>
            <input type="text" id="sidebarSearch" class="form-control form-control-sm ps-4 text-white border-0 fs-8" placeholder="Search modules... (⌘K)" style="background-color: rgba(255,255,255,0.06) !important; color: #fff !important;">
        </div>
    </div>

    <ul class="sidebar-menu">
        @php
            $sidebarConfig = config('sidebar.items', []);
        @endphp

        @foreach($sidebarConfig as $item)
            @php
                $hasChildren = !empty($item['children']);
                $permission = $item['permission'] ?? null;
                $canViewParent = !$permission || (auth()->check() && auth()->user()->can($permission));

                if ($hasChildren && !$canViewParent) {
                    foreach ($item['children'] as $child) {
                        if (empty($child['permission']) || (auth()->check() && auth()->user()->can($child['permission']))) {
                            $canViewParent = true;
                            break;
                        }
                    }
                }
            @endphp

            @if($canViewParent)
                @if($hasChildren)
                    @php
                        $collapseId = 'menu-' . Str::slug($item['label']);
                        $isParentActive = false;
                        foreach($item['children'] as $child) {
                            if (isset($child['route']) && Route::has($child['route']) && request()->routeIs($child['route'])) {
                                $isParentActive = true;
                                break;
                            }
                        }
                    @endphp
                    <li class="nav-item menu-entry">
                        <a class="nav-link {{ $isParentActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button" aria-expanded="{{ $isParentActive ? 'true' : 'false' }}">
                            <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                            <span>{{ $item['label'] }}</span>
                            <i class="bi bi-chevron-down ms-auto fs-8 opacity-50"></i>
                        </a>
                        <div class="collapse {{ $isParentActive ? 'show' : '' }}" id="{{ $collapseId }}">
                            <ul class="nav flex-column ps-1">
                                @foreach($item['children'] as $child)
                                    @php
                                        $childPermission = $child['permission'] ?? null;
                                        $canViewChild = !$childPermission || (auth()->check() && auth()->user()->can($childPermission));
                                    @endphp
                                    @if($canViewChild)
                                        <li class="nav-item">
                                            <a href="{{ isset($child['route']) && Route::has($child['route']) ? route($child['route']) : '#' }}" 
                                               class="nav-link {{ isset($child['route']) && Route::has($child['route']) && request()->routeIs($child['route']) ? 'active' : '' }}">
                                                <span>{{ $child['label'] }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item menu-entry">
                        <a href="{{ isset($item['route']) && Route::has($item['route']) ? route($item['route']) : '#' }}" 
                           class="nav-link {{ isset($item['route']) && Route::has($item['route']) && request()->routeIs($item['route']) ? 'active' : '' }}">
                            <i class="{{ $item['icon'] ?? 'bi bi-circle' }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</aside>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('sidebarSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                document.querySelectorAll('.menu-entry').forEach(el => {
                    const text = el.textContent.toLowerCase();
                    el.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }
    });
</script>
