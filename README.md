# LPM RESONAN NEWS PORTAL

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)

## About

**LPM RESONAN NEWS PORTAL** is the official news portal of the **Student Press Organization (LPM) Resonan at Singaperbangsa Karawang University**. This portal is designed to serve as a platform for up-to-date and factual information on various topics both on and off campus.

## Feature

### Content Management

- **Articles**: An article/content publishing system with comprehensive relational data
- **Categories**: Content organization by topic
- **Tags**: Grouping articles by tags for more structured categorization
- **Comments**: A comment system to encourage reader engagement

### RBAC Management

- **Users**: User management with assigned roles
- **Permissions**: Role-based access control using Laratrust

### Widget Management

- **Platforms**: Displays platform information for direct links
- **Embeds**: Displays social media content (Spotify, YouTube) directly in the public page sidebar
- **Sliders**: Displays banners in a slider format at the top of the public page for promotional purposes or to highlight content
- **Footers**: Displays contact information, important links, and social media in the footer

### Additional

- **Search Engine Friendly**: SEO-optimized for better visibility
- **Responsive Design**: A clean, optimized layout across all devices using Metronic 9 and TailwindCSS
- **Structured File Organization**: A clean, easy-to-understand file structure to facilitate development and maintenance

## Technology Stack

### Backend

- **Laravel 12.x** - PHP Framework
- **MySQL** - Database
- **Laratrust** - RBAC

### Frontend

- **Tailwind CSS** - CSS Framework
- **Vite** - Build Tool & Asset Bundling
- **Blade Templates** - Laravel Templating Engine
- **KTUI** - UI Component Library

### Development Tools

- **Composer** - PHP Dependency Manager
- **NPM** - JavaScript Package Manager

## System Requirements

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL
- Web Server (Apache/Nginx/PHP Built-in)

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/feryanuar24/lpmunsika-2.git
cd lpmunsika
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

#### Configure the database connection in `.env`:

```bash
# Run migrations
php artisan migrate

# (Optional) Run seeders
php artisan db:seed
```

### 5. Build Assets

```bash
# Development Hot Reload
npm run dev

# Production
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

The app is running on `http://localhost:8000`

## Contribution

Contributions are welcome for all members of LPM RESONAN UNSIKA!

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

### Guidelines for Contributions

- Use descriptive commit messages
- Use the existing code style and conventions

## License

This project is licensed under [MIT License](LICENSE).

## Acknowledgments

**LPM RESONAN UNSIKA Development Team**

## Contact & Support

- **Website**: [LPM RESONAN UNSIKA Official](https://resonan.lpmunsika.com)
- **Email**: lpmunsika@gmail.com
- **Instagram**: [@lpmresonan](https://instagram.com/@lpmresonan)
- **Issues**: [GitHub Issues](https://github.com/feryanuar24/lpmresonan/issues)
