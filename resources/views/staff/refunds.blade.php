<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Management — Plumbfix Staff</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Futuristic Light Theme Palette */
            --bg-color: #f8fafc;
            --surface-color: rgba(255, 255, 255, 0.7);
            --surface-color-solid: #ffffff;
            --surface-card: #ffffff;
            --border-color: rgba(226, 232, 240, 0.8);
            --hover-color: rgba(241, 245, 249, 0.8);
            --text-dark: #0f172a;
            --text-main: #475569;
            --text-muted: #94a3b8;
            --brand-color: #4f46e5;
            --brand-light: #e0e7ff;
            --brand-dark: #312e81;
            --accent-green: #10b981;
            --accent-green-light: rgba(16, 185, 129, 0.1);
            --accent-red: #ef4444;
            --accent-red-light: rgba(239, 68, 68, 0.1);
            --accent-orange: #f59e0b;
            --accent-orange-light: rgba(245, 158, 11, 0.1);
            --sidebar-width: 270px;
            --sidebar-collapsed-width: 88px;
            
            --glass-blur: 16px;
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
            
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 25px -5px rgba(79, 70, 229, 0.04), 0 8px 10px -6px rgba(79, 70, 229, 0.04);
            --shadow-lg: 0 20px 32px -4px rgba(79, 70, 229, 0.08), 0 12px 14px -6px rgba(79, 70, 229, 0.04);
            --transition-speed: 0.3s;
            --font-outfit: 'Outfit', sans-serif;
            --font-sans: 'Outfit', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Mesh Backgrounds */
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
        @keyframes drift {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            50% { transform: translate(4%, 6%) scale(1.08) rotate(180deg); }
            100% { transform: translate(-2%, -4%) scale(0.96) rotate(360deg); }
        }

        /* Sidebar styles */
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
            height: calc(100vh - 40px);
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
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
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
        body.collapsed-sidebar-active .nav-item,
        body.collapsed-sidebar-active .nav-link,
        body.collapsed-sidebar-active .nav-dropdown-toggle {
            justify-content: center;
            padding: 12px;
            border-radius: 12px;
        }
        body.collapsed-sidebar-active .nav-item i,
        body.collapsed-sidebar-active .nav-link i,
        body.collapsed-sidebar-active .nav-dropdown-toggle i {
            margin: 0;
        }

        /* Main Wrapper */
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

        /* Content Area */
        .content {
            padding: 32px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 28px;
            min-width: 0;
            max-width: 100%;
        }

        /* Alert styling */
        .alert-success {
            background-color: var(--accent-green-light);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: #065f46;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
        }
        .alert-error {
            background-color: var(--accent-red-light);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #991b1b;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Filtering Layout */
        .filter-bar {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 18px 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
            box-shadow: var(--glass-shadow), var(--shadow-sm);
        }
        .filter-btn {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 10px 20px;
            border-radius: 14px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .filter-btn:hover, .filter-btn.active {
            background-color: var(--brand-color);
            color: white;
            border-color: var(--brand-color);
        }

        /* Search Form styling */
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
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 12px 20px;
            border-radius: 12px;
            font-family: var(--font-outfit);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-reset:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        /* Table layout */
        .table-wrap {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            overflow-x: auto;
            box-shadow: var(--glass-shadow), var(--shadow-md);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 1100px;
        }
        th {
            background-color: rgba(0, 0, 0, 0.02);
            padding: 18px 24px;
            font-family: var(--font-outfit);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }
        td {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-main);
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover td {
            background-color: var(--hover-color);
        }

        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .customer-name {
            font-weight: 700;
            color: var(--text-dark);
        }
        .customer-email {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-pending {
            background-color: var(--accent-orange-light);
            color: #c2410c;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }
        .status-refunded {
            background-color: var(--accent-green-light);
            color: #047857;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Buttons and actions */
        .btn-refund {
            background-color: var(--accent-green);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: var(--font-outfit);
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-refund:hover {
            background-color: #059669;
        }
        .btn-view-receipt {
            background-color: var(--brand-light);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: var(--brand-color);
            padding: 8px 16px;
            border-radius: 8px;
            font-family: var(--font-outfit);
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-view-receipt:hover {
            background-color: var(--brand-color);
            color: white;
        }

        /* Modal styling */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-card {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 28px;
            max-width: 500px;
            width: 90%;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes modalIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .modal-card h3 {
            font-family: var(--font-outfit);
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
        }
        .bank-details-box {
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .bank-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }
        .bank-row span.label {
            color: var(--text-muted);
            font-weight: 500;
        }
        .bank-row span.val {
            color: var(--text-dark);
            font-weight: 700;
            font-family: monospace;
            font-size: 14.5px;
        }
        .btn-copy {
            background: transparent;
            border: none;
            color: var(--brand-color);
            cursor: pointer;
            font-size: 13px;
            margin-left: 8px;
            transition: opacity 0.2s;
        }
        .btn-copy:hover {
            opacity: 0.8;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-input {
            width: 100%;
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-dark);
            font-family: inherit;
            font-size: 14px;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color-solid);
        }
        .modal-textarea {
            width: 100%;
            height: 80px;
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-dark);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            resize: none;
        }
        .modal-textarea:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color-solid);
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .btn-cancel {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 10px 20px;
            border-radius: 10px;
            font-family: var(--font-outfit);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-cancel:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        /* Lightbox styling */
        #lightboxModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s ease;
        }
        #lightboxContent {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            background: var(--surface-color-solid);
            padding: 12px;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            transform: scale(0.95);
            transition: transform 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
        }
        #closeLightboxBtn {
            position: absolute;
            top: -16px;
            right: -16px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: var(--surface-color-solid);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            font-size: 14px;
            transition: all 0.2s;
            z-index: 10001;
        }
        #lightboxImg {
            max-width: 100%;
            max-height: calc(85vh);
            border-radius: 10px;
            display: block;
            object-fit: contain;
        }
        #lightboxIframe {
            display: none;
            width: 80vw;
            height: 80vh;
            border: none;
            border-radius: 10px;
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
            .sidebar {
                left: 20px;
                transform: translateX(-120%);
                z-index: 1005;
                bottom: 20px;
                top: 20px;
                height: calc(100vh - 40px);
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
            #closeLightboxBtn {
                top: 8px;
                right: 8px;
            }
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
    </style>
</head>
<body>

    <!-- Motion Background -->
    <div class="mesh-bg">
        <div class="mesh-orb orb-1"></div>
        <div class="mesh-orb orb-2"></div>
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
        <header class="main-header">
            <div class="welcome-meta">
                <button class="mobile-hamburger" id="mobileHamburger" aria-label="Toggle Sidebar Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="welcome-text">
                    <h1>Refund Management</h1>
                    <p>Process and track manual bank refund transfers for cancelled bookings</p>
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
                        <div class="dropdown-header-role">Admin Staff</div>
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

        <main class="content">
            @if (session('success'))
                <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <!-- Search and Filter Panel -->
            <div class="search-container">
                <form action="{{ route('staff.refunds.index') }}" method="GET" class="search-form" id="searchForm">
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

                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <button type="submit" class="btn-search">Search</button>
                    @if (request()->filled('search') || request()->filled('status') || request()->filled('year') || request()->filled('month') || request()->filled('day'))
                        <a href="{{ route('staff.refunds.index') }}" class="btn-reset">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Status filter bar -->
            <div class="filter-bar">
                <a href="{{ route('staff.refunds.index', request()->has('search') ? ['search' => request('search')] : []) }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('staff.refunds.index', array_merge(request()->query(), ['status' => 'pending'])) }}" class="filter-btn {{ request('status') === 'pending' ? 'active' : '' }}">⏳ Pending Refunds</a>
                <a href="{{ route('staff.refunds.index', array_merge(request()->query(), ['status' => 'refunded'])) }}" class="filter-btn {{ request('status') === 'refunded' ? 'active' : '' }}">✅ Refunded</a>
            </div>

            <!-- List Table -->
            <div class="table-wrap">
                @if ($bookings->isEmpty())
                    <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                        <div style="font-size: 32px; margin-bottom: 12px;">📭</div>
                        <p>No refund requests found matching the criteria.</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer Details</th>
                                <th>Cancellation Details</th>
                                <th>Deposit Paid</th>
                                <th>Eligible Refund</th>
                                <th>Customer Bank Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td style="font-weight: 700; color: var(--text-dark);">#{{ $booking->bookingID }}</td>
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name">{{ $booking->customer->customerName ?? '—' }}</span>
                                            <span class="customer-email">{{ $booking->customer->customerEmail ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: var(--text-main);">
                                            <strong>Reason:</strong> {{ $booking->cancellation_reason ?? '—' }}
                                        </div>
                                        @if($booking->cancelled_at)
                                        <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 4px;">
                                            Cancelled: {{ $booking->cancelled_at->timezone('Asia/Kuala_Lumpur')->format('d M y, h:i A') }}
                                        </div>
                                        @endif
                                    </td>
                                    <td style="font-weight: 600; color: var(--text-muted);">
                                        RM {{ number_format($booking->bookingDepositAmount, 2) }}
                                    </td>
                                    <td style="font-weight: 700; color: #d97706;">
                                        RM {{ number_format($booking->refund_amount, 2) }}
                                    </td>
                                    <td>
                                        <div style="font-size: 13.5px; color: var(--text-dark); font-weight: 600;">
                                            {{ $booking->customer->customerBankName ?? '—' }}
                                        </div>
                                        <div style="font-family: monospace; font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                                            {{ $booking->customer->customerBankAccountNo ?? '—' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $booking->refund_status }}">
                                            {{ ucwords($booking->refund_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($booking->refund_status === 'pending')
                                            <button class="btn-refund" onclick="openRefundModal({{ json_encode([
                                                'id' => $booking->bookingID,
                                                'name' => $booking->customer->customerName ?? '',
                                                'bank' => $booking->customer->customerBankName ?? '',
                                                'account' => $booking->customer->customerBankAccountNo ?? '',
                                                'amount' => number_format($booking->refund_amount, 2)
                                            ]) }})">
                                                <i class="fa-solid fa-hand-holding-dollar"></i> Process Refund
                                            </button>
                                        @else
                                            @if($booking->refund_receipt_path)
                                                @if(Str::endsWith($booking->refund_receipt_path, '.pdf'))
                                                    <a href="javascript:void(0)" class="btn-view-receipt lightbox-trigger" data-file-url="{{ asset($booking->refund_receipt_path) }}" data-is-pdf="true">
                                                        <i class="fa-solid fa-file-pdf"></i> Receipt PDF
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="btn-view-receipt lightbox-trigger" data-file-url="{{ asset($booking->refund_receipt_path) }}" data-is-pdf="false">
                                                        <i class="fa-solid fa-receipt"></i> View Receipt
                                                    </a>
                                                @endif
                                            @else
                                                <span style="color: var(--text-muted);">Refunded (No Receipt)</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Pagination --}}
            @if ($bookings->hasPages())
                <div class="pagination-wrapper">
                    @if ($bookings->onFirstPage())
                        <span class="page-link disabled">&laquo; Prev</span>
                    @else
                        <a href="{{ $bookings->previousPageUrl() }}" class="page-link">&laquo; Prev</a>
                    @endif

                    @foreach ($bookings->getUrlRange(max(1, $bookings->currentPage() - 2), min($bookings->lastPage(), $bookings->currentPage() + 2)) as $page => $url)
                        @if ($page == $bookings->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($bookings->hasMorePages())
                        <a href="{{ $bookings->nextPageUrl() }}" class="page-link">Next &raquo;</a>
                    @else
                        <span class="page-link disabled">Next &raquo;</span>
                    @endif
                </div>
            @endif
        </main>
    </div>

    <!-- Refund Processing Modal -->
    <div class="modal-overlay" id="refundModal">
        <div class="modal-card">
            <h3>Process Customer Refund</h3>
            
            <form id="refundForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p style="font-size:13.5px; color:var(--text-main); line-height:1.5;">
                        Please perform a bank transfer to the customer's bank account with the details below. Once complete, upload the transfer receipt to finalize.
                    </p>

                    <div class="bank-details-box">
                        <div class="bank-row">
                            <span class="label">Customer Name</span>
                            <span class="val" id="modalCustomerName"></span>
                        </div>
                        <div class="bank-row">
                            <span class="label">Bank Name</span>
                            <div style="display:flex; align-items:center;">
                                <span class="val" id="modalBankName" style="color: #d97706;"></span>
                                <button type="button" class="btn-copy" onclick="copyText('modalBankName')">Copy</button>
                            </div>
                        </div>
                        <div class="bank-row">
                            <span class="label">Bank Account No.</span>
                            <div style="display:flex; align-items:center;">
                                <span class="val" id="modalBankAccount"></span>
                                <button type="button" class="btn-copy" onclick="copyText('modalBankAccount')">Copy</button>
                            </div>
                        </div>
                        <div class="bank-row" style="border-top:1px dashed var(--border-color); padding-top:10px; margin-top:4px;">
                            <span class="label" style="font-weight:700;">Refund Amount</span>
                            <span class="val" style="color:var(--accent-green); font-size:16px; font-weight:800;" id="modalRefundAmount"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="refund_receipt">Upload Transaction Receipt (Image / PDF)</label>
                        <input type="file" name="refund_receipt" id="refund_receipt" class="form-input" accept="image/*,application/pdf" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="refund_remarks">Admin Remarks (Optional)</label>
                        <textarea name="refund_remarks" id="refund_remarks" class="modal-textarea" placeholder="Add payment reference number or notes..."></textarea>
                    </div>
                </div>

                <div class="modal-actions" style="margin-top:20px;">
                    <button type="button" class="btn-cancel" onclick="closeRefundModal()">Close</button>
                    <button type="submit" class="btn-refund" style="padding:10px 24px;">Confirm Refunded</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div id="lightboxModal">
        <div id="lightboxContent">
            <button id="closeLightboxBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img id="lightboxImg" src="">
            <iframe id="lightboxIframe" src=""></iframe>
        </div>
    </div>

    <script>
        // Sidebar Nav Dropdown Toggles
        document.addEventListener('DOMContentLoaded', () => {
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
        });

        // Sidebar Toggle Action
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const toggleChevronIcon = document.getElementById('toggleChevronIcon');

        if (sidebarToggleBtn && toggleChevronIcon) {
            sidebarToggleBtn.addEventListener('click', () => {
                if (window.innerWidth < 1200) {
                    document.body.classList.remove('mobile-sidebar-active');
                } else {
                    document.body.classList.toggle('collapsed-sidebar-active');
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

        // Profile Dropdown Toggle
        const profileBtn = document.getElementById('profileTriggerBtn');
        const profileMenu = document.getElementById('profileDropdownMenu');

        if (profileBtn && profileMenu) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('show');
                const notifMenu = document.getElementById('notificationDropdownMenu');
                if (notifMenu && notifMenu.classList.contains('show')) {
                    notifMenu.classList.remove('show');
                }
            });

            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.remove('show');
                }
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

        function openRefundModal(data) {
            document.getElementById('refundForm').action = '/staff/refunds/' + data.id + '/complete';
            document.getElementById('modalCustomerName').textContent = data.name;
            document.getElementById('modalBankName').textContent = data.bank;
            document.getElementById('modalBankAccount').textContent = data.account;
            document.getElementById('modalRefundAmount').textContent = 'RM ' + data.amount;
            document.getElementById('refundModal').classList.add('show');
        }

        function closeRefundModal() {
            document.getElementById('refundModal').classList.remove('show');
        }

        function copyText(elementId) {
            const text = document.getElementById(elementId).textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard: ' + text);
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }

        // Close modal on overlay click
        document.getElementById('refundModal').addEventListener('click', function(e) {
            if (e.target === this) closeRefundModal();
        });

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
                const url = trigger.getAttribute('data-file-url');
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
    </script>
</body>
</html>
