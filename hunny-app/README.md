# PRESENTASI TUGAS AKHIR PWEB
## Hunny Pet Care - Sistem Manajemen Produk & Reservasi Grooming

---

## 🎯 APA YANG DIBUAT?

**Hunny Pet Care** adalah aplikasi web untuk:
- **Pelanggan**: Membeli produk perawatan hewan dan melakukan reservasi grooming
- **Admin**: Mengelola inventaris produk, mengkonfirmasi pesanan & reservasi, dan mengelola layanan grooming

**Fungsi Utama:**
- Katalog produk lengkap dengan sistem keranjang belanja
- Reservasi layanan grooming dengan pemilihan tanggal & layanan
- Sistem pembayaran dengan dukungan QRIS, e-wallet, & transfer bank
- Dashboard admin untuk konfirmasi pesanan & manajemen data
- Riwayat pesanan & status reservasi real-time

---

## 🛠️ TEKNOLOGI YANG DIPAKAI

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | PHP Laravel 11 (Framework) |
| **Frontend** | HTML5 + CSS3 + JavaScript (ES6+) |
| **Database** | SQLite (Development) / MySQL (Production-ready) |
| **Styling** | Tailwind CSS v3 + Custom CSS |
| **Build Tool** | Vite + Vite Laravel Plugin |
| **Templating** | Blade (Laravel Template Engine) |
| **State Management** | Session + LocalStorage (Browser) |
| **HTTP Client** | Fetch API (Native JS) |
| **UI Components** | Alpine.js + Custom JS |

---

## 📁 STRUKTUR FOLDER UTAMA

```
hunny-app/
├── routes/
│   ├── web.php              # Routing utama (CRUD & API)
│   └── auth.php             # Auth routes (login, register, logout)
├── app/
│   ├── Http/Controllers/    # Business Logic
│   │   ├── BookingController.php
│   │   ├── OrderController.php
│   │   └── AdminProdukController.php
│   ├── Http/Middleware/     # Auth & Role Middleware
│   │   └── CekAdmin.php     # Admin-only protection
│   └── Models/              # Database Models
│       ├── Booking.php
│       ├── Order.php
│       └── Produk.php
├── resources/
│   ├── views/               # Blade Templates
│   │   ├── beranda.blade.php           # Landing page
│   │   ├── shop/index.blade.php        # Product catalog
│   │   ├── checkout.blade.php          # Checkout form
│   │   ├── booking/                    # Reservation forms
│   │   └── admin/                      # Admin dashboard
│   └── css/app.css          # Tailwind directives
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Admin & data seeders
├── public/
│   ├── style.css            # Custom CSS
│   ├── app.js               # Global JS (Theme, animations, etc)
│   └── index.php            # Entry point
└── config/
    ├── auth.php             # Auth configuration
    ├── session.php          # Session config
    └── database.php         # DB config
```

---

## ✨ FITUR YANG SUDAH DIIMPLEMENTASIKAN

### A. UNTUK CUSTOMER
1. ✅ **Browse Produk** - Lihat katalog produk dengan kategori
2. ✅ **Keranjang Belanja** - Tambah/hapus produk via LocalStorage
3. ✅ **Checkout** - Form input dengan validasi sisi klien
4. ✅ **Pilih Pembayaran** - QRIS, E-wallet, Transfer Bank
5. ✅ **Upload Bukti** - Unggah screenshot bukti pembayaran
6. ✅ **Lihat Pesanan Saya** - Search & filter status pesanan
7. ✅ **Buat Reservasi** - Form grooming dengan pilihan layanan
8. ✅ **Lihat Reservasi Saya** - Daftar booking personal
9. ✅ **Profile** - Edit data pribadi & ganti password

### B. UNTUK ADMIN
1. ✅ **Kelola Produk** - Create, Read, Update, Delete (CRUD)
2. ✅ **Kelola Stok** - Pantau ketersediaan barang
3. ✅ **Konfirmasi Pesanan** - Lihat bukti bayar → Setujui/Tolak
4. ✅ **Konfirmasi Reservasi** - Terima/Tolak booking grooming
5. ✅ **Kelola Layanan** - CRUD jenis grooming & harga
6. ✅ **Dashboard Statistik** - Total pesanan & pending orders

### C. KEAMANAN & PENGALAMAN USER
1. ✅ **Autentikasi** - Login/Register dengan session
2. ✅ **Role-Based Access** - Middleware `CekAdmin` untuk halaman admin
3. ✅ **CSRF Protection** - Token @csrf di semua form
4. ✅ **Dark Mode** - Toggle tema dengan simpan di cookie
5. ✅ **Responsive Design** - Mobile-friendly untuk semua halaman
6. ✅ **Error Handling** - Validasi form & feedback error
7. ✅ **Loading States** - Indikator loading saat proses

---

## 🎓 KESESUAIAN DENGAN 5 SOAL TUGAS AKHIR

### ✅ SOAL 1: Frontend (HTML & CSS)
**Status: TERPENUHI**
- Halaman utama: `resources/views/beranda.blade.php` (landing page)
- Halaman daftar data: `resources/views/shop/index.blade.php` (katalog produk)
- Halaman form input: `resources/views/booking/create.blade.php` (form reservasi)
- Halaman detail: `resources/views/booking/show.blade.php` (detail reservasi)
- CSS responsif: `public/style.css` (1000+ lines) + Tailwind utilities di Blade

**Bukti:**
```
- HTML5 semantik (<article>, <section>, <nav>, <form>, <table>)
- CSS Grid & Flexbox untuk layout responsive
- Font Google: Playfair Display + DM Sans
- Dark mode support dengan CSS custom properties
```

---

### ✅ SOAL 2: Interaktivitas (JavaScript & DOM Manipulation)
**Status: TERPENUHI**
- Event listeners pada form, button, & scroll
- Validasi form sisi klien (checkout, reservasi)
- DOM manipulation untuk preview keranjang belanja
- LocalStorage untuk cart management
- Theme toggle dengan cookie persistence

**Bukti Kode:**
```javascript
// File: resources/views/checkout.blade.php (Line 153-260)
function renderPreview() { /* update DOM */ }
async function submitOrder(event) { /* validasi & submit */ }

// File: public/app.js (Line 162-220)
function setCookie(name, value, days) { /* save theme */ }
function getCookie(name) { /* retrieve theme */ }
document.addEventListener('DOMContentLoaded', () => { /* apply theme */ });
```

---

### ✅ SOAL 3: Backend & Database (PHP + CRUD)
**Status: TERPENUHI**
- **PHP Framework:** Laravel 11 (full MVC pattern)
- **CRUD Operations:**
  - Create: `BookingController@store`, `OrderController@store`
  - Read: `BookingController@show`, `OrderController@detail`
  - Update: `BookingController@update`, `AdminProdukController@update`
  - Delete: `BookingController@destroy`, `AdminProdukController@destroy`
- **Database Models:** Booking, Order, Produk, User, Service
- **Migrations:** 8+ migration files untuk schema
- **Relationships:** HasMany, BelongsTo, Eager loading

**Bukti Struktur:**
```
routes/web.php → Controllers → Models → Database Migrations
│
├─ Route::resource('booking', BookingController)
├─ Route::resource('admin/produk', AdminProdukController)
└─ POST /checkout → OrderController@processCheckout
```

---

### ✅ SOAL 4: Keamanan (Cookies & Session)
**Status: TERPENUHI**
- **Session Driver:** File-based session (configurable ke database)
- **Authentication:** Middleware `auth` di routes
- **Authorization:** Middleware `cek.admin` untuk admin-only routes
- **Role-Based:** User model dengan method `isAdmin()`
- **CSRF Token:** `@csrf` di semua form Blade
- **Cookies:** Preference cookies untuk tema (secure, HttpOnly)
- **Session Config:** `config/session.php` dengan 120 menit lifetime

**Bukti Implementasi:**
```php
// routes/web.php (Line 41-88)
Route::middleware('auth')->group(function () { /* Protected routes */ });
Route::middleware('cek.admin')->group(function () { /* Admin only */ });

// app/Http/Middleware/CekAdmin.php
public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'Akses ditolak');
    }
    return $next($request);
}
```

---

### ✅ SOAL 5: Komunikasi Asinkronus (AJAX / JSON)
**Status: TERPENUHI**
- **Fetch API** digunakan di 4+ halaman untuk komunikasi tanpa reload
- **JSON Response** dari controller untuk handling data

**Contoh Implementasi:**

#### 1. Booking Search (File: resources/views/booking/index.blade.php, Line 181-206)
```javascript
form.addEventListener('submit', async function (event) {
    event.preventDefault();
    const response = await fetch('{{ route("booking.search") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ query }),
    });
    const json = await response.json();
    // Update DOM dengan hasil tanpa reload
});
```

#### 2. Update Order Status (File: resources/views/admin/konfirmasi.blade.php, Line 100-109)
```javascript
async function updateStatus(orderId, status) {
    const response = await fetch(`/admin/orders/${orderId}/status`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: JSON.stringify({ status }),
    });
    window.location.reload(); // Refresh setelah update
}
```

#### 3. Checkout Submission (File: resources/views/checkout.blade.php, Line 219-245)
```javascript
const response = await fetch(checkoutUrl, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
    body: formData, // FormData untuk file upload
});
const json = await response.json();
// Handle response & redirect ke order history
```

---

## 📊 METRIK IMPLEMENTASI

| Aspek | Jumlah | Catatan |
|-------|--------|---------|
| **Routes** | 50+ | CRUD + Custom endpoints |
| **Controllers** | 8 | BookingController, OrderController, AdminProdukController, dll |
| **Models** | 7 | User, Booking, Order, Produk, Service, Supplier, Customer |
| **Database Tables** | 8+ | users, bookings, orders, produks, services, dll |
| **Blade Views** | 30+ | Landing, Shop, Checkout, Booking, Admin, Auth |
| **CSS Custom** | 1000+ lines | Responsive design + dark mode |
| **JavaScript** | 600+ lines | Events, animations, theme, AJAX logic |
| **Middleware** | 3 | auth, verified, cek.admin |
| **Validations** | 20+ | Server-side + client-side |
| **Fetch Endpoints** | 4+ | Search, Status update, Checkout, Preference |

---

## 🚀 CARA MENJALANKAN

### 1. Setup Environment
```bash
cd hunny-app
cp .env.example .env
php artisan key:generate
```

### 2. Setup Database
```bash
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

### 3. Build Frontend & Run Server
```bash
npm install
npm run build    # atau npm run dev untuk development
php artisan serve
```

### 4. Akses Aplikasi
- **URL:** http://localhost:8000
- **Admin Login:** 
  - Email: `admin@hunnyapp.com`
  - Password: `password`

---

## 💡 HIGHLIGHTS TEKNIS

1. **MVC Architecture:** Separation of concerns (Model, View, Controller)
2. **RESTful Routing:** Resource routes untuk CRUD operations
3. **Query Optimization:** Eager loading & pagination
4. **Error Handling:** Try-catch & validation feedback
5. **Security First:** CSRF tokens, middleware, role-based access
6. **Responsive:** Mobile-first design dengan Tailwind + custom CSS
7. **Real-time UX:** Fetch API untuk update tanpa full reload
8. **State Management:** Session (server) + LocalStorage (client)
9. **Dark Mode:** Theme preference dengan persistent cookies
10. **Scalable:** Structure siap untuk production dengan minimal changes

---

## ✨ KESIMPULAN

✅ **Aplikasi Hunny Pet Care** sudah **lengkap** memenuhi **5 soal tugas akhir:**
1. Frontend (HTML & CSS) ✓
2. Interaktivitas (JavaScript & DOM) ✓
3. Backend & Database (PHP + CRUD) ✓
4. Keamanan (Session & Middleware) ✓
5. AJAX / Komunikasi Asinkronus ✓

Sistem ini siap digunakan sebagai **aplikasi demo** maupun **base project** untuk pengembangan lebih lanjut.
