# 🏨 HOTEL ROYAL HEAVEN - QUICK REFERENCE GUIDE

## Admin Access

| Feature | URL | Method |
|---------|-----|--------|
| **Dashboard** | `/admin` | GET |
| **Kamar List** | `/admin/kamar` | GET |
| **Tambah Kamar** | `/admin/kamar/create` | GET |
| **Edit Kamar** | `/admin/kamar/{id}/edit` | GET |
| **Pemesanan** | `/admin/pemesanan` | GET |
| **Detail Pemesanan** | `/admin/pemesanan/{id}` | GET |
| **Member** | `/admin/user` | GET |
| **Profil Admin** | `/admin/profile` | GET |

## Member Access

| Feature | URL | Method |
|---------|-----|--------|
| **Dashboard** | `/member` | GET |
| **Daftar Kamar** | `/member/kamar` | GET |
| **Pesan Kamar** | `/member/pemesanan/create` | GET |
| **Riwayat** | `/member/pemesanan` | GET |
| **Profil** | `/member/profile` | GET |

## Public Routes

| Feature | URL | Method |
|---------|-----|--------|
| **Landing** | `/` | GET |
| **Kamar List** | `/kamar` | GET |
| **About** | `/about` | GET |
| **Login** | `/login` | GET |
| **Register** | `/register` | GET |

---

## Folder Structure

```
📦 Hotel-Royal-Heaven
├── 📂 app/Http/Controllers/
│   ├── 📂 Admin/           ← Admin controllers
│   ├── 📂 Member/          ← Member controllers
│   └── AuthController.php
├── 📂 resources/views/
│   ├── 📂 admin/           ← Admin views
│   ├── 📂 member/          ← Member views
│   └── 📂 auth/
└── 📂 routes/
    └── web.php
```

---

## Controllers

### Admin Controllers
- `Admin\DashboardController` - Dashboard stats
- `Admin\KamarController` - CRUD rooms
- `Admin\PemesananController` - Manage bookings
- `Admin\UserController` - Manage members
- `Admin\ProfileController` - Admin profile

### Member Controllers
- `Member\DashboardController` - Member dashboard
- `Member\KamarController` - Browse rooms
- `Member\PemesananController` - Book & view history
- `Member\ProfileController` - Member profile

---

## Middleware

- `auth` - Check if authenticated
- `EnsureAdmin` - Check if admin (admin routes)
- `EnsureMember` - Check if member, not admin (member routes)

---

## Database Models

- `User` - With `isAdmin()` method
- `Kamar` - Room data
- `Pemesanan` - Booking data
- `TipeKamar` - Room types
- `Review` - Room reviews
- `Wishlist` - User wishlist

---

## Key Features

✅ Admin Dashboard with stats  
✅ Room Management (CRUD)  
✅ Booking Management  
✅ Member Management  
✅ User Profiles  
✅ Role-Based Access Control  
✅ Secure Middleware Protection  
✅ Clean Architecture  

---

## Testing Quick Checklist

- [ ] Login as admin → goes to `/admin`
- [ ] Login as member → goes to `/member`
- [ ] Register → goes to `/member`
- [ ] Admin access `/member/*` → denied
- [ ] Member access `/admin/*` → denied
- [ ] Public routes work
- [ ] Dashboard shows correct data
- [ ] Forms work correctly
- [ ] Delete confirmations work
- [ ] Pagination works

---

## File Locations

**Controllers:** `app/Http/Controllers/{Admin,Member}/`  
**Views:** `resources/views/{admin,member}/`  
**Routes:** `routes/web.php`  
**Middleware:** `app/Http/Middleware/`  
**Models:** `app/Models/`  

---

## Route Naming Convention

```
route('admin.kamar.index')        // Admin kamar list
route('admin.kamar.create')       // Create form
route('admin.kamar.show', $id)    // Show detail
route('admin.kamar.edit', $id)    // Edit form

route('member.pemesanan.index')   // Member bookings
route('member.pemesanan.create')  // Booking form
route('member.kamar.show', $id)   // Room detail
```

---

## Important Methods

```php
// Check if user is admin
if ($user->isAdmin()) { }

// Get authenticated user
$user = Auth::user();

// Redirect to previous page
redirect()->back();

// Redirect to named route
redirect()->route('member.index');

// Generate route URL
route('admin.kamar.index')
```

---

## Common Views

**Admin Dashboard:** `admin/dashboard/index.blade.php`  
**Member Dashboard:** `member/dashboard.blade.php`  
**Room List (Admin):** `admin/kamar/index.blade.php`  
**Room List (Member):** `member/kamar/index.blade.php`  
**Bookings (Admin):** `admin/pemesanan/index.blade.php`  
**Bookings (Member):** `member/pemesanan/index.blade.php`  

---

## Status Codes & Meanings

```
✅ 200 OK - Request successful
⚠️ 401 Unauthorized - Not logged in
🔴 403 Forbidden - Access denied
🔴 404 Not Found - Route not found
⚠️ 422 Unprocessable Entity - Validation error
🔴 500 Internal Server Error - Server error
```

---

## Useful Commands

```bash
# View all routes
php artisan route:list

# Clear config cache
php artisan config:clear

# Migrate database
php artisan migrate

# Seed database
php artisan db:seed

# Run development server
php artisan serve

# Tinker (test code)
php artisan tinker
```

---

## Quick Start for Developers

1. **Add new admin feature:**
   - Create controller in `Admin/`
   - Add views in `admin/`
   - Add routes in `routes/web.php` (admin group)

2. **Add new member feature:**
   - Create controller in `Member/`
   - Add views in `member/`
   - Add routes in `routes/web.php` (member group)

3. **Test access control:**
   - Use middleware for protection
   - Test with different user roles
   - Check middleware flow

---

**Last Updated:** 25 November 2025  
**Status:** ✅ Ready for Production

---

💡 **Pro Tip:** Always follow the folder structure and naming conventions for consistency!
