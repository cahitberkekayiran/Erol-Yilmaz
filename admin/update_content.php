<?php
session_start();
require_once '../config/database.php';

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $id = $_POST['id'] ?? '';
    
    try {
        switch ($type) {
            case 'page_content':
                $title = $_POST['title'] ?? '';
                $subtitle = $_POST['subtitle'] ?? '';
                $description = $_POST['description'] ?? '';
                $content = $_POST['content'] ?? '';
                
                $stmt = $pdo->prepare("UPDATE page_content SET title = ?, subtitle = ?, description = ?, content = ? WHERE id = ?");
                $stmt->execute([$title, $subtitle, $description, $content, $id]);
                break;
                
            case 'contact_info':
                $value = $_POST['value'] ?? '';
                $icon = $_POST['icon'] ?? '';
                
                $stmt = $pdo->prepare("UPDATE contact_info SET value = ?, icon = ? WHERE id = ?");
                $stmt->execute([$value, $icon, $id]);
                break;
                
            case 'social_links':
                $url = $_POST['url'] ?? '';
                $icon = $_POST['icon'] ?? '';
                $display_name = $_POST['display_name'] ?? '';
                
                $stmt = $pdo->prepare("UPDATE social_links SET url = ?, icon = ?, display_name = ? WHERE id = ?");
                $stmt->execute([$url, $icon, $display_name, $id]);
                break;
                
            case 'statistics':
                $value = $_POST['value'] ?? '';
                $label = $_POST['label'] ?? '';
                
                $stmt = $pdo->prepare("UPDATE statistics SET value = ?, label = ? WHERE id = ?");
                $stmt->execute([$value, $label, $id]);
                break;
                
            case 'content_cards':
                $title = $_POST['title'] ?? '';
                $description = $_POST['description'] ?? '';
                $icon = $_POST['icon'] ?? '';
                $order_index = $_POST['order_index'] ?? 0;
                
                $stmt = $pdo->prepare("UPDATE content_cards SET title = ?, description = ?, icon = ?, order_index = ? WHERE id = ?");
                $stmt->execute([$title, $description, $icon, $order_index, $id]);
                break;
                
            default:
                throw new Exception("Geçersiz içerik türü");
        }
        
        $_SESSION['success_message'] = "İçerik başarıyla güncellendi!";
        
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Güncelleme hatası: " . $e->getMessage();
    } catch(Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
    }
}

header('Location: dashboard.php');
exit;
?> 