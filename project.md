# Product Requirement Document (PRD) – Task Management App

**Versi:** 1.1  
**Tanggal:** 2026-03-04  

---

## 1. Ringkasan Project
**Nama Aplikasi:** Task Management  
**Deskripsi Singkat:**  
Aplikasi untuk memanajemen tugas developer agar prioritas tugas lebih jelas. Menggunakan algoritma Naive Bayes untuk membantu developer menentukan urutan tugas yang harus diselesaikan terlebih dahulu.  

**Problem yang Diselesaikan:**  
Developer sering memiliki banyak tugas dan bingung menentukan prioritas. Aplikasi ini membantu mengurutkan task berdasarkan prediksi prioritas, sehingga produktivitas lebih terstruktur.  

---

## 2. User Persona
- **Target User:** Developer  
- **Role:** Tidak ada role khusus; semua user memiliki hak akses penuh terhadap project dan tasks miliknya.  

---

## 3. Fitur Utama & Requirement

### 3.1 Autentikasi
- Login dan logout untuk mengakses aplikasi.  
- Validasi login dan penanganan error jika gagal.  

### 3.2 Project Management
- Membuat project baru dan menyimpannya.  
- Update project jika perlu mengubah detail project.  
- Hapus project jika sudah tidak diperlukan, termasuk semua task di dalamnya.  

### 3.3 Task Management
- Menambahkan task ke dalam project.  
- Mengupdate status atau progres task.  
- Menghapus task jika tidak relevan.  
- Mengurutkan task otomatis menggunakan Naive Bayes untuk menentukan prioritas.  

### 3.4 Dashboard & Reporting
- Menampilkan ringkasan semua project user dan status task.  
- Download laporan CSV per project dengan daftar task dan prioritasnya.  

---

## 4. Alur Pengguna (User Flow – Detail + Use Case Ready)

### 4.1 Login
**Use Case:** User ingin mengakses dashboard dan projectnya.  
**Langkah Detail:**  
1. User buka halaman login (`/login`).  
2. User mengisi email dan password.  
3. Klik tombol **Login**.  
4. Sistem memvalidasi kredensial:
   - Jika valid → redirect ke **Dashboard**.  
   - Jika gagal → tampilkan pesan error “Email atau password salah”.  
5. User bisa klik tombol **Logout** kapan saja untuk keluar dari session.

---

### 4.2 Membuat Project
**Use Case:** User ingin menambahkan project baru.  
**Langkah Detail:**  
1. Di dashboard, klik tombol **Create Project**.  
2. Muncul form input project.  
3. User mengisi detail project.  
4. Klik **Save / Submit**.  
5. Sistem menyimpan project baru ke database.  
6. Project baru muncul di:
   - Menu **Tasks** (list project)  
   - Dashboard (summary project & jumlah task)

---

### 4.3 Mengupdate Project
**Use Case:** User ingin mengubah informasi project yang sudah dibuat.  
**Langkah Detail:**  
1. Pilih project dari daftar **Tasks** atau **Dashboard**.  
2. Klik tombol **Edit Project**.  
3. Ubah informasi project di form edit.  
4. Klik **Save / Update**.  
5. Sistem menyimpan perubahan ke database.  
6. Project yang diperbarui muncul dengan data terbaru di daftar **Tasks** dan **Dashboard**.

---

### 4.4 Menghapus Project
**Use Case:** User ingin menghapus project yang sudah tidak relevan.  
**Langkah Detail:**  
1. Pilih project dari daftar **Tasks** atau **Dashboard**.  
2. Klik tombol **Delete Project**.  
3. Sistem meminta konfirmasi “Apakah yakin ingin menghapus project ini?”  
4. User klik **Yes / Confirm**.  
5. Sistem menghapus project beserta semua task di dalamnya dari database.  
6. Project hilang dari daftar **Tasks** dan **Dashboard**.

---

### 4.5 Menambahkan Task
**Use Case:** User ingin menambahkan task ke project.  
**Langkah Detail:**  
1. Pilih project di menu **Tasks**.  
2. Klik tombol **Create Task**.  
3. Muncul form input task.  
4. User mengisi task.  
5. Klik **Save / Submit**.  
6. Task tersimpan di database dan muncul di daftar task project tersebut.

---

### 4.6 Mengupdate Status Task
**Use Case:** User ingin menandai progres task.  
**Langkah Detail:**  
1. Pilih task dari daftar project.  
2. Klik dropdown/status button pada task.  
3. Pilih status baru: “Pending”, “In Progress”, atau “Done”.  
4. Sistem memperbarui status di database.  
5. Dashboard menampilkan update status secara real-time.  

---

### 4.7 Menghapus Task
**Use Case:** User ingin menghapus task yang tidak relevan.  
**Langkah Detail:**  
1. Pilih task dari daftar project.  
2. Klik tombol **Delete Task**.  
3. Sistem meminta konfirmasi “Apakah yakin ingin menghapus task ini?”  
4. User klik **Yes / Confirm**.  
5. Task dihapus dari database dan hilang dari daftar task project.

---

### 4.8 Mengurutkan Task (Naive Bayes)
**Use Case:** User ingin mengurutkan task secara otomatis sesuai prioritas.  
**Langkah Detail:**  
1. Di daftar task project, klik tombol **Apply Smart Sort**.  
2. Sistem mengirim request ke **API Naive Bayes**:
   - Endpoint: `/api/sort_tasks`  
   - Method: POST  
   - Payload: list task dari project (task ID, status, due date, kategori)  
3. API memproses data menggunakan model Naive Bayes.  
4. API mengembalikan task list yang sudah diurutkan berdasarkan prioritas.  
5. Frontend menampilkan task sesuai urutan prioritas baru.  
6. User dapat langsung melihat task prioritas tinggi di atas.

---

### 4.9 Dashboard & Laporan
**Use Case:** User ingin memantau seluruh project dan mengunduh laporan.  
**Langkah Detail:**  
1. User membuka halaman **Dashboard**.  
2. Sistem menampilkan ringkasan semua project:
   - Jumlah task per project  
   - Status task  
   - Prioritas task (jika sudah diurutkan)  
3. Untuk download laporan, klik tombol **Download CSV** pada project yang diinginkan.  
4. Sistem menghasilkan file CSV berisi:
   - Daftar semua task  
   - Status task  
   - Prioritas task  
   - Due date  
5. File CSV siap diunduh oleh user.
