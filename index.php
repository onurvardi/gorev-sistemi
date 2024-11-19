<?php
require 'config.php';
checkLogin();

$currentUser = getUser($db, $_SESSION['user_id']);

// İstatistikler
$stats = [
    'acil' => $db->query("SELECT COUNT(*) as sayi FROM basvurular WHERE oncelik = 'Acil' AND durum = 'Beklemede'")->fetch(PDO::FETCH_ASSOC),
    'bekleyen' => $db->query("SELECT COUNT(*) as sayi FROM basvurular WHERE durum = 'Beklemede'")->fetch(PDO::FETCH_ASSOC),
    'tamamlanan' => $db->query("SELECT COUNT(*) as sayi FROM basvurular WHERE durum = 'Tamamlandı'")->fetch(PDO::FETCH_ASSOC),
    'toplam' => $db->query("SELECT COUNT(*) as sayi FROM basvurular")->fetch(PDO::FETCH_ASSOC),
    'modem_satis' => $db->query("
        SELECT COUNT(*) as sayi, SUM(ei.fiyat) as toplam 
        FROM basvurular b 
        JOIN ek_islem_turleri ei ON b.ek_islem = ei.id 
        WHERE ei.islem_adi LIKE '%Modem%'
    ")->fetch(PDO::FETCH_ASSOC)
];

// Ekipler ve başvuruları
$ekipler = $db->query("
    SELECT e.*, 
           COUNT(b.id) as bekleyen_is 
    FROM ekipler e 
    LEFT JOIN basvurular b ON e.id = b.ekip_id AND b.durum = 'Beklemede'
    GROUP BY e.id
")->fetchAll(PDO::FETCH_ASSOC);

// Son başvurular (sadece bekleyenler)
$son_basvurular = $db->query("
    SELECT b.*, e.ekip_adi, k.kullanici_adi as islem_yapan
    FROM basvurular b 
    LEFT JOIN ekipler e ON b.ekip_id = e.id 
    LEFT JOIN kullanicilar k ON b.islem_yapan_id = k.id
    WHERE b.durum = 'Beklemede'
    ORDER BY b.basvuru_tarihi DESC 
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

$ek_islemler = $db->query("SELECT * FROM ek_islem_turleri")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toki1 Yönetim Sistemi</title>
    <link rel="stylesheet" href="assets/style.css?v=5.2">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-left">
                <h1>Toki1 Yönetim Sistemi</h1>
                <span class="user-info">Kullanıcı: <?= htmlspecialchars($currentUser['kullanici_adi']) ?></span>
            </div>
            <div class="header-right">
                <?php if ($currentUser['yetki'] == 'admin'): ?>
                    <a href="admin/index.php" class="admin-btn">Admin Panel</a>
                <?php endif; ?>
                <button class="add-button" onclick="yeniBasvuru()">+ Yeni Başvuru</button>
                <a href="logout.php" class="logout-btn">Çıkış</a>
            </div>
        </header>

        <div class="istatistik-kartlari">
            <a href="ek-islemler.php" class="istatistik-kart modem">
                <h3>Modem Satışları (Bugün) (Bugün)</h3>
                <span class="sayi"><?= $stats['modem_satis']['sayi'] ?></span>
                <small><?= number_format($stats['modem_satis']['toplam'], 2) ?> TL</small>
            </a>
            <div class="istatistik-kart acil">
                <h3>Acil İşler</h3>
                <span class="sayi"><?= $stats['acil']['sayi'] ?></span>
            </div>
            <div class="istatistik-kart bekleyen">
                <h3>Bekleyen İşler</h3>
                <span class="sayi"><?= $stats['bekleyen']['sayi'] ?></span>
            </div>
            <a href="tamamlanan.php" class="istatistik-kart tamamlanan">
                <h3>Tamamlanan</h3>
                <span class="sayi"><?= $stats['tamamlanan']['sayi'] ?></span>
            </a>
            <div class="istatistik-kart toplam">
                <h3>Toplam Başvuru</h3>
                <span class="sayi"><?= $stats['toplam']['sayi'] ?></span>
            </div>
        </div>

        <h2>Ekipler</h2>
        <div class="ekip-kartlari">
            <?php foreach($ekipler as $ekip): ?>
                <a href="ekip-panel.php?id=<?= $ekip['id'] ?>" class="ekip-kart">
                    <h3><?= htmlspecialchars($ekip['ekip_adi']) ?></h3>
                    <p>Bekleyen İş: <?= $ekip['bekleyen_is'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <h2>Bekleyen İşler</h2>
        <div class="basvuru-list">
            <?php foreach($son_basvurular as $basvuru): ?>
                <div class="basvuru-card <?= strtolower($basvuru['durum']) ?>">
                    <div class="basvuru-header">
                        <h3>
                            <?= htmlspecialchars($basvuru['ad_soyad']) ?>
                            <?php if(!$basvuru['ekip_id']): ?>
                                <span class="atanmadi-badge">Atanmadı</span>
                            <?php endif; ?>
                        </h3>
                        <span class="durum-badge <?= strtolower($basvuru['durum']) ?>">
                            <?= $basvuru['durum'] ?>
                        </span>
                    </div>
                    <div class="basvuru-body">
                        <p>📞 <?= htmlspecialchars($basvuru['telefon']) ?></p>
                        <p>📍 <?= htmlspecialchars($basvuru['sokak_no']) ?> Sk. No:<?= htmlspecialchars($basvuru['bina_no']) ?>/<?= htmlspecialchars($basvuru['daire_no']) ?></p>
                        <?php if($basvuru['ekip_id']): ?>
                            <p>👥 <?= htmlspecialchars($basvuru['ekip_adi']) ?></p>
                        <?php endif; ?>
                    </div>
                    <a href="#" onclick="basvuruDetay(<?= $basvuru['id'] ?>); return false;" class="detay-btn">Detay</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="assets/script.js?v=5.2"></script>
<button class="add-task" style="position: fixed; bottom: 20px; right: 20px;">+</button>
</body>
</html>
