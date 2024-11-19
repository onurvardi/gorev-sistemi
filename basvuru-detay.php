<?php
require 'config.php';
checkLogin();

$id = $_GET['id'] ?? 0;
$modal = isset($_GET['modal']) ? true : false;

$basvuru = $db->query("
    SELECT b.*, e.ekip_adi, k.kullanici_adi as islem_yapan
    FROM basvurular b 
    LEFT JOIN ekipler e ON b.ekip_id = e.id 
    LEFT JOIN kullanicilar k ON b.islem_yapan_id = k.id
    WHERE b.id = $id
")->fetch(PDO::FETCH_ASSOC);

$ekipler = $db->query("SELECT * FROM ekipler")->fetchAll(PDO::FETCH_ASSOC);
$islem_loglar = $db->query("
    SELECT l.*, k.kullanici_adi
    FROM islem_loglar l
    JOIN kullanicilar k ON l.kullanici_id = k.id
    WHERE l.basvuru_id = $id
    ORDER BY l.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

if ($modal) {
    // Modal görünüm için HTML
?>
    <div class="detay-content">
        <h2><?= htmlspecialchars($basvuru['ad_soyad']) ?></h2>
        
        <div class="detay-grid">
            <div class="detay-item">
                <label>Telefon:</label>
                <span><?= htmlspecialchars($basvuru['telefon']) ?></span>
            </div>
            <div class="detay-item">
                <label>Adres:</label>
                <span>
                    Sokak: <?= htmlspecialchars($basvuru['sokak_no']) ?>,
                    Bina: <?= htmlspecialchars($basvuru['bina_no']) ?>,
                    Daire: <?= htmlspecialchars($basvuru['daire_no']) ?>
                </span>
            </div>
            <div class="detay-item">
                <label>Durum:</label>
                <span class="durum-badge <?= strtolower($basvuru['durum']) ?>">
                    <?= $basvuru['durum'] ?>
                </span>
            </div>
            <div class="detay-item">
                <label>Ekip Ataması:</label>
                <select id="ekipSelect" onchange="ekipAta(<?= $id ?>, this.value)" <?= $basvuru['durum'] != 'Beklemede' ? 'disabled' : '' ?>>
                    <option value="">Ekip Seçin</option>
                    <?php foreach($ekipler as $ekip): ?>
                        <option value="<?= $ekip['id'] ?>" <?= $ekip['id'] == $basvuru['ekip_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ekip['ekip_adi']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="timeline">
            <?php foreach($islem_loglar as $log): ?>
                <div class="timeline-item">
                    <span class="time"><?= date('d.m.Y H:i', strtotime($log['created_at'])) ?></span>
                    <span class="event"><?= htmlspecialchars($log['aciklama']) ?></span>
                    <small>İşlemi yapan: <?= htmlspecialchars($log['kullanici_adi']) ?></small>
                </div>
            <?php endforeach; ?>
            <div class="timeline-item">
                <span class="time"><?= date('d.m.Y H:i', strtotime($basvuru['basvuru_tarihi'])) ?></span>
                <span class="event">Başvuru alındı</span>
            </div>
        </div>
    </div>
<?php
} else {
    // Tam sayfa görünüm için HTML
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Detayı - Toki1 Yönetim Sistemi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Başvuru Detayı</h1>
            <a href="index.php" class="geri-btn">← Ana Sayfa</a>
        </header>

        <div class="detay-card">
            <!-- Yukarıdaki detay içeriğinin aynısı -->
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
<?php
}
?>
