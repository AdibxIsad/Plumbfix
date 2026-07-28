<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Login — Plumbfix</title>
    <meta name="description" content="Log in to your Plumbfix account to manage bookings, track your plumber, and access your dashboard.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#2563eb',
                            cyan: '#06b6d4',
                            400: '#22d3ee',
                            500: '#06b6d4',
                            600: '#0891b2',
                            accent: '#f97316',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; }
        html, body {
            height: 100%;
        }
        body {
            background-color: #fafbfe;
            color: #1e293b;
            font-family: 'Outfit', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        /* Custom scrollbar styling for the form side if scrollable */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #fafbfe;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="antialiased min-h-screen lg:h-screen overflow-y-auto lg:overflow-hidden flex flex-col lg:flex-row bg-[#fafbfe]">

    <!-- Top Slim Loading Progress Bar -->
    <div id="top-loading-bar-container" class="fixed top-0 left-0 w-full h-1 z-[9999] pointer-events-none opacity-0 transition-opacity duration-300">
        <div id="top-loading-bar" class="h-full w-0 bg-gradient-to-r from-brand-cyan via-brand-blue to-indigo-500 shadow-[0_0_12px_rgba(6,182,212,0.8)] transition-all duration-300 ease-out"></div>
    </div>

    <!-- Fullscreen Login Progress Loading Overlay (White Theme) -->
    <div id="login-loading-overlay" class="fixed inset-0 z-[9998] bg-slate-900/30 backdrop-blur-md flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-400">
        <div class="w-full max-w-sm sm:max-w-md p-6 sm:p-8 bg-white/95 border border-slate-200/90 rounded-2xl sm:rounded-3xl shadow-2xl text-center relative overflow-hidden group">
            <!-- Background Soft Orbs -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-brand-cyan/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
            <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-brand-blue/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

            <!-- Icon & Logo Header -->
            <div class="relative mb-5 sm:mb-6 inline-block">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-brand-blue via-brand-cyan to-indigo-600 p-0.5 shadow-xl shadow-blue-500/20 mx-auto flex items-center justify-center">
                    <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center">
                        <i class="fa-solid fa-wrench text-brand-blue text-2xl sm:text-3xl animate-bounce" style="animation-duration: 2s;"></i>
                    </div>
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-brand-blue border-2 border-white flex items-center justify-center shadow">
                    <i class="fa-solid fa-bolt text-white text-[9px] sm:text-[10px]"></i>
                </div>
            </div>

            <!-- Title & Status -->
            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight mb-1">Authenticating Session</h3>
            <p id="loading-status-text" class="text-xs text-slate-500 font-medium mb-5 sm:mb-6 transition-all duration-300 min-h-[32px] flex items-center justify-center">
                Verifying user credentials with core matrix...
            </p>

            <!-- Loading Bar Container -->
            <div class="w-full bg-slate-100 rounded-full p-1 border border-slate-200/80 mb-3 relative overflow-hidden shadow-inner">
                <div id="modal-loading-bar" class="h-2.5 rounded-full bg-gradient-to-r from-brand-cyan via-brand-blue to-indigo-600 w-0 transition-all duration-300 ease-out shadow-sm"></div>
            </div>

            <!-- Percentage Badge -->
            <div class="flex justify-end items-center text-xs px-1 font-mono">
                <span id="loading-percentage" class="font-extrabold text-brand-blue text-sm">0%</span>
            </div>
        </div>
    </div>

    <!-- Left Panel: 3D Galaxy Canvas (Visible on LG screens 1024px+) -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-[42%] 2xl:w-[40%] h-screen relative bg-slate-950 overflow-hidden flex-col justify-between p-8 xl:p-12 select-none border-r border-slate-900 shrink-0">
        <!-- Canvas -->
        <canvas id="galaxyCanvas" class="absolute inset-0 w-full h-full object-cover"></canvas>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/10 to-slate-950/30 pointer-events-none"></div>

        <!-- Left Header (Branding) -->
        <div class="relative z-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-2xl xl:text-3xl font-extrabold tracking-tight group">
                <div class="w-10 h-10 xl:w-11 xl:h-11 rounded-xl bg-gradient-to-br from-brand-blue to-brand-cyan flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wrench text-white text-base xl:text-lg"></i>
                </div>
                <span class="text-white">Plumb<span class="text-brand-cyan">fix</span></span>
            </a>
        </div>

        <!-- Left Middle (Futuristic message / features) -->
        <div class="relative z-10 my-auto max-w-md">
            <span class="px-3 py-1 text-xs font-bold tracking-wider text-brand-cyan uppercase bg-brand-cyan/10 border border-brand-cyan/20 rounded-full">
                Next-Gen Service Portal
            </span>
            <h2 class="mt-5 xl:mt-6 text-3xl xl:text-4xl font-extrabold text-white leading-tight">
                Effortless repairs. <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-indigo-400 animate-pulse" style="animation-duration: 4s;">
                    Powered by intelligence.
                </span>
            </h2>
            <p class="mt-3 xl:mt-4 text-slate-400 leading-relaxed text-xs xl:text-sm">
                Access Bangi's first futuristic plumbing ecosystem. Book, track, and manage verified experts on our smart service matrix.
            </p>

            <div class="mt-6 xl:mt-8 space-y-3 xl:space-y-4">
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm shrink-0">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <span class="text-xs xl:text-sm font-medium">Lightning Fast Dispatch & Real-time ETA</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm shrink-0">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <span class="text-xs xl:text-sm font-medium">Instant Dispatch & Status Alerts</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <span class="text-xs xl:text-sm font-medium">Fully Insured & Verified Professionals</span>
                </div>
            </div>
        </div>

        <!-- Left Footer -->
        <div class="relative z-10 flex justify-between items-center text-xs text-slate-500">
            <span>© {{ date('Y') }} Plumbfix. All rights reserved.</span>
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Core Node Active
            </span>
        </div>
    </div>

    <!-- Right Panel: Login Credentials -->
    <div class="w-full lg:w-[55%] xl:w-[58%] 2xl:w-[60%] min-h-screen lg:h-screen bg-[#fafbfe] flex flex-col justify-between overflow-y-auto px-4 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-6 sm:py-10 lg:py-12 relative custom-scrollbar">
        
        <!-- Logo Header (Visible on mobile & tablet < 1024px) -->
        <div class="flex justify-between items-center mb-6 sm:mb-8 lg:hidden shrink-0">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-xl sm:text-2xl font-extrabold tracking-tight">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-gradient-to-br from-brand-blue to-brand-cyan flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-wrench text-white text-xs sm:text-sm"></i>
                </div>
                <span class="text-slate-900">Plumb<span class="text-brand-blue">fix</span></span>
            </a>
            <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-slate-800 transition-colors font-medium flex items-center gap-1 px-2.5 py-1.5 rounded-lg hover:bg-slate-100">
                <i class="fa-solid fa-house text-[10px]"></i> Home
            </a>
        </div>

        <div class="my-auto max-w-sm sm:max-w-md w-full mx-auto py-2 sm:py-4" id="form-container">
            <!-- Header -->
            <div class="mb-6 sm:mb-8" id="login-header-group">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-1.5 sm:mb-2">Welcome back</h1>
                <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">Sign in to manage bookings, track plumbers, and access your dashboard.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-5 p-3.5 sm:p-4 bg-blue-50 border border-blue-200 rounded-xl text-brand-blue text-xs sm:text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check shrink-0 text-base"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 sm:p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-xs sm:text-sm flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation shrink-0 text-base"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate class="space-y-4 sm:space-y-5">
                @csrf

                <!-- Email Field -->
                <div class="form-field">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5 sm:mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                            required
                            placeholder="you@example.com"
                            class="block w-full pl-11 pr-4 py-3 sm:py-3.5 bg-white border {{ $errors->has('email') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-base sm:text-[15px] min-h-[48px]"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-field">
                    <div class="flex justify-between items-center mb-1.5 sm:mb-2 gap-2">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            class="block w-full pl-11 pr-12 py-3 sm:py-3.5 bg-white border {{ $errors->has('password') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-base sm:text-[15px] min-h-[48px]"
                        >
                        <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-slate-400 hover:text-brand-blue transition-colors focus:outline-none min-w-[44px]" id="togglePassword" aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye text-base" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password Row -->
                <div class="flex items-center justify-between gap-2 form-field pt-0.5">
                    <label for="remember" class="inline-flex items-center gap-2 text-xs sm:text-sm text-slate-600 cursor-pointer select-none py-1">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-300 text-brand-blue focus:ring-brand-blue cursor-pointer shrink-0" {{ old('remember') ? 'checked' : '' }}>
                        <span>Keep me signed in</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-brand-blue hover:text-blue-700 font-bold transition-colors shrink-0">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginBtn" class="form-field w-full min-h-[48px] py-3.5 px-4 bg-brand-blue hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/10 hover:shadow-blue-600/25 transition-all hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-brand-blue/20 flex items-center justify-center text-sm sm:text-base">
                    <span id="btnText" class="flex items-center justify-center gap-2">
                        Sign In <i class="fa-solid fa-arrow-right text-xs"></i>
                    </span>
                    <span id="btnLoader" class="hidden items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5 text-white" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Signing in...
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6 sm:my-7 form-field" id="divider-group">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200/80"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-[#fafbfe] px-3 text-slate-400 font-bold tracking-wider">or continue with</span>
                </div>
            </div>

            <!-- Google Sign-In Button -->
            <a href="{{ route('auth.google') }}" id="googleBtn" class="form-field flex items-center justify-center gap-3 w-full min-h-[48px] py-3.5 px-4 rounded-xl border border-slate-200 bg-white text-slate-700 hover:border-brand-blue hover:bg-slate-50 hover:text-brand-blue font-semibold transition-all shadow-sm text-sm sm:text-base">
                <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                Sign in with Google
            </a>

            <!-- Register Link -->
            @if (Route::has('register'))
            <p class="text-center text-xs sm:text-sm text-slate-500 mt-6 sm:mt-8 form-field" id="register-redirect">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand-blue hover:text-blue-700 font-bold transition-colors ml-1 inline-block py-1">
                    Create one free
                </a>
            </p>
            @endif
        </div>

        <!-- Back Link -->
        <div class="mt-6 sm:mt-8 text-center text-xs text-slate-400 relative z-10 shrink-0 py-2" id="back-home-footer">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 hover:text-slate-600 transition-colors font-medium py-1 px-2.5 rounded-lg hover:bg-slate-100">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Plumbfix Home
            </a>
        </div>
    </div>

    <!-- GSAP for Micro-animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput  = document.getElementById('password');
        const toggleIcon     = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleIcon.className = isHidden ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });

        // Interactive Loading Bar & Progress Overlay Sequence
        const loginForm = document.getElementById('loginForm');
        const loginBtn  = document.getElementById('loginBtn');
        const btnText   = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');
        const topBarContainer = document.getElementById('top-loading-bar-container');
        const topBar = document.getElementById('top-loading-bar');
        const loadingOverlay = document.getElementById('login-loading-overlay');
        const modalLoadingBar = document.getElementById('modal-loading-bar');
        const loadingPercentage = document.getElementById('loading-percentage');
        const loadingStatusText = document.getElementById('loading-status-text');

        let loadingInterval = null;

        function resetLoginLoadingState() {
            if (loadingInterval) clearInterval(loadingInterval);
            if (topBarContainer) topBarContainer.classList.add('opacity-0');
            if (loadingOverlay) {
                loadingOverlay.classList.add('opacity-0', 'pointer-events-none');
            }
            if (loginBtn) loginBtn.disabled = false;
            if (btnText) btnText.classList.remove('hidden');
            if (btnLoader) {
                btnLoader.classList.add('hidden');
                btnLoader.classList.remove('flex');
            }
            if (topBar) topBar.style.width = '0%';
            if (modalLoadingBar) modalLoadingBar.style.width = '0%';
            if (loadingPercentage) loadingPercentage.textContent = '0%';
            if (loadingStatusText) loadingStatusText.textContent = 'Verifying user credentials with core matrix...';
        }

        // Reset state on back/forward browser navigation (BFCache pageshow)
        window.addEventListener('pageshow', resetLoginLoadingState);
        window.addEventListener('popstate', resetLoginLoadingState);

        function triggerDashboardLoadingSequence() {
            resetLoginLoadingState();

            if (topBarContainer) topBarContainer.classList.remove('opacity-0');
            if (loadingOverlay) {
                loadingOverlay.classList.remove('opacity-0', 'pointer-events-none');
            }

            let progress = 0;
            const statusSteps = [
                { threshold: 0, text: 'Verifying user credentials...' },
                { threshold: 30, text: 'Establishing secure session...' },
                { threshold: 65, text: 'Preparing Dashboard workspace...' },
                { threshold: 90, text: 'Welcome back! Launching Dashboard...' }
            ];

            loadingInterval = setInterval(() => {
                if (progress < 95) {
                    const diff = Math.floor(Math.random() * 8) + 4;
                    progress = Math.min(95, progress + diff);

                    if (topBar) topBar.style.width = progress + '%';
                    if (modalLoadingBar) modalLoadingBar.style.width = progress + '%';
                    if (loadingPercentage) loadingPercentage.textContent = progress + '%';

                    for (let i = statusSteps.length - 1; i >= 0; i--) {
                        if (progress >= statusSteps[i].threshold) {
                            if (loadingStatusText && loadingStatusText.textContent !== statusSteps[i].text) {
                                loadingStatusText.style.opacity = '0';
                                setTimeout(() => {
                                    loadingStatusText.textContent = statusSteps[i].text;
                                    loadingStatusText.style.opacity = '1';
                                }, 150);
                            }
                            break;
                        }
                    }
                } else {
                    clearInterval(loadingInterval);
                }
            }, 100);
        }

        if (loginForm) {
            loginForm.addEventListener('submit', () => {
                btnText.classList.add('hidden');
                btnLoader.classList.remove('hidden');
                btnLoader.classList.add('flex');
                loginBtn.disabled = true;

                triggerDashboardLoadingSequence();
            });
        }

        const googleBtn = document.getElementById('googleBtn');
        if (googleBtn) {
            googleBtn.addEventListener('click', () => {
                triggerDashboardLoadingSequence();
            });
        }

        // GSAP form elements staggered sweep in
        gsap.fromTo('#login-header-group',
            { opacity: 0, x: 30 },
            { opacity: 1, x: 0, duration: 0.6, ease: 'power2.out' }
        );
        gsap.fromTo('.form-field',
            { opacity: 0, y: 15 },
            { opacity: 1, y: 0, stagger: 0.05, duration: 0.5, ease: 'power2.out', delay: 0.15 }
        );
        gsap.fromTo('#back-home-footer',
            { opacity: 0 },
            { opacity: 1, duration: 0.4, ease: 'power2.out', delay: 0.5 }
        );
    </script>

    <!-- 3D Big Galaxy Canvas script -->
    <script>
        (function() {
            const canvas = document.getElementById('galaxyCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            function updateCanvasSize() {
                if (!canvas || !canvas.offsetWidth || !canvas.offsetHeight) return;
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
                maxRadius = Math.min(width, height) * 0.72;
                initStarfield();
            }

            let width = canvas.offsetWidth || 500;
            let height = canvas.offsetHeight || 500;

            window.addEventListener('resize', updateCanvasSize);

            // 1. TWINKLING BACKGROUND STARS
            let backgroundStars = [];
            function initStarfield() {
                backgroundStars = [];
                const starCount = Math.floor((width * height) * 0.0003);
                for (let i = 0; i < Math.max(40, starCount); i++) {
                    backgroundStars.push({
                        x: Math.random() * width,
                        y: Math.random() * height * 0.8,
                        size: Math.random() * 1.0 + 0.2,
                        alpha: Math.random() * 0.6 + 0.2,
                        twinkleSpeed: 0.006 + Math.random() * 0.01,
                        twinkleDir: Math.random() > 0.5 ? 1 : -1
                    });
                }
            }
            updateCanvasSize();

            // 2. DYNAMIC SHOOTING STARS
            class ShootingStar {
                constructor() {
                    this.reset();
                    this.y = -999;
                    this.active = false;
                }

                reset() {
                    this.x = Math.random() * width * 0.8;
                    this.y = Math.random() * height * 0.3;
                    this.speed = Math.random() * 10 + 10;
                    this.angle = Math.PI / 6 + (Math.random() - 0.5) * 0.1; // down-right
                    this.length = Math.random() * 90 + 50;
                    this.vx = Math.cos(this.angle) * this.speed;
                    this.vy = Math.sin(this.angle) * this.speed;
                    this.opacity = Math.random() * 0.5 + 0.5;
                    this.active = true;
                }

                update() {
                    if (!this.active) return;
                    this.x += this.vx;
                    this.y += this.vy;
                    this.opacity -= 0.015;
                    if (this.opacity <= 0 || this.x > width || this.y > height) {
                        this.active = false;
                    }
                }

                draw() {
                    if (!this.active) return;
                    ctx.beginPath();
                    const grad = ctx.createLinearGradient(
                        this.x - this.vx * (this.length / this.speed),
                        this.y - this.vy * (this.length / this.speed),
                        this.x,
                        this.y
                    );
                    grad.addColorStop(0, 'rgba(255, 255, 255, 0)');
                    grad.addColorStop(0.8, `rgba(224, 242, 254, ${this.opacity * 0.8})`);
                    grad.addColorStop(1, `rgba(255, 255, 255, ${this.opacity})`);
                    
                    ctx.strokeStyle = grad;
                    ctx.lineWidth = 1.5;
                    ctx.moveTo(this.x - this.vx * (this.length / this.speed), this.y - this.vy * (this.length / this.speed));
                    ctx.lineTo(this.x, this.y);
                    ctx.stroke();
                }
            }

            const shootingStars = [new ShootingStar(), new ShootingStar()];

            // 3. 3D ROTATING SPIRAL GALAXY (BIG GALAXY)
            const particles = [];
            const numParticles = 1350;
            const spiralArms = 3;
            let maxRadius = Math.min(width, height) * 0.72; // Make it a big galaxy!

            const colorTemplates = [
                'rgba(6, 182, 212, opacity)',   // Cyan
                'rgba(37, 99, 235, opacity)',   // Blue
                'rgba(139, 92, 246, opacity)',  // Purple
                'rgba(249, 115, 22, opacity)',   // Orange
                'rgba(255, 255, 255, opacity)'   // White
            ];

            class GalaxyParticle {
                constructor() {
                    this.reset();
                }

                reset() {
                    // Exponential core concentration
                    this.r = Math.pow(Math.random(), 3.2) * maxRadius + 3;
                    this.arm = Math.floor(Math.random() * spiralArms);
                    this.theta = Math.random() * Math.PI * 2;
                    
                    const pick = Math.random();
                    if (pick < 0.42) {
                        this.colorBase = colorTemplates[0]; // Cyan
                    } else if (pick < 0.68) {
                        this.colorBase = colorTemplates[1]; // Blue
                    } else if (pick < 0.83) {
                        this.colorBase = colorTemplates[2]; // Purple
                    } else if (pick < 0.94) {
                        this.colorBase = colorTemplates[3]; // Orange
                    } else {
                        this.colorBase = colorTemplates[4]; // White
                    }

                    // Spread offset along spiral arms
                    const dispersion = (maxRadius - this.r) * 0.22;
                    this.offsetX = (Math.random() - 0.5) * dispersion;
                    this.offsetY = (Math.random() - 0.5) * dispersion;
                    this.z = (Math.random() - 0.5) * dispersion * 0.45; // Flat disc structure
                    
                    // Orbit velocity based on distance from core
                    this.speed = (0.0035 + (Math.random() * 0.002)) * (1 - (this.r / maxRadius) * 0.75);
                    this.size = Math.random() * 1.1 + 0.35;
                    if (Math.random() > 0.985) this.size = Math.random() * 2.3 + 1.2; // Giant stars
                }

                update() {
                    this.theta += this.speed;
                }

                getCoords(cosP, sinP, cosY, sinY) {
                    const armAngle = (this.arm * (Math.PI * 2 / spiralArms)) + (this.r * 0.015);
                    const angle = this.theta + armAngle;

                    let x3d = Math.cos(angle) * this.r + this.offsetX;
                    let y3d = this.offsetY;
                    let z3d = Math.sin(angle) * this.r + this.z;

                    // Rotate pitch (X-axis)
                    let tempY = y3d * cosP - z3d * sinP;
                    let tempZ = y3d * sinP + z3d * cosP;
                    y3d = tempY;
                    z3d = tempZ;

                    // Rotate yaw (Y-axis)
                    let tempX = x3d * cosY - z3d * sinY;
                    z3d = x3d * sinY + z3d * cosY;
                    x3d = tempX;

                    // 3D Projection
                    const fov = 350;
                    const scale = fov / (fov + z3d);
                    const screenX = width / 2 + x3d * scale;
                    const screenY = height / 2 + y3d * scale;

                    return {
                        x: screenX,
                        y: screenY,
                        z: z3d,
                        size: this.size * scale,
                        color: this.colorBase,
                        scale: scale,
                        r: this.r
                    };
                }
            }

            // Populate particles
            for (let i = 0; i < numParticles; i++) {
                particles.push(new GalaxyParticle());
            }

            // Mouse interaction coordinates
            let curMouseX = width / 2;
            let curMouseY = height / 2;
            let targetMouseX = width / 2;
            let targetMouseY = height / 2;

            window.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                if (e.clientX >= rect.left && e.clientX <= rect.right) {
                    targetMouseX = e.clientX - rect.left;
                    targetMouseY = e.clientY - rect.top;
                }
            });

            function animate(timestamp) {
                // Outer space background gradient
                const bgGrad = ctx.createRadialGradient(
                    width * 0.3, height * 0.2, 50,
                    width * 0.5, height * 0.5, Math.max(width, height) * 0.8
                );
                bgGrad.addColorStop(0, '#0a0927'); // Cosmic indigo core
                bgGrad.addColorStop(0.5, '#020412');
                bgGrad.addColorStop(1, '#000000');
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, width, height);

                ctx.globalCompositeOperation = 'screen';

                // A. Twinkling background stars
                backgroundStars.forEach(star => {
                    star.alpha += star.twinkleSpeed * star.twinkleDir;
                    if (star.alpha >= 0.95) {
                        star.alpha = 0.95;
                        star.twinkleDir = -1;
                    } else if (star.alpha <= 0.15) {
                        star.alpha = 0.15;
                        star.twinkleDir = 1;
                    }
                    ctx.beginPath();
                    ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(240, 249, 255, ${star.alpha})`;
                    ctx.fill();
                });

                // B. Easing coordinates for parallax hover tilt
                curMouseX += (targetMouseX - curMouseX) * 0.05;
                curMouseY += (targetMouseY - curMouseY) * 0.05;

                const pitch = Math.PI / 3.2 + (curMouseY / height - 0.5) * 0.25;
                const yaw = (curMouseX / width - 0.5) * 0.25;

                const cosP = Math.cos(pitch);
                const sinP = Math.sin(pitch);
                const cosY = Math.cos(yaw);
                const sinY = Math.sin(yaw);

                // C. Project coordinates
                const projected = [];
                particles.forEach(p => {
                    p.update();
                    const coords = p.getCoords(cosP, sinP, cosY, sinY);
                    if (coords.x > -20 && coords.x < width + 20 && coords.y > -20 && coords.y < height + 20) {
                        projected.push(coords);
                    }
                });

                // D. Depth sorting (draw further particles first)
                projected.sort((a, b) => b.z - a.z);

                // E. Draw Core Glow
                const coreGlow = ctx.createRadialGradient(
                    width / 2, height / 2, 0,
                    width / 2, height / 2, maxRadius * 0.25
                );
                coreGlow.addColorStop(0, 'rgba(6, 182, 212, 0.24)');
                coreGlow.addColorStop(0.5, 'rgba(139, 92, 246, 0.08)');
                coreGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                ctx.fillStyle = coreGlow;
                ctx.fillRect(0, 0, width, height);

                // F. Draw Sorted Particles
                projected.forEach(coords => {
                    const depthOpacity = Math.max(0.12, Math.min(1.0, (350 - coords.z) / 450));
                    const edgeFade = 1.0 - (coords.r / maxRadius);
                    const opacity = depthOpacity * edgeFade * 0.9;

                    ctx.beginPath();
                    ctx.arc(coords.x, coords.y, coords.size, 0, Math.PI * 2);
                    ctx.fillStyle = coords.color.replace('opacity', opacity.toFixed(3));
                    if (coords.size > 2.0) {
                        ctx.shadowBlur = 4;
                        ctx.shadowColor = coords.color.replace('opacity', '1');
                    }
                    ctx.fill();
                    ctx.shadowBlur = 0;
                });

                // G. Update & Draw Shooting stars
                shootingStars.forEach(star => {
                    if (!star.active && Math.random() < 0.007) {
                        star.reset();
                    }
                    star.update();
                    star.draw();
                });

                ctx.globalCompositeOperation = 'source-over';

                requestAnimationFrame(animate);
            }

            requestAnimationFrame(animate);
        })();
    </script>
</body>
</html>
