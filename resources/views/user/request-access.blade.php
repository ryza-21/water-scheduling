<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Water Access - Water Seeker</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/user/all-user.css') }}">
</head>
<body>

<div class="dashboard-container">
    <!-- SIDEBAR (Community User Menu) -->
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
                    <a href="{{ route('user.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.water-sources') }}"><i class="fa-solid fa-faucet-drip"></i> Water Sources</a>
                </li>
                <li class="nav-item active">
                    <a href="{{ route('user.request-access') }}"><i class="fa-solid fa-file-circle-plus"></i> Request Water Access</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.my-requests') }}"><i class="fa-solid fa-clipboard-list"></i> My Requests</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.my-schedule') }}"><i class="fa-solid fa-calendar-days"></i> My Schedule</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.access-history') }}"><i class="fa-solid fa-folder-open"></i> Access History</a>
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
            <h1 class="page-title">WATER ACCESS REQUEST</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search water sources...">
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
            <!-- MODULE PURPOSE BANNER -->
            <div class="card" style="background: linear-gradient(135deg, #0d4c5c, #0c6a7a); color: white;">
                <h2 style="font-size: 18px; margin-bottom: 5px; color: #2ADED4;">Submit Formal Water Access Request</h2>
                <p style="font-size: 13px; color: #E0F7FA;">Select a community water source, provide the required information, and submit your request. The system will validate and save it with a <strong>Pending</strong> status for admin review.</p>
            </div>

            <!-- REQUEST FORM CONTAINER -->
            <div class="request-form-card">
                <!-- Success / Pending Alert Box gikan sa Laravel Session -->
                @if(session('success'))
                    <div class="alert-pending" id="successAlert" style="display: block; background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-check"></i> <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.request-access.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="waterSource">Select Water Source <span style="color: #c0392b;">*</span></label>
                        <select id="waterSource" name="requested_source" required>
                            <option value="">-- Choose Community Water Source --</option>
                            @foreach($waterSources as $source)
                                <option value="{{ $source->name }} ({{ $source->location }})">
                                    {{ $source->name }} ({{ $source->location }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preferredDate">Preferred Access Date <span style="color: #c0392b;">*</span></label>
                        <div style="position: relative;">
                            <input type="text" id="preferredDate" name="preferred_date" placeholder="Select date..." required style="width: 100%; padding-right: 35px;">
                            <i class="fa-solid fa-calendar-days" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #78909c; pointer-events: none;"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="purpose">Purpose of Access / Details <span style="color: #c0392b;">*</span></label>
                        <textarea id="purpose" name="purpose" rows="4" required placeholder="State your purpose..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estimatedVolume">Estimated Volume / Needs (Optional)</label>
                        <input type="text" id="estimatedVolume" name="estimated_volume" placeholder="e.g., 200 Liters">
                    </div>

                    <button type="submit" class="btn-submit-request">
                        <i class="fa-solid fa-paper-plane"></i> Submit Formal Request
                    </button>
                </form> 
            </div>

            <!-- FOOTER -->
            <footer class="dashboard-footer">
                <span>Powered by Water Seeker Community Portal</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<!-- Flatpickr JS Script CDN -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        flatpickr("#preferredDate", {
            dateFormat: "Y-m-d",    
            altInput: true,          
            altFormat: "F j, Y",     
            allowInput: true
        });

        // 1. Real-time Search Functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                const term = e.target.value.toLowerCase().trim();
                const items = document.querySelectorAll('.water-source-card, #waterSourcesTable tbody tr, .card');
                
                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(term) || term === '') {
                        item.style.display = '';
                    } else {
                        if (!item.classList.contains('banner-card') && !item.style.background.includes('linear-gradient')) {
                            item.style.display = 'none';
                        }
                    }
                });
            });
        }

        // 2. Notification Dropdown Toggle
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notifBadge = document.getElementById('notifBadge');

        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (notificationDropdown.style.display === 'none' || notificationDropdown.style.display === '') {
                    notificationDropdown.style.display = 'block';
                    if (notifBadge) {
                        notifBadge.style.display = 'none';
                    }
                } else {
                    notificationDropdown.style.display = 'none';
                }
            });
        }

        // 3. User Profile Dropdown Toggle
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