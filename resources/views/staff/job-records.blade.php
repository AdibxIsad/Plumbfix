<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Records — Plumbfix Staff</title>
    <meta name="description" content="Document completed jobs with cost and notes.">
    
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
            gap: 28px;
        
            min-width: 0;
            max-width: 100%;}

        /* Section Title */
        .section-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            margin-top: 8px;
            letter-spacing: -0.3px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border-color);
        }

        /* Pending records grid */
        .pending-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 12px;
        }

        .pending-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease, border-color var(--transition-speed);
        }

        .pending-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(79, 70, 229, 0.2);
        }

        .pending-card .type {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.2px;
        }

        .pending-card .meta {
            font-size: 13px;
            color: var(--text-main);
            line-height: 1.5;
            font-weight: 500;
        }

        .btn-create-record {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: var(--brand-gradient);
            color: #fff;
            padding: 9px 16px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
        }

        .btn-create-record:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(79, 70, 229, 0.25);
        }

        /* Table Design */
        .table-wrap {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            overflow-x: auto;
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

        .cost-val {
            font-size: 15px;
            font-weight: 800;
            color: var(--accent-green);
        }

        .notes-cell {
            font-size: 13px;
            color: var(--text-muted);
            min-width: 220px;
            max-width: 320px;
            white-space: normal;
            word-break: break-word;
            line-height: 1.5;
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

        .empty-state {
            text-align: center;
            padding: 50px 20px;
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
            .sidebar, .main-header, .filter-container, .btn-print-pdf, .sidebar-overlay, .pending-grid {
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
        }

        @media (max-width: 768px) {
            .filter-bar {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                gap: 8px;
                padding-bottom: 6px;
                margin-bottom: 12px;
            }
            .search-form, .filter-form {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                width: 100%;
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
            .table-wrap, .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                width: 100%;
            }
            table {
                min-width: 650px;
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
                justify-content: flex-end;
                width: 100%;
            }

            .profile-dropdown-menu,
            .notification-dropdown-menu {
                right: auto;
                left: 0;
                width: 100%;
            }
        }

        /* ══════════════════ TABS & BUSINESS REPORT STYLING ══════════════════ */
        .tabs-container {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            margin-bottom: 8px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 8px;
        }

        .tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px 12px 0 0;
            color: var(--text-main);
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 700;
            transition: all var(--transition-speed);
            cursor: pointer;
            border: none;
            background: none;
            border-bottom: 3px solid transparent;
            margin-bottom: -11px;
        }

        .tab-btn:hover {
            color: var(--brand-color);
            background-color: var(--hover-color);
        }

        .tab-btn.active {
            color: var(--brand-color);
            border-bottom: 3px solid var(--brand-color);
            font-weight: 800;
        }

        .report-section {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .report-card {
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
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .report-card::before {
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

        .report-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: var(--shadow-lg);
            border-color: var(--card-accent-color, rgba(79, 70, 229, 0.2));
        }

        .report-card:hover::before {
            opacity: 1;
        }

        .report-card.glow-effect {
            border: var(--glass-border);
            box-shadow: var(--glass-shadow), var(--shadow-sm);
        }
        
        .report-card.glow-effect:hover {
            border-color: var(--card-accent-color);
            box-shadow: 0 0 25px var(--card-hover-shadow-color);
        }

        .metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 2;
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
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .report-card:hover .metric-icon {
            transform: scale(1.1) rotate(5deg);
            background: var(--card-accent-color, var(--brand-color));
            color: white;
            box-shadow: 0 6px 16px var(--card-hover-shadow-color, rgba(79, 70, 229, 0.25));
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
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .metric-trend.up {
            color: var(--accent-green);
            background-color: var(--accent-green-bg);
            border-color: var(--accent-green-border);
        }

        .metric-trend.down {
            color: #ef4444;
            background-color: #fee2e2;
            border-color: rgba(239, 68, 68, 0.15);
        }

        .metric-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
            z-index: 2;
        }

        .metric-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -1px;
            line-height: 1;
        }

        .metric-desc {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .card-theme-indigo {
            --card-accent-color: #6366f1;
            --card-accent-light: #e0e7ff;
            --card-shadow-color: rgba(99, 102, 241, 0.1);
            --card-hover-shadow-color: rgba(99, 102, 241, 0.25);
        }

        .card-theme-orange {
            --card-accent-color: #f97316;
            --card-accent-light: #ffedd5;
            --card-shadow-color: rgba(249, 115, 22, 0.1);
            --card-hover-shadow-color: rgba(249, 115, 22, 0.25);
        }

        .card-theme-green {
            --card-accent-color: #10b981;
            --card-accent-light: #d1fae5;
            --card-shadow-color: rgba(16, 185, 129, 0.1);
            --card-hover-shadow-color: rgba(16, 185, 129, 0.25);
        }

        .report-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-top: 8px;
        }

        @media (max-width: 1024px) {
            .report-row {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.3px;
        }

        /* SVG Chart Design */
        .chart-container-svg {
            position: relative;
            width: 100%;
            height: 320px;
            margin-top: 10px;
            display: flex;
            flex-direction: column;
        }

        .chart-y-axis {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 40px;
            width: 65px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
            text-align: right;
            padding-right: 12px;
            border-right: 1px dashed var(--border-color);
        }

        .chart-y-value-label {
            line-height: 1;
        }

        .chart-plot-area {
            margin-left: 65px;
            margin-bottom: 40px;
            height: calc(100% - 40px);
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 0 10px;
        }

        .chart-grid-line {
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            border-top: 1px dashed var(--border-color);
            pointer-events: none;
            z-index: 1;
        }

        .chart-bar-wrapper {
            flex: 1;
            display: flex;
            align-items: flex-end;
            height: 100%;
            justify-content: center;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }

        .chart-bar-revenue {
            width: 16px;
            background: linear-gradient(180deg, var(--brand-color) 0%, rgba(99, 102, 241, 0.4) 100%) !important;
            border-radius: 4px 4px 0 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .chart-bar-bookings {
            width: 8px;
            background: linear-gradient(180deg, var(--accent-orange) 0%, rgba(245, 158, 11, 0.4) 100%) !important;
            border-radius: 2px 2px 0 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-left: 4px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .chart-bar-wrapper:hover .chart-bar-revenue {
            filter: brightness(1.15);
            box-shadow: 0 0 12px rgba(79, 70, 229, 0.3);
        }

        .chart-bar-wrapper:hover .chart-bar-bookings {
            filter: brightness(1.15);
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.3);
        }

        .chart-x-axis {
            margin-left: 65px;
            height: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
            border-top: 1px solid var(--border-color);
        }

        .chart-x-label {
            flex: 1;
            text-align: center;
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
        }

        .chart-tooltip {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 50%;
            transform: translateX(-50%) scale(0.9);
            background: var(--text-dark);
            color: white;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .chart-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 5px;
            border-style: solid;
            border-color: var(--text-dark) transparent transparent transparent;
        }

        .chart-bar-wrapper:hover .chart-tooltip {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }

        .chart-legend {
            display: flex;
            gap: 16px;
            justify-content: center;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-main);
            margin-top: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 4px;
        }

        .satisfaction-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .score-circle-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            padding: 10px 0;
        }

        .score-number {
            font-size: 48px;
            font-weight: 800;
            color: var(--brand-color);
            letter-spacing: -1.5px;
            line-height: 1;
        }

        .stars-container {
            display: flex;
            gap: 4px;
            color: #f59e0b;
            font-size: 16px;
            margin-top: 4px;
        }

        .rating-bars-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }

        .rating-bar-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-main);
        }

        .rating-star-lbl {
            width: 45px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rating-bar-outer {
            flex: 1;
            height: 8px;
            background-color: var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .rating-bar-inner {
            height: 100%;
            background-color: #f59e0b !important;
            border-radius: 4px;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .rating-percent-lbl {
            width: 35px;
            text-align: right;
            font-size: 11px;
            color: var(--text-muted);
        }

        .report-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 8px;
        }

        .btn-export-pdf {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 800;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.15);
            text-decoration: none;
        }

        .btn-export-pdf:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(239, 68, 68, 0.25);
        }

        .print-only-header {
            display: none;
        }

        /* ── Professional Executive Print Overrides ── */
        @media print {
            @page {
                margin: 15mm 20mm 15mm 20mm;
            }

            body {
                background: #ffffff !important;
                color: #0f172a !important;
                font-family: 'Outfit', 'Helvetica Neue', Arial, sans-serif !important;
                padding: 0 !important;
                margin: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .mesh-bg, .sidebar-overlay, .sidebar, .main-header, .tabs-container, .report-actions, .search-container, .pagination-wrapper {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .content {
                padding: 0 !important;
                margin: 0 !important;
            }

            /* Elegant Cover Header for Executive Report */
            .print-only-header {
                display: block !important;
                border-bottom: 2px solid #0f172a !important;
                padding-bottom: 12px !important;
                margin-bottom: 24px !important;
            }

            .print-only-header-title {
                font-size: 24px !important;
                font-weight: 800 !important;
                text-transform: uppercase;
                color: #0f172a !important;
                margin: 0 0 6px 0 !important;
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
            }

            .print-only-header-meta {
                font-size: 12px !important;
                color: #475569 !important;
                font-weight: 600 !important;
                display: flex !important;
                justify-content: space-between !important;
            }

            /* Printable Metrics Grid */
            .report-grid {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 16px !important;
                margin-bottom: 24px !important;
            }

            .report-card {
                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 12px !important;
                padding: 16px !important;
                box-shadow: none !important;
                color: #0f172a !important;
                page-break-inside: avoid;
            }

            .report-card::before {
                display: none !important;
            }

            .metric-icon {
                background: #f1f5f9 !important;
                color: #0f172a !important;
                border: 1px solid #cbd5e1 !important;
                box-shadow: none !important;
            }

            .metric-trend {
                background: #f1f5f9 !important;
                border: 1px solid #cbd5e1 !important;
                color: #0f172a !important;
            }

            .metric-trend.up {
                color: #15803d !important;
                background: #dcfce7 !important;
                border-color: #bbf7d0 !important;
            }

            .metric-trend.down {
                color: #b91c1c !important;
                background: #fee2e2 !important;
                border-color: #fecaca !important;
            }

            .metric-value {
                color: #0f172a !important;
                font-size: 24px !important;
            }

            .metric-desc {
                color: #475569 !important;
            }

            /* Chart & Satisfaction side-by-side */
            .report-row {
                display: grid !important;
                grid-template-columns: 3fr 2fr !important;
                gap: 16px !important;
                page-break-inside: avoid;
            }

            .chart-card, .satisfaction-card {
                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 12px !important;
                padding: 16px !important;
                box-shadow: none !important;
                page-break-inside: avoid;
            }

            .chart-container-svg {
                border-color: #cbd5e1 !important;
            }

            .chart-grid-line {
                border-color: #f1f5f9 !important;
            }

            .chart-y-axis {
                border-color: #cbd5e1 !important;
                color: #475569 !important;
            }

            .chart-x-axis {
                border-color: #cbd5e1 !important;
            }

            .chart-x-label {
                color: #475569 !important;
            }

            .chart-bar-revenue {
                background: #4f46e5 !important;
            }

            .chart-bar-bookings {
                background: #f97316 !important;
            }

            .chart-tooltip {
                display: none !important;
            }

            .rating-bar-outer {
                background-color: #e2e8f0 !important;
            }

            .rating-bar-inner {
                background-color: #eab308 !important;
            }

            svg[style*="position:absolute"] {
                display: none !important;
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
                    @if($activeTab === 'report')
                        <h1>Business Performance Report</h1>
                        <p>Monitor monthly revenue, booking volume, and customer satisfaction</p>
                    @else
                        <h1>Job Records (Reports)</h1>
                        <p>Document completed jobs with cost and notes</p>
                    @endif
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
            @if(session('error'))<div class="alert-error">⚠️ {{ session('error') }}</div>@endif

            <div class="tabs-container">
                <a href="{{ route('staff.job-records', ['tab' => 'report']) }}" class="tab-btn {{ $activeTab === 'report' ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Generate Business Report</span>
                </a>
                <a href="{{ route('staff.job-records', ['tab' => 'records']) }}" class="tab-btn {{ $activeTab === 'records' ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>Job Records (Reports)</span>
                </a>
            </div>

            @if($activeTab === 'report')
                <!-- 📈 GENERATE BUSINESS REPORT TAB 📈 -->
                <!-- Print Only Header -->
                <div class="print-only-header">
                    <div class="print-only-header-title">
                        <i class="fa-solid fa-wrench" style="color:#4f46e5; margin-right: 8px;"></i>
                        Plumbfix Business Performance Report
                    </div>
                    <div class="print-only-header-meta">
                        <span><strong>Period:</strong> @if($reportData['selectedMonth'] !== '') {{ date('F', mktime(0, 0, 0, $reportData['selectedMonth'], 1)) }} @else All Months @endif {{ $reportData['selectedYear'] }}</span>
                        <span><strong>Generated by:</strong> {{ $staff->staffName }} (Admin)</span>
                        <span><strong>Date:</strong> {{ now()->format('d M Y h:i A') }}</span>
                    </div>
                </div>

                <div class="report-section">
                    <!-- PDF Action button -->
                    <div class="report-actions">
                        <button onclick="window.print()" class="btn-export-pdf">
                            <i class="fa-solid fa-file-pdf"></i>
                            <span>Export PDF</span>
                        </button>
                    </div>

                    <!-- Metrics Grid -->
                    <div class="report-grid">
                        
                        <!-- Card 1: Monthly Revenue -->
                        <div class="report-card card-theme-indigo glow-effect">
                            <!-- Background illustration: stacked coins -->
                            <svg style="position:absolute;bottom:-8px;right:-8px;width:115px;height:115px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="32" cy="14" rx="20" ry="7" fill="currentColor"/>
                                <rect x="12" y="14" width="40" height="7" fill="currentColor" opacity="0.85"/>
                                <ellipse cx="32" cy="21" rx="20" ry="7" fill="currentColor" opacity="0.85"/>
                                <rect x="12" y="21" width="40" height="7" fill="currentColor" opacity="0.7"/>
                                <ellipse cx="32" cy="28" rx="20" ry="7" fill="currentColor" opacity="0.7"/>
                                <rect x="12" y="28" width="40" height="7" fill="currentColor" opacity="0.55"/>
                                <ellipse cx="32" cy="35" rx="20" ry="7" fill="currentColor" opacity="0.55"/>
                                <text x="22" y="16" font-size="8" font-weight="bold" fill="white" font-family="sans-serif">RM</text>
                            </svg>
                            <div class="metric-header">
                                <div class="metric-title-group">
                                    <div class="metric-icon"><i class="fa-solid fa-coins"></i></div>
                                    <span class="metric-title">Monthly Revenue</span>
                                </div>
                                <span class="metric-trend {{ $reportData['revenueGrowth'] >= 0 ? 'up' : 'down' }}">
                                    <i class="fa-solid {{ $reportData['revenueGrowth'] >= 0 ? 'fa-caret-up' : 'fa-caret-down' }}"></i>
                                    {{ ($reportData['revenueGrowth'] >= 0 ? '+' : '') . number_format($reportData['revenueGrowth'], 1) }}%
                                </span>
                            </div>
                            <div class="metric-body">
                                <span class="metric-value">RM {{ number_format($reportData['revenueThisMonth'], 2) }}</span>
                                <span class="metric-desc">Cumulative: <strong>RM {{ number_format($reportData['totalRevenueAllTime'], 2) }}</strong></span>
                            </div>
                        </div>

                        <!-- Card 2: Bookings Volume -->
                        <div class="report-card card-theme-orange">
                            <!-- Background illustration: calendar -->
                            <svg style="position:absolute;bottom:-8px;right:-8px;width:115px;height:115px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <rect x="8" y="12" width="48" height="44" rx="4"/>
                                <line x1="8" y1="24" x2="56" y2="24"/>
                                <line x1="20" y1="6" x2="20" y2="14"/>
                                <line x1="44" y1="6" x2="44" y2="14"/>
                                <circle cx="20" cy="36" r="2" fill="currentColor"/>
                                <circle cx="32" cy="36" r="2" fill="currentColor"/>
                                <circle cx="44" cy="36" r="2" fill="currentColor"/>
                                <circle cx="20" cy="46" r="2" fill="currentColor"/>
                                <circle cx="32" cy="46" r="2" fill="currentColor"/>
                                <circle cx="44" cy="46" r="2" fill="currentColor"/>
                            </svg>
                            <div class="metric-header">
                                <div class="metric-title-group">
                                    <div class="metric-icon"><i class="fa-regular fa-calendar-check"></i></div>
                                    <span class="metric-title">Bookings Volume</span>
                                </div>
                                <span class="metric-trend up" style="color:var(--brand-color); background-color:var(--brand-light); border-color:rgba(79, 70, 229, 0.15)">
                                    <i class="fa-solid fa-calendar-check"></i> Total: {{ $reportData['bookingsCount'] }}
                                </span>
                            </div>
                            <div class="metric-body">
                                <span class="metric-value">{{ sprintf("%02d", $reportData['bookingsCount']) }}</span>
                                <span class="metric-desc">
                                    <span class="type-badge" style="background-color:#ecfdf5; border-color:rgba(16,185,129,0.15); color:#059669; padding:2px 6px; font-size:11px;">{{ $reportData['bookingsCompleted'] }} Completed</span>
                                    <span class="type-badge" style="background-color:#eff6ff; border-color:rgba(59,130,246,0.15); color:#2563eb; padding:2px 6px; font-size:11px;">{{ $reportData['bookingsPending'] }} Pending</span>
                                </span>
                            </div>
                        </div>

                        <!-- Card 3: Satisfaction Rate -->
                        <div class="report-card card-theme-green">
                            <!-- Background illustration: smiley face -->
                            <svg style="position:absolute;bottom:-10px;right:-10px;width:120px;height:120px;opacity:0.08;pointer-events:none;" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="26"/>
                                <path d="M20 40 Q32 50 44 40"/>
                                <circle cx="22" cy="24" r="3" fill="currentColor"/>
                                <circle cx="42" cy="24" r="3" fill="currentColor"/>
                            </svg>
                            <div class="metric-header">
                                <div class="metric-title-group">
                                    <div class="metric-icon"><i class="fa-regular fa-face-smile"></i></div>
                                    <span class="metric-title">Satisfaction Rate</span>
                                </div>
                                <span class="metric-trend up">
                                    <i class="fa-solid fa-star"></i> {{ number_format($reportData['avgFeedbackRating'], 1) }} Avg
                                </span>
                            </div>
                            @php
                                $totalRatings = $reportData['satisfactionCount'];
                                $goodRatings = $reportData['ratingBreakdown'][5] + $reportData['ratingBreakdown'][4];
                                $satRate = $totalRatings > 0 ? ($goodRatings / $totalRatings * 100) : 100;
                            @endphp
                            <div class="metric-body">
                                <span class="metric-value">{{ number_format($satRate, 1) }}%</span>
                                <span class="metric-desc">Based on <strong>{{ $totalRatings }}</strong> review(s)</span>
                            </div>
                        </div>

                    </div>

                    <!-- Chart and Satisfaction Breakdown Row -->
                    <div class="report-row">
                        <!-- Chart Card -->
                        <div class="chart-card">
                            <div class="chart-header">
                                <div class="chart-title">Bookings & Revenue Trend</div>
                                <form action="{{ route('staff.job-records') }}" method="GET" style="display: flex; gap: 8px;" id="reportFilterForm">
                                    <input type="hidden" name="tab" value="report">
                                    <select name="report_month" onchange="document.getElementById('reportFilterForm').submit()" class="filter-select" style="padding: 6px 12px; font-size: 13px; width: 130px;">
                                        <option value="">All Months</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $reportData['selectedMonth'] == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                        @endfor
                                    </select>
                                    <select name="report_year" onchange="document.getElementById('reportFilterForm').submit()" class="filter-select" style="padding: 6px 12px; font-size: 13px; width: 90px;">
                                        @foreach($reportData['reportYears'] as $ry)
                                            <option value="{{ $ry }}" {{ $reportData['selectedYear'] == $ry ? 'selected' : '' }}>{{ $ry }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <!-- SVG Chart -->
                            <div class="chart-container-svg">
                                <!-- Grid Lines -->
                                @for($i = 0; $i < 4; $i++)
                                    <div class="chart-grid-line" style="bottom: {{ 20 + $i * 20 }}%;"></div>
                                @endfor

                                <!-- Y Axis -->
                                <div class="chart-y-axis">
                                    <div class="chart-y-value-label">RM {{ number_format($reportData['chartMaxRevenue']) }}</div>
                                    <div class="chart-y-value-label">RM {{ number_format($reportData['chartMaxRevenue'] * 0.75) }}</div>
                                    <div class="chart-y-value-label">RM {{ number_format($reportData['chartMaxRevenue'] * 0.5) }}</div>
                                    <div class="chart-y-value-label">RM {{ number_format($reportData['chartMaxRevenue'] * 0.25) }}</div>
                                    <div class="chart-y-value-label">RM 0</div>
                                </div>

                                <!-- Plot Area -->
                                <div class="chart-plot-area">
                                    @foreach($reportData['monthlyReportData'] as $monthNum => $data)
                                        @php
                                            $revPct = min(100, $reportData['chartMaxRevenue'] > 0 ? ($data['revenue'] / $reportData['chartMaxRevenue'] * 100) : 0);
                                            $bkPct = min(100, $reportData['chartMaxBookings'] > 0 ? ($data['bookings'] / $reportData['chartMaxBookings'] * 100) : 0);
                                        @endphp
                                        <div class="chart-bar-wrapper">
                                            <div class="chart-tooltip">
                                                <span style="font-weight: 800; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 2px; margin-bottom: 4px;">{{ $data['month_name'] }} {{ $reportData['selectedYear'] }}</span>
                                                <span>💰 Revenue: <strong>RM {{ number_format($data['revenue'], 2) }}</strong></span>
                                                <span>📅 Bookings: <strong>{{ $data['bookings'] }}</strong></span>
                                            </div>
                                            <div class="chart-bar-revenue" style="height: {{ max(4, $revPct) }}%;"></div>
                                            <div class="chart-bar-bookings" style="height: {{ max(4, $bkPct) }}%;"></div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- X Axis -->
                                <div class="chart-x-axis">
                                    @foreach($reportData['monthlyReportData'] as $monthNum => $data)
                                        <div class="chart-x-label">{{ $data['month_name'] }}</div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Legend -->
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <div class="legend-dot" style="background: var(--brand-color);"></div>
                                    <span>Revenue (RM)</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-dot" style="background: var(--accent-orange);"></div>
                                    <span>Bookings Count</span>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback Score Breakdown Card -->
                        <div class="satisfaction-card">
                            <div class="chart-title">Customer Feedback Breakdown</div>
                            <div class="score-circle-container">
                                <div style="text-align: center;">
                                    <div class="score-number">{{ number_format($reportData['avgFeedbackRating'], 1) }}</div>
                                    <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:var(--text-muted); margin-top:4px;">Out of 5 Stars</div>
                                </div>
                                <div style="flex: 1;">
                                    <div class="stars-container">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($reportData['avgFeedbackRating']))
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div style="font-size:12.5px; color:var(--text-main); font-weight:600; margin-top:6px;">
                                        Based on {{ $reportData['satisfactionCount'] }} customer review(s)
                                    </div>
                                </div>
                            </div>

                            <!-- Rating Bars List -->
                            <div class="rating-bars-list">
                                @for($star = 5; $star >= 1; $star--)
                                    @php
                                        $count = $reportData['ratingBreakdown'][$star] ?? 0;
                                        $pct = $reportData['satisfactionCount'] > 0 ? ($count / $reportData['satisfactionCount'] * 100) : 0;
                                    @endphp
                                    <div class="rating-bar-row">
                                        <div class="rating-star-lbl">
                                            <span>{{ $star }}</span>
                                            <i class="fa-solid fa-star" style="color:#f59e0b; font-size:11px;"></i>
                                        </div>
                                        <div class="rating-bar-outer">
                                            <div class="rating-bar-inner" style="width: {{ $pct }}%;"></div>
                                        </div>
                                        <div class="rating-percent-lbl">{{ $count }}</div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- 📋 JOB RECORDS TAB 📋 -->
                <!-- Completed bookings awaiting a record -->
                @if($completedWithoutRecord->isNotEmpty())
                <div class="section-title">⚡ Completed Jobs — Awaiting Record</div>
                <div class="pending-grid">
                    @foreach($completedWithoutRecord as $b)
                    <div class="pending-card">
                        <div class="type">{{ $b->bookingType }}</div>
                        <div class="meta">
                            {{ $b->bookingProblem }}<br>
                            📅 {{ \Carbon\Carbon::parse($b->bookingDate)->format('d M Y') }}
                            · 🕐 {{ \Carbon\Carbon::parse($b->bookingTime)->format('h:i A') }}
                        </div>
                        <a href="{{ route('staff.job-record.create', $b->bookingID) }}" class="btn-create-record">📝 Add Job Record</a>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- All job records -->
                <div class="section-title">📋 All Job Records</div>

                <!-- Search and Filter Panel -->
                <div class="search-container">
                    <form action="{{ route('staff.job-records') }}" method="GET" class="search-form" id="searchForm">
                        <input type="hidden" name="tab" value="records">
                        <input type="text" name="search" class="search-input" placeholder="Search by Booking ID or Customer Name..." value="{{ request('search') }}">
                        
                        <!-- Year, Month, Day Filter Selects -->
                        <select name="year" class="filter-select" style="width: 100px;">
                            <option value="">Year</option>
                            @for($y = date('Y') + 1; $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>

                        <select name="month" class="filter-select" style="width: 120px;">
                            <option value="">Month</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
                        </select>

                        <select name="day" class="filter-select" style="width: 90px;">
                            <option value="">Day</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>{{ sprintf('%02d', $d) }}</option>
                            @endfor
                        </select>

                        <button type="submit" class="btn-search">Search</button>
                        @if (request()->filled('search') || request()->filled('year') || request()->filled('month') || request()->filled('day'))
                            <a href="{{ route('staff.job-records', ['tab' => 'records']) }}" class="btn-reset">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="table-wrap">
                    @if($jobRecords->isEmpty())
                        <div class="empty-state">
                            <div class="icon">📂</div>
                            <p>No job records yet. Complete a booking and add a record to get started.</p>
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Booking</th>
                                    <th>Customer</th>
                                    <th>Plumber</th>
                                    <th>Completion Date</th>
                                    <th>Total Cost</th>
                                    <th>Notes</th>
                                    <th>Photos</th>
                                    <th>Recorded</th>
                                    <th style="text-align: center;">Report</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobRecords as $jr)
                                <tr>
                                    <td style="color:var(--text-muted);font-size:12px;">#{{ $jr->jobRecordID }}</td>
                                    <td>
                                        @if($jr->booking)
                                        <div><span class="type-badge">{{ $jr->booking->service_icon }} {{ $jr->booking->bookingType }}</span></div>
                                        <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ $jr->booking->bookingProblem }}</div>
                                        @else <span style="color:var(--text-muted);">—</span> @endif
                                    </td>
                                    <td>
                                        @if($jr->booking?->customer)
                                            <div style="font-weight:600;font-size:14px;color:var(--text-dark);">{{ $jr->booking->customer->customerName }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);">{{ $jr->booking->customer->customerEmail }}</div>
                                        @else <span style="color:var(--text-muted);">—</span> @endif
                                    </td>
                                    <td>
                                        @if($jr->staff)
                                            <div style="font-weight:600;font-size:14px;color:var(--text-dark);">{{ $jr->staff->staffName }}</div>
                                            <div style="font-size:12px;color:var(--text-muted);">ID: #{{ $jr->staffID }}</div>
                                        @else
                                            <span style="color:var(--text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td style="color:var(--text-muted);">
                                        {{ $jr->jobRecordCompletionDate ? $jr->jobRecordCompletionDate->format('d M Y') : '—' }}
                                    </td>
                                    <td><span class="cost-val">RM {{ number_format($jr->jobRecordTotalCost, 2) }}</span></td>
                                    <td><span class="notes-cell" title="{{ $jr->jobRecordNotes }}">{{ $jr->jobRecordNotes ?? '—' }}</span></td>
                                    <td>
                                        @if($jr->jobRecordAttachments && count($jr->jobRecordAttachments) > 0)
                                            <div style="display: flex; gap: 6px;">
                                                @foreach($jr->jobRecordAttachments as $attachment)
                                                    <a href="javascript:void(0)" class="lightbox-trigger" data-img-url="{{ asset($attachment) }}" style="display: block; width: 40px; height: 40px; border-radius: 6px; overflow: hidden; border: 1px solid var(--border-color);">
                                                        <img src="{{ asset($attachment) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span style="color:var(--text-muted);">—</span>
                                        @endif
                                    </td>
                                    <td style="color:var(--text-muted);font-size:13px;">{{ $jr->created_at->format('d M Y') }}</td>
                                    <td style="text-align: center; white-space: nowrap;">
                                        <a href="{{ route('staff.job-record.create', $jr->bookingID) }}" class="btn-print-pdf" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--surface-color); color: var(--accent-orange); text-decoration: none; transition: all 0.15s ease; margin-right: 4px;" onmouseover="this.style.backgroundColor='var(--accent-orange-bg)'; this.style.borderColor='var(--accent-orange)'" onmouseout="this.style.backgroundColor='var(--surface-color)'; this.style.borderColor='var(--border-color)'" title="Edit Record">
                                            <i class="fa-solid fa-pen-to-square" style="font-size: 15px;"></i>
                                        </a>
                                        <a href="{{ route('staff.job-record.print', $jr->jobRecordID) }}" target="_blank" class="btn-print-pdf" style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; border: 1px solid var(--border-color); background-color: var(--surface-color); color: var(--brand-color); text-decoration: none; transition: all 0.15s ease;" onmouseover="this.style.backgroundColor='var(--brand-light)'; this.style.borderColor='var(--brand-color)'" onmouseout="this.style.backgroundColor='var(--surface-color)'; this.style.borderColor='var(--border-color)'" title="Print Report (PDF)">
                                            <i class="fa-solid fa-file-pdf" style="font-size: 15px;"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Custom Pagination Links --}}
                @if ($jobRecords->hasPages())
                    <div class="pagination-wrapper">
                        {{-- Previous Page Link --}}
                        @if ($jobRecords->onFirstPage())
                            <span class="page-link disabled">&laquo; Prev</span>
                        @else
                            <a href="{{ $jobRecords->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($jobRecords->getUrlRange(max(1, $jobRecords->currentPage() - 2), min($jobRecords->lastPage(), $jobRecords->currentPage() + 2)) as $page => $url)
                            @if ($page == $jobRecords->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($jobRecords->hasMorePages())
                            <a href="{{ $jobRecords->nextPageUrl() }}" class="page-link">Next &raquo;</a>
                        @else
                            <span class="page-link disabled">Next &raquo;</span>
                        @endif
                    </div>
                @endif
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

            // Lightbox Modal Logic
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxContent = document.getElementById('lightboxContent');
            const closeLightboxBtn = document.getElementById('closeLightboxBtn');

            function openLightbox(imgUrl) {
                lightboxImg.src = imgUrl;
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
                }, 250);
            }

            document.querySelectorAll('.lightbox-trigger').forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = trigger.getAttribute('data-img-url') || trigger.getAttribute('href');
                    openLightbox(url);
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
        });
    </script>

    <!-- Lightbox Modal -->
    <div id="lightboxModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.25s ease;">
        <div style="position: relative; max-width: 90%; max-height: 90%; background: var(--surface-color); padding: 12px; border-radius: 16px; box-shadow: var(--shadow-lg); transform: scale(0.95); transition: transform 0.25s ease;" id="lightboxContent">
            <button id="closeLightboxBtn" style="position: absolute; top: -16px; right: -16px; width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--border-color); background: var(--surface-color); color: var(--text-dark); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: var(--shadow-md); font-size: 14px; transition: all 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-dark)'">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img id="lightboxImg" src="" style="max-width: 100%; max-height: calc(85vh); border-radius: 10px; display: block; object-fit: contain;">
        </div>
    </div>
</body>
</html>
