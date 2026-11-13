@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\ManagedUser[] $users */
    /** @var int $totalUsers */
    /** @var int $activeUsers */
    /** @var int $inactiveUsers */
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Water Seeker Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
    <style>
        .alert-popup {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">
            <i class="fa-solid fa-tint brand-icon"></i>
            <div class="brand-text">
                <span>WATER</span>
                <span>SEEKER</span>
            </div>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.water-sources') }}"><i class="fa-solid fa-faucet-drip"></i> Water Source Management</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.access-requests') }}"><i class="fa-solid fa-clipboard-list"></i> Water Access Requests</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.schedule-management') }}"><i class="fa-solid fa-calendar-days"></i> Schedule Management</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.access-records') }}"><i class="fa-solid fa-folder-open"></i> Access Records</a>
            </li>
            <li class="nav-item active">
                <a href="{{ route('admin.user-management') }}"><i class="fa-solid fa-user-plus"></i> User Management</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports') }}"><i class="fa-solid fa-file-lines"></i> Reports</a>
            </li>
        </ul>
         <!-- Logout Form inside Sidebar -->
            <div style="padding: 20px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="width: 100%; background: rgba(255,255,255,0.1); border: none; color: #fff; padding: 10px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 13px;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <h1 class="page-title">USER MANAGEMENT</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users...">
                </div>

                <!-- Notification Bell -->
                <div class="notification-container" style="position: relative; cursor: pointer;">
                    <i class="fa-solid fa-bell notification-icon" id="notificationBtn" style="font-size: 18px; color: #FFFFFF;"></i>
                    <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%; display: inline-block;">2</span>
                </div>

                <!-- User Profile -->
                <div class="user-profile-container" style="position: relative; cursor: pointer; display: inline-block;">
                    <div class="user-profile" id="profileBtn" style="display: flex; align-items: center; gap: 8px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="User Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #FFFFFF;"></i>
                    </div>

                    <div id="profileDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 220px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">
                        <div style="background: #0d4c5c; color: white; padding: 12px 15px;">
                            <p style="font-size: 13px; font-weight: bold; margin: 0;">{{ Auth::user()->name ?? 'Community User' }}</p>
                            <p style="font-size: 11px; color: #2ADED4; margin: 2px 0 0 0;">{{ Auth::user()->email ?? 'user@waterseeker.com' }}</p>
                        </div>
                        <div style="padding: 5px 0;">
                            <a href="{{ route('logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #e74c3c; text-decoration: none;">
                                <i class="fa-solid fa-right-from-bracket" style="width: 15px;"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="dashboard-grid">

            <!-- SUCCESS POPUP ALERT MESSAGE -->
            @if (session('success'))
                <div class="alert-popup" id="successAlert">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #28a745;"></i>
                        <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.style.display='none';" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #155724;">&times;</button>
                </div>
            @endif

            <!-- SUMMARY STAT CARDS -->
            <div class="stat-grid-users">
                <div class="user-stat-card">
                    <div class="user-stat-info">
                        <h4>Total Users</h4>
                        <h2>{{ $totalUsers ?? 0 }}</h2>
                    </div>
                    <i class="fa-solid fa-users user-stat-icon"></i>
                </div>
                <div class="user-stat-card active-card">
                    <div class="user-stat-info">
                        <h4>Active Users</h4>
                        <h2>{{ $activeUsers ?? 0 }}</h2>
                    </div>
                    <i class="fa-solid fa-user-check user-stat-icon"></i>
                </div>
                <div class="user-stat-card inactive-card">
                    <div class="user-stat-info">
                        <h4>Inactive Users</h4>
                        <h2>{{ $inactiveUsers ?? 0 }}</h2>
                    </div>
                    <i class="fa-solid fa-user-xmark user-stat-icon" style="color: #c0392b;"></i>
                </div>
            </div>

            <!-- USER MANAGEMENT MAIN CARD -->
            <div class="card table-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Account Directory</h3>
                        <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Manage user accounts, assign roles, and control system access levels.</p>
                    </div>
                    <button class="btn-add" id="openAddUserModalBtn" style="background-color: #0d4c5c; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-user-plus"></i> Add User
                    </button>
                </div>

                <!-- USER LIST TABLE -->
                <table id="userTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email / Contact</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users ?? [] as $user)
                            <tr data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-status="{{ $user->status }}">

                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <span class="badge {{ $user->status === 'Active' ? 'active' : 'inactive-status' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn-view-user" onclick="viewEditUser(this)">
                                        <i class="fa-solid fa-pen-to-square"></i> View / Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 15px; color: #546E7A;">No user accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FOOTER -->
            <footer class="dashboard-footer">
                <span>Powered by Water Seeker Admin</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<!-- ADD / EDIT USER MODAL -->
<div class="modal-overlay" id="userModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 450px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalTitle" style="font-size: 16px; color: #07303a;">User Details & Information</h3>
            <button class="close-modal" type="button" onclick="closeUserModal()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">&times;</button>
        </div>
        
        <form id="userForm" action="{{ route('admin.user-management.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="id" id="userId">

            <div class="form-group" style="margin-bottom: 12px;">
                <label>Full Name</label>
                <input type="text" name="name" id="userName" required maxlength="255" placeholder="e.g. Juan Dela Cruz" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label>Email Address / Contact</label>
                <input type="email" name="email" id="userEmail" required maxlength="255" placeholder="user@example.com" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
                <label>Assigned Role</label>
                <select name="role" id="userRole" onchange="verifyRoleAuthorization()" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Water Seeker">Water Seeker</option>
                    <option value="Administrator">Administrator</option>
                </select>
                <p class="role-select-warning" id="roleWarning" style="display: none; color: #e74c3c; font-size: 11px; margin-top: 4px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Security Note: Granting Administrator access requires authorized credentials.
                </p>
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label>Account Status</label>
                <select name="status" id="userStatus" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Active">Active (Allowed to Log In)</option>
                    <option value="Inactive">Inactive (Disabled Account)</option>
                </select>
            </div>

            <div class="modal-actions" style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeUserModal()" style="padding: 8px 15px; background: #ccc; border: none; border-radius: 4px; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 8px 15px; background: #0d4c5c; color: white; border: none; border-radius: 4px; cursor: pointer;">Save User Account</button>
            </div>
        </form>
    </div>
</div>

<!-- INTERNAL JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addButton = document.getElementById('openAddUserModalBtn');
    const modal = document.getElementById('userModal');

    if (addButton) {
        addButton.addEventListener('click', openAddModal);
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeUserModal();
            }
        });
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#userTable tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    }

    setTimeout(function() {
        const alertPopup = document.getElementById('successAlert');
        if (alertPopup) {
            alertPopup.style.transition = 'opacity 0.5s ease';
            alertPopup.style.opacity = '0';
            setTimeout(() => alertPopup.remove(), 500);
        }
    }, 4000);
});

function openAddModal() {
    const form = document.getElementById('userForm');
    form.reset();
    form.action = "{{ route('admin.user-management.store') }}";

    document.getElementById('formMethod').value = 'POST';
    document.getElementById('userId').value = '';
    document.getElementById('modalTitle').innerText = 'Add New User Account';
    document.getElementById('roleWarning').style.display = 'none';
    document.getElementById('userModal').style.display = 'flex';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

function viewEditUser(button) {
    const row = button.closest('tr');
    const id = row.dataset.id;

    if (!id || !Number.isInteger(Number(id))) {
        alert('Invalid user ID. Please refresh the page.');
        return;
    }

    const form = document.getElementById('userForm');
    form.action = `/admin/user-management/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('userId').value = id;
    document.getElementById('userName').value = row.dataset.name;
    document.getElementById('userEmail').value = row.dataset.email;
    document.getElementById('userRole').value = row.dataset.role;
    document.getElementById('userStatus').value = row.dataset.status;
    document.getElementById('modalTitle').innerText = 'Edit User Account';

    verifyRoleAuthorization();
    document.getElementById('userModal').style.display = 'flex';
}

function verifyRoleAuthorization() {
    const role = document.getElementById('userRole').value;
    const warning = document.getElementById('roleWarning');
    warning.style.display = role === 'Administrator' ? 'block' : 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function (e) {
            if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                profileDropdown.style.display = 'none';
            }
        });
    }
});
</script>

</body>
</html>