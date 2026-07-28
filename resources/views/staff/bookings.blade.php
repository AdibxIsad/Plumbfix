<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs — Plumbfix Staff</title>
    <meta name="description" content="Manage your assigned bookings and update their status.">
    
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
            /* Futuristic Light Theme Palette */
            --bg-color: #f8fafc;
            --surface-color: rgba(255, 255, 255, 0.7);
            --surface-color-solid: #ffffff;
            --text-main: #475569;
            --text-muted: #94a3b8;
            --text-dark: #0f172a;
            --brand-color: #4f46e5;
            --brand-gradient: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
            --brand-light: #e0e7ff;
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
            --shadow-md: 0 10px 25px -5px rgba(79, 70, 229, 0.04), 0 8px 10px -6px rgba(79, 70, 229, 0.04);
            --shadow-lg: 0 20px 32px -4px rgba(79, 70, 229, 0.08), 0 12px 14px -6px rgba(79, 70, 229, 0.04);
            --shadow-glow: 0 0 20px rgba(79, 70, 229, 0.12);
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
            background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
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
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(99, 102, 241, 0) 70%);
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
            background: radial-gradient(circle, rgba(168, 85, 247, 0.15) 0%, rgba(168, 85, 247, 0) 70%);
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
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
            transition: all var(--transition-speed) ease;
        }

        .brand-link:hover .brand-logo-container {
            transform: scale(1.05);
            box-shadow: 0 8px 22px rgba(79, 70, 229, 0.35);
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

        .nav-item,
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

        .nav-item i,
        .nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .nav-item:hover,
        .nav-link:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        .nav-item:hover i,
        .nav-link:hover i {
            color: var(--brand-color);
            transform: scale(1.1);
        }

        .nav-item.active,
        .nav-link.active {
            background: var(--brand-light);
            color: var(--brand-color);
            font-weight: 700;
            border-color: rgba(79, 70, 229, 0.1);
        }

        .nav-item.active i,
        .nav-link.active i {
            color: var(--brand-color);
        }

        /* Sidebar Nav Dropdown Styling */
        .nav-dropdown {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 14px;
            color: var(--text-main);
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
            border: 1px solid transparent;
            background: none;
            width: 100%;
            cursor: pointer;
            font-family: inherit;
            text-align: left;
        }

        .nav-dropdown-toggle:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        .nav-dropdown-toggle:hover i {
            color: var(--brand-color);
        }

        .nav-dropdown-toggle.active {
            background: var(--brand-light);
            color: var(--brand-color);
            font-weight: 700;
            border-color: rgba(79, 70, 229, 0.1);
        }

        .nav-dropdown-toggle.active i {
            color: var(--brand-color);
        }

        .nav-dropdown-arrow {
            margin-left: auto;
            font-size: 11px !important;
            color: var(--text-muted);
            transition: transform 0.25s ease !important;
            width: auto !important;
        }

        .nav-dropdown.open .nav-dropdown-arrow {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding-left: 34px;
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .nav-dropdown.open .nav-dropdown-menu {
            display: flex;
        }

        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .nav-dropdown-item i {
            font-size: 14px;
            width: 18px;
            text-align: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .nav-dropdown-item:hover {
            background-color: var(--hover-color);
            color: var(--brand-color);
        }

        .nav-dropdown-item:hover i {
            color: var(--brand-color);
        }

        .nav-dropdown-item.active {
            background: var(--brand-light);
            color: var(--brand-color);
            font-weight: 700;
        }

        .nav-dropdown-item.active i {
            color: var(--brand-color);
        }

        body.collapsed-sidebar-active .nav-dropdown-arrow {
            display: none;
        }

        body.collapsed-sidebar-active .nav-dropdown-menu {
            padding-left: 0;
        }

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

        body.collapsed-sidebar-active .nav-item {
            justify-content: center;
            padding: 12px;
            border-radius: 12px;
        }

        body.collapsed-sidebar-active .nav-item i {
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
            border-color: rgba(79, 70, 229, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.08);
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
            border-color: rgba(79, 70, 229, 0.2);
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.08);
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

        /* ══════════════════ CONTENT AREA ══════════════════ */
        .content {
            padding: 32px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 24px;
        
            min-width: 0;
            max-width: 100%;}

        /* Filter bar */
        .filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border-radius: 24px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            color: var(--text-muted);
            text-decoration: none;
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
        }

        .filter-btn:hover {
            background-color: var(--hover-color);
            color: var(--brand-color);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .filter-btn.active {
            background-color: var(--brand-light);
            border-color: var(--brand-color);
            color: var(--brand-color);
            box-shadow: var(--shadow-glow);
        }

        /* Section Title */
        .section-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            margin-top: 16px;
            letter-spacing: -0.3px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border-color);
        }

        /* Table Design */
        .table-wrap {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            overflow-x: auto;
            margin-bottom: 16px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            padding: 12px;
            transition: box-shadow var(--transition-speed);
        
            max-width: 100%;}

        .table-wrap:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: transparent;
            padding: 14px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        tbody tr {
            transition: all var(--transition-speed) ease;
        }

        tbody tr:hover {
            background-color: var(--hover-color);
        }

        tbody tr:not(:last-child) td {
            border-bottom: 1px solid rgba(226, 232, 240, 0.4);
        }

        tbody td {
            padding: 16px;
            font-size: 13.5px;
            vertical-align: middle;
            color: var(--text-main);
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: var(--brand-light);
            border: 1px solid rgba(79, 70, 229, 0.15);
            color: var(--brand-color);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background-color: var(--accent-orange-bg);
            color: var(--accent-orange);
            border: 1px solid var(--accent-orange-border);
        }

        .status-confirmed {
            background-color: var(--accent-blue-bg);
            color: var(--accent-blue);
            border: 1px solid var(--accent-blue-border);
        }

        .status-in_progress {
            background-color: #f5f3ff;
            color: #7c3aed;
            border: 1px solid rgba(124, 58, 237, 0.25);
        }

        .status-completed {
            background-color: var(--accent-green-bg);
            color: var(--accent-green);
            border: 1px solid var(--accent-green-border);
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        /* Status Select Form */
        .status-select {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-main);
            padding: 8px 12px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            outline: none;
            transition: all var(--transition-speed);
        }

        .status-select:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-update {
            padding: 8px 16px;
            border-radius: 10px;
            background: var(--brand-gradient);
            color: #fff;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            white-space: nowrap;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
        }

        .btn-update:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
        }

        .btn-accept {
            padding: 8px 16px;
            border-radius: 10px;
            background-color: var(--accent-green-bg);
            border: 1px solid var(--accent-green-border);
            color: var(--accent-green);
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-speed);
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-accept:hover {
            background-color: rgba(16, 185, 129, 0.15);
            border-color: var(--accent-green);
        }

        .customer-cell {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .customer-cell .name {
            font-weight: 800;
            font-size: 14px;
            color: var(--text-dark);
        }

        .customer-cell .email {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 44px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        .alert-success {
            background-color: var(--accent-green-bg);
            border: 1px solid var(--accent-green-border);
            color: var(--accent-green);
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #ef4444;
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .unassigned-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease, border-color var(--transition-speed);
        }

        .unassigned-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .unassigned-info {
            flex: 1;
        }

        .unassigned-info .type {
            font-weight: 800;
            font-size: 16px;
            color: var(--text-dark);
            margin-bottom: 2px;
            letter-spacing: -0.3px;
        }

        .unassigned-info .meta {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
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
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            color: var(--text-main);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            transition: all var(--transition-speed) ease;
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
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
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
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 18px 24px;
            margin-bottom: 18px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            flex-wrap: wrap;
            margin-top: 8px;
            transition: box-shadow var(--transition-speed);
        }

        .filter-container:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        .filter-form {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            width: 100%;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-item label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.08px;
        }

        .filter-input {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-dark);
            outline: none;
            cursor: pointer;
            transition: all var(--transition-speed);
            min-width: 140px;
        }

        .filter-input:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-reset-filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 38px;
            padding: 0 16px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color-solid);
            color: var(--text-main);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 17px;
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
        }

        .btn-reset-filter:hover {
            background-color: #fee2e2;
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.2);
        }

        .search-container {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
        }
        .search-form {
            display: flex;
            gap: 16px;
            align-items: center;
        }
        .search-input {
            flex: 1;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--text-dark);
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .search-input:focus {
            border-color: var(--brand-color);
        }
        .filter-select {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--text-dark);
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
            cursor: pointer;
            font-family: inherit;
        }
        .filter-select:focus {
            border-color: var(--brand-color);
        }
        .btn-search {
            background-color: var(--brand-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-family: var(--font-outfit);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-search:hover {
            background-color: var(--brand-dark);
        }
        .btn-reset {
            background-color: transparent;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-reset:hover {
            background-color: var(--hover-color);
        }

        /* Modal styling matching theme */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.15);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 24px;
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

        .btn-cancel-modal {
            padding: 10px 20px;
            border-radius: 10px;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .btn-cancel-modal:hover {
            background-color: var(--hover-color);
            border-color: var(--brand-color);
        }

        /* Slide-out Chat Drawer & Toast Notification */
        .chat-drawer {
            position: fixed;
            top: 16px;
            right: -420px;
            bottom: 16px;
            width: 400px;
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            box-shadow: var(--glass-shadow), var(--shadow-lg);
            z-index: 10000;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            border: var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
        }
        
        .chat-drawer.open {
            right: 16px;
        }
        
        .chat-drawer-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--surface-color-solid);
        }
        
        .chat-drawer-title {
            font-weight: 800;
            color: var(--text-dark);
            font-size: 16px;
            letter-spacing: -0.2px;
        }
        
        .chat-drawer-close {
            border: none;
            background: none;
            font-size: 24px;
            color: var(--text-muted);
            cursor: pointer;
            transition: color var(--transition-speed);
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
            background-color: rgba(248, 250, 252, 0.5);
        }

        .chat-messages-container::-webkit-scrollbar {
            width: 4px;
        }
        .chat-messages-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        
        .chat-message-bubble {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.4;
            word-break: break-word;
            box-shadow: var(--shadow-sm);
        }
        
        .chat-message-bubble.incoming {
            background-color: var(--surface-color-solid);
            color: var(--text-dark);
            align-self: flex-start;
            border: 1px solid var(--border-color);
            border-top-left-radius: 4px;
        }
        
        .chat-message-bubble.outgoing {
            background: var(--brand-gradient);
            color: white;
            align-self: flex-end;
            border-top-right-radius: 4px;
        }
        
        .chat-message-meta {
            font-size: 10px;
            color: var(--text-muted);
            margin-top: 4px;
            text-align: right;
            font-weight: 500;
        }
        
        .chat-message-bubble.outgoing .chat-message-meta {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .chat-drawer-footer {
            padding: 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            background-color: var(--surface-color-solid);
        }
        
        .chat-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: inherit;
            font-size: 13.5px;
            outline: none;
            transition: all var(--transition-speed);
            background-color: var(--hover-color);
            color: var(--text-dark);
        }
        
        .chat-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color-solid);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .chat-send-btn {
            padding: 10px 16px;
            background: var(--brand-gradient);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-speed);
            font-family: inherit;
        }
        
        .chat-send-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
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
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            border-radius: 16px;
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
            font-weight: 800;
            font-size: 13.5px;
            color: var(--text-dark);
            margin-bottom: 2px;
        }
        
        .toast-text {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.4;
            font-weight: 500;
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

        /* ══════════════════ MOBILE OVERLAY ══════════════════ */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.15);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity var(--transition-speed);
        }

        body.mobile-sidebar-active .sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        /* Print styling rules */
        @media print {
            body {
                background: white;
                color: black;
            }
            .sidebar, .main-header, .filter-bar, .filter-container, .sidebar-overlay, .toast-container, .chat-drawer {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .content {
                padding: 0 !important;
                gap: 20px !important;
            
            min-width: 0;
            max-width: 100%;}
            .table-wrap {
                border: 1px solid #ccc !important;
                box-shadow: none !important;
                page-break-inside: avoid;
            
            max-width: 100%;}
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .sidebar {
                left: 20px;
                transform: translateX(-120%);
                z-index: 1005;
                bottom: 20px;
                top: 20px;
            }

            body.mobile-sidebar-active .sidebar {
                transform: translateX(0);
            }

            body.collapsed-sidebar-active .sidebar {
                transform: translateX(-120%);
            }

            .main-wrapper {
                margin-left: 20px;
                padding-right: 20px;
            }

            body.collapsed-sidebar-active .main-wrapper {
                margin-left: 20px;
            }

            .mobile-hamburger {
                display: flex;
            }
            
            .chat-drawer {
                width: calc(100% - 32px);
                max-width: 400px;
            }
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .sidebar {
                left: 20px;
                transform: translateX(-120%);
                z-index: 1005;
                bottom: 20px;
                top: 20px;
            }

            body.mobile-sidebar-active .sidebar {
                transform: translateX(0);
            }

            body.collapsed-sidebar-active .sidebar {
                transform: translateX(-120%);
            }

            .main-wrapper {
                margin-left: 20px;
                padding-right: 20px;
            }

            body.collapsed-sidebar-active .main-wrapper {
                margin-left: 20px;
            }

            .mobile-hamburger {
                display: flex;
            }
            
            .chat-drawer {
                width: calc(100% - 32px);
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                margin-left: 12px;
                padding-right: 12px;
                width: calc(100% - 24px);
                min-width: 0;
                max-width: 100%;
                overflow-x: hidden;
            }
            .filter-bar {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                gap: 8px;
                padding-bottom: 6px;
                margin-bottom: 12px;
                scrollbar-width: none;
            }
            .filter-bar::-webkit-scrollbar {
                display: none;
            }
            .filter-btn {
                flex-shrink: 0;
                white-space: nowrap;
                padding: 8px 14px;
                font-size: 12.5px;
            }
            .search-form {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                width: 100%;
            }
            .search-input {
                flex: 1 1 100%;
                width: 100%;
            }
            .filter-select {
                flex: 1 1 calc(33.333% - 6px);
                min-width: 70px;
            }
            .btn-search, .btn-reset {
                flex: 1 1 auto;
            }
            .main-header {
                padding: 0 16px;
                height: 68px;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-top: 12px;
            }
            .welcome-meta {
                min-width: 0;
                flex: 1;
                gap: 10px;
            }
            .welcome-text {
                min-width: 0;
                overflow: hidden;
            }
            .welcome-text h1 {
                font-size: 16px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .welcome-text p {
                font-size: 11px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .content {
                padding: 16px 0;
                min-width: 0;
                max-width: 100%;
            }
            .table-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                width: 100%;
            }
            table {
                min-width: 650px;
            }
            #emailDropdownMenu,
            .notification-dropdown-menu,
            .profile-dropdown-menu {
                position: fixed !important;
                top: 80px !important;
                left: 50% !important;
                right: auto !important;
                transform: translateX(-50%) !important;
                width: calc(100vw - 32px) !important;
                max-width: 360px !important;
                z-index: 99999 !important;
                box-shadow: 0 12px 36px rgba(15, 23, 42, 0.22) !important;
            }
        }

        @media (max-width: 576px) {
            .welcome-text p {
                display: none;
            }
            .header-actions {
                gap: 8px;
            }
            .action-btn {
                width: 36px;
                height: 36px;
                font-size: 14px;
                border-radius: 10px;
            }
            .profile-dropdown-trigger {
                padding: 3px;
                border-radius: 10px;
            }
            .profile-avatar {
                width: 28px;
                height: 28px;
            }
            .filter-select {
                flex: 1 1 calc(50% - 4px);
            }
        }
    </style>

</head>
<body>

    <!-- Animated Futuristic Mesh Background -->
    <div class="mesh-bg">
        <div class="mesh-orb orb-1"></div>
        <div class="mesh-orb orb-2"></div>
        <div class="mesh-orb orb-3"></div>
    </div>

    <!-- Mobile Sidebar Overlay Backdrop -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ══════════ LEFT SIDEBAR ══════════ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('staff.dashboard') }}" class="brand-link">
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
            
            <!-- 1. Overview -->
            <a href="{{ route('staff.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-table-columns"></i>
                <span class="nav-link-text">Overview</span>
            </a>
            
            <!-- 2. Trend Analysis -->
            <a href="{{ route('staff.analytics') }}" class="nav-item nav-link {{ request()->routeIs('staff.analytics') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i>
                <span class="nav-link-text">Trend Analysis</span>
            </a>

            <!-- 3. Services Dropdown (Bookings & Report) -->
            <div class="nav-dropdown {{ request()->routeIs('staff.bookings', 'staff.job-records*') ? 'open' : '' }}">
                <button type="button" class="nav-dropdown-toggle {{ request()->routeIs('staff.bookings', 'staff.job-records*') ? 'active' : '' }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span class="nav-link-text">Services</span>
                    <i class="fa-solid fa-chevron-down nav-dropdown-arrow"></i>
                </button>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('staff.bookings') }}" class="nav-dropdown-item {{ request()->routeIs('staff.bookings') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check"></i>
                        <span class="nav-link-text">Bookings</span>
                    </a>
                    <a href="{{ route('staff.job-records') }}" class="nav-dropdown-item {{ request()->routeIs('staff.job-records*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="nav-link-text">Report</span>
                    </a>
                </div>
            </div>

            <!-- 4. Payment Dropdown (Verify Payments & Manage Refunds) -->
            <div class="nav-dropdown {{ request()->routeIs('staff.payments*', 'staff.refunds*') ? 'open' : '' }}">
                <button type="button" class="nav-dropdown-toggle {{ request()->routeIs('staff.payments*', 'staff.refunds*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wallet"></i>
                    <span class="nav-link-text">Payment</span>
                    <i class="fa-solid fa-chevron-down nav-dropdown-arrow"></i>
                </button>
                <div class="nav-dropdown-menu">
                    <a href="{{ route('staff.payments.index') }}" class="nav-dropdown-item {{ request()->routeIs('staff.payments*') ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="nav-link-text">Verify Payments</span>
                    </a>
                    <a href="{{ route('staff.refunds.index') }}" class="nav-dropdown-item {{ request()->routeIs('staff.refunds*') ? 'active' : '' }}">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <span class="nav-link-text">Manage Refunds</span>
                    </a>
                </div>
            </div>

            @if(auth('staff')->user()?->isAdmin())
            <!-- 5. Plumber -->
            <a href="{{ route('staff.plumbers') }}" class="nav-item nav-link {{ request()->routeIs('staff.plumbers*') ? 'active' : '' }}">
                <i class="fa-solid fa-helmet-safety"></i>
                <span class="nav-link-text">Plumber</span>
            </a>
            @endif

            <!-- 6. Feedback -->
            <a href="{{ route('staff.feedback') }}" class="nav-item nav-link {{ request()->routeIs('staff.feedback*') ? 'active' : '' }}">
                <i class="fa-solid fa-comment-dots"></i>
                <span class="nav-link-text">Feedback</span>
            </a>        </nav>
    </aside>

    <!-- ══════════ MAIN WRAPPER ══════════ -->
    <div class="main-wrapper">
        
        <!-- Header -->
        <header class="main-header">
            <div class="welcome-meta">
                <button class="mobile-hamburger" id="mobileHamburger" aria-label="Toggle Sidebar Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="welcome-text">
                    <h1>My Jobs (Services)</h1>
                    <p>Manage your assigned bookings and update their status</p>
                </div>
            </div>

            @php
                $userForNotifications = auth('customer')->user() ?? auth('staff')->user();
                $unreadCount = $userForNotifications ? $userForNotifications->unreadNotifications->count() : 0;
                $userEmail = $userForNotifications->staffEmail ?? $userForNotifications->customerEmail ?? 'staff@plumbfix.com';

                $hasChatMessages = false;
                if (auth('staff')->check()) {
                    $stfUser = auth('staff')->user();
                    if ($stfUser->isAdmin()) {
                        $hasChatMessages = \App\Models\ChatMessage::where('sender_type', 'customer')->exists();
                    } else {
                        $hasChatMessages = \App\Models\ChatMessage::whereHas('booking', function($q) use ($stfUser) {
                            $q->where('staffID', $stfUser->staffID);
                        })->where('sender_type', 'customer')->exists();
                    }
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
                                Plumbfix Staff Email Inbox
                            </div>
                            <span style="font-size: 10px; font-weight:700; color:var(--text-muted); background:var(--hover-color); padding:2px 8px; border-radius:10px;">Gmail</span>
                        </div>
                        <div class="notification-list">
                            <a href="{{ $gmailUrl }}" target="_blank" class="notification-item" style="display:block; text-decoration:none;">
                                <div class="notification-message" style="font-weight:700; color:var(--text-dark);">
                                    📋 New Service Order Request
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                                    Customer booking notification & dispatch details sent to <strong>{{ $userEmail }}</strong>
                                </div>
                                <div class="notification-time">Today · Click to open in Gmail ↗</div>
                            </a>
                            <a href="{{ $gmailUrl }}" target="_blank" class="notification-item" style="display:block; text-decoration:none;">
                                <div class="notification-message" style="font-weight:700; color:var(--text-dark);">
                                    💳 Payment Verification Alert
                                </div>
                                <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">
                                    Receipt document uploaded for review at <strong>{{ $userEmail }}</strong>
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
                            <path d="M20 100c10-25 22-30 40-30s30 5 40 30v20H20v-20z" fill="#6366f1" />
                            <path d="M50 70l10 15 10-15z" fill="#2563eb" />
                        </svg>
                    </div>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <!-- Dropdown Menu Options -->
                <div class="profile-dropdown-menu" id="profileDropdownMenu">
                    <div class="dropdown-header">
                        <div class="dropdown-header-name">{{ $staff->staffName ?? 'Staff Member' }}</div>
                        <div class="dropdown-header-role">Plumbing Technician</div>
                    </div>
                    <a href="{{ route('staff.profile') }}" class="dropdown-item">
                        <i class="fa-solid fa-user-gear"></i> Edit Profile
                    </a>
                    <a href="{{ route('staff.bookings') }}" class="dropdown-item">
                        <i class="fa-solid fa-clipboard-list"></i> My Orders
                    </a>
                    <form action="{{ route('staff.logout') }}" method="POST" id="logoutForm">
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
            @if(session('success'))<div class="alert-success">✅ {{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert-error">⚠️ {{ $errors->first() }}</div>@endif

            <!-- Filter -->
            <div class="filter-bar">
                <a href="{{ route('staff.bookings') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('staff.bookings', ['status'=>'pending']) }}" class="filter-btn {{ request('status')=='pending' ? 'active' : '' }}">⏳ Pending</a>
                <a href="{{ route('staff.bookings', ['status'=>'confirmed']) }}" class="filter-btn {{ request('status')=='confirmed' ? 'active' : '' }}">✔ Confirmed</a>
                <a href="{{ route('staff.bookings', ['status'=>'in_progress']) }}" class="filter-btn {{ request('status')=='in_progress' ? 'active' : '' }}">🔨 In Progress</a>
                <a href="{{ route('staff.bookings', ['status'=>'completed']) }}" class="filter-btn {{ request('status')=='completed' ? 'active' : '' }}">✅ Completed</a>
            </div>

            <!-- Search and Filter Panel -->
            <div class="search-container">
                <form action="{{ route('staff.bookings') }}" method="GET" class="search-form" id="searchForm">
                    <input type="text" name="search" class="search-input" placeholder="Search by Booking ID or Customer Name..." value="{{ request('search') }}">
                    
                    <!-- Year, Month, Day Filter Selects -->
                    <select name="year" class="filter-select">
                        <option value="">Year</option>
                        @for($y = date('Y') + 1; $y >= 2024; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>

                    <select name="month" class="filter-select">
                        <option value="">Month</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endfor
                    </select>

                    <select name="day" class="filter-select">
                        <option value="">Day</option>
                        @for($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>{{ sprintf('%02d', $d) }}</option>
                        @endfor
                    </select>

                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <button type="submit" class="btn-search">Search</button>
                    @if (request()->filled('search') || request()->filled('status') || request()->filled('year') || request()->filled('month') || request()->filled('day'))
                        <a href="{{ route('staff.bookings', request('status') ? ['status' => request('status')] : []) }}" class="btn-reset">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Unassigned / Pending jobs to confirm -->
            @if($unassigned->isNotEmpty())
            <div class="section-title">🆕 New Bookings Awaiting Approval / Assignment</div>
            @foreach($unassigned as $u)
            <div class="unassigned-card">
                <div style="font-size:32px;">📩</div>
                <div class="unassigned-info">
                    <div class="type">{{ $u->bookingType }} — {{ $u->bookingProblem }}</div>
                    <div class="meta">
                        📅 {{ \Carbon\Carbon::parse($u->bookingDate)->format('D, d M Y') }}
                        &nbsp;·&nbsp; 🕐 {{ \Carbon\Carbon::parse($u->bookingTime)->format('h:i A') }}
                        @if($u->bookingIssueDescription)
                            &nbsp;·&nbsp; {{ Str::limit($u->bookingIssueDescription, 60) }}
                        @endif
                        &nbsp;·&nbsp;
                        <a href="javascript:void(0)" class="details-trigger" 
                           data-customer-name="{{ $u->customer?->customerName ?? '—' }}" 
                           data-customer-email="{{ $u->customer?->customerEmail ?? '' }}" 
                           data-customer-phone="{{ $u->customer?->customerPhoneNo ?? '—' }}" 
                           data-customer-address="{{ $u->customer?->customerAddress ?? '—' }}" 
                           data-service="{{ $u->bookingType }}" 
                           data-problem="{{ $u->bookingProblem }}" 
                           data-desc="{{ $u->bookingIssueDescription ?? 'No additional description provided.' }}" 
                           data-date="{{ \Carbon\Carbon::parse($u->bookingDate)->format('d M Y') }}" 
                           data-time="{{ \Carbon\Carbon::parse($u->bookingTime)->format('h:i A') }}" 
                           data-status="{{ ucwords(str_replace('_',' ',$u->bookingStatus)) }}"
                           style="color:var(--brand-color); text-decoration:none; font-weight:700;">
                            View Full Details
                        </a>
                        @if($u->bookingAttachment)
                            &nbsp;·&nbsp; 
                            <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($u->bookingAttachment) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; font-weight:700;">
                                <i class="fa-regular fa-image"></i> View Photo
                            </a>
                        @endif
                        @if($u->bookingDepositReceipt)
                            &nbsp;·&nbsp; 
                            @if(Str::endsWith($u->bookingDepositReceipt, '.pdf'))
                                <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($u->bookingDepositReceipt) }}" data-is-pdf="true" style="color:var(--brand-color); text-decoration:none; font-weight:700;">
                                    <i class="fa-solid fa-file-pdf"></i> View Deposit PDF
                                </a>
                            @else
                                <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($u->bookingDepositReceipt) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; font-weight:700;">
                                    <i class="fa-solid fa-receipt"></i> View Deposit Receipt
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
                <form action="{{ route('staff.booking.accept', $u->bookingID) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-accept">✅ Approve & Confirm</button>
                </form>
            </div>
            @endforeach
            @endif

            <!-- My Assigned Jobs -->
            <div class="section-title">📋 All Bookings</div>
            <div class="table-wrap">
                @if($bookings->isEmpty())
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p>No bookings assigned to you yet.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Plumber</th>
                                <th>Service</th>
                                <th>Problem</th>
                                <th>Photo</th>
                                <th>Deposit Receipt</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $b)
                            <tr>
                                <td style="color:var(--text-muted);font-size:12px;">#{{ $b->bookingID }}</td>
                                <td>
                                    <div class="customer-cell">
                                        <span class="name">{{ $b->customer?->customerName ?? '—' }}</span>
                                        <span class="email">{{ $b->customer?->customerEmail ?? '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($b->staff)
                                        <div class="customer-cell">
                                            <span class="name">{{ $b->staff->staffName }}</span>
                                            <span class="email">ID: #{{ $b->staffID }}</span>
                                        </div>
                                    @else
                                        <span class="status-badge" style="background-color:#f1f5f9; color:#64748b; border: 1px solid rgba(100,116,139,0.15); text-transform:none; font-weight:600; letter-spacing:normal;">Unassigned</span>
                                    @endif
                                </td>
                                <td><span class="type-badge">{{ $b->service_icon }} {{ $b->bookingType }}</span></td>
                                <td>
                                    <div style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;color:var(--text-dark);">
                                        {{ $b->bookingProblem }}
                                    </div>
                                    <a href="javascript:void(0)" class="details-trigger" 
                                       data-customer-name="{{ $b->customer?->customerName ?? '—' }}" 
                                       data-customer-email="{{ $b->customer?->customerEmail ?? '' }}" 
                                       data-customer-phone="{{ $b->customer?->customerPhoneNo ?? '—' }}" 
                                       data-customer-address="{{ $b->customer?->customerAddress ?? '—' }}" 
                                       data-service="{{ $b->bookingType }}" 
                                       data-problem="{{ $b->bookingProblem }}" 
                                       data-desc="{{ $b->bookingIssueDescription ?? 'No additional description provided.' }}" 
                                       data-date="{{ \Carbon\Carbon::parse($b->bookingDate)->format('d M Y') }}" 
                                       data-time="{{ \Carbon\Carbon::parse($b->bookingTime)->format('h:i A') }}" 
                                       data-status="{{ ucwords(str_replace('_',' ',$b->bookingStatus)) }}"
                                       style="color:var(--brand-color); text-decoration:none; font-size:12px; font-weight:600; display:inline-block; margin-top:2px;">
                                        🔍 View Details
                                    </a>
                                </td>
                                <td>
                                    @if($b->bookingAttachment)
                                        <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($b->bookingAttachment) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:12.5px;">
                                            <i class="fa-regular fa-image" style="font-size:15px;"></i> View Photo
                                        </a>
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($b->bookingDepositReceipt)
                                        @if(Str::endsWith($b->bookingDepositReceipt, '.pdf'))
                                            <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($b->bookingDepositReceipt) }}" data-is-pdf="true" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:12.5px;">
                                                <i class="fa-solid fa-file-pdf" style="font-size:15px;"></i> View PDF
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="lightbox-trigger" data-file-url="{{ asset($b->bookingDepositReceipt) }}" data-is-pdf="false" style="color:var(--brand-color); text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-weight:600; font-size:12.5px;">
                                                <i class="fa-solid fa-receipt" style="font-size:15px;"></i> View Receipt
                                            </a>
                                        @endif
                                    @else
                                        <span style="color:var(--text-muted);">—</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-muted);white-space:nowrap;">{{ \Carbon\Carbon::parse($b->bookingDate)->format('d M Y') }}</td>
                                <td style="color:var(--text-muted);white-space:nowrap;">{{ \Carbon\Carbon::parse($b->bookingTime)->format('h:i A') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $b->bookingStatus }}">
                                        {{ ucwords(str_replace('_',' ',$b->bookingStatus)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                        @if($b->bookingStatus !== 'cancelled' && $b->bookingStatus !== 'completed')
                                         @php
                                             $bDateStr = $b->bookingDate instanceof \Carbon\Carbon 
                                                 ? $b->bookingDate->format('Y-m-d') 
                                                 : \Carbon\Carbon::parse($b->bookingDate)->format('Y-m-d');
                                             $bDateTime = \Carbon\Carbon::parse($bDateStr . ' ' . $b->bookingTime);
                                             $bHasPassed = now()->gt($bDateTime);
                                         @endphp
                                        <form action="{{ route('staff.booking.status', $b->bookingID) }}" method="POST" style="display:inline-flex;gap:6px;align-items:center;margin:0;">
                                            @csrf
                                            <select name="bookingStatus" class="status-select">
                                                <option value="confirmed"   {{ $b->bookingStatus=='confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="in_progress" {{ $b->bookingStatus=='in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed"   {{ $b->bookingStatus=='completed' ? 'selected' : '' }} {{ !$bHasPassed ? 'disabled title="Cannot complete booking before its scheduled date and time has passed"' : '' }}>Completed {{ !$bHasPassed ? '(Locked)' : '' }}</option>
                                                <option value="cancelled"   {{ $b->bookingStatus=='cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn-update">Save</button>
                                        </form>
                                        @elseif($b->bookingStatus === 'completed')
                                            @if($b->jobRecord)
                                                <a href="{{ route('staff.job-record.create', $b->bookingID) }}" class="btn-accept" style="text-decoration:none; background-color:#eff6ff; color:#2563eb; border-color:rgba(37,99,235,0.25); margin:0;">📝 Edit Record</a>
                                            @else
                                                <a href="{{ route('staff.job-record.create', $b->bookingID) }}" class="btn-accept" style="text-decoration:none; margin:0;">📝 Add Record</a>
                                            @endif
                                        @else
                                            <span style="color:var(--text-muted);font-size:13px;">—</span>
                                        @endif

                                        @if($b->bookingStatus !== 'cancelled')
                                        <button type="button" class="btn-chat" onclick="openChatDrawer({{ $b->bookingID }}, '{{ $b->customer->customerName ?? 'Customer' }}', this)" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background-color: var(--brand-light); border: 1px solid rgba(37,99,235,0.25); color: var(--brand-color); padding: 8px 12px; border-radius: 8px; font-family: 'Outfit', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; transition: all 0.2s; border-style: solid; height: 35px; position: relative;">
                                            <i class="fa-solid fa-comments"></i> Chat
                                            @if($b->chatMessages->where('sender_type', 'customer')->where('is_read', false)->count() > 0)
                                            <span class="booking-chat-dot"></span>
                                            @endif
                                        </button>
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

    <!-- Javascript Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Nav Dropdown Toggles
            document.querySelectorAll('.nav-dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const parent = toggle.closest('.nav-dropdown');
                    if (parent) {
                        parent.classList.toggle('open');
                    }
                });
            });

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

            // Details Modal Logic
            const detailsModal = document.getElementById('detailsModal');
            
            function openDetailsModal(trigger) {
                document.getElementById('modalCustomerName').textContent = trigger.getAttribute('data-customer-name');
                document.getElementById('modalCustomerPhone').textContent = trigger.getAttribute('data-customer-phone');
                document.getElementById('modalCustomerAddress').textContent = trigger.getAttribute('data-customer-address');
                document.getElementById('modalServiceType').textContent = trigger.getAttribute('data-service');
                document.getElementById('modalStatus').textContent = trigger.getAttribute('data-status');
                document.getElementById('modalDateTime').textContent = trigger.getAttribute('data-date') + ' · ' + trigger.getAttribute('data-time');
                document.getElementById('modalProblem').textContent = trigger.getAttribute('data-problem');
                document.getElementById('modalDescription').textContent = trigger.getAttribute('data-desc');
                
                detailsModal.classList.add('show');
            }
            
            window.closeDetailsModal = function() {
                detailsModal.classList.remove('show');
            }
            
            document.querySelectorAll('.details-trigger').forEach(trigger => {
                trigger.addEventListener('click', () => {
                    openDetailsModal(trigger);
                });
            });

            if (detailsModal) {
                detailsModal.addEventListener('click', (e) => {
                    if (e.target === detailsModal) {
                        closeDetailsModal();
                    }
                });
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
            const currentUserId = @json(auth('staff')->id());
            const currentUserType = 'staff';

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
                        fetch(`${routePrefix}/chat/unread-status`)
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

    <!-- Service Details Modal -->
    <div class="modal-overlay" id="detailsModal">
        <div class="modal" style="max-width: 600px; text-align: left; padding: 24px; border-radius: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; margin-bottom: 20px;">
                <h3 class="modal-title" style="margin: 0; font-size: 18px; font-weight: 700;">Service Details</h3>
                <button onclick="closeDetailsModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Customer Name</div>
                    <div id="modalCustomerName" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Contact Number</div>
                    <div id="modalCustomerPhone" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Service Address</div>
                    <div id="modalCustomerAddress" style="font-size: 14px; font-weight: 600; color: var(--text-dark); line-height: 1.4;"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Service Type</div>
                    <div id="modalServiceType" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Status</div>
                    <div id="modalStatus" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Booked Date & Time</div>
                    <div id="modalDateTime" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div>
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Problem</div>
                    <div id="modalProblem" style="font-size: 14px; font-weight: 600; color: var(--text-dark);"></div>
                </div>
                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 4px;">Problem Description</div>
                    <div id="modalDescription" style="font-size: 14px; color: var(--text-main); line-height: 1.5; white-space: pre-wrap; background-color: var(--hover-color); padding: 12px; border-radius: 8px; border: 1px solid var(--border-color);"></div>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 16px;">
                <button class="btn-cancel-modal" onclick="closeDetailsModal()">Close</button>
            </div>
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
