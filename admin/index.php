<?php
require_once '../config.php'; // Veritabanı bağlantısı

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hata raporlama
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kullanıcıları çek
$query = $db->query("SELECT id, kullanici_adi, yetki, ekip_id, created_at FROM kullanicilar");
$kullanicilar = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="admin.css?v=3">
</head>
<body>
    <header>
        <h1>Admin Paneli</h1>
        <button id="yeniKullanici" class="add-button">+ Yeni Kullanıcı</button>
    </header>
    <main>
        <h2>Kullanıcı Listesi</h2>
        <div class="kullanicilar-list">
            <?php foreach ($kullanicilar as $kullanici): ?>
                <div class="kullanici-card">
                    <div class="kullanici-header">
                        <h3><?= htmlspecialchars($kullanici['kullanici_adi'] ?? 'Bilinmiyor') ?></h3>
                        <span class="yetki-badge"><?= htmlspecialchars($kullanici['yetki'] ?? 'Tanımsız') ?></span>
                    </div>
                    <div class="kullanici-body">
                        <p>Ekip ID: <?= htmlspecialchars($kullanici['ekip_id'] ?? 'Atanmamış') ?></p>
                        <p>Kayıt Tarihi: <?= htmlspecialchars($kullanici['created_at'] ?? 'Bilinmiyor') ?></p>
                    </div>
                    <div class="kullanici-actions">
                        <a href="kullanici-duzenle.php?id=<?= $kullanici['id'] ?>">Düzenle</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Yeni Kullanıcı Modal -->
    <div id="kullaniciModal" class="modal">
        <div class="modal-content">
            <form method="POST" action="kullanici-ekle.php">
                <h3>Yeni Kullanıcı Ekle</h3>
                <label for="kullaniciAdi">Kullanıcı Adı:</label>
                <input type="text" id="kullaniciAdi" name="kullanici_adi" required>
                <label for="yetki">Yetki:</label>
                <select id="yetki" name="yetki">
                    <option value="admin">Admin</option>
                    <option value="ekip">Ekip</option>
                </select>
                <button type="submit">Kaydet</button>
                <button type="button" id="modalClose">Kapat</button>
            </form>
        </div>
    </div>

    <script src="admin.js?v=3"></script>
</body>
</html>
