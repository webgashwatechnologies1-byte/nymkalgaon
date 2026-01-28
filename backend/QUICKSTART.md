# 🚀 Quick Start Guide - NYM Kalgaon Backend

## ⚡ 3-Step Setup

### 1️⃣ Import Database (2 minutes)

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click **SQL** tab
3. Open `backend/schema.sql` and copy all content
4. Paste in SQL box and click **Go**
5. ✅ Done! Tables created with default admin user

### 2️⃣ Login to Dashboard (30 seconds)

1. Go to: `http://localhost/nymkalgaon/backend/dashboard/login.php`
2. Enter credentials:
   - **Email:** `admin@nymkalgaon.com`
   - **Password:** `admin123`
3. Click **Login to Dashboard**
4. ✅ You're in!

### 3️⃣ Test the System (2 minutes)

**Add Your First News:**
1. Click **Manage News** in sidebar
2. Click **Add New News** button
3. Fill the form:
   - Pick today's date
   - Upload any image (JPG/PNG)
   - Enter heading: "Test News"
   - Enter subheading: "This is a test"
   - Enter details: "Testing the news system"
4. Click **Add News**
5. ✅ News created!

**Update Featured Content:**
1. Click **Featured Content** in sidebar
2. Update the pre-filled content or keep it
3. Upload an image (optional - one exists)
4. Click **Update Featured Content**
5. ✅ Featured updated!

## 🎯 What You Can Do Now

✅ **Manage News** - Add, edit, delete news articles with images  
✅ **Featured Content** - Update homepage featured section  
✅ **Add Users** - Create new admin accounts  
✅ **View Stats** - See total news count on dashboard  

## 📱 Access URLs

| Page | URL |
|------|-----|
| Login | `http://localhost/nymkalgaon/backend/dashboard/login.php` |
| Dashboard | `http://localhost/nymkalgaon/backend/dashboard/dashboard.php` |
| Manage News | `http://localhost/nymkalgaon/backend/dashboard/news/index.php` |
| Featured | `http://localhost/nymkalgaon/backend/dashboard/featured/edit.php` |
| Add User | `http://localhost/nymkalgaon/backend/dashboard/users/register.php` |

## 🔐 Security Reminder

⚠️ **Change default password immediately:**
1. Create a new user with your email
2. Login with new account
3. Delete or change the default admin account

## ❓ Need Help?

- **Can't login?** → Check database imported correctly
- **Images not uploading?** → Check `backend/images/` folder exists
- **Page not found?** → Verify URL starts with `http://localhost/nymkalgaon/`

📖 **Full documentation:** See `backend/README.md`

---

**That's it! You're ready to manage your website content! 🎉**
