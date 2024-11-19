<?php
require 'config.php';
checkLogin();

$currentUser = getUser($db, $_SESSION['user_id']);

// Acil başvuruları al
$acil_basvurular = $db->query("
    SELECT b.*, e.ekip_adi, k.kullanici_adi as islem_yapan 
    FROM basvurular b
    LEFT JOIN ekipler e ON b.ekip_id = e.id
    LEFT JOIN kullanicilar k ON b.islem_yapan_id = k.id
    WHERE b.oncelik = 'Acil' AND b.durum = 'Beklemede'
    ORDER BY b.basvuru_tarihi DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acil Başvurular</title>
    <link rel="stylesheet" href="assets/style.css?v=5.2">
</head>
<body>
    <div class="container">
        <header>
            <h1>Acil Başvurular</h1>
            <a href="index.php" class="back-btn">← Ana Sayfa</a>
        </header>

        <div class="basvuru-list">
            <?php if (count($acil_basvurular) > 0): ?>
                <?php foreach ($acil_basvurular as $basvuru): ?>
                    <div class="basvuru-card <?= strtolower($basvuru['durum']) ?>">
                        <div class="basvuru-header">
                            <h3><?= htmlspecialchars($basvuru['ad_soyad']) ?></h3>
                            <span class="durum-badge"><?= htmlspecialchars($basvuru['durum']) ?></span>
                        </div>
                        <div class="basvuru-body">
                            <p>📞 <?= htmlspecialchars($basvuru['telefon']) ?></p>
                            <p>📍 <?= htmlspecialchars($basvuru['sokak_no']) ?> Sk. No:<?= htmlspecialchars($basvuru['bina_no']) ?>/<?= htmlspecialchars($basvuru['daire_no']) ?></p>
                            <?php if ($basvuru['ekip_id']): ?>
                                <p>👥 <?= htmlspecialchars($basvuru['ekip_adi']) ?></p>
                            <?php endif; ?>
                        </div>
                        <p>İşlem Yapan: <?= htmlspecialchars($basvuru['islem_yapan'] ?? 'Bilinmiyor') ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Acil başvuru bulunmamaktadır.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
