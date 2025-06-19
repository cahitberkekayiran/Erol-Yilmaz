<?php
require_once 'config/database.php';

// Verileri çek
try {
    $stmt = $pdo->query("SELECT * FROM page_content ORDER BY id");
    $pageContent = [];
    while ($row = $stmt->fetch()) {
        $pageContent[$row['section_name']] = $row;
    }
    
    $stmt = $pdo->query("SELECT * FROM contact_info ORDER BY id");
    $contactInfo = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM social_links ORDER BY id");
    $socialLinks = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM statistics ORDER BY id");
    $statistics = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT * FROM content_cards ORDER BY order_index");
    $contentCards = $stmt->fetchAll();
} catch(PDOException $e) {
    // Hata durumunda varsayılan değerler
    $pageContent = [];
    $contactInfo = [];
    $socialLinks = [];
    $statistics = [];
    $contentCards = [];
}
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageContent['hero']['title'] ?? 'Erol Yılmaz'); ?> - Resmi Web Sitesi</title>
    <link rel="icon" type="image/jpeg" href="erol-profile.jpg" />
    <link rel="apple-touch-icon" href="erol-profile.jpg" />
    <link rel="stylesheet" href="styles.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <nav class="navbar">
      <div class="nav-container">
        <div class="nav-logo">
          <h2><?php echo htmlspecialchars($pageContent['hero']['title'] ?? 'Erol Yılmaz'); ?></h2>
        </div>
        <div class="hamburger" id="hamburger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
        <ul class="nav-menu" id="desktopMenu">
          <li class="nav-item">
            <a href="#home" class="nav-link">Ana Sayfa</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">Hakkımda</a>
          </li>
          <li class="nav-item">
            <a href="#content" class="nav-link">İçerikler</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-link">İletişim</a>
          </li>
          <li class="nav-item">
            <a href="admin/login.php" class="nav-link" style="color: #ffd600; font-weight: 600;">Admin</a>
          </li>
        </ul>
      </div>
      <div class="mobile-menu" id="mobileMenu">
        <ul>
          <li><a href="#home">Ana Sayfa</a></li>
          <li><a href="#about">Hakkımda</a></li>
          <li><a href="#content">İçerikler</a></li>
          <li><a href="#contact">İletişim</a></li>
          <li><a href="admin/login.php" style="color: #ffd600; font-weight: 600;">Admin</a></li>
        </ul>
      </div>
    </nav>

    <section id="home" class="hero">
      <div class="hero-container">
        <div class="hero-content">
          <h1 class="hero-title"><?php echo htmlspecialchars($pageContent['hero']['title'] ?? 'Erol Yılmaz'); ?></h1>
          <p class="hero-subtitle"><?php echo htmlspecialchars($pageContent['hero']['subtitle'] ?? 'İçerik Üreticisi & Dijital Yaratıcı'); ?></p>
          <p class="hero-description">
            <?php echo htmlspecialchars($pageContent['hero']['description'] ?? 'Eğlenceli, bilgilendirici ve yaratıcı içeriklerle dijital dünyada iz bırakıyorum.'); ?>
          </p>

          <div
            class="platform-cards"
            style="
              display: flex;
              gap: 2rem;
              margin-top: 2.5rem;
              flex-wrap: wrap;
              justify-content: flex-start;
            "
          >
            <?php foreach ($socialLinks as $social): ?>
            <a
              href="<?php echo htmlspecialchars($social['url']); ?>"
              target="_blank"
              class="platform-card"
              style="
                background: #ffd600;
                color: #111;
                display: flex;
                align-items: center;
                gap: 1.2rem;
                padding: 2rem 2.5rem;
                border-radius: 2rem;
                font-size: 1.4rem;
                font-weight: 700;
                text-decoration: none;
                box-shadow: 0 4px 24px #ffd60022;
                transition: transform 0.2s, box-shadow 0.2s;
              "
            >
              <i class="<?php echo htmlspecialchars($social['icon']); ?>" style="font-size: 2.2rem"></i>
              <?php echo htmlspecialchars($social['display_name']); ?>'da Takip Et
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="hero-image">
          <div class="profile-placeholder">
            <img
              src="erol-profile.jpg"
              alt="<?php echo htmlspecialchars($pageContent['hero']['title'] ?? 'Erol Yılmaz'); ?>"
              style="
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid rgba(255, 255, 255, 0.2);
              "
            />
          </div>
        </div>
      </div>
    </section>

    <section id="about" class="about">
      <div class="container">
        <h2 class="section-title"><?php echo htmlspecialchars($pageContent['about']['title'] ?? 'Hakkımda'); ?></h2>
        <div class="about-content">
          <div class="about-text">
            <?php 
            $aboutContent = $pageContent['about']['content'] ?? '';
            $paragraphs = explode("\n\n", $aboutContent);
            foreach ($paragraphs as $paragraph) {
                if (trim($paragraph)) {
                    echo '<p>' . htmlspecialchars(trim($paragraph)) . '</p>';
                }
            }
            ?>
            <div class="stats">
              <?php foreach ($statistics as $stat): ?>
              <div class="stat-item">
                <h3><?php echo htmlspecialchars($stat['value']); ?></h3>
                <p><?php echo htmlspecialchars($stat['label']); ?></p>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="content" class="content">
      <div class="container">
        <h2 class="section-title"><?php echo htmlspecialchars($pageContent['content']['title'] ?? 'İçeriklerim'); ?></h2>
        <div class="content-grid">
          <?php foreach ($contentCards as $card): ?>
          <div class="content-card">
            <div class="content-icon">
              <i class="<?php echo htmlspecialchars($card['icon']); ?>"></i>
            </div>
            <h3><?php echo htmlspecialchars($card['title']); ?></h3>
            <p><?php echo htmlspecialchars($card['description']); ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="contact" class="contact">
      <div class="container">
        <h2 class="section-title"><?php echo htmlspecialchars($pageContent['contact']['title'] ?? 'İletişim'); ?></h2>
        <div class="contact-content">
          <div class="contact-info">
            <h3><?php echo htmlspecialchars($pageContent['contact']['subtitle'] ?? 'Benimle İletişime Geçin'); ?></h3>
            <p><?php echo htmlspecialchars($pageContent['contact']['description'] ?? 'Sorularınız, önerileriniz veya işbirliği teklifleriniz için aşağıdaki kanallardan ulaşabilirsiniz.'); ?></p>
            <div class="contact-links">
              <?php foreach ($contactInfo as $contact): ?>
              <a href="<?php echo $contact['type'] === 'email' ? 'mailto:' . htmlspecialchars($contact['value']) : htmlspecialchars($contact['value']); ?>" class="contact-link">
                <i class="<?php echo htmlspecialchars($contact['icon']); ?>"></i>
                <?php echo htmlspecialchars($contact['value']); ?>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-section">
            <h3><?php echo htmlspecialchars($pageContent['footer']['title'] ?? 'Erol Yılmaz'); ?></h3>
            <p><?php echo htmlspecialchars($pageContent['footer']['subtitle'] ?? 'İçerik üreticisi ve dijital yaratıcı'); ?></p>
          </div>
          <div class="footer-section">
            <h4>Sosyal Medya</h4>
            <div class="footer-social">
              <?php foreach ($socialLinks as $social): ?>
              <a href="<?php echo htmlspecialchars($social['url']); ?>" target="_blank">
                <i class="<?php echo htmlspecialchars($social['icon']); ?>"></i>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 <?php echo htmlspecialchars($pageContent['footer']['title'] ?? 'Erol Yılmaz'); ?>. Tüm hakları saklıdır.</p>
          <p class="developer-credit">
            Cahit Berke Kayıran tarafından yapılmıştır
          </p>
        </div>
      </div>
    </footer>

    <script src="script.js"></script>
  </body>
</html> 