# LetCon - Laravel Application Documentation

## Project Overview

**LetCon** is a Laravel-based web application built with modern Laravel ecosystem tools. It appears to be a referral and earning system with user management, wallet functionality, and level-based progression.

## Technology Stack

### Core Framework
- **PHP**: 8.2.12
- **Laravel Framework**: 12.21.0 (Latest Laravel 12)
- **Database**: MySQL

### Frontend & UI
- **Livewire**: 3.6.4 (Full-stack framework for dynamic UIs)
- **Livewire Volt**: 1.7.1 (Single-file Livewire components)
- **Flux UI**: 2.2.3 (Free edition - Component library for Livewire)
- **Tailwind CSS**: 4.1.11 (Utility-first CSS framework)
- **Vite**: 7.0.4 (Build tool and dev server)

### Development & Testing
- **Pest**: 3.8.2 (Testing framework)
- **PHPUnit**: 11.5.15 (Unit testing)
- **Laravel Pint**: 1.24.0 (Code formatting)
- **Laravel Sail**: 1.44.0 (Docker development environment)
- **Laravel Boost**: 1.1 (Development tools)

### Additional Packages
- **Spatie Laravel Permission**: 6.21 (Role and permission management)
- **Laravel Prompts**: 0.3.6 (Interactive CLI prompts)

## Project Structure

### Application Architecture
```
letcon/
├── app/
│   ├── Console/Commands/     # Artisan commands
│   ├── Http/Controllers/     # Traditional controllers
│   ├── Livewire/            # Livewire components
│   │   └── Actions/         # Livewire actions
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── bootstrap/
│   ├── app.php              # Application bootstrap (Laravel 12 structure)
│   └── providers.php        # Service providers registration
├── config/                  # Configuration files
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
│       ├── components/      # Blade components
│       ├── flux/            # Flux UI components
│       └── livewire/        # Livewire component views
├── routes/
│   ├── auth.php             # Authentication routes
│   ├── console.php          # Console routes
│   └── web.php              # Web routes
└── tests/                   # Test files
    ├── Feature/             # Feature tests
    └── Unit/                # Unit tests
```

## Core Models & Features

### User Management
The application includes a comprehensive user system with:

- **User Model** (`app/Models/User.php`)
  - Authentication with email/password
  - Username system
  - Referral system with referral codes
  - User levels and progression
  - KYC (Know Your Customer) verification
  - Banking information
  - Role-based permissions (Spatie)

### Financial System
- **Wallet Model** (`app/Models/Wallet.php`) - User wallet management
- **Payment Model** (`app/Models/Payment.php`) - Payment processing
- **Withdrawal Model** (`app/Models/Withdrawal.php`) - Withdrawal requests
- **Earning Model** (`app/Models/Earning.php`) - Earnings tracking

### Referral System
- **Referral Model** (`app/Models/Referral.php`) - Referral tracking
- **LevelHistory Model** (`app/Models/Levelhistory.php`) - User level progression
- **LevelSupporter Model** (`app/Models/LevelSupporter.php`) - Level support system
- **LevelUpTrigger Model** (`app/Models/LevelUpTrigger.php`) - Level upgrade triggers

### Notifications
- **Notification Model** (`app/Models/Notification.php`) - User notifications

## Key Features

### 1. User Registration & Authentication
- Email-based registration
- Username system
- Referral code generation and tracking
- KYC verification system
- Role-based access control

### 2. Referral System
- Multi-level referral tracking
- Referral code generation
- Referral-based earnings
- Level progression based on referrals

### 3. Financial Management
- Digital wallet system
- Payment processing
- Withdrawal requests
- Earnings tracking and distribution

### 4. User Progression
- Level-based system
- Level upgrade triggers
- Historical level tracking
- Support system for levels

### 5. Notifications
- User notification system
- Real-time updates (via Livewire)

## Development Setup

### Prerequisites
- PHP 8.2.12 or higher
- Composer
- Node.js and npm
- MySQL database

### Installation
1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install Node.js dependencies: `npm install`
4. Copy environment file: `cp .env.example .env`
5. Generate application key: `php artisan key:generate`
6. Create database and update `.env` file
7. Run migrations: `php artisan migrate`
8. Seed database: `php artisan db:seed`

### Development Commands
```bash
# Start development server with all services
composer run dev

# Run tests
composer run test
# or
php artisan test

# Format code
vendor/bin/pint

# Build assets
npm run build

# Development build with hot reload
npm run dev
```

## Laravel 12 Features Used

### Streamlined Structure
- No `app/Http/Kernel.php` - middleware registered in `bootstrap/app.php`
- No `app/Console/Kernel.php` - console configuration in `bootstrap/app.php`
- Commands auto-register from `app/Console/Commands/`

### Modern PHP Features
- PHP 8.2 constructor property promotion
- Explicit return type declarations
- Modern array syntax

## Frontend Architecture

### Livewire 3 with Volt
- Single-file components using Volt
- Real-time UI updates without page refresh
- Server-side state management
- Alpine.js integration for client-side interactions

### Flux UI Components
Available components include:
- avatar, badge, brand, breadcrumbs
- button, callout, checkbox, dropdown
- field, heading, icon, input
- modal, navbar, profile, radio
- select, separator, switch
- text, textarea, tooltip

### Tailwind CSS 4
- Utility-first CSS framework
- Modern CSS features
- Responsive design system
- Dark mode support

## Testing Strategy

### Pest Testing Framework
- Feature tests for user workflows
- Unit tests for individual components
- Authentication tests
- Dashboard functionality tests
- Settings tests

### Test Structure
```
tests/
├── Feature/
│   ├── Auth/           # Authentication tests
│   ├── DashboardTest.php
│   └── Settings/       # Settings functionality tests
├── Unit/
└── Pest.php           # Pest configuration
```

## Database Design

### Key Tables
- `users` - User accounts and profiles
- `wallets` - User wallet balances
- `payments` - Payment transactions
- `withdrawals` - Withdrawal requests
- `earnings` - User earnings
- `referrals` - Referral relationships
- `level_histories` - User level progression
- `notifications` - User notifications

### Relationships
- Users have one wallet
- Users have many payments and withdrawals
- Users have referral relationships (parent/child)
- Users have level progression history
- Users receive notifications

## Security Features

### Authentication & Authorization
- Laravel's built-in authentication
- Spatie Laravel Permission for roles
- CSRF protection
- Password hashing
- Session management

### Data Protection
- Mass assignment protection
- Input validation
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)

## Deployment Considerations

### Environment Configuration
- Database configuration
- Mail settings
- File storage settings
- Cache configuration
- Queue configuration

### Production Optimizations
- Asset compilation (`npm run build`)
- Configuration caching
- Route caching
- View caching
- Database optimization

## API Documentation

The application primarily uses Livewire for dynamic interactions, but may include API endpoints for:
- User authentication
- Payment processing
- Notification delivery
- Data synchronization

## Contributing Guidelines

### Code Standards
- Follow Laravel conventions
- Use Laravel Pint for code formatting
- Write tests for new features
- Use descriptive variable and method names
- Follow PSR-12 coding standards

### Development Workflow
1. Create feature branch
2. Implement changes with tests
3. Run code formatting: `vendor/bin/pint`
4. Run tests: `php artisan test`
5. Submit pull request

## Support & Maintenance

### Logging
- Application logs in `storage/logs/`
- Laravel Pail for log monitoring
- Error tracking and debugging

### Performance Monitoring
- Database query optimization
- Eager loading to prevent N+1 queries
- Caching strategies
- Asset optimization

---

*This documentation provides a comprehensive overview of the LetCon Laravel application. For specific implementation details, refer to the source code and inline documentation.*
