# NYM Kalgaon - Backend Dashboard System

## 📋 Overview

Complete admin dashboard for managing NYM Kalgaon website content including news articles and featured content.

## 🚀 Features

- **Authentication System** - Secure login/logout with session management
- **News Management** - Full CRUD operations (Create, Read, Update, Delete)
- **Featured Content** - Single record management for homepage featured section
- **User Management** - Register new admin users
- **Image Upload** - Secure image handling with validation
- **Responsive Design** - Works on desktop, tablet, and mobile devices

## 📁 File Structure

```
backend/
│
├── config.php              # Database connection & configuration
├── helpers.php             # Utility functions (auth, upload, etc.)
├── schema.sql              # Database schema (run this first!)
│
├── dashboard/
│   ├── login.php           # Login page
│   ├── logout.php          # Logout handler
│   ├── dashboard.php       # Main dashboard
│   │
│   ├── assets/
│   │   └── admin.css       # Admin dashboard styles
│   │
│   ├── users/
│   │   └── register.php    # Register new users
│   │
│   ├── news/
│   │   ├── index.php       # List all news
│   │   ├── add.php         # Add new news
│   │   ├── edit.php        # Edit news
│   │   └── delete.php      # Delete news
│   │
│   └── featured/
│       └── edit.php        # Edit featured content (single record)
│
└── images/
    ├── news/               # News images storage
    └── featured/           # Featured image storage
```

## 🔧 Installation & Setup

### Step 1: Import Database Schema

1. Open **phpMyAdmin** in your browser (usually `http://localhost/phpmyadmin`)
2. Click on **SQL** tab
3. Copy the contents of `backend/schema.sql`
4. Paste and click **Go** to execute
5. Verify that `users`, `news`, and `featured` tables are created

### Step 2: Verify Configuration

The `backend/config.php` file is already configured for WAMP:
- **Host:** localhost
- **Username:** root
- **Password:** (empty)
- **Database:** nymkalgaon

If your setup is different, update the connection details in `config.php`.

### Step 3: Set Permissions

Ensure the following directories are writable:
```
backend/images/news/
backend/images/featured/
```

On Windows (WAMP), this should work by default.

## 🔐 Default Login Credentials

After importing the database schema, use these credentials to login:

- **URL:** `http://localhost/nymkalgaon/backend/dashboard/login.php`
- **Email:** `admin@nymkalgaon.com`
- **Password:** `admin123`

> ⚠️ **Important:** Change the default password after first login!

## 📖 Usage Guide

### Accessing the Dashboard

1. Navigate to: `http://localhost/nymkalgaon/backend/dashboard/login.php`
2. Login with admin credentials
3. You'll be redirected to the main dashboard

### Managing News

**Add News:**
1. Click "Manage News" in sidebar
2. Click "Add New News" button
3. Fill in the form:
   - News Date (when the news occurred)
   - Image (JPG, PNG, GIF - max 5MB)
   - Heading (main title)
   - Subheading (subtitle)
   - Details (full content)
4. Click "Add News"

**Edit News:**
1. Go to "Manage News"
2. Click edit icon (pencil) on any news item
3. Update the fields
4. Optionally upload a new image (old one will be replaced)
5. Click "Update News"

**Delete News:**
1. Go to "Manage News"
2. Click delete icon (trash) on any news item
3. Confirm deletion
4. News and its image will be permanently deleted

### Managing Featured Content

Featured content is a **single record** that appears on the homepage.

1. Click "Featured Content" in sidebar
2. Fill in or update:
   - Dotext (short label/tag)
   - Heading (main title)
   - Subheading (subtitle)
   - Details (full description)
   - Image (featured image)
3. Click "Update Featured Content"

### Adding New Users

1. Click "Add User" in sidebar
2. Enter:
   - Full Name
   - Email Address
   - Password (min 6 characters)
   - Confirm Password
3. Click "Register User"

## 🛡️ Security Features

- **Password Hashing** - Uses PHP `password_hash()` with bcrypt
- **Session Management** - Secure session-based authentication
- **Input Sanitization** - All inputs are sanitized to prevent XSS
- **SQL Injection Protection** - Prepared statements used throughout
- **File Upload Validation** - Type, size, and MIME type checking
- **Backend Protection** - `.htaccess` prevents direct folder access

## 📱 Responsive Design

The dashboard is fully responsive and works on:
- ✅ Desktop (1920px+)
- ✅ Laptop (1024px - 1920px)
- ✅ Tablet (768px - 1024px)
- ✅ Mobile (320px - 768px)

Mobile features:
- Collapsible sidebar (hamburger menu)
- Touch-friendly buttons
- Optimized table views

## 🎨 Customization

### Changing Colors

Edit `backend/dashboard/assets/admin.css` and modify CSS variables:

```css
:root {
    --primary-color: #2563eb;      /* Main blue color */
    --success-color: #10b981;      /* Green for success */
    --danger-color: #ef4444;       /* Red for delete/errors */
    --dark-bg: #1f2937;            /* Sidebar background */
}
```

### Adding New Admin Pages

1. Create new PHP file in appropriate folder
2. Include `config.php` and `helpers.php`
3. Call `requireLogin()` to protect the page
4. Use the sidebar template from existing pages
5. Add navigation link in sidebar

## 🐛 Troubleshooting

### Cannot Login

- Verify database connection in `config.php`
- Check if `users` table exists in database
- Ensure session is started (check `config.php`)

### Images Not Uploading

- Check folder permissions for `backend/images/news/` and `backend/images/featured/`
- Verify `upload_max_filesize` in `php.ini` (should be at least 5MB)
- Check `post_max_size` in `php.ini`

### Page Not Found (404)

- Ensure you're accessing via: `http://localhost/nymkalgaon/backend/dashboard/...`
- Check that all files are in correct directories
- Verify `.htaccess` is working (mod_rewrite enabled)

### Database Connection Failed

- Verify MySQL is running in WAMP
- Check database name is `nymkalgaon`
- Ensure username is `root` with no password
- Import `schema.sql` if tables don't exist

## 📊 Database Schema

### users Table
- `id` - Primary key
- `name` - User's full name
- `email` - Unique email (used for login)
- `password` - Hashed password
- `created_at`, `updated_at` - Timestamps

### news Table
- `id` - Primary key
- `news_date` - Date of the news
- `image` - Filename of uploaded image
- `heading` - Main title
- `subheading` - Subtitle
- `details` - Full content
- `created_at`, `updated_at` - Timestamps

### featured Table
- `id` - Always 1 (single record)
- `dotext` - Short label/tag
- `heading` - Main title
- `subheading` - Subtitle
- `details` - Full description
- `image` - Filename of featured image
- `updated_at` - Timestamp

## 🔄 Updating the System

To add new features:

1. **New Database Fields:**
   - Add columns via phpMyAdmin
   - Update forms to include new fields
   - Update INSERT/UPDATE queries

2. **New Modules:**
   - Create new folder in `backend/dashboard/`
   - Add CRUD pages following existing patterns
   - Add sidebar navigation link

## 📞 Support

For issues or questions:
- Check this README first
- Review error messages in browser console
- Check PHP error logs in WAMP

## 🎯 Next Steps

After setup:

1. ✅ Login with default credentials
2. ✅ Change admin password
3. ✅ Add your first news article
4. ✅ Update featured content
5. ✅ Test all CRUD operations
6. ✅ Create additional admin users if needed

---

**Built for NYM Kalgaon** | Responsive Admin Dashboard System
