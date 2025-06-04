# Rancangan Aplikasi Student Grade Management (PHP Native + TailwindCSS + MySQL)

## 1. Arsitektur & Alur Sistem

1. File-based routing sederhana (index.php)  
2. Folder `templates/` untuk partial HTML (header, footer)  
3. Folder `functions/` untuk logic, file dipisahkan berdasarkan tema  
4. File `database.php` untuk koneksi DB
4. Frontend: PHP + TailwindCSS  
5. Database: MySQL  

### Alur Utama

1. User mengakses `index.php`  
2. Jika belum login → redirect ke `login.php`  
3. Setelah login (fungsi `login()`), set `$_SESSION['user']` → redirect ke `dashboard.php`  
4. Dashboard menampilkan menu:  
   - **Manajemen Kelas** → `classes.php`  
   - **Manajemen Siswa** → `students.php`  
   - **Input/Edit Nilai** → `grades.php`  
5. Setiap aksi (create/read/update/delete) memanggil fungsi di `functions.php`  
6. Logout via `logout.php` → `session_destroy()` → kembali ke login  

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