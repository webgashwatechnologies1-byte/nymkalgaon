# Backend File Structure & CSS Paths

## ✅ Correct CSS Link Paths

All admin pages should link to the CSS file correctly based on their location:

### Dashboard (root level)
- **File:** `backend/dashboard/dashboard.php`
- **CSS:** Uses inline `<style>` tag (self-contained)
- **Alternative:** Could use `assets/admin.css`

### News Pages (one level deep)
- **Files:** 
  - `backend/dashboard/news/index.php`
  - `backend/dashboard/news/add.php`
  - `backend/dashboard/news/edit.php`
  - `backend/dashboard/news/delete.php`
- **CSS Path:** `../assets/admin.css` ✅

### Featured Pages (one level deep)
- **File:** `backend/dashboard/featured/edit.php`
- **CSS Path:** `../assets/admin.css` ✅

### User Pages (one level deep)
- **File:** `backend/dashboard/users/register.php`
- **CSS Path:** `../assets/admin.css` ✅

## 📁 Directory Structure

```
backend/
├── dashboard/
│   ├── assets/
│   │   └── admin.css          ← Main CSS file
│   ├── news/
│   │   ├── index.php          (uses ../assets/admin.css)
│   │   ├── add.php            (uses ../assets/admin.css)
│   │   ├── edit.php           (uses ../assets/admin.css)
│   │   └── delete.php
│   ├── featured/
│   │   └── edit.php           (uses ../assets/admin.css)
│   ├── users/
│   │   └── register.php       (uses ../assets/admin.css)
│   ├── dashboard.php          (inline CSS)
│   ├── login.php              (inline CSS)
│   ├── logout.php
│   └── layout.php
├── images/
│   ├── news/
│   └── featured/
├── config.php
├── helpers.php
└── schema.sql
```

## 🎨 CSS Path Rules

- From `dashboard/` → use `assets/admin.css`
- From `dashboard/news/` → use `../assets/admin.css`
- From `dashboard/featured/` → use `../assets/admin.css`
- From `dashboard/users/` → use `../assets/admin.css`

## ✅ All Fixed!

All CSS paths are now correctly configured. Every page will load the premium design! 🚀
