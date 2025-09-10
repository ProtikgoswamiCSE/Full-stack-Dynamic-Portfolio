# Admin Authentication System

This document describes the admin authentication system for the Portfolio application.

## Features

- **Admin Login Page**: Secure login with email and password
- **Admin Registration Page**: Create new admin accounts
- **Password Security**: Strong password requirements with strength indicator
- **Session Management**: Remember me functionality
- **Protected Routes**: All admin routes require authentication
- **Logout Functionality**: Secure logout with session cleanup

## Access URLs

- **Admin Login**: `http://localhost:8000/admin/login`
- **Admin Registration**: `http://localhost:8000/admin/register`
- **Admin Dashboard**: `http://localhost:8000/admin/dashboard` (requires login)
- **Portfolio Home**: `http://localhost:8000/`

## Default Admin Credentials

After running the seeder, you can use these credentials to log in:

- **Email**: `admin@portfolio.com`
- **Password**: `admin123`

## Security Features

1. **Password Hashing**: All passwords are hashed using Laravel's Hash facade
2. **CSRF Protection**: All forms include CSRF tokens
3. **Input Validation**: Comprehensive validation for all inputs
4. **Session Security**: Proper session management and cleanup
5. **Route Protection**: Middleware protection for admin routes

## File Structure

```
app/Http/Controllers/Auth/
├── AdminAuthController.php          # Authentication controller

resources/views/admin/auth/
├── login.blade.php                  # Login page
└── register.blade.php               # Registration page

database/seeders/
├── AdminUserSeeder.php              # Creates default admin user
└── DatabaseSeeder.php               # Updated to include admin seeder

routes/
└── web.php                          # Updated with auth routes
```

## Usage

1. **First Time Setup**:
   ```bash
   php artisan db:seed --class=AdminUserSeeder
   ```

2. **Access Admin Panel**:
   - Navigate to `http://localhost:8000/admin`
   - You'll be redirected to the login page
   - Use the default credentials or register a new account

3. **Create New Admin**:
   - Go to `http://localhost:8000/admin/register`
   - Fill in the registration form
   - You'll be automatically logged in after registration

## Customization

### Styling
The authentication pages use Bootstrap 5 with custom CSS. You can modify the styles in the respective Blade templates.

### Password Requirements
Password requirements can be modified in the `AdminAuthController.php` file:
```php
'password' => ['required', 'confirmed', Password::min(8)]
```

### User Model
The system uses Laravel's default User model. You can extend it to add additional fields or functionality.

## Troubleshooting

1. **Cannot Access Admin Routes**: Make sure you're logged in and the session is active
2. **Registration Not Working**: Check that the database is properly configured and migrations are run
3. **Login Issues**: Verify the user exists in the database and password is correct

## Security Notes

- Change the default admin password after first login
- Consider implementing additional security measures like:
  - Two-factor authentication
  - Account lockout after failed attempts
  - Password reset functionality
  - Admin role management
