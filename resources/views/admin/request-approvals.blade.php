<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval and Rejection - Water Seeker Admin</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
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
    </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
       <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <h1 class="page-title">WATER SOURCE MANAGEMENT</h1>
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
            </div>
        </header>

        <!-- CONTENT -->
        <div class="dashboard-grid">
            <div class="card table-card">
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Request Decision Panel</h3>
                    <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Record the official decision on each request. The system updates and stores the request status.</p>
                </div>

                <table id="approvalsTable">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Applicant Name</th>
                            <th>Target Source</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                            <th>Decision Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#REQ-201</td>
                            <td>Ramil Gomez</td>
                            <td>Varam Spring V</td>
                            <td>2026-10-14</td>
                            <td><span class="badge pending">Pending</span></td>
                            <td>
                                <div class="decision-buttons">
                                    <button class="btn-approve-action" onclick="updateDecision(this, 'Approved')"><i class="fa-solid fa-check"></i> Approve</button>
                                    <button class="btn-reject-action" onclick="updateDecision(this, 'Rejected')"><i class="fa-solid fa-xmark"></i> Reject</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#REQ-202</td>
                            <td>Elena Cruz</td>
                            <td>San Juan Deep Well</td>
                            <td>2026-10-13</td>
                            <td><span class="badge approved">Approved</span></td>
                            <td>
                                <span class="decision-note">Official Decision Recorded</span>
                            </td>
                        </tr>
                        <tr>
                            <td>#REQ-203</td>
                            <td>Cardo Dalisay</td>
                            <td>Malun Water Reservoir</td>
                            <td>2026-10-12</td>
                            <td><span class="badge rejected">Rejected</span></td>
                            <td>
                                <span class="decision-note">Official Decision Recorded</span>
                            </td>
                        </tr>
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

<!-- INTERNAL JAVASCRIPT -->
<script>
    function updateDecision(button, decision) {
        const row = button.closest('tr');
        const statusBadge = row.querySelector('.badge');
        const actionCell = row.cells[5];

        if (confirm(`Sigurado ka ba nga gusto nimo i-${decision.toLowerCase()} kining request? Mag-update ug ma-store kini sa sistema.`)) {
            // I-update ang status badge
            statusBadge.className = decision === 'Approved' ? 'badge approved' : 'badge rejected';
            statusBadge.innerText = decision;

            // Ilisan ang mga botones og nota nga narecord na ang desisyon
            actionCell.innerHTML = `<span class="decision-note">Official Decision Recorded</span>`;
        }
    }

    // Real-time search functionality
    document.getElementById('searchInput').addEventListener('keyup', function (e) {
        const term = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#approvalsTable tbody tr');
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