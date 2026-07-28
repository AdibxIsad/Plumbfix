# 🔧 Plumbfix - Online Plumbing Services & Booking Management System

[![Laravel](https://img.shields.io/badge/Framework-Laravel%2011-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/Language-PHP%208.2+-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Styling-Tailwind%20CSS-38BDF8?style=for-the-badge&logo=tailwindcss)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

---

## 📌 Project Overview

**Plumbfix** is a comprehensive, multi-tier web application designed to streamline plumbing service bookings, technician dispatching, real-time job tracking, payment verification, and customer feedback management.

Built using **Laravel 11** and structured under modern software engineering principles, Plumbfix bridges the gap between homeowners requiring urgent plumbing services and service providers managing field technicians and operations.

---

## ✨ Key Features

### 👤 Customer Portal
- **Service Booking**: Interactive booking workflow with date/time selection, service categories, and address geolocation.
- **Deposit & Payment Upload**: Secure payment proof submission (DuitNow QR & online receipts).
- **Real-Time Job Tracking**: Live status updates on assigned plumbers, job progression, and completion.
- **Digital Invoices & Receipts**: Downloadable PDF receipts and invoices generated dynamically via DomPDF.
- **Customer Ratings & Feedback**: Rating system with review submission for completed service requests.
- **Profile & Avatar Management**: User profile customization with avatar upload support.

### 🔑 Staff & Admin Portal
- **Management Dashboard**: Real-time overview of active bookings, total revenue, pending payment verifications, and plumber availability.
- **Job Dispatch & Plumber Assignment**: Assign qualified plumbers to customer booking requests based on location and availability.
- **Payment & Refund Verification**: Staff workflow to review uploaded payment receipts, verify transactions, or process refund requests.
- **Printable Job Records**: Generate official job completion records for audit and record-keeping.
- **Analytics & Reporting**: Charts and summary reports for service performance and business growth.

---

## 🛠️ Technology Stack

| Layer | Technology |
| :--- | :--- |
| **Backend Framework** | [Laravel 11](https://laravel.com/) (PHP 8.2+) |
| **Frontend UI** | Blade Templates, JavaScript (ES6+), HTML5, CSS3 / Tailwind CSS |
| **Database** | MySQL / SQLite |
| **PDF Generation** | DomPDF (`barryvdh/laravel-dompdf`) |
| **Email Gateway** | Brevo API / Laravel Mail |
| **Real-time Messaging** | Pusher WebSockets & Echo |
| **Authentication** | Custom Laravel Auth Guard + Google OAuth Integration |

---

## 📁 System Architecture & Documentation

This repository includes full software design documentation, UML diagrams, and requirement specs:

- 📐 **[SYSTEM_ARCHITECTURE.md](./SYSTEM_ARCHITECTURE.md)**: Multi-tier architecture overview and component diagrams.
- 🔄 **[ACTIVITY_DIAGRAMS.md](./ACTIVITY_DIAGRAMS.md)**: Process flow diagrams for bookings, payments, and dispatch.
- 🗃️ **[DATA_DICTIONARY.md](./DATA_DICTIONARY.md)**: Detailed schema specifications for database tables.
- 📊 **[ERD_DESCRIPTIONS.md](./ERD_DESCRIPTIONS.md)**: Entity-Relationship Diagram specifications.
- 📋 **[USE_CASE_DESCRIPTIONS.md](./USE_CASE_DESCRIPTIONS.md)**: Use case specifications for all system roles.
- 💬 **[SYSTEM_SEQUENCE_DIAGRAMS.md](./SYSTEM_SEQUENCE_DIAGRAMS.md)**: Sequence diagrams for key user interactions.

---

## 🚀 Local Installation & Setup

Follow these steps to set up and run Plumbfix on your local development environment:

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js (v18+) & NPM
- MySQL / MariaDB Server

### Steps

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
   Copy the example environment file and configure your database settings:
   ```bash
   cp .env.example .env
   ```
   Update `.env` with your local database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=plumbfix
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Build Frontend Assets & Run Server**
   In terminal 1 (Vite Dev Server):
   ```bash
   npm run dev
   ```
   In terminal 2 (Laravel Local Server):
   ```bash
   php artisan serve
   ```

9. **Access Application**
   Open your browser and visit: `http://127.0.0.1:8000`

---

## 🧪 Testing

Run the PHPUnit automated test suite:
```bash
php artisan test
```

---

## 📄 License

This project is open-source software licensed under the [MIT License](LICENSE).
