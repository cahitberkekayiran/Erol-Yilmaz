<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';

echo "<h1>Admin Şifre Sıfırlama</h1>";

try {
    // Ayarlar
    $username = 'admin';
    $password = 'admin123';
    $email = 'admin@erolyilmazofficial.com';

    // Şifreyi hash'le
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (!$hashed_password) {
        throw new Exception("Şifre hash'lenemedi. PHP konfigürasyonunu kontrol edin.");
    }

    echo "<p><strong>Kullanıcı Adı:</strong> " . htmlspecialchars($username) . "</p>";
    echo "<p><strong>Yeni Şifre:</strong> " . htmlspecialchars($password) . "</p>";
    echo "<p><strong>Oluşturulan Hash:</strong> " . htmlspecialchars($hashed_password) . "</p>";

    // Kullanıcı var mı diye kontrol et
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Kullanıcı varsa, şifreyi güncelle
        echo "<p>Kullanıcı bulundu. Şifre güncelleniyor...</p>";
        $update_stmt = $pdo->prepare("UPDATE admin_users SET password = ? WHERE username = ?");
        $update_stmt->execute([$hashed_password, $username]);
        echo "<h3 style='color:green;'>Başarılı! 'admin' kullanıcısının şifresi güncellendi.</h3>";
    } else {
        // Kullanıcı yoksa, yeni kullanıcı oluştur
        echo "<p>Kullanıcı bulunamadı. Yeni admin kullanıcısı oluşturuluyor...</p>";
        $insert_stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES (?, ?, ?)");
        $insert_stmt->execute([$username, $hashed_password, $email]);
        echo "<h3 style='color:green;'>Başarılı! Yeni 'admin' kullanıcısı oluşturuldu.</h3>";
    }

    echo "<hr>";
    echo "<h2>ÖNEMLİ!</h2>";
    echo "<p style='color:red; font-weight:bold;'>Güvenlik nedeniyle bu dosyayı işiniz bittikten sonra sunucudan hemen silin!</p>";

} catch (Exception $e) {
    echo "<h3 style='color:red;'>Hata Oluştu!</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?> 