<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Portal — Plumbfix</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            /* Futuristic Light Theme Palette (Teal Accent) */
            --bg-color: #f8fafc;
            --surface-color: rgba(255, 255, 255, 0.7);
            --surface-color-solid: #ffffff;
            --text-main: #475569;
            --text-muted: #94a3b8;
            --text-dark: #0f172a;
            --brand-color: #0d9488;
            --brand-light: #ccfbf1;
            --brand-dark: #0f766e;
            --border-color: rgba(226, 232, 240, 0.8);
            --hover-color: rgba(241, 245, 249, 0.8);
            
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
            --shadow-md: 0 10px 25px -5px rgba(13, 148, 136, 0.04), 0 8px 10px -6px rgba(13, 148, 136, 0.04);
            --shadow-lg: 0 20px 32px -4px rgba(13, 148, 136, 0.08), 0 12px 14px -6px rgba(13, 148, 136, 0.04);
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

        /* Ambient Blur Background */
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
            background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0) 70%);
            animation-duration: 24s;
            animation-delay: -12s;
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
            text-align: left;
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
            text-align: left;
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
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* Alert Notification styles */
        .alert-error {
            background-color: var(--accent-red-light);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--accent-red);
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }
        .alert-error i {
            font-size: 18px;
            margin-top: 2px;
        }

        .alert-success {
            background-color: var(--accent-green-light);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--accent-green);
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }

        /* Layout Grid */
        .payment-grid {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 32px;
        }

        /* Cards styling */
        .payment-card {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 32px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }
        .card-title {
            font-family: var(--font-outfit);
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }
        .card-title i {
            color: var(--brand-color);
        }

        /* Payment Method Selector */
        .method-selector {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }
        .method-option {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            border: 2px solid var(--border-color);
            border-radius: 18px;
            background-color: var(--surface-color-solid);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .method-option:hover {
            border-color: var(--brand-color);
            background-color: var(--brand-light);
        }
        .method-option.active {
            border-color: var(--brand-color);
            background-color: var(--brand-light);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.05);
        }
        .method-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background-color: #f1f5f9;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.2s ease;
        }
        .method-option.active .method-icon {
            background-color: var(--brand-color);
            color: white;
        }
        .method-name {
            display: block;
            font-family: var(--font-outfit);
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
        }
        .method-desc {
            display: block;
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Order Details Row */
        .details-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .details-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14.5px;
            padding-bottom: 12px;
            border-bottom: 1px dashed var(--border-color);
        }
        .details-item:last-child {
            border: none;
            padding-bottom: 0;
        }
        .details-label {
            color: var(--text-main);
            font-weight: 500;
        }
        .details-value {
            color: var(--text-dark);
            font-weight: 700;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-Pending {
            background-color: var(--accent-orange-light);
            color: var(--accent-orange);
            border: 1px solid rgba(245, 158, 11, 0.1);
        }
        .status-Awaiting-Verification {
            background-color: rgba(13, 148, 136, 0.08);
            color: var(--brand-color);
            border: 1px solid rgba(13, 148, 136, 0.1);
        }
        .status-Paid {
            background-color: var(--accent-green-light);
            color: var(--accent-green);
            border: 1px solid rgba(16, 185, 129, 0.15);
        }
        .status-Rejected {
            background-color: var(--accent-red-light);
            color: var(--accent-red);
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        /* DuitNow Container */
        .deposit-highlight-container {
            border: 1px solid rgba(13, 148, 136, 0.15);
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.02) 0%, rgba(248, 250, 252, 0.5) 100%);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .qr-code-box {
            width: 200px;
            padding: 12px;
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }
        .payee-name {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--text-dark);
            display: block;
            margin-top: 4px;
            letter-spacing: 0.5px;
        }
        .pay-instruction-badge {
            background: var(--brand-light);
            border: 1px solid rgba(13, 148, 136, 0.1);
            padding: 8px 16px;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            margin-top: 6px;
            color: var(--brand-color);
            font-size: 13.5px;
            font-weight: 700;
        }

        /* Bank Transfer Details Card */
        .bank-card-container {
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            color: white;
            padding: 24px;
            border-radius: 20px;
            box-shadow: var(--shadow-md);
            margin-bottom: 8px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .bank-card-container::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }
        .bank-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .bank-logo {
            font-family: var(--font-outfit);
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .bank-type {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background-color: rgba(0, 0, 0, 0.15);
            padding: 4px 8px;
            border-radius: 6px;
        }
        .bank-field {
            margin-bottom: 12px;
            text-align: left;
        }
        .bank-field:last-child {
            margin-bottom: 0;
        }
        .bank-field-label {
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgba(255, 255, 255, 0.75);
            margin-bottom: 2px;
            display: block;
            font-weight: 600;
        }
        .bank-field-value {
            font-size: 16px;
            font-weight: 700;
            font-family: var(--font-outfit);
            letter-spacing: 0.5px;
        }
        .bank-account-copy-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-copy {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: var(--font-sans);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            outline: none;
        }
        .btn-copy:hover {
            background-color: rgba(255, 255, 255, 0.35);
        }

        /* File Upload styling */
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            padding: 32px 20px;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .file-upload-wrapper:hover {
            border-color: var(--brand-color);
            background-color: var(--brand-light);
        }
        .file-upload-wrapper input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .file-upload-info i {
            font-size: 36px;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: block;
        }
        .upload-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-dark);
            display: block;
        }
        .upload-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            display: block;
            margin-top: 6px;
        }

        .btn-submit {
            display: block;
            width: 100%;
            background-color: var(--brand-color);
            color: white;
            font-family: var(--font-outfit);
            font-size: 15px;
            font-weight: 800;
            padding: 16px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
            text-align: center;
            margin-top: 24px;
        }
        .btn-submit:hover {
            background-color: var(--brand-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3);
        }

        .field-error {
            color: var(--accent-red);
            font-size: 12.5px;
            font-weight: 600;
            margin-top: 8px;
            text-align: left;
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
            .payment-grid {
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
        <header class="main-header">
            <div class="welcome-meta">
                <button class="mobile-hamburger" id="mobileHamburger" aria-label="Open Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="welcome-text">
                    <h1>Complete Your Deposit Payment</h1>
                    <p>Secure scan & pay portal for booking confirmations</p>
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

        <main class="content">
            <!-- Alert message for Rejection -->
            @if ($booking->paymentStatus === 'Rejected')
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        <strong>Your payment receipt has been rejected. Please upload a new payment proof.</strong>
                        <div style="margin-top: 6px; font-weight: 500; font-size: 13px;">
                            <strong>Reason:</strong> {{ $booking->rejectionReason }}
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <div class="payment-grid">
                <!-- LEFT: Method Selection and Instructions -->
                <div>
                    <!-- Payment Method Toggles -->
                    @if ($booking->paymentStatus === 'Pending' || $booking->paymentStatus === 'Rejected')
                        <div class="method-selector">
                            <div class="method-option active" id="method-qr" onclick="selectPaymentMethod('DuitNow QR')">
                                <div class="method-icon"><i class="fa-solid fa-qrcode"></i></div>
                                <div class="method-details">
                                    <span class="method-name">DuitNow QR</span>
                                    <span class="method-desc">Scan and pay instantly</span>
                                </div>
                            </div>
                            <div class="method-option" id="method-bank" onclick="selectPaymentMethod('Online Banking')">
                                <div class="method-icon"><i class="fa-solid fa-building-columns"></i></div>
                                <div class="method-details">
                                    <span class="method-name">Online Banking</span>
                                    <span class="method-desc">Manual bank transfer</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Detail Sections -->
                    <div class="payment-card">
                        <!-- DuitNow QR Section -->
                        <div id="qr-details" style="display: block;">
                            <div class="card-title">
                                <i class="fa-solid fa-qrcode"></i> DuitNow QR Code
                            </div>
                            
                            <div class="deposit-highlight-container">
                                <span class="deposit-title" style="color:var(--text-dark); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">DuitNow National QR</span>
                                <div class="qr-code-box">
                                    <img src="{{ asset('images/company_qr.jpg') }}" alt="DuitNow QR Code" style="width: 100%; height: auto; border-radius: 10px; display: block;">
                                </div>
                                <div>
                                    <span class="payee-name">PLUMBFIX SERVICES</span>
                                    <div class="pay-instruction-badge">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                        <span>Scan to pay <strong>RM {{ number_format($booking->bookingDepositAmount, 2) }}</strong> deposit</span>
                                    </div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--text-muted); text-align: center; margin-top: 12px; line-height: 1.5;">
                                Open your preferred Malaysian banking app (MAE, CIMB, TNG eWallet, etc.) and scan the QR code above to pay.
                            </p>
                        </div>

                        <!-- Bank Transfer Section -->
                        <div id="bank-details" style="display: none;">
                            <div class="card-title">
                                <i class="fa-solid fa-building-columns"></i> Online Banking Details
                            </div>

                            <div class="bank-card-container">
                                <div class="bank-card-header">
                                    <div class="bank-logo">
                                        <i class="fa-solid fa-building-columns"></i> MAYBANK
                                    </div>
                                    <div class="bank-type">TRANSFER TARGET</div>
                                </div>
                                <div class="bank-card-body">
                                    <div class="bank-field">
                                        <span class="bank-field-label">Account Holder Name</span>
                                        <span class="bank-field-value">Plumbfix Services</span>
                                    </div>
                                    <div class="bank-field">
                                        <span class="bank-field-label">Account Number</span>
                                        <div class="bank-account-copy-row">
                                            <span class="bank-field-value" id="account-number">112345678901</span>
                                            <button type="button" class="btn-copy" onclick="copyAccountNumber()" id="copyBtn">
                                                <i class="fa-regular fa-copy"></i> Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bank-field" style="margin-bottom: 0;">
                                        <span class="bank-field-label">Deposit Amount Due</span>
                                        <span class="bank-field-value" style="font-size: 20px;">RM {{ number_format($booking->bookingDepositAmount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--text-muted); text-align: center; margin-top: 16px; line-height: 1.5;">
                                Log in to your banking portal, execute an instant transfer to the account details listed above, and download the transaction receipt.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Summary and Form Submission -->
                <div>
                    <!-- Order Summary -->
                    <div class="payment-card">
                        <div class="card-title">
                            <i class="fa-solid fa-clipboard-list"></i> Order Summary
                        </div>
                        
                        <div class="details-list">
                            <div class="details-item">
                                <span class="details-label">Order/Booking ID</span>
                                <span class="details-value">#{{ $booking->bookingID }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Order Date & Time</span>
                                <span class="details-value">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->timezone('Asia/Kuala_Lumpur')->format('d M Y, h:i A') }}
                                </span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Customer Name</span>
                                <span class="details-value">{{ $customer->customerName }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Service Type</span>
                                <span class="details-value">{{ $booking->bookingType }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Deposit Due</span>
                                <span class="details-value" style="color: var(--brand-color); font-size: 16px;">
                                    RM {{ number_format($booking->bookingDepositAmount, 2) }}
                                </span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Payment Status</span>
                                <span class="status-badge status-{{ str_replace(' ', '-', $booking->paymentStatus) }}">
                                    {{ $booking->paymentStatus }}
                                </span>
                            </div>
                            @if ($booking->paymentStatus !== 'Pending' && $booking->paymentStatus !== 'Rejected')
                                <div class="details-item">
                                    <span class="details-label">Selected Method</span>
                                    <span class="details-value" style="color: var(--text-dark); font-weight: 700;">
                                        <i class="{{ $booking->paymentMethod === 'DuitNow QR' ? 'fa-solid fa-qrcode' : 'fa-solid fa-building-columns' }}"></i>
                                        {{ $booking->paymentMethod ?? 'DuitNow QR' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Receipt Upload Form -->
                    @if ($booking->paymentStatus === 'Pending' || $booking->paymentStatus === 'Rejected')
                        <div class="payment-card">
                            <div class="card-title">
                                <i class="fa-solid fa-receipt"></i> Upload Receipt
                            </div>

                            <form action="{{ route('customer.payment.upload', $booking->bookingID) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Hidden Payment Method Value -->
                                <input type="hidden" name="payment_method" id="selected-payment-method" value="DuitNow QR">

                                <div class="file-upload-wrapper" id="receiptUploadWrapper">
                                    <input type="file" id="payment_receipt" name="payment_receipt" accept="image/*,.pdf" required>
                                    <div class="file-upload-info" style="pointer-events: none;">
                                        <i class="fa-solid fa-file-invoice-dollar" style="color: var(--brand-color);"></i>
                                        <span class="upload-title" id="receiptNameDisplay">Drag & drop or click to upload receipt</span>
                                        <span class="upload-subtitle">JPG, JPEG, PNG, or PDF up to 5MB</span>
                                    </div>
                                </div>
                                @error('payment_receipt')
                                    <div class="field-error">⚠️ {{ $message }}</div>
                                @enderror
                                <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 18px; margin-top: 18px; text-align: left;">
                                    <input type="checkbox" id="terms_accepted" name="terms_accepted" value="1" style="margin-top: 4px; cursor: pointer; width: 16px; height: 16px; accent-color: var(--brand-color);" required>
                                    <label for="terms_accepted" style="font-size: 13px; color: var(--text-main); cursor: pointer; line-height: 1.4; font-family: var(--font-sans);">
                                        I agree to the <span style="font-weight: 700; color: var(--text-dark);">Plumbfix Cancellation & Refund Policy</span>:
                                        <span style="display: block; font-size: 11.5px; color: var(--text-muted); margin-top: 4px;">
                                            • Full refund if cancelled 48 hours or more before service, or within 30 minutes of booking (grace period).
                                            <br>• Partial refund (deposit minus RM3.00 admin fee) if cancelled between 24 and 48 hours before service.
                                            <br>• Deposit is non-refundable if cancelled less than 24 hours before service.
                                        </span>
                                    </label>
                                </div>
                                @error('terms_accepted')
                                    <div class="field-error">⚠️ {{ $message }}</div>
                                @enderror

                                <button type="submit" class="btn-submit">
                                    <i class="fa-solid fa-check"></i> Confirm Booking
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- Receipt Submitted / Paid Screen -->
                        <div class="payment-card" style="text-align: center; border-color: rgba(5, 150, 105, 0.2); background-color: var(--accent-green-light);">
                            <div style="font-size: 44px; color: var(--accent-green); margin-bottom: 12px;">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <h3 style="color: var(--text-dark); font-family: var(--font-outfit); font-weight: 800; margin-bottom: 8px;">Receipt Submitted</h3>
                            <p style="font-size: 14px; line-height: 1.5; color: var(--text-main);">
                                Your payment is currently under review by our administrators. You will be notified once verified.
                            </p>
                            
                            @if ($booking->paymentStatus === 'Paid')
                                <a href="{{ route('customer.booking.receipt.download', $booking->bookingID) }}" class="btn-submit" style="background-color: var(--accent-green); margin-top: 20px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);">
                                    <i class="fa-solid fa-download"></i> Download Official Receipt
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Javascript Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.getElementById('payment_receipt');
            const fileNameDisplay = document.getElementById('receiptNameDisplay');
            const wrapper = document.getElementById('receiptUploadWrapper');

            if (fileInput && fileNameDisplay) {
                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        fileNameDisplay.textContent = file.name;
                        wrapper.style.borderColor = 'var(--brand-color)';
                        wrapper.style.backgroundColor = 'var(--brand-light)';
                    } else {
                        fileNameDisplay.textContent = 'Drag & drop or click to upload receipt';
                        wrapper.style.borderColor = 'var(--border-color)';
                        wrapper.style.backgroundColor = '#f8fafc';
                    }
                });
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

            // Profile Dropdown Toggle
            const profileBtn = document.getElementById('profileTriggerBtn');
            const profileMenu = document.getElementById('profileDropdownMenu');

            if (profileBtn && profileMenu) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                    const nMenu = document.getElementById('notificationDropdownMenu');
                    if (nMenu && nMenu.classList.contains('show')) {
                        nMenu.classList.remove('show');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }
        });

        function selectPaymentMethod(method) {
            const inputField = document.getElementById('selected-payment-method');
            if (!inputField) return;
            
            inputField.value = method;
            
            const qrOption = document.getElementById('method-qr');
            const bankOption = document.getElementById('method-bank');
            const qrDetails = document.getElementById('qr-details');
            const bankDetails = document.getElementById('bank-details');
            
            if (method === 'DuitNow QR') {
                qrOption.classList.add('active');
                bankOption.classList.remove('active');
                qrDetails.style.display = 'block';
                bankDetails.style.display = 'none';
            } else {
                bankOption.classList.add('active');
                qrOption.classList.remove('active');
                bankDetails.style.display = 'block';
                qrDetails.style.display = 'none';
            }
        }

        function copyAccountNumber() {
            const accNum = document.getElementById('account-number').innerText;
            navigator.clipboard.writeText(accNum).then(() => {
                const copyBtn = document.getElementById('copyBtn');
                const origHTML = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
                copyBtn.style.backgroundColor = '#059669';
                setTimeout(() => {
                    copyBtn.innerHTML = origHTML;
                    copyBtn.style.backgroundColor = '';
                }, 2000);
            });
        }
    </script>
</body>
</html>
