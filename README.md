# Protik Goswami - Full Stack Dynamic Portfolio

A modern, responsive portfolio website built with Laravel 12, featuring dark mode toggle, smooth animations, and a professional design.

## Features

- 🎨 **Modern Design**: Clean and professional portfolio layout
- 🌙 **Dark Mode**: Toggle between light and dark themes
- 📱 **Responsive**: Works perfectly on all devices
- ⚡ **Fast Loading**: Optimized assets and efficient code
- 🎯 **Sections**: Home, About, Skills, Achievements, Academic, Work, Images, Contact
- 🔗 **Social Links**: Integrated social media profiles
- 📍 **Interactive Map**: Google Maps integration for location

## Technologies Used

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: HTML5, CSS3, JavaScript
- **Styling**: Custom CSS with responsive design
- **Icons**: Font Awesome 6.4.0
- **Maps**: Google Maps Embed API

## Prerequisites

- PHP 8.2 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Full-stack-Dynamic-Portfolio
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database** (Optional - for future features)
   ```bash
   # Edit .env file with your database credentials
   php artisan migrate
   ```

5. **Start the development server**
   ```bash
   php artisan serve
   ```

6. **Access the application**
   Open your browser and navigate to `http://localhost:8000`

## Project Structure

```
├── app/                    # Laravel application logic
├── config/                 # Configuration files
├── database/              # Database migrations and seeders
├── public/                # Public assets and entry point
│   ├── assets/           # CSS, JS, and images
│   └── index.php         # Application entry point
├── resources/             # Views and frontend assets
│   ├── views/            # Blade templates
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript files
├── routes/                # Application routes
└── storage/               # Application storage
```

## Pages/Sections

- **Home**: Introduction and hero section
- **About**: Personal information and expertise areas
- **Skills**: Technical skills with progress bars
- **Achievements**: Certificates and accomplishments
- **Academic**: Educational background
- **Work**: Project showcase
- **Images**: Photo gallery
- **Contact**: Contact form and location map

## Customization

### Adding New Sections
1. Create a new Blade view in `resources/views/`
2. Add a route in `routes/web.php`
3. Update the navigation in `resources/views/index.blade.php`

### Modifying Styles
- Main styles: `public/assets/css/style.css`
- Additional styles: `resources/css/app.css`

### Theme Customization
- Dark mode styles are in `public/assets/css/style.css`
- Theme toggle logic: `public/assets/js/theme-toggle.js`

## Deployment

### For Production
1. Set `APP_ENV=production` in `.env`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Ensure proper file permissions
5. Configure your web server

### Recommended Hosting
- Shared hosting with PHP 8.2+ support
- VPS with LAMP/LEMP stack
- Cloud platforms (AWS, DigitalOcean, etc.)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact

- **Name**: Protik Goswami
- **Email**: goswami15-5841@diu.edu.bd
- **Phone**: 01736744140
- **LinkedIn**: [Protik Goswami](https://linkedin.com/in/protikgoswami)
- **GitHub**: [ProtikgoswamiCSE](https://github.com/ProtikgoswamiCSE)

## Acknowledgments

- Laravel Framework
- Font Awesome for icons
- Google Maps for location embedding
- All contributors and supporters

---

**Note**: This portfolio is actively maintained and updated. For the latest version, please check the repository.
