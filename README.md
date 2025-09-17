# CMS Project - Laravel Application

A comprehensive Content Management System built with Laravel 12, Vue 3, and Inertia.js that allows clients to customize their web pages and view analytics through a dashboard interface.

## Features

### Core Features
- **Client Authentication & Management**: Complete client registration and login system
- **Page Customization**: Real-time page editing with predefined themes
- **Analytics Dashboard**: Track page views, unique visitors, and performance metrics
- **Public Page Display**: SEO-friendly URLs for client pages
- **Theme System**: 6 predefined color themes with easy customization

### Technical Features
- **Multi-guard Authentication**: Separate authentication for clients and admins
- **Real-time Preview**: Live preview of page changes
- **CSV Export**: Export analytics data for external analysis
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **SEO Optimization**: Meta tags and clean URLs

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL/PostgreSQL/SQLite

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd cms-project1
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database configuration**
   - Update your `.env` file with database credentials
   - Create the database

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Usage

### Client Access
- **Registration**: Visit `/client/register` to create a new client account
- **Login**: Visit `/client/login` to access the client dashboard
- **Dashboard**: Manage pages, view analytics, and customize themes

### Admin Access
- **Admin Panel**: Visit `/admin` to access the admin dashboard
- **Client Management**: Create, edit, and manage client accounts

### Public Pages
- **View Pages**: Visit `/page/{client-slug}/{page-slug}` to view public pages
- **Example**: `/page/john-doe/welcome`

## Theme System

The application includes 6 predefined themes:

1. **Classic**: Black, brown, and white color scheme
2. **Ocean**: Blue and white ocean-inspired theme
3. **Forest**: Green natural theme
4. **Sunset**: Orange and red warm theme
5. **Purple**: Modern purple and violet theme
6. **Dark**: Sleek dark theme with white accents

## Page Editor

The page editor supports:
- **Hero Sections**: Headlines, subheadlines, and call-to-action buttons
- **Text Sections**: Rich text content areas
- **Feature Sections**: Multiple feature cards with titles and descriptions
- **Custom Sections**: Extensible section system for future content types

## Analytics

The analytics system tracks:
- **Page Views**: Total views per page
- **Unique Visitors**: Distinct visitor count
- **Time-based Data**: Daily, weekly, and monthly statistics
- **Top Pages**: Most viewed pages
- **Export Functionality**: CSV export for external analysis

## API Endpoints

### Client Authentication
- `POST /client/login` - Client login
- `POST /client/register` - Client registration
- `POST /client/logout` - Client logout

### Page Management
- `GET /client/pages` - List client pages
- `POST /client/pages` - Create new page
- `PUT /client/pages/{id}` - Update page
- `DELETE /client/pages/{id}` - Delete page
- `PATCH /client/pages/{id}/toggle-publish` - Toggle publish status

### Analytics
- `GET /client/analytics` - View analytics dashboard
- `GET /client/analytics/export` - Export analytics as CSV

### Public Pages
- `GET /page/{client}/{page}` - View public page

## Database Schema

### Tables
- `clients` - Client accounts and information
- `themes` - Available color themes
- `pages` - Client pages with content and settings
- `page_analytics` - Page view tracking data

### Relationships
- Client has many Pages
- Page belongs to Client and Theme
- Page has many PageAnalytics
- Theme has many Pages

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Frontend Development
```bash
npm run dev
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue in the repository.
