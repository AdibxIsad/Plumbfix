<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback — Plumbfix</title>
    <meta name="description" content="Share your experience and read reviews from other customers.">
    
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
            padding: 32px;
            flex: 1;
            width: 100%;
            min-width: 0;
            max-width: 100%;
        }

        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .page-header h1 span {
            color: var(--brand-color);
            background: linear-gradient(135deg, var(--brand-color) 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 500;
        }

        /* Stats Grid Section */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--glass-shadow);
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
        }

        .stat-card.full-width {
            grid-column: span 2;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            gap: 32px;
        }

        .stat-card-left-wrapper {
            flex: 0 0 240px;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--brand-gradient);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-title {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        .stat-card-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--brand-light);
            color: var(--brand-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .stat-card-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .stat-card-subtext {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Rating Breakdown styling */
        .breakdown-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            width: 100%;
        }

        .breakdown-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .breakdown-label {
            width: 32px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .breakdown-track {
            flex: 1;
            height: 8px;
            background: var(--hover-color);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .breakdown-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--brand-color) 0%, #06b6d4 100%);
            border-radius: 10px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .breakdown-percentage {
            width: 35px;
            text-align: right;
            color: var(--text-muted);
        }

        /* Two Column Layout */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1.6fr;
            gap: 32px;
            align-items: start;
        }

        /* Submit Form Card */
        .form-card {
            background-color: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 32px;
            box-shadow: var(--glass-shadow), var(--shadow-md);
            position: relative;
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-card-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .form-input {
            width: 100%;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 14px 16px;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            transition: all var(--transition-speed);
            outline: none;
            box-shadow: var(--shadow-sm);
        }

        .form-input:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.12), var(--shadow-sm);
        }

        .form-input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
            line-height: 1.5;
        }

        /* Star Rating */
        .stars-row {
            display: flex;
            gap: 12px;
            margin-bottom: 6px;
            padding: 4px 0;
        }

        .star-btn {
            font-size: 32px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: none;
            border: none;
            line-height: 1;
            padding: 0;
            filter: grayscale(1) opacity(0.3);
        }

        .star-btn:hover, .star-btn.active {
            filter: none;
            transform: scale(1.25);
            text-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
        }

        /* Drag-and-drop file styling */
        .file-upload-wrapper {
            position: relative;
            width: 100%;
            border: 2px dashed var(--border-color);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            background: var(--surface-color-solid);
            transition: all var(--transition-speed);
            cursor: pointer;
        }

        .file-upload-wrapper:hover, .file-upload-wrapper.dragover {
            border-color: var(--brand-color);
            background: var(--brand-light);
        }

        .file-upload-icon {
            font-size: 28px;
            color: var(--brand-color);
            margin-bottom: 10px;
        }

        .file-upload-text {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
        }

        .file-upload-text span {
            color: var(--brand-color);
            text-decoration: underline;
        }

        .file-upload-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Preview attachments area */
        .preview-thumbnails-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .preview-thumbnail {
            width: 55px;
            height: 55px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            object-fit: cover;
            position: relative;
            box-shadow: var(--shadow-sm);
        }

        .preview-doc-badge {
            width: 55px;
            height: 55px;
            border-radius: 8px;
            background: var(--hover-color);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--brand-color);
            box-shadow: var(--shadow-sm);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: 14px;
            background: var(--brand-gradient);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all var(--transition-speed);
            box-shadow: 0 4px 14px rgba(13, 148, 136, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
            opacity: 0.95;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Custom Filter & Search Header */
        .reviews-control-bar {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: var(--shadow-sm);
        }

        .reviews-tabs-container {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .reviews-tabs-container::-webkit-scrollbar {
            height: 4px;
        }
        .reviews-tabs-container::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .filter-tab {
            padding: 8px 16px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--surface-color-solid);
            color: var(--text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-speed);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-tab:hover {
            border-color: var(--brand-color);
            color: var(--brand-color);
        }

        .filter-tab.active {
            background: var(--brand-color);
            border-color: var(--brand-color);
            color: white;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.15);
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .search-input-field {
            width: 100%;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px 12px 42px;
            color: var(--text-dark);
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            transition: all var(--transition-speed);
            outline: none;
        }

        .search-input-field:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        /* Review wall section */
        .section-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--border-color);
        }

        /* Review Card Styling */
        .review-card {
            background-color: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--glass-shadow);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .review-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: transparent;
            transition: background var(--transition-speed);
        }

        /* Custom accent line based on rating */
        .review-card[data-rating="5"]::before, .review-card[data-rating="4"]::before {
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        }
        .review-card[data-rating="3"]::before {
            background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 100%);
        }
        .review-card[data-rating="2"]::before, .review-card[data-rating="1"]::before {
            background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
        }

        .review-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .review-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--brand-color), #0d9488);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.15);
        }

        .review-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .verified-badge {
            font-size: 10px;
            font-weight: 700;
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            padding: 2px 6px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .you-badge {
            font-size: 10px;
            font-weight: 700;
            color: var(--brand-color);
            background: var(--brand-light);
            padding: 2px 6px;
            border-radius: 6px;
        }

        .review-date {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 500;
        }

        .review-stars {
            font-size: 15px;
            letter-spacing: 2px;
            color: #f59e0b;
        }

        .review-comment {
            font-size: 14.5px;
            color: var(--text-dark);
            line-height: 1.6;
            font-weight: 500;
            word-break: break-word;
        }

        .review-attachments-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 8px;
        }

        .review-img-thumb {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--border-color);
            transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
            cursor: zoom-in;
        }

        .review-img-thumb:hover {
            transform: scale(1.06) rotate(1deg);
            border-color: var(--brand-color);
            box-shadow: var(--shadow-md), 0 0 10px rgba(13, 148, 136, 0.15);
        }

        .review-doc-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            padding: 8px 14px;
            border-radius: 10px;
            color: var(--brand-color);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
        }

        .review-doc-link:hover {
            background: var(--brand-light);
            border-color: var(--brand-color);
            transform: translateY(-1px);
        }

        /* Image modal viewer */
        .lightbox-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(8px);
            z-index: 100000;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .lightbox-content {
            max-width: 90%;
            max-height: 85%;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            animation: zoomFade 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .lightbox-close {
            position: absolute;
            top: 30px;
            right: 40px;
            color: white;
            font-size: 32px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .lightbox-close:hover {
            transform: scale(1.1);
        }

        /* Empty states */
        .no-reviews {
            text-align: center;
            padding: 60px 40px;
            color: var(--text-muted);
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--glass-shadow);
        }

        .no-reviews .icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
            color: var(--brand-color);
        }

        .no-reviews h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .no-reviews p {
            font-size: 13.5px;
        }

        /* Alerts and notices */
        .alert-success, .alert-error {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background-color: var(--accent-green-bg);
            border: 1px solid var(--accent-green-border);
            color: var(--accent-green);
        }

        .alert-error {
            background-color: #fee2e2;
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        @media (max-width: 900px) {
            .two-col {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .stat-card.full-width {
                grid-column: span 1;
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }
            .stat-card-left-wrapper {
                width: 100%;
            }
        }

        @media (max-width: 1200px) {
            .sidebar {
                transform: translateX(calc(-100% - 40px));
                position: fixed;
                top: 20px;
                left: 20px;
                bottom: 20px;
                z-index: 1005;
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
            #emailDropdownMenu,
            #notificationDropdownMenu,
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
            .main-wrapper {
                margin-left: 10px !important;
                padding-right: 10px !important;
                width: calc(100% - 20px) !important;
                max-width: 100% !important;
                overflow-x: hidden;
            }
            .content, .content-container {
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
        }

        /* JS-controlled Confirmation Modals */
        .confirm-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 100000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirm-modal-overlay.show {
            display: flex;
        }

        .confirm-modal-card {
            background-color: var(--surface-color-solid);
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            box-shadow: var(--shadow-lg);
            display: flex;
            flex-direction: column;
            padding: 28px;
            gap: 16px;
            text-align: left;
            border: 1px solid var(--border-color);
            animation: zoomFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .confirm-modal-card h4 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
        }

        .confirm-modal-card p {
            font-size: 14.5px;
            color: var(--text-main);
            line-height: 1.6;
            margin: 0;
        }

        .confirm-modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 8px;
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
            
            <a href="{{ route('customer.feedback') }}" class="nav-link active">
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
                    <h1>Feedback</h1>
                    <p>Share your experience and read what other customers say about Plumbfix</p>
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
            <div class="alert-success">
                ✅ {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="alert-error">
                ⚠️ {{ $errors->first() }}
            </div>
            @endif

            @php
                $avgRating = $allFeedback->avg('feedbackRating') ?? 0.0;
                $totalCount = $allFeedback->count();
                $recommendPercent = $totalCount > 0 ? round(($allFeedback->where('feedbackRating', '>=', 4)->count() / $totalCount) * 100) : 100;
                
                $starsCount = [
                    5 => $allFeedback->where('feedbackRating', 5)->count(),
                    4 => $allFeedback->where('feedbackRating', 4)->count(),
                    3 => $allFeedback->where('feedbackRating', 3)->count(),
                    2 => $allFeedback->where('feedbackRating', 2)->count(),
                    1 => $allFeedback->where('feedbackRating', 1)->count(),
                ];
            @endphp

            <div class="page-header">
                <div class="page-header-text">
                    <h1>Service <span>Feedback</span></h1>
                    <p>Share your experience and read what other customers say about Plumbfix</p>
                </div>
                <div id="writeFeedbackBtnContainer" style="margin-bottom: 0;">
                    <button type="button" id="toggleFeedbackFormBtn" class="btn-submit" style="margin-top: 0; width: auto; padding: 12px 24px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-pen-to-square"></i> Write a Feedback
                    </button>
                </div>
            </div>

            <!-- Statistics Header Cards Grid -->
            <div class="stats-grid">
                <!-- Average Rating Card (Horizontally Elongated / Full Width) -->
                <div class="stat-card full-width">
                    <div class="stat-card-left-wrapper">
                        <div class="stat-card-header" style="margin-bottom: 12px;">
                            <span class="stat-card-title">Average Rating</span>
                            <div class="stat-card-icon"><i class="fa-solid fa-star"></i></div>
                        </div>
                        <div class="stat-card-value" style="margin-bottom: 8px;">
                            {{ number_format($avgRating, 1) }}
                            <span style="font-size: 16px; color: var(--text-muted); font-weight: 600;">/ 5.0</span>
                        </div>
                        <div style="font-size: 20px; color: #f59e0b; letter-spacing: 2px;">
                            @for($i=1; $i<=5; $i++)
                                {{ $i <= round($avgRating) ? '⭐' : '☆' }}
                            @endfor
                        </div>
                    </div>
                    <div class="breakdown-list" style="flex: 1;">
                        @for($r = 5; $r >= 1; $r--)
                            @php
                                $percent = $totalCount > 0 ? ($starsCount[$r] / $totalCount) * 100 : 0;
                            @endphp
                            <div class="breakdown-row">
                                <div class="breakdown-label">{{ $r }} ★</div>
                                <div class="breakdown-track">
                                    <div class="breakdown-fill" style="width: {{ $percent }}%;"></div>
                                </div>
                                <div class="breakdown-percentage">{{ round($percent) }}%</div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Total Reviews Card (Bottom Left) -->
                <div class="stat-card" style="justify-content: space-between;">
                    <div>
                        <div class="stat-card-header">
                            <span class="stat-card-title">Total Feedbacks</span>
                            <div class="stat-card-icon"><i class="fa-solid fa-comments"></i></div>
                        </div>
                        <div class="stat-card-value" style="margin-top: 12px;">
                            {{ $totalCount }}
                            <span style="font-size: 16px; color: var(--text-muted); font-weight: 600;">Reviews</span>
                        </div>
                    </div>
                    <div class="stat-card-subtext">
                        <i class="fa-solid fa-arrow-trend-up" style="color: #10b981; margin-right: 4px;"></i>
                        100% verified customer experiences
                    </div>
                </div>

                <!-- Recommendation Rate Card (Bottom Right) -->
                <div class="stat-card" style="justify-content: space-between;">
                    <div>
                        <div class="stat-card-header">
                            <span class="stat-card-title">Recommendation Rate</span>
                            <div class="stat-card-icon"><i class="fa-solid fa-thumbs-up"></i></div>
                        </div>
                        <div class="stat-card-value" style="margin-top: 12px;">
                            {{ $recommendPercent }}%
                        </div>
                    </div>
                    <div class="stat-card-subtext">
                        Percentage of customers rating 4★ or 5★
                    </div>
                </div>
            </div>

            <!-- Feedback Form Card (Full Width) -->
            <div class="form-card" id="feedbackFormCard" style="display: none; margin-bottom: 32px;">
                <div class="form-card-title">⭐ Leave a Review</div>

                @if($completedBookingsWithoutFeedback->isEmpty())
                    <div style="text-align: center; padding: 24px 16px; background: var(--hover-color); border: 1px solid var(--border-color); border-radius: 14px;">
                        <div style="font-size: 32px; color: var(--brand-color); margin-bottom: 12px;"><i class="fa-solid fa-circle-check"></i></div>
                        <h4 style="font-size: 15px; font-weight: 800; color: var(--text-dark); margin-bottom: 6px;">No Pending Reviews</h4>
                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin: 0;">You have submitted feedback for all your completed bookings, or do not have any completed bookings yet.</p>
                    </div>
                @else
                    <form action="{{ route('customer.feedback.store') }}" method="POST" enctype="multipart/form-data" id="feedbackSubmissionForm">
                        @csrf

                        <div class="form-group">
                            <label for="bookingID" class="form-label">Select Service to Review</label>
                            <select name="bookingID" id="bookingID" class="form-input" required style="font-family: inherit; cursor: pointer;">
                                <option value="">-- Choose a Completed Service --</option>
                                @foreach($completedBookingsWithoutFeedback as $b)
                                    <option value="{{ $b->bookingID }}" {{ (old('bookingID') == $b->bookingID || $selectedBookingID == $b->bookingID) ? 'selected' : '' }}>
                                        Booking #{{ $b->bookingID }} - {{ $b->bookingType }} ({{ $b->bookingDate ? $b->bookingDate->format('d M Y') : '—' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('bookingID')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Your Rating</label>
                            <div class="stars-row" id="starsRow">
                                @for($i=1; $i<=5; $i++)
                                <button type="button" class="star-btn" data-val="{{ $i }}" id="star{{ $i }}">⭐</button>
                                @endfor
                            </div>
                            <input type="hidden" name="feedbackRating" id="ratingInput" value="{{ old('feedbackRating', 0) }}" required>
                            @error('feedbackRating')
                                <div style="font-size:12px;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="feedbackComments" class="form-label">Your Review <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                            <textarea id="feedbackComments" name="feedbackComments" class="form-input"
                                       placeholder="Tell us about your experience with Plumbfix...">{{ old('feedbackComments') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Attachments <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                            <div class="file-upload-wrapper" id="fileUploadWrapper">
                                <div class="file-upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                <div class="file-upload-text">Drag & drop files here or <span>browse</span></div>
                                <div class="file-upload-hint">Upload images (JPG, PNG) or PDF document (Max 4MB each)</div>
                                <input id="feedbackAttachments" type="file" name="feedbackAttachments[]" class="file-upload-input" multiple accept="image/*,application/pdf" onchange="handleFileSelect(event)">
                            </div>
                            <div class="preview-thumbnails-container" id="previewThumbnailsContainer"></div>
                        </div>

                        <button type="button" id="submitTriggerBtn" class="btn-submit" style="text-align: center; display: flex; cursor: pointer; user-select: none; width: 100%; justify-content: center; align-items: center; border: none; font-family: inherit;">💬 Submit Feedback</button>
                        <div class="confirm-modal-overlay" id="confirmModalOverlay">
                            <div class="confirm-modal-card">
                                <h4>Confirm Submission</h4>
                                <p>Are you sure you want to submit your feedback?</p>
                                <div class="confirm-modal-buttons">
                                    <button type="button" class="btn-secondary" id="cancelSubmitBtn" style="cursor: pointer; border: none; font-family: inherit; width: auto; margin-top: 0; padding: 12px 24px; font-weight: 600;">Cancel</button>
                                    <button type="submit" class="btn-submit" id="confirmSubmitBtn" style="width: auto; margin-top: 0; cursor: pointer; border: none; font-family: inherit; padding: 12px 24px;">Confirm Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            <!-- All Reviews Section (Full Width) -->
            <div class="reviews-section">
                <!-- Search & Filter Control Bar -->
                <div class="reviews-control-bar">
                    <div class="reviews-tabs-container">
                        <button type="button" class="filter-tab active" data-rating="all">
                            <i class="fa-solid fa-border-all"></i> All Reviews
                        </button>
                        @for($i = 5; $i >= 1; $i--)
                        <button type="button" class="filter-tab" data-rating="{{ $i }}">
                            {{ $i }} ★ ({{ $starsCount[$i] }})
                        </button>
                        @endfor
                    </div>
                    <div class="search-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" class="search-input-field" id="reviewSearchInput" placeholder="Search reviews by comments...">
                    </div>
                </div>

                <div class="section-title">💬 Customer Reviews</div>

                <div id="reviewsContainer">
                    @if($allFeedback->isEmpty())
                        <div class="no-reviews">
                            <div class="icon"><i class="fa-solid fa-comment-slash"></i></div>
                            <h4>No reviews yet</h4>
                            <p>Be the first to share your experience with Plumbfix!</p>
                        </div>
                    @else
                        @foreach($allFeedback as $fb)
                        <div class="review-card" data-rating="{{ $fb->feedbackRating }}" data-comment="{{ strtolower($fb->feedbackComments ?? '') }}">
                            <div class="review-header">
                                @php
                                    // Generate avatar gradient colors deterministically
                                    $colors = ['#0d9488', '#0f766e', '#115e59', '#14b8a6', '#2dd4bf'];
                                    $colorIndex = crc32($fb->customer?->customerName ?? 'Customer') % count($colors);
                                    $avatarColor = $colors[abs($colorIndex)];
                                @endphp
                                <div class="review-avatar" style="background: linear-gradient(135deg, {{ $avatarColor }}, #0d9488);">
                                    {{ strtoupper(substr($fb->customer?->customerName ?? 'Customer', 0, 1)) }}
                                </div>
                                <div style="flex:1;">
                                    <div class="review-name">
                                        {{ $fb->customer?->customerName ?? 'Customer' }}
                                        @if($fb->customerID === $customer->customerID)
                                            <span class="you-badge">You</span>
                                        @endif
                                        <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified</span>
                                    </div>
                                    <div class="review-date">{{ $fb->created_at->format('d M Y') }}</div>
                                    @if($fb->booking)
                                        <div style="font-size: 11.5px; color: var(--brand-color); font-weight: 600; margin-top: 4px; display: flex; align-items: center; gap: 4px;">
                                            <i class="fa-solid fa-screwdriver-wrench"></i> {{ $fb->booking->bookingType }}
                                        </div>
                                    @endif
                                </div>
                                <div class="review-stars">
                                    {{ str_repeat('⭐', $fb->feedbackRating) }}{{ str_repeat('☆', 5 - $fb->feedbackRating) }}
                                </div>
                            </div>
                            @if($fb->feedbackComments)
                            <div class="review-comment">"{{ $fb->feedbackComments }}"</div>
                            @endif
                            @if($fb->staffResponse)
                            <div class="staff-reply-container" style="margin-top: 16px; padding: 14px; background: rgba(79, 70, 229, 0.05); border-left: 4px solid var(--brand-color); border-radius: 8px;">
                                <div style="font-size: 12px; font-weight: 700; color: var(--text-dark); margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                    <i class="fa-solid fa-reply"></i> Plumbfix Team Response
                                </div>
                                <div style="font-size: 13px; color: var(--text-main); line-height: 1.5; font-style: italic;">
                                    "{{ $fb->staffResponse }}"
                                </div>
                            </div>
                            @endif
                            @if($fb->feedbackAttachments && count($fb->feedbackAttachments) > 0)
                            <div class="review-attachments-grid">
                                @foreach($fb->feedbackAttachments as $filePath)
                                    @php
                                        $fileName = basename($filePath);
                                        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
                                    @endphp
                                    @if($isImage)
                                        <img src="{{ asset($filePath) }}" alt="Review attachment" class="review-img-thumb" onclick="openLightbox('{{ asset($filePath) }}')">
                                    @else
                                        <a href="{{ asset($filePath) }}" target="_blank" class="review-doc-link">
                                            <i class="fa-solid fa-file-pdf"></i> {{ Str::limit($fileName, 18) }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
    <!-- Lightbox Modal for Image Preview -->
    <div id="lightboxModal" class="lightbox-modal" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-content" id="lightboxImage">
    </div>

        </main>
    </div>

    <!-- Javascript Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Toggle Feedback Form
            const toggleFeedbackFormBtn = document.getElementById('toggleFeedbackFormBtn');
            const feedbackFormCard = document.getElementById('feedbackFormCard');
            if (toggleFeedbackFormBtn && feedbackFormCard) {
                toggleFeedbackFormBtn.addEventListener('click', () => {
                    if (feedbackFormCard.style.display === 'none') {
                        feedbackFormCard.style.display = 'block';
                        toggleFeedbackFormBtn.innerHTML = '<i class="fa-solid fa-xmark"></i> Hide Form';
                        toggleFeedbackFormBtn.style.backgroundColor = '#64748b';
                    } else {
                        feedbackFormCard.style.display = 'none';
                        toggleFeedbackFormBtn.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Write a Feedback';
                        toggleFeedbackFormBtn.style.backgroundColor = 'var(--brand-color)';
                    }
                });
            }

            // Auto-expand form if bookingID parameter exists in URL
            const urlParams = new URLSearchParams(window.location.search);
            const bookingIdParam = urlParams.get('bookingID');
            if (bookingIdParam && feedbackFormCard) {
                feedbackFormCard.style.display = 'block';
                if (toggleFeedbackFormBtn) {
                    toggleFeedbackFormBtn.innerHTML = '<i class="fa-solid fa-xmark"></i> Hide Form';
                    toggleFeedbackFormBtn.style.backgroundColor = '#64748b';
                }
            }

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

            // Star Rating Logic
            let currentRating = {{ old('feedbackRating', 0) }};

            window.updateStars = function(val) {
                currentRating = val;
                document.getElementById('ratingInput').value = val;
                for(let i=1; i<=5; i++){
                    const s = document.getElementById('star'+i);
                    if(s) s.classList.toggle('active', i <= val);
                }
            }

            for(let i=1; i<=5; i++){
                const btn = document.getElementById('star'+i);
                if(btn){
                    btn.addEventListener('click', () => window.updateStars(i));
                    btn.addEventListener('mouseenter', () => {
                        for(let j=1; j<=5; j++){
                            const s = document.getElementById('star'+j);
                            if(s) s.style.filter = j <= i ? 'none' : 'grayscale(1) opacity(0.5)';
                        }
                    });
                    btn.addEventListener('mouseleave', () => window.updateStars(currentRating));
                }
            }

            if(currentRating > 0) window.updateStars(currentRating);

            // Drag and drop file upload behavior
            const fileUploadWrapper = document.getElementById('fileUploadWrapper');
            if (fileUploadWrapper) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    fileUploadWrapper.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        fileUploadWrapper.classList.add('dragover');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    fileUploadWrapper.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        fileUploadWrapper.classList.remove('dragover');
                    }, false);
                });

                fileUploadWrapper.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    const fileInput = document.getElementById('feedbackAttachments');
                    if (fileInput) {
                        fileInput.files = files;
                        // Trigger preview
                        const event = new Event('change');
                        fileInput.dispatchEvent(event);
                    }
                });
            }

            // File selection preview
            window.handleFileSelect = function(e) {
                const container = document.getElementById('previewThumbnailsContainer');
                if (!container) return;
                container.innerHTML = '';
                
                const files = e.target.files;
                if (!files) return;

                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            img.className = 'preview-thumbnail';
                            img.title = file.name;
                            container.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const badge = document.createElement('div');
                        badge.className = 'preview-doc-badge';
                        badge.title = file.name;
                        badge.innerHTML = '<i class="fa-solid fa-file-pdf"></i>';
                        container.appendChild(badge);
                    }
                });
            };

            // Search and rating filter tabs logic
            const filterTabs = document.querySelectorAll('.filter-tab');
            const searchInput = document.getElementById('reviewSearchInput');
            const reviewCards = document.querySelectorAll('.review-card');
            let activeRatingFilter = 'all';
            let activeSearchQuery = '';

            function applyFilters() {
                let visibleCount = 0;
                reviewCards.forEach(card => {
                    const rating = card.getAttribute('data-rating');
                    const comment = card.getAttribute('data-comment');
                    
                    const matchesRating = (activeRatingFilter === 'all' || rating === activeRatingFilter);
                    const matchesSearch = (activeSearchQuery === '' || comment.includes(activeSearchQuery));

                    if (matchesRating && matchesSearch) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Handle no results empty state dynamically
                let noReviewsEl = document.getElementById('noResultsEmptyState');
                if (visibleCount === 0) {
                    if (!noReviewsEl) {
                        const reviewsContainer = document.getElementById('reviewsContainer');
                        noReviewsEl = document.createElement('div');
                        noReviewsEl.id = 'noResultsEmptyState';
                        noReviewsEl.className = 'no-reviews';
                        noReviewsEl.innerHTML = `
                            <div class="icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                            <h4>No matching reviews</h4>
                            <p>Try refining your search text or selected rating filter.</p>
                        `;
                        reviewsContainer.appendChild(noReviewsEl);
                    } else {
                        noReviewsEl.style.display = 'block';
                    }
                } else if (noReviewsEl) {
                    noReviewsEl.style.display = 'none';
                }
            }

            if (filterTabs.length > 0) {
                filterTabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        filterTabs.forEach(t => t.classList.remove('active'));
                        tab.classList.add('active');
                        activeRatingFilter = tab.getAttribute('data-rating');
                        applyFilters();
                    });
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    activeSearchQuery = e.target.value.toLowerCase().trim();
                    applyFilters();
                });
            }

            // JS-controlled Confirmation Modal Behavior
            const form = document.getElementById('feedbackSubmissionForm');
            const submitTriggerBtn = document.getElementById('submitTriggerBtn');
            const confirmModalOverlay = document.getElementById('confirmModalOverlay');
            const cancelSubmitBtn = document.getElementById('cancelSubmitBtn');

            if (submitTriggerBtn && form && confirmModalOverlay && cancelSubmitBtn) {
                // Open modal on trigger click
                submitTriggerBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    // 1. Check if booking is selected
                    const bookingSelect = document.getElementById('bookingID');
                    if (bookingSelect && !bookingSelect.value) {
                         bookingSelect.reportValidity();
                         return;
                    }

                    // 2. Check if rating is selected
                    const ratingInput = document.getElementById('ratingInput');
                    if (!ratingInput || ratingInput.value === '0' || ratingInput.value === '') {
                        alert('Please select a star rating first!');
                        return;
                    }

                    // 3. Show confirmation modal
                    confirmModalOverlay.classList.add('show');
                });

                // Close modal on cancel click
                cancelSubmitBtn.addEventListener('click', () => {
                    confirmModalOverlay.classList.remove('show');
                });

                // Close modal if user clicks outside the card (on overlay background)
                confirmModalOverlay.addEventListener('click', (e) => {
                    if (e.target === confirmModalOverlay) {
                        confirmModalOverlay.classList.remove('show');
                    }
                });
            }

            // Lightbox Modal functions
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImage = document.getElementById('lightboxImage');

            window.openLightbox = function(src) {
                if (lightboxModal && lightboxImage) {
                    lightboxImage.src = src;
                    lightboxModal.style.display = 'flex';
                }
            };

            window.closeLightbox = function() {
                if (lightboxModal) {
                    lightboxModal.style.display = 'none';
                }
            };
        });
    </script>
</body>
</html>
