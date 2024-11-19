<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
$db = new PDO("mysql:host=localhost;dbname=umayprol_gorev;charset=utf8", "umayprol_gorev", "gorev889965**");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Oturum kontrolü
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

// Kullanıcı bilgilerini getir
function getUser($db, $user_id) {
    $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Log kayıt fonksiyonu
function logActivity($db, $kullanici_id, $basvuru_id, $islem_tipi, $aciklama) {
    $stmt = $db->prepare("INSERT INTO islem_loglar (kullanici_id, basvuru_id, islem_tipi, aciklama) VALUES (?, ?, ?, ?)");
    $stmt->execute([$kullanici_id, $basvuru_id, $islem_tipi, $aciklama]);
}
