# Laravel Expense Request System

A Laravel-based backend system for managing expense requests with approval, rejection (with reason), manual and automated payment handling, and modular gateway integration.

## 📌 Features

- Submit expense requests with optional attachment
- Admin review panel with:
  - Approve / Reject individual or bulk requests
  - Rejection reason support
  - File download
- Notifications:
  - Email and (stubbed) SMS for rejected requests
- Payment System:
  - Manual payments per request
  - Auto-pay daily at 8:00 AM
  - Modular bank gateway detection via IBAN prefix
- Logging & Error Tracking:
  - Detailed logs stored in `payment_logs` table

---

## ⚙️ Tech Stack

- **Laravel 12**
- PHP 8.2+
- MySQL
- Laravel Scheduler (for automated tasks)

---

## 📁 Project Structure Highlights

app/
├── Http/
│ └── Controllers/
│ └── ExpenseRequestController.php
│ └── PaymentController.php
├── Services/
│ └── Payment/
│ ├── Contracts/
│ ├── Gateways/
│ ├── Requests/
│ └── PaymentService.php
├── Jobs/
│ └── AutoPayApprovedExpenses.php

yaml
Copy
Edit

---

## 🧪 Testing

This project is prepared with modular, service-oriented architecture. While automated tests are not included, the structure allows for straightforward unit and feature testing, especially around:

- Payment gateways
- Expense request workflow
- Notifications

---

## 🛠 Setup & Usage

### Step 1: Clone the Repository

```bash
git clone https://github.com/amirayinie/expense-request-system.git
cd expense-request-system
Step 2: Install Dependencies
bash
Copy
Edit
composer install
cp .env.example .env
php artisan key:generate
Step 3: Migrate Database
bash
Copy
Edit
php artisan migrate
Step 4: Seed Dummy Users (Optional)
If needed, add test users manually or via seeder.

🏦 Bank Gateway Detection
The system uses the second and third digits of the IBAN to detect which gateway to use:

IBAN Prefix	Bank Gateway
IR12	Bank1
IR22	Bank2
IR33	Bank3

Each gateway is encapsulated in its own class and follows the PayableInterface contract.

🔄 Scheduled Auto Payment
Uses Laravel's scheduler to auto-pay approved, unpaid requests daily at 8:00 AM.

Registered in bootstrap/app.php:

php
Copy
Edit
use App\Jobs\AutoPayApprovedExpenses;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new AutoPayApprovedExpenses)->dailyAt('08:00');
You must run the scheduler with:

bash
Copy
Edit
php artisan schedule:run
🧩 Extending the System
To add a new bank gateway: create a class in App\Services\Payment\Gateways and implement PayableInterface.

Add its IBAN prefix to the $map in PaymentController.

⚠️ Notes
Actual payment and SMS APIs are stubbed. Replace with real integrations if needed.

SMS sending code is marked via comments inside NotificationService.

📮 Contact
For any questions or improvements, feel free to reach out or open a pull request.
