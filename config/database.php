<?php
// Veritabanı bağlantı ayarları
$host = "localhost";
$dbname = "erolyilmazofficial";
$username = "erol_user";
$password = "Erol120405.";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Site ayarları
define('SITE_URL', 'https://erolyilmazofficial.com'); // Sitenizin URL'sini buraya yazın
define('ADMIN_EMAIL', 'admin@erolyilmazofficial.com');
?> 