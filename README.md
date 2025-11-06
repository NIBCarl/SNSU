# SNSU Student Management System

A comprehensive web-based student information management system built for Surigao del Norte State University (SNSU) Student Affairs Office.

![SNSU Logo](public/assets/logo.png)

## 🎓 About

The SNSU Student Management System is designed to streamline student data collection, management, and analysis for the Student Affairs Office. The system provides a public-facing student submission form and a secure administrative dashboard for managing student records.

## ✨ Features

### Public Features
- **Student Registration Form**: Public form for students to submit their information
- **Thank You Page**: Confirmation page after successful submission

### Administrative Features
- **Dashboard**: Real-time statistics and insights
  - Total students count
  - Indigenous students tracking
  - PWD (Persons with Disability) monitoring
  - Housing status analytics
  - Location-based statistics

- **Student Management**
  - View all students with pagination
  - Add new student records
  - Edit existing student information
  - Delete student records (soft delete with recovery option)
  
- **Advanced Filtering**
  - Filter by Course
  - Filter by Year Level (1st Year, 2nd Year, 3rd Year, 4th Year, Others)
  - Filter by Gender
  - Filter by City
  - Filter by Ethnicity
  - Filter by Housing Status
  - PWD-only filter
  - Global search across multiple fields

- **Export Capabilities**
  - Export to CSV
  - Export to Excel (.xls)
  - Export to PDF (print-friendly)
  - Exports respect current filters and page

- **Student Analytics**
  - Gender distribution charts
  - Transportation mode statistics
  - Family income analysis
  - Location-based demographics
  - Travel time averages

- **Authentication & Security**
  - Secure login system
  - Password reset functionality
  - Email verification
  - Profile management
  - CSRF protection

## 🛠️ Technology Stack

### Backend
- **Framework**: Laravel 11.9
- **Language**: PHP 8.2+
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Breeze with Sanctum

### Frontend
- **Framework**: Vue.js 3.4
- **SPA Library**: Inertia.js 1.0
- **Build Tool**: Vite 5.0
- **Styling**: Tailwind CSS 3.2
- **Icons**: Font Awesome 6.7
- **Charts**: Chart.js 4.4

### Additional Libraries
- **PhpSpreadsheet**: Excel export functionality
- **Ziggy**: Laravel route helper for JavaScript

## 📋 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM or Yarn
- MySQL >= 5.7 or MariaDB >= 10.3
- Web server (Apache/Nginx)

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd SNSU
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install JavaScript Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
# Copy the environment file
cp env.txt .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database
Edit the `.env` file and update database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=snsu_student_affairs
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Seed Admin User
```bash
php artisan db:seed --class=AdminSeeder
```

**Default Admin Credentials:**
- Email: `studentaffairs@snsu.edu.ph`
- Password: `SNSU2024@SecurePass`

⚠️ **IMPORTANT**: Change these credentials immediately after first login!

### 8. Build Frontend Assets
```bash
# For development
npm run dev

# For production
npm run build
```

### 9. Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🌐 Production Deployment

### Pre-Deployment Checklist

1. **Update Environment Variables**
   - Set `APP_ENV=production`
   - Set `APP_DEBUG=false`
   - Update `APP_URL` to your production domain
   - Configure mail server settings
   - Set strong database credentials

2. **Install Production Dependencies**
```bash
composer install --optimize-autoloader --no-dev
npm ci
```

3. **Build Assets**
```bash
npm run build
```

4. **Run Migrations**
```bash
php artisan migrate --force
```

5. **Seed Database**
```bash
php artisan db:seed --class=AdminSeeder
```

6. **Optimize Application**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

7. **Set Permissions**
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

8. **Configure Web Server**
   - Point document root to `/public`
   - Enable URL rewriting
   - Configure HTTPS/SSL

### Security Recommendations

- Enable HTTPS
- Set `SESSION_SECURE_COOKIE=true` in `.env` for HTTPS
- Change default admin credentials immediately
- Configure firewall rules
- Regular backups of database
- Keep dependencies updated
- Enable rate limiting on login routes
- Use strong database passwords
- Consider implementing 2FA for admin accounts

## 📁 Project Structure

```
SNSU/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   └── Middleware/       # Custom middleware
│   └── Models/               # Eloquent models
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── assets/              # Images and static assets
│   └── build/               # Compiled frontend assets
├── resources/
│   ├── js/
│   │   ├── Components/      # Vue components
│   │   ├── Layouts/         # Layout components
│   │   └── Pages/           # Page components
│   ├── css/                 # Stylesheets
│   └── views/               # Blade templates
├── routes/
│   ├── web.php             # Web routes
│   └── auth.php            # Authentication routes
└── storage/                 # Application storage
```

## 🔧 Configuration

### Student Year Levels
The system uses predefined year levels:
- 1st Year
- 2nd Year
- 3rd Year
- 4th Year
- Others

### Filter Options
Pre-configured filter options:
- **Gender**: Male, Female, Other
- **Ethnicity**: Indigenous, Non-Indigenous
- **Housing Status**: Owned, Renting, Living with Relatives, Other
- **Study Devices**: Laptop, Tablet, Desktop, Mobile Phone

### Export Formats
- **CSV**: Compatible with Excel and spreadsheet applications
- **Excel**: Direct .xls format export
- **PDF**: Print-friendly HTML format for saving as PDF

## 👥 User Roles

### Admin Users
- Full access to dashboard
- Manage student records
- View analytics
- Export data
- Manage user profile

### Public Users
- Submit student information via public form
- No login required for student submission

## 🐛 Troubleshooting

### Assets Not Loading
```bash
npm run build
php artisan view:clear
```

### Database Connection Error
- Verify database credentials in `.env`
- Ensure MySQL service is running
- Check database exists: `CREATE DATABASE snsu_student_affairs;`

### Permission Errors
```bash
chmod -R 755 storage bootstrap/cache
```

### Session/Cache Issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📊 Database Schema

### Students Table (45 fields)
- Basic Information: name, student ID, course, year level
- Personal Details: gender, birth date, marital status, religion
- Contact: cellphone number
- Address: complete address with barangay, city, province
- Academic: study device preference
- Family: solo parent status, household size, parents' education
- Financial: family income bracket, monthly rental, daily fare
- Transportation: mode, travel time
- Demographics: ethnicity, PWD status, housing status

### Users Table
- Admin user accounts
- Email verification
- Password reset tokens

## 🔄 Updates & Maintenance

### Update Dependencies
```bash
composer update
npm update
```

### Database Backup
```bash
mysqldump -u username -p snsu_student_affairs > backup.sql
```

### Clear All Caches
```bash
php artisan optimize:clear
```

## 📝 License

This project is proprietary software developed for Surigao del Norte State University.

## 👨‍💻 Development Team

Developed for SNSU Student Affairs Office

## 🆘 Support

For technical support and inquiries:
- Email: studentaffairs@snsu.edu.ph
- Office: SNSU Student Affairs Office

## 📌 Version

**Current Version**: 1.0.0

**Last Updated**: January 2025

---

**Surigao del Norte State University**  
*Integrity • Competence • Respect*
