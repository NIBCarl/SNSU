#!/bin/bash

# SNSU Student Management System - Production Deployment Script
# This script automates the deployment process

set -e  # Exit on error

echo "🚀 Starting SNSU Student Management System Deployment..."
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Check if .env exists
if [ ! -f .env ]; then
    print_error ".env file not found!"
    print_info "Creating .env from env.txt..."
    cp env.txt .env
    print_warning "Please update .env with your production settings before continuing!"
    exit 1
fi

# Verify production environment
if ! grep -q "APP_ENV=production" .env; then
    print_warning "APP_ENV is not set to 'production' in .env"
    read -p "Continue anyway? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Step 1: Install Composer Dependencies
echo "📦 Step 1: Installing Composer dependencies..."
if composer install --optimize-autoloader --no-dev; then
    print_success "Composer dependencies installed"
else
    print_error "Failed to install Composer dependencies"
    exit 1
fi

# Step 2: Install NPM Dependencies
echo ""
echo "📦 Step 2: Installing NPM dependencies..."
if npm ci; then
    print_success "NPM dependencies installed"
else
    print_error "Failed to install NPM dependencies"
    exit 1
fi

# Step 3: Build Frontend Assets
echo ""
echo "🔨 Step 3: Building frontend assets..."
if npm run build; then
    print_success "Frontend assets built successfully"
else
    print_error "Failed to build frontend assets"
    exit 1
fi

# Step 4: Generate Application Key (if not set)
echo ""
echo "🔑 Step 4: Checking application key..."
if grep -q "APP_KEY=$" .env; then
    print_info "Generating application key..."
    php artisan key:generate --force
    print_success "Application key generated"
else
    print_success "Application key already set"
fi

# Step 5: Run Migrations
echo ""
echo "🗄️ Step 5: Running database migrations..."
read -p "Run migrations? This will modify the database. (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if php artisan migrate --force; then
        print_success "Migrations completed successfully"
    else
        print_error "Migration failed"
        exit 1
    fi
else
    print_warning "Skipped migrations"
fi

# Step 6: Seed Admin User
echo ""
echo "👤 Step 6: Seeding admin user..."
read -p "Seed admin user? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    if php artisan db:seed --class=AdminSeeder --force; then
        print_success "Admin user seeded"
        print_info "Email: studentaffairs@snsu.edu.ph"
        print_info "Password: SNSU2024@SecurePass"
        print_warning "⚠️  IMPORTANT: Change this password immediately after first login!"
    else
        print_error "Seeding failed"
    fi
else
    print_warning "Skipped admin seeding"
fi

# Step 7: Set Permissions
echo ""
echo "🔒 Step 7: Setting permissions..."
chmod -R 755 storage bootstrap/cache
print_success "Permissions set"

# Step 8: Optimize Application
echo ""
echo "⚡ Step 8: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
print_success "Application optimized"

# Final Summary
echo ""
echo "================================================"
echo "✅ Deployment completed successfully!"
echo "================================================"
echo ""
print_info "Next Steps:"
echo "  1. Update web server configuration (Nginx/Apache)"
echo "  2. Enable HTTPS/SSL"
echo "  3. Login and change admin password"
echo "  4. Test all functionality"
echo "  5. Set up database backups"
echo ""
print_warning "Important Files to Secure:"
echo "  - .env (contains sensitive credentials)"
echo "  - storage/ (contains logs and uploaded files)"
echo ""
print_info "Admin Login:"
echo "  URL: https://your-domain.com/login"
echo "  Email: studentaffairs@snsu.edu.ph"
echo "  Password: SNSU2024@SecurePass"
echo ""
print_warning "⚠️  Remember to change the admin password immediately!"
echo ""
print_success "Deployment script completed. Good luck! 🎉"

