<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plumbfix — Expert Plumbing in Bangi, Selangor</title>
    <meta name="description" content="Plumbfix connects you with certified master plumbers in Bangi in under 60 seconds. Book instantly, get updates, pay transparently.">
    <meta name="keywords" content="plumbing, plumber, bangi, selangor, leak repair, pipe installation, maintenance, emergency plumber">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Plumbfix — Expert Plumbing in Bangi">
    <meta property="og:description" content="Rapid, transparent plumbing services. Book a certified plumber in under 60 seconds.">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cyan: #06b6d4;
            --cyan-dark: #0891b2;
            --cyan-darker: #0e7490;
            --orange: #f97316;
            --orange-dark: #ea580c;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-500: #64748b;
            --slate-400: #94a3b8;
            --slate-300: #cbd5e1;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;
            --white: #ffffff;
            --transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--slate-50);
            color: var(--slate-900);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
           SCROLLBAR
        ═══════════════════════════════════════ */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--slate-100); }
        ::-webkit-scrollbar-thumb { background: var(--slate-300); border-radius: 99px; }

        /* ═══════════════════════════════════════
           UTILITY CLASSES
        ═══════════════════════════════════════ */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .glass {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.8);
        }

        .glass-dark {
            background: rgba(15,23,42,0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--cyan), var(--cyan-dark));
            color: white;
            font-weight: 700;
            font-size: 15px;
            border-radius: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Outfit', sans-serif;
            box-shadow: 0 8px 25px rgba(6,182,212,0.3);
            letter-spacing: -0.3px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 35px rgba(6,182,212,0.4);
            background: linear-gradient(135deg, var(--cyan-dark), var(--cyan-darker));
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: transparent;
            color: var(--slate-700);
            font-weight: 600;
            font-size: 15px;
            border-radius: 14px;
            text-decoration: none;
            border: 1.5px solid var(--slate-200);
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Outfit', sans-serif;
        }

        .btn-ghost:hover {
            border-color: var(--cyan);
            color: var(--cyan);
            background: rgba(6,182,212,0.04);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .badge-cyan {
            background: rgba(6,182,212,0.1);
            border: 1px solid rgba(6,182,212,0.2);
            color: var(--cyan-dark);
        }

        .badge-orange {
            background: rgba(249,115,22,0.1);
            border: 1px solid rgba(249,115,22,0.2);
            color: var(--orange-dark);
        }

        .section-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--cyan-dark);
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 900;
            color: var(--slate-900);
            line-height: 1.1;
            letter-spacing: -1.5px;
        }

        .section-subtitle {
            font-size: 17px;
            color: var(--slate-500);
            line-height: 1.7;
            font-weight: 400;
            max-width: 540px;
        }

        /* ═══════════════════════════════════════
           AMBIENT BLOBS
        ═══════════════════════════════════════ */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            animation: blobFloat 20s ease-in-out infinite alternate;
        }
        .blob-1 {
            width: 60vw; height: 60vw;
            top: -25%;  left: -20%;
            background: radial-gradient(circle, rgba(6,182,212,0.12) 0%, transparent 70%);
            animation-duration: 22s;
        }
        .blob-2 {
            width: 50vw; height: 50vw;
            bottom: -20%; right: -15%;
            background: radial-gradient(circle, rgba(249,115,22,0.1) 0%, transparent 70%);
            animation-duration: 28s;
            animation-delay: -10s;
        }
        .blob-3 {
            width: 40vw; height: 40vw;
            top: 40%; left: 30%;
            background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
            animation-duration: 18s;
            animation-delay: -5s;
        }

        @keyframes blobFloat {
            0%   { transform: translate(0,0) scale(1); }
            50%  { transform: translate(3%, 5%) scale(1.06); }
            100% { transform: translate(-2%, -3%) scale(0.97); }
        }

        /* ═══════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════ */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 900;
            transition: var(--transition);
            padding: 20px 0;
        }

        #navbar.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--slate-200);
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            padding: 14px 0;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 22px;
            font-weight: 900;
            color: var(--slate-900);
            letter-spacing: -0.5px;
        }

        .nav-logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--cyan), var(--cyan-darker));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            box-shadow: 0 6px 20px rgba(6,182,212,0.35);
            transition: var(--transition);
        }

        .nav-logo:hover .nav-logo-icon {
            transform: rotate(10deg) scale(1.05);
            box-shadow: 0 10px 28px rgba(6,182,212,0.45);
        }

        .nav-logo .logo-brand-fix { color: var(--cyan); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-links a {
            color: var(--slate-600);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 10px;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a:hover {
            color: var(--slate-900);
            background: rgba(0,0,0,0.04);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-login {
            color: var(--slate-700);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .nav-login:hover {
            color: var(--cyan);
            background: rgba(6,182,212,0.06);
        }

        .nav-register {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: linear-gradient(135deg, var(--cyan), var(--cyan-dark));
            color: white;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 5px 16px rgba(6,182,212,0.3);
        }

        .nav-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(6,182,212,0.4);
        }

        /* Mobile hamburger */
        .hamburger {
            display: none;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1.5px solid var(--slate-200);
            background: white;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
            transition: var(--transition);
        }

        .hamburger:hover {
            border-color: var(--cyan);
            background: rgba(6,182,212,0.05);
        }

        .hamburger span {
            display: block;
            width: 18px;
            height: 2px;
            background: var(--slate-700);
            border-radius: 99px;
            transition: var(--transition);
        }

        .hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(5px,5px); }
        .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(5px,-5px); }

        /* Mobile nav drawer */
        .mobile-nav {
            position: fixed;
            top: 0; right: 0;
            width: min(340px, 90vw);
            height: 100vh;
            background: white;
            box-shadow: -20px 0 60px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
            display: flex;
            flex-direction: column;
            padding: 28px;
            gap: 8px;
            overflow-y: auto;
        }

        .mobile-nav.open { transform: translateX(0); }

        .mobile-nav-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .mobile-nav-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--slate-200);
        }

        .mobile-nav-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--slate-200);
            background: var(--slate-50);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--slate-600);
            font-size: 16px;
            transition: var(--transition);
        }

        .mobile-nav-close:hover {
            background: #fef2f2;
            color: #ef4444;
            border-color: #fecaca;
        }

        .mobile-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--slate-700);
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
        }

        .mobile-nav a i {
            width: 20px;
            color: var(--cyan);
            font-size: 16px;
        }

        .mobile-nav a:hover {
            background: rgba(6,182,212,0.06);
            color: var(--cyan-dark);
        }

        .mobile-nav-divider {
            height: 1px;
            background: var(--slate-200);
            margin: 10px 0;
        }

        .mobile-nav-cta {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--slate-200);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* ═══════════════════════════════════════
           HERO SECTION
        ═══════════════════════════════════════ */
        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 140px 0 80px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 60px;
            align-items: center;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            background: rgba(6,182,212,0.08);
            border: 1px solid rgba(6,182,212,0.2);
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
            color: var(--cyan-dark);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .hero-eyebrow-dot {
            width: 7px;
            height: 7px;
            background: var(--orange);
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%,100% { transform: scale(1); opacity: 1; }
            50%      { transform: scale(1.4); opacity: 0.7; }
        }

        .hero-title {
            font-size: clamp(38px, 6vw, 72px);
            font-weight: 900;
            line-height: 1.0;
            letter-spacing: -3px;
            color: var(--slate-900);
            margin-bottom: 22px;
        }

        .hero-title .gradient-text {
            background: linear-gradient(135deg, var(--cyan) 0%, #38bdf8 50%, var(--orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 17px;
            color: var(--slate-500);
            line-height: 1.75;
            max-width: 500px;
            margin-bottom: 36px;
            font-weight: 400;
        }

        .hero-ctas {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 44px;
        }

        .hero-trust-row {
            display: flex;
            align-items: center;
            gap: 24px;
            flex-wrap: wrap;
        }

        .hero-trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--slate-500);
        }

        .hero-trust-item i {
            color: var(--cyan);
            font-size: 14px;
        }

        .trust-divider {
            width: 1px;
            height: 16px;
            background: var(--slate-300);
        }

        /* ═══════════════════════════════════════
           ORBITAL ANIMATION SCENE
        ═══════════════════════════════════════ */
        .orbital-scene {
            position: relative;
            width: 460px;
            height: 460px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin: 0 auto;
        }

        /* Faint glow behind the whole scene */
        .orbital-scene::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(6,182,212,0.13) 0%, transparent 68%);
            pointer-events: none;
        }

        /* ── Concentric ring tracks ── */
        .orbit-ring {
            position: absolute;
            border-radius: 50%;
            border: 1.5px solid rgba(6,182,212,0.18);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
        }

        .orbit-ring-1 { width: 160px; height: 160px; }
        .orbit-ring-2 { width: 280px; height: 280px; }
        .orbit-ring-3 { width: 400px; height: 400px; }

        /* Subtle ring glow via box-shadow */
        .orbit-ring-1 { box-shadow: 0 0 18px rgba(6,182,212,0.12); }
        .orbit-ring-2 { box-shadow: 0 0 22px rgba(6,182,212,0.10); }
        .orbit-ring-3 { box-shadow: 0 0 28px rgba(6,182,212,0.08); }

        /* ── Rotating arms (one per icon per ring) ── */
        .orbit-arm {
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            transform-origin: 0 0;
        }

        /* ── Icon nodes ── */
        .orbit-node {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: white;
            box-shadow: 0 6px 24px rgba(6,182,212,0.18), 0 2px 8px rgba(0,0,0,0.08);
            border: 2px solid rgba(6,182,212,0.15);
            font-size: 20px;
            transition: scale 0.3s, box-shadow 0.3s, border-color 0.3s;
            cursor: default;
            scale: 1;
        }

        .orbit-node:hover {
            scale: 1.18;
            box-shadow: 0 10px 32px rgba(6,182,212,0.35);
            border-color: var(--cyan);
            z-index: 10;
        }

        /* node sizes */
        .orbit-node-lg { width: 62px; height: 62px; font-size: 26px; }
        .orbit-node-md { width: 52px; height: 52px; font-size: 22px; }
        .orbit-node-sm { width: 44px; height: 44px; font-size: 18px; }

        /* special coloured nodes */
        .orbit-node-cyan {
            background: linear-gradient(135deg, #e0f9ff, #cffafe);
            border-color: rgba(6,182,212,0.3);
        }
        .orbit-node-orange {
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border-color: rgba(249,115,22,0.2);
        }
        .orbit-node-indigo {
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            border-color: rgba(99,102,241,0.2);
        }

        /* ── Ring animations (explicit from/to to prevent glitching) ── */
        @keyframes arm-cw-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes arm-ccw-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }
        @keyframes arm-cw-mid {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes arm-ccw-mid {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }
        @keyframes arm-cw-fast {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes arm-ccw-fast {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        /* ── Counter-spin animations (including translate to keep center) ── */
        @keyframes counter-cw-slow {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(-360deg); }
        }
        @keyframes counter-ccw-slow {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @keyframes counter-cw-mid {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(-360deg); }
        }
        @keyframes counter-ccw-mid {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }
        @keyframes counter-cw-fast {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(-360deg); }
        }
        @keyframes counter-ccw-fast {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Ring 1 arms (radius 80px) — 2 nodes */
        .arm-r1-a {
            animation: arm-cw-slow 18s linear infinite;
        }
        .arm-r1-b {
            animation: arm-cw-slow 18s linear infinite;
            animation-delay: -9s;
        }
        /* Ring 2 arms (radius 140px) — 3 nodes */
        .arm-r2-a { animation: arm-ccw-mid 24s linear infinite; }
        .arm-r2-b { animation: arm-ccw-mid 24s linear infinite; animation-delay: -8s; }
        .arm-r2-c { animation: arm-ccw-mid 24s linear infinite; animation-delay: -16s; }
        /* Ring 3 arms (radius 200px) — 4 nodes */
        .arm-r3-a { animation: arm-cw-fast 34s linear infinite; }
        .arm-r3-b { animation: arm-cw-fast 34s linear infinite; animation-delay: -8.5s; }
        .arm-r3-c { animation: arm-cw-fast 34s linear infinite; animation-delay: -17s; }
        .arm-r3-d { animation: arm-cw-fast 34s linear infinite; animation-delay: -25.5s; }

        /* Counter-spin the node inside each arm so it stays upright */
        .arm-r1-a .orbit-node,
        .arm-r1-b .orbit-node {
            animation: counter-cw-slow 18s linear infinite;
        }
        .arm-r1-b .orbit-node { animation-delay: -9s; }

        .arm-r2-a .orbit-node,
        .arm-r2-b .orbit-node,
        .arm-r2-c .orbit-node {
            animation: counter-ccw-mid 24s linear infinite;
        }
        .arm-r2-b .orbit-node { animation-delay: -8s; }
        .arm-r2-c .orbit-node { animation-delay: -16s; }

        .arm-r3-a .orbit-node,
        .arm-r3-b .orbit-node,
        .arm-r3-c .orbit-node,
        .arm-r3-d .orbit-node {
            animation: counter-cw-fast 34s linear infinite;
        }
        .arm-r3-b .orbit-node { animation-delay: -8.5s; }
        .arm-r3-c .orbit-node { animation-delay: -17s; }
        .arm-r3-d .orbit-node { animation-delay: -25.5s; }

        /* ── Centre hub ── */
        .orbital-hub {
            position: relative;
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 0 0 12px rgba(6,182,212,0.07), 0 0 0 24px rgba(6,182,212,0.04), 0 16px 40px rgba(6,182,212,0.14);
            border: 2px solid rgba(6,182,212,0.2);
        }

        .orbital-hub-value {
            font-size: 22px;
            font-weight: 900;
            color: var(--slate-900);
            letter-spacing: -1px;
            line-height: 1;
        }

        .orbital-hub-value span { color: var(--cyan); }

        .orbital-hub-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
            text-align: center;
        }

        /* tooltip on hover of node */
        .orbit-tooltip {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%);
            background: var(--slate-900);
            color: white;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            padding: 5px 10px;
            border-radius: 8px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .orbit-node:hover .orbit-tooltip { opacity: 1; }

        .orbit-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: var(--slate-900);
        }

        /* ═══════════════════════════════════════
           STATS BAR
        ═══════════════════════════════════════ */
        .stats-bar {
            padding: 48px 0;
            background: white;
            border-top: 1px solid var(--slate-100);
            border-bottom: 1px solid var(--slate-100);
            position: relative;
            z-index: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
        }

        .stat-item {
            text-align: center;
            padding: 0 32px;
            border-right: 1px solid var(--slate-200);
        }

        .stat-item:last-child { border-right: none; }

        .stat-value {
            font-size: 40px;
            font-weight: 900;
            color: var(--slate-900);
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-value span { color: var(--cyan); }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--slate-400);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ═══════════════════════════════════════
           TRUST SIGNALS MARQUEE
        ═══════════════════════════════════════ */
        .marquee-section {
            padding: 28px 0;
            background: var(--slate-50);
            border-bottom: 1px solid var(--slate-200);
            overflow: hidden;
            position: relative;
        }

        .marquee-wrap {
            position: relative;
            overflow: hidden;
        }

        .marquee-fade-l {
            position: absolute; top: 0; left: 0; bottom: 0; width: 120px;
            background: linear-gradient(to right, var(--slate-50), transparent);
            z-index: 2; pointer-events: none;
        }

        .marquee-fade-r {
            position: absolute; top: 0; right: 0; bottom: 0; width: 120px;
            background: linear-gradient(to left, var(--slate-50), transparent);
            z-index: 2; pointer-events: none;
        }

        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeScroll 28s linear infinite;
        }

        .marquee-track:hover { animation-play-state: paused; }

        @keyframes marqueeScroll {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        .marquee-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            height: 70px;
            padding: 0 28px;
            opacity: 0.45;
            transition: opacity 0.3s;
            font-size: 13px;
            font-weight: 700;
            color: var(--slate-600);
            gap: 8px;
            flex-shrink: 0;
        }

        .marquee-logo:hover { opacity: 0.85; }
        .marquee-logo img { max-height: 38px; object-fit: contain; filter: grayscale(100%) brightness(40%); }

        /* ═══════════════════════════════════════
           SERVICES SECTION
        ═══════════════════════════════════════ */
        #services {
            padding: 100px 0;
            background: var(--slate-50);
            position: relative;
            z-index: 1;
        }

        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .service-card {
            background: white;
            border-radius: 24px;
            padding: 36px 32px;
            border: 1px solid var(--slate-200);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }

        .service-card::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            opacity: 0;
            transition: opacity 0.4s;
            pointer-events: none;
        }

        .service-card:hover {
            transform: translateY(-6px);
            border-color: rgba(6,182,212,0.25);
            box-shadow: 0 24px 60px rgba(6,182,212,0.1);
        }

        .service-icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .service-icon-cyan {
            background: rgba(6,182,212,0.1);
            color: var(--cyan-dark);
        }

        .service-card:hover .service-icon-cyan {
            background: linear-gradient(135deg, var(--cyan), var(--cyan-dark));
            color: white;
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 28px rgba(6,182,212,0.3);
        }

        .service-icon-orange {
            background: rgba(249,115,22,0.1);
            color: var(--orange-dark);
        }

        .service-card:hover .service-icon-orange {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 28px rgba(249,115,22,0.3);
        }

        .service-icon-indigo {
            background: rgba(99,102,241,0.1);
            color: #4f46e5;
        }

        .service-card:hover .service-icon-indigo {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 28px rgba(99,102,241,0.3);
        }

        .service-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.5px;
        }

        .service-desc {
            font-size: 14px;
            color: var(--slate-500);
            line-height: 1.7;
            flex: 1;
        }

        .service-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: var(--cyan-dark);
            text-decoration: none;
            transition: var(--transition);
        }

        .service-link i {
            transition: transform 0.3s;
        }

        .service-card:hover .service-link i {
            transform: translateX(5px);
        }

        .service-popular {
            position: absolute;
            top: 0; right: 0;
            padding: 6px 16px;
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 0 22px 0 16px;
        }

        /* ═══════════════════════════════════════
           HOW IT WORKS
        ═══════════════════════════════════════ */
        #how-it-works {
            padding: 100px 0;
            background: white;
            position: relative;
            z-index: 1;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            position: relative;
            margin-top: 64px;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 48px;
            left: calc(100%/6);
            width: calc(100% - 100%/3);
            height: 2px;
            background: linear-gradient(90deg, var(--cyan), var(--orange), var(--cyan));
            opacity: 0.2;
        }

        .step-card {
            text-align: center;
            padding: 40px 32px;
            border-radius: 24px;
            border: 1px solid var(--slate-100);
            background: var(--slate-50);
            transition: var(--transition);
            position: relative;
        }

        .step-card:hover {
            background: white;
            border-color: rgba(6,182,212,0.2);
            box-shadow: 0 16px 40px rgba(6,182,212,0.08);
            transform: translateY(-4px);
        }

        .step-number {
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%);
            width: 32px;
            height: 32px;
            background: white;
            border: 2px solid var(--slate-200);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 900;
            color: var(--slate-400);
            transition: var(--transition);
        }

        .step-card:hover .step-number {
            border-color: var(--cyan);
            color: var(--cyan);
            background: rgba(6,182,212,0.06);
        }

        .step-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            border: 2px solid var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: var(--slate-400);
            margin: 0 auto 24px;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .step-card:hover .step-icon-circle {
            border-color: var(--cyan);
            color: var(--cyan);
            box-shadow: 0 8px 24px rgba(6,182,212,0.15);
        }

        .step-title {
            font-size: 19px;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 10px;
            letter-spacing: -0.3px;
        }

        .step-desc {
            font-size: 14px;
            color: var(--slate-500);
            line-height: 1.7;
        }

        /* ═══════════════════════════════════════
           TRUST / WHY US SECTION
        ═══════════════════════════════════════ */
        #why-us {
            padding: 100px 0;
            background: linear-gradient(180deg, var(--slate-50) 0%, white 100%);
            position: relative;
            z-index: 1;
        }

        .why-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
            margin-top: 64px;
        }

        .why-features {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .why-feature {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            padding: 22px;
            border-radius: 18px;
            border: 1px solid var(--slate-200);
            background: white;
            transition: var(--transition);
        }

        .why-feature:hover {
            border-color: rgba(6,182,212,0.25);
            box-shadow: 0 8px 24px rgba(6,182,212,0.07);
        }

        .why-feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .why-feature:hover .why-feature-icon {
            transform: scale(1.08) rotate(5deg);
        }

        .why-feature-body h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 4px;
        }

        .why-feature-body p {
            font-size: 13px;
            color: var(--slate-500);
            line-height: 1.65;
        }

        /* Floating card stack */
        .why-visual {
            position: relative;
            height: 480px;
        }

        .floating-card {
            position: absolute;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border: 1px solid var(--slate-200);
            padding: 22px 24px;
        }

        .floating-card-1 {
            top: 0; right: 0;
            width: 280px;
            animation: float1 6s ease-in-out infinite;
        }

        .floating-card-2 {
            bottom: 60px; left: 0;
            width: 260px;
            animation: float2 8s ease-in-out infinite;
        }

        .floating-card-3 {
            top: 50%; right: 20px;
            transform: translateY(-50%);
            width: 220px;
            animation: float3 7s ease-in-out infinite;
        }

        @keyframes float1 {
            0%,100% { transform: translateY(0px); }
            50%      { transform: translateY(-14px); }
        }

        @keyframes float2 {
            0%,100% { transform: translateY(0px); }
            50%      { transform: translateY(-10px); }
        }

        @keyframes float3 {
            0%,100% { transform: translateY(-50%) translateX(0); }
            50%      { transform: translateY(calc(-50% - 8px)) translateX(-4px); }
        }

        .fc-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .fc-status-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .fc-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 4px;
        }

        .fc-sub {
            font-size: 12px;
            color: var(--slate-500);
        }

        .fc-stars {
            display: flex;
            gap: 2px;
            color: #f59e0b;
            font-size: 12px;
            margin-top: 4px;
        }

        .fc-plumber {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .fc-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--slate-100);
        }

        .fc-ping {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: var(--slate-800);
        }

        .fc-ping-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--cyan);
            position: relative;
        }

        .fc-ping-dot::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: var(--cyan);
            opacity: 0.25;
            animation: ping 1.5s ease-out infinite;
        }

        @keyframes ping {
            0%   { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        /* ═══════════════════════════════════════
           TESTIMONIALS
        ═══════════════════════════════════════ */
        #testimonials {
            padding: 100px 0;
            background: var(--slate-900);
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .testimonials-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% -20%, rgba(6,182,212,0.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 64px;
        }

        .testimonial-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 32px;
            transition: var(--transition);
        }

        .testimonial-card:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(6,182,212,0.2);
            transform: translateY(-4px);
        }

        .testimonial-stars {
            display: flex;
            gap: 3px;
            color: #f59e0b;
            font-size: 14px;
            margin-bottom: 18px;
        }

        .testimonial-text {
            font-size: 14px;
            color: rgba(255,255,255,0.7);
            line-height: 1.75;
            font-style: italic;
            margin-bottom: 24px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .testimonial-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid rgba(6,182,212,0.3);
        }

        .testimonial-name {
            font-size: 14px;
            font-weight: 700;
            color: white;
        }

        .testimonial-meta {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════
           CTA SECTION
        ═══════════════════════════════════════ */
        #cta {
            padding: 100px 0;
            background: white;
            position: relative;
            z-index: 1;
        }

        .cta-box {
            background: linear-gradient(135deg, var(--slate-900) 0%, #1e3a5f 50%, var(--slate-900) 100%);
            border-radius: 32px;
            padding: 72px 64px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-box::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at 50% 120%, rgba(6,182,212,0.15) 0%, transparent 55%);
            pointer-events: none;
        }

        .cta-dot-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .cta-box h2 {
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 900;
            color: white;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
            position: relative;
        }

        .cta-box p {
            font-size: 17px;
            color: rgba(255,255,255,0.55);
            margin-bottom: 40px;
            position: relative;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            position: relative;
        }

        .btn-cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            background: linear-gradient(135deg, var(--cyan), var(--cyan-dark));
            color: white;
            font-size: 16px;
            font-weight: 700;
            border-radius: 14px;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(6,182,212,0.4);
        }

        .btn-cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(6,182,212,0.5);
        }

        .btn-cta-ghost {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            background: rgba(255,255,255,0.07);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 14px;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.12);
            transition: var(--transition);
        }

        .btn-cta-ghost:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.2);
        }

        /* ═══════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════ */
        footer {
            background: var(--slate-900);
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 72px 0 40px;
            position: relative;
            z-index: 1;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 56px;
        }

        .footer-brand p {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            line-height: 1.75;
            margin: 16px 0 24px;
            max-width: 280px;
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            margin-bottom: 10px;
        }

        .footer-contact-item i {
            color: var(--cyan);
            width: 16px;
            font-size: 13px;
        }

        .footer-col h5 {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 20px;
        }

        .footer-col a {
            display: block;
            font-size: 14px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            margin-bottom: 10px;
            transition: color 0.25s;
        }

        .footer-col a:hover { color: var(--cyan); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.07);
            padding-top: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .footer-bottom p {
            font-size: 13px;
            color: rgba(255,255,255,0.3);
        }

        .footer-socials {
            display: flex;
            gap: 10px;
        }

        .footer-social-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-social-btn:hover {
            background: rgba(6,182,212,0.15);
            border-color: rgba(6,182,212,0.3);
            color: var(--cyan);
            transform: translateY(-2px);
        }

        /* ═══════════════════════════════════════
           SCROLL REVEAL
        ═══════════════════════════════════════ */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
        }

        /* ═══════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════ */
        @media (max-width: 1024px) {
            .hero-grid      { grid-template-columns: 1fr; gap: 40px; }
            .orbital-scene  { width: 340px; height: 340px; }
            .orbit-ring-1   { width: 120px; height: 120px; }
            .orbit-ring-2   { width: 210px; height: 210px; }
            .orbit-ring-3   { width: 300px; height: 300px; }
            .hero-title     { font-size: clamp(36px, 8vw, 60px); }
            .footer-grid   { grid-template-columns: 1fr 1fr; gap: 40px; }
            .stats-grid    { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .stat-item     { border-right: none; border-bottom: 1px solid var(--slate-200); padding: 20px 0; }
            .stat-item:last-child, .stat-item:nth-child(2) { border-bottom: none; }
        }

        @media (max-width: 768px) {
            .nav-links  { display: none; }
            .nav-login  { display: none; }
            .nav-register { display: none; }
            .hamburger  { display: flex; }

            #hero       { padding: 120px 0 64px; }
            .hero-ctas  { flex-direction: column; align-items: flex-start; }
            .hero-ctas .btn-primary { width: 100%; justify-content: center; }
            .hero-ctas .btn-ghost   { width: 100%; justify-content: center; }

            .services-grid       { grid-template-columns: 1fr; }
            .steps-grid          { grid-template-columns: 1fr; }
            .steps-grid::before  { display: none; }
            .why-grid            { grid-template-columns: 1fr; }
            .why-visual          { display: none; }
            .testimonials-grid   { grid-template-columns: 1fr; }
            .footer-grid         { grid-template-columns: 1fr; gap: 32px; }
            .cta-box             { padding: 48px 28px; }
            .cta-buttons         { flex-direction: column; }
            .cta-buttons .btn-cta-primary,
            .cta-buttons .btn-cta-ghost { width: 100%; justify-content: center; }
            .footer-bottom       { flex-direction: column; text-align: center; }
        }

        @media (max-width: 480px) {
            .hero-trust-row  { gap: 12px; }
            .trust-divider   { display: none; }
            .stat-value      { font-size: 32px; }
        }
    </style>
</head>
<body>

<!-- Ambient Background Blobs -->
<div class="blob blob-1" aria-hidden="true"></div>
<div class="blob blob-2" aria-hidden="true"></div>
<div class="blob blob-3" aria-hidden="true"></div>

<!-- Mobile Nav Overlay -->
<div class="mobile-nav-overlay" id="mobileOverlay" role="dialog" aria-modal="true" aria-label="Navigation menu"></div>

<!-- Mobile Nav Drawer -->
<nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
    <div class="mobile-nav-header">
        <a href="{{ url('/') }}" class="nav-logo" style="font-size:18px;">
            <div class="nav-logo-icon" style="width:34px;height:34px;font-size:15px;">
                <i class="fa-solid fa-wrench"></i>
            </div>
            <span>Plumb<span class="logo-brand-fix">fix</span></span>
        </a>
        <button class="mobile-nav-close" id="mobileNavClose" aria-label="Close navigation">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <a href="#services" onclick="closeMobileNav()">
        <i class="fa-solid fa-wrench"></i> Services
    </a>
    <a href="#how-it-works" onclick="closeMobileNav()">
        <i class="fa-solid fa-route"></i> How It Works
    </a>
    <a href="#why-us" onclick="closeMobileNav()">
        <i class="fa-solid fa-shield-halved"></i> Why Plumbfix
    </a>
    <a href="#testimonials" onclick="closeMobileNav()">
        <i class="fa-regular fa-star"></i> Reviews
    </a>

    <div class="mobile-nav-divider"></div>

    <div class="mobile-nav-cta">
        @if(Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary" style="justify-content:center;" onclick="closeMobileNav()">
                    <i class="fa-solid fa-gauge"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost" style="justify-content:center;" onclick="closeMobileNav()">
                    Log In
                </a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary" style="justify-content:center;" onclick="closeMobileNav()">
                        <i class="fa-solid fa-calendar-check"></i> Book Now
                    </a>
                @endif
            @endauth
        @endif
    </div>
</nav>

<!-- ═══════ NAVBAR ═══════ -->
<header id="navbar" role="banner">
    <div class="container">
        <nav class="nav-inner" aria-label="Primary navigation">
            <a href="{{ url('/') }}" class="nav-logo" aria-label="Plumbfix Home">
                <div class="nav-logo-icon">
                    <i class="fa-solid fa-wrench" aria-hidden="true"></i>
                </div>
                <span>Plumb<span class="logo-brand-fix">fix</span></span>
            </a>

            <div class="nav-links" role="list">
                <a href="#services" role="listitem">Services</a>
                <a href="#how-it-works" role="listitem">How It Works</a>
                <a href="#why-us" role="listitem">Why Us</a>
                <a href="#testimonials" role="listitem">Reviews</a>
            </div>

            <div class="nav-actions">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-login">Log In</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-register">
                                <i class="fa-solid fa-calendar-check" aria-hidden="true"></i> Book Now
                            </a>
                        @endif
                    @endauth
                @endif

                <button class="hamburger" id="hamburgerBtn" aria-label="Open navigation menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </nav>
    </div>
</header>

<!-- ═══════ HERO ═══════ -->
<main>
<section id="hero" aria-label="Hero">
    <div class="container">
        <div class="hero-grid">
            <!-- Left: Content -->
            <div class="hero-content reveal">
                <div class="hero-eyebrow">
                    <div class="hero-eyebrow-dot" aria-hidden="true"></div>
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    Now Serving Bangi & Selangor
                </div>

                <h1 class="hero-title">
                    Expert Plumbing<br>
                    <span class="gradient-text">At Your Fingertips</span>
                </h1>

                <p class="hero-desc">
                    Connect with certified master plumbers in under 60 seconds. Transparent pricing, instant status updates, and same-day service — no phone calls required.
                </p>

                <div class="hero-ctas">
                    @if(Route::has('login'))
                        @auth
                            <a href="{{ url('/bookings/create') }}" class="btn-primary" id="hero-book-cta">
                                <i class="fa-solid fa-bolt" aria-hidden="true"></i> Book a Service
                            </a>
                            <a href="{{ url('/dashboard') }}" class="btn-ghost" id="hero-dash-cta">
                                <i class="fa-solid fa-gauge-high" aria-hidden="true"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary" id="hero-register-cta">
                                <i class="fa-solid fa-bolt" aria-hidden="true"></i> Book a Plumber
                            </a>
                            <a href="#how-it-works" class="btn-ghost" id="hero-learn-cta">
                                <i class="fa-regular fa-circle-play" aria-hidden="true"></i> See How It Works
                            </a>
                        @endauth
                    @endif
                </div>

                <div class="hero-trust-row" role="list">
                    <div class="hero-trust-item" role="listitem">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        Certified Plumbers
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="hero-trust-item" role="listitem">
                        <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                        60-Second Response
                    </div>
                    <div class="trust-divider" aria-hidden="true"></div>
                    <div class="hero-trust-item" role="listitem">
                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                        4.9★ Average Rating
                    </div>
                </div>
            </div>

            <!-- Right: Orbital Plumbing Animation -->
            <div class="reveal" style="animation-delay:0.2s;" aria-hidden="true">
                <div class="orbital-scene" id="orbital-scene">

                    <!-- Ring tracks -->
                    <div class="orbit-ring orbit-ring-1"></div>
                    <div class="orbit-ring orbit-ring-2"></div>
                    <div class="orbit-ring orbit-ring-3"></div>

                    <!-- ── RING 1 (radius 80px) — 2 icons: wrench, droplet ── -->
                    <div class="orbit-arm arm-r1-a">
                        <div class="orbit-node orbit-node-lg orbit-node-cyan"
                             style="position:absolute; left:80px; top:0; transform:translate(-50%,-50%);"
                             title="Leak Repair">
                            💧
                            <span class="orbit-tooltip">Leak Repair</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r1-b">
                        <div class="orbit-node orbit-node-lg orbit-node-cyan"
                             style="position:absolute; left:80px; top:0; transform:translate(-50%,-50%);"
                             title="Wrench">
                            🔧
                            <span class="orbit-tooltip">Pipe Repair</span>
                        </div>
                    </div>

                    <!-- ── RING 2 (radius 140px) — 3 icons: pipe, plunger, shower ── -->
                    <div class="orbit-arm arm-r2-a">
                        <div class="orbit-node orbit-node-md orbit-node-orange"
                             style="position:absolute; left:140px; top:0; transform:translate(-50%,-50%);"
                             title="Drain">
                            🪠
                            <span class="orbit-tooltip">Drain Unblocking</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r2-b">
                        <div class="orbit-node orbit-node-md orbit-node-orange"
                             style="position:absolute; left:140px; top:0; transform:translate(-50%,-50%);"
                             title="Pipe">
                            🔩
                            <span class="orbit-tooltip">Pipe Installation</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r2-c">
                        <div class="orbit-node orbit-node-md orbit-node-orange"
                             style="position:absolute; left:140px; top:0; transform:translate(-50%,-50%);"
                             title="Shower">
                            🚿
                            <span class="orbit-tooltip">Water Heater</span>
                        </div>
                    </div>

                    <!-- ── RING 3 (radius 200px) — 4 icons: toilet, tools, check, shield ── -->
                    <div class="orbit-arm arm-r3-a">
                        <div class="orbit-node orbit-node-sm orbit-node-indigo"
                             style="position:absolute; left:200px; top:0; transform:translate(-50%,-50%);"
                             title="Toilet">
                            🚽
                            <span class="orbit-tooltip">Toilet & Cistern</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r3-b">
                        <div class="orbit-node orbit-node-sm orbit-node-indigo"
                             style="position:absolute; left:200px; top:0; transform:translate(-50%,-50%);"
                             title="Tools">
                            🛠️
                            <span class="orbit-tooltip">General Maintenance</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r3-c">
                        <div class="orbit-node orbit-node-sm orbit-node-indigo"
                             style="position:absolute; left:200px; top:0; transform:translate(-50%,-50%);"
                             title="Certificate">
                            🏅
                            <span class="orbit-tooltip">Certified Quality</span>
                        </div>
                    </div>

                    <div class="orbit-arm arm-r3-d">
                        <div class="orbit-node orbit-node-sm orbit-node-indigo"
                             style="position:absolute; left:200px; top:0; transform:translate(-50%,-50%);"
                             title="24/7">
                            ⚡
                            <span class="orbit-tooltip">24/7 Response</span>
                        </div>
                    </div>

                    <!-- ── Centre hub ── -->
                    <div class="orbital-hub">
                        <div class="orbital-hub-value"><span class="counter" data-target="1200">0</span><span style="color:var(--cyan);">+</span></div>
                        <div class="orbital-hub-label">Jobs Done</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ STATS BAR ═══════ -->
<section class="stats-bar" aria-label="Key statistics">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item reveal">
                <div class="stat-value"><span class="counter" data-target="1200">0</span><span>+</span></div>
                <div class="stat-label">Jobs Completed</div>
            </div>
            <div class="stat-item reveal" style="animation-delay:0.1s;">
                <div class="stat-value"><span class="counter" data-target="98">0</span><span>%</span></div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
            <div class="stat-item reveal" style="animation-delay:0.2s;">
                <div class="stat-value"><span class="counter" data-target="45">0</span><span>min</span></div>
                <div class="stat-label">Avg. Response Time</div>
            </div>
            <div class="stat-item reveal" style="animation-delay:0.3s;">
                <div class="stat-value"><span class="counter" data-target="24">0</span><span>/7</span></div>
                <div class="stat-label">Emergency Support</div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ MARQUEE ═══════ -->
<div class="marquee-section" aria-label="Trusted communities">
    <div class="container" style="margin-bottom:10px;">
        <p style="font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:2px; color:var(--slate-400); text-align:center;">
            Trusted by Residents & Properties Across Bangi
        </p>
    </div>
    <div class="marquee-wrap">
        <div class="marquee-fade-l" aria-hidden="true"></div>
        <div class="marquee-fade-r" aria-hidden="true"></div>
        <div class="marquee-track" aria-hidden="true">
            @php
                $communities = [
                    ['icon'=>'fa-building', 'name'=>'Saujana Impian'],
                    ['icon'=>'fa-home', 'name'=>'Bandar Baru Bangi'],
                    ['icon'=>'fa-city', 'name'=>'Seksyen 7 Bangi'],
                    ['icon'=>'fa-building-columns', 'name'=>'UKM Residences'],
                    ['icon'=>'fa-house-chimney', 'name'=>'Taman Putra Damai'],
                    ['icon'=>'fa-building', 'name'=>'Mahkota Cheras'],
                    ['icon'=>'fa-home', 'name'=>'Kajang Heights'],
                    ['icon'=>'fa-city', 'name'=>'Seri Kembangan'],
                ];
            @endphp
            @foreach(array_merge($communities, $communities) as $c)
                <div class="marquee-logo">
                    <i class="fa-solid {{ $c['icon'] }}" style="color:var(--slate-400);"></i>
                    {{ $c['name'] }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ═══════ SERVICES ═══════ -->
<section id="services" aria-labelledby="services-heading">
    <div class="container">
        <div class="section-header">
            <p class="section-label reveal">Professional Care</p>
            <h2 class="section-title reveal" id="services-heading" style="margin-bottom:16px;">
                Our Core <span style="color:var(--cyan);">Offerings</span>
            </h2>
            <p class="section-subtitle reveal" style="margin:0 auto;">
                Expert solutions for every plumbing challenge — delivered with precision, speed, and lifetime durability.
            </p>
        </div>

        <div class="services-grid">
            <!-- Service 1 -->
            <article class="service-card reveal" id="service-leak">
                <div class="service-icon-wrap service-icon-cyan">
                    <i class="fa-solid fa-droplet-slash" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">Leak Repair</h3>
                    <p class="service-desc">
                        Rapid acoustic detection and emergency response to stop leaks immediately, preserving structural integrity and minimizing water damage.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>

            <!-- Service 2 (Popular) -->
            <article class="service-card reveal" id="service-pipe" style="animation-delay:0.1s;">
                <div class="service-popular">Popular</div>
                <div class="service-icon-wrap service-icon-orange">
                    <i class="fa-solid fa-circle-nodes" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">Pipe Installation</h3>
                    <p class="service-desc">
                        Complete hot/cold line piping replacements and fixture upgrades using premium materials certified to withstand pressure changes for decades.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link" style="color:var(--orange-dark);">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>

            <!-- Service 3 -->
            <article class="service-card reveal" id="service-drain" style="animation-delay:0.2s;">
                <div class="service-icon-wrap service-icon-indigo">
                    <i class="fa-solid fa-arrow-down-wide-short" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">Drain Unblocking</h3>
                    <p class="service-desc">
                        High-pressure hydro-jetting and CCTV drain inspection to clear stubborn blockages and restore full drainage flow throughout your property.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link" style="color:#4f46e5;">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>

            <!-- Service 4 -->
            <article class="service-card reveal" id="service-heater" style="animation-delay:0.1s;">
                <div class="service-icon-wrap service-icon-cyan">
                    <i class="fa-solid fa-shower" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">Water Heater Service</h3>
                    <p class="service-desc">
                        Installation, repair, and annual flushing of instant and storage water heaters. Extend lifespan and cut energy costs significantly.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>

            <!-- Service 5 -->
            <article class="service-card reveal" id="service-toilet" style="animation-delay:0.2s;">
                <div class="service-icon-wrap service-icon-orange">
                    <i class="fa-solid fa-toilet" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">Toilet & Cistern</h3>
                    <p class="service-desc">
                        Fix running toilets, leaking cisterns, faulty flushing mechanisms, and complete toilet suite replacements with premium hardware.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link" style="color:var(--orange-dark);">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>

            <!-- Service 6 -->
            <article class="service-card reveal" id="service-maintenance" style="animation-delay:0.3s;">
                <div class="service-icon-wrap service-icon-indigo">
                    <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 class="service-name">General Maintenance</h3>
                    <p class="service-desc">
                        Preventative inspections, pressure testing, block removals, and comprehensive plumbing health checks to protect your property year-round.
                    </p>
                </div>
                <a href="{{ route('login') }}" class="service-link" style="color:#4f46e5;">
                    Book Service <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </article>
        </div>
    </div>
</section>

<!-- ═══════ HOW IT WORKS ═══════ -->
<section id="how-it-works" aria-labelledby="hiw-heading">
    <div class="container">
        <div class="section-header">
            <p class="section-label reveal">Simple Process</p>
            <h2 class="section-title reveal" id="hiw-heading" style="margin-bottom:16px;">
                How It <span style="color:var(--cyan);">Works</span>
            </h2>
            <p class="section-subtitle reveal" style="margin:0 auto;">
                From problem to resolution — a seamless, fully transparent journey in three simple steps.
            </p>
        </div>

        <div class="steps-grid">
            <article class="step-card reveal" id="step-1">
                <div class="step-number" aria-hidden="true">1</div>
                <div class="step-icon-circle">
                    <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                </div>
                <h3 class="step-title">Describe & Book</h3>
                <p class="step-desc">
                    Log in, select your service type, describe the issue, attach a photo if needed, and pick your preferred time slot. Done in 2 minutes.
                </p>
            </article>

            <article class="step-card reveal" id="step-2" style="animation-delay:0.15s;">
                <div class="step-number" aria-hidden="true">2</div>
                <div class="step-icon-circle">
                    <i class="fa-regular fa-bell" aria-hidden="true"></i>
                </div>
                <h3 class="step-title">Instant Dispatch Updates</h3>
                <p class="step-desc">
                    A certified plumber is assigned instantly. Receive booking updates, real-time status alerts, and coordinate directly via chat.
                </p>
            </article>

            <article class="step-card reveal" id="step-3" style="animation-delay:0.3s;">
                <div class="step-number" aria-hidden="true">3</div>
                <div class="step-icon-circle">
                    <i class="fa-solid fa-handshake" aria-hidden="true"></i>
                </div>
                <h3 class="step-title">Approve & Pay</h3>
                <p class="step-desc">
                    Review the completed work, approve the job record digitally, and settle the transparent invoice online. Rate your experience to help others.
                </p>
            </article>
        </div>
    </div>
</section>

<!-- ═══════ WHY US ═══════ -->
<section id="why-us" aria-labelledby="why-heading">
    <div class="container">
        <div class="section-header" style="text-align:left; margin-bottom:0;">
            <p class="section-label reveal">Why Plumbfix</p>
            <h2 class="section-title reveal" id="why-heading" style="margin-bottom:16px;">
                The Smarter Way<br>to Fix Plumbing
            </h2>
            <p class="section-subtitle reveal">
                We've eliminated every pain point of traditional plumbing services — no more waiting, no more guessing, no more hidden fees.
            </p>
        </div>

        <div class="why-grid">
            <div class="why-features">
                <div class="why-feature reveal" id="feature-certified">
                    <div class="why-feature-icon" style="background:rgba(6,182,212,0.1);color:var(--cyan-dark);">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                    </div>
                    <div class="why-feature-body">
                        <h4>Verified & Certified Plumbers</h4>
                        <p>Every plumber on our platform passes background checks, skills assessments, and holds valid plumbing certifications from CIDB Malaysia.</p>
                    </div>
                </div>

                <div class="why-feature reveal" id="feature-transparent" style="animation-delay:0.1s;">
                    <div class="why-feature-icon" style="background:rgba(249,115,22,0.1);color:var(--orange-dark);">
                        <i class="fa-solid fa-file-invoice-dollar" aria-hidden="true"></i>
                    </div>
                    <div class="why-feature-body">
                        <h4>Transparent Pricing Always</h4>
                        <p>Receive itemized digital quotes before work begins. No surprise charges — ever. Review and approve each line item at your own pace.</p>
                    </div>
                </div>

                <div class="why-feature reveal" id="feature-tracking" style="animation-delay:0.2s;">
                    <div class="why-feature-icon" style="background:rgba(99,102,241,0.1);color:#4f46e5;">
                        <i class="fa-solid fa-bell" aria-hidden="true"></i>
                    </div>
                    <div class="why-feature-body">
                        <h4>Instant Status Alerts</h4>
                        <p>Get instant notifications and dashboard updates on your booking status. Receive immediate alerts when your expert is on their way.</p>
                    </div>
                </div>

                <div class="why-feature reveal" id="feature-warranty" style="animation-delay:0.3s;">
                    <div class="why-feature-icon" style="background:rgba(16,185,129,0.1);color:#059669;">
                        <i class="fa-solid fa-certificate" aria-hidden="true"></i>
                    </div>
                    <div class="why-feature-body">
                        <h4>30-Day Work Guarantee</h4>
                        <p>Every completed job comes with a 30-day workmanship warranty. If anything goes wrong, we'll return and fix it — at no extra charge.</p>
                    </div>
                </div>
            </div>

            <!-- Floating Visual Cards -->
            <div class="why-visual" aria-hidden="true">
                <!-- Card 1: New booking -->
                <div class="floating-card floating-card-1" style="box-shadow:0 24px 60px rgba(6,182,212,0.12);">
                    <div class="fc-status" style="color:var(--orange-dark);">
                        <div class="fc-status-dot" style="background:var(--orange);"></div>
                        New Request
                    </div>
                    <div class="fc-title">Leaking Pipe in Kitchen</div>
                    <div class="fc-sub">Status: <strong style="color:var(--orange-dark);">Assigning Expert</strong></div>
                    <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--slate-100); font-size:12px; color:var(--slate-500); display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-clock" style="color:var(--cyan);"></i>
                        Submitted just now
                    </div>
                </div>

                <!-- Card 2: Plumber assigned -->
                <div class="floating-card floating-card-2" style="box-shadow:0 20px 50px rgba(0,0,0,0.08);">
                    <div class="fc-plumber">
                        <img src="https://i.pravatar.cc/100?img=11" alt="Plumber Ahmad Fauzi" class="fc-avatar">
                        <div>
                            <div class="fc-title" style="font-size:14px;">Ahmad Fauzi</div>
                            <div class="fc-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="fc-sub" style="margin-top:4px;">Certified Plumber · 5 yrs</div>
                        </div>
                    </div>
                    <div style="margin-top:14px; font-size:12px; color:var(--slate-500); font-style:italic; line-height:1.5;">
                        "On my way! I have the necessary parts loaded."
                    </div>
                </div>

                <!-- Card 3: ETA -->
                <div class="floating-card floating-card-3" style="box-shadow:0 16px 40px rgba(6,182,212,0.1);">
                    <div class="fc-ping">
                        <div class="fc-ping-dot"></div>
                        Expert Dispatched
                    </div>
                    <div style="margin-top:12px; display:flex; align-items:center; gap:8px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(6,182,212,0.1);color:var(--cyan-dark);display:flex;align-items:center;justify-content:center;font-size:15px;">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <div style="font-size:11px;color:var(--slate-400);font-weight:700;text-transform:uppercase;letter-spacing:1px;">Status</div>
                            <div style="font-size:18px;font-weight:900;color:var(--slate-900);letter-spacing:-0.5px;">On the way</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════ TESTIMONIALS ═══════ -->
<section id="testimonials" aria-labelledby="testimonials-heading">
    <div class="testimonials-bg" aria-hidden="true"></div>
    <div class="container" style="position:relative;">
        <div class="section-header">
            <p class="section-label reveal" style="color:rgba(6,182,212,0.8);">Customer Stories</p>
            <h2 class="section-title reveal" id="testimonials-heading" style="color:white; margin-bottom:16px;">
                What Our Customers <span style="color:var(--cyan);">Say</span>
            </h2>
            <p class="section-subtitle reveal" style="color:rgba(255,255,255,0.5); margin:0 auto;">
                Real feedback from real homeowners across Bangi and surrounding areas.
            </p>
        </div>

        <div class="testimonials-grid">
            <article class="testimonial-card reveal" id="review-1">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                </div>
                <p class="testimonial-text">
                    "The plumber arrived in under 45 minutes and fixed our burst pipe within the hour. The instant status updates gave us peace of mind — we knew exactly when he was on his way. Highly professional!"
                </p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/100?img=5" alt="Aishah Razak" class="testimonial-avatar">
                    <div>
                        <div class="testimonial-name">Aishah Razak</div>
                        <div class="testimonial-meta">Bandar Baru Bangi · Homeowner</div>
                    </div>
                </div>
            </article>

            <article class="testimonial-card reveal" id="review-2" style="animation-delay:0.15s;">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                </div>
                <p class="testimonial-text">
                    "I was skeptical at first, but Plumbfix blew me away. Transparent pricing, a detailed digital invoice, and the work was done so neatly. No mess left behind at all. Will use again!"
                </p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/100?img=8" alt="Hafiz Kamarudin" class="testimonial-avatar">
                    <div>
                        <div class="testimonial-name">Hafiz Kamarudin</div>
                        <div class="testimonial-meta">Kajang · Property Manager</div>
                    </div>
                </div>
            </article>

            <article class="testimonial-card reveal" id="review-3" style="animation-delay:0.3s;">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                    <i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i>
                </div>
                <p class="testimonial-text">
                    "Our kitchen sink had a severe blockage. Booked at 8am and the plumber arrived by 9:30am. He explained every step clearly, showed us the before and after photos. Outstanding service."
                </p>
                <div class="testimonial-author">
                    <img src="https://i.pravatar.cc/100?img=20" alt="Nur Faradilla" class="testimonial-avatar">
                    <div>
                        <div class="testimonial-name">Nur Faradilla</div>
                        <div class="testimonial-meta">Seri Kembangan · Tenant</div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

</main>

<!-- ═══════ FOOTER ═══════ -->
<footer role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="nav-logo" style="margin-bottom:16px; display:inline-flex;">
                    <div class="nav-logo-icon"><i class="fa-solid fa-wrench" aria-hidden="true"></i></div>
                    <span style="color:white;">Plumb<span class="logo-brand-fix">fix</span></span>
                </a>
                <p>Transforming plumbing maintenance through rapid tech dispatching, digital transparency, and certified master-level expertise. Serving Bangi since 2020.</p>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                    123 Enterprise Tower, Bangi, Selangor
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    +60 3-8925 1234
                </div>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                    support@plumbfix.com.my
                </div>
            </div>

            <div class="footer-col">
                <h5>Services</h5>
                <a href="#services">Leak Repair</a>
                <a href="#services">Pipe Installation</a>
                <a href="#services">Drain Unblocking</a>
                <a href="#services">Water Heater</a>
                <a href="#services">General Maintenance</a>
            </div>

            <div class="footer-col">
                <h5>Company</h5>
                <a href="#why-us">About Us</a>
                <a href="#testimonials">Reviews</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#">Careers</a>
                <a href="#">Blog</a>
            </div>

            <div class="footer-col">
                <h5>Account</h5>
                @if(Route::has('login'))
                    <a href="{{ route('login') }}">Log In</a>
                @endif
                @if(Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Support</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} Plumbfix by Ikhlas Jujur Bakti. All rights reserved.</p>
            <div class="footer-socials">
                <a href="#" class="footer-social-btn" aria-label="Facebook">
                    <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                </a>
                <a href="#" class="footer-social-btn" aria-label="Instagram">
                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                </a>
                <a href="#" class="footer-social-btn" aria-label="Twitter / X">
                    <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                </a>
                <a href="#" class="footer-social-btn" aria-label="WhatsApp">
                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
    // ─── NAVBAR SCROLL ───────────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });

    // ─── MOBILE NAV ──────────────────────────────────────────────────
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileNav = document.getElementById('mobileNav');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileNavClose = document.getElementById('mobileNavClose');

    function openMobileNav() {
        hamburgerBtn.classList.add('open');
        hamburgerBtn.setAttribute('aria-expanded', 'true');
        mobileNav.classList.add('open');
        mobileOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    window.closeMobileNav = function() {
        hamburgerBtn.classList.remove('open');
        hamburgerBtn.setAttribute('aria-expanded', 'false');
        mobileNav.classList.remove('open');
        mobileOverlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    hamburgerBtn.addEventListener('click', openMobileNav);
    mobileNavClose.addEventListener('click', closeMobileNav);
    mobileOverlay.addEventListener('click', closeMobileNav);

    // ─── GSAP SCROLL REVEAL ──────────────────────────────────────────
    gsap.registerPlugin(ScrollTrigger);

    // Hero entrance
    gsap.fromTo('.hero-content',
        { opacity: 0, y: 40 },
        { opacity: 1, y: 0, duration: 1.2, ease: 'power3.out', delay: 0.1 }
    );

    gsap.fromTo('.hero-card',
        { opacity: 0, y: 40, scale: 0.96 },
        { opacity: 1, y: 0, scale: 1, duration: 1.2, ease: 'power3.out', delay: 0.3 }
    );

    // Generic reveal animation
    gsap.utils.toArray('.reveal').forEach((el, i) => {
        gsap.fromTo(el,
            { opacity: 0, y: 30 },
            {
                opacity: 1, y: 0,
                duration: 0.8,
                ease: 'power2.out',
                delay: parseFloat(el.style.animationDelay) || 0,
                scrollTrigger: {
                    trigger: el,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                }
            }
        );
    });

    // ─── COUNTER ANIMATION ───────────────────────────────────────────
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const target = parseInt(entry.target.dataset.target);
            const duration = 1800;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                entry.target.textContent = Math.round(current);
                if (current >= target) clearInterval(timer);
            }, 16);

            counterObserver.unobserve(entry.target);
        });
    }, { threshold: 0.5 });

    counters.forEach(c => counterObserver.observe(c));

    // ─── QUICK BOOK FORM INTERCEPT ───────────────────────────────────
    // Pre-fill service info as URL params when navigating to register/login
    document.getElementById('quick-book-form')?.addEventListener('submit', function(e) {
        const service = document.getElementById('qb-service')?.value;
        const loc     = document.getElementById('qb-location')?.value;
        const time    = document.getElementById('qb-time')?.value;

        if (service || loc || time) {
            const params = new URLSearchParams();
            if (service) params.set('service', service);
            if (loc)     params.set('location', loc);
            if (time)    params.set('time', time);
            this.action = this.action + '?' + params.toString();
        }
    });
</script>
</body>
</html>