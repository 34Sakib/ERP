<header class="top-navbar">
    <div class="d-flex align-items-center gap-3">
        <!-- Company/Branch Switcher Control -->
        <button class="btn btn-secondary-custom btn-sm d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-building text-success"></i>
            <span class="fw-bold fs-7 text-dark">{{ auth()->user()?->company?->name ?? 'Acme Global Corp' }}</span>
            <span class="text-muted">/</span>
            <span class="text-secondary fs-7">{{ auth()->user()?->branch?->name ?? 'HQ Branch' }}</span>
            <i class="bi bi-chevron-down ms-1 fs-8 text-muted"></i>
        </button>
        <ul class="dropdown-menu shadow-sm border fs-7">
            <li><h6 class="dropdown-header">Switch Branch</h6></li>
            <li><a class="dropdown-item active" href="#">Headquarters (HQ)</a></li>
            <li><a class="dropdown-item" href="#">Regional Office West</a></li>
        </ul>
    </div>

    <div class="d-flex align-items-center gap-3">
        <!-- Notification Bell with Burnt Orange Badge Count -->
        <div class="dropdown">
            <button class="btn btn-secondary-custom btn-sm position-relative p-2 rounded-circle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-bell text-secondary"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill fs-8" style="background-color: var(--cta-orange); color: #fff; font-size: 0.65rem !important;">
                    3
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow border p-0" style="width: 320px; border-color: var(--border-color) !important;">
                <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold fs-7">Notifications</h6>
                    <span class="badge badge-pill-forest">3 New</span>
                </div>
                <div class="list-group list-group-flush fs-7">
                    <a href="#" class="list-group-item list-group-item-action p-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1 fs-7 fw-bold">Leave Request Pending</h6>
                            <small class="text-muted fs-8">10m</small>
                        </div>
                        <p class="mb-1 text-muted fs-8">John Doe submitted 3-day leave request.</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div class="avatar-initials avatar-forest">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 2)) }}
                </div>
                <div class="d-none d-md-block text-start">
                    <div class="fw-bold text-dark leading-none fs-7">{{ auth()->user()?->name ?? 'Admin User' }}</div>
                    <div class="fs-8 text-muted mt-1">
                        {{ auth()->user()?->getRoleNames()->first() ?? 'Super Admin' }}
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border">
                <li>
                    <div class="px-3 py-2 border-bottom">
                        <div class="fw-bold fs-7">{{ auth()->user()?->name }}</div>
                        <div class="fs-8 text-muted">{{ auth()->user()?->email }}</div>
                    </div>
                </li>
                <li><a class="dropdown-item fs-7" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item fs-7 text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
