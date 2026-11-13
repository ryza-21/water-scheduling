<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Water Seeker | Register</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/log_in.css') }}">
    <style>
        /* Pag-adjust sa card width para moigo ang 2 columns */
        .login-container {
            max-width: 650px !important;
            width: 95% !important;
        }
        /* Grid layout para sa duha ka kolum per row */
        .form-grid-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            text-align: left;
        }
        .form-grid-2col .full-width {
            grid-column: span 2;
        }
        @media (max-width: 600px) {
            .form-grid-2col {
                grid-template-columns: 1fr;
            }
            .form-grid-2col .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">

        <header class="header-section">
            <div class="logo-icon">
                <i class="fa-solid fa-droplet"></i>
            </div>

            <h1>WATER SEEKER</h1>
            <h2>CREATE ACCOUNT</h2>
            <p class="header-subtitle">Sign up to get started</p>
        </header>

        <form class="login-form"
              id="registerForm"
              method="POST"
              action="{{ route('register.submit') }}">

            @csrf

            <div class="form-grid-2col">
                <!-- Account Type (Full width) -->
                <div class="full-width">
                    <label class="field-label" for="role">Account type</label>
                    <div class="input-group role-dropdown">
                        <i class="fa-solid fa-users role-icon" aria-hidden="true"></i>
                        <select name="role" id="role" required>
                            <option value="community" {{ old('role', 'community') == 'community' ? 'selected' : '' }}>
                                User / Community
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Administrator
                            </option>
                        </select>
                        <i class="fa-solid fa-chevron-down role-arrow" aria-hidden="true"></i>
                    </div>
                </div>

                <!-- Full Name / Username (Full width) -->
                <div class="full-width">
                    <label class="field-label" for="name">Full Name or Username</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user" aria-hidden="true"></i>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Enter your name or username"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required>
                    </div>
                </div>

                <!-- Email Address (Full width) -->
                <div class="full-width">
                    <label class="field-label" for="email">Email Address</label>
                    <div class="input-group">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Enter your email address"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required>
                    </div>
                </div>

                <!-- Password (Kolum sa Wala) -->
                <div>
                    <label class="field-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Password"
                            autocomplete="new-password"
                            required>
                    </div>
                </div>

                <!-- Confirm Password (Kolum sa Tuo) -->
                <div>
                    <label class="field-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock" aria-hidden="true"></i>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Confirm password"
                            autocomplete="new-password"
                            required>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="error-message" role="alert" style="color: #ef4444; font-size: 12px; margin: 15px 0 5px 0; text-align: left;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit" class="login-btn" style="margin-top: 20px;">
                <span>REGISTER</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <footer class="footer-banner">
            <span>Already have an account?</span>
            <a href="{{ url('/login') }}" class="banner-code">Login</a>
        </footer>

    </main>
</body>
</html>