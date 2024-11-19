<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = $_POST['kullanici_adi'] ?? null;
    $yetki = $_POST['yetki'] ?? null;
    $sifre = password_hash('admin', PASSWORD_BCRYPT);

    if (!$kullanici_adi || !$yetki) {
        echo "Tüm alanları doldurun.";
        exit;
    }

    try {
        $query = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre, yetki, created_at) VALUES (:kullanici_adi, :sifre, :yetki, NOW())");
        $query->execute([
            ':kullanici_adi' => $kullanici_adi,
            ':sifre' => $sifre,
            ':yetki' => $yetki,
        ]);
        echo "Kullanıcı başarıyla eklendi.";
        header('Location: index.php');
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek.";
}
