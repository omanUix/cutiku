# 📘 Cutiku – Aplikasi Pengajuan Cuti Karyawan

**Cutiku** adalah aplikasi web pengajuan cuti karyawan berbasis **PHP dan MySQL** yang dirancang untuk memudahkan proses pengajuan, pengelolaan, dan persetujuan cuti secara digital. Aplikasi ini membantu menggantikan proses manual menjadi lebih terstruktur, efisien, dan terdokumentasi dengan baik.

## ✨ Fitur Utama

### 👤 User / Karyawan

* Login ke sistem
* Mengajukan cuti
* Melihat riwayat pengajuan cuti
* Melihat status cuti (menunggu, disetujui, ditolak)
* Notifikasi Pengajuan Cuti melalui telegram

### 🛠️ Admin / Atasan

* Login & logout admin
* Melihat seluruh pengajuan cuti
* Menyetujui atau menolak pengajuan cuti
* Manajemen data pengguna
* Monitoring data cuti karyawan

---

## 🧰 Teknologi yang Digunakan

* **Bahasa Pemrograman**: PHP (Native)
* **Database**: MySQL
* **Frontend**: HTML, CSS, JavaScript
* **Web Server**: Apache (XAMPP / Laragon)
* **Konfigurasi Server**: `.htaccess`

---

## ⚙️ Instalasi & Konfigurasi

1. **Clone repository**

   ```bash
   git clone https://github.com/username/cutiku.git
   ```

2. **Pindahkan ke folder server**

   ```
   htdocs/cutiku
   ```

3. **Buat database**

   * Buka `phpMyAdmin`
   * Buat database baru (misal: `cutiku_db`)
   * Import file database `.sql`

4. **Atur koneksi database**

   ```php
   $host = "localhost";
   $user = "root";
   $pass = "";
   $db   = "cutiku_db";
   ```

5. **Jalankan aplikasi**

   ```
   http://localhost/cutiku
   ```

---

## 🔐 Akun Default

> Sesuaikan dengan data pada database

**Admin**

* Username: admin
* Password: admin123

**User**

Daftar aja ya

---

## 🖼️ Screenshot Aplikasi

### 🔐 Halaman Login

<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/70794e53-0181-41fb-9761-6236862c9b8f" />


### 🏠 Dashboard Karyawan

<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/025c790d-61c1-4537-a6a4-359c6f71febf" />


### 📝 Pengajuan Cuti

<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/65875b07-ba3c-4c89-8c2c-4ae299d3e25a" />


### 📄 Riwayat Pengajuan

<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/08b25bc8-2aac-4023-864d-a5711f451af8" />

### Profile Karyawan
<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/847eb074-f1ed-4132-a0ae-7b723d492c58" />

### 🏠 Dashboard Admin
<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/a0bab2d9-ab0f-4664-9aa7-61dd73dd50e7" />


### ✅ Persetujuan Cuti (Admin / Atasan)

<img width="1366" height="768" alt="image" src="https://github.com/user-attachments/assets/14e294b2-088a-40b4-83a7-cd85fef3157d" />


### 👥 Manajemen Pengguna

<img width="1357" height="643" alt="image" src="https://github.com/user-attachments/assets/596e3a75-117b-42b5-a425-17ed6667f39b" />

### Laporan
<img width="1357" height="655" alt="image" src="https://github.com/user-attachments/assets/6274498a-c16c-459c-9b6e-da5eb0aaa9e7" />

### Notifikasi Persetujuan Cuti Telegram
<img width="293" height="651" alt="image" src="https://github.com/user-attachments/assets/886bf7c8-0f56-4649-82b9-d6c528866062" />


## 📄 Lisensi

Project ini dibuat untuk **keperluan pembelajaran dan pengembangan sistem informasi**.
Bebas digunakan dan dimodifikasi sesuai kebutuhan.

---
# 📱 Panduan Bot Telegram CutiKu

Dokumentasi lengkap tentang integrasi Bot Telegram dengan sistem manajemen cuti CutiKu.

## 📋 Daftar Isi
1. [Pengenalan Bot](#pengenalan-bot)
2. [Persiapan & Setup](#persiapan--setup)
3. [Panduan Karyawan](#panduan-karyawan)
4. [Panduan Admin](#panduan-admin)
5. [Troubleshooting](#troubleshooting)

---

## Pengenalan Bot

Bot Telegram CutiKu adalah fitur notifikasi otomatis yang memungkinkan:

✅ **Untuk Karyawan:**
- Menerima notifikasi pengajuan cuti disetujui/ditolak
- Pengingat cuti yang akan datang
- Update status perubahan cuti secara real-time

✅ **Untuk Admin:**
- Notifikasi pengajuan cuti baru dari karyawan
- Update persetujuan/penolakan cuti
- Monitoring pengajuan menunggu

---

## Persiapan & Setup

### Langkah 1: Buat Bot dengan @BotFather

1. **Buka Telegram** dan cari **@BotFather**
2. **Ketik `/newbot`** untuk membuat bot baru
3. **Beri nama bot** (contoh: "CutiKu Notifications Bot")
4. **Beri username** (contoh: "cutikuBot" atau "cutiku_notifications_bot")
5. **Simpan TOKEN** yang diberikan oleh @BotFather

Contoh token: `123456:ABCDefGhIjKlmnOpqRstUvwXYz`

### Langkah 2: Konfigurasi File telegram_config.php

Edit file `telegram_config.php` di root folder:

```php
<?php
// telegram_config.php
define('BOT_TOKEN', 'YOUR_BOT_TOKEN_HERE');
define('BOT_API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN);

// Fungsi mengirim pesan ke Telegram
function sendTelegramMessage($chat_id, $message) {
    $url = BOT_API_URL . '/sendMessage';
    $data = array(
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    );
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($result, true);
}

// Fungsi mengirim notifikasi (wrapper)
function notifyTelegram($karyawan_id, $message) {
    $conn = getConnection();
    $query = "SELECT telegram_id FROM karyawan WHERE id = $karyawan_id AND telegram_id IS NOT NULL";
    $result = mysqli_query($conn, $query);
    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return sendTelegramMessage($row['telegram_id'], $message);
    }
    return false;
}
?>
```

### Langkah 3: Test Bot

Jalankan `test_telegram.php` untuk memverifikasi koneksi:

```bash
php test_telegram.php
```

Hasil sukses akan menampilkan `"ok": true` dalam response JSON.

---

## Panduan Karyawan

### Cara Mendapatkan Telegram ID

1. **Buka Telegram** atau https://web.telegram.org
2. **Cari @userinfobot** di search
3. **Klik tombol Start** atau ketik `/start`
4. **Bot akan menampilkan:**
   ```
   Your user ID: 123456789
   Your first name: John
   Your username: @johndoe
   ```
5. **Copy angka ID** (123456789) - ini adalah Telegram ID Anda

### Cara Mengaktifkan Bot CutiKu

1. **Cari Bot CutiKu** (contoh: @cutikuBot) di Telegram
2. **Klik Start** atau ketik `/start`
3. **Bot akan merespons** dengan pesan sambutan
4. **Masuk ke Profil Saya** di dashboard CutiKu
5. **Cari field "Telegram ID"** di section "Data Kontak"
6. **Paste Telegram ID** Anda (contoh: 123456789)
7. **Klik "💾 Simpan Perubahan"**

### Notifikasi yang Akan Diterima

Setelah setup selesai, Anda akan menerima notifikasi untuk:

| Event | Deskripsi |
|-------|-----------|
| ✅ Pengajuan Disetujui | Ketika admin menyetujui pengajuan cuti Anda |
| ❌ Pengajuan Ditolak | Ketika admin menolak pengajuan cuti Anda |
| ⏰ Reminder Cuti | Pengingat sebelum cuti dimulai |
| 📝 Update Status | Perubahan status pengajuan cuti |

---

## Panduan Admin

### Setup Bot untuk Admin

1. Dapatkan Telegram ID admin Anda (lihat langkah karyawan)
2. Edit `telegram_config.php` dan tambahkan:
   ```php
   define('ADMIN_TELEGRAM_ID', 'TELEGRAM_ID_ADMIN_HERE');
   ```
3. Bot akan mengirim notifikasi pengajuan baru ke ID admin

### Fitur Admin

#### 📊 Dashboard Info Telegram
- Akses menu **📱 Info Telegram** di admin dashboard
- Lihat dokumentasi lengkap setup bot
- Checklist persiapan

#### 🔍 Monitoring Telegram ID Karyawan
Di **Kelola Karyawan**, admin bisa:
- Melihat kolom "Telegram ID" untuk setiap karyawan
- Mengedit Telegram ID jika diperlukan
- Mengidentifikasi karyawan yang belum mendaftar

#### 📤 Mengirim Notifikasi Manual
Admin bisa mengirim notifikasi manual dengan menambahkan kode:

```php
// Di halaman kelola_pengajuan.php atau proses_pengajuan.php
if ($action == 'approve') {
    // ... kode approve ...
    
    // Kirim notifikasi ke karyawan
    notifyTelegram($karyawan_id, 
        "✅ Pengajuan cuti Anda <b>disetujui</b>!\n\n" .
        "Periode: " . $tanggal_mulai . " - " . $tanggal_selesai . "\n" .
        "Jenis: " . $jenis_cuti
    );
}
```

---

## Troubleshooting

### Bot Tidak Mengirim Notifikasi

**Kemungkinan Penyebab & Solusi:**

1. **TOKEN bot salah/belum diisi**
   - Periksa token di `telegram_config.php`
   - Pastikan format: `123456:ABCDefGhIjKlmnOpqRstUvwXYz`

2. **Server tidak bisa akses internet**
   - Periksa firewall/proxy server
   - Pastikan curl enabled di PHP

3. **Karyawan belum input Telegram ID**
   - Bagikan link "📱 Info Telegram" ke karyawan
   - Verifikasi di "Kelola Karyawan"

4. **Karyawan belum chat /start ke bot**
   - Bot perlu karyawan chat dulu sebelum bisa kirim pesan
   - Pastikan karyawan sudah klik "Start" di bot CutiKu

5. **Telegram ID tidak valid**
   - Cek menggunakan @userinfobot
   - Pastikan format hanya angka (contoh: 123456789)

### Cara Debug

Tambahkan logging di telegram_config.php:

```php
function sendTelegramMessage($chat_id, $message) {
    // ... kode sebelumnya ...
    
    $result = curl_exec($curl);
    curl_close($curl);
    
    // Log hasil
    error_log("Telegram Send: " . $result);
    
    return json_decode($result, true);
}
```

Periksa error log di `php_errors.log` atau `error.log`

### Reset Telegram ID Karyawan

Jika perlu reset:
1. Buka "Kelola Karyawan"
2. Cari karyawan yang ingin direset
3. Klik tombol "Edit"
4. Kosongkan field "Telegram ID"
5. Klik "Simpan"

---

## Link Penting

| Sumber | URL |
|--------|-----|
| Telegram Bot API | https://core.telegram.org/bots/api |
| @BotFather | https://t.me/BotFather |
| @userinfobot | https://t.me/userinfobot |
| Webhook Setup | https://core.telegram.org/bots/webhooks |

---

## FAQ

**Q: Apakah gratis?**
A: Ya, Telegram Bot API sepenuhnya gratis.

**Q: Harus install library tambahan?**
A: Tidak, hanya menggunakan curl built-in di PHP.

**Q: Bot bisa reply ke karyawan?**
A: Ya, bisa dengan webhook atau polling (documentasi di Telegram Bot API).

**Q: Berapa lama notifikasi terkirim?**
A: Biasanya kurang dari 1 detik setelah event terjadi.

**Q: Bisa custom pesan notifikasi?**
A: Ya, edit template pesan di `telegram_config.php` atau di setiap proses.

---

## Kontribusi & Update

Untuk update atau laporan bug, hubungi tim IT/HR melalui:
- 📧 Email: admin@cutiku.local
- 💬 Chat: Internal Chat System
- 📱 WhatsApp: Hub. Admin

---

**Versi Dokumentasi: 1.0**  
**Last Updated: 2025-12-28**

