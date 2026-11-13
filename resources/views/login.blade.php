
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Water Seeker | Login</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/log_in.css') }}">
</head>

<body>
    <main class="login-container">

        <header class="header-section">
            <div class="logo-icon">
                <i class="fa-solid fa-droplet"></i>
            </div>

            <h1>WATER SEEKER</h1>
            <h2>PROJECT LOGIN</h2>
            <p class="header-subtitle">
                Sign in to continue to your account
            </p>
        </header>

        <form class="login-form"
              id="loginForm"
              method="POST"
              action="{{ route('login.submit') }}">

            @csrf

            <label class="field-label" for="role">
                Account type
            </label>

            <div class="input-group role-dropdown">
                <i class="fa-solid fa-users role-icon" aria-hidden="true"></i>

                <select name="role" id="role" required>
                    <option value="community_user"
                        {{ old('role', 'community_user') == 'community_user' ? 'selected' : '' }}>
                        Community
                    </option>

                    <option value="admin"
                        {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>

                <i class="fa-solid fa-chevron-down role-arrow"
                   aria-hidden="true"></i>
            </div>

            <label class="field-label" for="username">
                Username or email
            </label>

            <div class="input-group">
                <i class="fa-solid fa-user" aria-hidden="true"></i>

                <input
                    type="text"
                    name="username"
                    id="username"
                    placeholder="Enter your username or email"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    required>
            </div>

            <label class="field-label" for="password">
                Password
            </label>

            <div class="input-group">
                <i class="fa-solid fa-lock" aria-hidden="true"></i>

                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required>

                <button type="button"
                        class="toggle-password"
                        id="togglePassword"
                        aria-label="Show password"
                        aria-pressed="false">

                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                </button>
            </div>

            @if ($errors->any())
                <div class="error-message" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="forgot-password">
                <a href="{{ url('/forgot-password') }}">
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="login-btn">
                <span>LOGIN</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>

        </form>

        <footer class="footer-banner">
            <span>Don't have an account?</span>

            <a href="{{ route('register') }}" class="banner-code">
                Register
            </a>
        </footer>

    </main>

    <script src="{{ asset('assets/js/log_in.js') }}" defer></script>
</body>
</html>
