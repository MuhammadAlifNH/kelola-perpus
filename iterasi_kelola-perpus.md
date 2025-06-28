# Rencana Iterasi Harian Proyek "Kelola Perpus"
## Panduan Tugas Tim dengan Framework Laravel (Sprint 5 Hari)

Dokumen ini berisi pembagian tugas harian untuk setiap anggota tim. Setiap hari dimulai dengan *stand-up meeting* 15 menit untuk sinkronisasi dan membahas kemajuan.

**Anggota Tim:**
*   **Person A:** [Nama Anda] - Blade & Frontend
*   **Person B:** [Nama Teman 1] - Controller & Logic
*   **Person C:** [Nama Teman 2] - Model, Migration & DB

---

### **Hari 0: Persiapan Proyek Laravel**
**Tujuan Hari Ini:** Menyiapkan proyek Laravel yang fungsional dan repositori bersama.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. `git clone` repositori setelah dibuat oleh Person C.<br>2. Jalankan `composer install`.<br>3. Konfigurasi file `.env` dan jalankan `php artisan key:generate`.<br>4. Pastikan bisa menjalankan `php artisan serve` dan melihat halaman selamat datang Laravel. |
| **Controller & Logic** | Person B | 1. Sama seperti Person A, lakukan `clone` dan setup proyek lokal.<br>2. Pastikan semua prasyarat (XAMPP/Laragon, Composer) sudah terinstal. |
| **Model, DB & Git** | Person C | 1. **(TUGAS UTAMA)** Buat proyek Laravel baru: `composer create-project laravel/laravel kelola-perpus`.<br>2. Buat database `kelola_perpus_db` di MySQL.<br>3. Konfigurasi file `.env` untuk koneksi database.<br>4. Inisialisasi Git, buat commit awal, dan **push ke GitHub**.<br>5. Bagikan URL repo ke tim. |

**Kriteria Selesai (Definition of Done):**
- [ ] Proyek Laravel baru sudah ada di GitHub.
- [ ] Semua anggota tim berhasil melakukan `clone` dan menjalankan server lokal.
- [ ] Koneksi ke database dari Laravel sudah berhasil.

---

### **Iterasi Hari 1: Fondasi & Menampilkan Daftar Buku (Read)**
**Tujuan Hari Ini:** Menampilkan data buku dari database ke halaman web.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. Buat layout utama di `resources/views/layouts/app.blade.php` (dengan Bootstrap 5).<br>2. Buat file view `resources/views/books/index.blade.php` yang meng-`@extend` layout utama.<br>3. Di `index.blade.php`, gunakan `@foreach` untuk menampilkan data buku (yang akan dikirim oleh Person B) dalam sebuah tabel HTML yang rapi. |
| **Controller & Logic** | Person B | 1. Buat Controller: `php artisan make:controller BookController --resource`.<br>2. Definisikan route di `routes/web.php`: `Route::resource('books', BookController::class);`.<br>3. Di `BookController@index`, tulis logika untuk mengambil semua buku: `$books = Book::all();` dan kirim ke view: `return view('books.index', compact('books'));`. |
| **Model, DB & Git** | Person C | 1. Buat Model & Migration: `php artisan make:model Book -m`.<br>2. Edit file migration untuk tabel `books` sesuai SRS (judul, penulis, dll).<br>3. Jalankan migrasi: `php artisan migrate`.<br>4. Buat Seeder: `php artisan make:seeder BookSeeder` untuk mengisi data dummy, lalu jalankan `php artisan db:seed --class=BookSeeder`. |

**Kriteria Selesai (Definition of Done):**
- [ ] Halaman `/books` berhasil menampilkan daftar buku yang diambil dari database.
- [ ] Tabel `books` dan data dummy sudah ada di database.

---

### **Iterasi Hari 2: Fitur Tambah & Hapus Buku (Create & Delete)**
**Tujuan Hari Ini:** Memberi Pustakawan kemampuan untuk menambah dan menghapus buku.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. Buat file view `resources/views/books/create.blade.php` yang berisi `<form>` untuk menambah buku.<br>2. Pastikan form menggunakan method `POST` dan memiliki `@csrf`.<br>3. Di `index.blade.php`, tambahkan tombol "Hapus" yang dibungkus dalam form kecil dengan method `POST` dan `@method('DELETE')`. |
| **Controller & Logic** | Person B | 1. Implementasikan fungsi `create()` di `BookController` untuk menampilkan view `books.create`.<br>2. Implementasikan fungsi `store()` untuk memvalidasi request dan menyimpan buku baru (`Book::create($request->all());`).<br>3. Implementasikan fungsi `destroy(Book $book)` untuk menghapus buku (`$book->delete();`).<br>4. Tambahkan redirect dengan pesan sukses (`->with('success', 'Pesan...')`). |
| **Model, DB & Git** | Person C | 1. Di `App\Models\Book.php`, tambahkan properti `$fillable` untuk mendefinisikan kolom yang boleh diisi massal: `protected $fillable = ['judul', 'penulis', 'tahun_terbit', 'stok'];`.<br>2. Bantu tim melakukan testing dan debugging dari alur form hingga ke database. |

**Kriteria Selesai (Definition of Done):**
- [ ] Pustakawan bisa menambah buku baru melalui form.
- [ ] Pustakawan bisa menghapus buku dari daftar.
- [ ] Pesan sukses (flash message) muncul setelah setiap aksi.

---

### **Iterasi Hari 3: Fitur Edit Buku & Setup Peminjaman (Update)**
**Tujuan Hari Ini:** Melengkapi fitur CRUD buku dan menyiapkan struktur untuk modul peminjaman.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. Buat file view `resources/views/books/edit.blade.php` yang berisi form edit.<br>2. Pastikan form sudah terisi data buku yang akan diedit.<br>3. Gunakan `@method('PUT')` di dalam form edit.<br>4. Buat struktur view dasar untuk modul peminjaman. |
| **Controller & Logic** | Person B | 1. Implementasikan fungsi `edit(Book $book)` di `BookController` untuk menampilkan form edit.<br>2. Implementasikan fungsi `update(Request $request, Book $book)` untuk memvalidasi dan menyimpan perubahan.<br>3. Buat `BorrowController` kosong untuk persiapan besok: `php artisan make:controller BorrowController`. |
| **Model, DB & Git** | Person C | 1. Buat Model & Migration untuk `BorrowLog`: `php artisan make:model BorrowLog -m`.<br>2. Definisikan kolom-kolom di file migration `borrow_logs` sesuai SRS.<br>3. Jalankan `php artisan migrate`.<br>4. Definisikan relasi Eloquent di `Book.php` (`public function borrowLogs()`) dan `BorrowLog.php` (`public function book()`). |

**Kriteria Selesai (Definition of Done):**
- [ ] Fitur edit buku berfungsi dari awal hingga akhir.
- [ ] Tabel `borrow_logs` dan relasinya sudah ada di database.

---

### **Iterasi Hari 4: Fitur Peminjaman & Pengembalian**
**Tujuan Hari Ini:** Menyelesaikan seluruh logika bisnis peminjaman dan pengembalian.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. Buat halaman `/borrow/create` yang berisi form untuk mencatat peminjaman (input nama, dropdown buku yang stoknya > 0).<br>2. Buat halaman `/borrowed-books` yang menampilkan daftar buku yang sedang dipinjam.<br>3. Tambahkan tombol "Kembalikan" di halaman tersebut. |
| **Controller & Logic** | Person B | 1. Definisikan route yang diperlukan untuk peminjaman di `routes/web.php`.<br>2. Di `BorrowController`, implementasikan `create()` dan `store()` untuk proses peminjaman (jangan lupa kurangi stok buku).<br>3. Implementasikan `index()` untuk menampilkan buku yang dipinjam.<br>4. Implementasikan `update()` atau fungsi `returnBook()` untuk proses pengembalian (jangan lupa tambah stok buku). |
| **Model, DB & Git** | Person C | 1. **(TUGAS KRITIS)** Lakukan pengujian end-to-end pada seluruh siklus peminjaman. Pastikan stok buku selalu konsisten.<br>2. Bantu Person B dengan query Eloquent yang mungkin kompleks (misal: mengambil buku yang `stok > 0`). |

**Kriteria Selesai (Definition of Done):**
- [ ] Pustakawan dapat mencatat peminjaman, dan stok buku berkurang.
- [ ] Pustakawan dapat melihat daftar buku yang dipinjam.
- [ ] Pustakawan dapat mengembalikan buku, dan stok buku bertambah.

---

### **Iterasi Hari 5: Finalisasi, Halaman Publik & Demo**
**Tujuan Hari Ini:** Merapikan aplikasi, menambahkan halaman publik, dan menyiapkan demo.

| Peran | Nama Anggota | Tugas Spesifik |
| :--- | :--- | :--- |
| **Blade & Frontend** | Person A | 1. Buat view `resources/views/public/index.blade.php` untuk halaman utama.<br>2. Rapikan semua tampilan, pastikan konsisten dan responsif.<br>3. Pastikan semua pesan sukses/error ditampilkan dengan baik. |
| **Controller & Logic** | Person B | 1. Buat `PublicController`: `php artisan make:controller PublicController`.<br>2. Buat route `GET /` yang mengarah ke `PublicController@index`.<br>3. Di `PublicController`, ambil semua data buku dan kirim ke view publik. |
| **Model, DB & Git** | Person C | 1. Tulis file `README.md` yang lengkap: deskripsi proyek, teknologi, dan cara instalasi (clone, composer install, setup .env, migrate, db:seed, serve).<br>2. Lakukan pengujian akhir pada semua fitur. |
| **Semua** | Tim | 1. Lakukan demo internal untuk memastikan semua fitur bekerja sesuai SRS.<br>2. Siapkan presentasi singkat. |

**Kriteria Selesai (Definition of Done):**
- [ ] Aplikasi bebas dari bug kritis.
- [ ] Halaman publik dapat diakses dan menampilkan data buku.
- [ ] Dokumentasi `README.md` sudah lengkap.
- [ ] Aplikasi siap untuk didemokan.