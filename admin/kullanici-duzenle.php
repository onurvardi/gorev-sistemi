<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $kullanici_adi = $_POST['kullanici_adi'] ?? null;
    $yetki = $_POST['yetki'] ?? null;

    if (!$id || !$kullanici_adi || !$yetki) {
        echo "Tüm alanları doldurun.";
        exit;
    }

    try {
        $query = $db->prepare("UPDATE kullanicilar SET kullanici_adi = :kullanici_adi, yetki = :yetki WHERE id = :id");
        $query->execute([
            ':id' => $id,
            ':kullanici_adi' => $kullanici_adi,
            ':yetki' => $yetki,
        ]);
        echo "Kullanıcı başarıyla güncellendi.";
        header('Location: index.php');
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Geçersiz istek.";
}
