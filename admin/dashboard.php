<?php
session_start();
require_once '../config/database.php';

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}

// Verileri çek
try {
    $stmt = $pdo->query("SELECT * FROM page_content ORDER BY id");
    $pageContent = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM contact_info ORDER BY id");
    $contactInfo = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM social_links ORDER BY id");
    $socialLinks = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM statistics ORDER BY id");
    $statistics = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM content_cards ORDER BY order_index");
    $contentCards = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Veri çekme hatası: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Erol Yılmaz</title>
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
            background: #f5f7fa;
            color: #333;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            font-size: 1.5rem;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .section {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section h2 {
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e1e5e9;
            border-radius: 5px;
            font-size: 1rem;
            font-family: inherit;
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: transform 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .tabs {
            display: flex;
            border-bottom: 2px solid #e1e5e9;
            margin-bottom: 2rem;
        }
        
        .tab {
            padding: 1rem 2rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }
        
        .tab.active {
            border-bottom-color: #667eea;
            color: #667eea;
            font-weight: 600;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-cog"></i> Admin Dashboard</h1>
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Çıkış Yap
        </a>
    </div>
    
    <div class="container">
        <div class="tabs">
            <div class="tab active" onclick="showTab('content')">Sayfa İçerikleri</div>
            <div class="tab" onclick="showTab('contact')">İletişim Bilgileri</div>
            <div class="tab" onclick="showTab('social')">Sosyal Medya</div>
            <div class="tab" onclick="showTab('stats')">İstatistikler</div>
            <div class="tab" onclick="showTab('cards')">İçerik Kartları</div>
        </div>
        
        <!-- Sayfa İçerikleri -->
        <div id="content" class="tab-content active">
            <div class="section">
                <h2><i class="fas fa-file-alt"></i> Sayfa İçerikleri</h2>
                <?php foreach ($pageContent as $content): ?>
                <form method="POST" action="update_content.php">
                    <input type="hidden" name="type" value="page_content">
                    <input type="hidden" name="id" value="<?php echo $content['id']; ?>">
                    
                    <div class="card">
                        <h3><?php echo htmlspecialchars($content['section_name']); ?></h3>
                        
                        <div class="form-group">
                            <label>Başlık</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($content['title']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Alt Başlık</label>
                            <input type="text" name="subtitle" value="<?php echo htmlspecialchars($content['subtitle']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Açıklama</label>
                            <textarea name="description"><?php echo htmlspecialchars($content['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>İçerik</label>
                            <textarea name="content"><?php echo htmlspecialchars($content['content']); ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Güncelle
                        </button>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- İletişim Bilgileri -->
        <div id="contact" class="tab-content">
            <div class="section">
                <h2><i class="fas fa-envelope"></i> İletişim Bilgileri</h2>
                <?php foreach ($contactInfo as $contact): ?>
                <form method="POST" action="update_content.php">
                    <input type="hidden" name="type" value="contact_info">
                    <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                    
                    <div class="card">
                        <h3><?php echo htmlspecialchars($contact['type']); ?></h3>
                        
                        <div class="form-group">
                            <label>Değer</label>
                            <input type="text" name="value" value="<?php echo htmlspecialchars($contact['value']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>İkon</label>
                            <input type="text" name="icon" value="<?php echo htmlspecialchars($contact['icon']); ?>">
                        </div>
                        
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Güncelle
                        </button>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Sosyal Medya -->
        <div id="social" class="tab-content">
            <div class="section">
                <h2><i class="fas fa-share-alt"></i> Sosyal Medya Linkleri</h2>
                <?php foreach ($socialLinks as $social): ?>
                <form method="POST" action="update_content.php">
                    <input type="hidden" name="type" value="social_links">
                    <input type="hidden" name="id" value="<?php echo $social['id']; ?>">
                    
                    <div class="card">
                        <h3><?php echo htmlspecialchars($social['platform']); ?></h3>
                        
                        <div class="form-group">
                            <label>URL</label>
                            <input type="url" name="url" value="<?php echo htmlspecialchars($social['url']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>İkon</label>
                            <input type="text" name="icon" value="<?php echo htmlspecialchars($social['icon']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Görünen Ad</label>
                            <input type="text" name="display_name" value="<?php echo htmlspecialchars($social['display_name']); ?>">
                        </div>
                        
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Güncelle
                        </button>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- İstatistikler -->
        <div id="stats" class="tab-content">
            <div class="section">
                <h2><i class="fas fa-chart-bar"></i> İstatistikler</h2>
                <?php foreach ($statistics as $stat): ?>
                <form method="POST" action="update_content.php">
                    <input type="hidden" name="type" value="statistics">
                    <input type="hidden" name="id" value="<?php echo $stat['id']; ?>">
                    
                    <div class="card">
                        <h3><?php echo htmlspecialchars($stat['name']); ?></h3>
                        
                        <div class="form-group">
                            <label>Değer</label>
                            <input type="text" name="value" value="<?php echo htmlspecialchars($stat['value']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Etiket</label>
                            <input type="text" name="label" value="<?php echo htmlspecialchars($stat['label']); ?>">
                        </div>
                        
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Güncelle
                        </button>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- İçerik Kartları -->
        <div id="cards" class="tab-content">
            <div class="section">
                <h2><i class="fas fa-th-large"></i> İçerik Kartları</h2>
                <?php foreach ($contentCards as $card): ?>
                <form method="POST" action="update_content.php">
                    <input type="hidden" name="type" value="content_cards">
                    <input type="hidden" name="id" value="<?php echo $card['id']; ?>">
                    
                    <div class="card">
                        <h3>Kart #<?php echo $card['order_index']; ?></h3>
                        
                        <div class="form-group">
                            <label>Başlık</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($card['title']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Açıklama</label>
                            <textarea name="description"><?php echo htmlspecialchars($card['description']); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>İkon</label>
                            <input type="text" name="icon" value="<?php echo htmlspecialchars($card['icon']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Sıra</label>
                            <input type="number" name="order_index" value="<?php echo $card['order_index']; ?>">
                        </div>
                        
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Güncelle
                        </button>
                    </div>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <script>
        function showTab(tabName) {
            // Tüm tabları gizle
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Tüm tab butonlarını pasif yap
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Seçilen tabı göster
            document.getElementById(tabName).classList.add('active');
            
            // Seçilen tab butonunu aktif yap
            event.target.classList.add('active');
        }
    </script>
</body>
</html> 