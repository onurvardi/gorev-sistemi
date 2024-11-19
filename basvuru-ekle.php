<?php
require 'config.php';
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $db->prepare("
            INSERT INTO basvurular 
            (ad_soyad, telefon, sokak_no, bina_no, daire_no, oncelik, basvuru_tarihi, durum, islem_yapan_id) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Beklemede', ?)
        ");
        
        $stmt->execute([
            $_POST['ad_soyad'],
            $_POST['telefon'],
            $_POST['sokak_no'],
            $_POST['bina_no'],
            $_POST['daire_no'],
            $_POST['oncelik'],
            $_SESSION['user_id']
        ]);

        $basvuru_id = $db->lastInsertId();
        logActivity($db, $_SESSION['user_id'], $basvuru_id, 'yeni_basvuru', 'Yeni başvuru oluşturuldu');
        
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
