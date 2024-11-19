<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];
    $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->execute([$kullanici_adi]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($sifre, $user['sifre'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ekip_id'] = $user['ekip_id'];
        $_SESSION['yetki'] = $user['yetki'];
        
        header('Location: index.php');
        exit;
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş - Toki1 Yönetim Sistemi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            padding: 20px;
            max-width: 400px;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #4a90e2;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .login-btn:hover {
            background: #357abd;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-box {
                padding: 25px;
            }

            h2 {
                font-size: 20px;
            }

            input, .login-btn {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Toki1 Yönetim Sistemi</h2>
            <?php if (isset($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Kullanıcı Adı</label>
                    <input type="text" name="kullanici_adi" required>
                </div>
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" name="sifre" required>
                </div>
                <button type="submit" class="login-btn">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>
</html>