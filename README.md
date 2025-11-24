# SaaS Project Management & CRM System

[![Tests](https://github.com/BorschCode/filament-playground/actions/workflows/tests.yml/badge.svg)](https://github.com/BorschCode/filament-playground/actions/workflows/tests.yml)
[![PHP Version](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![FilamentPHP](https://img.shields.io/badge/Filament-v3-FDAE4B?logo=data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMiAxMkwxMiAyMkwyMiAxMkwxMiAyWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+&logoColor=white)](https://filamentphp.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-7.0-47A248?logo=mongodb&logoColor=white)](https://mongodb.com)
[![Node.js](https://img.shields.io/badge/Node.js-22-339933?logo=node.js&logoColor=white)](https://nodejs.org)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-06B6D4?logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?logo=vue.js&logoColor=white)](https://vuejs.org)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-2.0-9553E9?logo=inertia&logoColor=white)](https://inertiajs.com)
[![Docker](https://img.shields.io/badge/Docker-Sail-2496ED?logo=docker&logoColor=white)](https://laravel.com/docs/sail)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A comprehensive Laravel 12 + FilamentPHP v3 + Neuron AI application demonstrating advanced features for project management and customer relationship management.

## 📸 Screenshots

### Landing Page
![Landing Page](docs/index.png)
*Modern landing page showcasing the SaaS solution with feature highlights and technology stack badges*

### Admin Panel - Client Management
![Admin Panel](docs/admin.png)
*FilamentPHP admin panel with advanced table features, filtering, and bulk actions*

## 🚀 Features

### Core Features
- **Multi-tenancy with Teams**: Full team-based isolation for SaaS architecture
- **CRM System**: Complete customer relationship management
    - Clients with full contact information
    - Contacts management
    - Deal pipeline management
    - Sales tracking
- **Project Management**: Comprehensive project tracking
    - Projects with budgets and progress tracking
    - Task management with subtasks
    - Time tracking and billing
    - Project-client associations
- **Advanced Features**:
    - Comments system (polymorphic for all entities)
    - Role-based permissions within teams
    - Soft deletes on all models
    - Comprehensive relationships

### Technology Stack
- **Backend**: Laravel 12.39.0 with PHP 8.4
- **Admin Panel**: FilamentPHP v3.3.45
- **AI Integration**: Neuron AI v2.8.11
- **Database**: MongoDB 7.0 with Laravel MongoDB driver
- **Frontend**:
  - Inertia.js v2 with Vue.js 3
  - Tailwind CSS v4
  - Vite for asset bundling
- **Testing**: Pest v4 with browser testing support
- **Containerization**: Laravel Sail (Docker)

## 📦 Installation

### Prerequisites
- Docker Desktop installed
- Git

### Quick Start

1. **Clone and Setup**
```bash
cd /mnt/256-m2/projects/filament
vendor/bin/sail up -d
```

2. **Access the Application**
- Application: http://localhost
- Admin Panel: http://localhost/admin
- Admin Credentials:
    - Email: `admin@example.com`
    - Password: `password`

## 📊 Database Schema

### Teams & Users
- `teams`: Team/organization management
- `users`: User accounts with team associations
- `team_user`: Pivot table for team memberships with roles

### CRM Module
- `clients`: Customer/company information
- `contacts`: Individual contacts within clients
- `deals`: Sales pipeline and deal tracking

### Project Management Module
- `projects`: Project information with budgets
- `tasks`: Task management with hierarchical structure
- `time_entries`: Time tracking for billing
- `comments`: Universal commenting system

## 🎯 Key Models & Relationships

### Team Model
- Owns multiple: Clients, Projects, Tasks, Deals, Contacts
- Has many Users through pivot
- Owner relationship to User

### Client Model
- Belongs to Team
- Has many: Contacts, Projects, Deals
- Polymorphic Comments

### Project Model
- Belongs to: Team, Client
- Has many: Tasks, TimeEntries
- Managed by User
- Auto-generates unique project codes

### Task Model
- Belongs to: Team, Project
- Self-referential (parent/subtasks)
- Assigned to User
- Has TimeEntries and Comments

### Deal Model
- Belongs to: Team, Client, Contact
- Tracks sales pipeline stages
- Currency and probability tracking

## 🔧 Filament Resources

All major entities have Filament admin resources:
- ClientResource
- ContactResource
- DealResource
- ProjectResource
- TaskResource
- TimeEntryResource
- TeamResource

## 🤖 Neuron AI Integration

Neuron AI (v2.8.11) is installed and ready for:
- Automated task generation
- Smart scheduling
- Email/Telegram notifications
- Wikipedia research and content generation
- Custom AI workflows

### Example Use Cases
1. Auto-generate project tasks from descriptions
2. Send automated client updates via Telegram
3. Research industry information for client profiles
4. Generate project reports

## 📝 Sample Data

The database is seeded with:
- 1 Admin user + 5 team members
- 1 Team (Acme Corporation)
- 10 Clients with contacts
- 15 Projects
- 75-225 Tasks
- Multiple Deals per client

## 🚀 Development Commands

### Initial Setup (First Time)
```bash
# 1. Start Docker containers
docker-compose up -d

# 2. Install PHP dependencies
docker-compose exec laravel.test composer install

# 3. Copy environment file
docker-compose exec laravel.test cp .env.example .env

# 4. Generate application key
docker-compose exec laravel.test php artisan key:generate

# 5. Run migrations and seed database
docker-compose exec laravel.test php artisan migrate:fresh --seed

# 6. Install and build frontend assets
docker-compose exec laravel.test npm install
docker-compose exec laravel.test npm run build
```

### Using Laravel Sail (Alternative)
```bash
# Complete setup with Sail
vendor/bin/sail up -d
vendor/bin/sail composer install
vendor/bin/sail artisan migrate:fresh --seed
vendor/bin/sail npm install && vendor/bin/sail npm run build
```

### Daily Development
```bash
# Start containers
vendor/bin/sail up -d
# or
docker-compose up -d

# Stop containers
vendor/bin/sail down
# or
docker-compose down

# Watch frontend assets (development)
vendor/bin/sail npm run dev
```

### Database Operations
```bash
# Run migrations
vendor/bin/sail artisan migrate

# Fresh migration with seeding
vendor/bin/sail artisan migrate:fresh --seed

# Seed database only
vendor/bin/sail artisan db:seed

# Reset database
vendor/bin/sail artisan migrate:reset
```

### Code Generation
```bash
# Create Filament resource
vendor/bin/sail artisan make:filament-resource ModelName --generate

# Create model with factory
vendor/bin/sail artisan make:model ModelName --factory

# Create migration
vendor/bin/sail artisan make:migration create_table_name
```

### Testing & Quality
```bash
# Run tests
vendor/bin/sail artisan test

# Run specific test
vendor/bin/sail artisan test --filter TestName

# Format code with Pint
vendor/bin/sail bin pint

# Fix code style
vendor/bin/sail bin pint --repair
```

### Utilities
```bash
# Access Tinker REPL
vendor/bin/sail artisan tinker

# Clear caches
vendor/bin/sail artisan optimize:clear

# View logs
vendor/bin/sail logs

# Access container shell
vendor/bin/sail shell
```

## 🔐 Security Features

- Laravel Fortify for authentication
- Two-factor authentication support
- Password hashing with Bcrypt
- CSRF protection
- Team-based data isolation
- Soft deletes for data recovery

## 📈 Next Steps & Enhancements

### Immediate Enhancements
1. **Custom Filament Pages**: Dashboard with widgets
2. **Advanced Filters**: Complex table filters
3. **Bulk Actions**: Mass operations on records
4. **Export/Import**: Excel/CSV functionality
5. **Advanced Reporting**: Analytics and insights

### Neuron AI Integration
1. **Task Automation**: AI-generated task breakdowns
2. **Smart Notifications**: Intelligent alerting
3. **Research Integration**: Wikipedia API for client research
4. **Communication**: Email/Telegram integration

### Testing
1. Feature tests for all modules
2. Browser tests with Pest v4
3. API endpoint testing

## 📚 File Structure

```
app/
├── Models/                 # Eloquent models
│   ├── Team.php
│   ├── Client.php
│   ├── Contact.php
│   ├── Deal.php
│   ├── Project.php
│   ├── Task.php
│   ├── TimeEntry.php
│   └── Comment.php
├── Filament/
│   └── Resources/         # Filament admin resources
│       ├── ClientResource.php
│       ├── ContactResource.php
│       ├── DealResource.php
│       ├── ProjectResource.php
│       ├── TaskResource.php
│       ├── TimeEntryResource.php
│       └── TeamResource.php
database/
├── migrations/            # Database migrations
├── factories/            # Model factories
└── seeders/              # Database seeders
```

## 🎨 Customization

### Adding a New Module

1. **Create Migration**
```bash
vendor/bin/sail artisan make:migration create_your_table --no-interaction
```

2. **Create Model with Factory**
```bash
vendor/bin/sail artisan make:model YourModel --factory --no-interaction
```

3. **Create Filament Resource**
```bash
vendor/bin/sail artisan make:filament-resource YourModel --generate --no-interaction
```

4. **Add Relationships** to existing models

## 🐛 Troubleshooting

### Common Issues

**Issue**: Cannot access /admin
- **Solution**: Ensure you've run `vendor/bin/sail artisan migrate:fresh --seed`

**Issue**: MongoDB connection refused
- **Solution**: Ensure MongoDB container is running with `vendor/bin/sail up -d`

**Issue**: Tests failing with MongoDB connection errors
- **Solution**: Check that `DB_CONNECTION=mongodb` is set in your `.env` file

**Issue**: Permission denied in Docker
- **Solution**: Run `vendor/bin/sail down` then `vendor/bin/sail up -d`

## 📞 Support & Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [FilamentPHP Documentation](https://filamentphp.com/docs)
- [Laravel MongoDB Documentation](https://github.com/mongodb/laravel-mongodb)
- [MongoDB Documentation](https://www.mongodb.com/docs/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Pest Documentation](https://pestphp.com/docs)
- [Neuron AI Documentation](https://github.com/neuron-core/neuron-ai)
- [Laravel Sail Documentation](https://laravel.com/docs/sail)

## 🏆 Best Practices Implemented

- ✅ Proper use of Eloquent relationships
- ✅ Factory pattern for testing data
- ✅ Repository pattern ready
- ✅ Service layer architecture support
- ✅ SOLID principles
- ✅ PSR-12 coding standards
- ✅ Comprehensive error handling
- ✅ Database transaction support
- ✅ Multi-tenancy architecture
- ✅ Soft deletes for data recovery

## 📄 License

This is a demonstration project. Adapt as needed for your requirements.

---

**Built with Laravel 12 + FilamentPHP v3 + Neuron AI**
