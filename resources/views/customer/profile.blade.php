<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — Plumbfix</title>
    <meta name="description" content="View and update your personal information.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Reset & Base Variables */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            /* Futuristic Light Theme Palette (Teal Accent) */
            --bg-color: #f8fafc;
            --surface-color: rgba(255, 255, 255, 0.7);
            --surface-color-solid: #ffffff;
            --text-main: #475569;
            --text-muted: #94a3b8;
            --text-dark: #0f172a;
            --brand-color: #0d9488;
            --brand-gradient: linear-gradient(135deg, #0d9488 0%, #115e59 100%);
            --brand-light: #ccfbf1;
            --border-color: rgba(226, 232, 240, 0.8);
            --hover-color: rgba(241, 245, 249, 0.8);
            
            --accent-green: #10b981;
            --accent-green-bg: rgba(16, 185, 129, 0.1);
            --accent-green-border: rgba(16, 185, 129, 0.15);
            --accent-orange: #f59e0b;
            --accent-orange-bg: rgba(245, 158, 11, 0.1);
            --accent-orange-border: rgba(245, 158, 11, 0.15);
            --accent-blue: #0ea5e9;
            --accent-blue-bg: rgba(14, 165, 233, 0.1);
            --accent-blue-border: rgba(14, 165, 233, 0.15);
            
            --sidebar-width: 270px;
            --sidebar-collapsed-width: 88px;
            
            --glass-blur: 16px;
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
            
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px -5px rgba(13, 148, 136, 0.04), 0 8px 10px -6px rgba(13, 148, 136, 0.04);
            --shadow-lg: 0 20px 32px -4px rgba(13, 148, 136, 0.08), 0 12px 14px -6px rgba(13, 148, 136, 0.04);
            --shadow-glow: 0 0 20px rgba(13, 148, 136, 0.12);
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            position: relative;
        }

        /* ══════════════════ MOTION BACKGROUND ══════════════════ */
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            pointer-events: none;
        }

        .mesh-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.45;
            animation: drift 25s infinite alternate ease-in-out;
        }

        .orb-1 {
            top: -10%;
            left: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.18) 0%, rgba(13, 148, 136, 0) 70%);
            animation-duration: 22s;
        }

        .orb-2 {
            bottom: -10%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.22) 0%, rgba(14, 165, 233, 0) 70%);
            animation-duration: 28s;
            animation-delay: -7s;
        }

        .orb-3 {
            top: 25%;
            left: 35%;
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%);
            animation-duration: 24s;
            animation-delay: -12s;
        }

        @keyframes drift {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            50% { transform: translate(4%, 6%) scale(1.08) rotate(180deg); }
            100% { transform: translate(-2%, -4%) scale(0.96) rotate(360deg); }
        }

        /* ══════════════════ SIDEBAR ══════════════════ */
        .sidebar {
            position: fixed;
            top: 20px;
            left: 20px;
            bottom: 20px;
            width: var(--sidebar-width);
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--glass-shadow), var(--shadow-md);
            overflow: hidden;
        }

        .sidebar-brand {
            height: 80px;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 800;
            font-size: 22px;
            transition: all var(--transition-speed) ease;
            padding: 8px 12px;
            border-radius: 14px;
            margin-left: -12px;
            margin-right: -12px;
        }

        .brand-link:hover {
            background-color: var(--hover-color);
            color: var(--brand-color);
        }

        .brand-logo-container {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--brand-color) 0%, #312e81 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.25);
            transition: all var(--transition-speed) ease;
        }

        .brand-link:hover .brand-logo-container {
            transform: scale(1.05);
            box-shadow: 0 8px 22px rgba(13, 148, 136, 0.35);
        }

        .brand-name {
            white-space: nowrap;
            font-weight: 800;
            letter-spacing: -0.5px;
            transition: opacity var(--transition-speed);
        }

        .sidebar-toggle {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 11px;
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
        }

        .sidebar-toggle:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
            border-color: var(--text-muted);
        }

        .sidebar-nav {
            flex: 1;
            padding: 24px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .nav-section {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: var(--text-muted);
            padding-left: 12px;
            margin-top: 16px;
            margin-bottom: 8px;
            transition: opacity var(--transition-speed);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
            border: 1px solid transparent;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        .nav-link:hover i {
            color: var(--brand-color);
            transform: scale(1.1);
        }

        .nav-link.active {
            background: var(--brand-light);
            color: var(--brand-color);
            font-weight: 700;
            border-color: rgba(13, 148, 136, 0.1);
        }

        .nav-link.active i {
            color: var(--brand-color);
        }

        /* Support bottom link */
        .sidebar-nav-bottom {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
        }

        /* Collapsed Sidebar Styles */
        body.collapsed-sidebar-active .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.collapsed-sidebar-active .brand-name,
        body.collapsed-sidebar-active .nav-section,
        body.collapsed-sidebar-active .nav-link-text {
            opacity: 0;
            pointer-events: none;
            width: 0;
            display: none;
        }

        body.collapsed-sidebar-active .sidebar-brand {
            justify-content: center;
            padding: 0;
        }

        body.collapsed-sidebar-active .sidebar-toggle {
            position: absolute;
            right: 12px;
            top: 28px;
            transform: rotate(180deg);
        }

        body.collapsed-sidebar-active .nav-link {
            justify-content: center;
            padding: 12px;
            border-radius: 12px;
        }

        body.collapsed-sidebar-active .nav-link i {
            margin: 0;
        }

        /* ══════════════════ MAIN WRAPPER ══════════════════ */
        .main-wrapper {
            flex: 1;
            min-width: 0;
            margin-left: calc(var(--sidebar-width) + 40px);
            padding-right: 20px;
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }

        body.collapsed-sidebar-active .main-wrapper {
            margin-left: calc(var(--sidebar-collapsed-width) + 40px);
        }

        /* Header Navigation */
        .main-header {
            height: 80px;
            margin-top: 20px;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--glass-shadow);
            position: sticky;
            top: 20px;
            z-index: 900;
            transition: all var(--transition-speed);
        }

        .welcome-meta {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .mobile-hamburger {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--surface-color-solid);
            color: var(--text-main);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: all var(--transition-speed);
        }

        .mobile-hamburger:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
            border-color: var(--text-muted);
        }

        .welcome-text h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .welcome-text p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 500;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .action-btn {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            transition: all var(--transition-speed) ease;
            text-decoration: none;
        }

        .action-btn:hover {
            background-color: var(--hover-color);
            color: var(--brand-color);
            border-color: rgba(13, 148, 136, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.08);
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid var(--surface-color-solid);
            box-sizing: content-box;
            animation: pulse-glow-red 2s infinite;
        }

        @keyframes pulse-glow-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Profile Dropdown Toggle Button */
        .profile-dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            cursor: pointer;
            transition: all var(--transition-speed) ease;
        }

        .profile-dropdown-trigger:hover {
            border-color: rgba(13, 148, 136, 0.2);
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.08);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            overflow: hidden;
        }

        .profile-avatar svg {
            width: 100%;
            height: 100%;
        }

        .profile-dropdown-trigger i {
            font-size: 11px;
            color: var(--text-main);
            padding-right: 4px;
        }

        /* Dropdown Panel */
        .profile-dropdown-menu {
            position: absolute;
            top: 55px;
            right: 0;
            width: 230px;
            background: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            display: none;
            flex-direction: column;
            padding: 8px;
            z-index: 1200;
            animation: dropdownFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-dropdown-menu.show {
            display: flex;
        }

        .notification-dropdown-trigger {
            position: relative;
            cursor: pointer;
        }
        
        .notification-dropdown-menu {
            position: absolute;
            top: 55px;
            right: 0;
            width: 300px;
            background: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            display: none;
            flex-direction: column;
            padding: 8px 0 0 0;
            z-index: 1200;
            animation: dropdownFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .notification-dropdown-menu.show {
            display: flex;
        }

        .notification-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.2s;
        }
        
        .notification-item:hover {
            background-color: var(--hover-color);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-message {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.4;
            font-weight: 500;
        }

        .notification-time {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .dropdown-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 6px;
        }

        .dropdown-header-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .dropdown-header-role {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 600;
        }

        .dropdown-item {
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all var(--transition-speed);
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: inherit;
            border-radius: 10px;
            font-weight: 600;
        }

        .dropdown-item:hover {
            background-color: var(--hover-color);
            color: var(--brand-color);
        }

        .dropdown-item i {
            font-size: 16px;
            width: 18px;
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .dropdown-item:hover i {
            color: var(--brand-color);
        }

        .dropdown-item.logout-btn {
            color: #ef4444;
        }

        .dropdown-item.logout-btn i {
            color: #ef4444;
        }

        .dropdown-item.logout-btn:hover {
            background-color: #fef2f2;
        }

        /* Sidebar Overlay backdrop */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 950;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .sidebar {
                transform: translateX(calc(-100% - 40px));
                position: fixed;
                top: 20px;
                left: 20px;
                bottom: 20px;
            }

            .main-wrapper {
                margin-left: 20px;
                padding-right: 20px;
            }

            .mobile-hamburger {
                display: flex;
            }

            body.mobile-sidebar-active .sidebar {
                transform: translateX(0);
            }

            body.mobile-sidebar-active .sidebar-overlay {
                display: block;
                opacity: 1;
            }
        }

        /* ══════════════════ CONTENT ══════════════════ */
        .content {
            padding: 32px 0;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* Profile Hero Banner */
        .profile-hero {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--brand-gradient);
        }

        .profile-hero-left {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .profile-avatar-lg {
            width: 88px;
            height: 88px;
            border-radius: 24px;
            background: linear-gradient(135deg, var(--brand-color) 0%, #312e81 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.3);
            flex-shrink: 0;
            position: relative;
        }

        .profile-avatar-badge {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 26px;
            height: 26px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border: 3px solid var(--surface-color-solid);
        }

        .profile-hero-info h2 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 4px;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .profile-hero-info p {
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .profile-meta-tags {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .tag-pill {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tag-pill.brand {
            background: var(--brand-light);
            color: var(--brand-color);
        }

        .tag-pill.muted {
            background: var(--hover-color);
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        /* Form Card */
        .form-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 28px;
            box-shadow: var(--glass-shadow), var(--shadow-md);
            transition: all 0.3s ease;
        }

        .form-card-title {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
        }

        .form-card-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--brand-light);
            color: var(--brand-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-input {
            width: 100%;
            background: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 13px 18px;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--brand-color);
            background: var(--surface-color-solid);
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.12);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        textarea.form-input {
            resize: vertical;
            min-height: 90px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: var(--brand-gradient);
            color: #fff;
            padding: 14px 32px;
            border-radius: 14px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px rgba(13, 148, 136, 0.25);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(13, 148, 136, 0.35);
        }

        .alert-success {
            background-color: var(--accent-green-bg);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--accent-green);
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: var(--shadow-sm);
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .error-list {
            list-style: none;
        }

        .error-list li {
            margin-bottom: 4px;
        }

        .field-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .profile-hero {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Bank Selector Styles */
        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(135px, 1fr));
            gap: 16px;
            margin-top: 12px;
            margin-bottom: 20px;
        }

        .bank-card {
            background: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .bank-card:hover {
            border-color: var(--brand-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 148, 136, 0.08);
        }

        .bank-card.selected {
            border-color: var(--brand-color);
            background: var(--brand-light);
            box-shadow: 0 0 0 2px var(--brand-color), 0 10px 24px rgba(13, 148, 136, 0.15);
        }

        .bank-card.selected::after {
            content: "\f058";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 12px;
            font-size: 16px;
            color: var(--brand-color);
            animation: scaleIn 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .bank-logo {
            width: 54px;
            height: 54px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            overflow: hidden;
            transition: transform 0.2s ease;
        }

        .bank-card:hover .bank-logo {
            transform: scale(1.06);
        }

        .bank-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Motion Background -->
    <div class="mesh-bg">
        <div class="mesh-orb orb-1"></div>
        <div class="mesh-orb orb-2"></div>
        <div class="mesh-orb orb-3"></div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ══════════ LEFT SIDEBAR ══════════ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <div class="brand-logo-container">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <span class="brand-name">Plumbfix</span>
            </a>
            <button class="sidebar-toggle" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-chevron-left" id="toggleChevronIcon"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section">Main Menu</div>
            
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fa-solid fa-table-columns"></i>
                <span class="nav-link-text">Overview</span>
            </a>
            
            <a href="{{ route('customer.bookings') }}" class="nav-link">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <span class="nav-link-text">Services</span>
            </a>
            
            <a href="{{ route('customer.booking.create') }}" class="nav-link">
                <i class="fa-solid fa-calendar-plus"></i>
                <span class="nav-link-text">Book Service</span>
            </a>
            
            <a href="{{ route('customer.feedback') }}" class="nav-link">
                <i class="fa-solid fa-comment-dots"></i>
                <span class="nav-link-text">Feedback</span>
            </a>
        </nav>
    </aside>

    <!-- ══════════ MAIN WRAPPER ══════════ -->
    <div class="main-wrapper">
        
        <!-- Header -->
        <header class="main-header">
            <div class="welcome-meta">
                <button class="mobile-hamburger" id="mobileHamburger" aria-label="Open Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="welcome-text">
                    <h1>My Profile</h1>
                    <p>Manage your account settings and personal details</p>
                </div>
            </div>

            @php
                $userForNotifications = auth('customer')->user() ?? auth('staff')->user();
                $unreadCount = $userForNotifications ? $userForNotifications->unreadNotifications->count() : 0;
                $userEmail = $userForNotifications->customerEmail ?? $userForNotifications->staffEmail ?? 'customer@gmail.com';

                $hasChatMessages = false;
                if (auth('customer')->check()) {
                    $custUser = auth('customer')->user();
                    $hasChatMessages = \App\Models\ChatMessage::whereHas('booking', function($q) use ($custUser) {
                        $q->where('customerID', $custUser->customerID);
                    })->where('sender_type', 'staff')->exists();
                }

                $gmailUrl = "https://mail.google.com/mail/u/0/#search/Plumbfix";
            @endphp
            <div class="header-actions">
                <!-- Email Notifications Dropdown -->
                <div class="email-dropdown-trigger" id="emailTriggerBtn" style="position:relative;">
                    <a href="javascript:void(0)" class="action-btn" aria-label="Mail" style="position: relative;">
                        <i class="fa-regular fa-envelope"></i>
                        @if($hasChatMessages)
                        <span class="chat-dot"></span>
                        @endif
                    </a>

                    <div class="notification-dropdown-menu" id="emailDropdownMenu" style="width: 320px;">
                        <div class="dropdown-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="dropdown-header-name" style="display:flex; align-items:center; gap:6px;">
                                <i class="fa-solid fa-envelope" style="color:var(--brand-color);"></i>
                                Plumbfix Email Inbox
                            </div>
                            <span style="font-size: 10px; font-weight:700; color:var(--text-muted); background:var(--hover-color); padding:2px 8px; border-radius:10px;">Gmail</span>
                        </div>
                        <div class="notification-list">
                            <a href="{{ $gmailUrl }}" target="_blank" class="notification-item" style="display:block; text-decoration:none;">
                                <div class="notification-message" style="font-weight:700; color:var(--text-dark);">
                                    📧 Booking Confirmation & Invoice
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                                    Official Plumbfix booking details & receipt emailed to <strong>{{ $userEmail }}</strong>
                                </div>
                                <div class="notification-time">Today · Click to open in Gmail ↗</div>
                            </a>
                            <a href="{{ $gmailUrl }}" target="_blank" class="notification-item" style="display:block; text-decoration:none;">
                                <div class="notification-message" style="font-weight:700; color:var(--text-dark);">
                                    🛠️ Expert Dispatch Notification
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                                    Verified plumber status & dispatch details sent to <strong>{{ $userEmail }}</strong>
                                </div>
                                <div class="notification-time">1 day ago · Click to open in Gmail ↗</div>
                            </a>
                        </div>
                        <a href="{{ $gmailUrl }}" target="_blank" class="dropdown-item" style="color: var(--brand-color); justify-content: center; font-weight: 700; border-top: 1px solid var(--border-color); border-radius: 0 0 12px 12px; margin-top: 4px; gap: 8px; text-decoration: none;">
                            <svg width="14" height="14" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                            </svg>
                            Open Gmail Inbox ↗
                        </a>
                    </div>
                </div>

                <!-- Bell Notifications Dropdown -->
                <div class="notification-dropdown-trigger" id="notificationTriggerBtn" style="position:relative;">
                    <a href="javascript:void(0)" class="action-btn" aria-label="Notifications">
                        <i class="fa-regular fa-bell"></i>
                        @if($unreadCount > 0)
                        <span class="notification-dot"></span>
                        @endif
                    </a>
                    
                    <div class="notification-dropdown-menu" id="notificationDropdownMenu">
                        <div class="dropdown-header">
                            <div class="dropdown-header-name">Recent Activity</div>
                        </div>
                        <div class="notification-list">
                            @if($userForNotifications && $unreadCount > 0)
                                @foreach($userForNotifications->unreadNotifications->take(5) as $notification)
                                    <div class="notification-item">
                                        <div class="notification-message">{{ $notification->data['message'] ?? 'New activity' }}</div>
                                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="notification-item text-muted" style="border:none; padding-bottom:16px;">No recent activity.</div>
                            @endif
                        </div>
                        @if($unreadCount > 0)
                        <form action="{{ route('notifications.markAsRead') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="color: var(--brand-color); justify-content: center; font-weight: 600; border-top: 1px solid var(--border-color); border-radius: 0 0 12px 12px; margin-top: 4px;">
                                Mark all as read
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Profile Dropdown Trigger -->
                <div class="profile-dropdown-trigger" id="profileTriggerBtn">
                    <div class="profile-avatar">
                        <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="tinyAvatarGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#ffedd5" />
                                    <stop offset="100%" stop-color="#fed7aa" />
                                </linearGradient>
                            </defs>
                            <circle cx="60" cy="60" r="60" fill="url(#tinyAvatarGrad)" />
                            <circle cx="60" cy="55" r="22" fill="#ffd8be" />
                            <path d="M36 50c-2-15 8-28 24-28s26 13 24 28c-2 4-5 6-8 4-4-2-6-8-16-8s-12 6-16 8c-3 2-6 0-8-4z" fill="#f59e0b" />
                            <path d="M40 38c5-10 18-12 28-8 10 4 12 12 10 16-5 2-15-4-22-2-6 2-12-2-16-6z" fill="#fbbf24" />
                            <path d="M20 100c10-25 22-30 40-30s30 5 40 30v20H20v-20z" fill="#4f46e5" />
                            <path d="M50 70l10 15 10-15z" fill="#4f46e5" />
                        </svg>
                    </div>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <!-- Dropdown Menu Options -->
                <div class="profile-dropdown-menu" id="profileDropdownMenu">
                    <div class="dropdown-header">
                        <div class="dropdown-header-name">{{ $customer->customerName ?? 'Customer' }}</div>
                        <div class="dropdown-header-role">Customer</div>
                    </div>
                    <a href="{{ route('customer.profile') }}" class="dropdown-item active">
                        <i class="fa-solid fa-user-gear"></i> Edit Profile
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="dropdown-item">
                        <i class="fa-solid fa-clipboard-list"></i> My Bookings
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            @if(session('success'))
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Profile Hero Banner -->
            <div class="profile-hero">
                <div class="profile-hero-left">
                    <div class="profile-avatar-lg">
                        {{ strtoupper(substr($customer->customerName, 0, 1)) }}
                        <span class="profile-avatar-badge" title="Verified Customer Account">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <div class="profile-hero-info">
                        <h2>{{ $customer->customerName }}</h2>
                        <p>{{ $customer->customerEmail }}</p>
                        <div class="profile-meta-tags">
                            <span class="tag-pill brand">
                                <i class="fa-solid fa-user-shield"></i> Verified Customer
                            </span>
                            <span class="tag-pill muted">
                                <i class="fa-solid fa-calendar-days"></i> Member since {{ $customer->created_at->format('F Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Info Form -->
            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf

                <div class="form-card">
                    <div class="form-card-title">
                        <div class="form-card-icon"><i class="fa-solid fa-user"></i></div>
                        Personal Information
                    </div>

                    <div class="form-group">
                        <label for="customerName" class="form-label">Full Name</label>
                        <input id="customerName" type="text" name="customerName" class="form-input"
                               value="{{ old('customerName', $customer->customerName) }}" required>
                        @error('customerName')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" value="{{ $customer->customerEmail }}" disabled
                               style="opacity:0.5;cursor:not-allowed;">
                        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;">Email cannot be changed. Contact support if needed.</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="customerPhoneNo" class="form-label">Phone Number</label>
                            <input id="customerPhoneNo" type="text" name="customerPhoneNo" class="form-input"
                                   value="{{ old('customerPhoneNo', $customer->customerPhoneNo) }}"
                                   placeholder="e.g. 012-3456789">
                            @error('customerPhoneNo')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div></div>
                    </div>

                    <div class="form-group">
                        <label for="customerAddress" class="form-label">Address</label>
                        <textarea id="customerAddress" name="customerAddress" class="form-input"
                                  placeholder="Your home/service address">{{ old('customerAddress', $customer->customerAddress) }}</textarea>
                        @error('customerAddress')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Bank Information -->
                <div class="form-card">
                    <div class="form-card-title">
                        <div class="form-card-icon"><i class="fa-solid fa-building-columns"></i></div>
                        Bank Details & Refund Info
                    </div>

                    <div class="form-group">
                        <label class="form-label">Select Your Bank</label>
                        <input type="hidden" name="customerBankName" id="customerBankName" value="{{ old('customerBankName', $customer->customerBankName) }}">
                        
                        <div class="bank-grid">
                            <!-- Maybank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Maybank' ? 'selected' : '' }}" data-bank="Maybank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#FFD100"/>
                                        <g transform="translate(15, 15) scale(0.7)">
                                            <path d="M50 10 C 25 15, 15 35, 20 60 C 25 80, 40 85, 50 90 C 60 85, 75 80, 80 60 C 85 35, 75 15, 50 10 Z" fill="#000000"/>
                                            <path d="M50 22 L45 35 L55 35 Z" fill="#FFD100"/>
                                            <path d="M30 45 L42 48 L32 55 Z" fill="#FFD100"/>
                                            <path d="M70 45 L58 48 L68 55 Z" fill="#FFD100"/>
                                            <circle cx="40" cy="58" r="4" fill="#FFD100"/>
                                            <circle cx="60" cy="58" r="4" fill="#FFD100"/>
                                            <path d="M45 70 Q50 78 55 70 Z" fill="#FFD100"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="bank-name">Maybank</div>
                            </div>

                            <!-- CIMB Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'CIMB Bank' ? 'selected' : '' }}" data-bank="CIMB Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#8C0D11"/>
                                        <g fill="#FFFFFF" transform="translate(18, 25)">
                                            <path d="M0 15 L25 25 L0 35 Z" opacity="0.6"/>
                                            <path d="M20 10 L50 25 L20 40 Z"/>
                                            <path d="M40 5 L75 25 L40 45 Z" opacity="0.8"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="bank-name">CIMB Bank</div>
                            </div>

                            <!-- Public Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Public Bank' ? 'selected' : '' }}" data-bank="Public Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#E11B22"/>
                                        <g transform="translate(50, 45)">
                                            <polygon points="0,-30 8,-10 30,-10 12,4 18,26 0,12 -18,26 -12,4 -30,-10 -8,-10" fill="#FFFFFF"/>
                                        </g>
                                        <text x="50" y="86" font-family="'Outfit', sans-serif" font-weight="800" font-size="14" fill="#FFFFFF" text-anchor="middle">PUBLIC BANK</text>
                                    </svg>
                                </div>
                                <div class="bank-name">Public Bank</div>
                            </div>

                            <!-- RHB Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'RHB Bank' ? 'selected' : '' }}" data-bank="RHB Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#005CA9"/>
                                        <path d="M25 35 C35 30, 65 30, 75 35 L75 60 C75 75, 50 85, 50 85 C50 85, 25 75, 25 60 Z" fill="#00A1E4"/>
                                        <text x="50" y="58" font-family="'Outfit', sans-serif" font-weight="900" font-size="20" fill="#FFFFFF" text-anchor="middle">RHB</text>
                                    </svg>
                                </div>
                                <div class="bank-name">RHB Bank</div>
                            </div>

                            <!-- Hong Leong Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Hong Leong Bank' ? 'selected' : '' }}" data-bank="Hong Leong Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#002D62"/>
                                        <circle cx="50" cy="50" r="25" fill="none" stroke="#FFFFFF" stroke-width="6"/>
                                        <circle cx="50" cy="50" r="12" fill="#E11B22"/>
                                        <path d="M50 15 L50 35" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round"/>
                                        <path d="M50 65 L50 85" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <div class="bank-name">Hong Leong Bank</div>
                            </div>

                            <!-- AmBank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'AmBank' ? 'selected' : '' }}" data-bank="AmBank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#0B2347"/>
                                        <g transform="translate(50, 48)">
                                            <polygon points="-25,15 0,-25 25,15" fill="#E11B22" opacity="0.9"/>
                                            <polygon points="-15,15 0,-10 15,15" fill="#FFC72C"/>
                                        </g>
                                        <text x="50" y="86" font-family="'Outfit', sans-serif" font-weight="800" font-size="10" fill="#FFFFFF" text-anchor="middle" letter-spacing="1">AmBank</text>
                                    </svg>
                                </div>
                                <div class="bank-name">AmBank</div>
                            </div>

                            <!-- Bank Islam -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Bank Islam' ? 'selected' : '' }}" data-bank="Bank Islam">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#006A4E"/>
                                        <path d="M60 30 A20 20 0 1 0 60 70 A15 15 0 1 1 60 30" fill="#FFD100"/>
                                        <text x="50" y="86" font-family="'Outfit', sans-serif" font-weight="800" font-size="10" fill="#FFFFFF" text-anchor="middle">BANK ISLAM</text>
                                    </svg>
                                </div>
                                <div class="bank-name">Bank Islam</div>
                            </div>

                            <!-- Affin Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Affin Bank' ? 'selected' : '' }}" data-bank="Affin Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#00517C"/>
                                        <path d="M30 30 L70 30 L50 70 Z" fill="#00A1E4"/>
                                        <path d="M40 30 L60 30 L50 50 Z" fill="#E11B22"/>
                                        <text x="50" y="86" font-family="'Outfit', sans-serif" font-weight="800" font-size="11" fill="#FFFFFF" text-anchor="middle">AFFIN BANK</text>
                                    </svg>
                                </div>
                                <div class="bank-name">Affin Bank</div>
                            </div>

                            <!-- Alliance Bank -->
                            <div class="bank-card {{ old('customerBankName', $customer->customerBankName) === 'Alliance Bank' ? 'selected' : '' }}" data-bank="Alliance Bank">
                                <div class="bank-logo">
                                    <svg viewBox="0 0 100 100">
                                        <rect width="100" height="100" rx="16" fill="#F8FAFC" stroke="#E2E8F0" stroke-width="2"/>
                                        <circle cx="40" cy="45" r="20" fill="#005CA9" opacity="0.85"/>
                                        <circle cx="60" cy="45" r="20" fill="#FFC72C" opacity="0.85"/>
                                        <text x="50" y="84" font-family="'Outfit', sans-serif" font-weight="800" font-size="11" fill="#005CA9" text-anchor="middle">ALLIANCE</text>
                                    </svg>
                                </div>
                                <div class="bank-name">Alliance Bank</div>
                            </div>
                        </div>
                        @error('customerBankName')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="customerBankAccountNo" class="form-label">Bank Account Number</label>
                        <input id="customerBankAccountNo" type="text" name="customerBankAccountNo" class="form-input"
                               value="{{ old('customerBankAccountNo', $customer->customerBankAccountNo) }}"
                               placeholder="e.g. 164012345678">
                        @error('customerBankAccountNo')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Change Password -->
                <div class="form-card">
                    <div class="form-card-title">
                        <div class="form-card-icon"><i class="fa-solid fa-lock"></i></div>
                        Security & Change Password <span style="font-size:12px;font-weight:500;color:var(--text-muted);margin-left:auto;">(Optional)</span>
                    </div>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" type="password" name="current_password" class="form-input"
                               placeholder="Enter current password">
                        @error('current_password')
                        <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password" class="form-label">New Password</label>
                            <input id="new_password" type="password" name="new_password" class="form-input"
                                   placeholder="Min. 8 characters">
                            @error('new_password')
                            <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-input"
                                   placeholder="Repeat new password">
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-save" id="saveProfileBtn">
                        <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- Javascript Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Toggle Action
            const sidebar = document.getElementById('sidebar');
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            const toggleChevronIcon = document.getElementById('toggleChevronIcon');

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', () => {
                    if (window.innerWidth < 1200) {
                        document.body.classList.remove('mobile-sidebar-active');
                    } else {
                        document.body.classList.toggle('collapsed-sidebar-active');
                        
                        // Toggle arrow icon
                        if (document.body.classList.contains('collapsed-sidebar-active')) {
                            toggleChevronIcon.className = 'fa-solid fa-chevron-right';
                        } else {
                            toggleChevronIcon.className = 'fa-solid fa-chevron-left';
                        }
                    }
                });
            }

            // Mobile Sidebar Toggle
            const mobileHamburger = document.getElementById('mobileHamburger');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (mobileHamburger && sidebarOverlay) {
                const toggleMobileSidebar = () => {
                    document.body.classList.toggle('mobile-sidebar-active');
                };

                mobileHamburger.addEventListener('click', toggleMobileSidebar);
                sidebarOverlay.addEventListener('click', toggleMobileSidebar);
            }

                    // Email Dropdown Toggle
        const emailBtn = document.getElementById('emailTriggerBtn');
        const emailMenu = document.getElementById('emailDropdownMenu');

        if (emailBtn && emailMenu) {
            emailBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                emailMenu.classList.toggle('show');

                // Hide email dot on click
                const emailDot = emailBtn.querySelector('.chat-dot');
                if (emailDot) {
                    emailDot.style.display = 'none';
                    sessionStorage.setItem('email_dot_dismissed', 'true');
                }

                const nMenu = document.getElementById('notificationDropdownMenu');
                const pMenu = document.getElementById('profileDropdownMenu');
                if (nMenu) nMenu.classList.remove('show');
                if (pMenu) pMenu.classList.remove('show');
            });

            document.addEventListener('click', (e) => {
                if (!emailBtn.contains(e.target) && !emailMenu.contains(e.target)) {
                    emailMenu.classList.remove('show');
                }
            });

            if (sessionStorage.getItem('email_dot_dismissed') === 'true') {
                const emailDot = emailBtn.querySelector('.chat-dot');
                if (emailDot) emailDot.style.display = 'none';
            }
        }

        // Notification Dropdown Toggle
        const notificationBtn = document.getElementById('notificationTriggerBtn');
        const notificationMenu = document.getElementById('notificationDropdownMenu');

        if (notificationBtn && notificationMenu) {
            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationMenu.classList.toggle('show');

                // Hide ONLY the bell red dot badge when clicked, keeping recent activity items visible!
                const bellDot = notificationBtn.querySelector('.notification-dot');
                if (bellDot) {
                    bellDot.style.display = 'none';
                }

                const eMenu = document.getElementById('emailDropdownMenu');
                const pMenu = document.getElementById('profileDropdownMenu');
                if (eMenu) eMenu.classList.remove('show');
                if (pMenu) pMenu.classList.remove('show');
            });

            document.addEventListener('click', (e) => {
                if (!notificationBtn.contains(e.target) && !notificationMenu.contains(e.target)) {
                    notificationMenu.classList.remove('show');
                }
            });
        }

        // Profile Dropdown Toggle Action
            const profileTriggerBtn = document.getElementById('profileTriggerBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            profileTriggerBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdownMenu.classList.toggle('show');
            });

            // Close dropdown if user clicks outside
            window.addEventListener('click', () => {
                if (profileDropdownMenu.classList.contains('show')) {
                    profileDropdownMenu.classList.remove('show');
                }
            });

            // Bank Selection Action
            const bankCards = document.querySelectorAll('.bank-card');
            const bankNameInput = document.getElementById('customerBankName');

            bankCards.forEach(card => {
                card.addEventListener('click', () => {
                    // Remove selected class from all cards
                    bankCards.forEach(c => c.classList.remove('selected'));
                    
                    // Add selected class to clicked card
                    card.classList.add('selected');
                    
                    // Set value in hidden input
                    bankNameInput.value = card.getAttribute('data-bank');
                });
            });
        });
    </script>
</body>
</html>
