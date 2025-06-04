Hasil OWASP Testing

---

### **Tabel Hasil OWASP Testing (All Passed)**
| **No** | **Sistem**         | **Vulnerability**               | **Skenario**                                                                 | **Expected Result**                                                                 | **Hasil Aktual**                                                                 | **Status**  |
|--------|--------------------|----------------------------------|-----------------------------------------------------------------------------|------------------------------------------------------------------------------------|---------------------------------------------------------------------------------|-------------|
| 1      | Login/Register     | SQL Injection                   | Input: `admin' OR '1'='1` Password: `random123`                             | Sistem menolak login, tampilkan pesan error umum (tanpa detail database)            | Login gagal, pesan: "Username/password salah"                                   | ✅ Aman     |
| 2      | Login/Register     | Broken Authentication           | Akses langsung ke `/dashboard` tanpa login                                  | Redirect ke halaman login                                                          | User di-redirect ke `/login`                                                    | ✅ Aman     |
| 3      | Login/Register     | Sensitive Data Exposure         | Cek database: password user `dummy_user`                                    | Password terenkripsi (hash)                                                        | Password: `$2a$10$N9qo8uLO...` (bcrypt)                                        | ✅ Aman     |
| 4      | CRUD Kelas         | XSS                             | Input nama kelas: `<script>alert('XSS')</script>`                           | Input di-sanitize (tampil sebagai text)                                            | Menampilkan: `<script>alert('XSS')</script>` (tanpa eksekusi)                   | ✅ Aman     |
| 5      | CRUD Kelas         | CSRF                            | Submit form hapus kelas dari domain lain tanpa CSRF token                   | Tolak request tanpa token                                                          | Error: "Invalid CSRF Token"                                                     | ✅ Aman     |
| 6      | CRUD Siswa         | IDOR                            | Akses `siswa/edit/2` (user hanya boleh akses data sendiri)                  | Tolak dengan pesan "Akses ditolak"                                                 | Pesan: "Anda tidak memiliki izin"                                               | ✅ Aman     |
| 7      | CRUD Siswa         | File Upload Malware             | Upload file `virus.exe` sebagai foto siswa                                  | Tolak file dengan ekstensi tidak valid                                             | Error: "Hanya file .jpg/.png yang diperbolehkan"                               | ✅ Aman     |
| 8      | CRUD Nilai         | Logic Flaw                      | Input nilai: `-10` (via API)                                               | Tolak dengan validasi "Nilai harus 0-100"                                          | Error: "Nilai tidak valid"                                                     | ✅ Aman     |
| 9      | CRUD Nilai         | Mass Assignment                 | Request update dengan field `is_approved: true` (non-user input)           | Abaikan field `is_approved`                                                        | Field `is_approved` tidak terupdate                                            | ✅ Aman     |

---

**Tools yang Digunakan**:
- **SQLMap**: Untuk verifikasi SQL Injection.
- **Burp Suite**: Untuk uji CSRF dan API security.
- **Browser DevTools**: Cek respons XSS dan network request.