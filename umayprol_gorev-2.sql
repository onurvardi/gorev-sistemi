-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 19 Kas 2024, 14:17:07
-- Sunucu sürümü: 8.0.32-cll-lve
-- PHP Sürümü: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `umayprol_gorev`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `basvurular`
--

CREATE TABLE `basvurular` (
  `id` int NOT NULL,
  `ad_soyad` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefon` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `sokak_no` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `bina_no` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `daire_no` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `basvuru_tarihi` datetime NOT NULL,
  `atanma_tarihi` datetime DEFAULT NULL,
  `oncelik` enum('Normal','Acil') COLLATE utf8mb4_general_ci DEFAULT 'Normal',
  `ekip_id` int DEFAULT NULL,
  `durum` enum('Beklemede','Atandı','Tamamlandı','Arızalı') COLLATE utf8mb4_general_ci DEFAULT 'Beklemede',
  `tamamlanma_tarihi` datetime DEFAULT NULL,
  `ariza_tarihi` datetime DEFAULT NULL,
  `ariza_aciklama` text COLLATE utf8mb4_general_ci,
  `ariza_cozum_tarihi` datetime DEFAULT NULL,
  `tamamlanma_detay` text COLLATE utf8mb4_general_ci,
  `modem_satis` decimal(10,2) DEFAULT NULL,
  `ek_islem` text COLLATE utf8mb4_general_ci,
  `ariza_cozum` text COLLATE utf8mb4_general_ci,
  `islem_yapan_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `basvurular`
--

INSERT INTO `basvurular` (`id`, `ad_soyad`, `telefon`, `sokak_no`, `bina_no`, `daire_no`, `basvuru_tarihi`, `atanma_tarihi`, `oncelik`, `ekip_id`, `durum`, `tamamlanma_tarihi`, `ariza_tarihi`, `ariza_aciklama`, `ariza_cozum_tarihi`, `tamamlanma_detay`, `modem_satis`, `ek_islem`, `ariza_cozum`, `islem_yapan_id`) VALUES
(1, 'Ahmet Yılmaz', '555 111 2233', 'Çiçek Sokak', '12', '4', '2024-11-14 23:30:31', '2024-11-14 23:33:40', 'Normal', 1, 'Arızalı', NULL, '2024-11-14 23:45:59', 'modem çalışmadı', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Mehmet Demir', '555 444 5566', 'Gül Sokak', '5', '8', '2024-11-14 23:30:31', '2024-11-14 23:44:06', 'Acil', 3, 'Arızalı', NULL, '2024-11-15 00:05:52', 'gfdgdf', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Ayşe Kaya', '555 777 8899', 'Lale Sokak', '18', '2', '2024-11-14 23:30:31', '2024-11-14 23:49:15', 'Normal', 3, 'Tamamlandı', '2024-11-15 00:06:27', NULL, NULL, '2024-11-15 00:06:27', NULL, NULL, NULL, 'yapıldı', NULL),
(4, 'Onur Vardi', '5325888141', '1202', 'DC15', '16', '2024-11-14 23:32:13', '2024-11-14 23:33:07', 'Normal', 2, 'Tamamlandı', '2024-11-14 23:45:25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'test', '545', 'h', 'uhıuh', 'ıuh', '2024-11-15 00:06:51', '2024-11-15 12:51:02', 'Normal', 2, 'Tamamlandı', '2024-11-15 12:52:48', NULL, NULL, NULL, '-', NULL, '', NULL, 1),
(6, 'Umay vardı', '05322322332', '1304', 'DC6', '22', '2024-11-15 00:41:28', '2024-11-15 12:50:58', 'Acil', 3, 'Arızalı', NULL, '2024-11-15 12:51:42', 'ikinci arıza açıklaması', NULL, NULL, NULL, NULL, NULL, 1),
(7, 'Umay vardı', '05322322332', '1304', 'DC6', '22', '2024-11-15 00:41:29', '2024-11-15 12:23:32', 'Acil', 2, 'Tamamlandı', '2024-11-15 12:49:44', NULL, NULL, NULL, 'işlemi yapıldı sorun yok', NULL, '1', NULL, 1),
(8, 'Umay vardı', '05322322332', '1304', 'DC6', '22', '2024-11-15 00:41:30', '2024-11-15 12:50:54', 'Acil', 3, 'Arızalı', NULL, '2024-11-15 12:52:19', 'yapamadık bunu şu sebepten', NULL, NULL, NULL, NULL, NULL, 1),
(9, 'Gonca Kılıçoğlu', '532532532', '1209', 'DC17', '15', '2024-11-15 12:47:49', '2024-11-15 12:48:41', 'Normal', 2, 'Tamamlandı', '2024-11-15 12:52:52', NULL, NULL, NULL, '-', NULL, '', NULL, 1),
(10, 'Şeyma Vardı', '45355', '1202', 'DC6', '22', '2024-11-15 12:54:17', '2024-11-15 12:54:44', 'Acil', 2, 'Tamamlandı', '2024-11-15 12:54:58', NULL, NULL, NULL, 'kjh', NULL, '', NULL, 1),
(11, 'osman osman', '22', '23', '43', '43', '2024-11-15 13:06:30', '2024-11-15 13:09:35', 'Acil', 3, 'Arızalı', NULL, '2024-11-15 13:10:03', 'arıza var yapamadık', NULL, NULL, NULL, NULL, NULL, 1),
(12, 'Serkan kılıçoğlu', '645376456', '1202', 'dc6', '16', '2024-11-15 13:26:59', '2024-11-15 13:27:16', 'Normal', 2, 'Tamamlandı', '2024-11-15 13:27:40', NULL, NULL, NULL, 'sorunsuz tamamlandı', NULL, '1', NULL, 1),
(13, 'klhjk', 'hjk', 'hkj', 'hjk', 'h', '2024-11-15 13:28:10', '2024-11-15 13:28:15', 'Normal', 3, 'Arızalı', NULL, '2024-11-15 13:28:32', 'kjhgfkjghk', NULL, NULL, NULL, NULL, NULL, 1),
(14, 'ıyıu', 'yhıu', 'yhkjh', 'kjh', 'kjh', '2024-11-15 13:29:14', '2024-11-15 13:29:18', 'Normal', 2, 'Tamamlandı', '2024-11-15 13:29:27', NULL, NULL, NULL, 'Hh', NULL, '', NULL, 1),
(15, 'ıyıu', 'yhıu', 'yhkjh', 'kjh', 'kjh', '2024-11-15 13:29:14', '2024-11-15 14:07:33', 'Normal', 3, 'Arızalı', NULL, '2024-11-15 18:23:56', 'arıza devam ediyor', NULL, NULL, NULL, NULL, NULL, 1),
(16, 'gfgf', 'gfgd', 'gfdg', 'gfdg', '43r', '2024-11-15 18:49:48', '2024-11-15 18:49:54', 'Normal', 3, 'Arızalı', NULL, '2024-11-15 18:50:01', 'arıza deavm ediyor', NULL, NULL, NULL, NULL, NULL, 1),
(17, 'deneme bülent', '5453', '54', '4534', 'gfgd', '2024-11-16 00:31:52', '2024-11-18 11:38:22', 'Normal', 2, 'Tamamlandı', '2024-11-18 11:38:29', NULL, NULL, NULL, 'gsfd', NULL, '', NULL, 1),
(18, 'SULTAN ERDEM', '05303853177', '1202', 'E1-8', '11', '2024-11-18 11:40:04', '2024-11-18 11:41:39', 'Acil', 2, 'Tamamlandı', '2024-11-18 11:42:10', NULL, NULL, NULL, 'Kızdı', NULL, '1', NULL, 7),
(19, 'OSNMAN', 'HAYDAR', '111', 'F6', '4', '2024-11-18 11:42:58', '2024-11-18 11:43:10', 'Normal', 3, 'Arızalı', NULL, '2024-11-18 11:43:58', 'Kablo yok', NULL, NULL, NULL, NULL, NULL, 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ekipler`
--

CREATE TABLE `ekipler` (
  `id` int NOT NULL,
  `ekip_adi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ekipler`
--

INSERT INTO `ekipler` (`id`, `ekip_adi`) VALUES
(1, 'Üstyapı Ekibi'),
(2, 'Evde Kurulum Ekibi'),
(3, 'Arıza Ekibi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ek_islem_turleri`
--

CREATE TABLE `ek_islem_turleri` (
  `id` int NOT NULL,
  `islem_adi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fiyat` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ek_islem_turleri`
--

INSERT INTO `ek_islem_turleri` (`id`, `islem_adi`, `fiyat`) VALUES
(1, 'Modem Satışı', 450.00),
(2, 'Ethernet Kablosu', 50.00),
(3, 'Ek Bağlantı Noktası', 100.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem_loglar`
--

CREATE TABLE `islem_loglar` (
  `id` int NOT NULL,
  `kullanici_id` int NOT NULL,
  `basvuru_id` int NOT NULL,
  `islem_tipi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `aciklama` text COLLATE utf8mb4_general_ci,
  `islem_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `islem_loglar`
--

INSERT INTO `islem_loglar` (`id`, `kullanici_id`, `basvuru_id`, `islem_tipi`, `aciklama`, `islem_tarihi`, `created_at`) VALUES
(1, 1, 1, 'Başvuru Güncelleme', 'Başvuru detayları güncellendi', '2024-11-15 09:22:21', '2024-11-15 09:23:26'),
(2, 2, 2, 'Başvuru Silme', 'Başvuru silindi', '2024-11-15 09:22:21', '2024-11-15 09:23:26'),
(3, 1, 7, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:23:32', '2024-11-15 09:23:32'),
(4, 1, 9, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 09:47:49', '2024-11-15 09:47:49'),
(5, 1, 9, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:48:41', '2024-11-15 09:48:41'),
(6, 1, 7, 'tamamlama', 'İş tamamlandı: işlemi yapıldı sorun yok', '2024-11-15 09:49:44', '2024-11-15 09:49:44'),
(7, 1, 8, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:50:54', '2024-11-15 09:50:54'),
(8, 1, 6, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:50:58', '2024-11-15 09:50:58'),
(9, 1, 5, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:51:02', '2024-11-15 09:51:02'),
(10, 1, 6, 'ariza', 'Arıza bildirimi: ikinci arıza açıklaması', '2024-11-15 09:51:42', '2024-11-15 09:51:42'),
(11, 1, 8, 'ariza', 'Arıza bildirimi: yapamadık bunu şu sebepten', '2024-11-15 09:52:19', '2024-11-15 09:52:19'),
(12, 1, 5, 'tamamlama', 'İş tamamlandı: -', '2024-11-15 09:52:48', '2024-11-15 09:52:48'),
(13, 1, 9, 'tamamlama', 'İş tamamlandı: -', '2024-11-15 09:52:52', '2024-11-15 09:52:52'),
(14, 1, 10, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 09:54:17', '2024-11-15 09:54:17'),
(15, 1, 10, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 09:54:44', '2024-11-15 09:54:44'),
(16, 1, 10, 'tamamlama', 'İş tamamlandı: kjh', '2024-11-15 09:54:58', '2024-11-15 09:54:58'),
(17, 1, 11, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 10:06:30', '2024-11-15 10:06:30'),
(18, 1, 11, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 10:09:35', '2024-11-15 10:09:35'),
(19, 1, 11, 'ariza', 'Arıza bildirimi: arıza var yapamadık', '2024-11-15 10:10:03', '2024-11-15 10:10:03'),
(20, 1, 12, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 10:26:59', '2024-11-15 10:26:59'),
(21, 1, 12, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 10:27:16', '2024-11-15 10:27:16'),
(22, 1, 12, 'tamamlama', 'İş tamamlandı: sorunsuz tamamlandı', '2024-11-15 10:27:40', '2024-11-15 10:27:40'),
(23, 1, 13, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 10:28:10', '2024-11-15 10:28:10'),
(24, 1, 13, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 10:28:15', '2024-11-15 10:28:15'),
(25, 1, 13, 'ariza', 'Arıza bildirimi: kjhgfkjghk', '2024-11-15 10:28:32', '2024-11-15 10:28:32'),
(26, 1, 14, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 10:29:14', '2024-11-15 10:29:14'),
(27, 1, 15, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 10:29:14', '2024-11-15 10:29:14'),
(28, 1, 14, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 10:29:18', '2024-11-15 10:29:18'),
(29, 1, 14, 'tamamlama', 'İş tamamlandı: Hh', '2024-11-15 10:29:27', '2024-11-15 10:29:27'),
(30, 1, 15, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 10:39:45', '2024-11-15 10:39:45'),
(31, 6, 15, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 11:07:33', '2024-11-15 11:07:33'),
(32, 1, 15, 'ariza', 'Arıza bildirimi: arıza devam ediyor', '2024-11-15 15:23:56', '2024-11-15 15:23:56'),
(33, 1, 16, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 15:49:48', '2024-11-15 15:49:48'),
(34, 1, 16, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-15 15:49:54', '2024-11-15 15:49:54'),
(35, 1, 16, 'ariza', 'Arıza bildirimi: arıza deavm ediyor', '2024-11-15 15:50:01', '2024-11-15 15:50:01'),
(36, 1, 17, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-15 21:31:52', '2024-11-15 21:31:52'),
(37, 1, 17, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-18 08:38:22', '2024-11-18 08:38:22'),
(38, 1, 17, 'tamamlama', 'İş tamamlandı: gsfd', '2024-11-18 08:38:29', '2024-11-18 08:38:29'),
(39, 1, 18, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-18 08:40:04', '2024-11-18 08:40:04'),
(40, 1, 18, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-18 08:41:39', '2024-11-18 08:41:39'),
(41, 7, 18, 'tamamlama', 'İş tamamlandı: Kızdı', '2024-11-18 08:42:10', '2024-11-18 08:42:10'),
(42, 1, 19, 'yeni_basvuru', 'Yeni başvuru oluşturuldu', '2024-11-18 08:42:58', '2024-11-18 08:42:58'),
(43, 1, 19, 'ekip_atama', 'Başvuru ekibe atandı', '2024-11-18 08:43:10', '2024-11-18 08:43:10'),
(44, 7, 19, 'ariza', 'Arıza bildirimi: Kablo yok', '2024-11-18 08:43:58', '2024-11-18 08:43:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int NOT NULL,
  `kullanici_adi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `yetki` enum('admin','ekip') COLLATE utf8mb4_general_ci NOT NULL,
  `ekip_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`, `yetki`, `ekip_id`, `created_at`) VALUES
(1, 'admin', '$2y$10$cF1gYYOHi3cuqQ7J0KLZ3.cp45gIVTS9XGIWdzJD561DBSTsvpWZW', 'admin', NULL, '2024-11-15 09:25:13'),
(2, 'suat', '$2y$10$cF1gYYOHi3cuqQ7J0KLZ3.cp45gIVTS9XGIWdzJD561DBSTsvpWZW.', 'ekip', 1, '2024-11-15 09:25:13'),
(3, 'abdulkadir', '$2y$10$cF1gYYOHi3cuqQ7J0KLZ3.cp45gIVTS9XGIWdzJD561DBSTsvpWZW', 'ekip', 2, '2024-11-15 09:25:13'),
(4, 'teest', '$2y$10$CV7vOi6lcyZbvpZP2hlQ2uLEtKhQLXBj95sGu1pO7Zd66k3C0HMWW', 'admin', NULL, '2024-11-15 09:45:34'),
(5, 'gonca', '$2y$10$/9WvFoMy/GXDgguPQ9pzpuzFwBKc69OTDHssZkSBUsKMtnAhFICAu', 'admin', NULL, '2024-11-15 11:07:05'),
(6, 'onur', '$2y$10$dNXwu3TSwAG5sUYrywQ15.1rBgblES.Jbb00uCS3qbORe.LSGTyZG', 'admin', NULL, '2024-11-15 11:07:14'),
(7, 'kocacik', '$2y$10$RzZAE4RP/zyWiwwxTRohI.1tZ3vIKCxFtN7PqrxDMc3bF1PL6ZZ1C', 'ekip', NULL, '2024-11-18 08:40:26');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `basvurular`
--
ALTER TABLE `basvurular`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ekip_id` (`ekip_id`);

--
-- Tablo için indeksler `ekipler`
--
ALTER TABLE `ekipler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ek_islem_turleri`
--
ALTER TABLE `ek_islem_turleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `islem_loglar`
--
ALTER TABLE `islem_loglar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_id` (`kullanici_id`),
  ADD KEY `basvuru_id` (`basvuru_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `basvurular`
--
ALTER TABLE `basvurular`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `ekipler`
--
ALTER TABLE `ekipler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `ek_islem_turleri`
--
ALTER TABLE `ek_islem_turleri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `islem_loglar`
--
ALTER TABLE `islem_loglar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `basvurular`
--
ALTER TABLE `basvurular`
  ADD CONSTRAINT `basvurular_ibfk_1` FOREIGN KEY (`ekip_id`) REFERENCES `ekipler` (`id`);

--
-- Tablo kısıtlamaları `islem_loglar`
--
ALTER TABLE `islem_loglar`
  ADD CONSTRAINT `islem_loglar_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`),
  ADD CONSTRAINT `islem_loglar_ibfk_2` FOREIGN KEY (`basvuru_id`) REFERENCES `basvurular` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
