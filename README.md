# 🛠️ Plumbfix - Plumbing Service & Operations Management System

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4-38BDF8?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS v4">
  <img src="https://img.shields.io/badge/Database-PostgreSQL%20%2F%20MySQL-4479A1?style=for-the-badge&logo=postgresql&logoColor=white" alt="Database">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License MIT">
</p>

---

## 🌐 Live System Demo

Experience the live application online:

👉 **[Launch Plumbfix Live Demo](https://plumbfix.onrender.com)**

### 🔑 Demo Login Accounts

You can test the application using the pre-configured demo accounts below:

| Account Type | Portal Link | Email | Password |
|---|---|---|---|
| 👷 **Staff / Plumber** | [Staff Login](https://plumbfix.onrender.com/staff/login) | `staff@gmail.com` | `staff123` |
| 👤 **Customer** | [Customer Login](https://plumbfix.onrender.com/login) | `customer@gmail.com` | `customer123` |

> ℹ️ *Note: You can also register a new Customer account or sign in via Google OAuth on the Customer Login page.*

---

## 📌 Overview

**Plumbfix** is a comprehensive, full-stack Web Application designed to streamline plumbing service bookings, technician dispatching, payment verification, and real-time customer-staff communication. Built with **Laravel 12**, **Tailwind CSS**, and modern web architectures, Plumbfix bridges the gap between plumbing service providers and customers with an intuitive, multi-portal system.

---

## ✨ Key Features

### 👤 Customer Portal
- **Online Booking System**: Select plumbing service categories, specify urgency, set preferred appointment dates, and attach issue details.
- **Payment Verification**: Deposit & payment upload via DuitNow QR or manual receipt upload with instant status tracking.
- **Real-Time Live Chat**: Direct communication channel with assigned plumbers/staff powered by **Pusher WebSockets**.
- **Automated Invoicing & Receipts**: Instant generation and download of PDF invoices and receipts using **DomPDF**.
- **Job Status Tracking**: Real-time progress monitoring from appointment confirmation to job completion.
- **Feedback & Rating System**: Rate completed jobs and submit service feedback.

### 🔑 Staff & Admin Dashboard
- **Operations Dashboard**: Centralized view of pending bookings, active jobs, payment verifications, and technician availability.
- **Job Scheduling & Dispatch**: Assign qualified plumbers to customer requests based on schedule and location.
- **Payment & Refund Management**: Verify uploaded receipts, approve payment deposits, and process refunds.
- **Analytics & Reporting**: Visual metrics on revenue, completed jobs, customer satisfaction, and service performance.

### 🔐 Security & Integrations
- **Authentication**: Email/Password authentication & **Google OAuth** integration via Laravel Socialite.
- **Role-Based Access Control (RBAC)**: Strict authorization guards distinguishing Customer, Staff, and Administrator capabilities.
- **Automated Email Notifications**: Service updates and transactional emails integrated via **Brevo API**.

---

## 🏗️ Technology Stack

| Component | Technology |
|---|---|
| **Backend Framework** | [Laravel 12](https://laravel.com/) (PHP 8.2+) |
| **Frontend UI** | Blade Templates, [Tailwind CSS v4](https://tailwindcss.com/), JavaScript |
| **Database** | MySQL / SQLite |
| **Real-Time Messaging** | Pusher WebSockets & Laravel Echo |
| **OAuth Authentication** | Laravel Socialite (Google Sign-In) |
| **PDF Generation** | DomPDF (`barryvdh/laravel-dompdf`) |
| **Email Gateway** | Brevo API / SMTP |
| **Build Tooling** | Vite, Composer, NPM |

---

## 📁 System Architecture & Documentation

This repository includes extensive system design, architectural diagrams, and Software Requirements Specifications (SRS):

- 📐 [`SYSTEM_ARCHITECTURE.md`](./SYSTEM_ARCHITECTURE.md) - High-level multi-tier architectural breakdown.
- 🔄 [`SYSTEM_SEQUENCE_DIAGRAMS.md`](./SYSTEM_SEQUENCE_DIAGRAMS.md) - Detailed sequence flows for bookings, chat, and payments.
- 🗄️ [`DATA_DICTIONARY.md`](./DATA_DICTIONARY.md) - Database schema specifications.
- 📋 [`USE_CASE_DESCRIPTIONS.md`](./USE_CASE_DESCRIPTIONS.md) - Functional use case breakdowns.

---

## 🚀 Getting Started

Follow these steps to set up and run Plumbfix locally.

### Prerequisites

Ensure you have the following installed on your development machine:
- **PHP** `>= 8.2` (with PDO, OpenSSL, Mbstring extensions)
- **Composer** `>= 2.0`
- **Node.js** `>= 18.0` & **NPM**
- **Git**

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/YOUR_USERNAME/Plumbfix.git
   cd Plumbfix
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   Copy the `.env.example` file to create your `.env` configuration:
   ```bash
   cp .env.example .env
   ```
   Generate the application encryption key:
   ```bash
   php artisan key:generate
   ```

5. **Database Setup & Migrations**
   Configure your database credentials in the `.env` file (SQLite or MySQL), then run:
   ```bash
   php artisan migrate --seed
   ```

6. **Build Assets & Launch Development Server**
   Run the development servers concurrently:
   ```bash
   npm run dev
   ```
   In a separate terminal, start the Laravel server:
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your web browser.

---

## 🧪 Testing

Run the automated test suite using PHPUnit / Laravel Test Runner:

```bash
php artisan test
```

---

## 👤 Author

Developed by **Adib** as part of an academic & professional software engineering portfolio.

---

## 📄 License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).
