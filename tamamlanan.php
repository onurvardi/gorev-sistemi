<?php
require 'config.php';
checkLogin();

$tamamlanan = $db->query("
    SELECT b.*, e.ekip_adi, k.kullanici_adi as islem_yapan,
           eit.islem_adi, eit.fiyat
    FROM basvurular b 
    LEFT JOIN ekipler e ON b.ekip_id = e.id 
    LEFT JOIN kullanicilar k ON b.islem_yapan_id = k.id
    LEFT JOIN ek_islem_turleri eit ON b.ek_islem = eit.id
    WHERE b.durum = 'Tamamlandı'
    ORDER BY b.tamamlanma_tarihi DESC
")->fetchAll(PDO::FETCH_ASSOC);

$toplam_tutar = $db->query("
    SELECT SUM(eit.fiyat) as toplam 
    FROM basvurular b 
    JOIN ek_islem_turleri eit ON b.ek_islem = eit.id
    WHERE b.durum = 'Tamamlandı'
")->fetch(PDO::FETCH_ASSOC)['toplam'];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamamlanan İşler - Toki1 Yönetim Sistemi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Tamamlanan İşler</h1>
            <a href="index.php" class="geri-btn">← Ana Sayfa</a>
        </header>

        <div class="ozet-bilgi">
            <h3>Toplam Tutar: <?= number_format($toplam_tutar, 2) ?> TL</h3>
        </div>

        <div class="basvuru-list">
            <?php foreach($tamamlanan as $basvuru): ?>
                <div class="basvuru-card tamamlandi">
                    <div class="basvuru-header">
                        <h3><?= htmlspecialchars($basvuru['ad_soyad']) ?></h3>
                        <span class="tarih"><?= date('d.m.Y H:i', strtotime($basvuru['tamamlanma_tarihi'])) ?></span>
                    </div>
                    <div class="basvuru-body">
                        <p>📞 <?= htmlspecialchars($basvuru['telefon']) ?></p>
                        <p>📍 <?= htmlspecialchars($basvuru['sokak_no']) ?> Sk. No:<?= htmlspecialchars($basvuru['bina_no']) ?>/<?= htmlspecialchars($basvuru['daire_no']) ?></p>
                        <p>👥 <?= htmlspecialchars($basvuru['ekip_adi']) ?></p>
                        <?php if($basvuru['islem_adi']): ?>
                            <p>💰 <?= htmlspecialchars($basvuru['islem_adi']) ?> - <?= number_format($basvuru['fiyat'], 2) ?> TL</p>
                        <?php endif; ?>
                        <p>✍️ <?= htmlspecialchars($basvuru['tamamlanma_detay']) ?></p>
                        <p class="islem-yapan">İşlemi yapan: <?= htmlspecialchars($basvuru['islem_yapan']) ?></p>
                    </div>
                    <a href="#" onclick="basvuruDetay(<?= $basvuru['id'] ?>); return false;" class="detay-btn">Detay</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
