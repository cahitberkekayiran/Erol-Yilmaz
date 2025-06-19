<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';

try {
    $response = [];
    
    // Sayfa içeriklerini al
    $stmt = $pdo->query("SELECT * FROM page_content ORDER BY id");
    $response['page_content'] = $stmt->fetchAll();
    
    // İletişim bilgilerini al
    $stmt = $pdo->query("SELECT * FROM contact_info ORDER BY id");
    $response['contact_info'] = $stmt->fetchAll();
    
    // Sosyal medya linklerini al
    $stmt = $pdo->query("SELECT * FROM social_links ORDER BY id");
    $response['social_links'] = $stmt->fetchAll();
    
    // İstatistikleri al
    $stmt = $pdo->query("SELECT * FROM statistics ORDER BY id");
    $response['statistics'] = $stmt->fetchAll();
    
    // İçerik kartlarını al
    $stmt = $pdo->query("SELECT * FROM content_cards ORDER BY order_index");
    $response['content_cards'] = $stmt->fetchAll();
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Veritabanı hatası: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?> 