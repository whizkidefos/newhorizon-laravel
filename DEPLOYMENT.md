# New Horizon Healthcare - Deployment Guide

This guide provides instructions for deploying the New Horizon Healthcare application to Hostinger, migrating from SQLite to MySQL, and importing users from the WordPress site with Ultimate Member plugin.

## Prerequisites

- A Hostinger account with PHP hosting plan
- MySQL database access
- Access to your WordPress database
- Composer installed on your local machine
- Git installed on your local machine

## Deployment Steps

### 1. Prepare Your Application for Production

1. **Update Dependencies**:
   ```bash
   composer update --no-dev
   npm ci
   npm run build
   ```

2. **Configure Environment Variables**:
   - Copy `.env.mysql` to `.env`
   - Update with your production credentials
   - Generate a new application key if needed:
     ```bash
     php artisan key:generate
     ```

3. **Optimize Laravel**:
   ```bash
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### 2. Database Setup

1. **Create MySQL Database on Hostinger**:
   - Log in to Hostinger control panel
   - Navigate to MySQL Databases
   - Create a new database (e.g., `newhorizon`)
   - Create a database user and assign to the database

2. **Update `.env` File with Database Credentials**:
   ```
   DB_CONNECTION=mysql
   DB_HOST=your_hostinger_mysql_host
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

3. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

### 3. Import WordPress Users

1. **Configure WordPress Database Connection**:
   Add these to your `.env` file:
   ```
   WP_DB_HOST=your_wordpress_db_host
   WP_DB_PORT=3306
   WP_DB_DATABASE=your_wordpress_db_name
   WP_DB_USERNAME=your_wordpress_db_username
   WP_DB_PASSWORD=your_wordpress_db_password
   WP_DB_PREFIX=wp_
   ```

2. **Run the Import Command**:
   ```bash
   php artisan users:import-wordpress
   ```

3. **Send Password Reset Links** (Optional):
   ```bash
   php artisan users:send-reset-links --all
   ```

### 4. Upload to Hostinger

1. **Prepare Files for Upload**:
   - Remove unnecessary files:
     ```bash
     rm -rf node_modules vendor
     ```
   - Create a ZIP archive of your project

2. **Upload via FTP or Hostinger File Manager**:
   - Upload the ZIP file
   - Extract it to your public_html directory or a subdirectory

3. **Install Dependencies on Server**:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

4. **Set Proper Permissions**:
   ```bash
   chmod -R 755 .
   chmod -R 777 storage bootstrap/cache
   ```

5. **Configure Web Server**:
   - Set document root to the `public` folder
   - Ensure `.htaccess` is properly configured

### 5. Final Configuration

1. **Configure Mail Settings**:
   Update your `.env` file with Hostinger SMTP settings:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=your_hostinger_smtp_host
   MAIL_PORT=587
   MAIL_USERNAME=your_email@yourdomain.com
   MAIL_PASSWORD=your_email_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@yourdomain.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

2. **Set Up Scheduled Tasks**:
   Add a cron job to run Laravel's scheduler:
   ```
   * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
   ```

3. **Configure Queue Worker** (if using queues):
   ```
   php artisan queue:work --tries=3
   ```

## Troubleshooting

### Common Issues

1. **Database Connection Issues**:
   - Verify database credentials in `.env`
   - Check if your IP is allowed to connect to the database
   - Ensure MySQL extension is enabled in PHP

2. **Permission Issues**:
   - Make sure storage and bootstrap/cache directories are writable
   - Check file ownership (should be the same as the web server user)

3. **500 Server Errors**:
   - Check PHP error logs
   - Temporarily set `APP_DEBUG=true` in `.env` to see detailed errors
   - Verify PHP version compatibility (Laravel 10 requires PHP 8.1+)

### Getting Help

If you encounter issues during deployment, check:
- Laravel documentation: https://laravel.com/docs
- Hostinger knowledge base: https://support.hostinger.com
- Open an issue in the project repository

## Post-Deployment Tasks

1. **Verify Functionality**:
   - Test user login (both admin and regular users)
   - Test timesheet submission and approval workflow
   - Test complaint submission and resolution process
   - Verify all dashboard statistics are working

2. **Set Up Backups**:
   - Configure database backups
   - Set up file system backups

3. **Security Checks**:
   - Ensure sensitive files are not publicly accessible
   - Verify HTTPS is properly configured
   - Remove any temporary files or debugging tools

## Maintenance

1. **Regular Updates**:
   - Keep Laravel framework updated
   - Update dependencies regularly
   - Apply security patches promptly

2. **Monitoring**:
   - Set up uptime monitoring
   - Configure error tracking
   - Monitor database performance

3. **Scaling**:
   - Consider caching strategies if traffic increases
   - Optimize database queries
   - Implement CDN for static assets
