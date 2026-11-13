<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Records - Water Seeker Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
</head>
<body>

<div class="dashboard-container">
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
            <li class="nav-item active">
                <a href="{{ route('admin.access-records') }}"><i class="fa-solid fa-folder-open"></i> Access Records</a>
            </li>
            <li class="nav-item">
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

    <div class="main-content">
        <header class="top-navbar">
            <h1 class="page-title">WATER SOURCE MANAGEMENT</h1>
            <div class="navbar-right" style="position: relative;">
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search water sources...">
                </div>

                <div class="notification-container" style="position: relative; cursor: pointer;">
                    <i class="fa-solid fa-bell notification-icon" id="notificationBtn" style="font-size: 18px; color: #FFFFFF;"></i>
                    <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%; display: inline-block;">2</span>

                    <div id="notificationDropdown" style="display: none; position: absolute; right: 0; top: 35px; width: 280px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">
                        <div style="background: #0d4c5c; color: white; padding: 10px 15px; font-size: 13px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
                            <span>Notifications</span>
                            <span style="font-size: 10px; background: #2ADED4; color: #07303a; padding: 2px 6px; border-radius: 4px;">2 New</span>
                        </div>
                        <div style="max-height: 250px; overflow-y: auto;">
                            <div style="padding: 10px 15px; border-bottom: 1px solid #f1f1f1; font-size: 12px; color: #333;">
                                <strong>Request Approved</strong><br>
                                <span style="color: #78909c;">Your request for San Juan Deep Well has been approved.</span>
                            </div>
                            <div style="padding: 10px 15px; border-bottom: 1px solid #f1f1f1; font-size: 12px; color: #333;">
                                <strong>System Update</strong><br>
                                <span style="color: #78909c;">Water Source Varam Spring V is now available for scheduling.</span>
                            </div>
                        </div>
                    </div>
                </div>

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
                            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-user-gear" style="color: #0d4c5c; width: 15px;"></i> Manage Profile
                            </a>
                            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-key" style="color: #0d4c5c; width: 15px;"></i> Change Password
                            </a>
                            <div style="border-top: 1px solid #eee; margin: 5px 0;"></div>
                            <a href="{{ route('logout') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #e74c3c; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#fdf0f0'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-right-from-bracket" style="width: 15px;"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-grid">
            <div class="card table-card">
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Stored Access Records Repository</h3>
                    <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Monitor and review stored access requests, statuses, schedules, and related records to maintain an organized repository.</p>
                </div>

                <div class="filter-container">
                    <label style="font-size: 12px; font-weight: 600; color: #0d4c5c;">
                        Filter Status:
                    </label>

                    <select id="statusFilter" class="filter-select">
                        <option value="all">All Records</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Declined">Declined</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <table id="recordsTable">
                    <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>User Name</th>
                            <th>Water Source</th>
                            <th>Assigned Schedule</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            @php
                                $schedule = $record->schedule;

                                $displayStatus = $schedule
                                    ? $schedule->status
                                    : $record->status;

                                $assignedSchedule = $schedule
                                    ? $schedule->schedule_date->format('M d, Y')
                                        . ' - ' . $schedule->time_slot
                                    : 'Not Scheduled';
                            @endphp

                            <tr
                                data-status="{{ $displayStatus }}"
                                data-id="{{ $record->request_code }}"
                                data-user="{{ $record->user_name }}"
                                data-source="{{ $record->requested_source }}"
                                data-schedule="{{ $assignedSchedule }}"
                                data-purpose="{{ $record->purpose }}"
                            >
                                <td>{{ $record->request_code }}</td>
                                <td>{{ $record->user_name }}</td>
                                <td>{{ $record->requested_source }}</td>
                                <td>{{ $assignedSchedule }}</td>
                                <td>
                                    <span class="badge {{ strtolower($displayStatus) }}">
                                        {{ $displayStatus }}
                                    </span>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn-view-record"
                                        onclick="openRecordModal(this)"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #78909c;">
                                    No access records found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer class="dashboard-footer">
                <span>Powered by Water Seeker Admin</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<div class="modal-overlay" id="recordModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 450px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 16px; color: #07303a;">Access Record Details</h3>
            <button class="close-modal" onclick="closeRecordModal()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">&times;</button>
        </div>
        <div class="record-details">
            <p style="margin-bottom: 8px;"><strong>Record ID:</strong> <span id="modalRecordId">-</span></p>
            <p style="margin-bottom: 8px;"><strong>User Name:</strong> <span id="modalUserName">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Water Source:</strong> <span id="modalSource">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Assigned Schedule:</strong> <span id="modalSchedule">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Status:</strong> <span id="modalStatus">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Purpose / Notes:</strong> <span id="modalPurpose">-</span></p>
        </div>
        <div class="modal-footer" style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <button type="button" class="btn-cancel" onclick="closeRecordModal()" style="background-color: #0d4c5c; color: white; border: none; padding: 7px 14px; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 600;">Close</button>
        </div>
    </div>
</div>

<script>
    function openRecordModal(button) {
        const row = button.closest('tr');
        document.getElementById('modalRecordId').innerText = row.getAttribute('data-id');
        document.getElementById('modalUserName').innerText = row.getAttribute('data-user');
        document.getElementById('modalSource').innerText = row.getAttribute('data-source');
        document.getElementById('modalSchedule').innerText = row.getAttribute('data-schedule');
        document.getElementById('modalStatus').innerText = row.getAttribute('data-status');
        document.getElementById('modalPurpose').innerText = row.getAttribute('data-purpose');

        document.getElementById('recordModal').style.display = 'flex';
    }

    function closeRecordModal() {
        document.getElementById('recordModal').style.display = 'none';
    }

    document.getElementById('statusFilter').addEventListener('change', function () {
        const filterValue = this.value;
        const rows = document.querySelectorAll('#recordsTable tbody tr');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');

            if (filterValue === 'all' || status === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchInput').addEventListener('keyup', function (e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#recordsTable tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();

                if (profileDropdown.style.display === 'none' || profileDropdown.style.display === '') {
                    profileDropdown.style.display = 'block';
                } else {
                    profileDropdown.style.display = 'none';
                }
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