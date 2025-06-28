# Spesifikasi Kebutuhan Perangkat Lunak (SKPL / SRS)
## Sistem Manajemen Perpustakaan "Kelola Perpus"

**Versi:** 1.0 (MVP)
**Tanggal:** 25 Mei 2024
**Framework:** Laravel 10+

---

### **1. Pendahuluan**

#### **1.1 Tujuan Dokumen**
Dokumen ini mendefinisikan kebutuhan fungsional dan non-fungsional dari proyek **"Kelola Perpus"** yang akan dibangun menggunakan framework PHP Laravel. Dokumen ini menjadi panduan utama bagi tim pengembang untuk memastikan produk akhir sesuai dengan tujuan awal dalam target waktu kurang dari satu minggu.

#### **1.2 Deskripsi Produk**
**"Kelola Perpus"** adalah aplikasi web monolitik (backend dan frontend menyatu) yang dirancang untuk membantu pustakawan mengelola data buku, melacak transaksi peminjaman, serta pengembalian. Aplikasi ini juga menyediakan halaman publik bagi pengunjung untuk melihat ketersediaan buku.

#### **1.3 Aktor (Pengguna Sistem)**

| Aktor | Deskripsi |
| :--- | :--- |
| **Pustakawan (Admin)** | Pengguna utama yang memiliki hak akses ke semua fitur manajemen. Diasumsikan tidak ada sistem login pada versi MVP ini; semua rute di bawah `/admin` (contoh) dapat diakses langsung. |
| **Pengunjung** | Pengguna publik yang mengakses URL utama (`/`). Hanya dapat melihat daftar buku yang tersedia. |

#### **1.4 Lingkup Proyek (Scope)**

**Fitur yang Termasuk (In-Scope):**
*   Manajemen data buku (CRUD - Create, Read, Update, Delete).
*   Pencatatan transaksi peminjaman dan pengembalian buku.
*   Halaman publik untuk melihat daftar buku dan status stoknya.
*   Implementasi menggunakan arsitektur MVC (Model-View-Controller) Laravel.

**Fitur yang TIDAK Termasuk (Out-of-Scope) untuk MVP:**
*   Sistem otentikasi (login/register) untuk Pustakawan atau Anggota.
*   Manajemen data anggota perpustakaan.
*   Perhitungan denda keterlambatan.
*   Fitur pencarian dan filter data.
*   Pencetakan laporan.

---

### **2. Kebutuhan Fungsional**

Detail fitur yang akan dibangun, dijelaskan dalam konteks alur kerja Laravel (Route, Controller, View).

#### **Modul 1: Manajemen Buku (Prefix Rute: `/books`)**

**F-01: Melihat Daftar Buku**
*   **Aktor:** Pustakawan
*   **Rute:** `GET /books`
*   **Controller:** `BookController@index`
*   **Deskripsi:** Pustakawan dapat melihat semua buku yang terdaftar dalam format tabel.
*   **Alur Kerja:**
    1.  Pustakawan mengakses URL `/books`.
    2.  `BookController` memanggil `Book::all()` untuk mengambil semua data dari tabel `books`.
    3.  Controller meneruskan data buku ke view `books.index`.
    4.  View menampilkan tabel yang berisi kolom: No, Judul, Penulis, Tahun Terbit, Stok, dan Aksi (Ubah/Hapus).

**F-02: Menambah Buku Baru**
*   **Aktor:** Pustakawan
*   **Rute:** `GET /books/create` (menampilkan form), `POST /books` (menyimpan data)
*   **Controller:** `BookController@create`, `BookController@store`
*   **Deskripsi:** Pustakawan dapat menambahkan buku baru melalui sebuah form.
*   **Alur Kerja:**
    1.  Pustakawan menekan tombol "Tambah Buku" yang mengarah ke `/books/create`.
    2.  `BookController@create` menampilkan view `books.create` yang berisi form.
    3.  Pustakawan mengisi form (Judul, Penulis, Tahun, Stok) dan menekan "Simpan".
    4.  Request dikirim ke `POST /books`.
    5.  `BookController@store` memvalidasi input, lalu menyimpan data baru ke database.
    6.  Setelah berhasil, pengguna diarahkan kembali ke halaman daftar buku (`/books`) dengan pesan sukses.

**F-03: Mengubah Data Buku**
*   **Aktor:** Pustakawan
*   **Rute:** `GET /books/{book}/edit` (menampilkan form), `PUT /books/{book}` (memperbarui data)
*   **Controller:** `BookController@edit`, `BookController@update`
*   **Deskripsi:** Pustakawan dapat mengubah detail buku yang sudah ada.
*   **Alur Kerja:**
    1.  Pustakawan menekan tombol "Ubah" pada sebuah buku, yang mengarah ke `/books/{id}/edit`.
    2.  `BookController@edit` mengambil data buku yang dipilih dan menampilkannya di view `books.edit`.
    3.  Pustakawan mengubah data di form dan menekan "Update".
    4.  Request dikirim ke `PUT /books/{id}`.
    5.  `BookController@update` memvalidasi dan memperbarui data di database.
    6.  Pengguna diarahkan kembali ke halaman daftar buku (`/books`) dengan pesan sukses.

**F-04: Menghapus Buku**
*   **Aktor:** Pustakawan
*   **Rute:** `DELETE /books/{book}`
*   **Controller:** `BookController@destroy`
*   **Deskripsi:** Pustakawan dapat menghapus data buku.
*   **Alur Kerja:**
    1.  Pustakawan menekan tombol "Hapus" yang mengirimkan request `DELETE` ke `/books/{id}`.
    2.  `BookController@destroy` menghapus data buku dari database.
    3.  Pengguna diarahkan kembali ke halaman daftar buku (`/books`) dengan pesan sukses.

#### **Modul 2: Manajemen Transaksi**

**F-05: Mencatat Peminjaman**
*   **Aktor:** Pustakawan
*   **Rute:** `POST /borrow` (contoh)
*   **Controller:** `BorrowController@store`
*   **Deskripsi:** Mencatat transaksi peminjaman dan mengurangi stok buku.
*   **Alur Kerja:**
    1.  Pustakawan mengisi form peminjaman (nama peminjam, dropdown buku).
    2.  Request dikirim ke `POST /borrow`.
    3.  `BorrowController@store` membuat entri baru di tabel `borrow_logs` dan mengurangi stok di tabel `books` yang bersangkutan.
    4.  Pengguna diarahkan ke halaman daftar buku dipinjam dengan pesan sukses.

**F-06: Melihat & Mengembalikan Buku**
*   **Aktor:** Pustakawan
*   **Rute:** `GET /borrowed-books` (melihat daftar), `PUT /return/{log}` (mengembalikan)
*   **Controller:** `BorrowController@index`, `BorrowController@update`
*   **Deskripsi:** Melihat daftar buku yang sedang dipinjam dan menandainya sebagai "sudah kembali".
*   **Alur Kerja:**
    1.  Pustakawan mengakses `/borrowed-books`. Controller menampilkan daftar buku yang `return_date`-nya masih NULL.
    2.  Pustakawan menekan tombol "Kembalikan" yang mengirim request `PUT` ke `/return/{id}`.
    3.  `BorrowController@update` mengisi `return_date` di `borrow_logs` dan menambah stok di `books`.
    4.  Pengguna diarahkan kembali ke halaman daftar buku dipinjam.

#### **Modul 3: Tampilan Publik**

**F-07: Halaman Publik Daftar Buku**
*   **Aktor:** Pengunjung
*   **Rute:** `GET /`
*   **Controller:** `PublicController@index`
*   **Deskripsi:** Menampilkan daftar buku yang tersedia untuk umum.
*   **Alur Kerja:**
    1.  Pengunjung mengakses URL utama aplikasi (`/`).
    2.  `PublicController` mengambil semua buku dan menampilkannya di view `public.index`.
    3.  Tampilan hanya berisi informasi: Judul, Penulis, Tahun, dan Status Ketersediaan (Tersedia/Habis).

---

### **3. Kebutuhan Non-Fungsional**

| ID | Kategori | Deskripsi Kebutuhan |
| :--- | :--- | :--- |
| **NF-01** | **Usability (Kegunaan)** | Antarmuka aplikasi harus bersih dan intuitif, memanfaatkan komponen UI dari Bootstrap 5. |
| **NF-02** | **Performance (Kinerja)** | Aplikasi harus merespons dalam waktu kurang dari 2 detik untuk setiap request, memanfaatkan caching route dan config Laravel jika memungkinkan. |
| **NF-03** | **Responsiveness** | Tampilan harus adaptif untuk layar desktop dan mobile. |
| **NF-04** | **Maintainability** | Kode harus mengikuti standar PSR-12 dan konvensi penamaan Laravel untuk kemudahan pemeliharaan. |

---

### **4. Kebutuhan Data (Struktur Database via Migrations)**

Rancangan tabel database yang akan dibuat menggunakan fitur Migrations Laravel.

#### **Tabel 1: `books`**
*   **Tujuan:** Menyimpan data semua buku di perpustakaan.
*   **Model Eloquent:** `App\Models\Book`

| Nama Kolom | Tipe Data Laravel | Keterangan |
| :--- | :--- | :--- |
| `id` | `id()` atau `bigIncrements('id')` | Primary Key (PK) |
| `judul` | `string('judul')` | Judul buku |
| `penulis`| `string('penulis')` | Nama penulis |
| `tahun_terbit` | `year('tahun_terbit')` | Tahun terbit |
| `stok` | `unsignedInteger('stok')->default(0)` | Jumlah stok saat ini |
| `timestamps` | `timestamps()` | Membuat kolom `created_at` & `updated_at` |

#### **Tabel 2: `borrow_logs`**
*   **Tujuan:** Menyimpan riwayat transaksi peminjaman.
*   **Model Eloquent:** `App\Models\BorrowLog`

| Nama Kolom | Tipe Data Laravel | Keterangan |
| :--- | :--- | :--- |
| `id` | `id()` | Primary Key (PK) |
| `book_id`| `foreignId('book_id')->constrained()` | Foreign Key (FK) ke `books.id` |
| `borrower_name` | `string('borrower_name')` | Nama peminjam |
| `borrow_date` | `date('borrow_date')` | Tanggal peminjaman |
| `return_date` | `date('return_date')->nullable()` | Tanggal pengembalian, boleh kosong |
| `timestamps` | `timestamps()` | Membuat kolom `created_at` & `updated_at` |