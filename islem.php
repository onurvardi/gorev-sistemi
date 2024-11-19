<?php
require 'config.php';
checkLogin();

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

try {
    switch($data['islem']) {
        case 'ekip_ata':
            $stmt = $db->prepare("UPDATE basvurular SET ekip_id = ?, atanma_tarihi = NOW(), islem_yapan_id = ? WHERE id = ?");
            $stmt->execute([$data['ekip_id'], $_SESSION['user_id'], $data['id']]);
            
            logActivity($db, $_SESSION['user_id'], $data['id'], 'ekip_atama', 'Başvuru ekibe atandı');
            $response['success'] = true;
            break;

        case 'tamamla':
            $stmt = $db->prepare("
                UPDATE basvurular 
                SET durum = 'Tamamlandı', 
                    tamamlanma_tarihi = NOW(),
                    tamamlanma_detay = ?,
                    ek_islem = ?,
                    islem_yapan_id = ?
                WHERE id = ?
            ");
            $stmt->execute([$data['detay'], $data['ek_islem'], $_SESSION['user_id'], $data['id']]);
            
            logActivity($db, $_SESSION['user_id'], $data['id'], 'tamamlama', 'İş tamamlandı: ' . $data['detay']);
            $response['success'] = true;
            break;

        case 'ariza':
            $stmt = $db->prepare("
                UPDATE basvurular 
                SET durum = 'Arızalı',
                    ariza_tarihi = NOW(),
                    ariza_aciklama = ?,
                    ekip_id = 3,
                    islem_yapan_id = ?
                WHERE id = ?
            ");
            $stmt->execute([$data['aciklama'], $_SESSION['user_id'], $data['id']]);
            
            logActivity($db, $_SESSION['user_id'], $data['id'], 'ariza', 'Arıza bildirimi: ' . $data['aciklama']);
            $response['success'] = true;
            break;

        case 'ariza_coz':
            $stmt = $db->prepare("
                UPDATE basvurular 
                SET durum = 'Tamamlandı',
                    ariza_cozum_tarihi = NOW(),
                    ariza_cozum = ?,
                    tamamlanma_tarihi = NOW(),
                    islem_yapan_id = ?
                WHERE id = ?
            ");
            $stmt->execute([$data['cozum'], $_SESSION['user_id'], $data['id']]);
            
            logActivity($db, $_SESSION['user_id'], $data['id'], 'ariza_cozum', 'Arıza çözüldü: ' . $data['cozum']);
            $response['success'] = true;
            break;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
