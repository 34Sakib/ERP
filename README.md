<div align="center">

# 🏢 Enterprise Resource Planning (ERP) Platform

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-v7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**A modern, full-featured Enterprise Resource Planning (ERP) & Human Resource Management System (HRMS) built on Laravel 12 and Tailwind CSS.**

[Features](#-key-features--modules) • [Tech Stack](#%EF%B8%8F-technology-stack) • [Quick Start](#-quick-start-guide) • [Directory Structure](#-directory-structure)

---

</div>

## 📌 Overview

This **Enterprise ERP** system is an all-in-one management suite designed for growing businesses, corporations, and enterprise organizations. Built with Laravel 12, it provides multi-company multi-branch support, role-based security, automated payroll, HRIS, asset tracking, inventory control, financial accounting, CRM pipelines, project tracking, and recruitment management.

---

## ✨ Key Features & Modules

### 🏢 1. Core Organization Management
- **Multi-Company & Branch Support**: Isolate or consolidate operations across multiple branches and child companies.
- **Department & Designation Structure**: Hierarchical department mapping with job levels and designation titles.
- **Team Management**: Organize workforce into cross-functional working teams.

### 🔐 2. Security & Access Control (RBAC)
- **Role-Based Access Control**: Granular permissions matrix managed via `spatie/laravel-permission`.
- **System Audit Logs**: Real-time tracking of security events, administrative updates, and record mutations powered by `spatie/laravel-activitylog`.
- **Multi-Tenant Data Scope**: Automated `CompanyScope` data isolation across database queries.

### 👥 3. HRIS & Employee Management
- **Employee Directory**: Centralized profile management with digital employee profiles, personal details, and employment history.
- **Document Expiry Tracking**: Monitor passports, visas, contracts, and certifications with expiration alerts.
- **Onboarding & Offboarding**: Streamlined employee lifecycle transitions.

### ⏱️ 4. Attendance & Shift Scheduling
- **Web Punch Clock**: Real-time check-in and check-out tracking for employees.
- **Shift Management**: Flexible shift creation with standard, flexible, and night-shift options.
- **Holiday Calendar**: Configurable company and national holiday schedules.
- **Attendance Regularization**: Request and approval workflow for missed punches or attendance adjustments.

### 🌴 5. Leave Management
- **Custom Leave Types**: Annual, sick, maternity, casual, and unpaid leave definitions.
- **Leave Entitlements**: Automatic leave balance allocations and roll-overs.
- **Approval Queue**: Multi-tier leave application review system for managers and HR admins.

### 💰 6. Payroll & Financial Compensation
- **Salary Structures**: Customizable base pay, allowances, bonuses, and tax/insurance deductions.
- **Automated Payroll Runs**: Monthly salary calculation, processing, and batch approval queues.
- **Digital Payslips**: Generate and view individual payslips (exportable as PDF).
- **Loans & Advances**: Employee salary advance requests with scheduled payroll deductions.

### 🎯 7. Recruitment & ATS (Applicant Tracking System)
- **Job Openings**: Post and manage job listings with department tags, location, and requirements.
- **Candidate Pipeline**: Applicant tracking from application received, screening, interview stages to hiring.
- **Interview Scheduler**: Track candidate interview schedules and aggregate interviewer feedback.

### 📦 8. Inventory & Supply Chain
- **Product Catalog**: SKU management, stock alerts, category classifications, and pricing.
- **Multi-Warehouse Management**: Manage multiple physical or virtual storage locations.
- **Supplier Directory**: Supplier contact info, transaction logs, and performance metrics.
- **Purchase Orders (PO)**: PO generation, status tracking, and stock intake validation.
- **Stock Movements**: Track stock transfers, adjustments, receipts, and dispatch logs.

### 💼 9. CRM (Customer Relationship Management)
- **Lead Management**: Track potential leads, lead sources, priority, and conversion status.
- **Deals Pipeline**: Visual sales stages (Qualification, Proposal, Negotiation, Won/Lost).
- **Client Company Directory**: B2B customer database with linked contact persons.
- **Sales Tasks & Follow-ups**: Schedule tasks and reminders for sales representatives.

### 📊 10. Accounting & Financial Management
- **Chart of Accounts**: Comprehensive ledger setup for assets, liabilities, equity, revenues, and expenses.
- **Income & Expense Tracking**: Categorized expense entries, approval workflow, and status tracking.
- **Invoicing & Billing**: Create customer invoices, track partial or full payments, and manage due dates.
- **Payment Log**: Detailed payment receipts and financial transaction audit trails.
- **Budget Planning**: Set annual/monthly departmental budgets and monitor actual vs budgeted spending.

### 📁 11. Asset Management
- **Asset Directory**: Track hardware, office equipment, vehicles, and software licenses with unique tag codes.
- **Asset Allocations**: Issue assets to employees and manage return tracking.
- **Maintenance Records**: Log asset repairs, routine maintenance schedules, and costs.

### 🚀 12. Project & Task Management
- **Project Workspaces**: Manage projects, deadlines, budgets, status metrics, and client tags.
- **Kanban Task Boards**: Task assignments, priority levels, and progress states.
- **Time Tracking & Timelogs**: Log billable and non-billable hours spent on project tasks.

### 📢 13. Communication & Calendar
- **Notice Board**: Broadcast organization-wide announcements and publish official policy documents.
- **Company Calendar**: Interactive calendar for events, meetings, holidays, and milestones.

---

## 🛠️ Technology Stack

| Layer | Technology / Package | Description |
| :--- | :--- | :--- |
| **Framework** | [Laravel 12.x](https://laravel.com) | Modern PHP Web Framework |
| **Language** | [PHP 8.2+](https://php.net) | Backend Scripting Engine |
| **Frontend** | Blade Templates + [Tailwind CSS 4.0](https://tailwindcss.com) | Responsive & Modern UI |
| **Build Tool** | [Vite 7.0](https://vitejs.dev) | Fast Asset Bundling & Hot Module Reloading |
| **Security & RBAC** | [spatie/laravel-permission](https://spatie.be/docs/laravel-permission) | Dynamic Roles & Permissions Matrix |
| **Audit Logging** | [spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog) | Activity & Audit Event Tracking |
| **Media Storage** | [spatie/laravel-medialibrary](https://spatie.be/docs/laravel-medialibrary) | File & Document Upload Management |
| **Data Tables** | [yajra/laravel-datatables-oracle](https://github.com/yajra/laravel-datatables) | Server-side Data Tables Processing |
| **PDF Generation** | [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) | Export Payslips & Financial Reports |
| **Excel Export/Import**| [maatwebsite/excel](https://laravel-excel.com) | Import/Export Data Spreadsheets |

---

## 🚀 Quick Start Guide

### Prerequisites
Make sure you have the following installed on your development system:
- **PHP** `>= 8.2` (with PDO, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON extensions enabled)
- **Composer** `>= 2.x`
- **Node.js** `>= 18.x` & **NPM**
- **SQLite** or **MySQL** / **PostgreSQL**

---

### Step-by-Step Installation

#### 1. Clone the Repository
```bash
git clone https://github.com/your-username/ERP.git
cd ERP
```

#### 2. Install PHP Dependencies
```bash
composer install
```

#### 3. Install & Build Frontend Assets
```bash
npm install
npm run build
```

#### 4. Configure Environment
Copy the example environment file:
```bash
cp .env.example .env
```

Generate the Laravel application encryption key:
```bash
php artisan key:generate
```

#### 5. Configure Database
By default, the project is configured for **SQLite**. Create an empty SQLite file if it doesn't exist:

*On Linux/macOS:*
```bash
touch database/database.sqlite
```
*On Windows (PowerShell):*
```powershell
New-Item -ItemType File -Path database\database.sqlite -Force
```

*(Optional)* If you prefer **MySQL**, update your `.env` file accordingly:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_database
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### 6. Run Database Migrations & Seeders
Execute the migrations to set up the database tables and seed mandatory system permissions and admin accounts:
```bash
php artisan migrate --seed
```

#### 7. Start Local Development Server
Run the unified development command (starts Artisan server, Vite worker, and queue listener concurrently):
```bash
composer dev
```
Or start the server individually:
```bash
php artisan serve
```

Navigate to `http://127.0.0.1:8000` in your web browser.

---

## 📁 Directory Structure

```
ERP/
├── app/
│   ├── Http/Controllers/     # Module Controllers (HR, Finance, Asset, CRM, etc.)
│   ├── Models/               # Eloquent Models grouped by domain
│   │   ├── Asset/
│   │   ├── Attendance/
│   │   ├── CRM/
│   │   ├── Core/
│   │   ├── Employee/
│   │   ├── Finance/
│   │   ├── Inventory/
│   │   ├── Leave/
│   │   ├── Payroll/
│   │   ├── Project/
│   │   └── Recruitment/
│   └── Scopes/               # Multi-Tenant CompanyScope Filter
├── config/                   # System Configuration Files
├── database/
│   ├── migrations/           # Database Schema Migrations
│   └── seeders/              # Permissions, Roles, & Demo Data Seeders
├── public/                   # Publicly Accessible Compiled Assets
├── resources/
│   ├── css/                  # Custom CSS & Tailwind styles
│   ├── js/                   # JS logic & components
│   └── views/                # Blade Templates & Layouts
├── routes/
│   ├── web.php               # ERP Web Application Routes
│   └── console.php           # Artisan Scheduled Tasks
└── tests/                    # Feature & Unit Test Suites
```

---

## 🧪 Testing & Code Quality

Run the automated test suite using PHPUnit:
```bash
composer test
```
Or via Laravel Artisan:
```bash
php artisan test
```

Format code according to Laravel Pint coding standards:
```bash
./vendor/bin/pint
```

---

## 🛡️ Security & Privacy

If you discover any security vulnerabilities within this project, please refrain from opening a public issue. Send an email to the security team or maintainers directly.

---

## 📄 License

This software is open-sourced and licensed under the [MIT License](LICENSE).

<div align="center">
  <sub>Built with ❤️ using <a href="https://laravel.com">Laravel</a> & <a href="https://tailwindcss.com">Tailwind CSS</a>.</sub>
</div>
