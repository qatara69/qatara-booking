<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            {{-- @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan --}}
            @can('room_type_access')
                <li class="nav-item">
                    <a href="{{ route("admin.room-types.index") }}" class="nav-link {{ request()->is('admin/room-types') || request()->is('admin/room-types/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-cogs nav-icon">

                        </i>
                        {{ trans('cruds.roomType.title') }}
                    </a>
                </li>
            @endcan
            @can('room_access')
                <li class="nav-item">
                    <a href="{{ route("admin.rooms.index") }}" class="nav-link {{ request()->is('admin/rooms') || request()->is('admin/rooms/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-hotel nav-icon">

                        </i>
                        {{ trans('cruds.room.title') }}
                    </a>
                </li>
            @endcan
            @can('booking_access')
                <li class="nav-item">
                    <a href="{{ route("admin.bookings.index") }}" class="nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user-tag nav-icon">

                        </i>
                        {{ trans('cruds.booking.title') }}
                    </a>
                </li>
            @endcan
            @can('payment_access')
                <li class="nav-item">
                    <a href="{{ route("admin.payments.index") }}" class="nav-link {{ request()->is('admin/payments') || request()->is('admin/payments/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-money nav-icon"></i>
                        
                        Payments
                    </a>
                </li>
            @endcan
            @can('user_access')
                <li class="nav-item">
                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user nav-icon"></i>
                        {{ trans('cruds.user.title') }}
                    </a>
                </li>
            @endcan
            @if(Auth::user()->getIsAdminAttribute())
            <li class="nav-item">
                <a href="{{ route("admin.users.login_info") }}" class="nav-link {{ request()->is('admin/login-info') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-info-circle nav-icon">

                    </i>
                    Login Info
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>