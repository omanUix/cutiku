<?php
/**
 * Konfigurasi Telegram Bot
 * 
 * CARA SETUP TELEGRAM BOT:
 * 1. Buka Telegram dan cari @BotFather
 * 2. Kirim perintah /newbot
 * 3. Ikuti instruksi untuk membuat bot (nama dan username bot)
 * 4. BotFather akan memberikan TOKEN API
 * 5. Copy TOKEN tersebut dan paste di bawah ini
 * 6. Untuk mendapatkan Telegram ID karyawan, minta mereka kirim pesan ke @userinfobot
 */

// Ganti dengan TOKEN dari BotFather
define('TELEGRAM_BOT_TOKEN', '8058534069:AAGxGj_GY8j5d5SMFkdx3S8YPLV6AUcBfxI');

/**
 * Fungsi untuk mengirim pesan ke Telegram
 * 
 * @param string $chat_id - Telegram ID penerima
 * @param string $message - Pesan yang akan dikirim
 * @return bool - true jika berhasil, false jika gagal
 */
function sendTelegramNotification($chat_id, $message) {
    // Jika telegram_id kosong, skip
    if (empty($chat_id)) {
        return false;
    }
    
    $token = TELEGRAM_BOT_TOKEN;
    
    // Jika token belum diisi, skip
    if ($token == 'MASUKKAN_TOKEN_BOT_ANDA_DISINI' || empty($token)) {
        error_log("Telegram bot token belum dikonfigurasi");
        return false;
    }
    
    // Log untuk debugging
    error_log("Mencoba kirim Telegram ke chat_id: " . $chat_id);
    
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    
    $data = array(
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    );
    
    // Gunakan cURL untuk mengirim request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Cek apakah berhasil (HTTP 200)
    if ($http_code == 200) {
        return true;
    } else {
        error_log("Telegram notification gagal: " . $result);
        return false;
    }
}

/**
 * Fungsi untuk format pesan notifikasi cuti
 * 
 * @param array $data - Data pengajuan cuti
 * @return string - Pesan yang diformat
 */
function formatCutiNotification($data) {
    $status_emoji = $data['status'] == 'disetujui' ? '✅' : '❌';
    $status_text = $data['status'] == 'disetujui' ? 'DISETUJUI' : 'DITOLAK';
    
    $message = "<b>{$status_emoji} PENGAJUAN CUTI {$status_text}</b>\n\n";
    $message .= "Halo <b>{$data['nama_lengkap']}</b>,\n\n";
    $message .= "Pengajuan cuti Anda telah diproses:\n\n";
    $message .= "📋 <b>Jenis Cuti:</b> {$data['jenis_cuti']}\n";
    $message .= "📅 <b>Tanggal:</b> {$data['tanggal_mulai']} s/d {$data['tanggal_selesai']}\n";
    $message .= "⏱ <b>Durasi:</b> {$data['jumlah_hari']} hari\n";
    $message .= "📌 <b>Status:</b> {$status_text}\n";
    
    if (!empty($data['komentar_admin'])) {
        $message .= "\n💬 <b>Komentar Admin:</b>\n{$data['komentar_admin']}\n";
    }
    
    $message .= "\n---\n";
    $message .= "🏖️ <i>CutiKu - Sistem Manajemen Cuti</i>";
    
    return $message;
}
?>