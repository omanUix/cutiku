<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = cleanInput($_POST['username']);
    $password = md5($_POST['password']);
    
    $conn = getConnection();
    $query = "SELECT u.*, k.nama_lengkap, k.id as karyawan_id 
              FROM users u 
              LEFT JOIN karyawan k ON u.id = k.user_id 
              WHERE u.username = '$username' AND u.password = '$password'";
    
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['karyawan_id'] = $user['karyawan_id'];
        
        if ($user['role'] == 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: karyawan/dashboard.php');
        }
        exit();
    } else {
        $error = 'Username atau password salah!';
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - CutiKu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        /* Left Section */
        .left-section {
            background: linear-gradient(180deg, #e8f0fe 0%, #d4e7f7 100%);
            padding: 80px 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
            margin-bottom: 60px;
        }
        
        .brand-icon {
            font-size: 40px;
            margin-right: 12px;
        }
        
        .brand-name {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .welcome-emoji {
            font-size: 120px;
            margin-bottom: 40px;
            animation: party 2s ease-in-out infinite;
        }
        
        @keyframes party {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(-10deg) scale(1.05); }
            75% { transform: rotate(10deg) scale(1.05); }
        }
        
        .welcome-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        
        .welcome-subtitle {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 40px;
        }
        
        .divider {
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, #3b82f6 0%, transparent 100%);
            margin-bottom: 40px;
        }
        
        .promo-badge {
            display: inline-block;
            color: #3b82f6;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 12px;
        }
        
        .promo-text {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .features {
            list-style: none;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            color: #1a1a1a;
            font-size: 15px;
        }
        
        .feature-item::before {
            content: "✓";
            color: #10b981;
            font-weight: 700;
            font-size: 18px;
            margin-right: 12px;
        }
        
        /* Right Section */
        .right-section {
            background: white;
            padding: 80px 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-header {
            margin-bottom: 10px;
        }
        
        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 40px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group input {
            width: 100%;
            padding: 16px 18px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            color: #1a1a1a;
            background: white;
            transition: all 0.2s;
        }
        
        .form-group input::placeholder {
            color: #9ca3af;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-login:hover {
            background: #2563eb;
        }
        
        .btn-login:active {
            transform: scale(0.98);
        }
        
        .divider-text {
            text-align: center;
            color: #9ca3af;
            font-size: 14px;
            margin: 30px 0;
            position: relative;
        }
        
        .divider-text::before,
        .divider-text::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #e5e7eb;
        }
        
        .divider-text::before {
            left: 0;
        }
        
        .divider-text::after {
            right: 0;
        }
        
        .social-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 30px;
        }
        
        .btn-social {
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #4a5568;
        }
        
        .btn-social:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .terms-text {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            text-align: center;
        }
        
        .terms-text a {
            color: #3b82f6;
            text-decoration: none;
        }
        
        .terms-text a:hover {
            text-decoration: underline;
        }
        
        .demo-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .demo-info h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 12px;
        }
        
        .demo-info p {
            font-size: 13px;
            color: #4b5563;
            line-height: 1.6;
            margin: 4px 0;
        }
        
        .demo-info strong {
            color: #1e40af;
            font-weight: 600;
        }
        
        @media (max-width: 1024px) {
            body {
                grid-template-columns: 1fr;
            }
            
            .left-section,
            .right-section {
                padding: 60px 40px;
            }
            
            .left-section {
                display: none;
            }
        }
        
        @media (max-width: 640px) {
            .right-section {
                padding: 40px 24px;
            }
            
            .login-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Left Section -->
    <div class="left-section">
        <div class="brand-logo">
            <span class="brand-icon">🏖️</span>
            <span class="brand-name">CutiKu</span>
        </div>
        
        <div class="welcome-emoji">🎉</div>
        
        <h1 class="welcome-title">Selamat Tinggal, Kerjaan Menumpuk.</h1>
        <h2 class="welcome-subtitle">Selamat Datang, CutiKu.</h2>
        
        <div class="divider"></div>
        
        <p class="promo-badge">Paket gratis!</p>
        <p class="promo-text">Tidak memerlukan kartu kredit<br>Ideal untuk individu dan tim kecil yang mengeksplorasi CutiKu</p>
        
        <ul class="features">
            <li class="feature-item">Hingga 20 pengguna</li>
            <li class="feature-item">18 bulan riwayat cuti</li>
            <li class="feature-item">Notifikasi Telegram yang aman dan dapat kustomisasi</li>
            <li class="feature-item">Dashboard real-time</li>
            <li class="feature-item">Penyimpanan 100 GB</li>
        </ul>
    </div>
    
    <!-- Right Section -->
    <div class="right-section">
        <div class="login-header">
            <h1 class="login-title">Masuk ke Akun Anda</h1>
        </div>
        

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        
        <div class="divider-text">Atau lanjutkan dengan</div>
        
        <div class="social-buttons">
            <button class="btn-social">📱 Telepon</button>
            <button class="btn-social">🔍 Google</button>
            <button class="btn-social">🍎 Apple</button>
        </div>
        
        <p class="terms-text">
            Dengan melanjutkan, Anda menyetujui <a href="#">Ketentuan Layanan Pengguna</a> dan <a href="#">Ketentuan Layanan Pelanggan</a> kami, dan mengakui bahwa Anda telah membaca <a href="#">Kebijakan Privasi</a> untuk mempelajari cara kami mengumpulkan, menggunakan, dan membagikan data Anda.
        </p>
    </div>
</body>
</html>