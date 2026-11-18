
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Request Water Access - Water Seeker</title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- User CSS -->
    <link rel="stylesheet" href="{{ asset('assets/user/all-user.css') }}">
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
                    <a href="{{ route('user.dashboard') }}">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.water-sources') }}">
                        <i class="fa-solid fa-faucet-drip"></i> Water Sources
                    </a>
                </li>

                <li class="nav-item active">
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
        </div>

        <!-- SIDEBAR LOGOUT -->
        <div style="padding:20px;">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    style="width:100%; background:rgba(255,255,255,0.1); border:none; color:#fff; padding:10px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; font-size:13px;">

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

            <h1 class="page-title">WATER ACCESS REQUEST</h1>

            <div class="navbar-right" style="position:relative;">

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
                    style="position:relative; cursor:pointer;">

                    <i
                        class="fa-solid fa-bell notification-icon"
                        id="notificationBtn"
                        style="font-size:18px; color:#FFFFFF;">
                    </i>

                    <span
                        id="notifBadge"
                        style="position:absolute; top:-5px; right:-5px; background:#e74c3c; color:white; font-size:10px; padding:2px 5px; border-radius:50%;">
                        2
                    </span>

                    <div
                        id="notificationDropdown"
                        style="display:none; position:absolute; right:0; top:35px; width:280px; background:#ffffff; box-shadow:0 4px 12px rgba(0,0,0,0.15); border-radius:8px; z-index:1100; overflow:hidden; border:1px solid #CFD8DC;">

                        <div style="background:#0d4c5c; color:white; padding:10px 15px; font-size:13px; font-weight:bold;">
                            Notifications
                        </div>

                        <div style="max-height:250px; overflow-y:auto;">

                            <div style="padding:10px 15px; border-bottom:1px solid #f1f1f1; font-size:12px; color:#333;">
                                <strong>Request Approved</strong>
                                <br>
                                <span style="color:#78909c;">
                                    Your request for San Juan Deep Well has been approved.
                                </span>
                            </div>

                            <div style="padding:10px 15px; font-size:12px; color:#333;">
                                <strong>System Update</strong>
                                <br>
                                <span style="color:#78909c;">
                                    Water source availability has been updated.
                                </span>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- USER PROFILE DROPDOWN -->
                <div class="user-profile-container"
                    style="position:relative; cursor:pointer; display:inline-block;">

                    <div
                        class="user-profile"
                        id="profileBtn"
                        style="display:flex; align-items:center; gap:8px;">

                        <img
                            src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100"
                            alt="User Profile"
                            style="width:35px; height:35px; border-radius:50%; object-fit:cover;">

                        <i
                            class="fa-solid fa-chevron-down"
                            style="font-size:10px; color:#FFFFFF;">
                        </i>

                    </div>


                    <div
                        id="profileDropdown"
                        style="display:none; position:absolute; right:0; top:45px; width:220px; background:#ffffff; box-shadow:0 4px 12px rgba(0,0,0,0.15); border-radius:8px; z-index:1100; overflow:hidden; border:1px solid #CFD8DC;">

                        <div style="background:#0d4c5c; color:white; padding:12px 15px;">

                            <p style="font-size:13px; font-weight:bold; margin:0;">
                                {{ auth()->user()->name ?? 'Community User' }}
                            </p>

                            <p style="font-size:11px; color:#2ADED4; margin:2px 0 0 0;">
                                {{ auth()->user()->email ?? 'user@waterseeker.com' }}
                            </p>

                        </div>

                        <div style="padding:5px 0;">

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                    style="width:100%; background:none; border:none; display:flex; align-items:center; gap:10px; padding:10px 15px; font-size:13px; color:#e74c3c; cursor:pointer;">

                                    <i class="fa-solid fa-right-from-bracket"></i>
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

            <!-- MODULE PURPOSE BANNER -->
            <div class="card"
                style="background:linear-gradient(135deg,#0d4c5c,#0c6a7a); color:white;">

                <h2 style="font-size:18px; margin-bottom:5px; color:#2ADED4;">
                    Submit Formal Water Access Request
                </h2>

                <p style="font-size:13px; color:#E0F7FA;">
                    Select a community water source, provide the required information, and submit your request. The system will validate and save it with a <strong>Pending</strong> status for admin review.
                </p>

            </div>


            <!-- REQUEST FORM CONTAINER -->
            <div class="request-form-card">

                <!-- SUCCESS MESSAGE -->
                @if(session('success'))

                    <div class="alert-pending"
                        id="successAlert"
                        style="display:block; background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px;">

                        <i class="fa-solid fa-circle-check"></i>
                        <strong>Success!</strong>
                        {{ session('success') }}

                    </div>

                @endif


                <!-- VALIDATION ERRORS -->
                @if($errors->any())

                    <div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:8px; margin-bottom:20px;">

                        <strong>Please check the following:</strong>

                        <ul style="margin:8px 0 0 20px;">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                <!-- REQUEST FORM -->
                <form action="{{ route('user.request-access.store') }}" method="POST">

                    @csrf


                    <!-- WATER SOURCE DROPDOWN -->
                    <div class="form-group">

                        <label for="waterSource">
                            Select Water Source
                            <span style="color:#c0392b;">*</span>
                        </label>

                        <select
                            id="waterSource"
                            name="water_source_id"
                            required>

                            <option value="">
                                -- Choose Community Water Source --
                            </option>

                            @forelse($waterSources as $source)

                                <option
                                    value="{{ $source->id }}"
                                    {{ (string) old('water_source_id', $selectedSourceId ?? '') === (string) $source->id ? 'selected' : '' }}>

                                    {{ $source->source_name }}

                                    @if($source->location)
                                        ({{ $source->location }})
                                    @endif

                                </option>

                            @empty

                                <option value="" disabled>
                                    No active water sources available
                                </option>

                            @endforelse

                        </select>

                        @error('water_source_id')
                            <small style="color:#c0392b;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- PREFERRED ACCESS DATE -->
                    <div class="form-group">

                        <label for="preferredDate">
                            Preferred Access Date
                            <span style="color:#c0392b;">*</span>
                        </label>

                        <div style="position:relative;">

                            <input
                                type="text"
                                id="preferredDate"
                                name="preferred_date"
                                value="{{ old('preferred_date') }}"
                                placeholder="Select date..."
                                required
                                style="width:100%; padding-right:35px;">

                            <i
                                class="fa-solid fa-calendar-days"
                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#78909c; pointer-events:none;">
                            </i>

                        </div>

                        @error('preferred_date')
                            <small style="color:#c0392b;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- PURPOSE -->
                    <div class="form-group">

                        <label for="purpose">
                            Purpose of Access / Details
                            <span style="color:#c0392b;">*</span>
                        </label>

                        <textarea
                            id="purpose"
                            name="purpose"
                            rows="4"
                            required
                            placeholder="State your purpose...">{{ old('purpose') }}</textarea>

                        @error('purpose')
                            <small style="color:#c0392b;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- ESTIMATED VOLUME -->
                    <div class="form-group">

                        <label for="estimatedVolume">
                            Estimated Volume / Needs (Optional)
                        </label>

                        <input
                            type="number"
                            id="estimatedVolume"
                            name="estimated_volume"
                            value="{{ old('estimated_volume') }}"
                            placeholder="e.g., 200 Liters"
                            min="0.01"
                            max="1000000"
                            step="0.01">

                        @error('estimated_volume')
                            <small style="color:#c0392b;">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="btn-submit-request">

                        <i class="fa-solid fa-paper-plane"></i>
                        Submit Formal Request

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


<!-- FLATPICKR JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {

    // ==========================================
    // DATE PICKER
    // ==========================================

    flatpickr("#preferredDate", {

        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "F j, Y",
        allowInput: true,
        minDate: "today"

    });


    // ==========================================
    // SEARCH WATER SOURCES IN DROPDOWN
    // ==========================================

    const searchInput = document.getElementById('searchInput');
    const waterSource = document.getElementById('waterSource');

    if (searchInput && waterSource) {

        searchInput.addEventListener('keyup', function (e) {

            const term = e.target.value.toLowerCase().trim();

            Array.from(waterSource.options).forEach(option => {

                if (option.value === '') return;

                option.hidden = !option.text.toLowerCase().includes(term);

            });

        });

    }


    // ==========================================
    // NOTIFICATION DROPDOWN
    // ==========================================

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


    // ==========================================
    // PROFILE DROPDOWN
    // ==========================================

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


    // ==========================================
    // CLOSE DROPDOWNS WHEN CLICKING OUTSIDE
    // ==========================================

    document.addEventListener('click', function () {

        if (notificationDropdown) {
            notificationDropdown.style.display = 'none';
        }

        if (profileDropdown) {
            profileDropdown.style.display = 'none';
        }

    });

});

</script>

</body>
</html>
