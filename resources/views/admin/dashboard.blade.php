<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Seeker Admin Dashboard</title>
    <!-- FontAwesome para sa mga Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
    <style>
        /* Custom layout adjustment para ma-inline ang tanang cards ug walay card sa kilid sa tables */
        .top-cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .full-width-section {
            width: 100%;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- SIDEBAR -->
        <aside class="sidebar" style="display: flex; flex-direction: column; justify-content: between; min-height: 100vh;">
            <div>
                <div class="brand">
                    <i class="fa-solid fa-droplet brand-icon"></i>
                    <div class="brand-text">
                        <span>WATER</span>
                        <span>SEEKER</span>
                    </div>
                </div>

                <ul class="nav-menu">
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.water-sources*') ? 'active' : '' }}">
                        <a href="{{ route('admin.water-sources') }}"><i class="fa-solid fa-faucet-drip"></i> Water Source Management</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.access-requests*') ? 'active' : '' }}">
                        <a href="{{ route('admin.access-requests') }}"><i class="fa-solid fa-clipboard-list"></i> Water Access Requests</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.schedule-management*') ? 'active' : '' }}">
                        <a href="{{ route('admin.schedule-management') }}"><i class="fa-solid fa-calendar-days"></i> Schedule Management</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.access-records*') ? 'active' : '' }}">
                        <a href="{{ route('admin.access-records') }}"><i class="fa-solid fa-folder-open"></i> Access Records</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.user-management*') ? 'active' : '' }}">
                        <a href="{{ route('admin.user-management') }}"><i class="fa-solid fa-user-plus"></i> User Management</a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <a href="{{ route('admin.reports') }}"><i class="fa-solid fa-file-lines"></i> Reports</a>
                    </li>   
                </ul>
            </div>

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

        <!-- MAIN CONTENT AREA -->
        <main class="main-content">
            <!-- TOP NAVBAR -->
            <header class="top-navbar">
                <h1 class="page-title">WATER SOURCE MANAGEMENT</h1>
                <div class="navbar-right" style="position: relative;">
                    <!-- Search Box -->
                    <div class="search-box">
                        <i class="fa-solid fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search water sources...">
                    </div>

                    <!-- Notification Bell -->
                    <div class="notification-container" style="position: relative; cursor: pointer;">
                        <i class="fa-solid fa-bell notification-icon" id="notificationBtn" style="font-size: 18px; color: #FFFFFF;"></i>
                        <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%; display: inline-block;">{{ $pendingApprovalsCount ?? 0 }}</span>
                        
                        <div id="notificationDropdown" style="display: none; position: absolute; right: 0; top: 35px; width: 280px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">
                            <div style="background: #0d4c5c; color: white; padding: 10px 15px; font-size: 13px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
                                <span>Notifications</span>
                                <span style="font-size: 10px; background: #2ADED4; color: #07303a; padding: 2px 6px; border-radius: 4px;">{{ $pendingApprovalsCount ?? 0 }} Pending</span>
                            </div>
                            <div style="max-height: 250px; overflow-y: auto;">
                                <div style="padding: 10px 15px; border-bottom: 1px solid #f1f1f1; font-size: 12px; color: #333;">
                                    <strong>Pending Requests</strong><br>
                                    <span style="color: #78909c;">You have {{ $pendingApprovalsCount ?? 0 }} pending access requests awaiting review.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="user-profile-container" style="position: relative; cursor: pointer; display: inline-block;">
                        <div class="user-profile" id="profileBtn" style="display: flex; align-items: center; gap: 8px;">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="User Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                            <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #FFFFFF;"></i>
                        </div>

                        <div id="profileDropdown" style="display: none; position: absolute; right: 0; top: 45px; width: 220px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">
                            <div style="background: #0d4c5c; color: white; padding: 12px 15px;">
                                <p style="font-size: 13px; font-weight: bold; margin: 0;">{{ Auth::user()->name ?? 'Administrator' }}</p>
                                <p style="font-size: 11px; color: #2ADED4; margin: 2px 0 0 0;">{{ Auth::user()->email ?? 'admin@waterseeker.com' }}</p>
                            </div>
                            <div style="padding: 5px 0;">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="width: 100%; background: none; border: none; display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #e74c3c; text-decoration: none; cursor: pointer;">
                                        <i class="fa-solid fa-right-from-bracket" style="width: 15px;"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- DASHBOARD CONTENT -->
            <div class="dashboard-grid" style="display: block;">
                
                <!-- 1. TANANG STAT CARDS NA-LINYA SA TAAS -->
                <div class="top-cards-row">
                    <!-- Pending Approvals Card -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <i class="fa-solid fa-file-invoice stat-icon"></i>
                            <span class="stat-title">Pending Approvals</span>
                        </div>
                        <div class="stat-body">
                            <h2>{{ $pendingApprovalsCount ?? 0 }}</h2>
                            <div class="mini-chart"><i class="fa-solid fa-chart-line"></i></div>
                        </div>
                    </div>

                    <!-- Active Sources Card -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <i class="fa-solid fa-water stat-icon"></i>
                            <span class="stat-title">Active Sources</span>
                        </div>
                        <div class="stat-body">
                            <h2>{{ $activeSourcesCount ?? 0 }}</h2>
                            <div class="mini-chart"><i class="fa-solid fa-chart-line"></i></div>
                        </div>
                    </div>

                    <!-- Access Records Summary Card -->
                    <div class="card stat-card">
                        <div class="card-header-flex">
                            <i class="fa-solid fa-folder-open stat-icon"></i>
                            <span class="stat-title">Access Records</span>
                        </div>
                        <div class="stat-body">
                            <h2>{{ $accessRecordsCount ?? 0 }}</h2>
                            <div class="mini-chart"><i class="fa-solid fa-chart-line"></i></div>
                        </div>
                    </div>
                </div>

                <!-- 2. ACCESS ACTIVITY LOG (FULL WIDTH) -->
                <div class="full-width-section">
                    <div class="card table-card">
                        <div class="card-title-action">
                            <h3>Access Activity Log</h3>
                            <a href="{{ route('admin.access-records') }}" class="show-all">Show all</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Source</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activityLogs ?? [] as $log)
                                    <tr>
                                        <td>{{ $log->submitted_at ? \Carbon\Carbon::parse($log->submitted_at)->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $log->user_name ?? 'N/A' }}</td>
                                        <td>{{ $log->requested_source ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $status = strtolower($log->status ?? 'pending');
                                            @endphp
                                            <span class="badge {{ $status == 'approved' ? 'approved' : 'pending' }}">
                                                {{ $log->status ?? 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #546E7A; padding: 15px;">No recent activity logs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. ACCESS REQUEST APPROVALS -->
                <div class="full-width-section">
                    <div class="card table-card large-table">
                        <h3>Access Request Approvals</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Source</th>
                                    <th>Request Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingRequests ?? [] as $req)
                                    <tr>
                                        <td>{{ $req->submitted_at ? \Carbon\Carbon::parse($req->submitted_at)->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $req->user_name ?? 'N/A' }}</td>
                                        <td>{{ $req->requested_source ?? 'N/A' }}</td>
                                        <td>Residential Access</td>
                                        <td>
                                            <form action="{{ route('admin.access-requests.update-status', $req->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="Approved">
                                                <button type="submit" class="btn-approve">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.access-requests.update-status', $req->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="Declined">
                                                <button type="submit" class="btn-decline">Decline</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; color: #546E7A; padding: 15px;">No pending request approvals found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="view-all-footer">
                            <a href="{{ route('admin.request-approvals') }}">View All Pending Approvals</a>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <footer class="dashboard-footer">
                    <span>Powered by Water Seeker Admin</span>
                    <span>avemateiu.com</span>
                </footer>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                const term = e.target.value.toLowerCase().trim();
                const items = document.querySelectorAll('.table-card tbody tr');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    item.style.display = (text.includes(term) || term === '') ? '' : 'none';
                });
            });
        }

        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
            });
        }

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
            });
        }

        document.addEventListener('click', function (e) {
            if (notificationDropdown) notificationDropdown.style.display = 'none';
            if (profileDropdown) profileDropdown.style.display = 'none';
        });
    });
    </script>
</body>
</html>