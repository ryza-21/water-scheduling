<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Management - Water Seeker Admin</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr CSS for Centered/Clean Calendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
    <style>
        /* Success Popup Alert Styling */
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
        <div>
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
                <li class="nav-item active">
                    <a href="{{ route('admin.schedule-management') }}"><i class="fa-solid fa-calendar-days"></i> Schedule Management</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.access-records') }}"><i class="fa-solid fa-folder-open"></i> Access Records</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user-management') }}"><i class="fa-solid fa-user-plus"></i> User Management</a>
                </li>
                <li class="nav-item">
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

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <h1 class="page-title">SCHEDULE MANAGEMENT</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search schedules...">
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
            
            <!-- SUCCESS POPUP MESSAGE ALERT -->
            @if (session('success'))
                <div class="alert-popup" id="successAlert">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #28a745;"></i>
                        <span style="font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.style.display='none';" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #155724;">&times;</button>
                </div>
            @endif

            <div class="card table-card">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Access Schedule Coordination</h3>
                    <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Organize access times, assign available schedules for approved requests, and prevent overlapping schedules.</p>
                </div>

                <table id="scheduleTable">
                    <thead>
                        <tr>
                            <th>Request Code</th>
                            <th>Applicant Name</th>
                            <th>Water Source</th>
                            <th>Schedule Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $accessRequest)
                            @php
                                $schedule = $accessRequest->schedule;
                            @endphp

                            <tr
                                data-applicant="{{ $accessRequest->user_name }}"
                                data-source="{{ $accessRequest->requested_source }}"
                                data-date="{{ $schedule?->schedule_date?->format('Y-m-d') }}"
                            >
                                <td>{{ $accessRequest->request_code }}</td>
                                <td>{{ $accessRequest->user_name }}</td>
                                <td>{{ $accessRequest->requested_source }}</td>
                                <td>
                                    @if ($schedule)
                                        {{ $schedule->schedule_date->format('M d, Y') }}
                                        <br>
                                        {{ $schedule->time_slot }}
                                    @else
                                        Not Scheduled
                                    @endif
                                </td>
                                <td>
                                    @if ($schedule)
                                        <span class="badge scheduled">{{ $schedule->status }}</span>
                                    @else
                                        <span class="badge pending">Not Scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn-schedule-action"
                                        onclick="openScheduleModal(this)"
                                        data-request-id="{{ $accessRequest->id }}"
                                        data-save-url="{{ route('admin.schedule.store', $accessRequest->id) }}"
                                    >
                                        <i class="fa-solid fa-calendar-check"></i>
                                        {{ $schedule ? 'Update Schedule' : 'Assign Schedule' }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No approved access requests found in the database.</td>
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

<!-- ASSIGN / UPDATE SCHEDULE MODAL -->
<div class="modal-overlay" id="scheduleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 420px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalTitle" style="font-size: 16px; color: #07303a;">Assign Access Schedule</h3>
            <button class="close-modal" type="button" onclick="closeScheduleModal()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">&times;</button>
        </div>
        <div class="schedule-details">
            <p style="margin-bottom: 8px;"><strong>Applicant:</strong> <span id="modalApplicant">-</span></p>
            <p style="margin-bottom: 15px;"><strong>Water Source:</strong> <span id="modalSource">-</span></p>
            
            <form id="scheduleForm" method="POST" action="">
                @csrf

                <div class="form-group" style="margin-bottom: 12px;">
                    <label for="scheduleDate">Schedule Date</label>
                    <div style="position: relative;">
                        <!-- Clean input controlled by Flatpickr -->
                        <input
                            type="text"
                            id="scheduleDate"
                            name="schedule_date"
                            required
                            placeholder="Select Date (e.g. Nov 06, 2026)"
                            style="width: 100%; padding: 8px; padding-right: 35px; border: 1px solid #ccc; border-radius: 4px; background: #fff; cursor: pointer;"
                        >
                        <i class="fa-solid fa-calendar-days" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #78909c; pointer-events: none;"></i>
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="startTime">Start Time</label>
                        <input
                            type="time"
                            id="startTime"
                            name="start_time"
                            required
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                        >
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label for="endTime">End Time</label>
                        <input
                            type="time"
                            id="endTime"
                            name="end_time"
                            required
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"
                        >
                    </div>
                </div>

                <div class="modal-actions" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeScheduleModal()" style="padding: 8px 15px; background: #ccc; border: none; border-radius: 4px; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" class="btn-schedule-action" style="padding: 8px 15px; background: #0d4c5c; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Flatpickr JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- INTERNAL JAVASCRIPT -->
<script>
    // Initialize Flatpickr for beautiful centered calendar popup matching Month name format
    let fp = flatpickr("#scheduleDate", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "M d, Y",
        minDate: "today",
        static: false // Mosiguro nga ang calendar mo-pop up doul sa input field sa sulod sa modal
    });

    function openScheduleModal(button) {
        const row = button.closest('tr');
        const form = document.getElementById('scheduleForm');

        document.getElementById('modalApplicant').textContent = row.dataset.applicant || '';
        document.getElementById('modalSource').textContent = row.dataset.source || '';

        document.getElementById('modalTitle').textContent = row.dataset.date
            ? 'Update Access Schedule'
            : 'Assign Access Schedule';

        form.action = button.dataset.saveUrl;

        const rawDate = row.dataset.date || '';
        fp.setDate(rawDate, true);
        
        document.getElementById('startTime').value = '';
        document.getElementById('endTime').value = '';

        document.getElementById('scheduleModal').style.display = 'flex';
    }

    function closeScheduleModal() {
        document.getElementById('scheduleModal').style.display = 'none';
    }

    // Automatic fade out sa success alert pagkalabay sa 4 segundos
    setTimeout(function() {
        const alertPopup = document.getElementById('successAlert');
        if (alertPopup) {
            alertPopup.style.transition = 'opacity 0.5s ease';
            alertPopup.style.opacity = '0';
            setTimeout(() => alertPopup.remove(), 500);
        }
    }, 4000);

    document.getElementById('scheduleForm').addEventListener('submit', function (event) {
        const date = document.getElementById('scheduleDate').value;
        const start = document.getElementById('startTime').value;
        const end = document.getElementById('endTime').value;

        if (!date || !start || !end) {
            event.preventDefault();
            alert('Please select a schedule date, start time, and end time.');
        }
    });

    document.getElementById('searchInput').addEventListener('input', function (event) {
        const term = event.target.value.toLowerCase();
        document.querySelectorAll('#scheduleTable tbody tr').forEach(function (row) {
            row.style.display = row.innerText.toLowerCase().includes(term) ? '' : 'none';
        });
    });

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