# Expense Request System (Laravel)

A Laravel-based system for submitting, reviewing, and processing employee expense requests with support for manual and automated payments.

## 📌 Features

- Expense request submission with file upload
- Validation and clean UI feedback
- Admin approval/rejection with reason
- Batch operations on multiple requests
- Email and SMS (mocked) notifications
- Payment system with pluggable bank gateways
- Manual and scheduled (daily) auto-payments
- Modular service-based architecture
- Error handling and logging
- Fully localized in Persian (Farsi)

## 🚀 Tech Stack

- Laravel 12
- PHP 8.3+
- MySQL / MariaDB
- Blade / HTML5
- Artisan Scheduler / Jobs
- Modular Service Architecture

## ⚙️ Setup Instructions

```bash
git clone https://github.com/your-username/expense-request-system.git
cd expense-request-system
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
