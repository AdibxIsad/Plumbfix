<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($jobRecord) ? 'Edit' : 'Add' }} Job Record — Plumbfix Staff</title>
    <meta name="description" content="Document or update the completed work details for a booking.">
    
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
            --bg-color: #fafbfe;
            --surface-color: #ffffff;
            --text-main: #1e293b;
            --text-muted: #94a3b8;
            --text-dark: #0f172a;
            --brand-color: #2563eb;
            --brand-light: #dbeafe;
            --border-color: #f1f5f9;
            --hover-color: #f8fafc;
            --accent-green: #22c55e;
            --accent-green-bg: #f0fdf4;
            --accent-orange: #f97316;
            --accent-orange-bg: #fff7ed;
            --accent-blue: #3b82f6;
            --accent-blue-bg: #eff6ff;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.04);
            --transition-speed: 0.25s;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ══════════════════ SIDEBAR ══════════════════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background-color: var(--surface-color);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
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
            transition: opacity var(--transition-speed);
        }

        .sidebar-toggle {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background-color: var(--surface-color);
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
        }

        .sidebar-nav {
            flex: 1;
            padding: 24px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-section {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            padding-left: 12px;
            margin-top: 16px;
            margin-bottom: 8px;
            transition: opacity var(--transition-speed);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 10px;
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
        }

        .nav-item i {
            font-size: 18px;
            width: 20px;
            text-align: center;
            color: var(--text-muted);
            transition: color 0.2s ease;
        }

        .nav-item:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        .nav-item:hover i {
            color: var(--text-dark);
        }

        .nav-item.active {
            background-color: var(--hover-color);
            color: var(--text-dark);
            font-weight: 600;
        }

        .nav-item.active i {
            color: var(--text-dark);
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
        body.collapsed-sidebar-active .nav-link-text,
        body.collapsed-sidebar-active .staff-info,
        body.collapsed-sidebar-active .sidebar-nav-bottom a:not(.logout-btn-nav) {
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

        /* ══════════════════ MAIN WRAPPER ══════════════════ */
        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        body.collapsed-sidebar-active .main-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Header Navigation */
        .main-header {
            height: 90px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--surface-color);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .welcome-meta {
            display: flex;
            align-items: center;
            gap: 16px;
        }



        .welcome-text h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .welcome-text p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 2px;
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
            object-fit: cover;
        }

        /* Dropdown Menu styling */
        .profile-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            padding: 8px;
            display: none;
            flex-direction: column;
            gap: 2px;
            z-index: 1000;
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
            top: 60px;
            right: 0;
            width: 280px;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            display: none;
            flex-direction: column;
            padding: 8px 0 0 0;
            z-index: 120;
        }

        .notification-dropdown-menu.show {
            display: flex;
        }

        .notification-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 10px 16px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-message {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.4;
        }

        .notification-time {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .dropdown-header {
            padding: 10px 12px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 4px;
        }

        .dropdown-header-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .dropdown-header-role {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .dropdown-item i {
            font-size: 15px;
            color: var(--text-muted);
        }

        .dropdown-item:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }

        .dropdown-item:hover i {
            color: var(--text-dark);
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
            padding: 40px;
            flex: 1;
            max-width: 800px;
        
            min-width: 0;
            max-width: 100%;}

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            color: var(--text-dark);
            background-color: var(--hover-color);
            border-color: var(--text-muted);
        }

        /* Booking summary card */
        .booking-summary {
            background: linear-gradient(135deg, var(--accent-blue-bg) 0%, var(--brand-light) 100%);
            border: 1px solid rgba(37, 99, 235, 0.15);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .booking-summary-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--brand-color);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .booking-summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .bs-item {
            font-size: 14.5px;
        }

        .bs-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .bs-value {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Forms Styling */
        .form-card {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }

        .form-card-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .form-input {
            width: 100%;
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        .field-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
        }

        .cost-preview {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--accent-green-bg);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 10px;
        }

        .cost-preview-label {
            font-size: 13px;
            color: var(--text-muted);
        }

        .cost-preview-val {
            font-size: 20px;
            font-weight: 800;
            color: var(--accent-green);
        }

        .btn-save {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background-color: var(--brand-color);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .btn-save:hover {
            opacity: 0.9;
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
    </style>
</head>
<body>

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
                <div class="welcome-text">
                    <h1>{{ isset($jobRecord) ? 'Edit' : 'Add' }} Job Record</h1>
                    <p>{{ isset($jobRecord) ? 'Update' : 'Document' }} the completed work details for booking #{{ $booking->bookingID }}</p>
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
                <a href="{{ route('staff.job-records') }}" class="btn-back">← Back</a>
                
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
            @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $e)<div>⚠️ {{ $e }}</div>@endforeach
            </div>
            @endif

            <!-- Booking Summary -->
            <div class="booking-summary">
                <div class="booking-summary-title">📋 Booking Details</div>
                <div class="booking-summary-grid">
                    <div class="bs-item">
                        <div class="bs-label">Service Type</div>
                        <div class="bs-value">{{ $booking->bookingType }}</div>
                    </div>
                    <div class="bs-item">
                        <div class="bs-label">Problem</div>
                        <div class="bs-value">{{ $booking->bookingProblem }}</div>
                    </div>
                    <div class="bs-item">
                        <div class="bs-label">Customer</div>
                        <div class="bs-value">{{ $booking->customer?->customerName ?? '—' }}</div>
                    </div>
                    <div class="bs-item">
                        <div class="bs-label">Booked Date</div>
                        <div class="bs-value">{{ \Carbon\Carbon::parse($booking->bookingDate)->format('d M Y') }} · {{ \Carbon\Carbon::parse($booking->bookingTime)->format('h:i A') }}</div>
                    </div>
                    @if($booking->bookingIssueDescription)
                    <div class="bs-item" style="grid-column:1/-1;">
                        <div class="bs-label">Issue Description</div>
                        <div class="bs-value" style="font-weight:400;color:var(--text-main);">{{ $booking->bookingIssueDescription }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('staff.job-record.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="bookingID" value="{{ $booking->bookingID }}">

                <div class="form-card">
                    <div class="form-card-title">📝 Job Record Details</div>

                    <div class="form-group">
                        <label for="jobRecordCompletionDate" class="form-label">Completion Date</label>
                        <input id="jobRecordCompletionDate" type="date" name="jobRecordCompletionDate" class="form-input"
                               value="{{ old('jobRecordCompletionDate', isset($jobRecord) ? $jobRecord->jobRecordCompletionDate->toDateString() : now()->toDateString()) }}"
                               max="{{ now()->toDateString() }}" required>
                        @error('jobRecordCompletionDate')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="jobRecordTotalCost" class="form-label">Total Cost (RM)</label>
                        <input id="jobRecordTotalCost" type="number" name="jobRecordTotalCost" class="form-input"
                               placeholder="0.00" step="0.01" min="0"
                               value="{{ old('jobRecordTotalCost', isset($jobRecord) ? number_format($jobRecord->jobRecordTotalCost, 2, '.', '') : '0.00') }}"
                               oninput="updateCostPreview(this.value)" required>
                        @error('jobRecordTotalCost')<div class="field-error">{{ $message }}</div>@enderror
                        <div class="cost-preview">
                            <span class="cost-preview-label">Total charged to customer</span>
                            <span class="cost-preview-val" id="costDisplay">RM 0.00</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jobRecordNotes" class="form-label">Work Notes <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                        <textarea id="jobRecordNotes" name="jobRecordNotes" class="form-input"
                                  placeholder="Describe the work done, parts replaced, recommendations...">{{ old('jobRecordNotes', isset($jobRecord) ? $jobRecord->jobRecordNotes : '') }}</textarea>
                        @error('jobRecordNotes')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    @if(isset($jobRecord) && $jobRecord->jobRecordAttachments && count($jobRecord->jobRecordAttachments) > 0)
                    <div class="form-group">
                        <label class="form-label">Existing Work Photos</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                            @foreach($jobRecord->jobRecordAttachments as $attachment)
                                <div style="position: relative; width: 60px; height: 60px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);">
                                    <img src="{{ asset($attachment) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="jobRecordAttachments" class="form-label">Upload Work Photos <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                        <div class="file-upload-wrapper" style="position: relative; border: 2px dashed var(--border-color); border-radius: 12px; padding: 20px; text-align: center; background-color: var(--hover-color); cursor: pointer; transition: all 0.2s ease;">
                            <input type="file" id="jobRecordAttachments" name="jobRecordAttachments[]" accept="image/*" multiple style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                            <div class="file-upload-info" style="pointer-events: none;">
                                <i class="fa-regular fa-image" style="font-size: 28px; color: var(--text-muted); margin-bottom: 8px; display: block;"></i>
                                <span style="font-size: 13.5px; font-weight: 600; color: var(--text-main); display: block;" id="fileNameDisplay">Drag & drop or click to upload multiple photos</span>
                                <span style="font-size: 11px; color: var(--text-muted); display: block; margin-top: 4px;">PNG, JPG, JPEG, GIF, SVG up to 4MB each</span>
                            </div>
                        </div>
                        <div id="fileListPreview" style="margin-top: 12px; display: flex; flex-wrap: wrap; gap: 10px;"></div>
                        @error('jobRecordAttachments')<div class="field-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-top: 24px; display: flex; align-items: center; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        @if($booking->customer?->customerEmail)
                            <input type="checkbox" id="send_invoice_email" name="send_invoice_email" value="1" style="width: 20px; height: 20px; border-radius: 6px; border: 1px solid var(--border-color); cursor: pointer; accent-color: var(--brand-color);" {{ old('send_invoice_email') ? 'checked' : '' }}>
                            <label for="send_invoice_email" style="font-size: 14px; font-weight: 500; color: var(--text-dark); cursor: pointer; user-select: none;">
                                📧 Save and Send PDF Invoice to Customer's Email ({{ $booking->customer->customerEmail }})
                            </label>
                        @else
                            <input type="checkbox" id="send_invoice_email" name="send_invoice_email" value="1" style="width: 20px; height: 20px; border-radius: 6px; border: 1px solid var(--border-color); cursor: not-allowed; accent-color: var(--text-muted);" disabled>
                            <label for="send_invoice_email" style="font-size: 14px; font-weight: 500; color: var(--text-muted); cursor: not-allowed; user-select: none;">
                                📧 Save and Send PDF Invoice (Disabled: Customer has no email address)
                            </label>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn-save">💾 Save Job Record</button>
            </form>
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

            sidebarToggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('collapsed-sidebar-active');
                
                // Toggle arrow icon
                if (document.body.classList.contains('collapsed-sidebar-active')) {
                    toggleChevronIcon.className = 'fa-solid fa-chevron-right';
                } else {
                    toggleChevronIcon.className = 'fa-solid fa-chevron-left';
                }
            });

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

            // Multiple file upload preview
            const fileInput = document.getElementById('jobRecordAttachments');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const fileListPreview = document.getElementById('fileListPreview');
            const fileUploadWrapper = fileInput ? fileInput.closest('.file-upload-wrapper') : null;

            if (fileInput && fileNameDisplay && fileListPreview) {
                fileInput.addEventListener('change', () => {
                    fileListPreview.innerHTML = '';
                    if (fileInput.files.length > 0) {
                        fileNameDisplay.textContent = `${fileInput.files.length} photo(s) selected`;
                        if (fileUploadWrapper) {
                            fileUploadWrapper.style.borderColor = 'var(--brand-color)';
                            fileUploadWrapper.style.backgroundColor = 'var(--brand-light)';
                        }
                        
                        Array.from(fileInput.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const previewContainer = document.createElement('div');
                                previewContainer.style.cssText = 'position: relative; width: 60px; height: 60px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color);';
                                
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
                                
                                previewContainer.appendChild(img);
                                fileListPreview.appendChild(previewContainer);
                            };
                            reader.readAsDataURL(file);
                        });
                    } else {
                        fileNameDisplay.textContent = 'Drag & drop or click to upload multiple photos';
                        if (fileUploadWrapper) {
                            fileUploadWrapper.style.borderColor = 'var(--border-color)';
                            fileUploadWrapper.style.backgroundColor = 'var(--hover-color)';
                        }
                    }
                });
            }
        });

        function updateCostPreview(val) {
            const num = parseFloat(val) || 0;
            document.getElementById('costDisplay').textContent = 'RM ' + num.toFixed(2);
        }
        updateCostPreview(document.getElementById('jobRecordTotalCost').value);
    </script>
</body>
</html>
