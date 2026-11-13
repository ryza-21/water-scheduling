<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Source Management - Water Seeker Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/all-admin.css') }}">
</head>
<body>

<div class="dashboard-container">
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
                <li class="nav-item active">
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
        </div>
        
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

        <div class="dashboard-grid">
            
            @if(session('success'))
                <div style="grid-column: 1 / -1; background: #d4edda; color: #155724; padding: 12px 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #c3e6cb; font-size: 13px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 16px;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="card table-card" style="grid-column: 1 / -1;">
                <div class="module-header-flex">
                    <div>
                        <h3 style="font-size: 15px; color: #07303a; font-weight: 700;">Community Water Sources</h3>
                        <p style="font-size: 12px; color: #546E7A; margin-top: 4px;">Keep water-source information organized, updated, and maintained.</p>
                    </div>
                    <button class="btn-add" id="openAddModal"><i class="fa-solid fa-plus"></i> Add New Source</button>
                </div>

                <table id="waterSourcesTable">
                    <thead>
                        <tr>
                            <th>Source ID</th>
                            <th>Source Name</th>
                            <th>Location / Area</th>
                            <th>Capacity / Flow</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($waterSources as $source)
                            <tr data-update-url="{{ route('admin.water-sources.update', $source) }}" data-delete-url="{{ route('admin.water-sources.destroy', $source) }}">
                                <td>{{ $source->source_id }}</td>
                                <td>{{ $source->source_name }}</td>
                                <td>{{ $source->location }}</td>
                                <td>{{ $source->capacity }}</td>
                                <td>
                                    <span class="badge {{ $source->status === 'Active' ? 'active' : 'maintenance' }}">
                                        {{ $source->status }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <button type="button" class="btn-action btn-delete delete-btn" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:20px;">
                                    No water sources found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer class="dashboard-footer" style="grid-column: 1 / -1;">
                <span>Powered by Water Seeker Admin</span>
                <span>avemateiu.com</span>
            </footer>
        </div>
    </div>
</div>

<div class="modal-overlay" id="sourceModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle">Add New Water Source</h3>
            <button class="close-modal" id="closeModal">&times;</button>
        </div>
        
        <form id="sourceForm" action="{{ route('admin.water-sources.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label for="sourceName">Source Name</label>
                <input type="text" id="sourceName" name="source_name" required>
            </div>

            <div class="form-group">
                <label for="sourceLocation">Location / Area</label>
                <input type="text" id="sourceLocation" name="location" required>
            </div>

            <div class="form-group">
                <label for="sourceCapacity">Capacity / Flow</label>
                <input type="text" id="sourceCapacity" name="capacity" required>
            </div>

            <div class="form-group">
                <label for="sourceStatus">Status / Maintenance</label>
                <select id="sourceStatus" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelModal">Cancel</button>
                <button type="submit" class="btn-save">Save Source</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-card" style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 400px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center;">
        <div style="margin-bottom: 15px;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px; color: #e74c3c;"></i>
        </div>
        <h3 style="font-size: 16px; color: #07303a; margin-bottom: 10px;">Confirm Deletion</h3>
        <p style="font-size: 13px; color: #546E7A; margin-bottom: 20px;">Are you sure you want to delete this water source? This action cannot be undone.</p>
        
        <form id="deleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button type="button" class="btn-cancel" id="cancelDeleteModal" style="background: #cfd8dc; color: #333; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn-decline" style="background: #e74c3c; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('sourceModal');
    const openAddModalBtn = document.getElementById('openAddModal');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelModalBtn = document.getElementById('cancelModal');
    const sourceForm = document.getElementById('sourceForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('#waterSourcesTable tbody');

    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const cancelDeleteModal = document.getElementById('cancelDeleteModal');

    const storeUrl = sourceForm.action;

    if (openAddModalBtn) {
        openAddModalBtn.addEventListener('click', function () {
            sourceForm.reset();
            sourceForm.action = storeUrl;
            formMethod.value = 'POST';
            modalTitle.textContent = 'Add New Water Source';
            modal.style.display = 'flex';
        });
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    if (tableBody) {
        tableBody.addEventListener('click', function (event) {
            const deleteButton = event.target.closest('.delete-btn');
            if (deleteButton) {
                const row = deleteButton.closest('tr');
                const deleteUrl = row.dataset.deleteUrl;
                if (deleteUrl) {
                    deleteForm.action = deleteUrl;
                    deleteModal.style.display = 'flex';
                }
                return;
            }

            const editButton = event.target.closest('.btn-edit');
            if (!editButton) return;

            const row = editButton.closest('tr');
            const updateUrl = row.dataset.updateUrl;

            if (!updateUrl) {
                alert('This record is not connected to the database yet.');
                return;
            }

            sourceForm.reset();
            sourceForm.action = updateUrl;
            formMethod.value = 'PUT';

            document.getElementById('sourceName').value = row.cells[1].textContent.trim();
            document.getElementById('sourceLocation').value = row.cells[2].textContent.trim();
            document.getElementById('sourceCapacity').value = row.cells[3].textContent.trim();
            document.getElementById('sourceStatus').value = row.cells[4].textContent.trim();

            modalTitle.textContent = 'Edit / Maintain Water Source';
            modal.style.display = 'flex';
        });
    }

    if (cancelDeleteModal) {
        cancelDeleteModal.addEventListener('click', function () {
            deleteModal.style.display = 'none';
        });
    }

    if (deleteModal) {
        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        });
    }

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