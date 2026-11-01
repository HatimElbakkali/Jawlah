# JAWLAH

> **JAWLAH** is a modern desert tourism booking platform designed to make desert experiences more organized, transparent, and accessible for travelers.

The platform helps visitors discover desert activities and experience packages, check prices and availability, make organized reservations, and receive booking confirmations, all from one place.

The project includes a complete booking flow, activity management, a contact system, two separate dashboards (**Admin** and **Employee**), MySQL database integration, and automated email notifications.

---

## The Problem & Our Solution

### The Problem

Desert tourism can sometimes be disorganized, especially for visitors who are unfamiliar with the area.

Travelers may face challenges such as:

* Unclear or inconsistent activity prices
* Unauthorized middlemen offering tours and activities
* Difficulty finding trusted activity providers
* Lack of organized booking systems
* Limited information about activity duration and availability
* Difficulty comparing individual activities and experience packages
* Uncertainty about reservations and booking confirmation

These issues can make the desert experience confusing and less transparent for travelers.

### The JAWLAH Solution

**JAWLAH** aims to provide a centralized and organized platform for desert tourism.

Through the platform, travelers can:

* Discover desert activities and experience packages
* View clear and transparent prices
* Check availability and select a suitable date and time
* View activity duration and important details
* Select the number and type of passengers
* Review the complete booking summary before confirmation
* Receive a unique booking reference
* Receive an automated booking confirmation by email
* Connect more directly with organized service providers
* Reduce dependency on unauthorized middlemen

The goal of **JAWLAH** is not only to provide an online booking system, but also to contribute to a more **organized, transparent, reliable, and accessible desert tourism experience** for both travelers and service providers.

---

## Features

### Activities & Experiences

* Browse individual desert activities
* Browse activity packages
* View activity information, duration, price, and availability
* Responsive tour interface

### Booking System

* Multi-step booking experience
* Select reservation date and time
* Select activity duration
* Choose number of passengers
* Automatic price calculation
* Booking confirmation
* Unique booking reference generation (for example `JWL-XXXXXX`)
* The same reference is saved in the database, shown to the customer, and sent in the confirmation email

### Passenger Management

* Adults
* Children
* Infants
* Booking validation before confirmation

### Price Calculation

* Dynamic total price calculation
* Price per person
* Passenger-based pricing
* Booking summary before confirmation

### Email System

* Booking confirmation emails
* Contact form notifications
* HTML-designed email templates
* Gmail SMTP integration using **PHPMailer**
* Sensitive SMTP credentials stored securely using `.env`

### Contact System

* Customer contact form
* Client-side validation
* Server-side processing
* Messages stored in the database
* Email notification when a new message is submitted

---

## Dashboards

JAWLAH includes two separate dashboards with different access levels.

### Admin Dashboard

Full control of the platform, available at `/admin`.

* Dashboard statistics (total bookings, revenue, activities, packs, messages)
* Recent bookings
* Bookings management: search by booking code, customer, email, phone, or activity, filter by type, status, and date, update status, delete
* Activities management (create, edit, change availability status, delete)
* Activity packs management (create, edit, change availability status, delete)
* Availability overview calculated from existing bookings and capacity
* Customer messages (mark as read, delete)

### Employee Dashboard

A simpler dashboard for staff who handle daily operations, available at `/employee`.

* Separate login page (session based)
* Bookings list with search and filters, status updates, and deletion
* Availability overview
* Customer messages with an unread counter (mark as read, delete)
* No access to activities or packs management, and no dashboard statistics

---

## Configuration & Security

* Environment variables using `.env`
* Database credentials are not stored directly in the source code
* Gmail App Password is protected
* `.env` excluded from Git using `.gitignore`
* PDO prepared statements for database operations
* Session-based authentication for the dashboards
* User input is escaped before it is placed inside email templates

> Before deploying, change the default employee credentials defined in the employee controller, and use a strong password for the database and the Gmail App Password.

---

## Built With

[![My Skills](https://skillicons.dev/icons?i=php,mysql,html,css,js)](https://skillicons.dev)

### Backend

* PHP
* PHP OOP
* MVC Architecture
* PDO
* MySQL

### Frontend

* HTML5
* CSS3
* Vanilla JavaScript

### Tools & Libraries

* Composer
* PHPMailer
* PHP dotenv
* Git
* GitHub

---

## Architecture

JAWLAH follows an **MVC-style architecture** to separate application responsibilities.

```text
JAWLAH/
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── services/
│   └── views/
│
├── authentication/
│
├── config/
│   └── config.php
│
├── public/
│   ├── assets/
│   ├── css/
│   ├── js/
│   └── index.php
│
├── routes/
│   └── route.php
│
├── schema/
│   └── jawlah.sql
│
├── .env
├── .env.example
├── .gitignore
├── .htaccess
├── composer.json
├── composer.lock
└── index.php
```

> `.env` is intentionally excluded from GitHub because it contains private configuration values.

---

## Installation

### 1. Clone the repository

```bash
git clone YOUR_REPOSITORY_URL
```

Then enter the project directory:

```bash
cd JAWLAH
```

### 2. Install PHP dependencies

Make sure Composer is installed, then run:

```bash
composer install
```

### 3. Create your environment file

Copy:

```text
.env.example
```

and create:

```text
.env
```

Example configuration:

```env
# Mail Config
SMTP_HOST=smtp.gmail.com
SMTP_AUTH=true
SMTP_USER=
SMTP_PASS=
SMTP_SECURE=tls
SMTP_PORT=587
FROM_EMAIL=
FROM_NAME=JAWLAH

# Database Config
DB_HOST=localhost
DB_NAME=
DB_USER=
DB_PASSWORD=
```

Add your own database and SMTP credentials.

Never commit your `.env` file.

---

## Database Setup

Import:

```text
schema/jawlah.sql
```

into your MySQL server.

Then configure your database credentials inside `.env`.

Example:

```env
DB_HOST=localhost
DB_NAME=jawlah
DB_USER=root
DB_PASSWORD=
```

---

## Run Locally

You can run the project using PHP's built-in development server:

```bash
php -S localhost:8000
```

Then open:

```text
http://localhost:8000
```

Dashboards:

```text
http://localhost:8000/admin
http://localhost:8000/employee
```

---

## Deployment Notes

When deploying to a Linux hosting (for example InfinityFree), keep in mind:

* **File and folder names are case-sensitive.** `EmployeeDashboard` and `employeedashboard` are different paths on Linux, even if both work on Windows. The name used in `require` must match the real file name exactly.
* Upload the `.env` file manually, with the hosting database host, name, user, and password (not `localhost`).
* Upload the `vendor/` folder, or run `composer install` on the server if the hosting allows it.
* Disable `display_errors` in production.

---

## Composer Dependencies

The project uses Composer to manage PHP dependencies.

Main dependencies include:

* PHPMailer
* vlucas/phpdotenv

The `vendor/` directory is not included in the repository.

After cloning the project, simply run:

```bash
composer install
```

---

## Environment Variables

Sensitive information is stored in:

```text
.env
```

The `.gitignore` file prevents it from being uploaded to GitHub:

```gitignore
.env
/vendor/
.vscode/
.DS_Store
```

A safe template is available as:

```text
.env.example
```

---

## Project Goal

JAWLAH was created to build a complete tourism booking experience where visitors can easily discover desert activities, check available experiences, make reservations, and receive confirmation emails.

The project also focuses on applying real backend development concepts such as:

* Object-Oriented Programming
* MVC structure
* Database relationships
* Secure configuration
* Server-side validation
* Routing
* Email integration
* Booking management
* Role-based dashboards

---

## Future Improvements

Possible future improvements include:

* Online payment integration
* Customer accounts
* Booking cancellation system
* Advanced availability scheduling
* Stronger authentication for the admin and employee dashboards (hashed passwords stored in the database)
* Reviews and ratings
* Multiple languages
* REST API
* Improved deployment configuration

---

## Connect

If you want to see more of my work or contact me:

**All social links:**
https://linktr.ee/HatimElbakkali

---

## License

This project was created for learning, portfolio, and development purposes.

---

Thank you for checking out **JAWLAH**.