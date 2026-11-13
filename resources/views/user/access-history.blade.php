@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\AccessRequest[] $requests */
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access History - Water Seeker</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/user/all-user.css') }}">
</head>
<body>

<div class="dashboard-container">
    <!-- SIDEBAR (Community User Menu) -->
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
                <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.water-sources') }}"><i class="fa-solid fa-faucet-drip"></i> Water Sources</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.request-access') }}"><i class="fa-solid fa-file-circle-plus"></i> Request Water Access</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.my-requests') }}"><i class="fa-solid fa-clipboard-list"></i> My Requests</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.my-schedule') }}"><i class="fa-solid fa-calendar-days"></i> My Schedule</a>
            </li>
            <li class="nav-item active">
                <a href="{{ route('user.access-history') }}"><i class="fa-solid fa-folder-open"></i> Access History</a>
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
            <h1 class="page-title">ACCESS HISTORY</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search water sources...">
                </div>

                <!-- Notification Bell with Dropdown (Puti na ang icon) -->
                <div class="notification-container" style="position: relative; cursor: pointer;">
                    <i class="fa-solid fa-bell notification-icon" id="notificationBtn" style="font-size: 18px; color: #FFFFFF;"></i>
                    <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%; display: inline-block;">2</span>
                    
                    <!-- Notification Dropdown Box -->
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

               <!-- User Profile with Dropdown -->
                <div class="user-profile-container" style="position: relative; cursor: pointer; display: inline-block;">
                    <div class="user-profile" id="profileBtn" style="display: flex; align-items: center; gap: 8px;">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" alt="User Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #FFFFFF;"></i>
                    </div>

                    <!-- Profile Dropdown Box -->
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
        </header>

        <!-- CONTENT -->
        <div class="dashboard-grid">
            <!-- MODULE PURPOSE BANNER -->
            <div class="card" style="background: linear-gradient(135deg, #0d4c5c, #0c6a7a); color: white;">
                <h2 style="font-size: 18px; margin-bottom: 5px; color: #2ADED4;">Historical Access Records Log</h2>
                <p style="font-size: 13px; color: #E0F7FA;">Review your previous water access requests, historical recorded statuses, completed schedules, and administrative decisions for complete personal reference.</p>
            </div>

            <!-- HISTORY TABLE CARD -->
            <div class="card table-card">
                <!-- FILTER CONTROLS -->
                <div class="history-filter-bar">
                    <div class="filter-group-history">
                        <label style="font-size: 12px; font-weight: 600; color: #0d4c5c;">Filter Recorded Status:</label>
                        <select id="statusFilter" class="filter-select-history">
                            <option value="all">All Records</option>
                            <option value="Completed">Completed</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <span style="font-size: 12px; color: #546E7A; font-style: italic;">Showing archived requests</span>
                </div>

                <table id="historyTable">
                    <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>Water Source</th>
                            <th>Requested Date</th>
                            <th>Recorded Schedule</th>
                            <th>Final Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                 <tbody>
                        @if(isset($requests) && count($requests) > 0)
                            @foreach($requests as $req)
                                @php
                                    $status = $req->status ?? 'Completed';
                                    $statusLower = strtolower($status);
                                    
                                    $badgeClass = 'history-completed';
                                    if ($statusLower === 'rejected' || $statusLower === 'declined') {
                                        $badgeClass = 'history-rejected';
                                        $status = 'Rejected';
                                    } elseif ($statusLower === 'cancelled') {
                                        $badgeClass = 'history-cancelled';
                                    } elseif ($statusLower === 'approved') {
                                        $badgeClass = 'history-completed';
                                    }

                                    $reqDateFormatted = $req->created_at ? $req->created_at->format('F d, Y') : ($req->preferred_date ? $req->preferred_date->format('F d, Y') : '-');
                                    $scheduleFormatted = $statusLower === 'approved' || $statusLower === 'completed' ? ($req->preferred_date ? $req->preferred_date->format('M d, Y') . ' (Assigned Slot)' : 'Scheduled') : 'N/A';
                                    $notesText = $req->remarks ?? ($statusLower === 'rejected' ? 'Request declined by administrator.' : 'Successfully recorded in community archive logs.');
                                @endphp
                                <tr data-status="{{ $status }}" 
                                    data-id="{{ $req->request_code }}" 
                                    data-source="{{ $req->requested_source }}" 
                                    data-reqdate="{{ $reqDateFormatted }}" 
                                    data-schedule="{{ $scheduleFormatted }}" 
                                    data-purpose="{{ $req->purpose }}" 
                                    data-notes="{{ $notesText }}">
                                    <td><strong>{{ $req->request_code }}</strong></td>
                                    <td>{{ $req->requested_source }}</td>
                                    <td>{{ $reqDateFormatted }}</td>
                                    <td>
                                        @if($statusLower === 'rejected' || $statusLower === 'cancelled')
                                            <span style="color: #c0392b;">N/A</span>
                                        @else
                                            {{ $scheduleFormatted }}
                                        @endif
                                    </td>
                                    <td><span class="badge {{ $badgeClass }}">{{ $status }}</span></td>
                                    <td>
                                        <button type="button" class="btn-view-history" onclick="openHistoryModal(this)"><i class="fa-solid fa-file-lines"></i> View Record</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" style="text-align: center; color: #546E7A; padding: 25px;">No historical access records found in the database.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- FOOTER -->
            <footer class="dashboard-footer">
                <span>Powered by Water Seeker Community Portal</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<!-- HISTORY RECORD DETAILS MODAL -->
<div class="modal-overlay" id="historyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 450px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 16px; color: #07303a;">Historical Access Record Details</h3>
            <button class="close-modal" type="button" onclick="closeHistoryModal()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">&times;</button>
        </div>
        <div class="history-details">
            <p style="margin-bottom: 8px;"><strong>Record ID:</strong> <span id="modalHistId">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Water Source:</strong> <span id="modalSource">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Requested Date:</strong> <span id="modalReqDate">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Recorded Schedule:</strong> <span id="modalSchedule">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Final Status:</strong> <span id="modalStatusBadge">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Original Purpose:</strong> <span id="modalPurpose">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Record Notes / Remarks:</strong> <span id="modalNotes" style="color: #546E7A; font-style: italic;">-</span></p>
        </div>
        <div class="modal-footer" style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <button type="button" class="btn-cancel" onclick="closeHistoryModal()" style="background-color: #0d4c5c; color: white; border: none; padding: 7px 14px; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 600;">Close Record</button>
        </div>
    </div>
</div>

<!-- INTERNAL JAVASCRIPT PARA SA FILTERING, SEARCH, UG RECORD MODAL -->
<script>
    function openHistoryModal(button) {
        const row = button.closest('tr');
        document.getElementById('modalHistId').innerText = row.getAttribute('data-id');
        document.getElementById('modalSource').innerText = row.getAttribute('data-source');
        document.getElementById('modalReqDate').innerText = row.getAttribute('data-reqdate');
        document.getElementById('modalSchedule').innerText = row.getAttribute('data-schedule');
        document.getElementById('modalPurpose').innerText = row.getAttribute('data-purpose');
        document.getElementById('modalNotes').innerText = row.getAttribute('data-notes');

        const status = row.getAttribute('data-status');
        let badgeClass = 'history-completed';
        if (status === 'Rejected') badgeClass = 'history-rejected';
        if (status === 'Cancelled') badgeClass = 'history-cancelled';

        document.getElementById('modalStatusBadge').innerHTML = `<span class="badge ${badgeClass}">${status}</span>`;
        document.getElementById('historyModal').style.display = 'flex';
    }

    function closeHistoryModal() {
        document.getElementById('historyModal').style.display = 'none';
    }

    // Status Filter Functionality
    document.getElementById('statusFilter').addEventListener('change', function () {
        const filterValue = this.value;
        const rows = document.querySelectorAll('#historyTable tbody tr');

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (filterValue === 'all' || status === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Real-Time Search Functionality
    document.getElementById('searchInput').addEventListener('keyup', function (e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#historyTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                const term = e.target.value.toLowerCase().trim();
                
                // Pwede mangita sa mga table rows o grid cards (depende sa imong layout)
                const items = document.querySelectorAll('.water-source-card, #waterSourcesTable tbody tr, .card');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(term) || term === '') {
                        item.style.display = '';
                    } else {
                        // Ayaw i-hide ang pinakataas nga banner cards
                        if (!item.classList.contains('banner-card') && !item.style.background.includes('linear-gradient')) {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        }

        // 2. Notification Bell Dropdown Toggle & Badge Removal
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notifBadge = document.getElementById('notifBadge');

        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                // Toggle display
                if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                    notificationDropdown.style.display = 'block';
                    // Tag-on nga nabasa na (kuhaon ang badge)
                    if (notifBadge) {
                        notifBadge.style.display = 'none';
                    }
                } else {
                    notificationDropdown.style.display = 'none';
                }
            });

            // I-close ang dropdown kung mo-click sa gawas
            document.addEventListener('click', function (e) {
                if (!notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
                    notificationDropdown.style.display = 'none';
                }
            });
        }
    });
    document.addEventListener("DOMContentLoaded", function () {
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                // I-toggle ang display sa profile dropdown
                if (profileDropdown.style.display === 'none' || profileDropdown.style.display === '') {
                    profileDropdown.style.display = 'block';
                } else {
                    profileDropdown.style.display = 'none';
                }
            });

            // I-close ang dropdown kung mo-click sa gawas
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