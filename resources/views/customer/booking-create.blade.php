<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking — Plumbfix</title>
    <meta name="description" content="Fill in your service details and pick a convenient date & time slot.">
    
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

        /* ══════════════════ CONTENT AREA ══════════════════ */
        .content {
            padding: 32px 0;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* Wizard Stepper Styling */
        .stepper-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            position: relative;
            padding: 0 16px;
        }
        .stepper-line {
            position: absolute;
            top: 24px;
            left: 48px;
            right: 48px;
            height: 3px;
            background-color: var(--border-color);
            z-index: 1;
            transition: all 0.3s ease;
        }
        .stepper-line-progress {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--brand-color), #3b82f6);
            transition: all 0.3s ease;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            z-index: 2;
            position: relative;
            flex: 1;
        }
        .step-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: var(--surface-color-solid);
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-muted);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-sm);
        }
        .step-item.active .step-circle {
            background-color: var(--brand-light);
            border-color: var(--brand-color);
            color: var(--brand-color);
            box-shadow: 0 0 15px rgba(13, 148, 136, 0.2);
            transform: scale(1.1);
        }
        .step-item.completed .step-circle {
            background: linear-gradient(135deg, var(--brand-color), #3b82f6);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.2);
        }
        .step-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: color 0.3s;
        }
        .step-item.active .step-title {
            color: var(--text-dark);
        }
        .step-item.completed .step-title {
            color: var(--brand-color);
        }

        /* Wizard Steps Transition */
        .wizard-step {
            display: none;
            animation: fadeIn 0.4s ease;
        }
        .wizard-step.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Visual Service Selection Cards */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .service-card {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            user-select: none;
            text-align: left;
        }
        .service-card:hover {
            border-color: var(--brand-color);
            background-color: var(--brand-light);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .service-card.active {
            border-color: var(--brand-color);
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.04) 0%, rgba(59, 130, 246, 0.04) 100%);
            box-shadow: 0 8px 20px rgba(13, 148, 136, 0.08);
            transform: translateY(-2px);
        }
        .service-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: var(--hover-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: all 0.3s;
        }
        .service-card:hover .service-card-icon,
        .service-card.active .service-card-icon {
            background-color: var(--brand-color);
            color: white;
        }
        .service-card-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .service-card-desc {
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Two-column layout */
        .booking-layout {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 28px;
            align-items: start;
        }

        /* Schedule layout */
        .schedule-layout {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 28px;
            align-items: start;
        }
        @media (max-width: 960px) {
            .schedule-layout, .booking-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Forms Styling */
        .form-card {
            background-color: var(--surface-color-solid);
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
            text-align: left;
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
            background-color: var(--surface-color-solid);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
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

        /* Calendar styling matching theme */
        .calendar-card {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            box-shadow: var(--shadow-sm);
        }
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .cal-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .cal-nav {
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            color: var(--brand-color);
            padding: 6px 14px;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .cal-nav:hover {
            background-color: var(--brand-light);
            border-color: var(--brand-color);
        }
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            margin-bottom: 24px;
        }
        .cal-day-label {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            padding: 6px 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .cal-day {
            text-align: center;
            padding: 10px 4px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            color: var(--text-main);
        }
        .cal-day:hover:not(.disabled):not(.empty) {
            background-color: var(--hover-color);
            border-color: var(--border-color);
        }
        .cal-day.selected {
            background: linear-gradient(135deg, var(--brand-color), #3b82f6);
            color: #fff !important;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.2);
        }
        .cal-day.today {
            border-color: var(--brand-color);
            color: var(--brand-color);
        }
        .cal-day.disabled {
            color: var(--text-muted);
            opacity: 0.35;
            cursor: not-allowed;
        }
        .cal-day.empty {
            cursor: default;
        }
        .cal-day.friday {
            color: var(--accent-orange);
        }
        .cal-day.selected.friday {
            color: #fff;
        }

        /* Slots */
        .slots-section {
            margin-top: 8px;
        }
        .slots-title {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            text-align: left;
        }
        .slots-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .slot-btn {
            padding: 12px 10px;
            border-radius: 10px;
            text-align: center;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
            background-color: var(--hover-color);
            color: var(--text-main);
        }
        .slot-btn:hover:not(.taken) {
            background-color: var(--brand-light);
            border-color: var(--brand-color);
            color: var(--brand-color);
        }
        .slot-btn.selected {
            background: linear-gradient(135deg, var(--brand-color), #3b82f6);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.2);
        }
        .slot-btn.taken {
            background-color: #fef2f2;
            border-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            cursor: not-allowed;
            font-size: 12.5px;
        }
        .friday-note {
            background-color: var(--accent-orange-bg);
            border: 1px solid rgba(245, 158, 11, 0.25);
            border-radius: 10px;
            padding: 12px 16px;
            margin-top: 16px;
            font-size: 12.5px;
            color: var(--accent-orange);
            display: none;
            line-height: 1.5;
            text-align: left;
        }
        .no-date-msg {
            text-align: center;
            padding: 40px 0;
            color: var(--text-muted);
            font-size: 14.5px;
        }
        .no-date-msg .icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* Upload Drop Zone */
        .drop-zone {
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 36px 20px;
            text-align: center;
            background-color: var(--surface-color-solid);
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .drop-zone:hover, .drop-zone.dragover {
            border-color: var(--brand-color);
            background-color: var(--brand-light);
        }
        .drop-zone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .drop-zone-icon {
            font-size: 36px;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: block;
        }
        .drop-zone-text {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-dark);
            display: block;
        }
        .drop-zone-subtext {
            font-size: 12px;
            color: var(--text-muted);
            display: block;
            margin-top: 6px;
        }

        /* Navigation Buttons */
        .wizard-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            gap: 16px;
        }
        .btn-prev {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }
        .btn-prev:hover {
            background-color: var(--hover-color);
            color: var(--text-dark);
        }
        .btn-next {
            flex: 1.5;
            padding: 14px;
            border-radius: 12px;
            background-color: var(--brand-color);
            color: white;
            border: none;
            font-family: inherit;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
            text-align: center;
        }
        .btn-next:hover {
            opacity: 0.95;
            transform: translateY(-1px);
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
            text-align: left;
        }

        /* Custom Toast Notification */
        .custom-toast {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-left: 5px solid #ef4444;
            color: #0f172a;
            padding: 14px 20px;
            border-radius: 14px;
            box-shadow: 0 10px 30px -5px rgba(239, 68, 68, 0.25), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
            pointer-events: none;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .custom-toast.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }
        .custom-toast i {
            color: #ef4444;
            font-size: 18px;
        }
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15) !important;
            animation: shake 0.3s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
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
            
            <a href="{{ route('customer.booking.create') }}" class="nav-link active">
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
                    <h1>Book a Service</h1>
                    <p>Select service details, date and time slot</p>
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
            @if($errors->any())
            <div class="alert-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <!-- Stepper Container -->
            <div class="stepper-container">
                <div class="stepper-line">
                    <div class="stepper-line-progress" id="stepperProgress"></div>
                </div>
                <div class="step-item active" id="stepIndicator-1">
                    <div class="step-circle">1</div>
                    <span class="step-title">Services</span>
                </div>
                <div class="step-item" id="stepIndicator-2">
                    <div class="step-circle">2</div>
                    <span class="step-title">Schedule</span>
                </div>
                <div class="step-item" id="stepIndicator-3">
                    <div class="step-circle">3</div>
                    <span class="step-title">Review</span>
                </div>
            </div>

            <form action="{{ route('customer.booking.store') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                @csrf
                <!-- Hidden fields set by JS -->
                <input type="hidden" name="bookingDate" id="bookingDateInput" value="{{ old('bookingDate') }}">
                <input type="hidden" name="bookingTime" id="bookingTimeInput" value="{{ old('bookingTime') }}">
                <input type="hidden" name="bookingType" id="bookingTypeInput" value="{{ old('bookingType') }}">

                <!-- ══════════ STEP 1: SERVICE SELECTION ══════════ -->
                <div class="wizard-step active" id="step-1">
                    <div class="form-card">
                        <div class="form-card-title">🔧 Select Service Category</div>
                        
                        <div class="services-grid">
                            <div class="service-card" onclick="selectServiceCard('Pipe Repair')" data-service="Pipe Repair">
                                <div class="service-card-icon">🔩</div>
                                <div class="service-card-title">Pipe Repair</div>
                                <div class="service-card-desc">Fixing leaking, burst, or clogged pipes and connections.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Drain Cleaning')" data-service="Drain Cleaning">
                                <div class="service-card-icon">🚿</div>
                                <div class="service-card-title">Drain Cleaning</div>
                                <div class="service-card-desc">Clearing blocked kitchen sinks, bathroom drains, and pipes.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Leak Detection')" data-service="Leak Detection">
                                <div class="service-card-icon">💧</div>
                                <div class="service-card-title">Leak Detection</div>
                                <div class="service-card-desc">Locating hidden slab leaks and moisture issues accurately.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Water Heater')" data-service="Water Heater">
                                <div class="service-card-icon">🔥</div>
                                <div class="service-card-title">Water Heater</div>
                                <div class="service-card-desc">Installation, troubleshooting, and repairing heaters.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Toilet Repair')" data-service="Toilet Repair">
                                <div class="service-card-icon">🚽</div>
                                <div class="service-card-title">Toilet Repair</div>
                                <div class="service-card-desc">Fixing flush systems, toilet bowls, and seat replacements.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Tap & Faucet')" data-service="Tap & Faucet">
                                <div class="service-card-icon">🚰</div>
                                <div class="service-card-title">Tap & Faucet</div>
                                <div class="service-card-desc">Replacing and repairing kitchen or bathroom taps.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('Water Tank')" data-service="Water Tank">
                                <div class="service-card-icon">🏗️</div>
                                <div class="service-card-title">Water Tank</div>
                                <div class="service-card-desc">Cleaning, inspecting, and installing storage tanks.</div>
                            </div>
                            <div class="service-card" onclick="selectServiceCard('General Inspection')" data-service="General Inspection">
                                <div class="service-card-icon">🔍</div>
                                <div class="service-card-title">General Inspection</div>
                                <div class="service-card-desc">Full checkup of household plumbing and valves.</div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 24px;">
                            <label for="bookingProblem" class="form-label">Problem Summary</label>
                            <input id="bookingProblem" type="text" name="bookingProblem" class="form-input"
                                   placeholder="e.g. Leaking pipe under kitchen sink"
                                   value="{{ old('bookingProblem') }}" required>
                            <div id="bookingProblemJsError" class="field-error" style="display:none; color: #ef4444; font-size: 13px; margin-top: 8px; font-weight: 600; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-triangle-exclamation"></i> Please enter a problem summary.
                            </div>
                            @error('bookingProblem')<div class="field-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="bookingIssueDescription" class="form-label">Additional Details <span style="color:var(--text-muted);font-weight:400;">(optional)</span></label>
                            <textarea id="bookingIssueDescription" name="bookingIssueDescription" class="form-input"
                                      placeholder="Describe the issue in more detail...">{{ old('bookingIssueDescription') }}</textarea>
                            @error('bookingIssueDescription')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="wizard-buttons">
                        <div style="flex:1;"></div>
                        <button type="button" class="btn-next" onclick="nextStep(2)">Choose Schedule <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- ══════════ STEP 2: CHOOSE SCHEDULE ══════════ -->
                <div class="wizard-step" id="step-2">
                    <div class="schedule-layout">
                        <!-- Calendar Card -->
                        <div class="calendar-card">
                            <div class="cal-header">
                                <button type="button" class="cal-nav" id="prevMonth">&#8592;</button>
                                <div class="cal-title" id="calTitle"></div>
                                <button type="button" class="cal-nav" id="nextMonth">&#8594;</button>
                            </div>
                            <div class="cal-grid" id="calGrid"></div>
                        </div>

                        <!-- Slots Card -->
                        <div class="form-card" style="margin-bottom: 0; min-height: 380px; display: flex; flex-direction: column;">
                            <div class="form-card-title">🕒 Select Time Slot</div>
                            <div class="slots-section" style="flex: 1;">
                                <div id="slotsContainer">
                                    <div class="no-date-msg">
                                        <div class="icon">📅</div>
                                        <div>Select a date to see available slots</div>
                                    </div>
                                </div>
                                <div class="friday-note" id="fridayNote">
                                    🕌 Friday schedule: Only 3 slots available (Jumu'ah prayer break 12–3 PM)
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected summary inline preview -->
                    <div class="form-card" id="summaryCard" style="display:none; margin-top: 24px; padding: 20px;">
                        <div class="form-card-title" style="margin-bottom: 12px; padding-bottom: 8px;">📋 Selected Slot Details</div>
                        <div style="display:flex; gap: 24px; flex-wrap: wrap;">
                            <div style="display:flex; align-items: center; gap: 8px; font-size:14.5px;">
                                <i class="fa-regular fa-calendar-check" style="color:var(--brand-color); font-size:16px;"></i>
                                <span id="summaryDate" style="font-weight:600; color:var(--text-dark);"></span>
                            </div>
                            <div style="display:flex; align-items: center; gap: 8px; font-size:14.5px;">
                                <i class="fa-regular fa-clock" style="color:var(--brand-color); font-size:16px;"></i>
                                <span id="summaryTime" style="font-weight:600; color:var(--brand-color);"></span>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep(1)"><i class="fa-solid fa-arrow-left"></i> Service Details</button>
                        <button type="button" class="btn-next" onclick="nextStep(3)">Review & Confirm <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- ══════════ STEP 3: REVIEW & CONFIRM ══════════ -->
                <div class="wizard-step" id="step-3">
                    <div class="booking-layout">
                        <!-- Summary Review Sheet -->
                        <div class="form-card" style="margin-bottom: 0;">
                            <div class="form-card-title">📋 Review Booking Details</div>
                            
                            <div style="display: flex; flex-direction: column; gap: 14px;">
                                <div style="display: flex; justify-content: space-between; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px;">
                                    <span style="color: var(--text-muted); font-weight: 500;">Service Category</span>
                                    <span id="confirmServiceType" style="font-weight: 700; color: var(--text-dark);"></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px;">
                                    <span style="color: var(--text-muted); font-weight: 500;">Problem Summary</span>
                                    <span id="confirmProblem" style="font-weight: 600; color: var(--text-dark); max-width: 250px; text-align: right; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px;">
                                    <span style="color: var(--text-muted); font-weight: 500;">Details</span>
                                    <span id="confirmAdditionalDetails" style="font-weight: 600; color: var(--text-dark); max-width: 250px; text-align: right; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 14px; border-bottom: 1px dashed var(--border-color); padding-bottom: 10px;">
                                    <span style="color: var(--text-muted); font-weight: 500;">Date & Time Slot</span>
                                    <span id="confirmDateTime" style="font-weight: 700; color: var(--brand-color);"></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 15px; font-weight: 800; padding-top: 6px;">
                                    <span style="color: var(--text-dark);">Refundable Deposit</span>
                                    <span style="color: var(--accent-green);">RM 50.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Photo Drop Zone -->
                        <div class="form-card" style="margin-bottom: 0;">
                            <div class="form-card-title">📸 Upload Issue Photo <span style="color:var(--text-muted); font-weight:400; font-size:12px;">(Optional)</span></div>
                            
                            <div class="drop-zone" id="dropZoneContainer">
                                <input type="file" id="bookingAttachment" name="bookingAttachment" accept="image/*">
                                <div class="drop-zone-info" id="dropZoneInfo">
                                    <i class="fa-regular fa-image drop-zone-icon" id="dropZoneIcon" style="color: var(--brand-color);"></i>
                                    <span class="drop-zone-text" id="dropZoneTitle">Drag & drop image or click to browse</span>
                                    <span class="drop-zone-subtext">Supports PNG, JPG, JPEG up to 4MB</span>
                                </div>
                            </div>
                            @error('bookingAttachment')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="wizard-buttons">
                        <button type="button" class="btn-prev" onclick="prevStep(2)"><i class="fa-solid fa-arrow-left"></i> Change Schedule</button>
                        <button type="button" class="btn-next" onclick="submitBookingForm()"><i class="fa-solid fa-paper-plane"></i> Submit Booking Request <i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </form>
        </main>

    <!-- Javascript Actions -->
    <script>
        let selectedDate = null;
        let selectedSlot = null;
        let currentYear  = new Date().getFullYear();
        let currentMonth = new Date().getMonth();
        let currentStep  = 1;

        // Global wizard transition functions
        function goToStep(stepNum) {
            // Update active wizard steps
            document.querySelectorAll('.wizard-step').forEach(step => {
                step.classList.remove('active');
            });
            const activeStep = document.getElementById('step-' + stepNum);
            if (activeStep) {
                activeStep.classList.add('active');
            }

            // Update stepper indicator circles
            for (let i = 1; i <= 3; i++) {
                const indicator = document.getElementById('stepIndicator-' + i);
                if (indicator) {
                    if (i === stepNum) {
                        indicator.classList.add('active');
                        indicator.classList.remove('completed');
                    } else if (i < stepNum) {
                        indicator.classList.remove('active');
                        indicator.classList.add('completed');
                    } else {
                        indicator.classList.remove('active');
                        indicator.classList.remove('completed');
                    }
                }
            }

            // Update progress line
            const progressLine = document.getElementById('stepperProgress');
            if (progressLine) {
                if (stepNum === 1) {
                    progressLine.style.width = '0%';
                } else if (stepNum === 2) {
                    progressLine.style.width = '50%';
                } else if (stepNum === 3) {
                    progressLine.style.width = '100%';
                }
            }

            currentStep = stepNum;

            // Scroll to top of content smoothly
            const mainHeader = document.querySelector('.main-header');
            if (mainHeader) {
                mainHeader.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function selectServiceCard(serviceType) {
            document.getElementById('bookingTypeInput').value = serviceType;
            
            // Remove active class from all service cards
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('active');
            });

            // Add active class to the selected card
            const selectedCard = document.querySelector(`.service-card[data-service="${serviceType}"]`);
            if (selectedCard) {
                selectedCard.classList.add('active');
            }
        }

        function showToast(msg) {
            let toast = document.getElementById('customToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'customToast';
                toast.className = 'custom-toast';
                toast.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i><span id="customToastText"></span>';
                document.body.appendChild(toast);
            }
            document.getElementById('customToastText').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3500);
        }

        function validateStep(stepNum) {
            if (stepNum === 1) {
                const serviceType = document.getElementById('bookingTypeInput').value;
                if (!serviceType) {
                    showToast('Please select a service category.');
                    return false;
                }
                const problemInput = document.getElementById('bookingProblem');
                const problemError = document.getElementById('bookingProblemJsError');
                const problem = problemInput ? problemInput.value.trim() : '';
                if (!problem) {
                    if (problemInput) {
                        problemInput.classList.add('input-error');
                        problemInput.focus();
                    }
                    if (problemError) problemError.style.display = 'flex';
                    showToast('Please enter a problem summary.');
                    return false;
                } else {
                    if (problemInput) problemInput.classList.remove('input-error');
                    if (problemError) problemError.style.display = 'none';
                }
            } else if (stepNum === 2) {
                if (!selectedDate) {
                    showToast('Please select a date from the calendar.');
                    return false;
                }
                if (!selectedSlot) {
                    showToast('Please select an available time slot.');
                    return false;
                }
            }
            return true;
        }

        function nextStep(targetStep) {
            if (targetStep > currentStep) {
                for (let step = currentStep; step < targetStep; step++) {
                    if (!validateStep(step)) {
                        return;
                    }
                }
            }

            // Populate Step 3 review summary fields
            if (targetStep === 3) {
                document.getElementById('confirmServiceType').textContent = document.getElementById('bookingTypeInput').value;
                document.getElementById('confirmProblem').textContent = document.getElementById('bookingProblem').value;
                
                const additional = document.getElementById('bookingIssueDescription').value.trim();
                document.getElementById('confirmAdditionalDetails').textContent = additional ? additional : '—';
                
                const dateText = document.getElementById('summaryDate').textContent;
                const timeText = document.getElementById('summaryTime').textContent;
                document.getElementById('confirmDateTime').textContent = dateText + ' @ ' + timeText;
            }

            goToStep(targetStep);
        }

        function prevStep(targetStep) {
            goToStep(targetStep);
        }

        function submitBookingForm() {
            if (!validateStep(1) || !validateStep(2)) {
                return;
            }
            document.getElementById('bookingForm').submit();
        }

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

            if (profileTriggerBtn && profileDropdownMenu) {
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
            }

            // Drag and drop file upload zone logic
            const dropZone = document.getElementById('dropZoneContainer');
            const fileInput = document.getElementById('bookingAttachment');
            const dropZoneTitle = document.getElementById('dropZoneTitle');
            const dropZoneSubtext = document.getElementById('dropZoneSubtext');
            const dropZoneIcon = document.getElementById('dropZoneIcon');

            if (dropZone && fileInput) {
                dropZone.addEventListener('click', () => {
                    fileInput.click();
                });

                fileInput.addEventListener('click', (e) => {
                    e.stopPropagation();
                });

                fileInput.addEventListener('change', () => {
                    handleFileSelection(fileInput.files);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.add('dragover');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        dropZone.classList.remove('dragover');
                    }, false);
                });

                dropZone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;
                    handleFileSelection(files);
                }, false);
            }

            function handleFileSelection(files) {
                if (files && files.length > 0) {
                    const file = files[0];
                    const fileSizeKB = (file.size / 1024).toFixed(1);
                    dropZoneTitle.textContent = file.name.length > 25 ? file.name.substring(0, 22) + '...' : file.name;
                    if (dropZoneSubtext) {
                        dropZoneSubtext.textContent = `File size: ${fileSizeKB} KB. Click or drag to replace.`;
                    }

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            let previewImg = document.getElementById('dropZonePreview');
                            if (!previewImg) {
                                previewImg = document.createElement('img');
                                previewImg.id = 'dropZonePreview';
                                previewImg.style.maxWidth = '120px';
                                previewImg.style.maxHeight = '120px';
                                previewImg.style.objectFit = 'cover';
                                previewImg.style.borderRadius = '8px';
                                previewImg.style.marginTop = '12px';
                                previewImg.style.border = '1px solid var(--border-color)';
                                previewImg.style.cursor = 'pointer';
                                previewImg.title = 'Click to enlarge';
                                dropZone.appendChild(previewImg);
                            }
                            previewImg.src = e.target.result;
                            previewImg.style.display = 'block';

                            previewImg.addEventListener('click', (e) => {
                                e.stopPropagation();
                                openLightbox(e.target.src, false);
                            });

                            if (dropZoneIcon) {
                                dropZoneIcon.style.display = 'none';
                            }
                        }
                        reader.readAsDataURL(file);
                    } else {
                        const previewImg = document.getElementById('dropZonePreview');
                        if (previewImg) {
                            previewImg.style.display = 'none';
                        }
                        if (dropZoneIcon) {
                            dropZoneIcon.style.display = 'block';
                            dropZoneIcon.className = 'fa-regular fa-file-image drop-zone-icon';
                        }
                    }
                } else {
                    dropZoneTitle.textContent = 'Drag & drop image or click to browse';
                    if (dropZoneSubtext) {
                        dropZoneSubtext.textContent = 'Supports PNG, JPG, JPEG up to 4MB';
                    }
                    if (dropZoneIcon) {
                        dropZoneIcon.style.display = 'block';
                        dropZoneIcon.className = 'fa-regular fa-image drop-zone-icon';
                    }
                    const previewImg = document.getElementById('dropZonePreview');
                    if (previewImg) {
                        previewImg.style.display = 'none';
                    }
                }
            }

            renderCalendar();

            // Restore old values if validation failed
            @if(old('bookingType'))
                selectServiceCard('{{ old("bookingType") }}');
            @endif

            @if(old('bookingDate'))
                selectedDate = '{{ old("bookingDate") }}';
                const oldDateObj = new Date('{{ old("bookingDate") }}');
                const isFri = oldDateObj.getDay() === 5;
                selectDate('{{ old("bookingDate") }}', isFri, oldDateObj);
                @if(old('bookingTime'))
                    setTimeout(() => {
                        const oldSlot = '{{ old("bookingTime") }}';
                        document.querySelectorAll('.slot-btn').forEach(b => {
                            if(b.dataset.val === oldSlot) b.click();
                        });
                        // Go to Step 3 if we have everything
                        goToStep(3);
                    }, 100);
                @else
                    // Go to Step 2 if we only have date
                    goToStep(2);
                @endif
            @endif

            // Lightbox close events
            const lightboxModal = document.getElementById('lightboxModal');
            const closeLightboxBtn = document.getElementById('closeLightboxBtn');
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

        const DAY_LABELS = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        const MONTHS = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];

        const REGULAR_SLOTS = [
            { val:'08:00:00', label:'8:00 AM' },
            { val:'10:00:00', label:'10:00 AM' },
            { val:'12:00:00', label:'12:00 PM' },
            { val:'14:00:00', label:'2:00 PM' },
            { val:'16:00:00', label:'4:00 PM' },
        ];

        const FRIDAY_SLOTS = [
            { val:'08:00:00', label:'8:00 AM' },
            { val:'10:00:00', label:'10:00 AM' },
            { val:'15:00:00', label:'3:00 PM' },
        ];

        function pad(n){ return String(n).padStart(2,'0'); }

        function renderCalendar() {
            const title = document.getElementById('calTitle');
            const grid  = document.getElementById('calGrid');
            if(!title || !grid) return;
            title.textContent = MONTHS[currentMonth] + ' ' + currentYear;
            grid.innerHTML = '';

            DAY_LABELS.forEach(d => {
                const lbl = document.createElement('div');
                lbl.className = 'cal-day-label';
                lbl.textContent = d;
                grid.appendChild(lbl);
            });

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth+1, 0).getDate();
            const today = new Date(); today.setHours(0,0,0,0);

            for(let i=0; i<firstDay; i++){
                const empty = document.createElement('div');
                empty.className='cal-day empty';
                grid.appendChild(empty);
            }

            for(let d=1; d<=daysInMonth; d++){
                const date = new Date(currentYear, currentMonth, d);
                const cell = document.createElement('div');
                cell.className = 'cal-day';

                const isSunday = date.getDay() === 0;
                const isFriday = date.getDay() === 5;
                const isPast   = date < today;

                if(isPast || isSunday){
                    cell.classList.add('disabled');
                } else {
                    if(isFriday) cell.classList.add('friday');
                    if(date.toDateString() === today.toDateString()) cell.classList.add('today');

                    const dateStr = currentYear+'-'+pad(currentMonth+1)+'-'+pad(d);
                    if(selectedDate === dateStr) cell.classList.add('selected');

                    cell.addEventListener('click', () => selectDate(dateStr, isFriday, date));
                }

                cell.textContent = d;
                grid.appendChild(cell);
            }
        }

        function selectDate(dateStr, isFriday, dateObj){
            selectedDate = dateStr;
            selectedSlot = null;
            document.getElementById('bookingDateInput').value = dateStr;
            document.getElementById('bookingTimeInput').value = '';
            document.getElementById('summaryCard').style.display = 'none';
            document.getElementById('fridayNote').style.display = isFriday ? 'block' : 'none';

            const fmtDate = dateObj.toLocaleDateString('en-MY',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
            document.getElementById('summaryDate').textContent = fmtDate;

            // Fetch booked slots for the selected date
            fetch(`/bookings/booked-slots?date=${dateStr}`)
                .then(res => res.json())
                .then(bookedSlots => {
                    renderSlots(isFriday ? FRIDAY_SLOTS : REGULAR_SLOTS, bookedSlots, dateStr);
                })
                .catch(err => {
                    console.error("Failed to fetch booked slots:", err);
                    renderSlots(isFriday ? FRIDAY_SLOTS : REGULAR_SLOTS, [], dateStr);
                });
            renderCalendar();
        }

        function renderSlots(slots, bookedSlots = [], dateStr = ''){
            const container = document.getElementById('slotsContainer');
            container.innerHTML = '<div class="slots-title">Select Arrival Time</div><div class="slots-grid" id="slotsGrid"></div>';
            const grid = document.getElementById('slotsGrid');

            // Format today's date to YYYY-MM-DD
            const todayObj = new Date();
            const todayStr = todayObj.getFullYear() + '-' + pad(todayObj.getMonth() + 1) + '-' + pad(todayObj.getDate());
            const currentHour = todayObj.getHours();
            const currentMin = todayObj.getMinutes();

            slots.forEach(s => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'slot-btn';
                btn.textContent = s.label;
                btn.dataset.val = s.val;

                // Check if this slot is already booked in database
                const isBooked = bookedSlots.includes(s.val);

                // Calculate lead time in hours
                const [slotHour, slotMin] = s.val.split(':').map(Number);
                const slotDateObj = new Date(dateStr + 'T' + pad(slotHour) + ':' + pad(slotMin) + ':00');
                const leadTimeHours = (slotDateObj - new Date()) / (1000 * 60 * 60);
                
                let isPastToday = leadTimeHours < 12;

                if (isBooked || isPastToday) {
                    btn.classList.add('taken');
                    btn.disabled = true;
                    if (isBooked) {
                        btn.textContent += ' (Booked)';
                    } else if (isPastToday) {
                        const isLiterallyPast = slotDateObj < new Date();
                        btn.textContent += isLiterallyPast ? ' (Passed)' : ' (Min 12h notice)';
                    }
                } else {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
                        btn.classList.add('selected');
                        selectedSlot = s.val;
                        document.getElementById('bookingTimeInput').value = s.val;
                        document.getElementById('summaryTime').textContent = s.label;
                        document.getElementById('summaryCard').style.display = 'block';
                    });
                }

                grid.appendChild(btn);
            });
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentMonth--;
            if(currentMonth < 0){ currentMonth=11; currentYear--; }
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentMonth++;
            if(currentMonth > 11){ currentMonth=0; currentYear++; }
            renderCalendar();
        });

        function openLightbox(fileUrl, isPdf) {
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxIframe = document.getElementById('lightboxIframe');
            const lightboxContent = document.getElementById('lightboxContent');

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
            const lightboxModal = document.getElementById('lightboxModal');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxIframe = document.getElementById('lightboxIframe');
            const lightboxContent = document.getElementById('lightboxContent');

            lightboxModal.style.opacity = '0';
            lightboxContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                lightboxModal.style.display = 'none';
                lightboxImg.src = '';
                lightboxIframe.src = '';
            }, 250);
        }

        // Intercept form submit event to run our wizard validation
        document.getElementById('bookingForm').addEventListener('submit', function(e){
            if (!validateStep(1) || !validateStep(2)) {
                e.preventDefault();
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
</body>
</html>
