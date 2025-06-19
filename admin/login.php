<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
echo "Session Durumu: " . session_status() . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Kayıt Yolu: " . session_save_path() . "<br>";

require_once '../config/database.php';
echo "Veritabanı bağlantısı denendi.<br>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST isteği alındı.<br>";
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "Gelen Kullanıcı Adı: " . htmlspecialchars($username) . "<br>";
    echo "Gelen Şifre: " . htmlspecialchars($password) . "<br>";

    // Örnek şifre hash'i oluşturma (test için)
    // echo "Test şifre (admin123) hash'i: " . password_hash('admin123', PASSWORD_DEFAULT) . "<br>";
    
    try {
        echo "Veritabanı sorgusu hazırlanıyor...<br>";
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user) {
            echo "Kullanıcı bulundu: " . htmlspecialchars($user['username']) . "<br>";
            echo "Veritabanındaki Hash: " . htmlspecialchars($user['password']) . "<br>";
            
            if (password_verify($password, $user['password'])) {
                echo "Şifre doğrulandı! Giriş başarılı.<br>";
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $user;
                
                echo "Session 'admin_logged_in' ayarlandı: " . $_SESSION['admin_logged_in'] . "<br>";
                
                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Şifre hatalı! (password_verify false döndü)";
                echo $error . "<br>";
            }
        } else {
            $error = "Kullanıcı adı bulunamadı!";
            echo $error . "<br>";
        }
    } catch(PDOException $e) {
        $error = "Giriş hatası: " . $e->getMessage();
        echo $error . "<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Erol Yılmaz</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .back-link {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-user-shield"></i></h1>
            <h1>Admin Girişi</h1>
            <p>Erol Yılmaz Web Sitesi Yönetimi</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Şifre</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Giriş Yap
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.html"><i class="fas fa-arrow-left"></i> Ana Sayfaya Dön</a>
        </div>
    </div>
</body>
</html> 