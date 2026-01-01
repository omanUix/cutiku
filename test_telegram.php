<?php
require_once 'telegram_config.php';

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Telegram Bot - CutiKu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h2 {
            color: #667eea;
            margin: 20px 0 15px 0;
            font-size: 18px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 8px;
        }
        
        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            font-weight: 500;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .status-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .info-item {
            padding: 10px;
            background: #f8f9fa;
            margin: 8px 0;
            border-radius: 5px;
            font-family: monospace;
        }
        
        .form-group {
            margin: 20px 0;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        
        pre {
            background: #2d2d2d;
            color: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔧 Test Telegram Bot & cURL</h1>
            
            <h2>1️⃣ Cek PHP cURL Extension</h2>
            <?php
            if (function_exists('curl_version')) {
                $curl_info = curl_version();
                echo '<div class="status status-success">✅ cURL AKTIF</div>';
                echo '<div class="info-item">Versi cURL: ' . $curl_info['version'] . '</div>';
                echo '<div class="info-item">SSL Versi: ' . $curl_info['ssl_version'] . '</div>';
            } else {
                echo '<div class="status status-error">❌ cURL TIDAK AKTIF</div>';
                echo '<div class="status-info">Cara mengaktifkan cURL:';
                echo '<ol style="margin: 10px 0 0 20px;">';
                echo '<li>Buka file <code>php.ini</code></li>';
                echo '<li>Cari baris <code>;extension=curl</code></li>';
                echo '<li>Hapus tanda <code>;</code> di depannya</li>';
                echo '<li>Restart Apache/Nginx</li>';
                echo '</ol></div>';
            }
            ?>
            
            <h2>2️⃣ Cek Konfigurasi Token Bot</h2>
            <?php
            $token = TELEGRAM_BOT_TOKEN;
            if ($token == 'MASUKKAN_TOKEN_BOT_ANDA_DISINI' || empty($token)) {
                echo '<div class="status status-error">❌ Token belum dikonfigurasi</div>';
                echo '<p>Buka file <code>telegram_config.php</code> dan masukkan token dari @BotFather</p>';
            } else {
                echo '<div class="status status-success">✅ Token sudah dikonfigurasi</div>';
                echo '<div class="info-item">Token: ' . substr($token, 0, 15) . '...' . substr($token, -10) . '</div>';
            }
            ?>
            
            <h2>3️⃣ Test Koneksi ke Telegram API</h2>
            <?php
            if (function_exists('curl_version') && $token != 'MASUKKAN_TOKEN_BOT_ANDA_DISINI') {
                $url = "https://api.telegram.org/bot{$token}/getMe";
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                
                $result = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                
                if ($http_code == 200) {
                    $bot_info = json_decode($result, true);
                    if ($bot_info['ok']) {
                        echo '<div class="status status-success">✅ Koneksi ke Telegram API BERHASIL</div>';
                        echo '<div class="info-item">Nama Bot: ' . $bot_info['result']['first_name'] . '</div>';
                        echo '<div class="info-item">Username Bot: @' . $bot_info['result']['username'] . '</div>';
                        echo '<div class="info-item">Bot ID: ' . $bot_info['result']['id'] . '</div>';
                    } else {
                        echo '<div class="status status-error">❌ Token tidak valid</div>';
                        echo '<pre>' . $result . '</pre>';
                    }
                } else {
                    echo '<div class="status status-error">❌ Gagal koneksi ke Telegram API (HTTP ' . $http_code . ')</div>';
                    echo '<pre>' . $result . '</pre>';
                }
            } else {
                echo '<div class="status status-info">⚠️ Tidak bisa test koneksi (cURL tidak aktif atau token belum dikonfigurasi)</div>';
            }
            ?>
            
            <h2>4️⃣ Test Kirim Pesan</h2>
            <div class="status status-info">
                <strong>📌 Cara test:</strong>
                <ol style="margin: 10px 0 0 20px; line-height: 1.8;">
                    <li>Dapatkan Telegram ID Anda dari <code>@userinfobot</code></li>
                    <li>Pastikan Anda sudah <strong>START</strong> bot Anda (<code>@cutiku_bot</code>)</li>
                    <li>Masukkan Telegram ID Anda di form di bawah</li>
                    <li>Klik "Kirim Test Pesan"</li>
                    <li>Cek Telegram Anda, harusnya ada pesan masuk</li>
                </ol>
            </div>
            
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['test_send'])) {
                $test_chat_id = trim($_POST['telegram_id']);
                
                if (!empty($test_chat_id) && function_exists('curl_version')) {
                    $test_message = "🎉 <b>TEST BERHASIL!</b>\n\n";
                    $test_message .= "Bot Telegram CutiKu sudah berfungsi dengan baik!\n\n";
                    $test_message .= "✅ Token: Valid\n";
                    $test_message .= "✅ cURL: Aktif\n";
                    $test_message .= "✅ Koneksi: Berhasil\n\n";
                    $test_message .= "Sekarang bot siap mengirim notifikasi cuti ke karyawan.\n\n";
                    $test_message .= "---\n";
                    $test_message .= "🏖️ <i>CutiKu - Sistem Manajemen Cuti</i>";
                    
                    $result = sendTelegramNotification($test_chat_id, $test_message);
                    
                    if ($result) {
                        echo '<div class="status status-success">✅ Pesan BERHASIL dikirim! Cek Telegram Anda.</div>';
                    } else {
                        echo '<div class="status status-error">❌ Gagal mengirim pesan</div>';
                        echo '<p><strong>Kemungkinan penyebab:</strong></p>';
                        echo '<ul style="margin-left: 20px;">';
                        echo '<li>Telegram ID salah atau tidak valid</li>';
                        echo '<li>Anda belum <strong>START</strong> bot di Telegram</li>';
                        echo '<li>Bot di-block oleh user</li>';
                        echo '</ul>';
                    }
                }
            }
            ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Telegram ID Anda:</label>
                    <input type="text" name="telegram_id" placeholder="Contoh: 123456789" required>
                    <small style="color: #666; display: block; margin-top: 5px;">
                        Dapatkan dari @userinfobot di Telegram
                    </small>
                </div>
                <button type="submit" name="test_send" class="btn">📤 Kirim Test Pesan</button>
            </form>
            
            <h2>5️⃣ Kesimpulan</h2>
            <?php
            $all_ok = true;
            $problems = [];
            
            if (!function_exists('curl_version')) {
                $all_ok = false;
                $problems[] = 'cURL tidak aktif';
            }
            
            if ($token == 'MASUKKAN_TOKEN_BOT_ANDA_DISINI' || empty($token)) {
                $all_ok = false;
                $problems[] = 'Token belum dikonfigurasi';
            }
            
            if ($all_ok) {
                echo '<div class="status status-success">';
                echo '<strong>🎉 SEMUA SIAP!</strong><br>';
                echo 'Bot Telegram sudah dikonfigurasi dengan benar dan siap digunakan.';
                echo '</div>';
            } else {
                echo '<div class="status status-error">';
                echo '<strong>⚠️ ADA MASALAH:</strong><br>';
                foreach ($problems as $problem) {
                    echo '• ' . $problem . '<br>';
                }
                echo '</div>';
            }
            ?>
            
            <div style="margin-top: 30px; text-align: center;">
                <a href="login.php" style="color: #667eea; text-decoration: none; font-weight: 600;">
                    ← Kembali ke Aplikasi
                </a>
            </div>
        </div>
    </div>
</body>
</html>