<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Seasonality Analytics — Plumbfix</title>
    <meta name="description" content="Analyze booking trends, seasonality patterns, and optimize technician resource allocation.">
    
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
            --accent-rainy: #0284c7;
            --accent-rainy-bg: rgba(2, 132, 199, 0.1);
            --accent-rainy-border: rgba(2, 132, 199, 0.15);
            
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

        /* ══════════════════ CONTENT CONTAINER ══════════════════ */
        .content-container {
            padding: 32px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        /* Control Panel */
        .control-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            padding: 18px 24px;
            border-radius: 20px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
        }

        .year-select {
            padding: 10px 16px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-dark);
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            cursor: pointer;
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
        }

        .year-select:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--brand-gradient);
            color: white;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            padding: 11px 20px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
            transition: all var(--transition-speed) ease;
        }

        .btn-export:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
        }

        /* Statistics Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stats-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all var(--transition-speed) cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--brand-color), transparent);
            opacity: 0;
            transition: opacity var(--transition-speed);
        }

        .stats-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-lg);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .stats-card:hover::before {
            opacity: 1;
        }

        /* Customize stats card hover highlights based on index */
        .stats-card:nth-child(1):hover::before {
            background: linear-gradient(90deg, transparent, var(--brand-color), transparent);
        }
        .stats-card:nth-child(2):hover::before {
            background: linear-gradient(90deg, transparent, var(--accent-orange), transparent);
        }
        .stats-card:nth-child(3):hover::before {
            background: linear-gradient(90deg, transparent, var(--accent-rainy), transparent);
        }
        .stats-card:nth-child(4):hover::before {
            background: linear-gradient(90deg, transparent, var(--accent-green), transparent);
        }

        .stats-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stats-card-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-main);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stats-icon-wrapper {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all var(--transition-speed);
        }

        .stats-card:hover .stats-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .stats-icon-wrapper.blue {
            color: var(--brand-color);
            background: var(--brand-light);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.1);
        }
        .stats-card:hover .stats-icon-wrapper.blue {
            background: var(--brand-color);
            color: white;
        }

        .stats-icon-wrapper.orange {
            color: var(--accent-orange);
            background: var(--accent-orange-bg);
            box-shadow: 0 4px 10px rgba(245, 158, 11, 0.1);
        }
        .stats-card:hover .stats-icon-wrapper.orange {
            background: var(--accent-orange);
            color: white;
        }

        .stats-icon-wrapper.rainy {
            color: var(--accent-rainy);
            background: var(--accent-rainy-bg);
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.1);
        }
        .stats-card:hover .stats-icon-wrapper.rainy {
            background: var(--accent-rainy);
            color: white;
        }

        .stats-icon-wrapper.green {
            color: var(--accent-green);
            background: var(--accent-green-bg);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.1);
        }
        .stats-card:hover .stats-icon-wrapper.green {
            background: var(--accent-green);
            color: white;
        }

        .stats-card-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .stats-card-footer {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .stats-card-footer strong {
            color: var(--text-main);
            font-weight: 700;
        }

        /* ── SVG Charts Layout ── */
        .chart-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: relative;
            overflow: hidden;
            transition: box-shadow var(--transition-speed);
        }

        .chart-card:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chart-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chart-title-icon {
            font-size: 18px;
            color: var(--brand-color);
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--brand-light);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        .chart-legend {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-color {
            width: 10px;
            height: 10px;
            border-radius: 3px;
        }

        .legend-color.rainy-zone {
            background-color: var(--accent-rainy-bg);
            border: 1px dashed var(--accent-rainy);
        }
        .legend-color.bookings-line {
            background-color: var(--brand-color);
            height: 3px;
            width: 16px;
        }

        .svg-container {
            width: 100%;
            height: 320px;
            position: relative;
            margin-top: 10px;
        }

        /* Tooltips for SVG Chart */
        .chart-tooltip {
            position: absolute;
            background: var(--surface-color-solid);
            color: var(--text-dark);
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 12px;
            pointer-events: none;
            display: none;
            z-index: 100;
            box-shadow: var(--shadow-lg);
            flex-direction: column;
            gap: 4px;
            border: 1px solid var(--border-color);
            transition: all 0.15s ease-out;
        }

        .chart-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: var(--surface-color-solid) transparent transparent transparent;
        }

        .tooltip-title {
            font-weight: 800;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 4px;
            margin-bottom: 4px;
            color: var(--brand-color);
        }

        /* Two-Column Distribution Row */
        .analysis-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Service demand bar lists */
        .distribution-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 10px;
        }

        .distribution-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .dist-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .dist-type-name {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dist-type-count {
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .dist-bar-bg {
            height: 8px;
            background-color: var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .dist-bar-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--brand-color), var(--accent-blue));
            transition: width 0.5s ease-in-out;
        }

        .dist-bar-fill.rainy-fill {
            background: linear-gradient(90deg, var(--accent-rainy), #38bdf8);
        }

        /* ── Recommendations Card ── */
        .recommendation-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 30px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: box-shadow var(--transition-speed);
        }

        .recommendation-card:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        .rec-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .rec-item {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-speed) ease;
        }

        .rec-item:hover {
            transform: translateX(4px);
            box-shadow: var(--shadow-md);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .rec-icon {
            width: 36px;
            height: 36px;
            background-color: var(--accent-orange-bg);
            color: var(--accent-orange);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
            border: 1px solid var(--accent-orange-border);
        }

        .rec-icon.rain {
            background-color: var(--accent-rainy-bg);
            color: var(--accent-rainy);
            border: 1px solid var(--accent-rainy-border);
        }

        .rec-content {
            font-size: 14px;
            color: var(--text-main);
            line-height: 1.5;
            font-weight: 500;
        }

        .rec-content strong {
            color: var(--text-dark);
            font-weight: 700;
        }

        /* Monthly breakdown table */
        .table-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            transition: box-shadow var(--transition-speed);
        }

        .table-card:hover {
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }

        .table-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--text-dark);
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
        }

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

        .analysis-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .analysis-table th {
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .analysis-table td {
            padding: 16px 16px;
            font-size: 13.5px;
            color: var(--text-main);
            border-bottom: 1px solid rgba(226, 232, 240, 0.4);
            vertical-align: middle;
        }

        .analysis-table tbody tr {
            transition: all 0.2s ease;
        }

        .analysis-table tbody tr:hover {
            background-color: var(--hover-color);
        }

        .analysis-table tr:last-child td {
            border-bottom: none;
        }

        .season-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        .season-badge.rainy {
            background-color: var(--accent-rainy-bg);
            color: var(--accent-rainy);
            border: 1px solid var(--accent-rainy-border);
        }

        .season-badge.dry {
            background-color: var(--accent-orange-bg);
            color: var(--accent-orange);
            border: 1px solid var(--accent-orange-border);
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
            .sidebar, .main-header, .control-panel, .btn-export, .sidebar-overlay {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .content-container {
                padding: 0 !important;
                gap: 20px !important;
            }
            .chart-card, .stats-card, .analysis-row > div, .recommendation-card, .table-card {
                border: 1px solid #ccc !important;
                box-shadow: none !important;
                page-break-inside: avoid;
            }
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .analysis-row {
                grid-template-columns: 1fr;
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
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .control-panel {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
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
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .header-filters {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
            .chart-wrapper, .chart-container {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
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
            .profile-dropdown-menu {
                position: absolute;
                top: 52px;
                right: 0;
                left: auto;
                width: 240px;
                max-width: calc(100vw - 32px);
            }
            .notification-dropdown-menu {
                position: absolute;
                top: 52px;
                right: 0;
                left: auto;
                width: 280px;
                max-width: calc(100vw - 32px);
            }
        }

        /* ══════════════════ SEASONAL ANIMATIONS CSS ══════════════════ */
        .seasonal-anim-layer {
            pointer-events: none;
        }

        /* Monsoon Animations */
        @keyframes rain-fall {
            0% { transform: translateY(0); opacity: 0; }
            10% { opacity: 0.7; }
            90% { opacity: 0.7; }
            100% { transform: translateY(170px); opacity: 0; }
        }
        
        .rain-streak {
            stroke: #38bdf8;
            stroke-width: 1.5;
            animation: rain-fall 0.8s linear infinite;
        }

        .rain-delay-1 { animation-delay: 0s; }
        .rain-delay-2 { animation-delay: 0.15s; }
        .rain-delay-3 { animation-delay: 0.3s; }
        .rain-delay-4 { animation-delay: 0.45s; }
        .rain-delay-5 { animation-delay: 0.6s; }

        @keyframes rain-cycle {
            0%, 27%, 90%, 100% { opacity: 0; }
            32%, 85% { opacity: 1; }
        }
        
        .rain-layer {
            animation: rain-cycle 10s ease-in-out infinite;
        }

        @keyframes lightning-strike {
            0%, 19%, 21.5%, 23.5%, 26%, 28.5%, 31%, 100% { opacity: 0; }
            20%, 21% { opacity: 1; }
            24%, 25.5% { opacity: 1; }
            29%, 30.5% { opacity: 1; }
        }

        .lightning-bolt {
            stroke: url(#lightningGrad);
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: url(#lightning-glow);
            animation: lightning-strike 10s infinite;
        }

        @keyframes cloud-storm {
            0%, 100% { opacity: 0.35; transform: translateY(0) scale(1); }
            20% { opacity: 0.9; transform: translateY(1px) scale(1.02); }
            25% { filter: brightness(2) drop-shadow(0 4px 8px rgba(234, 179, 8, 0.4)); }
            27% { filter: none; opacity: 0.9; }
            29% { filter: brightness(2) drop-shadow(0 4px 8px rgba(234, 179, 8, 0.4)); }
            31% { filter: none; opacity: 0.9; }
            80% { opacity: 0.9; transform: translateY(1px) scale(1.02); }
        }

        .cloud-animate-1 {
            animation: cloud-storm 10s ease-in-out infinite;
            transform-origin: 122.5px 30px;
        }

        .cloud-animate-2 {
            animation: cloud-storm 10s ease-in-out infinite;
            transform-origin: 756.5px 30px;
        }

        @keyframes zone-flash {
            0%, 19%, 21.5%, 23.5%, 26%, 28.5%, 31%, 100% {
                fill: url(#rainyZoneGrad);
                stroke: rgba(2, 132, 199, 0.15);
            }
            20%, 21%, 24%, 25.5%, 29%, 30.5% {
                fill: rgba(14, 165, 233, 0.18);
                stroke: rgba(14, 165, 233, 0.5);
            }
        }

        .monsoon-rect-1, .monsoon-rect-2 {
            animation: zone-flash 10s infinite;
        }

        /* Dry Season Animations */
        @keyframes spin-rays {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse-sun {
            0%, 100% { transform: translate(459px, 65px) scale(0.95); }
            50% { transform: translate(459px, 65px) scale(1.1); }
        }

        .dry-sun-group {
            animation: pulse-sun 4s ease-in-out infinite;
            transform-origin: 459px 65px;
        }

        .sun-rays {
            animation: spin-rays 16s linear infinite;
            transform-origin: 0px 0px;
        }

        @keyframes float-particle {
            0% { transform: translate(var(--sx), 230px); opacity: 0; }
            15% { opacity: 0.6; }
            85% { opacity: 0.6; }
            100% { transform: translate(var(--ex), 60px); opacity: 0; }
        }

        .dry-particle {
            fill: #f97316;
            filter: drop-shadow(0 0 1px #fef08a);
            animation: float-particle 6s ease-in-out infinite;
        }

        .dry-particle.p1 { --sx: 260px; --ex: 290px; animation-delay: 0s; animation-duration: 5s; }
        .dry-particle.p2 { --sx: 350px; --ex: 330px; animation-delay: 1.5s; animation-duration: 7s; }
        .dry-particle.p3 { --sx: 420px; --ex: 460px; animation-delay: 0.8s; animation-duration: 6s; }
        .dry-particle.p4 { --sx: 530px; --ex: 500px; animation-delay: 2.2s; animation-duration: 5.5s; }
        .dry-particle.p5 { --sx: 640px; --ex: 670px; animation-delay: 3s; animation-duration: 6.5s; }
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

            <!-- 5. Plumber -->
            <a href="{{ route('staff.plumbers') }}" class="nav-item nav-link {{ request()->routeIs('staff.plumbers*') ? 'active' : '' }}">
                <i class="fa-solid fa-helmet-safety"></i>
                <span class="nav-link-text">Plumber</span>
            </a>

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
                    <h1>Trend & Seasonality Analysis</h1>
                    <p>Detect fluctuations in plumbing demands and plan resource allocation.</p>
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
        
        <!-- Dashboard Content Grid -->
        <main class="content-container">
            
            <!-- Control / Filter Panel -->
            <div class="control-panel">
                <form action="{{ route('staff.analytics') }}" method="GET" id="yearFilterForm" class="filter-group">
                    <label for="yearSelect" class="filter-label"><i class="fa-regular fa-calendar-days"></i> Select Analysis Year:</label>
                    <select name="year" id="yearSelect" class="year-select" onchange="document.getElementById('yearFilterForm').submit()">
                        @foreach($years as $yr)
                            <option value="{{ $yr }}" {{ $yr == $selectedYear ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </form>
                <button onclick="window.print()" class="btn-export">
                    <i class="fa-solid fa-print"></i> Print Report / PDF
                </button>
            </div>

            <!-- Metrics Row (4 Cards) -->
            <div class="stats-grid">
                
                <!-- Card 1: Annual Bookings -->
                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-card-title">Total Bookings</span>
                        <div class="stats-icon-wrapper blue"><i class="fa-solid fa-clipboard-list"></i></div>
                    </div>
                    <span class="stats-card-value">{{ sprintf("%02d", $totalBookings) }}</span>
                    <div class="stats-card-footer">
                        <span>For the year <strong>{{ $selectedYear }}</strong></span>
                    </div>
                </div>

                <!-- Card 2: Peak Demand Month -->
                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-card-title">Peak Demand Month</span>
                        <div class="stats-icon-wrapper orange"><i class="fa-solid fa-fire-flame-curved"></i></div>
                    </div>
                    <span class="stats-card-value" style="font-size:26px; padding-top:4px;">{{ $peakMonthName }}</span>
                    <div class="stats-card-footer">
                        <span>Volume: <strong>{{ $peakCount }} bookings</strong></span>
                    </div>
                </div>

                <!-- Card 3: Rainy Season Surge -->
                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-card-title">Monsoon Surge</span>
                        <div class="stats-icon-wrapper rainy"><i class="fa-solid fa-cloud-showers-heavy"></i></div>
                    </div>
                    <span class="stats-card-value" style="color:var(--accent-rainy);">+{{ round($seasonalSurge, 0) }}%</span>
                    <div class="stats-card-footer">
                        <span>Rainy vs Dry monthly average</span>
                    </div>
                </div>

                <!-- Card 4: Top Surged Service -->
                <div class="stats-card">
                    <div class="stats-card-header">
                        <span class="stats-card-title">Seasonality Spike</span>
                        <div class="stats-icon-wrapper green"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    </div>
                    <span class="stats-card-value" style="font-size:20px; color:var(--accent-green); padding-top:10px;">{{ $mostSurgedService }}</span>
                    <div class="stats-card-footer">
                        <span>Spike: <strong>+{{ round($highestSurgeVal, 0) }}%</strong> in rainy season</span>
                    </div>
                </div>

            </div>

            <!-- Seasonality Curve Chart (Line/Area Custom SVG) -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title-group">
                        <div class="chart-title-icon"><i class="fa-solid fa-chart-area"></i></div>
                        <h2 class="chart-title">Monthly Demand Seasonality Profile ({{ $selectedYear }})</h2>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-color rainy-zone"></div>
                            <span>Rainy Season (Monsoon Period)</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color bookings-line"></div>
                            <span>Booking Quantity</span>
                        </div>
                    </div>
                </div>
                
                <div class="svg-container">
                    <svg viewBox="0 0 840 320" width="100%" height="100%" style="overflow: visible;">
                        <!-- Defs for gradients -->
                        <defs>
                            <linearGradient id="areaGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#2563eb" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#2563eb" stop-opacity="0.0"/>
                            </linearGradient>
                            <linearGradient id="rainyZoneGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#0284c7" stop-opacity="0.06"/>
                                <stop offset="100%" stop-color="#0284c7" stop-opacity="0.01"/>
                            </linearGradient>

                            <!-- New Season gradients and filters -->
                            <linearGradient id="dryZoneGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#f97316" stop-opacity="0.04"/>
                                <stop offset="100%" stop-color="#f97316" stop-opacity="0.0"/>
                            </linearGradient>

                            <linearGradient id="cloudGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#94a3b8" />
                                <stop offset="60%" stop-color="#475569" />
                                <stop offset="100%" stop-color="#334155" />
                            </linearGradient>

                            <linearGradient id="lightningGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#eab308" />
                                <stop offset="100%" stop-color="#ca8a04" />
                            </linearGradient>

                            <linearGradient id="sunGrad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#fef08a" />
                                <stop offset="100%" stop-color="#f97316" />
                            </linearGradient>

                            <filter id="cloud-shadow" x="-30%" y="-30%" width="160%" height="160%">
                                <feDropShadow dx="0" dy="3" stdDeviation="3" flood-color="#0f172a" flood-opacity="0.12" />
                            </filter>

                            <filter id="lightning-glow" x="-50%" y="-50%" width="200%" height="200%">
                                <feGaussianBlur stdDeviation="3" result="blur" />
                                <feColorMatrix type="matrix" values="
                                    1 0 0 0 0.9
                                    0 1 0 0 0.8
                                    0 0 1 0 0.1
                                    0 0 0 1 0" in="blur" result="glow"/>
                                <feMerge>
                                    <feMergeNode in="glow" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>

                            <filter id="sun-glow" x="-50%" y="-50%" width="200%" height="200%">
                                <feGaussianBlur stdDeviation="4" result="blur" />
                                <feMerge>
                                    <feMergeNode in="blur" />
                                    <feMergeNode in="SourceGraphic" />
                                </feMerge>
                            </filter>

                            <!-- Storm Cloud Path reusable definition -->
                            <path id="storm-cloud-path" d="M10,22 a11,11 0 0,1 18,-4 a13,13 0 0,1 24,2 a10,10 0 0,1 17,9 a8,8 0 0,1 -4,13 L10,42 a9,9 0 0,1 0,-20 Z" />

                            <!-- Reusable Storm Cloud Cluster (4 overlapping clouds) -->
                            <g id="storm-cloud-cluster">
                                <use href="#storm-cloud-path" fill="url(#cloudGrad)" filter="url(#cloud-shadow)" />
                                <use href="#storm-cloud-path" transform="translate(32, -4)" fill="url(#cloudGrad)" filter="url(#cloud-shadow)" />
                                <use href="#storm-cloud-path" transform="translate(14, 8)" fill="url(#cloudGrad)" filter="url(#cloud-shadow)" />
                                <use href="#storm-cloud-path" transform="translate(44, 6)" fill="url(#cloudGrad)" filter="url(#cloud-shadow)" />
                            </g>
                        </defs>

                        <!-- Rainy Season Background Shading (Nov, Dec, Jan, Feb, Mac) -->
                        <!-- Zone 1: January, February, March (x from 25 to 220) -->
                        <rect class="monsoon-rect-1" x="25" y="20" width="195" height="230" fill="url(#rainyZoneGrad)" stroke="rgba(2, 132, 199, 0.15)" stroke-dasharray="4,4"/>
                        <!-- Zone 2: November, December (x from 698 to 815) -->
                        <rect class="monsoon-rect-2" x="698" y="20" width="117" height="230" fill="url(#rainyZoneGrad)" stroke="rgba(2, 132, 199, 0.15)" stroke-dasharray="4,4"/>

                        <!-- Dry Season Background Shading (Apr - Oct) (x from 220 to 698) -->
                        <rect x="220" y="20" width="478" height="230" fill="url(#dryZoneGrad)" stroke="rgba(249, 115, 22, 0.08)" stroke-dasharray="4,4"/>
                        <text x="459" y="32" fill="#f97316" font-size="11" font-weight="700" opacity="0.8" text-anchor="middle" style="pointer-events: none;">☀️ DRY SEASON</text>

                        <!-- ==================== SEASONAL ANIMATIONS ==================== -->
                        <!-- Monsoon Zone 1 Animations -->
                        <g class="seasonal-anim-layer" style="pointer-events: none;">
                            <!-- Heavy Rain -->
                            <g class="rain-layer">
                                <line class="rain-streak rain-delay-1" x1="45" y1="55" x2="40" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="65" y1="55" x2="60" y2="70" />
                                <line class="rain-streak rain-delay-3" x1="85" y1="55" x2="80" y2="70" />
                                <line class="rain-streak rain-delay-4" x1="105" y1="55" x2="100" y2="70" />
                                <line class="rain-streak rain-delay-5" x1="125" y1="55" x2="120" y2="70" />
                                <line class="rain-streak rain-delay-1" x1="145" y1="55" x2="140" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="165" y1="55" x2="160" y2="70" />
                                <line class="rain-streak rain-delay-3" x1="185" y1="55" x2="180" y2="70" />
                                <line class="rain-streak rain-delay-4" x1="205" y1="55" x2="200" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="55" y1="55" x2="50" y2="70" />
                                <line class="rain-streak rain-delay-5" x1="95" y1="55" x2="90" y2="70" />
                                <line class="rain-streak rain-delay-1" x1="135" y1="55" x2="130" y2="70" />
                                <line class="rain-streak rain-delay-3" x1="175" y1="55" x2="170" y2="70" />
                            </g>
                            <!-- Lightning Bolt -->
                            <path class="lightning-bolt" d="M 122.5 65 L 107.5 95 L 122.5 95 L 105 135" />
                            <!-- Storm Clouds Cluster -->
                            <use href="#storm-cloud-cluster" x="67.5" y="30" class="cloud-animate-1" />
                        </g>

                        <!-- Monsoon Zone 2 Animations -->
                        <g class="seasonal-anim-layer" style="pointer-events: none;">
                            <!-- Heavy Rain -->
                            <g class="rain-layer">
                                <line class="rain-streak rain-delay-1" x1="705" y1="55" x2="700" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="720" y1="55" x2="715" y2="70" />
                                <line class="rain-streak rain-delay-3" x1="735" y1="55" x2="730" y2="70" />
                                <line class="rain-streak rain-delay-4" x1="750" y1="55" x2="745" y2="70" />
                                <line class="rain-streak rain-delay-5" x1="765" y1="55" x2="760" y2="70" />
                                <line class="rain-streak rain-delay-1" x1="780" y1="55" x2="775" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="795" y1="55" x2="790" y2="70" />
                                <line class="rain-streak rain-delay-3" x1="710" y1="55" x2="705" y2="70" />
                                <line class="rain-streak rain-delay-5" x1="740" y1="55" x2="735" y2="70" />
                                <line class="rain-streak rain-delay-2" x1="770" y1="55" x2="765" y2="70" />
                                <line class="rain-streak rain-delay-4" x1="785" y1="55" x2="780" y2="70" />
                            </g>
                            <!-- Lightning Bolt -->
                            <path class="lightning-bolt" d="M 756.5 65 L 741.5 95 L 756.5 95 L 739 135" />
                            <!-- Storm Clouds Cluster -->
                            <use href="#storm-cloud-cluster" x="701.5" y="30" class="cloud-animate-2" />
                        </g>

                        <!-- Dry Season Zone Animations -->
                        <g class="seasonal-anim-layer" style="pointer-events: none;">
                            <!-- Floating Warm Dust/Solar Particles -->
                            <g class="dry-particles">
                                <circle class="dry-particle p1" r="2" />
                                <circle class="dry-particle p2" r="1.5" />
                                <circle class="dry-particle p3" r="2.5" />
                                <circle class="dry-particle p4" r="1.8" />
                                <circle class="dry-particle p5" r="2" />
                            </g>
                            <!-- Glowing rotating Sun -->
                            <g class="dry-sun-group">
                                <!-- Sun rays -->
                                <g class="sun-rays">
                                    <line x1="0" y1="-18" x2="0" y2="-12" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="0" y1="12" x2="0" y2="18" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="-18" y1="0" x2="-12" y2="0" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="12" y1="0" x2="18" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="-13" y1="-13" x2="-9" y2="-9" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="9" y1="9" x2="13" y2="13" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="13" y1="-13" x2="9" y2="-9" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="-9" y1="9" x2="-13" y2="13" stroke="#f97316" stroke-width="2" stroke-linecap="round"/>
                                </g>
                                <!-- Sun core -->
                                <circle cx="0" cy="0" r="8" fill="url(#sunGrad)" filter="url(#sun-glow)"/>
                            </g>
                        </g>

                        <!-- Monsoon Titles in Foreground (rendered after storm clouds) -->
                        <text x="122.5" y="32" fill="#0284c7" font-size="11" font-weight="700" opacity="0.8" text-anchor="middle" style="pointer-events: none;">☔ MONSOON</text>
                        <text x="756.5" y="32" fill="#0284c7" font-size="11" font-weight="700" opacity="0.8" text-anchor="middle" style="pointer-events: none;">☔ MONSOON</text>

                        <!-- Horizontal Grid Lines -->
                        @for($i = 0; $i <= 4; $i++)
                            @php 
                                $y = 50 + $i * 50; 
                                $val = round(($peakCount > 0 ? $peakCount : 10) * (1 - $i * 0.25));
                            @endphp
                            <line x1="50" y1="{{ $y }}" x2="800" y2="{{ $y }}" stroke="#f1f5f9" stroke-width="1"/>
                            <text x="25" y="{{ $y + 4 }}" fill="#94a3b8" font-size="11" text-anchor="end" font-weight="600">{{ $val }}</text>
                        @endfor

                        <!-- X Axis Line -->
                        <line x1="50" y1="250" x2="800" y2="250" stroke="#cbd5e1" stroke-width="1"/>

                        <!-- Calculate SVG coordinates for 12 months -->
                        @php
                            $points = [];
                            $areaPoints = ["50,250"];
                            for($m = 1; $m <= 12; $m++) {
                                $x = 50 + ($m - 1) * 68.18; // Spacing out 12 points
                                $count = $chartData[$m]['count'];
                                $yMaxCount = $peakCount > 0 ? $peakCount : 10;
                                $y = 250 - ($count / $yMaxCount) * 200;
                                $points[] = "$x,$y";
                                $areaPoints[] = "$x,$y";
                            }
                            $areaPoints[] = "800,250";
                            $pointString = implode(' ', $points);
                            $areaString = implode(' ', $areaPoints);
                        @endphp

                        <!-- Area Fill -->
                        <polygon points="{{ $areaString }}" fill="url(#areaGradient)"/>

                        <!-- Line Path -->
                        <polyline points="{{ $pointString }}" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                        <!-- Interactive Dots & Labels -->
                        @foreach($chartData as $m => $data)
                            @php
                                $coords = explode(',', $points[$m - 1]);
                                $cx = $coords[0];
                                $cy = $coords[1];
                                $dotColor = $data['is_rainy'] ? '#0284c7' : '#2563eb';
                            @endphp
                            
                            <!-- Vertical Guideline on hover (via CSS) -->
                            <line x1="{{ $cx }}" y1="50" x2="{{ $cx }}" y2="250" stroke="#dbeafe" stroke-dasharray="2,2" opacity="0" class="hover-line-{{ $m }}" style="pointer-events:none; transition: opacity 0.15s;"/>
                            
                            <!-- Month Name Label -->
                            <text x="{{ $cx }}" y="275" fill="{{ $data['is_rainy'] ? '#0284c7' : '#94a3b8' }}" font-size="11" font-weight="700" text-anchor="middle">
                                {{ $data['name'] }}
                            </text>
                            
                            <!-- Dot -->
                            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="5" fill="{{ $dotColor }}" stroke="#ffffff" stroke-width="2" style="cursor: pointer; transition: r 0.15s;" 
                                    onmouseover="showTooltip(event, '{{ $data['full_name'] }}', {{ $data['count'] }}, {{ $data['completed'] }}, {{ $data['cancelled'] }}, {{ $m }})"
                                    onmouseout="hideTooltip({{ $m }})"/>
                        @endforeach
                    </svg>

                    <!-- HTML Chart Tooltip box -->
                    <div id="chartTooltip" class="chart-tooltip"></div>
                </div>
            </div>

            <!-- Bottom Row: Service Type Share Comparative + Resource Recommendations -->
            <div class="analysis-row">
                
                <!-- Left: Service Demands (Rainy vs Dry Season Mix) -->
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <div class="chart-title-icon"><i class="fa-solid fa-arrows-split-up-and-left"></i></div>
                            <h2 class="chart-title">Demand Mix Comparison by Season</h2>
                        </div>
                    </div>
                    
                    <div class="tab-bar" style="display:flex; border-bottom:1px solid var(--border-color); padding-bottom:12px; gap:12px;">
                        <button class="year-select" style="background-color:var(--accent-rainy-bg); color:var(--accent-rainy); border-color:var(--accent-rainy);" onclick="toggleSeason('rainy')">
                            🌧️ Rainy Season Mix (Nov - Mar)
                        </button>
                        <button class="year-select" style="background-color:var(--hover-color); color:var(--text-main);" onclick="toggleSeason('dry')">
                            ☀️ Dry Season Mix (Apr - Oct)
                        </button>
                    </div>

                    <!-- Rainy Season List -->
                    <div class="distribution-list" id="rainyMixList">
                        @foreach($rainyTypeCounts as $type => $count)
                            @php
                                $totalRainyTypeCount = array_sum($rainyTypeCounts);
                                $pct = $totalRainyTypeCount > 0 ? ($count / $totalRainyTypeCount) * 100 : 0;
                            @endphp
                            <div class="distribution-item">
                                <div class="dist-meta">
                                    <span class="dist-type-name">{{ $type }}</span>
                                    <span class="dist-type-count">{{ $count }} calls ({{ round($pct, 1) }}%)</span>
                                </div>
                                <div class="dist-bar-bg">
                                    <div class="dist-bar-fill rainy-fill" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dry Season List (hidden by default) -->
                    <div class="distribution-list" id="dryMixList" style="display:none;">
                        @foreach($dryTypeCounts as $type => $count)
                            @php
                                $totalDryTypeCount = array_sum($dryTypeCounts);
                                $pct = $totalDryTypeCount > 0 ? ($count / $totalDryTypeCount) * 100 : 0;
                            @endphp
                            <div class="distribution-item">
                                <div class="dist-meta">
                                    <span class="dist-type-name">{{ $type }}</span>
                                    <span class="dist-type-count">{{ $count }} calls ({{ round($pct, 1) }}%)</span>
                                </div>
                                <div class="dist-bar-bg">
                                    <div class="dist-bar-fill" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Automated Resource Allocation Advisory -->
                <div class="recommendation-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <div class="chart-title-icon" style="color:var(--accent-orange);"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                            <h2 class="chart-title" style="color:var(--text-dark);">AI Resource Allocation Advisory</h2>
                        </div>
                        <span class="season-badge rainy"><i class="fa-solid fa-circle-check"></i> System Evaluation Live</span>
                    </div>
                    
                    <p style="font-size:13.5px; color:var(--text-muted); margin-top:-10px; line-height:1.4;">
                        Our analytics has computed these dynamic recommendations based on database booking frequencies and month-over-month growth patterns.
                    </p>

                    <div class="rec-grid">
                        @foreach($recommendations as $rec)
                            <div class="rec-item">
                                <div class="rec-icon"><i class="fa-solid fa-umbrella"></i></div>
                                <div class="rec-content">
                                    {!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $rec['text']) !!}
                                </div>
                            </div>
                        @endforeach

                        @foreach($generalRecs as $gRec)
                            <div class="rec-item">
                                <div class="rec-icon rain"><i class="fa-solid fa-circle-info"></i></div>
                                <div class="rec-content">
                                    {!! preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $gRec) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Monthly Seasonality Breakdown Grid Table -->
            <div class="table-card">
                <h3 class="table-title"><i class="fa-solid fa-list-check" style="margin-right:8px;"></i> Month-by-Month Demand Profile</h3>
                <div class="table-container">
                    <table class="analysis-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Season</th>
                                <th>Total Bookings</th>
                                <th>Completed Jobs</th>
                                <th>Cancellations</th>
                                <th>Completion Rate</th>
                                <th>Demand Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chartData as $m => $data)
                                @php
                                    $rate = $data['count'] > 0 ? ($data['completed'] / $data['count']) * 100 : 0;
                                    $weight = $totalBookings > 0 ? ($data['count'] / $totalBookings) * 100 : 0;
                                @endphp
                                <tr>
                                    <td style="font-weight:700; color:var(--text-dark);">{{ $data['full_name'] }}</td>
                                    <td>
                                        @if($data['is_rainy'])
                                            <span class="season-badge rainy">🌧️ Rainy</span>
                                        @else
                                            <span class="season-badge dry">☀️ Dry</span>
                                        @endif
                                    </td>
                                    <td style="font-weight:700;">{{ $data['count'] }}</td>
                                    <td>{{ $data['completed'] }}</td>
                                    <td style="color:red;">{{ $data['cancelled'] }}</td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <span style="font-weight:600;">{{ round($rate, 0) }}%</span>
                                            <div style="width:40px; height:6px; background-color:var(--border-color); border-radius:3px; overflow:hidden;">
                                                <div style="height:100%; width:{{ $rate }}%; background-color:var(--accent-green);"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight:600; color:var(--text-muted);">{{ round($weight, 1) }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

            if (profileTriggerBtn && profileDropdownMenu) {
                profileTriggerBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('show');

                    const eMenu = document.getElementById('emailDropdownMenu');
                    const nMenu = document.getElementById('notificationDropdownMenu');
                    if (eMenu) eMenu.classList.remove('show');
                    if (nMenu) nMenu.classList.remove('show');
                });

                // Close dropdown if user clicks outside
                document.addEventListener('click', (e) => {
                    if (!profileTriggerBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.remove('show');
                    }
                });
            }
        });

        // Interactive Tooltip Functionality for SVG Chart
        function showTooltip(evt, monthName, total, completed, cancelled, mIndex) {
            const tooltip = document.getElementById('chartTooltip');
            if (!tooltip) return;

            // Show vertical line
            const line = document.querySelector(`.hover-line-${mIndex}`);
            if (line) line.style.opacity = '1';

            tooltip.style.display = 'flex';
            tooltip.innerHTML = `
                <div class="tooltip-title">${monthName}</div>
                <div>Bookings: <strong>${total}</strong></div>
                <div style="font-size:11px; opacity:0.9;">Completed: ${completed}</div>
                <div style="font-size:11px; color:#f87171;">Cancelled: ${cancelled}</div>
            `;

            // Position tooltip dynamically
            const containerRect = evt.target.ownerSVGElement.parentNode.getBoundingClientRect();
            const dotRect = evt.target.getBoundingClientRect();
            
            const tooltipX = dotRect.left - containerRect.left + (dotRect.width / 2) - (tooltip.offsetWidth / 2);
            const tooltipY = dotRect.top - containerRect.top - tooltip.offsetHeight - 8;

            tooltip.style.left = `${tooltipX}px`;
            tooltip.style.top = `${tooltipY}px`;
        }

        function hideTooltip(mIndex) {
            const tooltip = document.getElementById('chartTooltip');
            if (tooltip) tooltip.style.display = 'none';

            // Hide vertical line
            const line = document.querySelector(`.hover-line-${mIndex}`);
            if (line) line.style.opacity = '0';
        }

        // Toggle Season Tab Mix
        function toggleSeason(season) {
            const rainyMixList = document.getElementById('rainyMixList');
            const dryMixList = document.getElementById('dryMixList');
            const buttons = document.querySelectorAll('.tab-bar button');

            if (season === 'rainy') {
                rainyMixList.style.display = 'flex';
                dryMixList.style.display = 'none';
                buttons[0].style.borderColor = 'var(--accent-rainy)';
                buttons[0].style.color = 'var(--accent-rainy)';
                buttons[0].style.backgroundColor = 'var(--accent-rainy-bg)';
                
                buttons[1].style.borderColor = 'var(--border-color)';
                buttons[1].style.color = 'var(--text-main)';
                buttons[1].style.backgroundColor = 'var(--hover-color)';
            } else {
                rainyMixList.style.display = 'none';
                dryMixList.style.display = 'flex';
                buttons[1].style.borderColor = 'var(--brand-color)';
                buttons[1].style.color = 'var(--brand-color)';
                buttons[1].style.backgroundColor = 'var(--brand-light)';
                
                buttons[0].style.borderColor = 'var(--border-color)';
                buttons[0].style.color = 'var(--text-main)';
                buttons[0].style.backgroundColor = 'var(--hover-color)';
            }
        }
    </script>
</body>
</html>
