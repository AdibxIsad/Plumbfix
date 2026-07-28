<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings — Plumbfix</title>
    <meta name="description" content="View and manage all your plumbing service bookings.">
    
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

        @media (max-width: 768px) {
            .notification-dropdown-menu,
            #emailDropdownMenu,
            #notificationDropdownMenu,
            .profile-dropdown-menu {
                position: fixed !important;
                top: 80px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                width: calc(100vw - 32px) !important;
                max-width: 360px !important;
                right: auto !important;
                z-index: 9999 !important;
                box-shadow: 0 12px 36px rgba(15, 23, 42, 0.2) !important;
            }
            .main-wrapper {
                margin-left: 10px !important;
                padding-right: 10px !important;
                width: calc(100% - 20px) !important;
                max-width: 100% !important;
                overflow-x: hidden;
            }
            .content {
                padding: 16px 10px !important;
                width: 100% !important;
            }
            .main-header {
                padding: 10px 14px !important;
                margin-top: 10px !important;
                height: auto !important;
                flex-wrap: wrap;
                gap: 10px;
            }
            .welcome-text h1 {
                font-size: 18px !important;
            }
            .welcome-text p {
                font-size: 11.5px !important;
            }
            .search-container, .table-wrap {
                padding: 14px 10px !important;
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .filter-bar {
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                gap: 6px !important;
            }
            .search-form {
                flex-direction: column !important;
                gap: 8px !important;
            }
            .filter-select, .search-input {
                width: 100% !important;
                flex: 1 1 100% !important;
            }
            .table-wrap table {
                min-width: 650px;
            }
        }

        /* ══════════════════ CONTENT AREA ══════════════════ */
        .content {
            padding: 40px;
            flex: 1;
        
            min-width: 0;
            max-width: 100%;}

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: var(--brand-color);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.15);
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Section Title */
        .section-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border-color);
        }

        .table-wrap {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow-x: auto;
            box-shadow: var(--shadow-sm);
        
            max-width: 100%;}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: var(--hover-color);
            padding: 14px 18px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        tbody tr {
            transition: background 0.15s;
        }

        tbody tr:hover {
            background-color: var(--hover-color);
        }

        tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--border-color);
        }

        tbody td {
            padding: 14px 18px;
            font-size: 14px;
            vertical-align: middle;
            color: var(--text-main);
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: var(--brand-light);
            border: 1px solid rgba(13, 148, 136, 0.15);
            color: var(--brand-color);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background-color: var(--accent-orange-bg);
            color: var(--accent-orange);
            border: 1px solid rgba(249, 115, 22, 0.25);
        }

        .status-confirmed {
            background-color: var(--accent-blue-bg);
            color: var(--accent-blue);
            border: 1px solid rgba(59, 130, 246, 0.25);
        }

        .status-in_progress {
            background-color: #f5f3ff;
            color: #7c3aed;
            border: 1px solid rgba(124, 58, 237, 0.25);
        }

        .status-completed {
            background-color: var(--accent-green-bg);
            color: var(--accent-green);
            border: 1px solid rgba(34, 197, 94, 0.25);
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: #fef2f2;
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #ef4444;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete:hover:not(:disabled) {
            background-color: #fee2e2;
        }

        .btn-delete:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 48px;
            margin-bottom: 14px;
            opacity: 0.5;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 16px;
        }

        .alert-success {
            background-color: var(--accent-green-bg);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: var(--accent-green);
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            box-shadow: var(--shadow-sm);
        }

        /* Modal styling matching theme */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 32px;
            max-width: 420px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-lg);
            animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-icon {
            font-size: 48px;
            color: #ef4444;
            margin-bottom: 16px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .modal-text {
            font-size: 14.5px;
            color: var(--text-main);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-cancel-modal {
            padding: 10px 20px;
            border-radius: 10px;
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel-modal:hover {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        .btn-confirm-delete {
            padding: 10px 20px;
            border-radius: 10px;
            background-color: #ef4444;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.15);
        }

        .btn-confirm-delete:hover {
            opacity: 0.9;
        }

        /* Pagination Styling */
        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
            padding: 10px 0;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color);
            color: var(--text-main);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .page-link:hover:not(.disabled) {
            border-color: var(--brand-color);
            color: var(--brand-color);
            background-color: var(--brand-light);
        }

        .page-link.active {
            background-color: var(--brand-color);
            color: white;
            border-color: var(--brand-color);
            box-shadow: 0 2px 8px rgba(13, 148, 136, 0.15);
        }

        .page-link.disabled {
            color: var(--text-muted);
            opacity: 0.5;
            cursor: not-allowed;
            background-color: var(--hover-color);
        }

        /* Filter Panel CSS */
        .filter-container {
            display: flex;
            align-items: center;
            gap: 16px;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 18px;
            box-shadow: var(--shadow-sm);
            flex-wrap: wrap;
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-item label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        .filter-input {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--hover-color);
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 140px;
        }

        .filter-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color);
        }

        .btn-reset-filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background-color: var(--hover-color);
            color: var(--text-main);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.2s;
        }

        .btn-reset-filter:hover {
            background-color: #fee2e2;
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.2);
        }

        /* Slide-out Chat Drawer (Task 17) & Toast Notification (Task 7) */
        .chat-drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            height: 100%;
            background-color: var(--surface-color);
            box-shadow: -4px 0 24px rgba(15, 23, 42, 0.15);
            z-index: 10000;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            border-left: 1px solid var(--border-color);
        }
        .chat-drawer.open {
            right: 0;
        }
        .chat-drawer-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--hover-color);
        }
        .chat-drawer-title {
            font-weight: 800;
            color: var(--text-dark);
            font-size: 16px;
        }
        .chat-drawer-close {
            border: none;
            background: none;
            font-size: 24px;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }
        .chat-drawer-close:hover {
            color: #ef4444;
        }
        .chat-messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background-color: #f8fafc;
        }
        .chat-message-bubble {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.4;
            word-break: break-word;
        }
        .chat-message-bubble.incoming {
            background-color: var(--surface-color);
            color: var(--text-dark);
            align-self: flex-start;
            border: 1px solid var(--border-color);
            border-top-left-radius: 4px;
        }
        .chat-message-bubble.outgoing {
            background-color: var(--brand-color);
            color: white;
            align-self: flex-end;
            border-top-right-radius: 4px;
        }
        .chat-message-meta {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 4px;
            text-align: right;
        }
        .chat-message-bubble.outgoing .chat-message-meta {
            color: rgba(255, 255, 255, 0.7);
        }
        .chat-drawer-footer {
            padding: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            background-color: var(--surface-color);
        }
        .chat-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: border 0.2s;
            background-color: var(--hover-color);
            color: var(--text-dark);
        }
        .chat-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color);
        }
        .chat-send-btn {
            padding: 10px 16px;
            background-color: var(--brand-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
            font-family: 'Outfit', sans-serif;
        }
        .chat-send-btn:hover {
            opacity: 0.9;
        }

        .booking-chat-dot {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 9px;
            height: 9px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: bippingPulse 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        .booking-chat-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid #ef4444;
            opacity: 0.8;
            animation: bippingPing 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes bippingPulse {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        @keyframes bippingPing {
            0% { transform: scale(0.8); opacity: 0.8; }
            70%, 100% { transform: scale(2.2); opacity: 0; }
        }

        /* Toast notifications styles */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 100005;
            pointer-events: none;
        }
        .toast-card {
            pointer-events: auto;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            border-radius: 12px;
            padding: 16px 20px;
            width: 320px;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border-left: 4px solid var(--brand-color);
        }
        .toast-card.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast-icon {
            font-size: 20px;
            color: var(--brand-color);
        }
        .toast-content {
            flex: 1;
        }
        .toast-title {
            font-weight: 700;
            font-size: 13.5px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }
        .toast-text {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.4;
        }
        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 18px;
            padding: 0 4px;
            line-height: 1;
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
            
            <a href="{{ route('customer.bookings') }}" class="nav-link active">
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
                    <h1>My Bookings</h1>
                    <p>View and manage all your plumbing service bookings</p>
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
                    <a href="{{ route('customer.profile') }}" class="dropdown-item">
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
            <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
            <div class="alert-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <!-- Date Filtering Options -->
            <div class="filter-container">
                <form action="{{ route('customer.bookings') }}" method="GET" id="filterForm" class="filter-form">
                    {{-- Year --}}
                    <div class="filter-item">
                        <label for="year">Year</label>
                        <select name="year" id="year" class="filter-input" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Years</option>
                            <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ request('year') == '2026' ? 'selected' : '' }}>2026</option>
                        </select>
                    </div>

                    {{-- Month --}}
                    <div class="filter-item">
                        <label for="month">Month</label>
                        <select name="month" id="month" class="filter-input" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Months</option>
                            @for ($m = 1; $m <= 12; $m++)
                                @php
                                    $monthName = date('F', mktime(0, 0, 0, $m, 1));
                                    $val = sprintf('%02d', $m);
                                @endphp
                                <option value="{{ $val }}" {{ request('month') == $val ? 'selected' : '' }}>{{ $monthName }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Day/Date --}}
                    <div class="filter-item">
                        <label for="date">Specific Day</label>
                        <input type="date" name="date" id="date" class="filter-input" value="{{ request('date') }}" onchange="document.getElementById('filterForm').submit()">
                    </div>

                    {{-- Reset --}}
                    @if (request()->filled('year') || request()->filled('month') || request()->filled('date'))
                        <a href="{{ route('customer.bookings') }}" class="btn-reset-filter"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    @endif

                    {{-- New Booking --}}
                    <a href="{{ route('customer.booking.create') }}" class="btn-primary" style="margin-left: auto; margin-top: 15px;">➕ New Booking</a>
                </form>
            </div>

            <div class="table-wrap">
                @if($bookings->isEmpty())
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p>You have no bookings yet. Create your first booking to get started!</p>
                        <a href="{{ route('customer.booking.create') }}" class="btn-primary">Book a Service</a>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service Type</th>
                                <th>Problem</th>
                                <th>Assigned Plumber</th>
                                <th>Description</th>
                                <th>Photo</th>
                                <th>Deposit Receipt</th>
                                <th>Payment Status</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td style="color:var(--text-muted);font-size:13px;">#{{ $booking->bookingID }}</td>
                                <td><span class="type-badge">{{ $booking->service_icon }} {{ $booking->bookingType }}</span></td>
                                <td style="font-weight:600; color:var(--text-dark);">{{ $booking->bookingProblem }}</td>
                                <td>
                                    @if($booking->staff)
                                        <div style="font-weight:600;color:var(--text-dark);">{{ $booking->staff->staffName }}</div>
                                        <div style="font-size:11.5px;color:var(--text-muted);">ID: #{{ $booking->staffID }}</div>
                                    @else
                                        <span class="status-badge" style="background-color:#f1f5f9; color:#64748b; border: 1px solid rgba(100,116,139,0.15); text-transform:none; font-weight:600; letter-spacing:normal;">Pending Assignment</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-muted);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $booking->bookingIssueDescription ?? '—' }}
                                </td>
                                <td>
                                    @if($booking->bookingAttachment)
                                        <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($booking->bookingAttachment) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:13px;">
                                            <i class="fa-regular fa-image" style="font-size:16px;"></i> View Photo
                                        </a>
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->bookingDepositReceipt)
                                        @if(Str::endsWith($booking->bookingDepositReceipt, '.pdf'))
                                            <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($booking->bookingDepositReceipt) }}" data-is-pdf="true" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:13px;">
                                                <i class="fa-solid fa-file-pdf" style="font-size:16px;"></i> View PDF
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($booking->bookingDepositReceipt) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:13px;">
                                                <i class="fa-solid fa-receipt" style="font-size:16px;"></i> View Receipt
                                            </a>
                                        @endif
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                        @php
                                            $dispPaymentStatus = ($booking->bookingStatus === 'cancelled' && $booking->paymentStatus === 'Pending') ? 'Cancelled' : $booking->paymentStatus;
                                        @endphp
                                        <span class="status-badge" style="
                                            @if($dispPaymentStatus === 'Pending') background-color: rgba(249, 115, 22, 0.15); color: #fdba74; border: 1px solid rgba(249, 115, 22, 0.2);
                                            @elseif($dispPaymentStatus === 'Awaiting Verification') background-color: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.2);
                                            @elseif($dispPaymentStatus === 'Paid') background-color: rgba(16, 185, 129, 0.15); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.2);
                                            @elseif($dispPaymentStatus === 'Rejected' || $dispPaymentStatus === 'Cancelled') background-color: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2);
                                            @endif
                                            font-size: 11px; padding: 4px 8px; text-transform: uppercase; font-weight: 700; border-radius: 30px; display: inline-flex; align-items: center; gap: 4px;
                                        ">
                                            @if($dispPaymentStatus === 'Paid')
                                                <i class="fa-solid fa-circle-check"></i>
                                            @elseif($dispPaymentStatus === 'Cancelled')
                                                <i class="fa-solid fa-ban"></i>
                                            @endif
                                            {{ $dispPaymentStatus }}
                                        </span>
                                        @if($booking->paymentSubmittedAt)
                                            <span style="font-size: 10.5px; color: var(--text-muted); white-space: nowrap;">
                                                Sub: {{ $booking->paymentSubmittedAt->timezone('Asia/Kuala_Lumpur')->format('d M y, h:i A') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($booking->bookingDate)->format('d M Y') }}</td>
                                <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($booking->bookingTime)->format('h:i A') }}</td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-start;">
                                        <span class="status-badge status-{{ $booking->bookingStatus }}">
                                            @if($booking->bookingStatus === 'pending')
                                                ⏳ Awaiting Approval
                                            @else
                                                {{ ucwords(str_replace('_', ' ', $booking->bookingStatus)) }}
                                            @endif
                                        </span>
                                        @if($booking->bookingStatus === 'cancelled' && $booking->refund_status !== 'not_applicable')
                                            <span class="status-badge" style="
                                                @if($booking->refund_status === 'pending') background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2);
                                                @elseif($booking->refund_status === 'refunded') background-color: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);
                                                @endif
                                                font-size: 10px; padding: 4px 8px; font-weight: 700; border-radius: 30px; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px;
                                            ">
                                                @if($booking->refund_status === 'pending')
                                                    <i class="fa-solid fa-clock-rotate-left"></i> Pending Refund (RM {{ number_format($booking->refund_amount, 2) }})
                                                @else
                                                    <i class="fa-solid fa-circle-check"></i> Refunded (RM {{ number_format($booking->refund_amount, 2) }})
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 6px;">
                                        @if($booking->bookingStatus === 'pending')
                                            <button class="btn-primary" disabled style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 600; opacity: 0.65; cursor: not-allowed; background-color: var(--hover-color); color: var(--text-muted); border: 1px solid var(--border-color); text-align: center;">
                                                <i class="fa-solid fa-clock"></i> Awaiting Approval
                                            </button>
                                        @elseif(($booking->paymentStatus === 'Pending' || $booking->paymentStatus === 'Rejected') && $booking->bookingStatus !== 'cancelled')
                                            <a href="{{ route('customer.payment.show', $booking->bookingID) }}" class="btn-primary" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; background-color: var(--brand-color); color: white; border: none; text-align: center;">
                                                <i class="fa-solid fa-credit-card"></i> Pay Deposit (RM 50.00)
                                            </a>
                                        @endif

                                        @if($booking->paymentStatus === 'Paid')
                                        <a href="{{ route('customer.booking.receipt.download', $booking->bookingID) }}" class="btn-invoice" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: #ecfdf5; border: 1px solid rgba(16,185,129,0.25); color: #065f46; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; text-align: center;">
                                            <i class="fa-solid fa-file-invoice"></i> Receipt
                                        </a>
                                        @endif

                                        @if($booking->bookingStatus === 'cancelled' && $booking->refund_status === 'refunded' && $booking->refund_receipt_path)
                                        <a href="javascript:void(0)" class="btn-invoice lightbox-trigger" data-file-url="{{ asset($booking->refund_receipt_path) }}" data-is-pdf="{{ Str::endsWith($booking->refund_receipt_path, '.pdf') ? 'true' : 'false' }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: #f0fdfa; border: 1px solid rgba(20,184,166,0.25); color: #0d9488; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s; text-align: center;">
                                            <i class="fa-solid fa-receipt"></i> Refund Receipt
                                        </a>
                                        @endif

                                        @if($booking->staffID && $booking->bookingStatus !== 'cancelled')
                                        <button class="btn-chat" onclick="openChatDrawer({{ $booking->bookingID }}, {{ json_encode($booking->staff?->staffName ?? 'Staff') }}, this)" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: var(--brand-light); border: 1px solid rgba(79,70,229,0.25); color: var(--brand-color); padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; transition: all 0.2s; border-style: solid; position: relative;">
                                            <i class="fa-solid fa-comments"></i> Chat
                                            @if($booking->chatMessages->where('sender_type', 'staff')->where('is_read', false)->count() > 0)
                                            <span class="booking-chat-dot"></span>
                                            @endif
                                        </button>
                                        @endif

                                        @if($booking->bookingStatus === 'completed' && $booking->jobRecord)
                                        <a href="{{ route('customer.booking.invoice.download', $booking->bookingID) }}" class="btn-invoice" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: #f0fdf4; border: 1px solid rgba(34,197,94,0.25); color: #15803d; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s;">
                                            <i class="fa-solid fa-file-invoice-dollar"></i> Invoice
                                        </a>
                                        @endif

                                        @if($booking->bookingStatus === 'completed' && !$booking->feedback)
                                        <a href="{{ route('customer.feedback', ['bookingID' => $booking->bookingID]) }}" class="btn-invoice" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: #eff6ff; border: 1px solid rgba(59,130,246,0.25); color: #1d4ed8; padding: 6px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s;">
                                            <i class="fa-solid fa-star"></i> Feedback
                                        </a>
                                        @endif

                                        @if(in_array($booking->bookingStatus, ['pending', 'confirmed', 'in_progress']))
                                        <a href="{{ route('customer.booking.cancel.confirm', $booking->bookingID) }}" class="btn-delete" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-trash-can"></i> Cancel
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Custom Pagination Links --}}
            @if ($bookings->hasPages())
                <div class="pagination-wrapper">
                    {{-- Previous Page Link --}}
                    @if ($bookings->onFirstPage())
                        <span class="page-link disabled">&laquo; Prev</span>
                    @else
                        <a href="{{ $bookings->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($bookings->getUrlRange(max(1, $bookings->currentPage() - 2), min($bookings->lastPage(), $bookings->currentPage() + 2)) as $page => $url)
                        @if ($page == $bookings->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($bookings->hasMorePages())
                        <a href="{{ $bookings->nextPageUrl() }}" class="page-link">Next &raquo;</a>
                    @else
                        <span class="page-link disabled">Next &raquo;</span>
                    @endif
                </div>
            @endif
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="modal-title">Cancel Booking?</div>
            <div class="modal-text">Are you sure you want to cancel this booking? This action cannot be undone.</div>
            <div class="modal-actions">
                <button class="btn-cancel-modal" onclick="closeDeleteModal()">Keep Booking</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-delete">Yes, Cancel It</button>
                </form>
            </div>
        </div>
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

            // Profile Dropdown Toggle Action
            const profileTriggerBtn = document.getElementById('profileTriggerBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileTriggerBtn && profileDropdownMenu) {
                profileTriggerBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('show');
                    const eMenu = document.getElementById('emailDropdownMenu');
                    const nMenu = document.getElementById('notificationDropdownMenu');
                    if (eMenu) eMenu.classList.remove('show');
                    if (nMenu) nMenu.classList.remove('show');
                });

                document.addEventListener('click', (e) => {
                    if (!profileTriggerBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.remove('show');
                    }
                });
            }

            // Close modal on overlay click
            const delModal = document.getElementById('deleteModal');
            if (delModal) {
                delModal.addEventListener('click', function(e) {
                    if (e.target === this) closeDeleteModal();
                });
            }

            // Lightbox Modal Logic
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxIframe = document.getElementById('lightboxIframe');
            const lightboxContent = document.getElementById('lightboxContent');
            const closeLightboxBtn = document.getElementById('closeLightboxBtn');

            function openLightbox(fileUrl, isPdf) {
                if (isPdf) {
                    lightboxImg.style.display = 'none';
                    lightboxIframe.style.display = 'block';
                    lightboxIframe.src = fileUrl;
                    lightboxContent.style.width = '85vw';
                    lightboxContent.style.height = '85vh';
                } else {
                    lightboxIframe.style.display = 'none';
                    lightboxImg.style.display = 'block';
                    lightboxImg.src = fileUrl;
                    lightboxContent.style.width = '';
                    lightboxContent.style.height = '';
                }
                lightboxModal.style.display = 'flex';
                // Trigger reflow for transition
                void lightboxModal.offsetWidth;
                lightboxModal.style.opacity = '1';
                lightboxContent.style.transform = 'scale(1)';
            }

            function closeLightbox() {
                lightboxModal.style.opacity = '0';
                lightboxContent.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    lightboxModal.style.display = 'none';
                    lightboxImg.src = '';
                    lightboxIframe.src = '';
                }, 250);
            }

            document.querySelectorAll('.lightbox-trigger').forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = trigger.getAttribute('data-file-url') || trigger.getAttribute('data-img-url') || trigger.getAttribute('href');
                    const isPdf = trigger.getAttribute('data-is-pdf') === 'true';
                    openLightbox(url, isPdf);
                });
            });

            if (lightboxModal) {
                lightboxModal.addEventListener('click', (e) => {
                    if (e.target === lightboxModal) {
                        closeLightbox();
                    }
                });
            }
            if (closeLightboxBtn) {
                closeLightboxBtn.addEventListener('click', closeLightbox);
            }

            // Global notification polling (Task 7)
            let lastNotificationCount = null;

            function checkLiveNotifications() {
                fetch('/notifications/unread')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.querySelector('.notification-dot') || document.querySelector('.action-btn .notification-dot');
                        const bellBtn = document.querySelector('#notificationTriggerBtn .action-btn');
                        
                        const count = data.unread_count;
                        if (lastNotificationCount !== null && count > lastNotificationCount) {
                            const newNotifs = data.notifications;
                            if (newNotifs.length > 0) {
                                showToastNotification("New Activity", newNotifs[0].message);
                            }
                        }
                        
                        lastNotificationCount = count;

                        if (count > 0) {
                            if (!badge && bellBtn) {
                                const dot = document.createElement('span');
                                dot.className = 'notification-dot';
                                bellBtn.appendChild(dot);
                            }
                        } else {
                            if (badge) badge.remove();
                        }

                        const listContainer = document.querySelector('#notificationDropdownMenu .notification-list');
                        if (listContainer) {
                            if (data.notifications.length > 0) {
                                let html = '';
                                data.notifications.forEach(n => {
                                    html += `<div class="notification-item">
                                        <div class="notification-message">${n.message}</div>
                                        <div class="notification-time">${n.time_formatted}</div>
                                    </div>`;
                                });
                                listContainer.innerHTML = html;
                            } else {
                                listContainer.innerHTML = '<div class="notification-item text-muted" style="border:none; padding-bottom:16px;">No recent activity.</div>';
                            }
                        }
                    })
                    .catch(err => console.error("Error fetching notifications", err));
            }

            function showToastNotification(title, text) {
                let container = document.querySelector('.toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.className = 'toast-container';
                    document.body.appendChild(container);
                }

                const toast = document.createElement('div');
                toast.className = 'toast-card';
                toast.innerHTML = `
                    <div class="toast-icon">🔔</div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-text">${text}</div>
                    </div>
                    <button class="toast-close">&times;</button>
                `;

                container.appendChild(toast);
                void toast.offsetWidth;
                toast.classList.add('show');

                const autoClose = setTimeout(() => {
                    closeToast(toast);
                }, 5000);

                toast.querySelector('.toast-close').addEventListener('click', () => {
                    clearTimeout(autoClose);
                    closeToast(toast);
                });
            }

            function closeToast(toast) {
                toast.classList.remove('show');
                toast.addEventListener('transitionend', () => {
                    toast.remove();
                });
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

            // Chat Drawer (Task 17) Javascript
            let currentChatBookingId = null;
            let chatPollInterval = null;
            const currentUserId = @json(auth('customer')->id());
            const currentUserType = 'customer';

            window.openChatDrawer = function(bookingId, name, btnEl) {
                currentChatBookingId = bookingId;
                if (btnEl) {
                    const dot = btnEl.querySelector('.booking-chat-dot');
                    if (dot) dot.style.display = 'none';
                }
                document.getElementById('chatDrawerSubtitle').textContent = `Booking #BKG-${bookingId}`;
                document.getElementById('chatDrawerTitle').textContent = `Chat with ${name}`;
                document.getElementById('chatDrawer').classList.add('open');
                
                fetchChatMessages();
                
                if (chatPollInterval) clearInterval(chatPollInterval);
                chatPollInterval = setInterval(fetchChatMessages, 3000);
            }

            window.closeChatDrawer = function() {
                currentChatBookingId = null;
                document.getElementById('chatDrawer').classList.remove('open');
                if (chatPollInterval) {
                    clearInterval(chatPollInterval);
                    chatPollInterval = null;
                }
            }

            window.fetchChatMessages = function() {
                if (!currentChatBookingId) return;
                
                const routePrefix = currentUserType === 'staff' ? '/staff' : '';
                fetch(`${routePrefix}/bookings/${currentChatBookingId}/chat/messages`)
                    .then(res => res.json())
                    .then(data => {
                        const container = document.getElementById('chatMessagesContainer');
                        const scrollAtBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 50;
                        
                        let html = '';
                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(msg => {
                                const isOutgoing = msg.sender_type === currentUserType && msg.sender_id === currentUserId;
                                const bubbleClass = isOutgoing ? 'outgoing' : 'incoming';
                                
                                html += `
                                    <div class="chat-message-bubble ${bubbleClass}">
                                        <div class="chat-message-sender" style="font-size: 10px; font-weight: bold; margin-bottom: 3px; ${isOutgoing ? 'color: rgba(255, 255, 255, 0.85)' : 'color: var(--text-muted)'}">${msg.sender_name}</div>
                                        <div>${msg.message}</div>
                                        <div class="chat-message-meta">${msg.time_formatted}</div>
                                    </div>
                                `;
                            });
                        } else {
                            html = '<div style="text-align: center; color: var(--text-muted); padding: 40px 0; font-size: 13px;">No messages yet. Send a message to start the conversation.</div>';
                        }
                        
                        container.innerHTML = html;
                        
                        if (scrollAtBottom || container.getAttribute('data-loaded') !== 'true') {
                            container.scrollTop = container.scrollHeight;
                            container.setAttribute('data-loaded', 'true');
                        }

                        // Update header chat dot status dynamically
                        fetch('/chat/unread-status')
                            .then(r => r.json())
                            .then(statusData => {
                                const headerDot = document.querySelector('#emailTriggerBtn .chat-dot');
                                if (headerDot) {
                                    headerDot.style.display = statusData.unread_count > 0 ? 'inline-block' : 'none';
                                }
                            })
                            .catch(e => {});
                    })
                    .catch(err => console.error("Error fetching chat messages", err));
            }

            window.sendChatMessage = function() {
                const input = document.getElementById('chatInput');
                const msg = input.value.trim();
                if (!msg || !currentChatBookingId) return;
                
                input.value = '';
                const routePrefix = currentUserType === 'staff' ? '/staff' : '';
                
                fetch(`${routePrefix}/bookings/${currentChatBookingId}/chat/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: msg })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fetchChatMessages();
                    } else {
                        alert("Error sending message");
                    }
                })
                .catch(err => {
                    console.error("Error sending chat message", err);
                    alert("Failed to send message");
                });
            }
        });

        function openDeleteModal(bookingId) {
            document.getElementById('deleteForm').action = '/bookings/' + bookingId;
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }
    </script>

    <!-- Lightbox Modal -->
    <div id="lightboxModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.25s ease;">
        <div style="position: relative; max-width: 90%; max-height: 90%; background: var(--surface-color); padding: 12px; border-radius: 16px; box-shadow: var(--shadow-lg); transform: scale(0.95); transition: transform 0.25s ease; display: flex; align-items: center; justify-content: center;" id="lightboxContent">
            <button id="closeLightboxBtn" style="position: absolute; top: -16px; right: -16px; width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-dark); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-md); font-size: 14px; transition: all 0.2s; z-index: 10001;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-dark)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img id="lightboxImg" src="" style="max-width: 100%; max-height: calc(85vh); border-radius: 10px; display: block; object-fit: contain;">
            <iframe id="lightboxIframe" src="" style="display: none; width: 80vw; height: 80vh; border: none; border-radius: 10px;"></iframe>
        </div>
    </div>

    <!-- Chat Drawer (Task 17) HTML -->
    <div id="chatDrawer" class="chat-drawer">
        <div class="chat-drawer-header">
            <div class="chat-drawer-title-group">
                <div class="chat-drawer-title" id="chatDrawerTitle">Booking Chat</div>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px;" id="chatDrawerSubtitle">Booking #</div>
            </div>
            <button onclick="closeChatDrawer()" class="chat-drawer-close">&times;</button>
        </div>
        <div class="chat-messages-container" id="chatMessagesContainer">
            <!-- Messages populated dynamically -->
        </div>
        <div class="chat-drawer-footer">
            <input type="text" id="chatInput" class="chat-input" placeholder="Type a message..." onkeydown="if(event.key === 'Enter') sendChatMessage()">
            <button onclick="sendChatMessage()" class="chat-send-btn">Send</button>
        </div>
    </div>
</body>
</html>
