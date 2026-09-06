<nav id="sidebar">
    <div class="brand">
        <i class="bi bi-grid-3x3-gap-fill me-2"></i>TaskManager
    </div>

    <ul class="nav flex-column mt-2">

        {{-- MAIN --}}
        <li class="nav-section">Main</li>

        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('profile.edit') }}"
               class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
        </li>

        {{-- ADMIN --}}
        <li class="nav-section">Admin</li>

        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.roles.index') }}"
               class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i> Roles Management
            </a>
        </li>

        {{-- WORK --}}
        <li class="nav-section">Work</li>

        <li class="nav-item">
            <a href="{{ route('admin.projects.index') }}"
               class="nav-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <i class="bi bi-kanban"></i> Projects
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.tasks.index') }}"
               class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i> Tasks
            </a>
        </li>

    </ul>
</nav>