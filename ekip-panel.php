<?php
require 'config.php';
checkLogin();

$ekip_id = $_GET['id'] ?? 0;

$ekip = $db->query("SELECT * FROM ekipler WHERE id = $ekip_id")->fetch(PDO::FETCH_ASSOC);

$basvurular = $db->query("
    SELECT b.*, k.kullanici_adi as islem_yapan
    FROM basvurular b
    LEFT JOIN kullanicilar k ON b.islem_yapan_id = k.id
    WHERE b.ekip_id = $ekip_id AND b.durum = 'Beklemede'
    ORDER BY b.oncelik DESC, b.basvuru_tarihi ASC
")->fetchAll(PDO::FETCH_ASSOC);

$ek_islemler = $db->query("SELECT * FROM ek_islem_turleri")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $ekip['ekip_adi'] ?> - Toki1 Yönetim Sistemi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= htmlspecialchars($ekip['ekip_adi']) ?></h1>
            <a href="index.php" class="geri-btn">← Ana Sayfa</a>
        </header>

        <div class="basvuru-list">
            <?php foreach($basvurular as $basvuru): ?>
                <div class="basvuru-card <?= strtolower($basvuru['durum']) ?>">
                    <div class="basvuru-header">
                        <h3><?= htmlspecialchars($basvuru['ad_soyad']) ?></h3>
                        <span class="oncelik-badge <?= strtolower($basvuru['oncelik']) ?>">
                            <?= $basvuru['oncelik'] ?>
                        </span>
                    </div>
                    <div class="basvuru-body">
                        <p>📞 <?= htmlspecialchars($basvuru['telefon']) ?></p>
                        <p>📍 <?= htmlspecialchars($basvuru['sokak_no']) ?> Sk. No:<?= htmlspecialchars($basvuru['bina_no']) ?>/<?= htmlspecialchars($basvuru['daire_no']) ?></p>
                        <p>📅 <?= date('d.m.Y H:i', strtotime($basvuru['basvuru_tarihi'])) ?></p>
                    </div>
                    <div class="basvuru-actions">
                        <button onclick="islemTamamla(<?= $basvuru['id'] ?>)" class="btn-tamamla">Tamamla</button>
                        <button onclick="arizaBildir(<?= $basvuru['id'] ?>)" class="btn-ariza">Yeni Arıza Notu</button>
                        <a href="#" onclick="basvuruDetay(<?= $basvuru['id'] ?>); return false;" class="detay-btn">Detay</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
    function islemTamamla(id) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <h3>İşlem Tamamla</h3>
                <form id="tamamlaForm">
                    <div class="form-group">
                        <label>Tamamlanma Detayı</label>
                        <textarea name="detay" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ek İşlem</label>
                        <select name="ek_islem" class="form-control">
                            <option value="">Yok</option>
                            <?php foreach($ek_islemler as $islem): ?>
                                <option value="<?= $islem['id'] ?>"><?= htmlspecialchars($islem['islem_adi']) ?> - <?= number_format($islem['fiyat'], 2) ?> TL</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">Tamamla</button>
                    <button type="button" class="btn-iptal" onclick="this.closest('.modal').remove()">İptal</button>
                <p>Yeni notlar burada görünmeye devam edecek.</p>
</form>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'flex';

        document.getElementById('tamamlaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('islem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    islem: 'tamamla',
                    id: id,
                    detay: formData.get('detay'),
                    ek_islem: formData.get('ek_islem')
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showNotification('İşlem tamamlandı');
                    setTimeout(() => location.reload(), 1000);
                }
            });
        });
    }

    function arizaBildir(id) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <h3>Yeni Arıza Notu</h3>
                <form id="arizaForm">
                    <div class="form-group">
                        <label>Arıza Açıklaması</label>
                        <textarea name="aciklama" required class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Bildir</button>
                    <button type="button" class="btn-iptal" onclick="this.closest('.modal').remove()">İptal</button>
                <p>Yeni notlar burada görünmeye devam edecek.</p>
</form>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'flex';

        document.getElementById('arizaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('islem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    islem: 'ariza',
                    id: id,
                    aciklama: formData.get('aciklama')
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showNotification('Arıza kaydedildi');
                    setTimeout(() => location.reload(), 1000);
                }
            });
        });
    }
    </script>
    <script src="assets/script.js"></script>
</body>
</html>
