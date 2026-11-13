<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Water Seeker Admin</title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .charts-container-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        @media (max-width: 992px) {
            .charts-container-grid {
                grid-template-columns: 1fr;
            }
        }
        .chart-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 15px 18px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            border: 1px solid #CFD8DC;
        }
        .chart-card h4 {
            font-size: 13px;
            color: #07303a;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .chart-wrapper {
            position: relative;
            height: 180px; /* Gi-menosan ang gidak-on para compact */
            width: 100%;
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
            <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.water-sources') ? 'active' : '' }}">
                <a href="{{ route('admin.water-sources') }}"><i class="fa-solid fa-faucet-drip"></i> Water Source Management</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.access-requests') ? 'active' : '' }}">
                <a href="{{ route('admin.access-requests') }}"><i class="fa-solid fa-clipboard-list"></i> Water Access Requests</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.schedule-management') ? 'active' : '' }}">
                <a href="{{ route('admin.schedule-management') }}"><i class="fa-solid fa-calendar-days"></i> Schedule Management</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.access-records') ? 'active' : '' }}">
                <a href="{{ route('admin.access-records') }}"><i class="fa-solid fa-folder-open"></i> Access Records</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.user-management') ? 'active' : '' }}">
                <a href="{{ route('admin.user-management') }}"><i class="fa-solid fa-user-plus"></i> User Management</a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
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
            <h1 class="page-title">REPORTS & ANALYTICS</h1>
            <div class="navbar-right" style="position: relative;">
                <!-- Search Box -->
                <div class="search-box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search reports...">
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
            
            <!-- FORM PARA SA FILTERS AT EXPORT -->
            <form method="GET" action="{{ route('admin.reports') }}" id="reportFilterForm">

                <!-- REPORTS OVERVIEW CARDS -->
                <div class="reports-stat-grid" style="margin-bottom: 20px;">
                    <div class="report-stat-card accent-teal">
                        <div class="report-stat-header">
                            <h4>TOTAL REQUESTS</h4>
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        <div class="report-stat-body">
                            <h2>{{ $totalRequests ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="report-stat-card accent-mint">
                        <div class="report-stat-header">
                            <h4>APPROVED</h4>
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div class="report-stat-body">
                            <h2>{{ $approvedCount ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="report-stat-card">
                        <div class="report-stat-header">
                            <h4>PENDING</h4>
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div class="report-stat-body">
                            <h2>{{ $pendingCount ?? 0 }}</h2>
                        </div>
                    </div>
                    <div class="report-stat-card">
                        <div class="report-stat-header">
                            <h4>REJECTED</h4>
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div class="report-stat-body">
                            <h2>{{ $rejectedCount ?? 0 }}</h2>
                        </div>
                    </div>
                </div>

                <!-- CHARTS SECTION (THEME MATCHED & COMPACT) -->
                <div class="charts-container-grid">
                    <!-- Status Distribution Donut Chart -->
                    <div class="chart-card">
                        <h4><i class="fa-solid fa-chart-pie" style="color: #0d4c5c;"></i> Status Distribution</h4>
                        <div class="chart-wrapper">
                            <canvas id="statusDonutChart"></canvas>
                        </div>
                    </div>

                    <!-- Water Source Requests Bar Chart -->
                    <div class="chart-card">
                        <h4><i class="fa-solid fa-chart-column" style="color: #0d4c5c;"></i> Water Source Volume</h4>
                        <div class="chart-wrapper">
                            <canvas id="sourceBarChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- MAIN REPORTS TABLE CARD -->
                <div class="card table-card">
                    <div style="margin-bottom: 15px;">
                        <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Monthly Water Access Reports ({{ $monthName ?? 'October 2026' }})</h3>
                        <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Monitor water access requests, review statuses, assigned schedules, and breakdown per natural water source.</p>
                    </div>

                    <!-- TOOLBAR FILTERS -->
                    <div class="reports-toolbar">
                        <div class="filters-group">
                            <select name="status" id="statusFilter" class="filter-select-repo" onchange="this.form.submit()">
                                <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>Filter Status: All</option>
                                <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            
                            <select name="source" id="sourceFilter" class="filter-select-repo" onchange="this.form.submit()">
                                <option value="all" {{ request('source', 'all') === 'all' ? 'selected' : '' }}>Filter Source: All Sources</option>
                                @foreach ($sourceSummary as $summary)
                                    <option value="{{ $summary['source'] }}" {{ request('source') === $summary['source'] ? 'selected' : '' }}>
                                        {{ $summary['source'] }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="month" name="month" id="monthInputFilter" class="filter-select-repo" value="{{ $month ?? '2026-10' }}" onchange="this.form.submit()">
                        </div>
                        <div class="export-group">
                            <button type="button" class="btn-export" onclick="exportReport('excel')"><i class="fa-solid fa-file-excel"></i> Export Excel</button>
                        </div>
                    </div>

            </form>

                <!-- REPORTS TABLE -->
                <table id="reportsTable">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Requester</th>
                            <th>Water Source</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Assigned Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $item)
                            @php
                                $statusClass = strtolower($item->status ?? 'other');
                                if (!in_array($statusClass, ['approved', 'pending', 'rejected'])) {
                                    $statusClass = 'other';
                                }
                            @endphp
                            <tr data-status="{{ $item->status }}" data-source="{{ $item->requested_source ?? $item->water_source }}" data-date="{{ $item->submitted_at }}">
                                <td><strong>{{ $item->request_code ?? 'N/A' }}</strong></td>
                                <td>{{ $item->user_name ?? 'N/A' }}</td>
                                <td>{{ $item->requested_source ?? $item->water_source ?? 'N/A' }}</td>
                                <td>{{ $item->submitted_at ? \Carbon\Carbon::parse($item->submitted_at)->format('M. d, Y') : 'N/A' }}</td>
                                <td><span class="badge {{ $statusClass }}">{{ $item->status ?? 'Unknown' }}</span></td>
                                <td>
                                    @if ($item->schedule)
                                        {{ $item->schedule->schedule_date ?? $item->schedule->date ?? 'Scheduled' }}
                                    @else
                                        <span style="color: #999; font-style: italic;">Unscheduled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 20px; color: #546E7A;">No requests found for the selected filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- SUMMARY FOOTER -->
                <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #E0F7FA; display: flex; justify-content: space-between; font-size: 12px; color: #0d4c5c; font-weight: 600; flex-wrap: wrap; gap: 10px;">
                    <span>Water Source Breakdown Summary:</span>
                    @forelse ($sourceSummary as $summary)
                        <span>{{ $summary['source'] }}: {{ $summary['total'] }} Requests ({{ $summary['approved'] }} Approved, {{ $summary['pending'] }} Pending, {{ $summary['rejected'] }} Rejected)</span>
                    @empty
                        <span>No summary data available.</span>
                    @endforelse
                </div>
            </div>

            <!-- FOOTER -->
            <footer class="dashboard-footer">
                <span>Powered by Water Seeker Admin</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<!-- HIDDEN CONFIG PARA SA EXPORT URL -->
<div id="reportExportConfig"
     data-pdf-url="{{ route('admin.reports.pdf') }}"
     data-excel-url="{{ route('admin.reports.excel') }}"
     hidden>
</div>

<!-- SAFE PHP TO JS DATA PASSING VIA HTML DATA ATTRIBUTES -->
<div id="phpChartData"
     data-approved="{{ $approvedCount ?? 0 }}"
     data-pending="{{ $pendingCount ?? 0 }}"
     data-rejected="{{ $rejectedCount ?? 0 }}"
     data-sources='@json(collect($sourceSummary)->pluck("source"))'
     data-totals='@json(collect($sourceSummary)->pluck("total"))'
     hidden>
</div>

<!-- INTERNAL JAVASCRIPT & CHARTS INITIALIZATION -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dataContainer = document.getElementById('phpChartData');
        const approved = parseInt(dataContainer.dataset.approved) || 0;
        const pending = parseInt(dataContainer.dataset.pending) || 0;
        const rejected = parseInt(dataContainer.dataset.rejected) || 0;
        const sourceLabels = JSON.parse(dataContainer.dataset.sources || '[]');
        const sourceTotals = JSON.parse(dataContainer.dataset.totals || '[]');

        // Status Donut Chart (Water Seeker Theme Palette)
        const ctxDonut = document.getElementById('statusDonutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Approved', 'Pending', 'Rejected'],
                datasets: [{
                    data: [approved, pending, rejected],
                    backgroundColor: ['#2ADED4', '#E67E22', '#E74C3C'], // Water Seeker Cyan Teal, Amber, & Coral Red
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 10,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });

        // Water Source Bar Chart (Matching Dark Teal Theme)
        const ctxBar = document.getElementById('sourceBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: sourceLabels.length ? sourceLabels : ['No Sources'],
                datasets: [{
                    label: 'Total Access Requests',
                    data: sourceTotals.length ? sourceTotals : [0],
                    backgroundColor: '#0D4C5C', // Water Seeker Dark Teal Accent
                    hoverBackgroundColor: '#2ADED4',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            font: { size: 10 },
                            color: '#546E7A'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { 
                            stepSize: 1,
                            font: { size: 10 },
                            color: '#546E7A'
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Profile Dropdown JS
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

    // Real-time client search filtering
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('#reportsTable tbody tr');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Export Handler
    function exportReport(format) {
        const config = document.getElementById('reportExportConfig');
        const form = document.getElementById('reportFilterForm');

        if (!config || !form) {
            alert('Report export configuration was not found.');
            return;
        }

        let exportUrl = format === 'pdf' ? config.dataset.pdfUrl : (format === 'excel' ? config.dataset.excelUrl : '');
        if (!exportUrl) {
            alert('Invalid export format.');
            return;
        }

        const params = new URLSearchParams(new FormData(form));
        window.location.href = exportUrl + '?' + params.toString();
    }
</script>

</body>
</html>