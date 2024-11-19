<?php
require 'config.php';
checkLogin();

$currentUser = getUser($db, $_SESSION['user_id']);

// Bugünkü modem satışlarını al
$bugunku_modem_satislari = $db->query("
    SELECT b.*, ei.islem_adi, ei.fiyat 
    FROM basvurular b
    JOIN ek_islem_turleri ei ON b.ek_islem = ei.id
    WHERE ei.islem_adi LIKE '%Modem%' AND DATE(b.basvuru_tarihi) = CURDATE()
    ORDER BY b.basvuru_tarihi DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Tüm modem satışlarını al
$tum_modem_satislari = $db->query("
    SELECT b.*, ei.islem_adi, ei.fiyat 
    FROM basvurular b
    JOIN ek_islem_turleri ei ON b.ek_islem = ei.id
    WHERE ei.islem_adi LIKE '%Modem%'
    ORDER BY b.basvuru_tarihi DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modem Satışları</title>
    <link rel="stylesheet" href="assets/style.css?v=5.2">
</head>
<body>
    <div class="container">
        <header>
            <h1>Modem Satışları</h1>
            <a href="index.php" class="back-btn">← Ana Sayfa</a>
        </header>

        <h2>Bugünkü Modem Satışları</h2>
        <div class="satis-list">
            <?php if (count($bugunku_modem_satislari) > 0): ?>
                <?php foreach ($bugunku_modem_satislari as $satis): ?>
                    <div class="satis-card">
                        <p><strong>Ad Soyad:</strong> <?= htmlspecialchars($satis['ad_soyad']) ?></p>
                        <p><strong>İşlem Türü:</strong> <?= htmlspecialchars($satis['islem_adi']) ?></p>
                        <p><strong>Fiyat:</strong> <?= number_format($satis['fiyat'], 2) ?> TL</p>
                        <p><strong>Tarih:</strong> <?= htmlspecialchars($satis['basvuru_tarihi']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Bugün modem satışı yapılmamıştır.</p>
            <?php endif; ?>
        </div>

        <h2>Tüm Modem Satışları</h2>
        <div class="satis-list">
            <?php if (count($tum_modem_satislari) > 0): ?>
                <?php foreach ($tum_modem_satislari as $satis): ?>
                    <div class="satis-card">
                        <p><strong>Ad Soyad:</strong> <?= htmlspecialchars($satis['ad_soyad']) ?></p>
                        <p><strong>İşlem Türü:</strong> <?= htmlspecialchars($satis['islem_adi']) ?></p>
                        <p><strong>Fiyat:</strong> <?= number_format($satis['fiyat'], 2) ?> TL</p>
                        <p><strong>Tarih:</strong> <?= htmlspecialchars($satis['basvuru_tarihi']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Hiç modem satışı yapılmamıştır.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
