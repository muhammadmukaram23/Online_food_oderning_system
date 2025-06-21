# KFC Restaurant Management System - Setup Guide

This is a complete KFC restaurant management system built with Laravel frontend and FastAPI backend.

## Features

### Admin Panel
- **Dashboard**: Overview with statistics and quick actions
- **Location Management**: CRUD operations for restaurant locations
- **Category Management**: CRUD operations for menu categories
- **Menu Item Management**: CRUD operations with image upload functionality
- **Order Management**: View and manage customer orders

### Public Website
- **Homepage**: Featured items, categories, and locations
- **Menu**: Browse menu items with category filtering and cart functionality
- **Locations**: Find restaurant locations
- **Authentication**: Login and registration for admin access

## Prerequisites

- PHP 8.1+
- Composer
- Laravel 11
- FastAPI backend (Python)
- Web server (Apache/Nginx)

## Installation Steps

### 1. Clone and Setup Laravel Project

```bash
# Navigate to the kfc directory
cd kfc

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Configure Environment

Edit `.env` file and add:

```env
APP_NAME="KFC Restaurant Management"
APP_URL=http://localhost:8000

# API Configuration
API_BASE_URL=http://localhost:8000

# Database (if needed for Laravel sessions/cache)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Session Configuration
SESSION_DRIVER=file
```

### 3. Setup Storage

```bash
# Create storage link for image uploads
php artisan storage:link

# Create menu-items directory
mkdir -p storage/app/public/menu-items
```

### 4. Start FastAPI Backend

Make sure your FastAPI backend is running on `http://localhost:8000`. The Laravel frontend will connect to these endpoints:

- `/auth/register` - User registration
- `/auth/login` - User login
- `/auth/me` - Get current user
- `/locations` - Location management
- `/menu/categories` - Category management
- `/menu/items` - Menu item management
- `/orders` - Order management
- `/stats` - Statistics
- `/health` - Health check

### 5. Start Laravel Development Server

```bash
php artisan serve --port=8080
```

The website will be available at `http://localhost:8080`

## Usage

### Admin Access

1. Go to `http://localhost:8080/register` to create an admin account
2. Login at `http://localhost:8080/login`
3. Access admin dashboard at `http://localhost:8080/admin/dashboard`

### Admin Features

#### Dashboard
- View system statistics
- Quick action buttons
- System status monitoring

#### Location Management
- Add new restaurant locations
- Edit existing locations
- Delete locations
- View all locations with details

#### Category Management
- Create menu categories
- Edit category details
- Delete categories
- Organize menu items

#### Menu Item Management
- Add new menu items with images
- Set prices and descriptions
- Mark items as featured or available
- Assign items to categories
- Upload and manage item images

#### Order Management
- View all customer orders
- Update order status
- View order details and items

### Public Website Features

#### Homepage
- Featured menu items
- Category showcase
- Location highlights
- Call-to-action sections

#### Menu Page
- Browse all menu items
- Filter by category
- Add items to cart
- View item details and prices

#### Cart Functionality
- Add/remove items
- Update quantities
- View total price
- Toast notifications

## File Structure

```
kfc/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php      # Admin panel controller
│   │   ├── AuthController.php       # Authentication controller
│   │   └── HomeController.php       # Public pages controller
│   └── Services/
│       └── ApiService.php           # FastAPI integration service
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php           # Main layout with KFC styling
│   ├── auth/
│   │   ├── login.blade.php         # Login form
│   │   └── register.blade.php      # Registration form
│   ├── admin/
│   │   ├── dashboard.blade.php     # Admin dashboard
│   │   └── menu-items/
│   │       ├── index.blade.php     # Menu items list
│   │       └── create.blade.php    # Add menu item form
│   ├── home.blade.php              # Homepage
│   └── menu.blade.php              # Menu page
├── routes/
│   └── web.php                     # All routes definition
└── config/
    └── app.php                     # App configuration with API URL
```

## API Integration

The Laravel frontend communicates with the FastAPI backend through the `ApiService` class which handles:

- HTTP requests with proper headers
- JWT token management
- Error handling and fallbacks
- Session-based authentication storage

## Styling and UI

- **Framework**: Bootstrap 5
- **Icons**: Font Awesome 6
- **Color Scheme**: KFC red (#E4002B) and gold (#FFD700)
- **Responsive Design**: Mobile-first approach
- **Components**: Cards, modals, forms, navigation

## Image Upload

Menu item images are stored in `storage/app/public/menu-items/` and served through Laravel's storage link system.

## Error Handling

The system includes comprehensive error handling:
- API connection failures
- Invalid responses
- Form validation errors
- Authentication errors
- Graceful degradation when backend is unavailable

## Development Notes

- All API calls include timeout handling
- Mock responses are provided when API is unavailable
- Session-based authentication for admin panel
- CSRF protection on all forms
- Input validation on both client and server side

## Troubleshooting

### Common Issues

1. **API Connection Failed**
   - Ensure FastAPI backend is running on correct port
   - Check `API_BASE_URL` in `.env` file
   - Verify CORS settings on FastAPI backend

2. **Images Not Displaying**
   - Run `php artisan storage:link`
   - Check file permissions on storage directory

3. **Login Issues**
   - Verify FastAPI authentication endpoints
   - Check session configuration
   - Clear browser cache and cookies

4. **Style Issues**
   - Ensure Bootstrap and Font Awesome CDN links are accessible
   - Check for CSS conflicts

## Production Deployment

For production deployment:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database
4. Set up SSL certificates
5. Configure web server (Apache/Nginx)
6. Set proper file permissions
7. Configure caching and optimization

## Support

For issues and support, check:
- Laravel documentation
- FastAPI backend logs
- Browser developer console
- Laravel logs in `storage/logs/` 