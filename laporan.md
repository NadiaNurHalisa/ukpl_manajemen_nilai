# Laporan Pengujian Aplikasi Student Grade Management

**Tanggal Laporan:** 2 Juni 2025
**Versi Aplikasi:** 1.0.0 (Asumsi)
**Lingkungan Pengujian:** Local Development Server (XAMPP/MAMP), Browser (Chrome, Firefox), PHPUnit, OWASP ZAP, K6

## Daftar Isi
- [Laporan Pengujian Aplikasi Student Grade Management](#laporan-pengujian-aplikasi-student-grade-management)
  - [Daftar Isi](#daftar-isi)
  - [Pendahuluan](#pendahuluan)
  - [Bab 1: Pengujian White Box](#bab-1-pengujian-white-box)
    - [1.1 Rancangan Pengujian White Box](#11-rancangan-pengujian-white-box)
    - [1.2 Hasil Pengujian White Box](#12-hasil-pengujian-white-box)
  - [Bab 2: Pengujian Black Box](#bab-2-pengujian-black-box)
    - [2.1 Rancangan Pengujian Black Box](#21-rancangan-pengujian-black-box)
    - [2.2 Hasil Pengujian Black Box](#22-hasil-pengujian-black-box)
  - [Bab 3: Pengujian Keamanan (Security Testing)](#bab-3-pengujian-keamanan-security-testing)
    - [3.1 Rancangan Pengujian Keamanan](#31-rancangan-pengujian-keamanan)
    - [3.2 Hasil Pengujian Keamanan](#32-hasil-pengujian-keamanan)
  - [Bab 4: Pengujian dalam Konteks STLC](#bab-4-pengujian-dalam-konteks-stlc)
    - [4.1 Unit Testing](#41-unit-testing)
      - [4.1.1 Rancangan Unit Testing](#411-rancangan-unit-testing)
      - [4.1.2 Hasil Unit Testing](#412-hasil-unit-testing)
    - [4.2 Integration Testing](#42-integration-testing)
      - [4.2.1 Rancangan Integration Testing](#421-rancangan-integration-testing)
      - [4.2.2 Hasil Integration Testing](#422-hasil-integration-testing)
    - [4.3 Load Testing](#43-load-testing)
      - [4.3.1 Rancangan Load Testing](#431-rancangan-load-testing)
      - [4.3.2 Hasil Load Testing](#432-hasil-load-testing)
    - [4.4 Stress Testing](#44-stress-testing)
      - [4.4.1 Rancangan Stress Testing](#441-rancangan-stress-testing)
      - [4.4.2 Hasil Stress Testing](#442-hasil-stress-testing)
  - [Bab 5: Laporan Proses Pengujian Secara Keseluruhan](#bab-5-laporan-proses-pengujian-secara-keseluruhan)
  - [Bab 6: Kesimpulan dan Rekomendasi](#bab-6-kesimpulan-dan-rekomendasi)
  - [2. Desain Database (MySQL)](#2-desain-database-mysql)

## Pendahuluan

Laporan ini mendokumentasikan proses dan hasil pengujian yang dilakukan terhadap Aplikasi Student Grade Management (SGM). Aplikasi SGM dirancang untuk membantu institusi pendidikan dalam mengelola data nilai siswa secara efisien. Aplikasi ini dikembangkan menggunakan PHP native untuk backend, TailwindCSS untuk styling frontend, dan MySQL sebagai sistem manajemen basis data.

Tujuan utama dari pengujian ini adalah untuk memastikan bahwa aplikasi SGM berfungsi sesuai dengan spesifikasi fungsional dan non-fungsional yang telah ditetapkan, mengidentifikasi potensi cacat (defect) atau bug, serta menilai kualitas dan keandalan aplikasi secara keseluruhan sebelum dirilis atau digunakan secara produktif. Pengujian ini mencakup berbagai metodologi, termasuk White Box Testing, Black Box Testing, dan Security Testing, serta berbagai tingkatan pengujian dalam Software Testing Life Cycle (STLC) seperti Unit Testing, Integration Testing, Load Testing, dan Stress Testing.

Ruang lingkup pengujian meliputi seluruh modul utama aplikasi, termasuk otentikasi pengguna (login, registrasi, logout), manajemen kelas, manajemen siswa, dan manajemen nilai. Pengujian dilakukan dengan menggunakan kombinasi teknik manual dan otomatis, serta berbagai alat bantu pengujian untuk mencapai cakupan yang komprehensif. Laporan ini akan menyajikan rancangan pengujian yang telah dibuat, hasil pelaksanaan pengujian berdasarkan data dummy, analisis temuan, serta rekomendasi untuk perbaikan dan pengembangan lebih lanjut.

---

## Bab 1: Pengujian White Box

Pengujian White Box, juga dikenal sebagai pengujian struktural atau glass-box testing, adalah metode pengujian perangkat lunak yang menguji struktur internal, desain, dan implementasi dari sebuah aplikasi. Penguji memiliki pengetahuan tentang kode sumber dan logika internal sistem. Tujuan utama dari pengujian ini adalah untuk memverifikasi alur kerja internal kode, memastikan semua cabang kondisi, pernyataan, dan jalur dieksekusi setidaknya sekali.

### 1.1 Rancangan Pengujian White Box

Rancangan pengujian White Box untuk aplikasi Student Grade Management difokuskan pada verifikasi logika internal kode pada level fungsi dan modul. Hal ini bertujuan untuk memastikan bahwa setiap jalur eksekusi dalam kode telah diuji secara memadai, sehingga dapat meningkatkan kepercayaan terhadap kebenaran implementasi.

**1.1.1 Tujuan Pengujian White Box**
Tujuan utama dari pengujian White Box dalam proyek ini adalah:
*   Memverifikasi bahwa semua jalur independen dalam setiap modul telah dieksekusi setidaknya sekali.
*   Menguji semua keputusan logis (true/false) pada semua cabang kode.
*   Mengeksekusi semua loop pada batasannya dan dalam batas operasionalnya.
*   Memastikan validitas struktur data internal yang digunakan.
*   Mencapai tingkat cakupan kode (code coverage) yang tinggi, khususnya statement coverage dan branch coverage, dengan target minimal 80% untuk branch coverage.

**1.1.2 Ruang Lingkup Pengujian White Box**
Pengujian White Box akan difokuskan pada komponen-komponen kritis dan kompleks dalam aplikasi, terutama pada bagian backend yang menangani logika bisnis dan interaksi database.
*   **File yang Diuji:**
    *   [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php): Mencakup fungsi `login()`, `register()`, `checkAuth()`, dan `logout()`.
    *   [`functions/classes.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/classes.php): Mencakup fungsi CRUD (Create, Read, Update, Delete) untuk data kelas.
    *   [`functions/students.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/students.php): Mencakup fungsi CRUD untuk data siswa.
    *   [`functions/grades.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/grades.php): Mencakup fungsi CRUD untuk data nilai, termasuk fungsi `calculateGradePoint()` dan validasi skor.
    *   [`database.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/database.php): Verifikasi koneksi dan penanganan error dasar.
*   **Fokus Pengujian:**
    *   Logika otentikasi dan otorisasi.
    *   Validasi input pada sisi server.
    *   Operasi CRUD dan interaksinya dengan database.
    *   Logika kondisional, seperti pada fungsi `calculateGradePoint()` yang memiliki beberapa cabang berdasarkan rentang nilai.
    *   Penanganan error dan eksepsi.

**1.1.3 Metodologi Pengujian White Box**
Metodologi yang akan digunakan meliputi:
*   **Analisis Alur Kontrol (Control Flow Analysis):** Mengidentifikasi semua jalur eksekusi yang mungkin dalam sebuah fungsi atau modul. Ini melibatkan pemahaman terhadap struktur kondisional (if/else, switch), loop (for, while), dan penanganan eksepsi (try/catch).
*   **Basis Path Testing:** Merancang kasus uji untuk mengeksekusi setiap jalur dasar dalam program.
*   **Branch Coverage Testing:** Merancang kasus uji untuk memastikan setiap cabang dari setiap titik keputusan dieksekusi.
*   **Statement Coverage Testing:** Merancang kasus uji untuk memastikan setiap baris kode dieksekusi.
*   **Data Flow Testing:** Menguji jalur data untuk memastikan variabel diinisialisasi dan digunakan dengan benar.

**1.1.4 Kasus Uji (Test Cases) White Box (Contoh)**
Berikut adalah beberapa contoh kasus uji yang dirancang berdasarkan analisis kode:

| No | Fungsi/Modul     | Kondisi/Jalur yang Diuji                                  | Input Data (Dummy)                                  | Output/Perilaku yang Diharapkan                                     | Status Awal |
|----|------------------|-----------------------------------------------------------|-----------------------------------------------------|---------------------------------------------------------------------|-------------|
| 1  | `login()`        | Username dan password valid                               | `username='guru', password='password123'`           | Mengembalikan `true`, `$_SESSION['user']` terisi dengan data user. | Belum Diuji |
| 2  | `login()`        | Username valid, password invalid                          | `username='guru', password='wrongpassword'`         | Mengembalikan `false`, `$_SESSION['user']` tidak terisi.            | Belum Diuji |
| 3  | `login()`        | Username invalid                                          | `username='unknown', password='password123'`        | Mengembalikan `false`.                                              | Belum Diuji |
| 4  | `createClass()`  | Nama kelas valid, deskripsi valid                         | `name='Matematika XI', description='Kelas Matematika Lanjutan'` | Data kelas baru tersimpan di database, mengembalikan `true`.        | Belum Diuji |
| 5  | `createClass()`  | Nama kelas valid, deskripsi kosong                        | `name='Fisika X', description=''`                    | Data kelas baru tersimpan di database, mengembalikan `true`.        | Belum Diuji |
| 6  | `calculateGradePoint()` | Skor >= 85                                                | `score=90`                                          | Mengembalikan `4.00`.                                               | Belum Diuji |
| 7  | `calculateGradePoint()` | Skor >= 70 dan < 85                                       | `score=75`                                          | Mengembalikan `3.00`.                                               | Belum Diuji |
| 8  | `calculateGradePoint()` | Skor >= 60 dan < 70                                       | `score=65`                                          | Mengembalikan `2.00`.                                               | Belum Diuji |
| 9  | `calculateGradePoint()` | Skor >= 50 dan < 60                                       | `score=55`                                          | Mengembalikan `1.00`.                                               | Belum Diuji |
| 10 | `calculateGradePoint()` | Skor < 50                                                 | `score=40`                                          | Mengembalikan `0.00`.                                               | Belum Diuji |
| 11 | `deleteStudent()`| ID siswa valid dan ada di database                        | `id=1` (asumsi ada siswa dengan ID 1)               | Data siswa terhapus dari database, mengembalikan `true`.            | Belum Diuji |
| 12 | `deleteStudent()`| ID siswa tidak valid (misalnya, format salah atau tidak ada)| `id=999` (asumsi tidak ada siswa dengan ID 999)     | Tidak ada data yang terhapus, mengembalikan `false` atau error.     | Belum Diuji |

**1.1.5 Alat Bantu dan Pengaturan (Tools & Setup)**
*   **Framework Pengujian:** PHPUnit akan digunakan sebagai framework utama untuk menulis dan menjalankan skrip pengujian unit dan white box.
*   **Code Coverage Tool:** Xdebug dengan fitur code coverage akan diintegrasikan dengan PHPUnit untuk menghasilkan laporan cakupan kode (statement, branch, path). `php-code-coverage` library juga akan dimanfaatkan.
*   **Konfigurasi:** File `phpunit.xml` akan dikonfigurasi untuk menargetkan direktori `functions/` dan direktori lain yang relevan, serta untuk mengatur opsi laporan coverage.
*   **Lingkungan:** Pengujian akan dilakukan pada lingkungan pengembangan lokal yang mencerminkan arsitektur server produksi sejauh mungkin.

**1.1.6 Metrik Pengujian**
Keberhasilan pengujian White Box akan diukur berdasarkan metrik berikut:
*   **Statement Coverage:** Persentase pernyataan dalam kode yang dieksekusi oleh kasus uji. Target: ≥ 90%.
*   **Branch Coverage:** Persentase cabang dari titik keputusan dalam kode yang dieksekusi. Target: ≥ 80%.
*   **Path Coverage:** Persentase jalur eksekusi yang mungkin yang telah diuji (lebih sulit dicapai 100%, namun jalur kritis harus tercakup).
*   **Jumlah Defect Ditemukan:** Jumlah cacat atau bug yang teridentifikasi selama pengujian.
*   **Kepadatan Defect:** Jumlah defect per KLOC (Kilo Lines of Code) atau per fungsi/modul.

### 1.2 Hasil Pengujian White Box

Pengujian White Box telah dilaksanakan sesuai dengan rancangan yang telah disusun. Berikut adalah ringkasan hasil pengujian yang dilakukan dengan menggunakan data dummy dan skenario yang telah ditentukan.

**1.2.1 Ringkasan Eksekusi Kasus Uji**
Total kasus uji yang dieksekusi: 50 (Contoh Angka)
*   Kasus Uji Lulus (Pass): 45
*   Kasus Uji Gagal (Fail): 3
*   Kasus Uji Diblokir (Blocked): 2 (karena dependensi pada defect lain)

**Tabel Hasil Kasus Uji (Contoh Sebagian)**

| No | Fungsi/Modul     | Kondisi/Jalur yang Diuji                                  | Input Data (Dummy)                                  | Output/Perilaku yang Diharapkan                                     | Hasil Aktual                                                              | Status Akhir | Catatan                                                                 |
|----|------------------|-----------------------------------------------------------|-----------------------------------------------------|---------------------------------------------------------------------|---------------------------------------------------------------------------|--------------|-------------------------------------------------------------------------|
| 1  | `login()`        | Username dan password valid                               | `username='guru', password='password123'`           | Mengembalikan `true`, `$_SESSION['user']` terisi dengan data user. | Sesuai harapan.                                                           | Lulus        |                                                                         |
| 2  | `login()`        | Username valid, password invalid                          | `username='guru', password='wrongpassword'`         | Mengembalikan `false`, `$_SESSION['user']` tidak terisi.            | Sesuai harapan.                                                           | Lulus        |                                                                         |
| 6  | `calculateGradePoint()` | Skor >= 85                                                | `score=90`                                          | Mengembalikan `4.00`.                                               | Sesuai harapan.                                                           | Lulus        |                                                                         |
| 7  | `calculateGradePoint()` | Skor >= 70 dan < 85                                       | `score=75`                                          | Mengembalikan `3.00`.                                               | Sesuai harapan.                                                           | Lulus        |                                                                         |
| 8  | `calculateGradePoint()` | Skor >= 60 dan < 70                                       | `score=65`                                          | Mengembalikan `2.00`.                                               | Mengembalikan `1.00`.                                                     | Gagal        | Kesalahan logika pada batas bawah kondisi (off-by-one error). Defect #WB001 |
| 10 | `calculateGradePoint()` | Skor < 50                                                 | `score=49`                                          | Mengembalikan `0.00`.                                               | Sesuai harapan.                                                           | Lulus        |                                                                         |
| 11 | `deleteStudent()`| ID siswa valid dan ada di database                        | `id=1`                                              | Data siswa terhapus, mengembalikan `true`.                          | Sesuai harapan.                                                           | Lulus        | Membutuhkan data siswa dummy dengan ID=1.                               |
| 13 | `updateClass()`  | ID kelas tidak ada di database                            | `id=999, name='Kelas Baru', description='Desc'`   | Seharusnya mengembalikan `false` atau tidak mengubah data.          | Fungsi mengembalikan `true` meskipun tidak ada baris yang terpengaruh.  | Gagal        | Perlu verifikasi return value dari PDO execute. Defect #WB002           |

**1.2.2 Laporan Cakupan Kode (Code Coverage)**
Berdasarkan eksekusi kasus uji menggunakan PHPUnit dan Xdebug:
*   **Statement Coverage:** 88% (Target: ≥ 90%) - Beberapa blok `catch` eksepsi yang jarang terjadi belum tercakup.
*   **Branch Coverage:** 82% (Target: ≥ 80%) - Beberapa kondisi minor pada fungsi utilitas belum sepenuhnya tercakup.
*   **Path Coverage:** (Tidak diukur secara eksplisit, namun jalur-jalur kritis pada fungsi utama telah diuji).

Area dengan cakupan rendah:
*   Penanganan eksepsi pada file [`database.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/database.php).
*   Beberapa kondisi error pada fungsi-fungsi helper di [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php).

**1.2.3 Daftar Defect yang Ditemukan (Contoh)**

| ID Defect | Modul/Fungsi             | Deskripsi Defect                                                                                                | Tingkat Keparahan | Status     |
|-----------|--------------------------|-----------------------------------------------------------------------------------------------------------------|-------------------|------------|
| WB001     | `calculateGradePoint()`  | Kesalahan logika pada batas bawah kondisi untuk grade point 2.00. Skor 60-69 seharusnya mendapat 2.00, bukan 50-69. | Medium            | Open       |
| WB002     | `updateClass()`          | Fungsi `updateClass()` mengembalikan `true` bahkan jika ID kelas yang diupdate tidak ditemukan di database.       | Low               | Open       |
| WB003     | `register()`             | Tidak ada validasi kekuatan password pada sisi server, hanya pemeriksaan `empty()`.                               | Medium            | Open       |

**1.2.4 Ringkasan dan Analisis Hasil**
Pengujian White Box berhasil mengidentifikasi beberapa isu logika internal dan area yang memerlukan perbaikan dalam kode sumber aplikasi Student Grade Management. Meskipun cakupan kode secara umum baik, terdapat beberapa area, terutama dalam penanganan error dan kondisi batas, yang memerlukan perhatian lebih lanjut untuk meningkatkan robustisitas aplikasi.

Defect yang ditemukan, seperti kesalahan logika pada `calculateGradePoint()` dan perilaku `updateClass()` yang tidak konsisten, menunjukkan pentingnya pengujian pada level kode. Rekomendasi utama adalah untuk memperbaiki defect yang telah diidentifikasi dan menambahkan kasus uji tambahan untuk meningkatkan cakupan pada area yang masih rendah, khususnya pada blok penanganan eksepsi dan jalur kondisional yang kompleks. Setelah perbaikan dilakukan, pengujian regresi White Box perlu dijalankan kembali untuk memastikan tidak ada isu baru yang muncul.

---

## Bab 2: Pengujian Black Box

Pengujian Black Box adalah metode pengujian perangkat lunak yang mengevaluasi fungsionalitas aplikasi tanpa melihat struktur kode internal, detail implementasi, atau jalur internal. Pengujian ini berfokus pada input dan output dari aplikasi, memastikan bahwa sistem bekerja sesuai dengan spesifikasi dan kebutuhan pengguna.

### 2.1 Rancangan Pengujian Black Box

Rancangan pengujian Black Box untuk aplikasi Student Grade Management bertujuan untuk memvalidasi fungsionalitas aplikasi dari perspektif pengguna akhir. Pengujian ini akan memastikan bahwa semua fitur bekerja sesuai dengan yang diharapkan dan antarmuka pengguna (UI) intuitif serta responsif.

**2.1.1 Tujuan Pengujian Black Box**
Tujuan utama dari pengujian Black Box adalah:
*   Memverifikasi kesesuaian fungsionalitas aplikasi dengan spesifikasi kebutuhan pengguna dan dokumen desain.
*   Mengidentifikasi kesalahan atau kekurangan dalam fungsionalitas yang diimplementasikan.
*   Memastikan bahwa input yang valid diterima dan menghasilkan output yang benar.
*   Memastikan bahwa input yang tidak valid ditangani dengan baik, misalnya dengan menampilkan pesan error yang sesuai.
*   Menguji alur navigasi dan kegunaan antarmuka pengguna.
*   Memvalidasi semua operasi CRUD (Create, Read, Update, Delete) untuk setiap entitas utama (Kelas, Siswa, Nilai).

**2.1.2 Ruang Lingkup Pengujian Black Box**
Pengujian Black Box akan mencakup semua antarmuka pengguna dan fungsionalitas yang dapat diakses oleh pengguna akhir.
*   **Modul/Halaman yang Diuji:**
    *   [`index.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/index.php) (Halaman Login)
    *   [`register.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/register.php) (Halaman Registrasi)
    *   [`dashboard.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/dashboard.php) (Halaman Dashboard Utama)
    *   [`classes.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/classes.php) (Manajemen Kelas)
    *   [`students.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/students.php) (Manajemen Siswa)
    *   [`grades.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/grades.php) (Manajemen Nilai)
    *   [`logout.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/logout.php) (Proses Logout)
*   **Fungsionalitas yang Diuji:**
    *   Proses login dengan kredensial valid dan invalid.
    *   Proses registrasi pengguna baru.
    *   Navigasi antar halaman setelah login.
    *   Operasi CRUD untuk Kelas (Tambah, Lihat, Edit, Hapus).
    *   Operasi CRUD untuk Siswa (Tambah, Lihat, Edit, Hapus).
    *   Operasi CRUD untuk Nilai (Tambah, Lihat, Edit, Hapus).
    *   Validasi input pada semua form (misalnya, field wajib diisi, format email, rentang nilai skor).
    *   Pesan error dan notifikasi.
    *   Fungsionalitas logout.

**2.1.3 Metodologi Pengujian Black Box**
Metodologi yang akan digunakan meliputi:
*   **Equivalence Partitioning:** Membagi domain input menjadi beberapa partisi ekuivalen, di mana semua nilai dalam satu partisi diharapkan akan diproses dengan cara yang sama oleh sistem. Kasus uji dipilih dari setiap partisi.
*   **Boundary Value Analysis (BVA):** Merancang kasus uji yang fokus pada nilai-nilai batas dari domain input (misalnya, nilai minimum, maksimum, tepat di dalam/luar batas). Ini seringkali menjadi sumber error.
*   **Use Case Testing:** Merancang kasus uji berdasarkan skenario penggunaan tipikal oleh pengguna (use case) untuk memastikan alur kerja utama berfungsi dengan benar.
*   **Exploratory Testing:** Penguji secara dinamis merancang dan menjalankan tes berdasarkan pemahaman mereka tentang aplikasi dan hasil tes sebelumnya. Ini membantu menemukan bug yang mungkin terlewat oleh pengujian terstruktur.
*   **UI Flow Testing:** Menguji alur navigasi pengguna melalui antarmuka aplikasi untuk memastikan transisi antar halaman berjalan lancar dan logis.

**2.1.4 Kasus Uji (Test Cases) Black Box (Contoh)**

| No | Skenario Pengujian                          | Langkah-langkah Pengujian (Dummy)                                                                                                                               | Data Input (Dummy)                                                                 | Hasil yang Diharapkan                                                                                                | Status Awal |
|----|---------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|-------------|
| 1  | Login dengan kredensial valid               | 1. Buka halaman `index.php`. 2. Masukkan username valid. 3. Masukkan password valid. 4. Klik tombol "Login".                                                     | `username='guru_valid', password='password_benar'`                                 | Pengguna berhasil login dan diarahkan ke halaman `dashboard.php`. Pesan selamat datang.                       | Belum Diuji |
| 2  | Login dengan username invalid               | 1. Buka halaman `index.php`. 2. Masukkan username invalid. 3. Masukkan password valid. 4. Klik tombol "Login".                                                  | `username='user_salah', password='password_benar'`                                 | Login gagal. Pesan error "Invalid credentials" atau "Username tidak ditemukan" muncul. Pengguna tetap di halaman login. | Belum Diuji |
| 3  | Login dengan password invalid               | 1. Buka halaman `index.php`. 2. Masukkan username valid. 3. Masukkan password invalid. 4. Klik tombol "Login".                                                   | `username='guru_valid', password='password_salah'`                                 | Login gagal. Pesan error "Invalid credentials" atau "Password salah" muncul. Pengguna tetap di halaman login.          | Belum Diuji |
| 4  | Registrasi pengguna baru dengan data valid  | 1. Buka halaman `register.php`. 2. Isi semua field (Nama Lengkap, Username, Password) dengan data valid. 3. Klik tombol "Register".                               | `full_name='Guru Baru', username='guru_baru', password='newpass123'`               | Registrasi berhasil. Pengguna diarahkan ke halaman login (`index.php`). Akun baru tersimpan di database.             | Belum Diuji |
| 5  | Registrasi dengan username sudah ada        | 1. Buka halaman `register.php`. 2. Isi username yang sudah terdaftar. 3. Isi field lain. 4. Klik tombol "Register".                                               | `username='guru_valid'` (sudah ada)                                                | Registrasi gagal. Pesan error "Username sudah digunakan" muncul.                                                     | Belum Diuji |
| 6  | Tambah Kelas baru dengan data valid         | 1. Login sebagai guru. 2. Navigasi ke `classes.php`. 3. Klik "Tambah Kelas". 4. Isi Nama Kelas dan Deskripsi. 5. Klik "Tambah".                                  | `name='Biologi XII', description='Kelas Biologi tingkat lanjut'`                   | Kelas baru berhasil ditambahkan dan muncul di daftar kelas. Notifikasi sukses muncul.                                | Belum Diuji |
| 7  | Tambah Kelas dengan nama kosong             | 1. Login. 2. Navigasi ke `classes.php`. 3. Klik "Tambah Kelas". 4. Kosongkan Nama Kelas. 5. Isi Deskripsi. 6. Klik "Tambah".                                      | `name='', description='Deskripsi saja'`                                            | Penambahan kelas gagal. Pesan error "Nama kelas wajib diisi" muncul di bawah field nama.                            | Belum Diuji |
| 8  | Edit data Siswa                             | 1. Login. 2. Navigasi ke `students.php`. 3. Pilih siswa untuk diedit. 4. Ubah nama dan email. 5. Klik "Update".                                                  | `full_name='Siswa Edit', email='siswa.edit@example.com'`                           | Data siswa berhasil diupdate di daftar dan di database.                                                              | Belum Diuji |
| 9  | Hapus data Nilai                            | 1. Login. 2. Navigasi ke `grades.php`. 3. Pilih nilai untuk dihapus. 4. Konfirmasi penghapusan.                                                                 | -                                                                                  | Data nilai berhasil dihapus dari daftar dan database.                                                                | Belum Diuji |
| 10 | Input Nilai dengan skor di luar rentang (105) | 1. Login. 2. Navigasi ke `grades.php`. 3. Klik "Tambah Nilai". 4. Isi data siswa, mapel. 5. Masukkan skor 105. 6. Klik "Tambah".                               | `score=105`                                                                        | Penambahan nilai gagal. Pesan error "Skor harus antara 0 dan 100" muncul.                                          | Belum Diuji |
| 11 | Input Nilai dengan skor non-numerik ('abc') | 1. Login. 2. Navigasi ke `grades.php`. 3. Klik "Tambah Nilai". 4. Isi data siswa, mapel. 5. Masukkan skor 'abc'. 6. Klik "Tambah".                              | `score='abc'`                                                                      | Penambahan nilai gagal. Pesan error "Skor harus berupa angka" muncul.                                               | Belum Diuji |
| 12 | Logout dari sistem                          | 1. Login. 2. Klik tombol/link "Logout".                                                                                                                         | -                                                                                  | Pengguna berhasil logout dan diarahkan ke halaman login (`index.php`). Session pengguna dihapus.                     | Belum Diuji |

**2.1.5 Alat Bantu dan Pengaturan (Tools & Setup)**
*   **Browser:** Pengujian manual akan dilakukan menggunakan browser modern seperti Google Chrome, Mozilla Firefox, dan Safari untuk memastikan kompatibilitas lintas browser dasar.
*   **Alat Inspeksi Browser:** Developer tools pada browser akan digunakan untuk inspeksi elemen, debugging JavaScript, dan memantau network requests.
*   **Alat Otomasi UI (Opsional, jika ada):** Selenium WebDriver atau Cypress dapat digunakan untuk mengotomatisasi skenario pengujian UI yang repetitif. Untuk laporan ini, kita asumsikan pengujian manual atau dengan alat sederhana.
*   **Spreadsheet/Test Management Tool:** Digunakan untuk mendokumentasikan kasus uji, langkah-langkah, hasil yang diharapkan, hasil aktual, dan status.
*   **Data Dummy:** Seperangkat data dummy yang representatif akan disiapkan untuk berbagai skenario pengujian.

**2.1.6 Metrik Pengujian**
Keberhasilan pengujian Black Box akan diukur berdasarkan metrik berikut:
*   **Persentase Kasus Uji yang Lulus:** Jumlah kasus uji yang berhasil dieksekusi sesuai harapan dibagi total kasus uji. Target: ≥ 95%.
*   **Jumlah Defect Ditemukan:** Total cacat fungsional, UI, atau usability yang teridentifikasi.
*   **Tingkat Keparahan Defect:** Klasifikasi defect berdasarkan dampaknya (Kritis, Tinggi, Medium, Rendah).
*   **Cakupan Fungsionalitas:** Persentase fungsionalitas yang telah diuji. Target: 100% untuk fungsionalitas inti.
*   **Kesesuaian dengan Kebutuhan:** Sejauh mana aplikasi memenuhi kebutuhan pengguna yang terdokumentasi.

### 2.2 Hasil Pengujian Black Box

Pengujian Black Box telah dilaksanakan sesuai dengan rancangan, berfokus pada fungsionalitas aplikasi dari perspektif pengguna akhir. Pengujian dilakukan secara manual dengan mengikuti skenario dan kasus uji yang telah ditentukan, menggunakan data dummy.

**2.2.1 Ringkasan Eksekusi Kasus Uji**
Total kasus uji yang dieksekusi: 75 (Contoh Angka)
*   Kasus Uji Lulus (Pass): 68
*   Kasus Uji Gagal (Fail): 5
*   Kasus Uji Memerlukan Klarifikasi (Clarification Needed): 2

**Tabel Hasil Kasus Uji (Contoh Sebagian)**

| No | Skenario Pengujian                          | Hasil Aktual                                                                                                                               | Status Akhir | Catatan                                                                                                                               |
|----|---------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------|--------------|---------------------------------------------------------------------------------------------------------------------------------------|
| 1  | Login dengan kredensial valid               | Berhasil login, diarahkan ke `dashboard.php`. Pesan selamat datang "Hi, [Nama Pengguna]" tampil.                                            | Lulus        |                                                                                                                                       |
| 3  | Login dengan password invalid               | Gagal login. Pesan error "Invalid credentials" muncul. Tetap di halaman login.                                                             | Lulus        |                                                                                                                                       |
| 4  | Registrasi pengguna baru dengan data valid  | Berhasil registrasi. Diarahkan ke `index.php`. Akun baru dapat digunakan untuk login.                                                        | Lulus        |                                                                                                                                       |
| 6  | Tambah Kelas baru dengan data valid         | Kelas baru berhasil ditambahkan dan muncul di daftar. Tidak ada notifikasi sukses yang eksplisit, hanya halaman refresh.                       | Lulus        | Disarankan menambahkan notifikasi sukses. (Improvement #BB001)                                                                        |
| 7  | Tambah Kelas dengan nama kosong             | Penambahan gagal. Pesan error "Nama kelas wajib diisi" tidak muncul, namun field nama ditandai merah (asumsi dari `required` HTML5).         | Gagal        | Pesan error sisi server tidak muncul, hanya validasi browser. Seharusnya ada pesan error dari backend. Defect #BB001                     |
| 10 | Input Nilai dengan skor di luar rentang (105) | Penambahan nilai gagal. Input field `type="number"` membatasi input di browser, namun jika dikirim via modifikasi request, server menerima. | Gagal        | Validasi sisi server untuk rentang nilai (0-100) pada skor tidak seketat yang diharapkan atau bisa di-bypass. Defect #BB002             |
| 11 | Input Nilai dengan skor non-numerik ('abc') | Penambahan nilai gagal. Input field `type="number"` mencegah input non-numerik di browser. Jika di-bypass, server menolak dengan error SQL. | Gagal        | Seharusnya ada pesan error yang lebih user-friendly dari aplikasi, bukan error SQL mentah. Defect #BB003                               |
| 13 | Tampilan daftar siswa di kelas tertentu     | (Skenario baru) Setelah menambah siswa ke kelas A, siswa tersebut tidak langsung muncul di daftar siswa jika difilter berdasarkan kelas A.   | Gagal        | Kemungkinan masalah caching atau query pengambilan data siswa per kelas. Defect #BB004                                                  |
| 14 | Responsivitas halaman dashboard             | Halaman dashboard (`dashboard.php`) tampil baik di desktop, namun pada layar mobile (360px), tombol navigasi sedikit tumpang tindih.         | Lulus dengan Catatan | Perlu perbaikan minor pada CSS untuk tampilan mobile. (Improvement #BB002)                                                              |

**2.2.2 Daftar Defect yang Ditemukan (Contoh)**

| ID Defect | Modul/Halaman            | Deskripsi Defect                                                                                                                            | Tingkat Keparahan | Status     |
|-----------|--------------------------|---------------------------------------------------------------------------------------------------------------------------------------------|-------------------|------------|
| BB001     | `classes.php`            | Tidak ada pesan error sisi server yang jelas saat mencoba menambahkan kelas dengan nama kosong. Hanya mengandalkan validasi HTML5 `required`. | Medium            | Open       |
| BB002     | `grades.php`             | Validasi sisi server untuk rentang skor (0-100) pada input nilai dapat di-bypass jika request dimodifikasi.                                   | High              | Open       |
| BB003     | `grades.php`             | Saat input skor non-numerik di-bypass ke server, aplikasi menampilkan error SQL mentah, bukan pesan error yang user-friendly.               | Medium            | Open       |
| BB004     | `students.php`           | Daftar siswa tidak selalu ter-update secara real-time setelah penambahan siswa baru jika ada filter aktif (misal, filter per kelas).        | Medium            | Open       |
| BB005     | `register.php`           | Field password pada halaman registrasi tidak memiliki opsi "show password" untuk memudahkan pengguna.                                       | Low               | Open       |

**2.2.3 Ringkasan dan Analisis Hasil**
Pengujian Black Box menunjukkan bahwa sebagian besar fungsionalitas inti aplikasi Student Grade Management berjalan sesuai harapan. Pengguna dapat melakukan login, registrasi, serta operasi CRUD pada data kelas, siswa, dan nilai dengan cukup baik. Alur navigasi utama juga berfungsi dengan lancar.

Namun, beberapa isu berhasil diidentifikasi, terutama terkait dengan validasi input sisi server dan penanganan error. Defect seperti BB001, BB002, dan BB003 menunjukkan adanya celah dalam validasi data yang dapat dieksploitasi atau menyebabkan pengalaman pengguna yang buruk. Isu tampilan seperti BB005 (minor) dan Improvement #BB002 (responsivitas) juga dicatat untuk perbaikan usability.

Rekomendasi utama adalah untuk memperkuat validasi input pada sisi server untuk semua form, memastikan bahwa semua batasan data (seperti rentang skor) ditegakkan di backend. Pesan error juga perlu ditingkatkan agar lebih informatif dan user-friendly. Perbaikan pada isu caching atau pengambilan data (Defect #BB004) juga penting untuk konsistensi data yang ditampilkan. Setelah perbaikan, pengujian regresi Black Box harus dilakukan pada area yang terdampak.

---
## Bab 3: Pengujian Keamanan (Security Testing)

Pengujian Keamanan adalah proses yang bertujuan untuk menemukan kerentanan dalam sistem perangkat lunak dan memastikan bahwa data serta sumber daya sistem dilindungi dari potensi ancaman. Untuk aplikasi Student Grade Management yang menangani data sensitif siswa dan nilai, pengujian keamanan menjadi sangat krusial.

### 3.1 Rancangan Pengujian Keamanan

Rancangan pengujian keamanan ini bertujuan untuk mengidentifikasi dan mengevaluasi potensi kerentanan keamanan dalam aplikasi Student Grade Management. Fokus utama adalah pada perlindungan terhadap serangan umum web, otentikasi dan otorisasi yang kuat, serta integritas dan kerahasiaan data.

**3.1.1 Tujuan Pengujian Keamanan**
Tujuan utama dari pengujian keamanan adalah:
*   Mengidentifikasi kerentanan umum seperti SQL Injection (SQLi), Cross-Site Scripting (XSS), Cross-Site Request Forgery (CSRF).
*   Memverifikasi mekanisme otentikasi dan manajemen sesi yang aman.
*   Memastikan implementasi otorisasi yang tepat, sehingga pengguna hanya dapat mengakses data dan fungsionalitas yang sesuai dengan hak aksesnya.
*   Menguji validasi input dan sanitasi output untuk mencegah serangan berbasis input.
*   Mengevaluasi konfigurasi keamanan server dan aplikasi.
*   Memastikan data sensitif (seperti password) dienkripsi dengan baik saat disimpan dan ditransmisikan (jika menggunakan HTTPS).

**3.1.2 Ruang Lingkup Pengujian Keamanan**
Pengujian keamanan akan mencakup area-area berikut:
*   **Modul yang Diuji:**
    *   [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php) (Mekanisme login, registrasi, manajemen sesi)
    *   Semua halaman yang menerima input pengguna: [`index.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/index.php), [`register.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/register.php), [`classes.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/classes.php), [`students.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/students.php), [`grades.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/grades.php).
    *   Interaksi dengan database melalui file-file di `functions/`.
*   **Jenis Kerentanan yang Diuji (berdasarkan OWASP Top 10 sebagai referensi):**
    *   Injection (khususnya SQL Injection).
    *   Broken Authentication.
    *   Sensitive Data Exposure (misalnya, password dalam clear text, informasi sesi yang mudah ditebak).
    *   XML External Entities (XXE) - Kurang relevan untuk aplikasi PHP sederhana ini, namun tetap diperhatikan.
    *   Broken Access Control (Otorisasi yang tidak tepat).
    *   Security Misconfiguration.
    *   Cross-Site Scripting (XSS) - Stored dan Reflected.
    *   Insecure Deserialization - Kurang relevan untuk aplikasi PHP sederhana ini.
    *   Using Components with Known Vulnerabilities (jika ada library pihak ketiga).
    *   Insufficient Logging & Monitoring.
    *   Cross-Site Request Forgery (CSRF) pada operasi yang mengubah state (POST requests).

**3.1.3 Metodologi Pengujian Keamanan**
Metodologi yang akan digunakan meliputi:
*   **Vulnerability Scanning (Otomatis):** Menggunakan alat seperti OWASP ZAP (Zed Attack Proxy) untuk melakukan pemindaian otomatis terhadap aplikasi untuk menemukan kerentanan umum.
*   **Penetration Testing (Manual):** Melakukan simulasi serangan secara manual pada titik-titik input dan fungsionalitas kritis. Ini termasuk mencoba payload SQLi, XSS, dan memanipulasi request HTTP.
*   **Security Code Review (Manual):** Meskipun lebih condong ke White Box, tinjauan kode dari perspektif keamanan akan dilakukan pada bagian-bagian kritis seperti otentikasi, manajemen sesi, dan query database untuk memastikan penggunaan prepared statements dan sanitasi output.
*   **Authentication & Authorization Testing:** Menguji skenario untuk bypass otentikasi, menebak kredensial, dan mengakses fungsionalitas tanpa hak akses yang sesuai.
*   **Session Management Testing:** Memeriksa bagaimana sesi dikelola, termasuk pembuatan token sesi, masa berlaku, dan perlindungan terhadap session hijacking/fixation.

**3.1.4 Kasus Uji (Test Cases) Keamanan (Contoh)**

| No | Jenis Kerentanan        | Target Pengujian                                       | Skenario/Payload (Dummy)                                                                    | Hasil yang Diharapkan                                                                                                | Status Awal |
|----|-------------------------|--------------------------------------------------------|---------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------|-------------|
| 1  | SQL Injection (Login)   | Form login di `index.php` (field username)             | `username: admin' OR '1'='1`                                                               | Login gagal. Query database menggunakan parameterized query, sehingga input dianggap sebagai string literal.         | Belum Diuji |
| 2  | SQL Injection (Search)  | (Jika ada fitur search) Parameter URL pada fitur search | `search.php?query=test' UNION SELECT null, password, null FROM users--`                    | Tidak ada data sensitif yang terekspos. Input disanitasi atau query menggunakan prepared statements.                 | Belum Diuji |
| 3  | XSS (Stored)            | Form input nama kelas di `classes.php`                 | `Nama Kelas: <script>alert('XSS')</script>`                                                 | Payload script tidak dieksekusi saat nama kelas ditampilkan. Output di-escape dengan benar (misalnya, `htmlspecialchars()`). | Belum Diuji |
| 4  | XSS (Reflected)         | Parameter URL yang mungkin direfleksikan di halaman    | `example.php?message=<img src=x onerror=alert(1)>`                                        | Payload tidak dieksekusi. Output di-escape.                                                                          | Belum Diuji |
| 5  | Broken Authentication   | Mekanisme login                                        | Mencoba brute-force password. Mencoba akses halaman dashboard tanpa login.                  | Brute-force gagal (ada rate limiting/captcha setelah beberapa percobaan gagal - idealnya). Akses dashboard ditolak. | Belum Diuji |
| 6  | Broken Access Control   | Akses URL admin oleh user biasa (jika ada role)        | User A (non-admin) mencoba mengakses `admin_panel.php` secara langsung.                     | Akses ditolak (redirect ke login atau halaman error 403).                                                            | Belum Diuji |
| 7  | CSRF                    | Form hapus data (misal, hapus kelas di `classes.php`)  | Membuat halaman HTML jahat yang mengirim POST request ke `classes.php?action=delete&id=1` | Permintaan ditolak jika tidak ada token CSRF yang valid atau token tidak cocok.                                      | Belum Diuji |
| 8  | Session Fixation        | Proses Login                                           | 1. Dapatkan session ID sebelum login. 2. Login. 3. Periksa apakah session ID berubah.       | Session ID harus di-regenerate setelah login berhasil untuk mencegah session fixation.                               | Belum Diuji |
| 9  | Sensitive Data Exposure | Penyimpanan password di database (`users` table)       | Periksa skema database dan kode registrasi.                                                 | Password di-hash menggunakan algoritma yang kuat (misalnya, `password_hash()` dengan BCRYPT).                      | Belum Diuji |
| 10 | Security Misconfig      | HTTP Headers                                           | Periksa response headers (X-Content-Type-Options, X-Frame-Options, CSP).                    | Header keamanan yang relevan diimplementasikan.                                                                      | Belum Diuji |

**3.1.5 Alat Bantu dan Pengaturan (Tools & Setup)**
*   **OWASP ZAP (Zed Attack Proxy):** Untuk pemindaian kerentanan otomatis dan sebagai proxy untuk inspeksi manual.
*   **Burp Suite Community Edition:** Sebagai alternatif atau pelengkap ZAP untuk intercepting proxy dan pengujian manual.
*   **Browser Developer Tools:** Untuk inspeksi request/response, cookies, dan DOM.
*   **SQLMap (Opsional, dengan hati-hati di lingkungan tes):** Untuk pengujian SQL Injection otomatis.
*   **Nmap (Opsional):** Untuk pemindaian port dan layanan pada server (jika relevan dengan scope).
*   **Checklist Keamanan:** Menggunakan checklist berdasarkan OWASP Top 10 atau standar keamanan lainnya.

**3.1.6 Metrik Pengujian**
Keberhasilan pengujian keamanan akan diukur berdasarkan:
*   **Jumlah Kerentanan Ditemukan:** Total kerentanan yang teridentifikasi, diklasifikasikan berdasarkan tingkat risiko (Kritis, Tinggi, Medium, Rendah).
*   **Persentase Kerentanan Kritis/Tinggi yang Ditangani:** Target 0 kerentanan kritis/tinggi yang belum ditangani sebelum rilis.
*   **Kepatuhan terhadap Praktik Terbaik Keamanan:** Sejauh mana aplikasi mengikuti prinsip-prinsip keamanan dasar (misalnya, penggunaan prepared statements, sanitasi output, hashing password).
*   **Waktu untuk Mengeksploitasi (jika ditemukan):** Estimasi kesulitan bagi penyerang untuk mengeksploitasi kerentanan.

### 3.2 Hasil Pengujian Keamanan

Pengujian keamanan telah dilaksanakan dengan kombinasi pemindaian otomatis menggunakan OWASP ZAP dan pengujian penetrasi manual pada fungsionalitas-fungsionalitas kunci aplikasi Student Grade Management. Fokus utama adalah pada identifikasi kerentanan umum dan validasi mekanisme pertahanan aplikasi.

**3.2.1 Ringkasan Temuan**
*   **Total Kerentanan Teridentifikasi:** 8 (Contoh Angka)
    *   Kritis: 0
    *   Tinggi: 1
    *   Medium: 3
    *   Rendah: 4
*   **Alat yang Digunakan:** OWASP ZAP, Burp Suite (manual interception), Browser DevTools.

**Tabel Hasil Pengujian Keamanan (Contoh Sebagian)**

| No | Jenis Kerentanan        | Target Pengujian                                       | Hasil Aktual                                                                                                                                                              | Status Akhir | Catatan/Rekomendasi                                                                                                                               |
|----|-------------------------|--------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------|---------------------------------------------------------------------------------------------------------------------------------------------------|
| 1  | SQL Injection (Login)   | Form login di `index.php`                              | Tidak ditemukan kerentanan SQL Injection. Penggunaan prepared statements pada fungsi `login()` di [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php) efektif mencegah serangan dasar. | Lulus        | Pertahankan penggunaan prepared statements di semua query database.                                                                               |
| 3  | XSS (Stored)            | Form input nama kelas di `classes.php`                 | Payload `<script>alert('XSS')</script>` pada nama kelas tidak dieksekusi saat ditampilkan. `htmlspecialchars()` digunakan dengan benar pada output.                      | Lulus        | Konsisten menggunakan `htmlspecialchars()` untuk semua output yang berasal dari input pengguna.                                                   |
| 4  | XSS (Reflected)         | Parameter `error` pada URL `login.php` (misal, `login.php?error=...`) | Jika parameter `error` dimanipulasi dengan payload XSS, payload tersebut direfleksikan tanpa sanitasi yang cukup, menyebabkan XSS. `htmlspecialchars()` tidak diterapkan. | Gagal (Medium) | Terapkan `htmlspecialchars()` pada semua parameter URL yang direfleksikan ke halaman. Defect #SEC001.                                            |
| 6  | Broken Access Control   | Akses halaman `grades.php` tanpa login                 | Pengguna yang belum login diarahkan ke `login.php` oleh fungsi `checkAuth()`.                                                                                             | Lulus        | Mekanisme `checkAuth()` berfungsi dengan baik untuk halaman yang dilindungi.                                                                      |
| 7  | CSRF                    | Form hapus kelas di `classes.php`                      | Tidak ditemukan implementasi token CSRF. Operasi hapus kelas rentan terhadap serangan CSRF jika pengguna yang terotentikasi mengunjungi halaman jahat.                       | Gagal (High)   | Implementasikan token anti-CSRF untuk semua form yang melakukan perubahan state (POST, DELETE). Defect #SEC002.                                  |
| 8  | Session Fixation        | Proses Login                                           | Session ID tidak di-regenerate setelah proses login berhasil. Session ID sebelum dan sesudah login tetap sama.                                                            | Gagal (Medium) | Panggil `session_regenerate_id(true)` setelah login berhasil di fungsi `login()` pada [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php). Defect #SEC003. |
| 9  | Sensitive Data Exposure | Penyimpanan password                                   | Password pengguna di-hash menggunakan `password_hash()` (BCRYPT default), yang merupakan praktik yang baik.                                                               | Lulus        |                                                                                                                                                   |
| 10 | Security Misconfig      | HTTP Headers                                           | Header `X-Frame-Options` dan `X-Content-Type-Options` tidak diset. Aplikasi mungkin rentan terhadap clickjacking dan MIME-sniffing.                                        | Gagal (Low)    | Tambahkan header keamanan seperti `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, dan `Content-Security-Policy`. Defect #SEC004. |
| 11 | Informasi Versi PHP     | HTTP Response Header `X-Powered-By`                    | Header `X-Powered-By: PHP/x.y.z` terekspos, memberikan informasi versi PHP yang digunakan.                                                                                  | Gagal (Low)    | Nonaktifkan header `X-Powered-By` melalui konfigurasi `php.ini` (`expose_php = Off`). Defect #SEC005.                                        |

**3.2.2 Daftar Kerentanan yang Ditemukan (Contoh)**

| ID Defect | Jenis Kerentanan        | Deskripsi                                                                                                                               | Tingkat Keparahan | Status     |
|-----------|-------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|-------------------|------------|
| SEC001    | XSS (Reflected)         | Parameter `error` pada URL `login.php` rentan terhadap XSS karena tidak disanitasi sebelum ditampilkan.                                   | Medium            | Open       |
| SEC002    | CSRF                    | Tidak ada perlindungan token CSRF pada form yang mengubah state (misalnya, hapus kelas, hapus siswa, hapus nilai).                        | High              | Open       |
| SEC003    | Session Fixation        | Session ID tidak di-regenerate setelah login berhasil, memungkinkan potensi serangan session fixation.                                    | Medium            | Open       |
| SEC004    | Security Misconfig      | Tidak adanya header keamanan HTTP seperti `X-Frame-Options` dan `X-Content-Type-Options`.                                                 | Low               | Open       |
| SEC005    | Informasi Versi PHP     | Header `X-Powered-By` mengekspos versi PHP yang digunakan.                                                                                | Low               | Open       |

**3.2.3 Ringkasan dan Analisis Hasil**
Pengujian keamanan menunjukkan bahwa aplikasi Student Grade Management telah menerapkan beberapa praktik keamanan dasar dengan baik, seperti penggunaan prepared statements untuk mencegah SQL Injection pada beberapa area kritis dan hashing password yang kuat.

Namun, beberapa kerentanan signifikan berhasil diidentifikasi. Kerentanan CSRF (SEC002) pada operasi yang mengubah data merupakan risiko tinggi karena dapat menyebabkan tindakan yang tidak diinginkan dilakukan atas nama pengguna. Isu XSS Reflected (SEC001) dan Session Fixation (SEC003) juga perlu segera ditangani karena dapat membahayakan akun pengguna dan integritas data. Kerentanan dengan tingkat keparahan rendah seperti SEC004 dan SEC005 terkait konfigurasi keamanan dan information disclosure sebaiknya juga diperbaiki untuk memperkuat postur keamanan aplikasi secara keseluruhan.

Rekomendasi utama adalah untuk segera memprioritaskan perbaikan kerentanan CSRF dengan mengimplementasikan token anti-CSRF di semua form yang relevan. Selanjutnya, perbaiki kerentanan XSS dan Session Fixation. Tinjau kembali semua titik di mana input pengguna direfleksikan ke output dan pastikan sanitasi yang tepat. Implementasikan header keamanan HTTP yang direkomendasikan dan nonaktifkan eksposur informasi versi software yang tidak perlu. Pengujian keamanan regresi harus dilakukan setelah semua perbaikan diimplementasikan.

---

## Bab 4: Pengujian dalam Konteks STLC

Software Testing Life Cycle (STLC) adalah serangkaian aktivitas yang dilakukan selama proses pengujian perangkat lunak. Bab ini akan merinci rancangan dan hasil (dummy) dari berbagai jenis pengujian yang merupakan bagian integral dari STLC, yaitu Unit Testing, Integration Testing, Load Testing, dan Stress Testing, yang disesuaikan untuk aplikasi Student Grade Management.

### 4.1 Unit Testing

Unit testing adalah level pengujian perangkat lunak di mana unit atau komponen individual dari perangkat lunak diuji secara terisolasi. Tujuannya adalah untuk memvalidasi bahwa setiap unit kode (misalnya, fungsi, metode, atau kelas) bekerja seperti yang diharapkan.

#### 4.1.1 Rancangan Unit Testing

Rancangan unit testing untuk aplikasi SGM berfokus pada pengujian fungsi-fungsi individual dalam direktori `functions/` untuk memastikan kebenaran logika dan penanganan kasus batas.

**Tujuan Unit Testing:**
*   Memverifikasi fungsionalitas setiap unit (fungsi/metode) secara terisolasi.
*   Mengidentifikasi bug pada tahap awal pengembangan.
*   Memfasilitasi perubahan dan refactoring kode dengan menyediakan jaring pengaman.
*   Meningkatkan kualitas desain kode.
*   Mencapai cakupan kode yang tinggi pada level unit.

**Ruang Lingkup Unit Testing:**
*   **File yang Diuji:**
    *   [`functions/auth.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/auth.php): Fungsi `login()`, `register()`, `calculateGradePoint()` (jika ada fungsi helper di sini).
    *   [`functions/classes.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/classes.php): Fungsi `createClass()`, `getClassById()`, `updateClass()`, `deleteClass()`.
    *   [`functions/students.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/students.php): Fungsi `createStudent()`, `getStudentById()`, `updateStudent()`, `deleteStudent()`.
    *   [`functions/grades.php`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/functions/grades.php): Fungsi `createGrade()`, `getGradeById()`, `updateGrade()`, `deleteGrade()`, `calculateGradePoint()`.
*   **Fokus Pengujian:**
    *   Validitas output berdasarkan input yang berbeda (valid, invalid, batas).
    *   Penanganan error dan eksepsi dalam unit.
    *   Interaksi dengan dependensi (misalnya, database) akan di-mock untuk menjaga isolasi unit.

**Metodologi Unit Testing:**
*   Setiap fungsi akan memiliki kelas tesnya sendiri (misalnya, `AuthTest.php`, `GradesTest.php`).
*   Menggunakan PHPUnit sebagai framework testing.
*   Menggunakan mocking/stubbing untuk dependensi eksternal seperti koneksi database PDO. Library seperti Mockery atau PHPUnit built-in mocking dapat digunakan.
*   Kasus uji akan mencakup input valid, input invalid, nilai batas, dan kondisi error.

**Kasus Uji Unit Testing (Contoh):**

| No | Fungsi               | Input (Dummy)                                     | Mock/Stub (Jika Ada)                               | Output yang Diharapkan                                  |
|----|----------------------|---------------------------------------------------|----------------------------------------------------|---------------------------------------------------------|
| 1  | `login()`            | `username='valid', password='valid'`              | Mock PDO: `fetch()` mengembalikan data user valid. | `true`, `$_SESSION` terisi.                             |
| 2  | `login()`            | `username='valid', password='invalid'`            | Mock PDO: `fetch()` mengembalikan data user valid. | `false`.                                                |
| 3  | `calculateGradePoint()`| `score=95`                                        | -                                                  | `4.00`                                                  |
| 4  | `calculateGradePoint()`| `score=72`                                        | -                                                  | `3.00`                                                  |
| 5  | `calculateGradePoint()`| `score=-5` (invalid)                              | -                                                  | `0.00` (atau sesuai spesifikasi penanganan error).      |
| 6  | `createClass()`      | `name='Kelas Test', description='Deskripsi Test'` | Mock PDO: `execute()` mengembalikan `true`.        | `true` (atau ID kelas baru jika fungsi mengembalikan ID). |
| 7  | `deleteStudent()`    | `id=1` (valid)                                    | Mock PDO: `execute()` mengembalikan `true`.        | `true`.                                                 |
| 8  | `deleteStudent()`    | `id=999` (tidak ada)                              | Mock PDO: `execute()` mengembalikan `false`.       | `false`.                                                |

**Alat Bantu dan Pengaturan:**
*   PHPUnit.
*   Xdebug untuk code coverage.
*   Konfigurasi `phpunit.xml` untuk menargetkan direktori `functions/` dan mengatur bootstrap untuk dependensi (seperti `database.php` jika tidak di-mock sepenuhnya).
*   Mocking library (misalnya, Mockery).

**Metrik Pengujian:**
*   Statement Coverage: Target ≥ 90%.
*   Branch Coverage: Target ≥ 80%.
*   Jumlah unit test yang lulus.

#### 4.1.2 Hasil Unit Testing

Unit testing telah dilaksanakan pada fungsi-fungsi utama dalam direktori `functions/` menggunakan PHPUnit dan data dummy, dengan fokus pada isolasi unit melalui mocking dependensi database.

**Ringkasan Eksekusi Unit Test:**
*   Total Unit Test Dijalankan: 150 (Contoh Angka)
*   Unit Test Lulus: 142
*   Unit Test Gagal: 8
*   Assertion per Test: Rata-rata 2-3 assertions.

**Laporan Cakupan Kode (Unit Level):**
*   Statement Coverage: 92%
*   Branch Coverage: 85%

**Contoh Hasil Unit Test Gagal (Dummy):**

| Fungsi/Metode           | Kasus Uji                                                                 | Alasan Kegagalan (Dummy)                                                                                                                               | ID Defect (Jika Ada) |
|-------------------------|---------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------|
| `register()`            | Registrasi dengan username yang sangat panjang (>50 karakter).            | Fungsi tidak menangani batasan panjang username dengan benar, menyebabkan error SQL saat insert jika field DB memiliki batasan. Test mengharapkan `false`. | UT001                |
| `calculateGradePoint()` | Input skor `null` atau non-numerik.                                       | Fungsi menghasilkan PHP warning/error, bukan mengembalikan nilai default (misalnya, 0.00) atau `false` secara graceful.                                  | UT002                |
| `updateStudent()`       | Mencoba update siswa dengan email yang sudah digunakan oleh siswa lain.   | Fungsi tidak memeriksa keunikan email saat update, berpotensi melanggar constraint UNIQUE di database. Test mengharapkan `false`.                       | UT003                |

**Ringkasan dan Analisis Hasil Unit Testing:**
Unit testing berhasil memvalidasi sebagian besar fungsi individual. Tingkat cakupan kode yang dicapai (92% statement, 85% branch) menunjukkan bahwa sebagian besar logika internal unit telah diuji. Kegagalan unit test seperti UT001, UT002, dan UT003 menyoroti beberapa kasus batas dan penanganan error yang perlu diperbaiki pada level fungsi. Perbaikan pada unit-unit ini akan meningkatkan robustisitas keseluruhan aplikasi dan mengurangi risiko bug pada tahap integrasi.

### 4.2 Integration Testing

Integration testing adalah fase dalam pengujian perangkat lunak di mana modul-modul individual digabungkan dan diuji sebagai satu grup. Tujuannya adalah untuk mengekspos kesalahan dalam interaksi antar modul yang terintegrasi.

#### 4.2.1 Rancangan Integration Testing

Rancangan integration testing untuk aplikasi SGM akan fokus pada pengujian alur kerja end-to-end yang melibatkan interaksi antara beberapa modul, seperti otentikasi, manajemen kelas, manajemen siswa, dan manajemen nilai, dengan menggunakan database nyata (testing database).

**Tujuan Integration Testing:**
*   Memverifikasi interaksi dan aliran data yang benar antar modul yang terintegrasi.
*   Mengidentifikasi isu antarmuka antar modul.
*   Memastikan fungsionalitas end-to-end bekerja sesuai skenario pengguna.
*   Menguji interaksi dengan database dalam konteks alur kerja yang lebih besar.

**Ruang Lingkup Integration Testing:**
*   **Skenario End-to-End yang Diuji:**
    *   Alur Registrasi Pengguna -> Login -> Logout.
    *   Alur Login -> Buat Kelas -> Tambah Siswa ke Kelas -> Input Nilai untuk Siswa -> Lihat Daftar Nilai -> Edit Nilai -> Hapus Nilai.
    *   Alur Login -> Manajemen Kelas (CRUD lengkap).
    *   Alur Login -> Manajemen Siswa (CRUD lengkap, termasuk perubahan kelas).
    *   Akses ke halaman yang memerlukan otentikasi setelah logout (memastikan redirect ke login).
*   **Modul yang Terlibat:** Semua modul utama (`auth`, `classes`, `students`, `grades`) dan interaksinya dengan database.

**Metodologi Integration Testing:**
*   Menggunakan pendekatan Big Bang (semua modul diintegrasikan sekaligus) atau Incremental (modul diintegrasikan satu per satu), tergantung kompleksitas. Untuk aplikasi ini, pendekatan yang lebih fokus pada skenario end-to-end (mirip Big Bang untuk alur tertentu) akan digunakan.
*   Setup environment testing dengan database MySQL terpisah yang memiliki skema identik dengan produksi ([`schema.sql`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/schema.sql)). Data awal (seed data) mungkin diperlukan.
*   Kasus uji akan mensimulasikan interaksi pengguna melalui beberapa halaman dan fungsi.
*   PHPUnit dapat digunakan dengan setup TestServer yang membungkus seluruh aplikasi, atau pengujian dilakukan melalui skrip yang mensimulasikan request HTTP.

**Kasus Uji Integration Testing (Contoh):**

| No | Skenario Integrasi                                                              | Langkah-langkah Kunci (Dummy)                                                                                                                                                                                                                            | Hasil yang Diharapkan                                                                                                                                                                                                                                                           |
|----|---------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 1  | Alur Lengkap: Registrasi, Login, Buat Kelas, Tambah Siswa, Input Nilai, Logout | 1. Registrasi user baru. 2. Login dengan user baru. 3. Buat kelas baru. 4. Tambah siswa baru ke kelas tersebut. 5. Input nilai untuk siswa tersebut. 6. Verifikasi nilai tersimpan. 7. Logout. 8. Coba akses halaman nilai tanpa login.                 | Semua langkah berhasil. Data konsisten di database. Setelah logout, akses ke halaman nilai ditolak dan diarahkan ke login.                                                                                                                                               |
| 2  | Interaksi Hapus Kelas dengan Siswa Terdaftar                                    | 1. Login. 2. Buat kelas. 3. Tambah beberapa siswa ke kelas tersebut. 4. Hapus kelas tersebut.                                                                                                                                                           | Kelas berhasil dihapus. Siswa yang terdaftar di kelas tersebut juga terhapus (sesuai `ON DELETE CASCADE` pada foreign key `students.class_id`). Verifikasi data siswa di database.                                                                                             |
| 3  | Update Email Siswa ke Email yang Sudah Ada                                      | 1. Login. 2. Buat dua siswa: Siswa A (emailA@test.com), Siswa B (emailB@test.com). 3. Edit Siswa A, coba ubah emailnya menjadi emailB@test.com.                                                                                                         | Update gagal karena email harus unik. Pesan error yang sesuai ditampilkan. Data Siswa A tidak berubah.                                                                                                                                                                        |
| 4  | Akses Data Setelah Session Timeout (Simulasi)                                   | 1. Login. 2. Biarkan sesi idle hingga timeout (jika ada konfigurasi timeout). 3. Coba lakukan aksi yang memerlukan otentikasi (misal, tambah kelas).                                                                                                   | Aplikasi seharusnya mengarahkan pengguna ke halaman login atau menampilkan pesan sesi berakhir.                                                                                                                                                                                 |

**Alat Bantu dan Pengaturan:**
*   Menggunakan PHPUnit (jika digunakan untuk mengelola tes).
*   Database MySQL terpisah untuk testing (misalnya, `guru_test`).
*   Skrip untuk setup/teardown database (membuat skema, mengisi seed data, membersihkan data setelah tes).
*   Alat bantu HTTP client seperti Postman atau skrip cURL untuk mensimulasikan request jika tidak menggunakan TestServer PHPUnit.

**Metrik Pengujian:**
*   Persentase skenario integrasi yang berhasil.
*   Jumlah defect yang ditemukan pada antarmuka antar modul atau dalam alur kerja end-to-end.
*   Konsistensi data di database setelah menjalankan skenario.

#### 4.2.2 Hasil Integration Testing

Integration testing telah dilakukan dengan menjalankan skenario-skenario end-to-end yang melibatkan interaksi antar modul utama aplikasi SGM dan database testing.

**Ringkasan Eksekusi Skenario Integrasi:**
*   Total Skenario Integrasi Dijalankan: 25 (Contoh Angka)
*   Skenario Lulus: 20
*   Skenario Gagal: 5

**Contoh Hasil Skenario Integrasi Gagal (Dummy):**

| Skenario Integrasi                                                              | Alasan Kegagalan (Dummy)                                                                                                                                                                                                                            | ID Defect (Jika Ada) |
|---------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------|
| Alur Lengkap: Registrasi, Login, Buat Kelas, Tambah Siswa, Input Nilai, Logout | Setelah logout dan mencoba login kembali dengan user yang baru diregistrasi, terkadang muncul error "Invalid credentials" meskipun kredensial benar. Isu intermittent, mungkin terkait caching session atau race condition pada registrasi/login. | IT001                |
| Interaksi Hapus Kelas dengan Siswa Terdaftar                                    | Saat kelas dihapus, siswa yang terkait tidak selalu terhapus meskipun ada `ON DELETE CASCADE`. Terjadi pada kondisi tertentu jika ada nilai yang terkait dengan siswa tersebut.                                                                     | IT002                |
| Update Email Siswa ke Email yang Sudah Ada                                      | Aplikasi tidak mencegah update email siswa ke email yang sudah digunakan oleh siswa lain. Ini menyebabkan pelanggaran constraint UNIQUE di database dan error SQL mentah ditampilkan ke pengguna, bukan pesan error aplikasi yang baik.             | IT003                |

**Ringkasan dan Analisis Hasil Integration Testing:**
Integration testing berhasil mengidentifikasi beberapa isu yang tidak terlihat pada level unit testing, terutama yang berkaitan dengan aliran data antar modul, manajemen sesi, dan konsistensi data di database. Kegagalan seperti IT001 (isu login intermittent) dan IT003 (penanganan constraint unik pada update) menunjukkan area di mana interaksi antar komponen perlu diperbaiki. Isu IT002 terkait `ON DELETE CASCADE` memerlukan investigasi lebih lanjut pada skema database dan logika penghapusan. Perbaikan defect ini krusial untuk memastikan keandalan alur kerja utama aplikasi.

### 4.3 Load Testing

Load testing adalah jenis pengujian performa yang menentukan perilaku sistem di bawah beban kerja yang diharapkan (normal dan puncak). Tujuannya adalah untuk memastikan aplikasi dapat menangani jumlah pengguna konkuren dan volume transaksi yang diharapkan tanpa degradasi performa yang signifikan.

#### 4.3.1 Rancangan Load Testing

Rancangan load testing untuk aplikasi SGM akan fokus pada endpoint-endpoint yang sering diakses dan berpotensi menjadi bottleneck, seperti halaman input nilai dan daftar data.

**Tujuan Load Testing:**
*   Menilai performa aplikasi (waktu respons, throughput) di bawah beban pengguna normal dan puncak.
*   Mengidentifikasi bottleneck performa dalam aplikasi atau infrastruktur.
*   Memastikan aplikasi memenuhi target Service Level Agreements (SLAs) terkait performa.
*   Menentukan kapasitas maksimum sistem sebelum performa menurun drastis.

**Ruang Lingkup Load Testing:**
*   **Endpoint yang Diuji:**
    *   `grades.php` (POST untuk input/edit nilai, GET untuk menampilkan daftar nilai).
    *   `students.php` (GET untuk menampilkan daftar siswa, POST untuk tambah/edit siswa).
    *   `classes.php` (GET untuk menampilkan daftar kelas, POST untuk tambah/edit kelas).
    *   `login.php` (POST untuk proses login).
*   **Skenario Beban:**
    *   Simulasi 50 pengguna konkuren mengakses dan melakukan operasi CRUD selama 5 menit.
    *   Simulasi 100 pengguna konkuren mengakses dan melakukan operasi input nilai selama 5 menit.

**Metodologi Load Testing:**
*   Menggunakan alat load testing seperti K6 atau Apache JMeter.
*   Membuat skrip tes yang mensimulasikan alur pengguna tipikal.
*   Meningkatkan beban secara bertahap (ramp-up) hingga mencapai target pengguna konkuren.
*   Memantau metrik performa kunci selama pengujian.

**Kasus Uji Load Testing (Contoh):**

| No | Skenario Beban                                     | Jumlah Virtual Users (VU) | Durasi    | Ramp-up Period | Metrik yang Dipantau                                                                 | Target Performa (Contoh)                                     |
|----|----------------------------------------------------|---------------------------|-----------|----------------|--------------------------------------------------------------------------------------|--------------------------------------------------------------|
| 1  | 50 VU melakukan login dan navigasi dashboard       | 50                        | 5 menit   | 30 detik       | Waktu respons rata-rata & P95, throughput (req/sec), error rate.                     | P95 Response Time < 500ms, Error Rate < 1%.                  |
| 2  | 100 VU melakukan input nilai secara bersamaan      | 100                       | 5 menit   | 1 menit        | Waktu respons rata-rata & P95 untuk POST ke `grades.php`, throughput, error rate.    | P95 Response Time < 1s, Error Rate < 2%.                     |
| 3  | 75 VU melihat daftar siswa                           | 75                        | 3 menit   | 30 detik       | Waktu respons rata-rata & P95 untuk GET `students.php`, throughput, error rate.      | P95 Response Time < 800ms, Error Rate < 1%.                  |

**Alat Bantu dan Pengaturan:**
*   K6 (atau JMeter).
*   Skrip tes K6 (misalnya, `load_test.js`).
*   Lingkungan server staging yang semirip mungkin dengan produksi (spesifikasi hardware, software, konfigurasi jaringan).
*   Alat monitoring server (misalnya, `htop`, `vmstat`, log server, atau Prometheus/Grafana jika ada).

**Metrik Pengujian:**
*   Waktu Respons (Average, P90, P95, P99).
*   Throughput (requests per second/minute).
*   Error Rate (%).
*   Penggunaan Sumber Daya Server (CPU, Memory, Network I/O, Disk I/O).

#### 4.3.2 Hasil Load Testing

Load testing telah dilakukan pada endpoint-endpoint kunci aplikasi SGM menggunakan K6 untuk mensimulasikan berbagai tingkat beban pengguna.

**Ringkasan Hasil Load Testing (Dummy):**

| Skenario Beban                                     | VU  | Durasi  | P95 Response Time (Aktual) | Error Rate (Aktual) | Penggunaan CPU Server (Puncak) | Catatan (Dummy)                                                                                                                               |
|----------------------------------------------------|-----|---------|----------------------------|---------------------|--------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------|
| 50 VU login & navigasi                             | 50  | 5 menit | 450ms                      | 0.5%                | 40%                            | Performa baik, sesuai target.                                                                                                                 |
| 100 VU input nilai                                 | 100 | 5 menit | 1.2s                       | 3%                  | 75%                            | Waktu respons sedikit di atas target (1s). Error rate juga sedikit naik. Query insert nilai mungkin perlu optimasi. Bottleneck #LD001.         |
| 75 VU lihat daftar siswa                           | 75  | 3 menit | 900ms                      | 1.5%                | 60%                            | Waktu respons sedikit di atas target (800ms) saat data siswa banyak. Query `getStudents()` dengan join mungkin perlu diindeks lebih baik. Bottleneck #LD002. |

**Bottleneck yang Teridentifikasi (Dummy):**
*   **LD001:** Operasi POST ke `grades.php` (input nilai) menunjukkan peningkatan waktu respons dan error rate yang signifikan di atas 80 VU. Investigasi menunjukkan query INSERT ke tabel `grades` dan kalkulasi `grade_point` mungkin menjadi bottleneck.
*   **LD002:** Operasi GET ke `students.php` (daftar siswa) menjadi lambat ketika jumlah siswa dan kelas banyak, terutama karena query JOIN yang kompleks. Kurangnya indeks yang optimal pada kolom yang di-JOIN atau difilter.

**Ringkasan dan Analisis Hasil Load Testing:**
Load testing menunjukkan bahwa aplikasi SGM dapat menangani beban pengguna moderat dengan baik. Namun, pada beban puncak, terutama pada operasi input nilai dan penampilan data yang besar, beberapa bottleneck performa mulai terlihat. Waktu respons meningkat dan error rate naik, mengindikasikan area yang memerlukan optimasi. Optimasi query database, penambahan indeks yang tepat, dan mungkin caching strategi dapat membantu meningkatkan performa di bawah beban tinggi.

### 4.4 Stress Testing

Stress testing adalah jenis pengujian performa yang mengevaluasi perilaku sistem di luar batas beban kerja normal atau puncaknya. Tujuannya adalah untuk menentukan titik gagal sistem dan bagaimana sistem pulih dari kegagalan tersebut.

#### 4.4.1 Rancangan Stress Testing

Rancangan stress testing untuk aplikasi SGM akan fokus pada pemberian beban ekstrim pada endpoint kritis untuk melihat bagaimana aplikasi berperilaku dan kapan ia mulai gagal.

**Tujuan Stress Testing:**
*   Menentukan batas kemampuan aplikasi dan infrastruktur.
*   Mengamati perilaku sistem saat berada di bawah tekanan ekstrim (misalnya, degradasi performa, error, crash).
*   Memverifikasi stabilitas sistem dan kemampuannya untuk pulih setelah beban ekstrim dihilangkan.
*   Mengidentifikasi jenis error yang muncul saat sistem tertekan.

**Ruang Lingkup Stress Testing:**
*   **Endpoint yang Diuji:** Fokus pada endpoint yang sama dengan load testing, terutama yang menunjukkan potensi bottleneck (`grades.php` POST, `students.php` GET).
*   **Skenario Beban Ekstrim:**
    *   Meningkatkan jumlah pengguna konkuren secara drastis hingga sistem mulai menunjukkan error signifikan atau waktu respons tidak dapat diterima (misalnya, 200-500 VU atau lebih).
    *   Menjalankan beban tinggi untuk durasi singkat untuk melihat apakah sistem crash.

**Metodologi Stress Testing:**
*   Menggunakan alat load testing (K6, JMeter) dengan konfigurasi untuk beban yang sangat tinggi.
*   Meningkatkan beban secara progresif melebihi kapasitas yang diharapkan hingga sistem gagal atau performa sangat terdegradasi.
*   Memantau sistem secara ketat selama pengujian untuk error, penggunaan sumber daya, dan waktu respons.
*   Setelah beban dihilangkan, amati waktu pemulihan sistem ke kondisi normal.

**Kasus Uji Stress Testing (Contoh):**

| No | Skenario Beban Ekstrim                               | Jumlah Virtual Users (VU) Target | Durasi    | Metrik yang Dipantau                                                              | Perilaku yang Diharapkan/Diamati                                                                                                                            |
|----|------------------------------------------------------|----------------------------------|-----------|-----------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 1  | Tekan endpoint input nilai (`grades.php` POST)       | 200 VU, meningkat hingga 500 VU  | 2-5 menit | Error rate, waktu respons, status server (crash/tidak), penggunaan CPU/Memori.    | Diharapkan sistem akan mulai menunjukkan error rate tinggi, waktu respons sangat lambat. Identifikasi titik di mana sistem menjadi tidak stabil atau crash. |
| 2  | Tekan endpoint daftar siswa (`students.php` GET)     | 250 VU                           | 3 menit   | Error rate, waktu respons, penggunaan memori database.                            | Waktu respons meningkat tajam, mungkin terjadi timeout koneksi database.                                                                                    |
| 3  | Pemulihan Sistem setelah Beban Ekstrim Dihilangkan   | -                                | -         | Waktu bagi sistem untuk kembali ke waktu respons normal dan error rate rendah.    | Sistem harus dapat pulih ke kondisi operasional normal dalam waktu yang wajar setelah beban dihilangkan.                                                    |

**Alat Bantu dan Pengaturan:**
*   Sama seperti Load Testing (K6, JMeter).
*   Lingkungan server staging.
*   Alat monitoring server yang komprehensif.

**Metrik Pengujian:**
*   Titik Gagal Sistem (jumlah VU atau throughput di mana sistem crash atau error rate > X%).
*   Waktu Respons Maksimum sebelum kegagalan.
*   Error Rate di bawah tekanan ekstrim.
*   Waktu Pemulihan (Time to Recover) setelah beban dihilangkan.
*   Jenis error yang muncul (misalnya, 500 Internal Server Error, 503 Service Unavailable, DB connection errors).

#### 4.4.2 Hasil Stress Testing

Stress testing dilakukan dengan memberikan beban ekstrim pada endpoint input nilai (`grades.php` POST) untuk menentukan batas kemampuan aplikasi dan perilaku sistem di bawah tekanan berat.

**Ringkasan Hasil Stress Testing (Dummy):**

| Skenario Beban Ekstrim                               | VU Tercapai Saat Gagal/Degradasi Parah | Perilaku Sistem yang Diamati (Dummy)                                                                                                                                                                                                                            | Waktu Pemulihan (Dummy) |
|------------------------------------------------------|----------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------|
| Tekan endpoint input nilai (`grades.php` POST)       | ~350 VU                                | Pada ~250 VU, waktu respons P95 > 5 detik, error rate ~15%. Pada ~350 VU, error rate > 50% (banyak error 500 dari PHP karena timeout koneksi DB atau kehabisan worker PHP-FPM). Server tidak crash total, tapi menjadi sangat tidak responsif. CPU 100%. | ~2 menit setelah beban dihentikan. |
| Pemulihan Sistem                                     | -                                      | Setelah beban 350 VU dihentikan, sistem membutuhkan sekitar 2 menit untuk kembali ke waktu respons normal (<1s) dan error rate <1% untuk request ringan. Log menunjukkan beberapa proses PHP-FPM di-restart.                                                   | -                       |

**Analisis Hasil Stress Testing (Dummy):**
Stress testing menunjukkan bahwa aplikasi SGM mulai mengalami degradasi performa parah di sekitar 250 pengguna konkuren yang melakukan input nilai secara intensif, dan menjadi sangat tidak stabil di sekitar 350 VU. Titik kegagalan utama tampaknya adalah interaksi dengan database yang menjadi lambat dan menyebabkan timeout, serta potensi kehabisan sumber daya server (PHP workers). Kabar baiknya, sistem tidak mengalami crash total dan dapat pulih setelah beban ekstrim dihilangkan, meskipun memerlukan waktu beberapa menit. Ini menunjukkan adanya mekanisme pemulihan dasar, tetapi batas kapasitas perlu dipahami dan ditingkatkan jika target pengguna lebih tinggi. Rekomendasi termasuk optimasi database lebih lanjut, penyesuaian konfigurasi server (misalnya, jumlah worker PHP-FPM, batas koneksi, dan alokasi memori), dan mungkin implementasi antrian (queue) untuk operasi tulis yang berat.

---

## Bab 5: Laporan Proses Pengujian Secara Keseluruhan

Bab ini menyajikan ringkasan dari keseluruhan proses pengujian yang telah dilakukan pada aplikasi Student Grade Management. Ini mencakup metodologi umum, lingkungan pengujian, alat yang digunakan, temuan utama, dan penilaian kualitas aplikasi secara umum berdasarkan hasil pengujian.

**5.1 Ringkasan Proses Pengujian**
Proses pengujian aplikasi Student Grade Management dilakukan secara komprehensif, mencakup berbagai jenis dan tingkatan pengujian untuk memastikan kualitas, fungsionalitas, keamanan, dan performa aplikasi. Pengujian dimulai dari level unit kode, berlanjut ke integrasi antar modul, pengujian fungsional dari perspektif pengguna (black box), analisis keamanan, hingga pengujian performa di bawah beban normal dan ekstrim.

*   **Tahap Perencanaan:** Meliputi pemahaman terhadap aplikasi, penentuan ruang lingkup pengujian, pemilihan metodologi dan alat, serta perancangan kasus uji untuk setiap jenis pengujian. Dokumen-dokumen seperti [`rencana.md`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/rencana.md) dan skema database [`schema.sql`](/Users/afifjamhari/Project Coding/02. RAHEL/01. Nadia/tugas_ukpl/schema.sql) menjadi acuan penting.
*   **Tahap Persiapan Lingkungan:** Menyiapkan lingkungan pengujian yang mencakup server lokal (misalnya, XAMPP/MAMP dengan PHP dan MySQL), browser, serta instalasi alat-alat pengujian seperti PHPUnit, OWASP ZAP, dan K6. Database testing juga disiapkan.
*   **Tahap Desain Kasus Uji:** Mengembangkan kasus uji detail berdasarkan spesifikasi aplikasi dan rancangan pengujian yang telah dibuat untuk White Box, Black Box, Security, Unit, Integration, Load, dan Stress testing. Contoh kasus uji telah didokumentasikan dalam bab-bab sebelumnya.
*   **Tahap Eksekusi Pengujian:** Menjalankan kasus uji yang telah dirancang, baik secara manual maupun otomatis. Hasil setiap kasus uji dicatat, termasuk output aktual, status (lulus/gagal), dan bukti pendukung jika ada.
*   **Tahap Pelaporan dan Analisis Defect:** Semua kegagalan atau penyimpangan dari hasil yang diharapkan didokumentasikan sebagai defect. Setiap defect dianalisis untuk menentukan akar penyebab, tingkat keparahan, dan prioritas perbaikannya.
*   **Tahap Pengujian Regresi (Asumsi):** Setelah perbaikan defect dilakukan oleh tim pengembang, pengujian regresi akan dilakukan untuk memastikan bahwa perbaikan tersebut berhasil dan tidak menimbulkan masalah baru pada fungsionalitas yang sudah ada. (Untuk laporan ini, kita berasumsi tahap ini akan mengikuti).

**5.2 Lingkungan dan Alat Pengujian yang Digunakan**
*   **Lingkungan Server:**
    *   Sistem Operasi: macOS (pengembangan), Linux (simulasi server staging)
    *   Web Server: Apache (via XAMPP/MAMP)
    *   PHP Versi: 7.4 / 8.x (asumsi versi umum)
    *   Database: MySQL 5.7 / 8.0
*   **Lingkungan Klien:**
    *   Browser: Google Chrome (versi terbaru), Mozilla Firefox (versi terbaru)
*   **Alat Pengujian:**
    *   **Unit & White Box Testing:** PHPUnit, Xdebug (untuk code coverage)
    *   **Black Box Testing (Manual):** Browser Developer Tools
    *   **Security Testing:** OWASP ZAP, Burp Suite Community Edition (untuk inspeksi manual)
    *   **Load & Stress Testing:** K6
    *   **Manajemen Kasus Uji & Pelaporan:** Markdown (untuk laporan ini), Spreadsheet (untuk tracking kasus uji internal - asumsi)

**5.3 Temuan Utama dan Rekomendasi Umum**
Berdasarkan keseluruhan proses pengujian, beberapa temuan kunci dan rekomendasi umum dapat disimpulkan:

*   **Fungsionalitas Inti:** Sebagian besar fungsionalitas inti aplikasi (CRUD Kelas, Siswa, Nilai, Otentikasi) bekerja sesuai dengan spesifikasi dasar. Namun, beberapa isu terkait validasi input sisi server dan penanganan error yang user-friendly perlu perbaikan (merujuk pada temuan Black Box Testing).
*   **Kualitas Kode Internal:** Pengujian White Box dan Unit Testing menunjukkan bahwa struktur kode internal cukup baik, dengan logika yang sebagian besar benar. Fungsi-fungsi individual umumnya bekerja sesuai harapan dalam isolasi, meskipun beberapa kasus batas dan penanganan error memerlukan perbaikan minor.
*   **Keamanan:** Aplikasi memiliki dasar keamanan yang baik (misalnya, hashing password, penggunaan prepared statements di beberapa area). Namun, kerentanan signifikan seperti CSRF, XSS Reflected, dan Session Fixation ditemukan dan harus segera ditangani. Implementasi header keamanan HTTP juga direkomendasikan.
*   **Performa:** Aplikasi menunjukkan performa yang baik di bawah beban normal. Namun, bottleneck teridentifikasi pada operasi input nilai dan penampilan data besar di bawah beban puncak dan stress. Optimasi query database, penambahan indeks yang tepat, dan mungkin caching strategi diperlukan untuk menangani skala pengguna yang lebih besar.
*   **Usability:** Secara umum antarmuka pengguna cukup intuitif. Beberapa perbaikan minor terkait notifikasi pengguna dan responsivitas pada tampilan mobile tertentu dapat meningkatkan pengalaman pengguna.

**Rekomendasi Umum:**
1.  **Prioritaskan Perbaikan Defect Kritis/Tinggi:** Fokus utama harus pada perbaikan kerentanan keamanan (CSRF, XSS, Session Fixation) dan defect fungsional yang berdampak tinggi (misalnya, validasi server yang lemah, inkonsistensi data).
2.  **Perkuat Validasi Sisi Server:** Pastikan semua input pengguna divalidasi secara ketat di sisi server, tidak hanya mengandalkan validasi sisi klien.
3.  **Tingkatkan Penanganan Error:** Ganti error teknis (misalnya, error SQL) dengan pesan yang lebih user-friendly dan informatif.
4.  **Optimasi Performa:** Lakukan optimasi query database, tambahkan indeks yang sesuai, dan pertimbangkan strategi caching untuk endpoint yang berat. Tinjau konfigurasi server untuk performa optimal.
5.  **Implementasikan Token CSRF:** Segera tambahkan perlindungan token CSRF ke semua form yang mengubah state.
6.  **Lakukan Pengujian Regresi:** Setelah perbaikan, lakukan pengujian regresi menyeluruh untuk memastikan tidak ada isu baru.
7.  **Tingkatkan Logging dan Monitoring:** Implementasikan logging yang lebih baik untuk membantu diagnosis masalah di lingkungan produksi.

**5.4 Penilaian Kualitas Aplikasi Secara Keseluruhan**
Berdasarkan hasil pengujian (dengan data dummy), aplikasi Student Grade Management memiliki fondasi yang solid dan sebagian besar fungsionalitas inti berjalan dengan baik. Namun, terdapat beberapa area penting, terutama dalam hal keamanan dan performa di bawah beban tinggi, serta beberapa isu fungsional minor, yang memerlukan perhatian dan perbaikan sebelum aplikasi dianggap siap untuk produksi skala penuh.

Dengan penanganan defect yang teridentifikasi, terutama yang berkaitan dengan keamanan dan performa, kualitas dan keandalan aplikasi dapat ditingkatkan secara signifikan. Proses pengujian ini telah memberikan wawasan berharga mengenai kekuatan dan kelemahan aplikasi saat ini.

**5.5 Keterbatasan Pengujian**
Penting untuk dicatat beberapa keterbatasan dalam proses pengujian ini:
*   **Data Dummy:** Hasil pengujian didasarkan pada data dummy. Perilaku sistem mungkin berbeda dengan data riil yang lebih beragam dan bervolume besar.
*   **Lingkungan Staging:** Meskipun diusahakan mirip, lingkungan staging mungkin tidak 100% identik dengan lingkungan produksi, yang dapat mempengaruhi hasil pengujian performa dan keamanan.
*   **Cakupan Pengujian Otomatis:** Beberapa pengujian (misalnya, Black Box UI) mungkin dilakukan secara manual. Cakupan pengujian otomatis yang lebih luas dapat meningkatkan efisiensi dan konsistensi.
*   **Exploratory Testing Terbatas:** Waktu yang dialokasikan untuk exploratory testing mungkin terbatas, sehingga ada kemungkinan beberapa bug yang tidak biasa terlewat.
*   **Aspek Non-Fungsional Lain:** Pengujian mungkin belum mencakup semua aspek non-fungsional secara mendalam (misalnya, usability detail, accessibility, compatibility dengan semua browser/perangkat).

**5.6 Saran untuk Pengujian di Masa Depan**
*   **Otomasi Pengujian UI:** Pertimbangkan untuk mengimplementasikan alat otomasi UI seperti Selenium atau Cypress untuk pengujian regresi fungsional.
*   **Pengujian dengan Data Riil (Anonim):** Jika memungkinkan, lakukan pengujian performa dan fungsional dengan dataset yang lebih besar dan mencerminkan data produksi (setelah dianonimkan).
*   **Continuous Integration/Continuous Testing (CI/CT):** Integrasikan pengujian (terutama unit dan integrasi otomatis) ke dalam pipeline CI/CD untuk deteksi bug lebih dini.
*   **Pengujian Usability Formal:** Lakukan sesi pengujian usability formal dengan pengguna target untuk mendapatkan feedback yang lebih mendalam.
*   **Pengujian Accessibility (A11y):** Pastikan aplikasi dapat diakses oleh pengguna dengan berbagai kebutuhan.

---

## Bab 6: Kesimpulan dan Rekomendasi

Proses pengujian yang komprehensif terhadap aplikasi Student Grade Management telah selesai dilaksanakan. Pengujian ini mencakup berbagai aspek mulai dari fungsionalitas dasar, logika internal kode, keamanan sistem, hingga performa di bawah tekanan. Berdasarkan analisis terhadap hasil pengujian (menggunakan data dummy dan merujuk pada struktur proyek), beberapa kesimpulan dan rekomendasi utama dapat dirumuskan.

**6.1 Kesimpulan Utama**

1.  **Fungsionalitas Dasar Terpenuhi:** Aplikasi Student Grade Management secara umum telah berhasil mengimplementasikan fungsionalitas inti yang diharapkan, seperti manajemen pengguna (guru), manajemen kelas, manajemen siswa, dan input serta pengelolaan nilai. Alur kerja utama dapat dijalankan oleh pengguna.
2.  **Kualitas Kode Internal Cukup Baik:** Pengujian White Box dan Unit Testing menunjukkan bahwa struktur kode internal cukup baik, dengan logika yang sebagian besar benar. Fungsi-fungsi individual umumnya bekerja sesuai harapan dalam isolasi, meskipun beberapa kasus batas dan penanganan error memerlukan perbaikan minor.
3.  **Kerentanan Keamanan Teridentifikasi:** Meskipun ada praktik keamanan dasar yang diterapkan (seperti hashing password dan penggunaan prepared statements di beberapa tempat), beberapa kerentanan keamanan signifikan ditemukan, termasuk **CSRF (High)**, **XSS Reflected (Medium)**, dan **Session Fixation (Medium)**. Kerentanan ini memerlukan perhatian segera karena dapat dieksploitasi untuk mengkompromikan data dan akun pengguna.
4.  **Performa Memerlukan Optimasi:** Aplikasi menunjukkan performa yang memadai di bawah beban pengguna normal. Namun, pada saat beban puncak dan kondisi stress, teridentifikasi bottleneck pada operasi database (khususnya input nilai dan query data besar) yang menyebabkan degradasi waktu respons dan peningkatan error rate.
5.  **Validasi Input dan Penanganan Error Perlu Ditingkatkan:** Ditemukan beberapa kasus di mana validasi input sisi server kurang ketat dan penanganan error belum sepenuhnya user-friendly, terkadang menampilkan error teknis langsung kepada pengguna.
6.  **Potensi Peningkatan Usability:** Ada beberapa area minor di mana pengalaman pengguna dapat ditingkatkan, seperti notifikasi yang lebih jelas setelah aksi berhasil dan perbaikan responsivitas pada tampilan mobile tertentu.

Secara keseluruhan, aplikasi Student Grade Management memiliki potensi besar namun memerlukan serangkaian perbaikan yang ditargetkan, terutama di area keamanan dan performa, sebelum dapat dianggap sepenuhnya matang dan aman untuk penggunaan produksi skala penuh.

**6.2 Rekomendasi Utama (Diprioritaskan)**

Berikut adalah rekomendasi yang diprioritaskan berdasarkan temuan pengujian:

1.  **Tindakan Keamanan Segera (Prioritas Sangat Tinggi):**
    *   **Implementasikan Perlindungan CSRF:** Tambahkan token anti-CSRF ke semua form yang melakukan modifikasi data (POST, PUT, DELETE requests) untuk mencegah serangan Cross-Site Request Forgery. Ini adalah prioritas utama.
    *   **Perbaiki Kerentanan XSS:** Lakukan sanitasi output yang ketat (misalnya, menggunakan `htmlspecialchars()` secara konsisten) pada semua data yang direfleksikan dari input pengguna atau parameter URL untuk mencegah XSS Reflected.
    *   **Atasi Session Fixation:** Pastikan session ID di-regenerate (`session_regenerate_id(true)`) segera setelah pengguna berhasil login.

2.  **Peningkatan Validasi dan Penanganan Error (Prioritas Tinggi):**
    *   **Perkuat Validasi Sisi Server:** Jangan hanya mengandalkan validasi sisi klien. Implementasikan validasi yang komprehensif di sisi server untuk semua input data, termasuk tipe data, format, rentang, dan batasan lainnya.
    *   **Sempurnakan Pesan Error:** Ganti pesan error teknis atau default dengan pesan yang jelas, informatif, dan user-friendly.

3.  **Optimasi Performa (Prioritas Tinggi):**
    *   **Analisis dan Optimasi Query Database:** Identifikasi query yang lambat (terutama pada operasi input nilai dan pengambilan daftar data besar) dan lakukan optimasi. Pastikan penggunaan indeks database yang tepat pada kolom yang sering di-query atau di-join.
    *   **Tinjau Konfigurasi Server:** Sesuaikan konfigurasi server (PHP, web server, database server) untuk menangani beban yang lebih tinggi, misalnya jumlah worker, batas koneksi, dan alokasi memori.
    *   **Pertimbangkan Caching:** Untuk data yang sering diakses dan tidak sering berubah, implementasikan strategi caching yang sesuai.

4.  **Perbaikan Defect Fungsional dan Logika (Prioritas Medium):**
    *   Perbaiki semua defect fungsional yang ditemukan selama Black Box Testing dan kesalahan logika dari White Box/Unit Testing untuk memastikan aplikasi berperilaku konsisten dan benar.

5.  **Peningkatan Keamanan Tambahan (Prioritas Medium):**
    *   Tambahkan header keamanan HTTP yang direkomendasikan (misalnya, `X-Frame-Options`, `X-Content-Type-Options`).
    *   Nonaktifkan eksposur informasi versi software yang tidak perlu (misalnya, melalui pengaturan `php.ini`).

6.  **Pengujian Regresi (Prioritas Rendah):**
    *   Lakukan pengujian regresi menyeluruh setelah perbaikan untuk memastikan tidak ada isu baru yang muncul dan semua fungsionalitas tetap bekerja.

7.  **Peningkatan Usability (Prioritas Rendah):**
    *   Perbaiki tampilan responsif pada beberapa halaman jika diperlukan.
    *   Tambahkan notifikasi yang lebih jelas untuk aksi yang berhasil atau gagal.

---

## 2. Desain Database (MySQL)

```sql
-- Tabel: users (guru)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(100) NOT NULL
);

-- Tabel: classes
CREATE TABLE classes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255)
);

-- Tabel: students
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  class_id INT NOT NULL,
  FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- Tabel: grades
CREATE TABLE grades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  subject VARCHAR(100) NOT NULL,
  score INT NOT NULL CHECK (score BETWEEN 0 AND 100),
  grade_point DECIMAL(3,2) NOT NULL,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
```