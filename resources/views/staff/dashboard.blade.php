<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard — Plumbfix</title>
    <meta name="description" content="Manage your clients, orders, services, and products in one place.">
    
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
            --brand-light: #e0e7ff;
            --border-color: rgba(226, 232, 240, 0.8);
            --hover-color: rgba(241, 245, 249, 0.8);
            --accent-green: #10b981;
            --accent-green-bg: rgba(16, 185, 129, 0.1);
            --accent-orange: #f59e0b;
            --accent-orange-bg: rgba(245, 158, 11, 0.1);
            --accent-blue: #0ea5e9;
            --accent-blue-bg: rgba(14, 165, 233, 0.1);
            --sidebar-width: 270px;
            --sidebar-collapsed-width: 88px;
            
            --glass-blur: 16px;
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
            
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px -5px rgba(79, 70, 229, 0.04), 0 8px 10px -6px rgba(79, 70, 229, 0.04);
            --shadow-lg: 0 20px 32px -4px rgba(79, 70, 229, 0.08), 0 12px 14px -6px rgba(79, 70, 229, 0.04);
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            /* Blueprint illustration pattern background */
            background-image: 
                radial-gradient(rgba(79, 70, 229, 0.04) 1.5px, transparent 1.5px),
                linear-gradient(rgba(79, 70, 229, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(79, 70, 229, 0.015) 1px, transparent 1px);
            background-size: 24px 24px, 120px 120px, 120px 120px;
            background-position: 0 0, 0 0, 0 0;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            position: relative;
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
            border-color: rgba(79, 70, 229, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.08);
        }

        .notification-dot,
        .chat-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 9px;
            height: 9px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid var(--surface-color-solid);
            box-sizing: content-box;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: bippingPulse 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        .notification-dot::after,
        .chat-dot::after {
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

        /* ══════════════════ DASHBOARD CONTENT ══════════════════ */
        .content-container {
            padding: 32px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* Metrics Row */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .metric-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 16px;
            position: relative;
            overflow: hidden;
            color: var(--card-accent-color, var(--brand-color));
            transition: all var(--transition-speed) cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--card-accent-color, var(--brand-color)), transparent);
            opacity: 0;
            transition: opacity var(--transition-speed);
        }

        .metric-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-lg);
            border-color: var(--card-accent-color, rgba(79, 70, 229, 0.2));
        }

        .metric-card:hover::before {
            opacity: 1;
        }

        .metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .metric-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--card-accent-light, var(--brand-light));
            color: var(--card-accent-color, var(--brand-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 10px var(--card-shadow-color, rgba(79, 70, 229, 0.1));
            transition: all var(--transition-speed);
        }

        .metric-card:hover .metric-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--card-accent-color, var(--brand-color));
            color: white;
            box-shadow: 0 6px 16px var(--card-hover-shadow-color, rgba(79, 70, 229, 0.25));
        }

        /* --- Card Color Themes --- */
        /* Theme Indigo (Card 1) */
        .card-theme-indigo {
            --card-accent-color: #6366f1;
            --card-accent-light: #e0e7ff;
            --card-shadow-color: rgba(99, 102, 241, 0.1);
            --card-hover-shadow-color: rgba(99, 102, 241, 0.25);
        }
        
        /* Theme Orange (Card 2) */
        .card-theme-orange {
            --card-accent-color: #f97316;
            --card-accent-light: #ffedd5;
            --card-shadow-color: rgba(249, 115, 22, 0.1);
            --card-hover-shadow-color: rgba(249, 115, 22, 0.25);
        }
        
        /* Theme Green (Card 3) */
        .card-theme-green {
            --card-accent-color: #10b981;
            --card-accent-light: #d1fae5;
            --card-shadow-color: rgba(16, 185, 129, 0.1);
            --card-hover-shadow-color: rgba(16, 185, 129, 0.25);
        }
        
        /* Theme Rose (Card 4) */
        .card-theme-rose {
            --card-accent-color: #f43f5e;
            --card-accent-light: #ffe4e6;
            --card-shadow-color: rgba(244, 63, 94, 0.1);
            --card-hover-shadow-color: rgba(244, 63, 94, 0.25);
        }

        .metric-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
        }

        .metric-trend {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .metric-trend.up i {
            color: var(--accent-green);
        }

        .metric-trend.down i {
            color: #ef4444;
        }

        .metric-body {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .metric-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
            letter-spacing: -1px;
        }

        .metric-desc {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* 2-Column Middle Row Grid (Chart + Recent Activities) */
        .dashboard-row-middle {
            display: grid;
            grid-template-columns: 1.62fr 1.08fr;
            gap: 20px;
        }

        .dashboard-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            transition: box-shadow var(--transition-speed);
        }

        .dashboard-card:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-icon {
            font-size: 18px;
            color: var(--brand-color);
        }

        .card-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .card-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Button Links like "See All" */
        .see-all-btn {
            font-size: 12px;
            font-weight: 700;
            color: var(--brand-color);
            text-decoration: none;
            background: var(--brand-light);
            padding: 6px 14px;
            border-radius: 8px;
            transition: all var(--transition-speed);
            border: 1px solid rgba(79, 70, 229, 0.1);
        }

        .see-all-btn:hover {
            background: var(--brand-color);
            color: white;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
            transform: translateY(-1px);
        }

        /* Revenue Growth Trend Chart Layout */
        .chart-legend {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
            color: var(--text-muted);
            margin-right: 8px;
            font-weight: 600;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .legend-dot.product { background-color: #cbd5e1; }
        .legend-dot.service { background-color: #94a3b8; }

        .dropdown-filter {
            padding: 6px 12px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--surface-color-solid);
            font-size: 12px;
            font-weight: 700;
            color: var(--text-main);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: border 0.2s;
        }

        .dropdown-filter:hover {
            border-color: var(--text-muted);
        }

        /* Custom SVG/CSS Clustered Bar Chart */
        .chart-container {
            height: 250px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-left: 35px;
            margin-top: 10px;
        }

        .chart-grid-lines {
            position: absolute;
            inset: 0 0 30px 35px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none;
            z-index: 1;
        }

        .grid-line-row {
            display: flex;
            align-items: center;
            width: 100%;
            height: 0;
        }

        .grid-line-label {
            position: absolute;
            left: -35px;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            width: 28px;
            text-align: right;
        }

        .grid-line-dash {
            width: 100%;
            border-top: 1px dashed var(--border-color);
        }

        .chart-bars-area {
            position: relative;
            height: calc(100% - 30px);
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            z-index: 2;
        }

        .chart-month-col {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            position: relative;
        }

        .month-bars {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 100%;
        }

        .bar {
            width: 10px;
            border-radius: 4px 4px 0 0;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .bar.product {
            background-color: #cbd5e1;
        }

        .bar.service {
            background-color: #cbd5e1;
        }

        .bar.sales-bar {
            width: 16px;
            background: linear-gradient(180deg, rgba(79, 70, 229, 0.2) 0%, rgba(79, 70, 229, 0.05) 100%);
            border: 1px solid rgba(79, 70, 229, 0.15);
            border-radius: 6px 6px 0 0;
        }

        /* Highlight Active Service/Sales Bar */
        .chart-month-col.active .bar.sales-bar,
        .chart-month-col:hover .bar.sales-bar {
            background: linear-gradient(180deg, var(--brand-color) 0%, #a855f7 100%);
            border-color: transparent;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
            transform: scaleY(1.03);
        }

        .month-label {
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .chart-month-col.active .month-label {
            color: var(--brand-color);
            font-weight: 800;
        }

        /* Tooltip positioned above August bar */
        .chart-tooltip-aug {
            position: absolute;
            background: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 14px;
            box-shadow: var(--shadow-lg);
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 115px;
            pointer-events: none;
            transition: all 0.15s ease-out;
        }

        .chart-tooltip-aug::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: var(--surface-color-solid) transparent transparent transparent;
        }

        .tooltip-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .tooltip-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .tooltip-dot.product {
            background-color: #cbd5e1;
        }

        .tooltip-dot.service {
            background-color: var(--accent-green);
        }

        .tooltip-growth {
            background-color: var(--accent-green-bg);
            color: var(--accent-green);
            font-size: 10px;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 6px;
            align-self: flex-start;
        }

        /* Recent Activities Tabs & List */
        .tab-bar {
            display: flex;
            align-items: center;
            gap: 4px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }

        .tab-btn {
            padding: 6px 14px;
            border-radius: 20px;
            border: none;
            background: none;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .tab-btn:hover {
            color: var(--text-dark);
            background-color: var(--hover-color);
        }

        .tab-btn.active {
            background: var(--brand-light);
            color: var(--brand-color);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 14px;
            text-decoration: none;
            color: inherit;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: var(--surface-color-solid);
            border-color: var(--border-color);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .activity-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .activity-avatar svg {
            width: 100%;
            height: 100%;
        }

        .activity-meta-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .activity-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .activity-sub {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 170px;
            font-weight: 500;
        }

        .activity-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .activity-status-group {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
        }

        .activity-status {
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .activity-status.status-in_progress {
            color: var(--accent-orange);
        }
        .activity-status.status-in_progress i {
            animation: pulse-glow-orange 1.5s infinite;
        }

        @keyframes pulse-glow-orange {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        .activity-status.status-completed {
            color: var(--accent-green);
        }

        .activity-status.status-cancelled {
            color: #ef4444;
        }

        .activity-status.status-pending {
            color: var(--accent-blue);
        }

        .activity-status.status-payment {
            color: #d97706;
        }
        .activity-status.status-payment i {
            color: #d97706;
            animation: pulse-glow-orange 1.5s infinite;
        }

        .activity-status.status-refund {
            color: #ef4444;
        }
        .activity-status.status-refund i {
            color: #ef4444;
            animation: pulse-glow-red 1.5s infinite;
        }

        @keyframes pulse-glow-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        .activity-status i {
            font-size: 7px;
            width: 7px;
            height: 7px;
            background-color: currentColor;
            border-radius: 50%;
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .activity-arrow {
            font-size: 12px;
            color: var(--text-muted);
            transition: transform 0.2s;
        }

        .activity-item:hover .activity-arrow {
            transform: translateX(2px);
            color: var(--brand-color);
        }

        /* ══════════════════ BOTTOM ROW ══════════════════ */
        .dashboard-row-bottom {
            display: grid;
            grid-template-columns: 1.08fr 1.62fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        /* Plumbers List Layout */
        .plumber-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .plumber-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: inherit;
            padding: 10px 14px;
            border-radius: 16px;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.25s ease;
        }

        .plumber-item:hover {
            border-color: var(--border-color);
            background-color: var(--surface-color-solid);
            transform: translateX(4px);
            box-shadow: var(--shadow-sm);
        }

        .plumber-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .plumber-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .plumber-avatar svg {
            width: 100%;
            height: 100%;
        }

        .plumber-meta {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .plumber-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .plumber-specialty {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .plumber-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .plumber-stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
        }

        .plumber-jobs {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .plumber-rating {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .plumber-rating i {
            color: #f59e0b;
        }

        .plumber-arrow {
            font-size: 12px;
            color: var(--text-main);
        }

        /* Ongoing Jobs Table Layout */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .table-container::-webkit-scrollbar {
            height: 6px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .jobs-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .jobs-table th {
            padding: 12px 14px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .jobs-table td {
            padding: 14px 14px;
            font-size: 13.5px;
            color: var(--text-main);
            vertical-align: middle;
            border-bottom: 1px solid rgba(226, 232, 240, 0.4);
        }

        .jobs-table tbody tr {
            transition: all 0.2s ease;
            cursor: default;
        }

        .jobs-table tbody tr:hover {
            background-color: var(--hover-color);
        }

        .jobs-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-client-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .table-client-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-client-avatar svg {
            width: 100%;
            height: 100%;
        }

        .table-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        .table-badge.in-progress {
            background-color: var(--accent-orange-bg);
            color: var(--accent-orange);
        }

        .table-badge.in-progress i {
            animation: pulse-glow-orange 1.5s infinite;
            border-radius: 50%;
        }

        .table-badge.completed {
            background-color: var(--accent-green-bg);
            color: var(--accent-green);
        }

        .table-badge.completed i {
            font-size: 8px;
        }

        .table-deadline {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .table-deadline i {
            color: var(--text-muted);
            font-size: 14px;
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

        /* ══════════════════ RESPONSIVE MEDIA QUERIES ══════════════════ */
        @media (max-width: 1200px) {
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .dashboard-row-middle,
            .dashboard-row-bottom {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 260px;
            }

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
            .content-container,
            .dashboard-row-middle,
            .dashboard-row-bottom,
            .metrics-grid {
                min-width: 0;
                max-width: 100%;
            }
            .metrics-grid {
                grid-template-columns: 1fr;
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
            .content-container {
                padding: 16px 0;
            }
            .metric-card {
                padding: 16px;
            }
            .dashboard-card {
                padding: 16px;
                border-radius: 18px;
                min-width: 0;
                max-width: 100%;
                overflow: hidden;
                box-sizing: border-box;
            }
            .chart-wrapper, .chart-container {
                width: 100%;
                max-width: 100%;
                min-width: 0;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                width: 100%;
                max-width: 100%;
                margin-top: 8px;
                box-sizing: border-box;
            }
            .jobs-table {
                min-width: 620px;
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
            .plumber-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            .plumber-right {
                width: 100%;
                display: flex;
                justify-content: flex-end;
            }
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

        /* Hologram Mascot Base Effect */
        #cute-plumber-container::before {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translateX(-50%) rotateX(70deg);
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 2px solid rgba(79, 70, 229, 0.4);
            background: radial-gradient(circle, rgba(79, 70, 229, 0.15) 0%, transparent 70%);
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.3), inset 0 0 10px rgba(79, 70, 229, 0.2);
            animation: spin-pedestal 8s linear infinite;
            z-index: -1;
        }
        
        @keyframes spin-pedestal {
            from { transform: translateX(-50%) rotateX(70deg) rotate(0deg); }
            to { transform: translateX(-50%) rotateX(70deg) rotate(360deg); }
        }

        /* ── Login Success Animation ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-success-animate .main-header .welcome-meta,
        .login-success-animate .metrics-grid .metric-card,
        .login-success-animate .dashboard-row-middle > .dashboard-card,
        .login-success-animate .dashboard-row-bottom > .dashboard-card {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .login-success-animate .main-header .welcome-meta {
            animation-delay: 0.1s;
        }
        .login-success-animate .metrics-grid .metric-card:nth-child(1) {
            animation-delay: 0.2s;
        }
        .login-success-animate .metrics-grid .metric-card:nth-child(2) {
            animation-delay: 0.3s;
        }
        .login-success-animate .metrics-grid .metric-card:nth-child(3) {
            animation-delay: 0.4s;
        }
        .login-success-animate .metrics-grid .metric-card:nth-child(4) {
            animation-delay: 0.5s;
        }
        .login-success-animate .dashboard-row-middle > :nth-child(1) {
            animation-delay: 0.6s;
        }
        .login-success-animate .dashboard-row-middle > :nth-child(2) {
            animation-delay: 0.7s;
        }
        .login-success-animate .dashboard-row-bottom > :nth-child(1) {
            animation-delay: 0.8s;
        }
        .login-success-animate .dashboard-row-bottom > :nth-child(2) {
            animation-delay: 0.9s;
        }
    </style>
    <!-- Three.js for 3D Plumber Avatar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>
<body class="{{ session('welcome') ? 'login-success-animate' : '' }}">

    <!-- Top Slim Dashboard Loading Progress Bar -->
    <div id="dash-top-bar-container" style="position: fixed; top: 0; left: 0; width: 100%; height: 3px; z-index: 99999; pointer-events: none; opacity: 1; transition: opacity 0.5s ease;">
        <div id="dash-top-bar" style="height: 100%; width: 0%; background: linear-gradient(90deg, var(--brand-color), #0ea5e9, #6366f1); box-shadow: 0 0 10px rgba(79, 70, 229, 0.6); transition: width 0.4s ease-out;"></div>
    </div>

    <!-- Login Welcome Notification Toast with Auto-Dismiss Loading Bar (White Theme) -->
    @if (session('welcome'))
    <div id="welcome-loading-toast" style="position: fixed; top: 24px; right: 24px; z-index: 99999; background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 18px 24px; color: #0f172a; box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 10px 15px -3px rgba(0,0,0,0.05); display: flex; flex-direction: column; gap: 10px; max-width: 420px; animation: slideInWelcome 0.6s cubic-bezier(0.16, 1, 0.3, 1); overflow: hidden;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #4f46e5); display: flex; align-items: center; justify-content: center; color: white; font-size: 18px; flex-shrink: 0; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <div style="font-weight: 800; font-size: 15px; color: #0f172a; letter-spacing: -0.2px;">Staff Portal Activated</div>
                    <div style="font-size: 13px; color: #64748b; line-height: 1.4; font-weight: 500;">{{ session('welcome') }}</div>
                </div>
            </div>
            <button onclick="dismissWelcomeToast()" style="background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; transition: color 0.2s;" onmouseover="this.style.color='#0f172a'" onmouseout="this.style.color='#94a3b8'">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <!-- Progress Timer Bar -->
        <div style="width: 100%; height: 3px; background: #f1f5f9; border-radius: 99px; overflow: hidden; margin-top: 4px;">
            <div id="toast-progress-bar" style="height: 100%; width: 100%; background: linear-gradient(90deg, #6366f1, #06b6d4); transition: width 4.5s linear;"></div>
        </div>
    </div>

    <style>
        @keyframes slideInWelcome {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
    </style>

    <script>
        function initDashboardTopBar() {
            const topBar = document.getElementById('dash-top-bar');
            const topBarContainer = document.getElementById('dash-top-bar-container');
            if (topBar && topBarContainer) {
                topBarContainer.style.opacity = '1';
                topBar.style.width = '0%';
                setTimeout(() => { topBar.style.width = '70%'; }, 40);
                setTimeout(() => { topBar.style.width = '100%'; }, 220);
                setTimeout(() => { topBarContainer.style.opacity = '0'; }, 550);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initDashboardTopBar();

            const toastBar = document.getElementById('toast-progress-bar');
            if (toastBar) {
                setTimeout(() => { toastBar.style.width = '0%'; }, 100);
                setTimeout(() => { dismissWelcomeToast(); }, 4700);
            }
        });

        window.addEventListener('pageshow', initDashboardTopBar);

        function dismissWelcomeToast() {
            const toast = document.getElementById('welcome-loading-toast');
            if (toast) {
                toast.style.transition = 'all 0.4s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px) scale(0.95)';
                setTimeout(() => toast.remove(), 400);
            }
        }
    </script>
    @else
    <script>
        function initDashboardTopBar() {
            const topBar = document.getElementById('dash-top-bar');
            const topBarContainer = document.getElementById('dash-top-bar-container');
            if (topBar && topBarContainer) {
                topBarContainer.style.opacity = '1';
                topBar.style.width = '0%';
                setTimeout(() => { topBar.style.width = '70%'; }, 40);
                setTimeout(() => { topBar.style.width = '100%'; }, 220);
                setTimeout(() => { topBarContainer.style.opacity = '0'; }, 550);
            }
        }

        document.addEventListener('DOMContentLoaded', initDashboardTopBar);
        window.addEventListener('pageshow', initDashboardTopBar);
    </script>
    @endif

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
                    @if($staff->isAdmin())
                        <h1>Welcome back, {{ $staff->staffName }}!</h1>
                    @else
                        <h1>Welcome back, Staff {{ $staff->staffName }}!</h1>
                    @endif
                    <p>Manage your bookings, services, and reports all in one place.</p>
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
                        <!-- Tiny Avatar SVG -->
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
        
        <!-- Dashboard Content Grid -->
        <main class="content-container">
            
            <!-- Metrics Row (4 Cards) -->
            <div class="metrics-grid">
                
                <!-- Card 1: Active Clients -->
                <div class="metric-card card-theme-indigo">
                    <!-- Background illustration: group of people -->
                    <svg style="position:absolute;bottom:-10px;right:-10px;width:115px;height:115px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Person 1 (center) -->
                        <circle cx="32" cy="20" r="10" fill="currentColor"/>
                        <path d="M16 52 C16 40 48 40 48 52 L48 58 L16 58 Z" fill="currentColor"/>
                        <!-- Person 2 (left) -->
                        <circle cx="14" cy="24" r="7" fill="currentColor" opacity="0.7"/>
                        <path d="M2 54 C2 45 26 45 26 54" stroke="currentColor" stroke-width="5" fill="none" opacity="0.7"/>
                        <!-- Person 3 (right) -->
                        <circle cx="50" cy="24" r="7" fill="currentColor" opacity="0.7"/>
                        <path d="M38 54 C38 45 62 45 62 54" stroke="currentColor" stroke-width="5" fill="none" opacity="0.7"/>
                    </svg>
                    <div class="metric-header">
                        <div class="metric-title-group">
                            <div class="metric-icon"><i class="fa-solid fa-users"></i></div>
                            <span class="metric-title">Total Active Clients</span>
                        </div>
                        <span class="metric-trend {{ $newClientsThisMonth > 0 ? 'up' : '' }}"><i class="fa-solid fa-caret-up"></i> +{{ $newClientsThisMonth }} new</span>
                    </div>
                    <div class="metric-body">
                        <span class="metric-value">{{ sprintf("%02d", $totalActiveClients) }}</span>
                        <span class="metric-desc">Currently receiving our services</span>
                    </div>
                </div>

                <!-- Card 2: Pending Orders -->
                <div class="metric-card card-theme-orange">
                    <!-- Background illustration: clock -->
                    <svg style="position:absolute;bottom:-8px;right:-8px;width:115px;height:115px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="32" cy="32" r="26" stroke="currentColor" stroke-width="4"/>
                        <path d="M32 14 L32 32 L46 40" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="32" cy="32" r="3" fill="currentColor"/>
                        <line x1="32" y1="6" x2="32" y2="11" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <line x1="32" y1="53" x2="32" y2="58" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <line x1="6" y1="32" x2="11" y2="32" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <line x1="53" y1="32" x2="58" y2="32" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                    <div class="metric-header">
                        <div class="metric-title-group">
                            <div class="metric-icon"><i class="fa-regular fa-clock"></i></div>
                            <span class="metric-title">Pending Orders</span>
                        </div>
                        <span class="metric-trend {{ $newBookingsToday > 0 ? 'up' : '' }}"><i class="fa-solid fa-caret-up"></i> +{{ $newBookingsToday }} today</span>
                    </div>
                    <div class="metric-body">
                        <span class="metric-value">{{ sprintf("%02d", $pendingOrders) }}</span>
                        <span class="metric-desc">Orders waiting for action</span>
                    </div>
                </div>

                <!-- Card 3: Completed Jobs -->
                <div class="metric-card card-theme-green">
                    <!-- Background illustration: wrench + checkmark -->
                    <svg style="position:absolute;bottom:-10px;right:-12px;width:120px;height:120px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Wrench -->
                        <path d="M46 8 C40 8 36 12 36 18 C36 19.5 36.3 21 37 22.2 L14 45.2 C12.8 44.5 11.3 44 10 44 C4 44 0 48 0 54 C0 60 4 64 10 64 C16 64 20 60 20 54 C20 52.5 19.7 51 19 49.8 L42 26.8 C43.2 27.5 44.7 28 46 28 C52 28 56 24 56 18 C56 16.2 55.6 14.5 54.8 13 L48 20 L44 16 L50.8 9.2 C49.3 8.4 47.7 8 46 8 Z" fill="currentColor"/>
                        <!-- Check badge -->
                        <circle cx="50" cy="50" r="13" fill="currentColor"/>
                        <path d="M44 50 L48 54 L56 46" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <div class="metric-header">
                        <div class="metric-title-group">
                            <div class="metric-icon"><i class="fa-regular fa-circle-check"></i></div>
                            <span class="metric-title">Completed Jobs</span>
                        </div>
                        <span class="metric-trend {{ $jobsGrowth >= 0 ? 'up' : 'down' }}"><i class="fa-solid {{ $jobsGrowth >= 0 ? 'fa-caret-up' : 'fa-caret-down' }}"></i> {{ ($jobsGrowth >= 0 ? '+' : '') . number_format($jobsGrowth, 0) }}%</span>
                    </div>
                    <div class="metric-body">
                        <span class="metric-value">{{ sprintf("%02d", $completedJobs) }}</span>
                        <span class="metric-desc">Growth compared to last month</span>
                    </div>
                </div>

                <!-- Card 4: Total Sales -->
                <div class="metric-card card-theme-rose">
                    <!-- Background illustration: stacked coins / money bag -->
                    <svg style="position:absolute;bottom:-8px;right:-8px;width:115px;height:115px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Coin stack -->
                        <ellipse cx="32" cy="14" rx="20" ry="7" fill="currentColor"/>
                        <rect x="12" y="14" width="40" height="7" fill="currentColor" opacity="0.85"/>
                        <ellipse cx="32" cy="21" rx="20" ry="7" fill="currentColor" opacity="0.85"/>
                        <rect x="12" y="21" width="40" height="7" fill="currentColor" opacity="0.7"/>
                        <ellipse cx="32" cy="28" rx="20" ry="7" fill="currentColor" opacity="0.7"/>
                        <rect x="12" y="28" width="40" height="7" fill="currentColor" opacity="0.55"/>
                        <ellipse cx="32" cy="35" rx="20" ry="7" fill="currentColor" opacity="0.55"/>
                        <!-- RM currency symbol -->
                        <text x="22" y="16" font-size="8" font-weight="bold" fill="white" font-family="sans-serif">RM</text>
                    </svg>
                    <div class="metric-header">
                        <div class="metric-title-group">
                            <div class="metric-icon"><i class="fa-solid fa-coins"></i></div>
                            <span class="metric-title">Total Sales</span>
                        </div>
                        <span class="metric-trend {{ $salesGrowth >= 0 ? 'up' : 'down' }}"><i class="fa-solid {{ $salesGrowth >= 0 ? 'fa-caret-up' : 'fa-caret-down' }}"></i> {{ ($salesGrowth >= 0 ? '+' : '') . number_format($salesGrowth, 1) }}%</span>
                    </div>
                    <div class="metric-body">
                        <span class="metric-value" style="font-size: 28px;">RM {{ number_format($totalSales, 2) }}</span>
                        <span class="metric-desc">All-time revenue completed</span>
                    </div>
                </div>

            </div>

            <!-- Middle Row Grid (Revenue Growth + Recent Activities) -->
            <div class="dashboard-row-middle">
                
                <!-- Left: Sales Chart Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <div class="card-icon"><i class="fa-solid fa-chart-column"></i></div>
                            <h2 class="card-title">Monthly Sales Trend</h2>
                        </div>
                        <div class="card-actions">
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <div class="legend-dot service" style="background-color: var(--brand-color);"></div>
                                    <span>Total Sales</span>
                                </div>
                            </div>
                            <form action="{{ route('staff.dashboard') }}" method="GET" id="chartYearForm" style="margin: 0;">
                                <select name="chart_year" class="dropdown-filter" onchange="document.getElementById('chartYearForm').submit()">
                                    @foreach($years as $yr)
                                        <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>
                                            {{ $yr == date('Y') ? 'This Year ('.$yr.')' : ($yr == date('Y') - 1 ? 'Last Year ('.$yr.')' : $yr) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    
                    <!-- CSS Custom Clustered Bar Chart -->
                    <div class="chart-container" id="revenueChartContainer">
                        <!-- Horizontal Grid Lines -->
                        <div class="chart-grid-lines">
                            @foreach($yLabels as $label)
                            <div class="grid-line-row">
                                <span class="grid-line-label">{{ $label }}</span>
                                <div class="grid-line-dash"></div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Bar Groups for Jan-Dec -->
                        <div class="chart-bars-area">
                            @foreach($monthlyData as $mIndex => $data)
                            <div class="chart-month-col {{ $mIndex == $highestMonthIndex ? 'active' : '' }}" 
                                 data-month="{{ $data['month_full_name'] }}"
                                 data-sales="RM {{ number_format($data['sales'], 2) }}"
                                 data-growth="{{ ($data['growth'] >= 0 ? '+' : '') . number_format($data['growth'], 1) }}% vs prev">
                                 <div class="month-bars">
                                     <div class="bar sales-bar" style="height: {{ $data['sales_height'] }}%;"></div>
                                 </div>
                                 <div class="month-label">{{ $data['month_name'] }}</div>
                             </div>
                             @endforeach
                         </div>

                         <!-- Dynamic Tooltip Box -->
                         <div class="chart-tooltip-aug" id="revenueChartTooltip" style="position: absolute; display: none; pointer-events: none; z-index: 10;">
                             <div class="tooltip-row">
                                 <div class="tooltip-dot service" style="background-color: var(--brand-color);"></div>
                                 <span id="tooltipSalesVal">RM 0.00</span>
                             </div>
                             <span class="tooltip-growth" id="tooltipGrowthVal">+0.0% vs prev</span>
                         </div>
                     </div>
                </div>

                <!-- Right: Recent Activities Card -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <div class="card-icon"><i class="fa-regular fa-clock"></i></div>
                            <h2 class="card-title">Recent Activities</h2>
                        </div>
                        <a href="{{ route('staff.bookings') }}" class="see-all-btn">See All</a>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="tab-bar">
                        <button class="tab-btn active" data-tab="all">All</button>
                        <button class="tab-btn" data-tab="pending">Bookings</button>
                        <button class="tab-btn" data-tab="payment">Payments</button>
                        <button class="tab-btn" data-tab="refund">Refunds</button>
                        <button class="tab-btn" data-tab="in_progress">In Progress</button>
                        <button class="tab-btn" data-tab="completed">Completed</button>
                    </div>

                    <!-- Activities List -->
                    <div class="activity-list">
                        @forelse($recentActivities as $booking)
                        @php
                            $itemStatus = 'pending';
                            $targetRoute = route('staff.bookings');
                            $statusClass = 'pending';
                            $statusLabel = 'Pending Booking';

                            $hasReceipt = !empty($booking->bookingDepositReceipt) || ($booking->paymentReceipts && $booking->paymentReceipts->count() > 0);
                            $pStatus = $booking->paymentStatus;
                            $rStatus = $booking->refund_status;

                            // 1. Check Refund status
                            if ($rStatus && $rStatus !== 'not_applicable') {
                                $itemStatus = 'refund';
                                $targetRoute = route('staff.refunds.index');
                                if ($rStatus == 'pending') {
                                    $statusClass = 'refund';
                                    $statusLabel = 'Pending Refund';
                                } else {
                                    $statusClass = 'completed';
                                    $statusLabel = 'Refund ' . ucfirst($rStatus);
                                }
                            }
                            // 2. Check Payment Verification status
                            elseif ($hasReceipt || in_array($pStatus, ['Pending', 'Awaiting Verification', 'Submitted', 'Under Review', 'Paid', 'Rejected'])) {
                                $itemStatus = 'payment';
                                $targetRoute = route('staff.payments.index');
                                if (in_array($pStatus, ['Pending', 'Awaiting Verification', 'Submitted', 'Under Review']) || ($hasReceipt && $pStatus !== 'Paid')) {
                                    $statusClass = 'payment';
                                    $statusLabel = 'Verify Payment';
                                } elseif ($pStatus === 'Paid') {
                                    $statusClass = 'completed';
                                    $statusLabel = 'Payment Verified';
                                } elseif ($pStatus === 'Rejected') {
                                    $statusClass = 'cancelled';
                                    $statusLabel = 'Payment Rejected';
                                } else {
                                    $statusClass = 'payment';
                                    $statusLabel = 'Verify Payment';
                                }
                            }
                            // 3. Regular Booking status
                            else {
                                if (!$booking->staffID || $booking->bookingStatus == 'pending') {
                                    $itemStatus = 'pending';
                                    $statusClass = 'pending';
                                    $statusLabel = 'Pending Booking';
                                } elseif ($booking->bookingStatus == 'in_progress') {
                                    $itemStatus = 'in_progress';
                                    $statusClass = 'in_progress';
                                    $statusLabel = 'In Progress';
                                } elseif ($booking->bookingStatus == 'completed') {
                                    $itemStatus = 'completed';
                                    $statusClass = 'completed';
                                    $statusLabel = 'Completed';
                                } elseif ($booking->bookingStatus == 'cancelled') {
                                    $itemStatus = 'cancelled';
                                    $statusClass = 'cancelled';
                                    $statusLabel = 'Cancelled';
                                }
                            }
                        @endphp
                        <a href="{{ $targetRoute }}" class="activity-item" data-status="{{ $itemStatus }}">
                            <div class="activity-left">
                                <div class="activity-avatar">
                                    @php
                                        $colors = [
                                            ['bg' => '#e0f2fe', 'fg' => '#0284c7', 'face' => '#f0d3c0', 'hair' => '#1e293b'],
                                            ['bg' => '#f3e8ff', 'fg' => '#a855f7', 'face' => '#fcd34d', 'hair' => '#1e1b4b'],
                                            ['bg' => '#f1f5f9', 'fg' => '#475569', 'face' => '#e7c8b4', 'hair' => '#78350f'],
                                            ['bg' => '#fef9c3', 'fg' => '#eab308', 'face' => '#ffd8be', 'hair' => '#451a03'],
                                        ];
                                        $style = $colors[$booking->bookingID % count($colors)];
                                    @endphp
                                    <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="60" cy="60" r="60" fill="{{ $style['bg'] }}" />
                                        <circle cx="60" cy="55" r="22" fill="{{ $style['face'] }}" />
                                        <path d="M38 48c-1-12 6-22 22-22s23 10 22 22c-3 5-10 4-22 4s-19-1-22-4z" fill="{{ $style['hair'] }}" />
                                        <path d="M25 98c8-18 20-22 35-22s27 4 35 22v22H25V98z" fill="{{ $style['fg'] }}" />
                                    </svg>
                                </div>
                                <div class="activity-meta-details">
                                    <span class="activity-name">{{ $booking->customer->customerName ?? 'Customer' }}</span>
                                    <span class="activity-sub">{{ $booking->bookingProblem }}</span>
                                </div>
                            </div>
                            <div class="activity-right">
                                <div class="activity-status-group">
                                    <span class="activity-status status-{{ $statusClass }}"><i class="fa-solid fa-circle"></i> {{ $statusLabel }}</span>
                                    <span class="activity-time">{{ $booking->created_at->diffForHumans() }}</span>
                                </div>
                                <i class="fa-solid fa-chevron-right activity-arrow"></i>
                            </div>
                        </a>
                        @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 40px 0; font-size: 14px; width: 100%;">
                            No recent activities found.
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Bottom Row Grid (Top Performing Plumbers + Ongoing Jobs) -->
            <div class="dashboard-row-bottom">
                
                <!-- Left: Plumbers List -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <div class="card-icon"><i class="fa-solid fa-helmet-safety"></i></div>
                            <h2 class="card-title">Plumbers</h2>
                        </div>
                        @if($staff->isAdmin())
                        <a href="{{ route('staff.plumbers') }}" class="see-all-btn">See All</a>
                        @endif
                    </div>
                    
                    <!-- Plumber List -->
                    <div class="plumber-list">
                        @forelse($plumbers as $i => $plumber)
                        <div class="plumber-item">
                            <div class="plumber-left">
                                <div class="plumber-avatar">
                                    @php
                                        $colors = [
                                            ['bg' => '#dbeafe', 'fg' => '#1d4ed8', 'face' => '#ffd8be', 'hair' => '#1e3a8a'],
                                            ['bg' => '#f1f5f9', 'fg' => '#475569', 'face' => '#e2e8f0', 'hair' => '#64748b'],
                                            ['bg' => '#ffedd5', 'fg' => '#b45309', 'face' => '#fbcfe8', 'hair' => '#7c2d12'],
                                        ];
                                        $style = $colors[$i % count($colors)];
                                    @endphp
                                    <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="60" cy="60" r="60" fill="{{ $style['bg'] }}" />
                                        <circle cx="60" cy="55" r="22" fill="{{ $style['face'] }}" />
                                        <path d="M38 48c0-10 8-18 22-18s22 8 22 18v6c-4-2-10 0-15-2-5 2-10 0-15 2v-6z" fill="{{ $style['hair'] }}" />
                                        <path d="M25 98c8-18 20-22 35-22s27 4 35 22v22H25V98z" fill="{{ $style['fg'] }}" />
                                    </svg>
                                </div>
                                <div class="plumber-meta">
                                    <span class="plumber-name" style="font-weight: 700; color: var(--text-dark);">{{ $plumber->staffName }}</span>
                                </div>
                            </div>
                            <div class="plumber-right">
                                <div class="plumber-stats">
                                    <span class="plumber-jobs">{{ $plumber->bookings_count }} {{ Str::plural('Job', $plumber->bookings_count) }} Completed</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div style="text-align: center; color: var(--text-muted); padding: 40px 0; font-size: 14px; width: 100%;">
                            No plumbers found.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right: Ongoing Jobs Table -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <div class="card-icon"><i class="fa-solid fa-circle-notch"></i></div>
                            <h2 class="card-title">Ongoing Jobs</h2>
                        </div>
                        <a href="{{ route('staff.bookings') }}" class="see-all-btn">See All</a>
                    </div>

                    <!-- Table container -->
                    <div class="table-container">
                        <table class="jobs-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Plumber</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ongoingJobs as $i => $job)
                                <tr>
                                    <td>
                                        <div class="table-client-cell">
                                            <div class="table-client-avatar">
                                                @php
                                                    $colors = [
                                                        ['bg' => '#fed7aa', 'fg' => '#ea580c', 'face' => '#fcd34d', 'hair' => '#c2410c'],
                                                        ['bg' => '#f1f5f9', 'fg' => '#64748b', 'face' => '#e2e8f0', 'hair' => '#475569'],
                                                    ];
                                                    $style = $colors[$i % count($colors)];
                                                @endphp
                                                <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="60" cy="60" r="60" fill="{{ $style['bg'] }}" />
                                                    <circle cx="60" cy="55" r="21" fill="{{ $style['face'] }}" />
                                                    <path d="M35 50c0-12 10-22 25-22s25 10 25 22v6c-5-2-10 0-15-2-5 2-10 0-15 2v-6z" fill="{{ $style['hair'] }}" />
                                                    <path d="M25 100c8-20 20-22 35-22s27 2 35 22v20H25v-20z" fill="{{ $style['fg'] }}" />
                                                </svg>
                                            </div>
                                            <span>{{ $job->customer->customerName }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $job->bookingType }}</td>
                                    <td>
                                        @if($job->staff)
                                            <div style="font-weight:600;color:var(--text-dark);">{{ $job->staff->staffName }}</div>
                                            <div style="font-size:11px;color:var(--text-muted);">ID: #{{ $job->staffID }}</div>
                                        @else
                                            <span style="color:var(--text-muted);">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($job->bookingStatus == 'completed')
                                        <span class="table-badge completed">
                                            <i class="fa-solid fa-check"></i> Completed
                                        </span>
                                        @elseif($job->bookingStatus == 'cancelled')
                                        <span class="table-badge" style="background-color:#fee2e2; color:#ef4444;">
                                            <i class="fa-solid fa-xmark"></i> Cancelled
                                        </span>
                                        @else
                                        <span class="table-badge in-progress">
                                            <i class="fa-solid fa-circle"></i> {{ ucwords(str_replace('_', ' ', $job->bookingStatus)) }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-deadline">
                                            <i class="fa-regular fa-calendar"></i>
                                            <span>{{ $job->bookingDate ? $job->bookingDate->format('M d') : '—' }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                                        No jobs recorded.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

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
                    if (window.innerWidth < 1024) {
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

            // Tab filtering for Recent Activities
            const tabBtns = document.querySelectorAll('.tab-btn');
            const activityItems = document.querySelectorAll('.activity-item');

            function applyFilter() {
                const activeBtn = document.querySelector('.tab-bar .tab-btn.active');
                if (!activeBtn) return;
                const filter = activeBtn.getAttribute('data-tab') || activeBtn.textContent.trim().toLowerCase();
                activityItems.forEach(item => {
                    const itemStatus = (item.getAttribute('data-status') || '').toLowerCase();
                    let show = false;
                    if (filter === 'all') {
                        show = true;
                    } else if (filter === 'payment') {
                        show = (itemStatus === 'payment');
                    } else if (filter === 'refund') {
                        show = (itemStatus === 'refund');
                    } else if (filter === 'pending') {
                        show = (itemStatus === 'pending');
                    } else if (filter === 'in_progress') {
                        show = (itemStatus === 'in_progress' || itemStatus === 'confirmed');
                    } else if (filter === 'completed') {
                        show = (itemStatus === 'completed');
                    } else if (filter === 'cancelled') {
                        show = (itemStatus === 'cancelled');
                    } else {
                        show = (itemStatus === filter);
                    }
                    item.style.display = show ? 'flex' : 'none';
                });
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    applyFilter();
                });
            });

            // Run initial filter on load
            applyFilter();

            // Interactive Chart Tooltip
            const chartCols = document.querySelectorAll('.chart-month-col');
            const tooltip = document.getElementById('revenueChartTooltip');
            const tooltipSales = document.getElementById('tooltipSalesVal');
            const tooltipGrowth = document.getElementById('tooltipGrowthVal');
            const chartContainer = document.getElementById('revenueChartContainer');

            // Find default active column (highest)
            const defaultCol = document.querySelector('.chart-month-col.active');

            function positionTooltip(col) {
                if (!tooltip || !col) return;
                const salesVal = col.getAttribute('data-sales');
                const growthVal = col.getAttribute('data-growth');

                tooltipSales.textContent = salesVal;
                tooltipGrowth.textContent = growthVal;

                tooltip.style.display = 'flex';
                tooltip.style.transform = 'translateX(-50%)';
                tooltip.style.bottom = 'auto';

                // Position relative to chart-month-col
                const colRect = col.getBoundingClientRect();
                const containerRect = chartContainer.getBoundingClientRect();

                const leftPos = colRect.left - containerRect.left + (colRect.width / 2);
                tooltip.style.left = `${leftPos}px`;

                // The tooltip sits above the highest bar in this column
                const barElements = col.querySelectorAll('.bar');
                let minTop = containerRect.bottom;
                barElements.forEach(b => {
                    const r = b.getBoundingClientRect();
                    if (r.top < minTop) minTop = r.top;
                });
                
                const topPos = minTop - containerRect.top - tooltip.offsetHeight - 8;
                tooltip.style.top = `${topPos}px`;
            }

            chartCols.forEach(col => {
                col.addEventListener('mouseenter', () => {
                    chartCols.forEach(c => c.classList.remove('active'));
                    col.classList.add('active');
                    positionTooltip(col);
                });
            });

            if (chartContainer) {
                chartContainer.addEventListener('mouseleave', () => {
                    chartCols.forEach(c => c.classList.remove('active'));
                    tooltip.style.display = 'none';
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

            setInterval(checkLiveNotifications, 6000);
            checkLiveNotifications();
        });
    </script>

    <!-- ══════════ 3D CUTE PLUMBER AVATAR ══════════ -->
    <div id="cute-plumber-container" style="position: fixed; top: 80%; left: 80%; width: 140px; height: 140px; z-index: 99999; cursor: pointer; user-select: none; transition: transform 0.2s ease;">
        <!-- Speech bubble -->
        <div id="plumber-speech-bubble" style="display: none; position: absolute; bottom: 135px; left: 50%; transform: translateX(-50%); width: 220px; background-color: white; border: 2px solid var(--brand-color); border-radius: 16px; padding: 12px 16px; box-shadow: var(--shadow-lg); font-size: 13px; font-weight: 700; color: var(--text-dark); line-height: 1.4; z-index: 100000; animation: bubblePop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both; font-family: 'Outfit', sans-serif;">
            <span id="plumber-speech-text">Need help? 🪠</span>
            <!-- Speech triangle indicator -->
            <div style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid var(--brand-color);"></div>
            <div style="position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid white;"></div>
        </div>
        
        <canvas id="cute-plumber-canvas" width="140" height="140" style="display: block; outline: none;"></canvas>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Speech Bubble Quotes
            const plumberQuotes = [
                "Hello! I'm Plumbfix's mascot! Tap me to do a flip! 🪠",
                "Checking system metrics... everything looks perfectly clear! 👍",
                "Did you know? A leaky toilet can waste 200 gallons of water a day! 💧",
                "On duty and ready to repair! 🛠️",
                "Need a wrench? I've got mine handy! 🔧",
                "Is it hot in here, or did someone leave the boiler on? 🥵",
                "Remember: A slow drain is an early sign of clogging! 🪠",
                "Woohoo! Dynamic 3D backflip! 🤸‍♂️",
                "Keep up the great work! Plumbfix rules! 🌟",
                "Did you check the plumbers list today? We have some top-tier talent! 👷"
            ];

            const container = document.getElementById('cute-plumber-container');
            const canvas = document.getElementById('cute-plumber-canvas');
            const speechBubble = document.getElementById('plumber-speech-bubble');
            const speechText = document.getElementById('plumber-speech-text');

            if (!container || !canvas) return;

            // 1. Setup Three.js scene inside the canvas
            const width = 140;
            const height = 140;
            const scene = new THREE.Scene();
            
            // Transparent background
            const renderer = new THREE.WebGLRenderer({ canvas: canvas, alpha: true, antialias: true });
            renderer.setSize(width, height);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

            // Camera setup
            const camera = new THREE.PerspectiveCamera(35, width / height, 0.1, 100);
            camera.position.set(0, 0, 4.2);

            // Plumber Model Group
            const plumber = new THREE.Group();
            scene.add(plumber);

            // Materials
            const skinMat = new THREE.MeshLambertMaterial({ color: 0xffd1b3 }); // Peach skin
            const redMat = new THREE.MeshLambertMaterial({ color: 0xef4444 }); // Red shirt & cap
            const blueMat = new THREE.MeshLambertMaterial({ color: 0x1d4ed8 }); // Blue overalls
            const strapMat = new THREE.MeshLambertMaterial({ color: 0x1e3a8a }); // Dark blue straps
            const darkMat = new THREE.MeshLambertMaterial({ color: 0x1e293b }); // Eyes, hair, mustache, shoes
            const yellowMat = new THREE.MeshLambertMaterial({ color: 0xf59e0b }); // Yellow buttons
            const grayMat = new THREE.MeshLambertMaterial({ color: 0x94a3b8 }); // Wrench/tools

            // --- Assemblies ---
            // A. Head
            const headGeo = new THREE.SphereGeometry(0.5, 32, 32);
            const head = new THREE.Mesh(headGeo, skinMat);
            head.position.y = 0.4;
            plumber.add(head);

            // B. Cap
            const capGeo = new THREE.SphereGeometry(0.52, 32, 16, 0, Math.PI * 2, 0, Math.PI / 2);
            const cap = new THREE.Mesh(capGeo, redMat);
            cap.position.y = 0.52;
            cap.rotation.x = -0.05;
            plumber.add(cap);

            const visorGeo = new THREE.BoxGeometry(0.6, 0.08, 0.35);
            const visor = new THREE.Mesh(visorGeo, redMat);
            visor.position.set(0, 0.65, 0.38);
            visor.rotation.x = 0.12;
            plumber.add(visor);

            // C. Eyes
            const eyeGeo = new THREE.SphereGeometry(0.06, 16, 16);
            const leftEye = new THREE.Mesh(eyeGeo, darkMat);
            leftEye.position.set(-0.16, 0.48, 0.44);
            const rightEye = new THREE.Mesh(eyeGeo, darkMat);
            rightEye.position.set(0.16, 0.48, 0.44);
            plumber.add(leftEye, rightEye);

            // D. Nose
            const noseGeo = new THREE.SphereGeometry(0.1, 16, 16);
            const nose = new THREE.Mesh(noseGeo, skinMat);
            nose.position.set(0, 0.38, 0.49);
            plumber.add(nose);

            // E. Mustache
            const mustacheGeo = new THREE.BoxGeometry(0.28, 0.08, 0.1);
            const mustache = new THREE.Mesh(mustacheGeo, darkMat);
            mustache.position.set(0, 0.26, 0.47);
            plumber.add(mustache);

            // F. Body (Overalls)
            const bodyGeo = new THREE.CylinderGeometry(0.38, 0.34, 0.7, 32);
            const body = new THREE.Mesh(bodyGeo, blueMat);
            body.position.y = -0.18;
            plumber.add(body);

            // G. Arms (Sleeves)
            const armGeo = new THREE.CylinderGeometry(0.1, 0.1, 0.35, 16);
            const leftArm = new THREE.Mesh(armGeo, redMat);
            leftArm.position.set(-0.42, -0.1, 0);
            leftArm.rotation.z = 0.4;
            const rightArm = new THREE.Mesh(armGeo, redMat);
            rightArm.position.set(0.42, -0.1, 0);
            rightArm.rotation.z = -0.4;
            plumber.add(leftArm, rightArm);

            // Hands
            const handGeo = new THREE.SphereGeometry(0.1, 16, 16);
            const leftHand = new THREE.Mesh(handGeo, skinMat);
            leftHand.position.set(-0.5, -0.25, 0);
            const rightHand = new THREE.Mesh(handGeo, skinMat);
            rightHand.position.set(0.5, -0.25, 0);
            plumber.add(leftHand, rightHand);

            // Overalls details (Straps & Buttons)
            const strapGeo = new THREE.BoxGeometry(0.06, 0.45, 0.04);
            const leftStrap = new THREE.Mesh(strapGeo, strapMat);
            leftStrap.position.set(-0.16, -0.08, 0.34);
            leftStrap.rotation.z = 0.05;
            const rightStrap = new THREE.Mesh(strapGeo, strapMat);
            rightStrap.position.set(0.16, -0.08, 0.34);
            rightStrap.rotation.z = -0.05;
            plumber.add(leftStrap, rightStrap);

            const buttonGeo = new THREE.SphereGeometry(0.04, 16, 16);
            const leftButton = new THREE.Mesh(buttonGeo, yellowMat);
            leftButton.position.set(-0.16, -0.22, 0.36);
            const rightButton = new THREE.Mesh(buttonGeo, yellowMat);
            rightButton.position.set(0.16, -0.22, 0.36);
            plumber.add(leftButton, rightButton);

            // H. Shoes
            const shoeGeo = new THREE.SphereGeometry(0.15, 16, 16);
            const leftShoe = new THREE.Mesh(shoeGeo, darkMat);
            leftShoe.position.set(-0.18, -0.58, 0.08);
            const rightShoe = new THREE.Mesh(shoeGeo, darkMat);
            rightShoe.position.set(0.18, -0.58, 0.08);
            plumber.add(leftShoe, rightShoe);

            // I. Grey Wrench held in right hand
            const wrenchHandleGeo = new THREE.BoxGeometry(0.06, 0.3, 0.03);
            const wrenchHandle = new THREE.Mesh(wrenchHandleGeo, grayMat);
            wrenchHandle.position.set(0.54, -0.24, 0.2);
            wrenchHandle.rotation.x = Math.PI / 4;
            wrenchHandle.rotation.y = Math.PI / 6;
            plumber.add(wrenchHandle);

            const wrenchHeadGeo = new THREE.TorusGeometry(0.06, 0.03, 8, 24);
            const wrenchHead = new THREE.Mesh(wrenchHeadGeo, grayMat);
            wrenchHead.position.set(0.54, -0.1, 0.32);
            wrenchHead.rotation.x = Math.PI / 4;
            wrenchHead.rotation.y = Math.PI / 6;
            plumber.add(wrenchHead);

            // J. Dynamic Shadow Mesh under plumber
            const shadowGeo = new THREE.RingGeometry(0.01, 0.3, 32);
            const shadowMat = new THREE.MeshBasicMaterial({ color: 0x000000, transparent: true, opacity: 0.12, side: THREE.DoubleSide });
            const shadow = new THREE.Mesh(shadowGeo, shadowMat);
            shadow.rotation.x = Math.PI / 2;
            shadow.position.y = -0.7;
            plumber.add(shadow);

            // Lights
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.75);
            scene.add(ambientLight);

            const dirLight = new THREE.DirectionalLight(0xffffff, 0.85);
            dirLight.position.set(3, 8, 5);
            scene.add(dirLight);

            // Position & Movement Variables
            let isCollapsed = document.body.classList.contains('collapsed-sidebar-active');
            let minX = isCollapsed ? 100 : 280;
            let maxX = window.innerWidth - 160;
            let minY = 110;
            let maxY = window.innerHeight - 160;

            let posX = maxX - 40;
            let posY = maxY - 40;
            let targetX = posX;
            let targetY = posY;

            // Apply starting position
            container.style.left = `${posX}px`;
            container.style.top = `${posY}px`;

            let isWalking = false;
            let walkSpeed = 1.8;
            let walkTime = 0;

            let isBackflipping = false;
            let flipAngle = 0;
            let bubbleTimeout = null;

            // Helper to check window bounds
            function updateBounds() {
                isCollapsed = document.body.classList.contains('collapsed-sidebar-active');
                minX = isCollapsed ? 100 : 280;
                maxX = window.innerWidth - 160;
                minY = 110;
                maxY = window.innerHeight - 160;

                // Clamp current position in case window size shrunk
                posX = Math.max(minX, Math.min(posX, maxX));
                posY = Math.max(minY, Math.min(posY, maxY));
                container.style.left = `${posX}px`;
                container.style.top = `${posY}px`;
            }
            window.addEventListener('resize', updateBounds);
            
            // Listen to sidebar toggle to dynamically recalculate boundary bounds
            const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', () => {
                    setTimeout(updateBounds, 300); // delay to let transition finish
                });
            }

            // Periodically pick random positions to wander
            function selectNewTarget() {
                if (Math.random() < 0.28 && !isBackflipping) {
                    updateBounds();
                    if (maxX > minX && maxY > minY) {
                        targetX = minX + Math.random() * (maxX - minX);
                        targetY = minY + Math.random() * (maxY - minY);
                        isWalking = true;
                    }
                }
            }
            setInterval(selectNewTarget, 9000);

            // Interaction - Click trigger flip and random quote speech bubble
            container.addEventListener('click', (e) => {
                // Prevent bubbling
                e.stopPropagation();
                
                if (isBackflipping) return;

                isBackflipping = true;
                flipAngle = 0;

                // Pick a speech message
                const quote = plumberQuotes[Math.floor(Math.random() * plumberQuotes.length)];
                speechText.innerText = quote;
                speechBubble.style.display = 'block';

                if (bubbleTimeout) clearTimeout(bubbleTimeout);
                bubbleTimeout = setTimeout(() => {
                    speechBubble.style.display = 'none';
                }, 6000);
            });

            // Animation Loop
            function tick() {
                requestAnimationFrame(tick);

                const time = Date.now() * 0.003;

                if (isBackflipping) {
                    // Spin flip
                    flipAngle += 0.12;
                    plumber.rotation.x = flipAngle;

                    // Arc height
                    const progress = flipAngle / (Math.PI * 2);
                    const jumpHeight = Math.sin(progress * Math.PI) * 1.3;
                    plumber.position.y = jumpHeight;

                    // Shrink and fade shadow
                    shadow.scale.set(1 - jumpHeight * 0.5, 1 - jumpHeight * 0.5, 1);
                    shadow.material.opacity = 0.12 * (1 - jumpHeight * 0.6);

                    if (flipAngle >= Math.PI * 2) {
                        isBackflipping = false;
                        plumber.rotation.x = 0;
                        plumber.position.y = 0;
                        shadow.scale.set(1, 1, 1);
                        shadow.material.opacity = 0.12;
                    }
                } else {
                    // Idle breathing bobbing
                    plumber.position.y = Math.sin(time * 1.5) * 0.05;
                    plumber.rotation.y = Math.cos(time * 0.7) * 0.12;
                    
                    // Face towards cursor position subtly
                    leftArm.rotation.z = 0.4 + Math.sin(time * 1.5) * 0.04;
                    rightArm.rotation.z = -0.4 - Math.sin(time * 1.5) * 0.04;
                }

                // Handle waddle-walking movement
                if (isWalking && !isBackflipping) {
                    const dx = targetX - posX;
                    const dy = targetY - posY;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist > 5) {
                        // Swing limbs
                        walkTime += 0.18;
                        leftArm.rotation.z = 0.4 + Math.sin(walkTime) * 0.4;
                        rightArm.rotation.z = -0.4 - Math.sin(walkTime) * 0.4;

                        leftShoe.position.z = Math.sin(walkTime) * 0.18;
                        rightShoe.position.z = -Math.sin(walkTime) * 0.18;
                        
                        leftShoe.position.y = -0.58 + Math.max(0, Math.cos(walkTime) * 0.12);
                        rightShoe.position.y = -0.58 + Math.max(0, -Math.cos(walkTime) * 0.12);

                        // Face direction of movement
                        plumber.rotation.y = dx > 0 ? 0.4 : -0.4;

                        posX += (dx / dist) * walkSpeed;
                        posY += (dy / dist) * walkSpeed;

                        container.style.left = `${posX}px`;
                        container.style.top = `${posY}px`;
                    } else {
                        isWalking = false;
                        // Reset waddle poses
                        leftArm.rotation.z = 0.4;
                        rightArm.rotation.z = -0.4;
                        leftShoe.position.set(-0.18, -0.58, 0.08);
                        rightShoe.position.set(0.18, -0.58, 0.08);
                    }
                }

                renderer.render(scene, camera);
            }

            // Start loop
            tick();
        });
    </script>
</body>
</html>
