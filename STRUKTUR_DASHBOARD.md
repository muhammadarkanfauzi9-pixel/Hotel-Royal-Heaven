# Struktur Dashboard Hotel Royal Heaven

## Ringkasan Perubahan Struktur

Aplikasi sudah diorganisir dengan membedakan **Admin Dashboard** dan **Member Dashboard** dengan struktur folder dan routing yang rapi.

---

## 📁 Struktur Folder

### Controllers
```
app/Http/Controllers/
├── Admin/
│   ├── DashboardController.php      # Dashboard admin
│   ├── KamarController.php          # Manajemen kamar
│   ├── PemesananController.php      # Manajemen pemesanan
│   ├── UserController.php           # Manajemen member
│   └── ProfileController.php        # Profil admin
├── Member/
│   ├── DashboardController.php      # Dashboard member
│   ├── KamarController.php          # Lihat daftar kamar
│   ├── PemesananController.php      # Pesan kamar & riwayat
│   └── ProfileController.php        # Profil member
├── AuthController.php               # Auth (shared)
└── KamarController.php              # Public kamar listing
```

### Views
```
resources/views/
├── member/
│   ├── dashboard.blade.php          # Dashboard member
│   ├── kamar/
│   │   └── index.blade.php          # Lihat daftar kamar
│   ├── pemesanan/
│   │   ├── index.blade.php          # Riwayat pemesanan
│   │   └── create.blade.php         # Form pesan kamar
│   └── profile/
│       ├── show.blade.php           # Profil member
│       └── edit.blade.php           # Edit profil member
│
├── admin/
│   ├── dashboard/
│   │   └── index.blade.php          # Dashboard admin
│   ├── kamar/
│   │   ├── index.blade.php          # Manajemen kamar
│   │   ├── create.blade.php         # Form tambah kamar
│   │   └── edit.blade.php           # Form edit kamar
│   ├── pemesanan/
│   │   ├── index.blade.php          # Manajemen pemesanan
│   │   └── show.blade.php           # Detail pemesanan
│   ├── user/
│   │   ├── index.blade.php          # Manajemen member
│   │   ├── show.blade.php           # Detail member
│   │   └── edit.blade.php           # Edit member
│   └── profile/
│       ├── show.blade.php           # Profil admin
│       └── edit.blade.php           # Edit profil admin
│
├── layouts/
├── auth/
├── kamar/                           # Public kamar listing
├── about.blade.php
└── home.blade.php
```

### Middleware
```
app/Http/Middleware/
├── EnsureAdmin.php                  # Cek user adalah admin
└── EnsureMember.php                 # Cek user adalah member (bukan admin)
```

---

## 🔗 Routing Structure

### Admin Routes (prefix: `/admin`)
```
GET    /admin                         → Dashboard admin
GET    /admin/kamar                   → Manajemen kamar
POST   /admin/kamar                   → Tambah kamar
GET    /admin/kamar/{id}/edit         → Form edit kamar
PUT    /admin/kamar/{id}              → Update kamar
DELETE /admin/kamar/{id}              → Hapus kamar
GET    /admin/pemesanan               → Manajemen pemesanan
GET    /admin/user                    → Manajemen member
PUT    /admin/user/{id}               → Update member
DELETE /admin/user/{id}               → Hapus member
GET    /admin/profile                 → Profil admin
PUT    /admin/profile                 → Update profil admin
```

### Member Routes (prefix: `/member`)
```
GET    /member                        → Dashboard member
GET    /member/kamar                  → Daftar kamar
GET    /member/pemesanan              → Riwayat pemesanan
GET    /member/pemesanan/create       → Form pesan kamar
POST   /member/pemesanan              → Simpan pemesanan
GET    /member/profile                → Profil member
PUT    /member/profile                → Update profil member
```

### Public Routes
```
GET    /                              → Landing page
GET    /kamar                         → Daftar kamar (public)
GET    /about                         → Tentang kami
```

### Auth Routes
```
GET    /login                         → Form login
POST   /login                         → Proses login
GET    /register                      → Form register
POST   /register                      → Proses register
POST   /logout                        → Logout
```

---

## 🔐 Middleware Protection

| Route      | Middleware                          | Akses                  |
|------------|-------------------------------------|------------------------|
| `/admin/*` | `auth`, `EnsureAdmin`               | Admin only             |
| `/member/*`| `auth`, `EnsureMember`              | Member only (not admin)|
| `/kamar`   | Public (no auth)                    | Semua user             |
| `/`        | Public (no auth)                    | Semua user             |

---

## ✨ Fitur Berdasarkan Role

### 🔑 Admin
- ✅ Dashboard dengan statistik
- ✅ Manajemen kamar (CRUD)
- ✅ Manajemen pemesanan
- ✅ Manajemen member
- ✅ Profil admin

### 👤 Member
- ✅ Dashboard dengan menu
- ✅ Lihat daftar kamar
- ✅ Pesan kamar
- ✅ Lihat riwayat pemesanan
- ✅ Profil member

---

## 🎯 Cara Menggunakan

### Untuk Admin
1. Login dengan akun admin
2. Akan otomatis diarahkan ke `/admin` (dashboard)
3. Kelola kamar, pemesanan, dan member dari sini

### Untuk Member
1. Register/Login dengan akun member
2. Akan dialihkan ke `/member` (dashboard)
3. Lihat kamar tersedia dan pesan dari sini

---

## 📝 Catatan Penting

- Saat member yang bukan admin mencoba akses admin route, mereka akan di-redirect ke halaman sebelumnya
- Saat admin mencoba akses member route, mereka akan di-redirect
- Struktur folder sudah konsisten dan mudah di-maintain
- Setiap role memiliki folder views yang terpisah untuk claritas
