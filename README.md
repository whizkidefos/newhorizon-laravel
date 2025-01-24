# New Horizon Healthcare - Employee Management System

## About New Horizon Healthcare

New Horizon Healthcare is a comprehensive employee management system designed specifically for healthcare professionals. Our platform streamlines the management of healthcare staff, their training records, work history, and shift scheduling.

## Features

- **User Management**
  - Role-based access control (Admin, Staff)
  - Profile management
  - Bank details management
  - Work history tracking
  - Training records management

- **Course Management**
  - Online course catalog
  - Course enrollment
  - Progress tracking
  - Completion certificates

- **Shift Management**
  - Available shifts listing
  - Shift booking system
  - Work schedule management
  - Timesheet tracking

- **Document Management**
  - Secure document storage
  - Document sharing
  - Version control

## Technical Stack

- **Framework**: Laravel 10.x
- **Frontend**: 
  - Blade Templates
  - Tailwind CSS
  - Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel-permission

## Installation

1. Clone the repository
```bash
git clone https://github.com/whizkidefos/newhorizon-laravel.git
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database
```bash
php artisan migrate
php artisan db:seed
```

5. Start development servers
```bash
php artisan serve
npm run dev
```

## Contributing

Please read our [Contributing Guide](CONTRIBUTING.md) before submitting a Pull Request to the project.

## Security

If you discover any security related issues, please email security@newhorizonhealthcare.com instead of using the issue tracker.

## License

The New Horizon Healthcare platform is proprietary software. 2024 New Horizon Healthcare Ltd.
