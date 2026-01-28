# NYM Kalgaon - Routing System

## Overview
This project now uses a clean URL routing system. All requests are routed through `index.php` which handles the routing logic.

## How It Works

### 1. **index.php (Router)**
- Acts as the front controller for all requests
- Maps clean URLs to their corresponding PHP files
- Handles 404 errors for non-existent routes

### 2. **.htaccess (URL Rewriting)**
- Enables clean URLs by removing `.php` extensions
- Routes all requests to `index.php`
- Prevents direct access to the `backend` folder
- Redirects old `.php` URLs to clean URLs (301 redirect)

## Available Routes

| Clean URL | Maps to File |
|-----------|-------------|
| `/` or `/home` | `home.php` |
| `/about` | `about.php` |
| `/contact` | `contact.php` |
| `/officials` | `official.php` |
| `/news-letter` | `news-&-letter.php` |
| `/privacy-policy` | `privacy-policy.php` |
| `/terms-condition` | `terms-&-consition.php` |
| `/thanks` | `thanks.php` |

## Usage

### Accessing Pages
- **Old way:** `http://localhost/nymkalgaon/about.php`
- **New way:** `http://localhost/nymkalgaon/about`

### Creating Links
Always use clean URLs in your href attributes:
```html
<!-- ✅ Correct -->
<a href="/">Home</a>
<a href="/about">About Us</a>
<a href="/contact">Contact</a>

<!-- ❌ Incorrect (old way) -->
<a href="index.php">Home</a>
<a href="about.php">About Us</a>
```

## Adding New Routes

To add a new route, edit `index.php` and add to the `$routes` array:

```php
$routes = [
    // ... existing routes
    'new-page' => 'new-page.php',
];
```

Then create the corresponding PHP file (`new-page.php`) in the root directory.

## Requirements

- Apache web server with `mod_rewrite` enabled
- WAMP/XAMPP/LAMP stack
- `.htaccess` file support enabled in Apache configuration

## Notes

- The `backend` folder is protected and cannot be accessed directly via URL
- All old `.php` URLs will automatically redirect to clean URLs (301 permanent redirect)
- The routing system maintains backward compatibility while enforcing clean URLs
