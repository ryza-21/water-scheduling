
@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\WaterSource[] $waterSources */
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Water Sources & Availability - Water Seeker</title>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- User CSS -->
    <link rel="stylesheet" href="{{ asset('assets/user/all-user.css') }}">
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
                <a href="{{ route('user.dashboard') }}">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>

            <li class="nav-item active">
                <a href="{{ route('user.water-sources') }}">
                    <i class="fa-solid fa-faucet-drip"></i> Water Sources
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.request-access') }}">
                    <i class="fa-solid fa-file-circle-plus"></i> Request Water Access
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.my-requests') }}">
                    <i class="fa-solid fa-clipboard-list"></i> My Requests
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.my-schedule') }}">
                    <i class="fa-solid fa-calendar-days"></i> My Schedule
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.access-history') }}">
                    <i class="fa-solid fa-folder-open"></i> Access History
                </a>
            </li>

        </ul>

        <!-- SIDEBAR LOGOUT -->
        <div style="padding: 20px;">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    style="width: 100%; background: rgba(255,255,255,0.1); border: none; color: #fff; padding: 10px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 13px;">

                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout

                </button>
            </form>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP NAVBAR -->
        <header class="top-navbar">

            <h1 class="page-title">WATER SOURCES & AVAILABILITY</h1>

            <div class="navbar-right" style="position: relative;">

                <!-- SEARCH BOX -->
                <div class="search-box">

                    <i class="fa-solid fa-search"></i>

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Search water sources..."
                    >

                </div>


                <!-- NOTIFICATION DROPDOWN -->
                <div class="notification-container"
                    style="position: relative; cursor: pointer;">

                    <i
                        class="fa-solid fa-bell notification-icon"
                        id="notificationBtn"
                        style="font-size: 18px; color: #FFFFFF;">
                    </i>

                    <span
                        id="notifBadge"
                        style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%; display: inline-block;">
                        2
                    </span>


                    <div
                        id="notificationDropdown"
                        style="display: none; position: absolute; right: 0; top: 35px; width: 280px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">

                        <div
                            style="background: #0d4c5c; color: white; padding: 10px 15px; font-size: 13px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">

                            <span>Notifications</span>

                            <span
                                style="font-size: 10px; background: #2ADED4; color: #07303a; padding: 2px 6px; border-radius: 4px;">
                                2 New
                            </span>

                        </div>

                        <div style="max-height: 250px; overflow-y: auto;">

                            <div
                                style="padding: 10px 15px; border-bottom: 1px solid #f1f1f1; font-size: 12px; color: #333;">

                                <strong>Request Approved</strong>

                                <br>

                                <span style="color: #78909c;">
                                    Your request for San Juan Deep Well has been approved.
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- USER PROFILE DROPDOWN -->
                <div
                    class="user-profile-container"
                    style="position: relative; cursor: pointer; display: inline-block;">

                    <div
                        class="user-profile"
                        id="profileBtn"
                        style="display: flex; align-items: center; gap: 8px;">

                        <img
                            src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100"
                            alt="User Profile"
                            style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">

                        <i
                            class="fa-solid fa-chevron-down"
                            style="font-size: 10px; color: #FFFFFF;">
                        </i>

                    </div>


                    <div
                        id="profileDropdown"
                        style="display: none; position: absolute; right: 0; top: 45px; width: 220px; background: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px; z-index: 1100; overflow: hidden; border: 1px solid #CFD8DC;">

                        <div
                            style="background: #0d4c5c; color: white; padding: 12px 15px;">

                            <p style="font-size: 13px; font-weight: bold; margin: 0;">
                                {{ auth()->user()->name ?? 'Community User' }}
                            </p>

                            <p style="font-size: 11px; color: #2ADED4; margin: 2px 0 0 0;">
                                {{ auth()->user()->email ?? 'user@waterseeker.com' }}
                            </p>

                        </div>


                        <!-- PROFILE LOGOUT -->
                        <div style="padding: 5px 0;">

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button
                                    type="submit"
                                    style="width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 15px; font-size: 13px; color: #e74c3c; text-decoration: none; background: none; border: none; cursor: pointer;">

                                    <i class="fa-solid fa-right-from-bracket" style="width: 15px;"></i>
                                    Logout

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <div class="dashboard-grid">

            <!-- SYSTEM NOTICE -->
            <div class="system-notice-banner">

                <i
                    class="fa-solid fa-circle-info"
                    style="font-size: 20px; color: #0d4c5c;">
                </i>

                <div>

                    <strong>System Management Note:</strong>

                    Availability reflects access schedules and reservations coordinated by the Administrator in the system.

                </div>

            </div>


            <!-- DYNAMIC WATER SOURCES -->
            <div class="detailed-source-grid" id="sourceCardsList">

                @if(isset($waterSources) && $waterSources->count() > 0)

                    @foreach($waterSources as $source)

                        @php
                            $sourceName = $source->source_name ?? '';
                            $sourceLocation = $source->location ?? '';
                            $sourceId = $source->id ?? '';
                            $sourceStatus = $source->status ?? 'Available';
                            $maxSlots = $source->max_slots ?? 10;
                            $purpose = $source->purpose ?? 'General Domestic';
                            $description = $source->description ?? 'Managed and recorded by Admin.';

                            $isFullyBooked = in_array(
                                strtolower($sourceStatus),
                                ['fully booked', 'inactive', 'unavailable']
                            );
                        @endphp


                        <div
                            class="detailed-card"
                            data-search="{{ strtolower($sourceName . ' ' . $sourceLocation) }}">

                            <div>

                                <!-- SOURCE HEADER -->
                                <div class="detailed-card-header">

                                    <div>

                                        <h3>{{ $sourceName }}</h3>

                                        <span style="font-size: 11px; color: #546E7A;">

                                            <i class="fa-solid fa-location-dot"></i>

                                            {{ $sourceLocation }}

                                        </span>

                                    </div>


                                    <!-- SOURCE STATUS -->
                                    <span class="badge {{ !$isFullyBooked ? 'available-slot' : 'unavailable-slot' }}">

                                        {{ $sourceStatus }}

                                    </span>

                                </div>


                                <!-- SOURCE INFORMATION -->
                                <div style="font-size: 12px; color: #333; margin-bottom: 10px;">

                                    <p style="margin-bottom: 4px;">
                                        <strong>Admin Record ID:</strong>
                                        #SRC-{{ $sourceId }}
                                    </p>

                                    <p style="margin-bottom: 4px;">
                                        <strong>Target Purpose:</strong>
                                        {{ $purpose }}
                                    </p>

                                    <p style="margin-bottom: 4px;">
                                        <strong>Max Daily Slots:</strong>
                                        {{ $maxSlots }} Allocations
                                    </p>

                                </div>


                                <!-- VIEW DETAILS BUTTON -->
                                <button
                                    class="btn-view-details"
                                    type="button"

                                    data-name="{{ $sourceName }}"
                                    data-location="{{ $sourceLocation }}"
                                    data-record-id="#SRC-{{ $sourceId }}"
                                    data-status="{{ $sourceStatus }}"
                                    data-slots="{{ $maxSlots }} Slots"
                                    data-description="{{ $description }}"

                                    onclick="openDetailsModal(this)">

                                    <i class="fa-solid fa-circle-info"></i>
                                    View Source Details

                                </button>

                            </div>


                            <!-- REQUEST ACCESS BUTTON -->
                            <div style="margin-top: 15px;">

                                @if(!$isFullyBooked)

                                    <a
                                        href="{{ route('user.request-access', ['source' => $sourceId]) }}"
                                        class="btn-proceed-request">

                                        Select & Proceed to Request Access

                                        <i class="fa-solid fa-arrow-right"></i>

                                    </a>

                                @else

                                    <button
                                        class="btn-proceed-request btn-proceed-disabled"
                                        disabled
                                        style="background: #cfd8dc; color: #546e7a; cursor: not-allowed;">

                                        Fully Booked - Choose Another Source

                                    </button>

                                @endif

                            </div>

                        </div>

                    @endforeach

                @else

                    <!-- EMPTY STATE -->
                    <div
                        class="card"
                        style="grid-column: 1 / -1; text-align: center; padding: 30px;">

                        <p style="color: #546E7A; font-size: 14px;">

                            No water sources registered or updated by the administrator yet.

                        </p>

                    </div>

                @endif

            </div>


            <!-- FOOTER -->
            <footer class="dashboard-footer">

                <span>Powered by Water Seeker Community Portal</span>

                <span>avemateiu.com</span>

            </footer>

        </div>

    </div>

</div>


<!-- WATER SOURCE DETAILS MODAL -->
<div
    class="modal-overlay"
    id="detailsModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">

    <div
        class="modal-card"
        style="background: #FFFFFF; padding: 25px; border-radius: 12px; width: 450px; max-width: 90%; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">

        <!-- MODAL HEADER -->
        <div
            class="modal-header"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">

            <h3
                style="font-size: 16px; color: #07303a;"
                id="modalSourceName">

                Source Information

            </h3>

            <button
                class="close-modal"
                type="button"
                onclick="closeDetailsModal()"
                style="background: none; border: none; font-size: 18px; cursor: pointer; color: #78909c;">

                &times;

            </button>

        </div>


        <!-- MODAL BODY -->
        <div style="font-size: 13px; color: #333; line-height: 1.6;">

            <p>
                <strong>Location:</strong>
                <span id="modalLocation">-</span>
            </p>

            <p>
                <strong>System Record ID:</strong>
                <span id="modalRecordId">-</span>
            </p>

            <p>
                <strong>Admin Status:</strong>
                <span id="modalStatus">-</span>
            </p>

            <p>
                <strong>Allocated Slots:</strong>
                <span id="modalSlots">-</span>
            </p>

            <p>
                <strong>Admin Description & Record:</strong>
            </p>

            <p
                id="modalDesc"
                style="background: #F1F8F6; padding: 10px; border-radius: 6px; color: #546E7A; font-style: italic; margin-top: 5px;">

                -

            </p>

        </div>


        <!-- MODAL FOOTER -->
        <div
            class="modal-footer"
            style="display: flex; justify-content: flex-end; margin-top: 20px;">

            <button
                type="button"
                class="btn-cancel"
                onclick="closeDetailsModal()"
                style="background-color: #0d4c5c; color: white; border: none; padding: 7px 14px; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 600;">

                Close Details

            </button>

        </div>

    </div>

</div>


<!-- INTERNAL JAVASCRIPT -->
<script>

// ==========================================
// WATER SOURCE DETAILS MODAL
// ==========================================

function openDetailsModal(button) {

    document.getElementById('modalSourceName').innerText =
        button.dataset.name || 'Source Information';

    document.getElementById('modalLocation').innerText =
        button.dataset.location || '-';

    document.getElementById('modalRecordId').innerText =
        button.dataset.recordId || '-';

    document.getElementById('modalStatus').innerText =
        button.dataset.status || '-';

    document.getElementById('modalSlots').innerText =
        button.dataset.slots || '-';

    document.getElementById('modalDesc').innerText =
        button.dataset.description || '-';

    document.getElementById('detailsModal').style.display = 'flex';

}


function closeDetailsModal() {

    document.getElementById('detailsModal').style.display = 'none';

}


// ==========================================
// DOCUMENT READY
// ==========================================

document.addEventListener("DOMContentLoaded", function () {


    // ======================================
    // WATER SOURCE SEARCH
    // ======================================

    const searchInput = document.getElementById('searchInput');

    if (searchInput) {

        searchInput.addEventListener('input', function (e) {

            const term = e.target.value.toLowerCase().trim();

            const cards = document.querySelectorAll(
                '#sourceCardsList .detailed-card'
            );

            cards.forEach(card => {

                const text = card.getAttribute('data-search') || '';

                card.style.display = text.includes(term) ? 'flex' : 'none';

            });

        });

    }


    // ======================================
    // NOTIFICATION DROPDOWN
    // ======================================

    const notificationBtn = document.getElementById('notificationBtn');

    const notificationDropdown = document.getElementById('notificationDropdown');

    const notifBadge = document.getElementById('notifBadge');


    if (notificationBtn && notificationDropdown) {

        notificationBtn.addEventListener('click', function (e) {

            e.stopPropagation();

            const isHidden =
                notificationDropdown.style.display === 'none' ||
                notificationDropdown.style.display === '';

            notificationDropdown.style.display =
                isHidden ? 'block' : 'none';

            if (isHidden && notifBadge) {

                notifBadge.style.display = 'none';

            }

        });


        notificationDropdown.addEventListener('click', function (e) {

            e.stopPropagation();

        });

    }


    // ======================================
    // PROFILE DROPDOWN
    // ======================================

    const profileBtn = document.getElementById('profileBtn');

    const profileDropdown = document.getElementById('profileDropdown');


    if (profileBtn && profileDropdown) {

        profileBtn.addEventListener('click', function (e) {

            e.stopPropagation();

            const isHidden =
                profileDropdown.style.display === 'none' ||
                profileDropdown.style.display === '';

            profileDropdown.style.display =
                isHidden ? 'block' : 'none';

        });


        profileDropdown.addEventListener('click', function (e) {

            e.stopPropagation();

        });

    }


    // ======================================
    // CLOSE DROPDOWNS WHEN CLICKING OUTSIDE
    // ======================================

    document.addEventListener('click', function () {

        if (notificationDropdown) {

            notificationDropdown.style.display = 'none';

        }

        if (profileDropdown) {

            profileDropdown.style.display = 'none';

        }

    });


    // ======================================
    // CLOSE MODAL WHEN CLICKING OVERLAY
    // ======================================

    const detailsModal = document.getElementById('detailsModal');

    if (detailsModal) {

        detailsModal.addEventListener('click', function (e) {

            if (e.target === detailsModal) {

                closeDetailsModal();

            }

        });

    }


    // ======================================
    // CLOSE MODAL USING ESCAPE KEY
    // ======================================

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            closeDetailsModal();

        }

    });

});

</script>

</body>
</html>
