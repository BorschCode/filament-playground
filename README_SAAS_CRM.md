# SaaS Project Management & CRM System

A comprehensive Laravel 12 + FilamentPHP v3 + Neuron AI application demonstrating advanced features for project management and customer relationship management.

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
- **Backend**: Laravel 12.39.0
- **Admin Panel**: FilamentPHP v3.3.45
- **AI Integration**: Neuron AI v2.8.11
- **Database**: SQLite (easily switchable to MySQL/PostgreSQL)
- **Frontend**: Livewire v3.7.0
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

```bash
# Start the application
vendor/bin/sail up -d

# Run migrations
vendor/bin/sail artisan migrate

# Seed database
vendor/bin/sail artisan db:seed

# Fresh migration with seeding
vendor/bin/sail artisan migrate:fresh --seed

# Create a new Filament resource
vendor/bin/sail artisan make:filament-resource ModelName --generate

# Run tests
vendor/bin/sail artisan test

# Format code with Pint
vendor/bin/sail bin pint

# Access Tinker
vendor/bin/sail artisan tinker

# Stop the application
vendor/bin/sail stop
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
- **Solution**: Ensure you've run `php artisan migrate:fresh --seed`

**Issue**: Database locked error
- **Solution**: SQLite limitation, switch to MySQL in .env

**Issue**: Permission denied in Docker
- **Solution**: Run `vendor/bin/sail down` then `vendor/bin/sail up -d`

## 📞 Support & Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [FilamentPHP Documentation](https://filamentphp.com/docs)
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
