# 📚 LMS Frontend - Role Based Access Control System

Dokumentasi lengkap untuk sistem manajemen pengguna dan role berbasis frontend yang telah diimplementasikan.

---

## 🎯 Fitur Utama

### 1. **Data Pengguna Management**
Halaman untuk mengelola semua pengguna sistem dengan fitur CRUD lengkap.

**URL:** `/data-pengguna`

**Field User:**
- Nama Lengkap
- NIM/NIP (identitas mahasiswa/dosen)
- Email
- Password (auto-hashed di production)
- Role (Admin, Dosen, Mahasiswa)
- Status (Aktif/Nonaktif)

**Fitur:**
- ✓ Tambah pengguna baru
- ✓ Edit data pengguna dengan password optional
- ✓ Hapus pengguna dengan konfirmasi
- ✓ Cari pengguna (nama, email, NIM/NIP)
- ✓ Tampilan status dengan badge warna
- ✓ Toast notification untuk setiap aksi

**Sample Data (Default):**
```
1. Admin User (ADM001) - admin@kampus.ac.id - Admin
2. Dr. Santoso, M.Kom (NIP1001) - santoso@kampus.ac.id - Dosen
3. Ir. Rina, M.T (NIP1002) - rina@kampus.ac.id - Dosen
4. Toni Hermawan (210203001) - toni@kampus.ac.id - Mahasiswa
5. Siti Nurhaliza (210203002) - siti@kampus.ac.id - Mahasiswa
```

---

### 2. **Manajemen Role & Permission**
Halaman untuk membuat dan mengelola role dengan permission matrix.

**URL:** `/manajemen-role`

**7 Permission Types:**
1. **Create/Tambah** - Membuat data baru
2. **Read/Lihat** - Melihat/membaca data
3. **Update/Edit** - Mengubah data yang ada
4. **Delete/Hapus** - Menghapus data
5. **Manage User** - Mengelola pengguna sistem
6. **Manage Role** - Mengelola role dan permission
7. **Reports** - Mengakses laporan sistem

**Default Roles:**
```
Admin
├─ Permissions: Create, Read, Update, Delete, Manage User, Manage Role, Reports
├─ Deskripsi: Admin sistem dengan akses penuh

Dosen
├─ Permissions: Create, Read, Update, Reports
├─ Deskripsi: Dosen pengelola kelas dan materi

Mahasiswa
├─ Permissions: Read
├─ Deskripsi: Mahasiswa pengguna sistem pembelajaran

Moderator
├─ Permissions: Create, Read, Update, Delete
├─ Deskripsi: Moderator forum dan diskusi
```

**Fitur:**
- ✓ Tambah role baru
- ✓ Edit role dan permission
- ✓ Hapus role
- ✓ Checkbox permission selection
- ✓ Status aktif/nonaktif
- ✓ Real-time search

---

### 3. **Dynamic Sidebar System**
Menu sidebar otomatis menyesuaikan berdasarkan role pengguna.

**Master Data Menu Items:**
```
Master Data
├─ Data Pengguna (Admin only)
├─ Data Mata Kuliah (All roles)
├─ Manajemen Kelas (All roles)
└─ Manajemen Role (Admin only)
```

**Fitur:**
- ✓ Menu items muncul/hilang berdasarkan role
- ✓ Pada halaman Data Pengguna, sidebar update ketika pengguna ditambah/diedit
- ✓ Menyimpan role pilihan di localStorage
- ✓ Automatic update saat navigasi halaman

---

## 🔧 Implementasi Teknis

### File yang Dimodifikasi/Dibuat

#### 1. `resources/views/admin/datapengguna.blade.php`
**Komponen:**
- Table dengan 6 kolom (Nama, NIM/NIP, Email, Role, Status, Aksi)
- Modal Tambah/Edit User
- Modal Konfirmasi Hapus
- Search input
- Toast notification container

**JavaScript Functions:**
- `renderTable(data)` - Render tabel dari data array
- `editUser(id)` - Buka modal edit dengan pre-filled data
- `showDeleteConfirm(id, name)` - Tampilkan konfirmasi hapus
- `deleteUser()` - Eksekusi penghapusan
- `showToast(message, type)` - Tampilkan notifikasi
- Integration dengan `updateSidebarFromRole(role)` saat submit form

#### 2. `resources/views/admin/manajemenrole.blade.php`
**Komponen:**
- Table dengan 5 kolom (Nama Role, Deskripsi, Permission Badges, Status, Aksi)
- Modal Tambah/Edit Role
- Permission checkboxes (7 items)
- Modal Konfirmasi Hapus

**JavaScript Functions:**
- `renderTable(data)` - Render tabel role
- `editRole(id)` - Populate modal dengan role data
- `getPermissionLabels(permissions)` - Convert permission keys ke display labels
- CRUD operations management

#### 3. `resources/views/layouts/partials/_sidebar.blade.php`
**Modifikasi:**
- Tambahkan `style="display: none;"` ke menu items
- Tambahkan class identifiers:
  - `.menu-item-data-pengguna`
  - `.menu-item-data-matkul`
  - `.menu-item-data-kelas`
  - `.menu-item-manajemen-role`

**JavaScript Addition:**
- `rolePermissions` object - Mapping role ke permission menu
- `updateSidebarVisibility(role)` - Update status display menu items
- `window.updateSidebarFromRole(role)` - Global function untuk trigger update
- DOMContentLoaded listener untuk inisialisasi

---

## 🎨 UI/UX Design

### Color Scheme
```
Primary Blue:    #1976d2
Success Green:   #4caf50
Danger Red:      #d32f2f
Warning Orange:  #ff9800
Light Gray:      #f8f9fa
Dark Gray:       #333333
```

### Icons (Unicode Symbols)
```
✎ Edit
✕ Delete
✓ Success
⚠ Warning
○ Status Inactive
```

### Badge Styles
```
.badge-primary     - Biru UI (Admin, default)
.badge-warning     - Amber (Dosen, edit actions)
.badge-secondary   - Gray (Mahasiswa, inactive)
.badge-success     - Hijau (Active status)
```

### Animations
```
slideIn   - 0.3s ease (toast masuk dari kanan)
fadeOut   - 0.3s ease (toast keluar ke kanan)
hover     - 0.2s ease (button dan table rows)
```

---

## 📱 Responsive Behavior

- **Table:** Horizontal scroll pada mobile (table-responsive)
- **Modal:** Centered dengan max-width 512px (modal-dialog-centered)
- **Search:** Full width input pada desktop, 250px maksimal
- **Buttons:** Mobile-optimized dengan padding yang jelas
- **Icons:** Font size 16px untuk mobile-friendly taps

---

## 🔄 Data Flow

### User Management Flow
```
Click "Tambah Pengguna"
    ↓
Modal terbuka (empty form)
    ↓
Fill form & Click "Simpan"
    ↓
Validation & Add to allData[]
    ↓
Re-render table
    ↓
Show success toast
    ↓
Update sidebar visibility
    ↓
Close modal
```

### Edit User Flow
```
Click "✎" button
    ↓
editUser() dipanggil
    ↓
Modal terbuka (pre-filled data)
    ↓
Edit field & Click "Simpan"
    ↓
Update allData[] matching ID
    ↓
Re-render table
    ↓
Show update toast
    ↓
Update sidebar
```

### Delete User Flow
```
Click "✕" button
    ↓
showDeleteConfirm() dipanggil
    ↓
Confirmation modal terbuka
    ↓
Click "Hapus"
    ↓
deleteUser() executed
    ↓
Remove from allData[]
    ↓
Re-render table
    ↓
Show delete toast
    ↓
Close modal
```

---

## 💾 Data Storage (Frontend)

### localStorage Keys
```
currentUserRole - Menyimpan role yang sedang dipilih
                  Digunakan untuk sidebar visibility
                  Default: 'admin'
```

### In-Memory Data Structures
```javascript
allData[] - Array semua users
{
  id: number,
  name: string,
  nim_nip: string,
  email: string,
  role: 'admin' | 'dosen' | 'mahasiswa',
  status: 'aktif' | 'nonaktif'
}

currentData[] - Array hasil filter (search)
editingId - null | number (untuk track user yang sedang di-edit)
deleteId - null | number (untuk track user yang akan dihapus)
```

---

## 🚀 Production Checklist

### Backend Integration Required
- [ ] Connect user data dari `/api/v1/users` endpoint
- [ ] Connect role data dari `/api/v1/roles` endpoint
- [ ] Update DELETE/POST/PUT handlers
- [ ] Add server-side validation
- [ ] Add authentication middleware
- [ ] Add authorization checks
- [ ] Hash passwords sebelum simpan
- [ ] Add audit logging

### Security Enhancements
- [ ] CSRF token untuk form submissions
- [ ] Password encryption (bcrypt)
- [ ] Role-based route middleware
- [ ] Permission checking per user
- [ ] Rate limiting on API endpoints
- [ ] SQL injection prevention
- [ ] XSS protection

### Data Persistence
- [ ] Create users table migration
- [ ] Create roles table migration
- [ ] Create role_permissions table migration
- [ ] Create user_roles junction table
- [ ] Seed default roles & permissions

---

## 🧪 Testing Guide

### Manual Test Cases

**Test 1: Add User**
1. Buka `/data-pengguna`
2. Klik tombol "Tambah Pengguna"
3. Isi form lengkap
4. Klik "Simpan"
5. ✓ Toast muncul
6. ✓ User muncul di tabel
7. ✓ Sidebar di-update

**Test 2: Edit User**
1. Klik tombol "✎" pada user row
2. Modal terbuka dengan data pre-filled
3. Ubah salah satu field
4. Klik "Simpan"
5. ✓ Data terupdate di tabel
6. ✓ Toast "diperbarui" muncul

**Test 3: Delete User**
1. Klik tombol "✕" pada user row
2. Confirmation modal muncul
3. Klik "Hapus"
4. ✓ User removed dari tabel
5. ✓ Toast "dihapus" muncul

**Test 4: Search Filter**
1. Ketik di search box
2. ✓ Table filter real-time
3. ✓ Cocokkan: nama, email, atau NIM/NIP

**Test 5: Sidebar Update**
1. Di data-pengguna, ubah/tambah user dengan role berbeda
2. ✓ Sidebar menu items berubah visibility
3. ✓ Refresh halaman, sidebar tetap sesuai role

---

## 📚 Component API Reference

### datapengguna.blade.php Functions

```javascript
renderTable(data: Array)
// Re-render user table dari data array

editUser(id: number)
// Buka modal edit dengan data pre-filled untuk user ID

showDeleteConfirm(id: number, name: string)
// Tampilkan konfirmasi hapus modal

deleteUser()
// Eksekusi penghapusan user dari allData[]

showToast(message: string, type: 'success' | 'error' | 'info')
// Tampilkan notifikasi toast dengan auto-dismiss
```

### manajemenrole.blade.php Functions

```javascript
renderTable(data: Array)
// Re-render role table

editRole(id: number)
// Edit role dan permission checkboxes

showDeleteConfirm(id: number, name: string)
// Tampilkan konfirmasi hapus

deleteRole()
// Eksekusi penghapusan role
```

### sidebar.blade.php Functions

```javascript
updateSidebarVisibility(role: 'admin' | 'dosen' | 'mahasiswa')
// Update menu items visibility berdasarkan role
// Simpan ke localStorage
// Update DOM elements

window.updateSidebarFromRole(role: string)
// Global function untuk trigger sidebar update
// Bisa dipanggil dari file lain via window object
```

---

## 📝 Notes untuk Developer

### Important Considerations
1. **Frontend Only** - Data disimpan di memory (allData[]), akan hilang saat refresh
2. **No Authentication** - Tidak ada user authentication, sandbox mode
3. **UUID vs ID** - Menggunakan numeric ID, ganti dengan UUID di production
4. **Search Performance** - Current filter O(n), optimize dengan index di production
5. **Toast Auto-Dismiss** - 4 detik, bisa diatur di showToast()
6. **Modal Backdrop** - Static backdrop (prevent close saat click outside)

### Common Issues & Solutions

**Issue:** Sidebar tidak update saat tambah user
**Solution:** Pastikan `updateSidebarFromRole()` dipanggil di form submit handler

**Issue:** Search tidak menemukan hasil
**Solution:** Search case-insensitive, gunakan toLowerCase()

**Issue:** Modal tidak close setelah submit
**Solution:** Pastikan `data-bs-dismiss="modal"` atau manual `.hide()` dipanggil

---

## 🎓 Learning Resources

- Bootstrap 5 Modals: https://getbootstrap.com/docs/5.0/components/modal/
- Vanilla JavaScript Array Methods: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array
- localStorage API: https://developer.mozilla.org/en-US/docs/Web/API/Window/localStorage
- Custom Events: https://developer.mozilla.org/en-US/docs/Web/Events/Creating_and_triggering_events

---

**Last Updated:** 2024
**Status:** ✅ Frontend Complete - Ready for API Integration
