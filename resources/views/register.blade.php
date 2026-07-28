<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up — Plumbfix</title>
    <meta name="description" content="Create your free Plumbfix customer account to book expert plumbing services in Bangi instantly.">

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
        body {
            background-color: #fafbfe;
            color: #1e293b;
            font-family: 'Outfit', sans-serif;
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
        .strength-bar { height: 4px; border-radius: 4px; flex: 1; transition: background 0.4s; background: rgba(148,163,184,0.3); }
    </style>
</head>
<body class="antialiased min-h-screen overflow-hidden flex flex-col lg:flex-row bg-[#fafbfe]">

    <!-- Left Panel: 3D Galaxy Canvas (45%) -->
    <div class="hidden lg:flex lg:w-[45%] h-screen relative bg-slate-950 overflow-hidden flex-col justify-between p-12 select-none border-r border-slate-900">
        <!-- Canvas -->
        <canvas id="galaxyCanvas" class="absolute inset-0 w-full h-full object-cover"></canvas>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/10 to-slate-950/30 pointer-events-none"></div>

        <!-- Left Header (Branding) -->
        <div class="relative z-10">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-3xl font-extrabold tracking-tight group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-brand-blue to-brand-cyan flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wrench text-white text-lg"></i>
                </div>
                <span class="text-white">Plumb<span class="text-brand-cyan">fix</span></span>
            </a>
        </div>

        <!-- Left Middle (Futuristic message / features) -->
        <div class="relative z-10 my-auto max-w-md">
            <span class="px-3 py-1 text-xs font-bold tracking-wider text-brand-cyan uppercase bg-brand-cyan/10 border border-brand-cyan/20 rounded-full">
                Next-Gen Service Portal
            </span>
            <h2 class="mt-6 text-4xl font-extrabold text-white leading-tight">
                Effortless repairs. <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-indigo-400 animate-pulse" style="animation-duration: 4s;">
                    Powered by intelligence.
                </span>
            </h2>
            <p class="mt-4 text-slate-400 leading-relaxed text-sm">
                Access Bangi's first futuristic plumbing ecosystem. Book, track, and manage verified experts on our smart service matrix.
            </p>

            <div class="mt-8 space-y-4">
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <span class="text-sm font-medium">Lightning Fast Dispatch & Real-time ETA</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <span class="text-sm font-medium">Instant Dispatch & Status Alerts</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <div class="w-8 h-8 rounded-lg bg-slate-900/80 border border-slate-800 flex items-center justify-center text-brand-cyan text-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <span class="text-sm font-medium">Fully Insured & Verified Professionals</span>
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

    <!-- Right Panel: Registration Form (55%) -->
    <div class="w-full lg:w-[55%] h-screen bg-[#fafbfe] flex flex-col justify-between overflow-y-auto px-6 py-8 md:p-12 lg:p-16 relative custom-scrollbar">
        
        <!-- Logo (Visible on mobile only) -->
        <div class="flex justify-between items-center mb-6 lg:hidden">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-2xl font-extrabold tracking-tight">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-brand-blue to-brand-cyan flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-wrench text-white text-sm"></i>
                </div>
                <span class="text-slate-900">Plumb<span class="text-brand-blue">fix</span></span>
            </a>
            <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-slate-800 transition-colors font-medium">
                Back to Home
            </a>
        </div>

        <div class="my-auto max-w-md w-full mx-auto" id="form-container">
            <!-- Header -->
            <div class="mb-6" id="register-header-group">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Create account</h1>
                <p class="text-slate-500 text-sm">Join thousands of customers who trust Plumbfix.</p>
            </div>

            <!-- Benefits Strip -->
            <div class="grid grid-cols-3 gap-2 border border-slate-100 bg-white rounded-xl p-3 mb-6 text-center shadow-sm form-field">
                <div class="flex flex-col items-center justify-center">
                    <i class="fa-solid fa-bolt text-brand-blue text-sm mb-1.5 block"></i>
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Instant Booking</span>
                </div>
                <div class="flex flex-col items-center justify-center border-x border-slate-100">
                    <i class="fa-solid fa-bell text-brand-blue text-sm mb-1.5 block"></i>
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Status Alerts</span>
                </div>
                <div class="flex flex-col items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-brand-blue text-sm mb-1.5 block"></i>
                    <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Verified Experts</span>
                </div>
            </div>

            <!-- Errors display -->
            @if ($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex gap-3">
                    <i class="fa-solid fa-triangle-exclamation mt-0.5 shrink-0"></i>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('register.post') }}" id="registerForm" novalidate class="space-y-4">
                @csrf

                <!-- Full Name -->
                <div class="form-field">
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-user"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            autocomplete="name" required placeholder="e.g. Ahmad bin Abdullah"
                            class="block w-full pl-11 pr-4 py-3 bg-white border {{ $errors->has('name') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-field">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            autocomplete="email" required placeholder="you@example.com"
                            class="block w-full pl-11 pr-4 py-3 bg-white border {{ $errors->has('email') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-field">
                    <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 px-4 flex items-center text-slate-500 font-bold border-r border-slate-200 pointer-events-none bg-slate-50 rounded-l-xl text-sm">
                            🇲🇾 +60
                        </span>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                            autocomplete="tel" placeholder="12-345 6789"
                            class="block w-full pl-24 pr-4 py-3 bg-white border {{ $errors->has('phone') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-field">
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Address <span class="text-slate-400 font-normal lowercase">(optional)</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <textarea id="address" name="address" rows="2"
                            placeholder="No. 12, Jalan Damai, Bangi, Selangor..."
                            class="block w-full pl-11 pr-4 py-3 bg-white border {{ $errors->has('address') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm resize-none">{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-field">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input id="password" type="password" name="password"
                            autocomplete="new-password" required placeholder="Min. 8 characters"
                            class="block w-full pl-11 pr-12 py-3 bg-white border {{ $errors->has('password') ? 'border-red-400 ring-2 ring-red-500/10' : 'border-slate-200' }} rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm"
                            oninput="checkStrength(this.value)">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-brand-blue transition-colors" id="togglePw1" aria-label="Toggle password">
                            <i class="fa-regular fa-eye" id="pwIcon1"></i>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="flex gap-1.5 mt-2" id="strengthBars">
                        <div class="strength-bar" id="bar1"></div>
                        <div class="strength-bar" id="bar2"></div>
                        <div class="strength-bar" id="bar3"></div>
                        <div class="strength-bar" id="bar4"></div>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 font-medium" id="strengthLabel">Enter a password</p>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-field">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock-open"></i>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            autocomplete="new-password" required placeholder="Re-enter your password"
                            class="block w-full pl-11 pr-12 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10 transition-all text-sm">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-brand-blue transition-colors" id="togglePw2" aria-label="Toggle confirm password">
                            <i class="fa-regular fa-eye" id="pwIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-3 pt-1 form-field">
                    <input type="checkbox" id="terms" name="terms" class="w-4 h-4 rounded border-slate-300 text-brand-blue focus:ring-brand-blue cursor-pointer mt-0.5" required>
                    <label for="terms" class="text-xs text-slate-500 leading-relaxed cursor-pointer select-none">
                        I agree to the
                        <a href="#" class="text-brand-blue hover:text-blue-700 font-bold transition-colors">Terms of Service</a>
                        and
                        <a href="#" class="text-brand-blue hover:text-blue-700 font-bold transition-colors">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" id="registerBtn" class="form-field w-full py-3.5 px-4 bg-brand-blue hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/10 hover:shadow-blue-600/25 transition-all hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-brand-blue/20">
                    <span id="btnText" class="flex items-center justify-center gap-2">
                        Create My Account <i class="fa-solid fa-arrow-right text-xs"></i>
                    </span>
                    <span id="btnLoader" class="hidden items-center justify-center gap-2">
                        <svg class="animate-spin w-5 h-5 text-white" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Creating account...
                    </span>
                </button>
            </form>

            <!-- Divider + Login Link -->
            <div class="relative my-6 form-field">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-100"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-[#fafbfe] px-3 text-slate-400 font-bold tracking-wider">already have an account?</span>
                </div>
            </div>

            <a href="{{ route('login') }}" class="form-field flex items-center justify-center gap-2 w-full py-3 rounded-xl border border-slate-200 text-slate-600 hover:border-brand-blue/50 hover:text-brand-blue hover:bg-blue-50/20 transition-all text-sm font-semibold shadow-sm bg-white">
                <i class="fa-solid fa-right-to-bracket text-brand-blue"></i>
                Sign in to existing account
            </a>
        </div>

        <!-- Back Link -->
        <div class="mt-8 text-center text-xs text-slate-400 relative z-10" id="back-home-footer">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 hover:text-slate-600 transition-colors font-medium">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Plumbfix Home
            </a>
        </div>
    </div>

    <!-- GSAP for Micro-animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        // Password toggle helpers
        function makeToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            if (!btn) return;
            btn.addEventListener('click', () => {
                const input = document.getElementById(inputId);
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                document.getElementById(iconId).className = isHidden ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
            });
        }
        makeToggle('togglePw1', 'password', 'pwIcon1');
        makeToggle('togglePw2', 'password_confirmation', 'pwIcon2');

        // Password strength checker
        function checkStrength(val) {
            const bars   = [1,2,3,4].map(i => document.getElementById('bar'+i));
            const label  = document.getElementById('strengthLabel');
            const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
            const labels = ['Too weak','Weak','Good','Strong'];

            let score = 0;
            if (val.length >= 8)   score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            if (val.length === 0) {
                bars.forEach(b => b.style.background = 'rgba(148,163,184,0.3)');
                label.textContent = 'Enter a password';
                label.style.color = '#94a3b8';
                return;
            }

            bars.forEach((b, i) => {
                b.style.background = i < score ? colors[score - 1] : 'rgba(148,163,184,0.3)';
            });
            label.textContent  = labels[score - 1] || 'Too weak';
            label.style.color  = colors[score - 1] || colors[0];
        }

        // Terms checkbox validation & loading indicator triggers
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!document.getElementById('terms').checked) {
                e.preventDefault();
                alert('Please agree to the Terms of Service to continue.');
                return;
            }
            document.getElementById('btnText').classList.add('hidden');
            document.getElementById('btnLoader').classList.remove('hidden');
            document.getElementById('btnLoader').classList.add('flex');
            document.getElementById('registerBtn').disabled = true;
        });

        // GSAP staggered entrance animations
        gsap.fromTo('#register-header-group',
            { opacity: 0, x: 30 },
            { opacity: 1, x: 0, duration: 0.6, ease: 'power2.out' }
        );
        gsap.fromTo('.form-field',
            { opacity: 0, y: 15 },
            { opacity: 1, y: 0, stagger: 0.04, duration: 0.5, ease: 'power2.out', delay: 0.15 }
        );
        gsap.fromTo('#back-home-footer',
            { opacity: 0 },
            { opacity: 1, duration: 0.4, ease: 'power2.out', delay: 0.6 }
        );
    </script>

    <!-- 3D Big Galaxy Canvas script -->
    <script>
        (function() {
            const canvas = document.getElementById('galaxyCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            
            let width = canvas.width = canvas.offsetWidth;
            let height = canvas.height = canvas.offsetHeight;

            window.addEventListener('resize', () => {
                if (!canvas) return;
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
                initStarfield();
            });

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
            initStarfield();

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

            window.addEventListener('resize', () => {
                maxRadius = Math.min(width, height) * 0.72;
            });

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

                    const dispersion = (maxRadius - this.r) * 0.22;
                    this.offsetX = (Math.random() - 0.5) * dispersion;
                    this.offsetY = (Math.random() - 0.5) * dispersion;
                    this.z = (Math.random() - 0.5) * dispersion * 0.45;
                    
                    this.speed = (0.0035 + (Math.random() * 0.002)) * (1 - (this.r / maxRadius) * 0.75);
                    this.size = Math.random() * 1.1 + 0.35;
                    if (Math.random() > 0.985) this.size = Math.random() * 2.3 + 1.2;
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

                    let tempY = y3d * cosP - z3d * sinP;
                    let tempZ = y3d * sinP + z3d * cosP;
                    y3d = tempY;
                    z3d = tempZ;

                    let tempX = x3d * cosY - z3d * sinY;
                    z3d = x3d * sinY + z3d * cosY;
                    x3d = tempX;

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

            for (let i = 0; i < numParticles; i++) {
                particles.push(new GalaxyParticle());
            }

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
                const bgGrad = ctx.createRadialGradient(
                    width * 0.3, height * 0.2, 50,
                    width * 0.5, height * 0.5, Math.max(width, height) * 0.8
                );
                bgGrad.addColorStop(0, '#0a0927');
                bgGrad.addColorStop(0.5, '#020412');
                bgGrad.addColorStop(1, '#000000');
                ctx.fillStyle = bgGrad;
                ctx.fillRect(0, 0, width, height);

                ctx.globalCompositeOperation = 'screen';

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

                curMouseX += (targetMouseX - curMouseX) * 0.05;
                curMouseY += (targetMouseY - curMouseY) * 0.05;

                const pitch = Math.PI / 3.2 + (curMouseY / height - 0.5) * 0.25;
                const yaw = (curMouseX / width - 0.5) * 0.25;

                const cosP = Math.cos(pitch);
                const sinP = Math.sin(pitch);
                const cosY = Math.cos(yaw);
                const sinY = Math.sin(yaw);

                const projected = [];
                particles.forEach(p => {
                    p.update();
                    const coords = p.getCoords(cosP, sinP, cosY, sinY);
                    if (coords.x > -20 && coords.x < width + 20 && coords.y > -20 && coords.y < height + 20) {
                        projected.push(coords);
                    }
                });

                projected.sort((a, b) => b.z - a.z);

                const coreGlow = ctx.createRadialGradient(
                    width / 2, height / 2, 0,
                    width / 2, height / 2, maxRadius * 0.25
                );
                coreGlow.addColorStop(0, 'rgba(6, 182, 212, 0.24)');
                coreGlow.addColorStop(0.5, 'rgba(139, 92, 246, 0.08)');
                coreGlow.addColorStop(1, 'rgba(0, 0, 0, 0)');
                ctx.fillStyle = coreGlow;
                ctx.fillRect(0, 0, width, height);

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
