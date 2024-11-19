<?php
require 'config.php';
checkLogin();

$ek_islemler = $db->query("
    SELECT eit.*, 
           COUNT(b.id) as kullanim_sayisi,
           SUM(CASE WHEN b.id IS NOT NULL THEN eit.fiyat ELSE 0 END) as toplam_tutar
    FROM ek_islem_turleri eit
    LEFT JOIN basvurular b ON eit.id = b.ek_islem
    GROUP BY eit.id
    ORDER BY eit.islem_adi
")->fetchAll(PDO::FETCH_ASSOC);

$toplam = $db->query("
    SELECT SUM(eit.fiyat) as genel_toplam
    FROM basvurular b 
    JOIN ek_islem_turleri eit ON b.ek_islem = eit.id
")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ek İşlemler - Toki1 Yönetim Sistemi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Ek İşlemler</h1>
            <div class="header-buttons">
                <a href="index.php" class="geri-btn">← Ana Sayfa</a>
                <?php if ($_SESSION['yetki'] == 'admin'): ?>
                    <button onclick="yeniEkIslem()" class="add-button">+ Yeni Ek İşlem</button>
                <?php endif; ?>
            </div>
        </header>

        <div class="ozet-bilgi">
            <h3>Toplam Tutar: <?= number_format($toplam['genel_toplam'], 2) ?> TL</h3>
        </div>

        <div class="ek-islem-list">
            <?php foreach($ek_islemler as $islem): ?>
                <div class="ek-islem-card">
                    <div class="ek-islem-header">
                        <h3><?= htmlspecialchars($islem['islem_adi']) ?></h3>
                        <span class="fiyat"><?= number_format($islem['fiyat'], 2) ?> TL</span>
                    </div>
                    <div class="ek-islem-body">
                        <p>Kullanım: <?= $islem['kullanim_sayisi'] ?> kez</p>
                        <p>Toplam: <?= number_format($islem['toplam_tutar'], 2) ?> TL</p>
                    </div>
                    <?php if ($_SESSION['yetki'] == 'admin'): ?>
                        <div class="ek-islem-actions">
                            <button onclick="ekIslemDuzenle(<?= $islem['id'] ?>)">Düzenle</button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
