<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
<style>
    /* Giữ bố cục cũ nhưng tinh chỉnh responsive & toggle */
    .sidebar-toggle-btn {
        position: fixed;
        left: 13.6rem;
        top: 1rem;
        z-index: 1031;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .sidebar-toggle-btn .arrow-icon {
        transition: transform 0.2s ease;
    }

    /* Thu gọn sidebar: vẫn hiển thị icon, ẩn text */
    .layout.sidebar-collapsed aside.navbar-vertical {
        width: 72px;
        min-width: 72px;
    }

    .layout.sidebar-collapsed .navbar-brand-image {
        width: 48px !important;
        height: 48px !important;
        object-fit: cover;
    }

    .layout.sidebar-collapsed .admin-info,
    .layout.sidebar-collapsed .nav-link-title,
    .layout.sidebar-collapsed .dropdown-menu {
        display: none !important;
    }

    .layout.sidebar-collapsed .navbar-nav.pt-lg-3 {
        align-items: center;
    }

    .layout.sidebar-collapsed .sidebar-toggle-btn .arrow-icon {
        transform: rotate(180deg);
    }

    /* Mobile: dùng collapse sẵn có, ẩn nút toggle rời */
    @media (max-width: 991.98px) {
        .sidebar-toggle-btn {
            display: none !important;
        }
    }
</style>
<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <x-link :href="route('admin.profile.index')">
                <img src="{{ asset(auth('admin')->user()->avatar ?? 'assets/images/default-avatar.png') }}"
                    width="200" height="200" alt="Tabler" class="navbar-brand-image">
            </x-link>
        </h1>
        <div class="admin-info">
            @php
                $admin = auth('admin')->user();
            @endphp
            <span class="admin-name">{{ $admin->fullname ?? 'Admin' }}</span>
            <span class="admin-role">{{ $admin->roles[0]->name ?? 'Role not set' }}</span>
        </div>
        <div class="navbar-nav d-lg-none flex-row">
            @include('admin.layouts.partials.account')
        </div>

        <div class="navbar-collapse collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @foreach ($menu as $item)
                    @php
                        $user = auth('admin')->user();
                        $hasRole =
                            empty($item['roles']) ||
                            collect($item['roles'])
                                ->intersect($user->roles->pluck('name'))
                                ->isNotEmpty();
                        $hasPermission =
                            empty($item['permissions']) ||
                            $user->checkPermissions($item['permissions']) ||
                            in_array('mevivuDev', $item['permissions']);

                        $visibleSub = collect($item['sub'] ?? [])->filter(function ($subItem) use ($user) {
                            $hasSubRole =
                                empty($subItem['roles']) ||
                                collect($subItem['roles'])
                                    ->intersect($user->roles->pluck('name'))
                                    ->isNotEmpty();
                            $hasSubPermission =
                                empty($subItem['permissions']) ||
                                $user->checkPermissions($subItem['permissions']) ||
                                in_array('mevivuDev', $subItem['permissions']);
                            return $hasSubRole && $hasSubPermission;
                        });

                        $hasVisibleSub = $visibleSub->isNotEmpty();
                    @endphp

                    @if ($hasRole && $hasPermission)
                        <li @class(['nav-item', 'dropdown' => $hasVisibleSub])>
                            <x-admin-item-link-sidebar-left class="nav-link" :href="$routeName($item['routeName'], $item['param'] ?? [])" :dropdown="$hasVisibleSub">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    {!! __($item['icon']) !!}
                                </span>
                                <span class="nav-link-title">
                                    {{ __($item['title']) }}
                                </span>
                            </x-admin-item-link-sidebar-left>

                            @if ($hasVisibleSub)
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            @foreach ($visibleSub as $subItem)
                                                <x-admin-item-link-sidebar-left class="dropdown-item" :href="$routeName($subItem['routeName'], $subItem['param'] ?? [])">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        {!! __($subItem['icon']) !!}
                                                    </span>
                                                    <span class="nav-link-title">
                                                        {{ __($subItem['title']) }}
                                                    </span>
                                                </x-admin-item-link-sidebar-left>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</aside>

<!-- Nút Toggle -->
<button class="sidebar-toggle-btn d-none d-md-block">
    <span class="arrow-icon"><i class="ti ti-triangle-filled"></i></span>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('aside');
        const toggleBtn = document.querySelector('.sidebar-toggle-btn');
        const arrowIcon = toggleBtn.querySelector('.arrow-icon');
        const layout = document.querySelector('.layout'); // Container chung

        toggleBtn.addEventListener('click', function() {
            layout.classList.toggle('sidebar-collapsed');
        });
    });
</script>
