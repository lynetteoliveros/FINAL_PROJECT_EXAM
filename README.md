# Laravel Ticket Management System

A robust ticket management system built with Laravel, designed for efficient department-based ticket handling and tracking.

## Features

### Ticket Management
- Create, view, update, and track support tickets
- Severity levels with visual indicators:
  - Critical (Red)
  - High (Orange)
  - Medium (Yellow)
  - Low (Green)
- Smart ticket sorting:
  - Primary sort by severity (Critical → High → Medium → Low)
  - Secondary sort by creation date (newest first)

### Department-Based Workflow
- Department-specific ticket views
- Inter-department ticket transfer functionality
- Transfer request tracking and notifications

### User Roles & Permissions
- Admin: Full system access
- Supervisor: Department management and critical ticket handling
- Officer: Standard ticket handling
- Junior Officer: Basic ticket handling

### Notification System
- Real-time notifications for:
  - Ticket assignments
  - Status changes
  - Department transfers
  - New remarks/comments

### Additional Features
- User profile management
- Dark mode support
- Responsive design
- Ticket search and filtering
- Ticket remarks/comments system

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
- XAMPP/WAMP/LAMP (or similar)

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd laravel-ticket
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install and compile frontend dependencies:
```bash
npm install
npm run dev
```

4. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ticket
DB_USERNAME=root
DB_PASSWORD=
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

## Running the Application

1. Start your local development server:
```bash
php artisan serve
```

2. Start the Vite development server:
```bash
npm run dev
```

3. Access the application at: `http://localhost:8000`

### Default Login Credentials

```
Admin:
Email: admin@example.com
Password: password

Supervisor:
Email: supervisor@example.com
Password: password

Officer:
Email: officer@example.com
Password: password

Junior Officer:
Email: junior@example.com
Password: password
```

## Usage

1. Login with your credentials
2. Navigate to the tickets section to:
   - View all tickets (Admin)
   - View department tickets (Department users)
   - Create new tickets
   - Update existing tickets
   - Transfer tickets between departments
   - Add remarks/comments

## Security

- Authentication required for all ticket operations
- Role-based access control
- CSRF protection
- XSS protection
- Input validation and sanitization

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
