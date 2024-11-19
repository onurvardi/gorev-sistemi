<?php
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $query = $db->prepare("SELECT * FROM kullanicilar WHERE id = :id");
        $query->execute([':id' => $id]);
        $kullanici = $query->fetch(PDO::FETCH_ASSOC);

        if ($kullanici) {
            echo json_encode($kullanici);
        } else {
            echo json_encode(['error' => 'Kullanıcı bulunamadı.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Geçersiz istek.']);
}
