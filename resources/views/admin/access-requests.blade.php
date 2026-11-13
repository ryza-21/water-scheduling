<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Request Management - Water Seeker Admin</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
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
                <!-- Active Water Access Requests -->
                <li class="nav-item active">
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
            <h1 class="page-title">WATER ACCESS REQUESTS</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search requests...">
                </div>

                <!-- Notification Bell with Dropdown -->
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
                                <strong>New Request</strong><br>
                                <span style="color: #78909c;">A new water access request has been submitted.</span>
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
                            <p style="font-size: 13px; font-weight: bold; margin: 0;">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p style="font-size: 11px; color: #2ADED4; margin: 2px 0 0 0;">{{ Auth::user()->email ?? 'admin@waterseeker.com' }}</p>
                        </div>
                        <div style="padding: 5px 0;">
                            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-user-gear" style="color: #0d4c5c; width: 15px;"></i> Manage Profile
                            </a>
                            <a href="#" style="display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #333; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f1f1'" onmouseout="this.style.background='transparent'">
                                <i class="fa-solid fa-key" style="color: #0d4c5c; width: 15px;"></i> Change Password
                            </a>
                            <div style="border-top: 1px solid #eee; margin: 5px 0;"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="width: 100%; background: none; border: none; display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #e74c3c; text-decoration: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#fdf0f0'" onmouseout="this.style.background='transparent'">
                                    <i class="fa-solid fa-right-from-bracket" style="width: 15px;"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="dashboard-grid">
            <div class="card table-card">
                <div class="card-title-action" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Submitted Access Requests</h3>
                        <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Review user requests and process information for water source access.</p>
                    </div>
                </div>

                <table id="accessRequestsTable">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>User Name</th>
                            <th>Requested Source</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $accessRequest)
                            <tr
                                data-id="{{ $accessRequest->id }}"
                                data-user="{{ $accessRequest->user_name }}"
                                data-source="{{ $accessRequest->requested_source }}"
                                data-purpose="{{ $accessRequest->purpose }}"
                                data-date="{{ $accessRequest->submitted_at?->format('Y-m-d') ?? $accessRequest->created_at?->format('Y-m-d') }}"
                            >
                                <td>#{{ $accessRequest->request_code ?? $accessRequest->id }}</td>
                                <td>{{ $accessRequest->user_name }}</td>
                                <td>{{ $accessRequest->requested_source }}</td>
                                <td>{{ $accessRequest->submitted_at?->format('Y-m-d') ?? $accessRequest->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge {{ strtolower($accessRequest->status) }}">
                                        {{ $accessRequest->status }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn-approve review-btn">
                                        <i class="fa-solid fa-eye"></i> Review
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:20px;">
                                    No access requests found.
                                </td>
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

<!-- REVIEW & CUSTOM CONFIRMATION MODAL -->
<div class="modal-overlay" id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 450px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 id="modalHeading" style="font-size: 16px; color: #07303a;">Review Access Request</h3>
            <button class="close-modal" id="closeModal" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">&times;</button>
        </div>
        
        <!-- Details View -->
        <div id="modalDetailsView" class="request-details" style="font-size: 13px; color: #333;">
            <p style="margin-bottom: 8px;"><strong>User Name:</strong> <span id="modalUserName">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Requested Source:</strong> <span id="modalSource">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Purpose / Details:</strong> <span id="modalPurpose">-</span></p>
            <p style="margin-bottom: 8px;"><strong>Date Submitted:</strong> <span id="modalDate">-</span></p>
        </div>

        <!-- Custom Confirmation Message View (Hidden by default) -->
        <div id="modalConfirmView" style="display: none; font-size: 14px; color: #333; text-align: center; padding: 15px 0;">
            <i class="fa-solid fa-circle-question" style="font-size: 36px; color: #0d4c5c; margin-bottom: 10px;"></i>
            <p id="confirmMessage" style="font-weight: 600; color: #07303a;"></p>
        </div>
       
        <div class="modal-footer" style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
            <form id="statusForm" method="POST" action="">
                @csrf
                <input type="hidden" name="status" id="statusInput" value="">
                
                <!-- Initial Action Buttons -->
                <div id="initialButtons" style="display: flex; gap: 10px;">
                    <button type="button" class="btn-decline" id="btnDeclineModal">Decline</button>
                    <button type="button" class="btn-approve" id="btnApproveModal">Approve</button>
                </div>

                <!-- Confirmation Action Buttons (Hidden by default) -->
                <div id="confirmButtons" style="display: none; gap: 10px;">
                    <button type="button" class="btn-cancel" id="btnBackModal" style="background: #cfd8dc; color: #333; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn-approve" id="btnConfirmSubmit">Yes, Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("reviewModal");
    const closeModalBtn = document.getElementById("closeModal");
    const statusForm = document.getElementById("statusForm");
    const statusInput = document.getElementById("statusInput");

    const modalHeading = document.getElementById("modalHeading");
    const modalUserName = document.getElementById("modalUserName");
    const modalSource = document.getElementById("modalSource");
    const modalPurpose = document.getElementById("modalPurpose");
    const modalDate = document.getElementById("modalDate");

    const modalDetailsView = document.getElementById("modalDetailsView");
    const modalConfirmView = document.getElementById("modalConfirmView");
    const confirmMessage = document.getElementById("confirmMessage");

    const initialButtons = document.getElementById("initialButtons");
    const confirmButtons = document.getElementById("confirmButtons");

    const approveBtn = document.getElementById("btnApproveModal");
    const declineBtn = document.getElementById("btnDeclineModal");
    const backBtn = document.getElementById("btnBackModal");

    function resetModalView() {
        modalDetailsView.style.display = "block";
        modalConfirmView.style.display = "none";
        initialButtons.style.display = "flex";
        confirmButtons.style.display = "none";
        modalHeading.textContent = "Review Access Request";
    }

    function closeModal() {
        modal.style.display = "none";
        resetModalView();
    }

    document.querySelectorAll(".review-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            resetModalView();

            modalUserName.textContent = row.dataset.user || "-";
            modalSource.textContent = row.dataset.source || "-";
            modalPurpose.textContent = row.dataset.purpose || "-";
            modalDate.textContent = row.dataset.date || "-";

            statusForm.action =
                "/admin/access-requests/" +
                encodeURIComponent(row.dataset.id) +
                "/status";

            const status = row.querySelector(".badge")
                .textContent.trim().toLowerCase();

            const alreadyProcessed = status !== "pending";

            approveBtn.disabled = alreadyProcessed;
            declineBtn.disabled = alreadyProcessed;

            approveBtn.style.opacity = alreadyProcessed ? "0.5" : "1";
            declineBtn.style.opacity = alreadyProcessed ? "0.5" : "1";

            modal.style.display = "flex";
        });
    });

    // Custom Confirmation for Approve
    approveBtn.addEventListener("click", function () {
        if (!statusForm.action) return;
        statusInput.value = "Approved";
        confirmMessage.textContent = "Are you sure you want to approve this request?";
        
        modalDetailsView.style.display = "none";
        modalConfirmView.style.display = "block";
        initialButtons.style.display = "none";
        confirmButtons.style.display = "flex";
        modalHeading.textContent = "Confirm Approval";
    });

    // Custom Confirmation for Decline
    declineBtn.addEventListener("click", function () {
        if (!statusForm.action) return;
        statusInput.value = "Declined";
        confirmMessage.textContent = "Are you sure you want to decline this request?";
        
        modalDetailsView.style.display = "none";
        modalConfirmView.style.display = "block";
        initialButtons.style.display = "none";
        confirmButtons.style.display = "flex";
        modalHeading.textContent = "Confirm Decline";
    });

    // Back button from confirmation view
    backBtn.addEventListener("click", function () {
        resetModalView();
    });

    closeModalBtn.addEventListener("click", closeModal);

    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('#accessRequestsTable tbody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(function (row) {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Notification Dropdown Toggle
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notifBadge = document.getElementById('notifBadge');

    if (notificationBtn && notificationDropdown) {
        notificationBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                notificationDropdown.style.display = 'block';
                if (notifBadge) notifBadge.style.display = 'none';
            } else {
                notificationDropdown.style.display = 'none';
            }
        });
    }

    // User Profile Dropdown Toggle
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
    }

    // Global Click Listener to close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        if (notificationDropdown && !notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
            notificationDropdown.style.display = 'none';
        }
        if (profileDropdown && !profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
            profileDropdown.style.display = 'none';
        }
    });
});
</script>

</body>
</html>