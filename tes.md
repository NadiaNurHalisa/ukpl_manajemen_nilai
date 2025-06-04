Berdasarkan arsitektur aplikasi Student Grade Management, berikut adalah file Mermaid untuk alur poin 1-3:

## 1. Alur Autentikasi & Routing Utama

```mermaid
flowchart TD
    A[User akses index.php] --> B{Ada Session?}
    B -->|Tidak| C[Login Page]
    B -->|Ya| D[Dashboard]
    
    C --> E{Submit Login?}
    E -->|Tidak| C
    E -->|Ya| F{Valid?}
    
    F -->|Tidak| G[Error Message]
    F -->|Ya| H[Set Session]
    
    G --> C
    H --> D
    
    D --> I[Menu Dashboard]
    I --> J[Classes]
    I --> K[Students] 
    I --> L[Grades]
    I --> M[Logout]
    
    M --> N[Destroy Session]
    N --> C
```

## 2. Alur Manajemen Kelas (classes.php)

```mermaid
flowchart TD
    A[Akses classes.php] --> B{Cek Session}
    B -->|Tidak ada| C[Redirect ke login]
    B -->|Valid| D{Request Method}
    
    D -->|GET| E{Action}
    D -->|POST| F{Action}
    
    E -->|delete| G[Delete Class]
    E -->|edit| H[Edit Form]
    E -->|default| I[Show List]
    
    F -->|add| J[Add Class]
    F -->|edit| K[Update Class]
    
    G --> L{Has Students?}
    L -->|Ya| M[Error: Cannot Delete]
    L -->|Tidak| N[Delete Success]
    
    J --> O{Valid Input?}
    O -->|Ya| P[Create Success]
    O -->|Tidak| Q[Error Message]
    
    K --> R{Valid Input?}
    R -->|Ya| S[Update Success]
    R -->|Tidak| T[Error Message]
    
    N --> I
    P --> I
    S --> I
    M --> I
    Q --> I
    T --> I
    H --> I
```

## 3. Alur Manajemen Siswa (students.php)

```mermaid
flowchart TD
    A[Akses students.php] --> B{Cek Session}
    B -->|Tidak ada| C[Redirect ke login]
    B -->|Valid| D{Ada Kelas?}
    
    D -->|Tidak| E[Warning: Tambah kelas dulu]
    D -->|Ya| F{Request Method}
    
    F -->|GET| G{Action}
    F -->|POST| H{Action}
    
    G -->|delete| I[Delete Student]
    G -->|edit| J[Edit Form]
    G -->|default| K[Show List]
    
    H -->|add| L[Add Student]
    H -->|edit| M[Update Student]
    
    I --> N{Has Grades?}
    N -->|Ya| O[Error: Cannot Delete]
    N -->|Tidak| P[Delete Success]
    
    L --> Q{Valid Data?}
    Q -->|Ya| R[Create Success]
    Q -->|Tidak| S[Error Message]
    
    M --> T{Valid Data?}
    T -->|Ya| U[Update Success]
    T -->|Tidak| V[Error Message]
    
    P --> K
    R --> K
    U --> K
    O --> K
    S --> K
    V --> K
    J --> K
    E --> K
```


## 3A. Alur Menambahkan Nilai (grades.php)

```mermaid
flowchart TD
    A[Akses grades.php] --> B{Cek Session}
    B -->|Tidak ada| C[Redirect ke login]
    B -->|Valid| D{Request Method}
    
    D -->|GET| E{Action}
    D -->|POST| F{Action}
    
    E -->|delete| G[Delete Grade]
    E -->|edit| H[Edit Form]
    E -->|default| I[Show List]
    
    F -->|add| J{Valid Input?}
    F -->|edit| K{Valid Input?}
    
    J -->|Ya| L{Student Exists?}
    J -->|Tidak| M[Error Message]
    
    L -->|Ya| N{No Duplicate?}
    L -->|Tidak| M
    
    N -->|Ya| O[Add Success]
    N -->|Tidak| M
    
    K -->|Ya| P[Update Success]
    K -->|Tidak| M
    
    G --> I
    O --> I
    P --> I
    M --> I
    H --> I
```
```


## 4. Dependensi Antar Modul

```mermaid
flowchart TD
    A[Users] --> B[Login]
    B --> C[Dashboard]
    
    C --> D[Classes]
    C --> E[Students]
    C --> F[Grades]
    
    D --> G[Create Classes]
    G --> H[Create Students]
    H --> I[Create Grades]
    
    J[Delete Class] --> K{Has Students?}
    K -->|Ya| L[Error]
    K -->|Tidak| M[Success]
    
    N[Delete Student] --> O{Has Grades?}
    O -->|Ya| P[Error]
    O -->|Tidak| Q[Success]
```
