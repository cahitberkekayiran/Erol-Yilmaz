-- Erol Yılmaz Website Database
-- Database: erolyilmazofficial

USE erolyilmazofficial;

-- Ana sayfa içerikleri tablosu
CREATE TABLE IF NOT EXISTS page_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_name VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    description TEXT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- İletişim bilgileri tablosu
CREATE TABLE IF NOT EXISTS contact_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    value VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sosyal medya linkleri tablosu
CREATE TABLE IF NOT EXISTS social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    display_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- İstatistikler tablosu
CREATE TABLE IF NOT EXISTS statistics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    value VARCHAR(50) NOT NULL,
    label VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- İçerik kartları tablosu
CREATE TABLE IF NOT EXISTS content_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(50),
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Admin kullanıcılar tablosu
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Örnek veriler ekleme
INSERT INTO page_content (section_name, title, subtitle, description, content) VALUES
('hero', 'Erol Yılmaz', 'İçerik Üreticisi & Dijital Yaratıcı', 'Eğlenceli, bilgilendirici ve yaratıcı içeriklerle dijital dünyada iz bırakıyorum.', ''),
('about', 'Hakkımda', '', '', 'Merhaba! Ben Erol Yılmaz. Dijital dünyada yaratıcı içerikler üretiyorum ve insanlarla etkileşim kurmayı seviyorum. Eğlenceli videolar, bilgilendirici içerikler ve günlük hayatımdan kesitler paylaşıyorum.\n\nSosyal medya platformlarında aktif olarak içerik üretiyorum ve takipçilerimle sürekli iletişim halindeyim. Amacım insanlara değer katmak ve eğlenceli anlar yaşatmak.'),
('content', 'İçeriklerim', '', '', ''),
('contact', 'İletişim', 'Benimle İletişime Geçin', 'Sorularınız, önerileriniz veya işbirliği teklifleriniz için aşağıdaki kanallardan ulaşabilirsiniz.', ''),
('footer', 'Erol Yılmaz', 'İçerik üreticisi ve dijital yaratıcı', '', '');

INSERT INTO contact_info (type, value, icon) VALUES
('email', 'contact@erolyilmazofficial.com', 'fas fa-envelope'),
('instagram', '@erolyilmazofficial', 'fab fa-instagram');

INSERT INTO social_links (platform, url, icon, display_name) VALUES
('instagram', 'https://www.instagram.com/erolyilmazofficial/', 'fab fa-instagram', 'Instagram'),
('tiktok', 'https://tiktok.com/@erolyilmazofficial', 'fab fa-tiktok', 'TikTok'),
('youtube', 'https://www.youtube.com/@erolyilmazofficial', 'fab fa-youtube', 'YouTube');

INSERT INTO statistics (name, value, label) VALUES
('followers', '100K+', 'Takipçi'),
('videos', '20+', 'Video'),
('platforms', '3', 'Platform');

INSERT INTO content_cards (title, description, icon, order_index) VALUES
('Video İçerikler', 'Eğlenceli ve bilgilendirici videolar ile günlük hayatımdan kesitler paylaşıyorum.', 'fas fa-video', 1),
('Komedi', 'Günlük hayatın komik anlarını yakalayıp sizlerle paylaşıyorum.', 'fas fa-laugh', 2),
('İpuçları', 'Hayatı kolaylaştıran pratik ipuçları ve öneriler sunuyorum.', 'fas fa-lightbulb', 3);

-- Admin kullanıcı oluşturma (şifre: admin123)
INSERT INTO admin_users (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@erolyilmazofficial.com'); 