# Randevu Sistemi

CodeIgniter 3 ile geliştirilmiş basit randevu yönetim sistemi.

## Özellikler

- Kullanıcı kayıt ve giriş sistemi
- Randevu ekleme, listeleme, silme
- Admin paneli (randevu onaylama/iptal etme)
- Responsive tasarım
- Modern ve kullanıcı dostu arayüz

## Gereksinimler

- PHP 7.0 veya üzeri
- MySQL/MariaDB
- Apache/Nginx (mod_rewrite önerilir)
- CodeIgniter 3.x

## Kurulum

1. Projeyi klonlayın veya indirin
2. Veritabanı oluşturun:
   ```sql
   CREATE DATABASE randevu;
   ```

3. `application/config/database.php` dosyasını düzenleyin:
   ```php
   $db['default'] = array(
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'randevu',
       'dbdriver' => 'mysqli',
       // ...
   );
   ```

4. `randevu.sql` dosyasını veritabanınıza import edin

5. `application/config/config.php` dosyasında `base_url` ayarını yapın:
   ```php
   $config['base_url'] = 'http://localhost/randevu/';
   ```

## Varsayılan Admin Kullanıcı

- **Email:** admin@admin.com
- **Şifre:** admin123

## Kullanım

1. Normal kullanıcılar kayıt olup randevu ekleyebilir
2. Admin kullanıcılar randevuları onaylayabilir/iptal edebilir
3. Her kullanıcı sadece kendi randevularını görebilir
4. Admin tüm randevuları görebilir

## Teknolojiler

- CodeIgniter 3
- PHP
- MySQL
- HTML/CSS/JavaScript

## Lisans

Bu proje eğitim amaçlı geliştirilmiştir.

