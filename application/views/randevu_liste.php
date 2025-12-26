<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Listesi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #ffffff; min-height: 100vh; padding: 20px; }
        .container { max-width: 1400px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        h1 { margin-bottom: 25px; color: #333; font-size: 28px; }
        .header-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #e9ecef; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .btn { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; margin-bottom: 20px; transition: all 0.3s; font-weight: 500; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,123,255,0.3); }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-warning:hover { background: #e0a800; }
        .btn-small { padding: 6px 12px; font-size: 13px; margin-right: 5px; }
        .alert { padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-danger { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #e9ecef; }
        th { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; }
        tr:hover { background: #f8f9fa; }
        .durum { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .beklemede { background: #fff3cd; color: #856404; }
        .onaylandi { background: #d4edda; color: #155724; }
        .iptal { background: #f8d7da; color: #721c24; }
        .admin-badge { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .empty-state { text-align: center; padding: 40px; color: #6c757d; }
        @media (max-width: 768px) {
            .header-info { flex-direction: column; align-items: flex-start; gap: 15px; }
            table { font-size: 14px; }
            th, td { padding: 10px 8px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-info">
            <h1>Randevu Listesi</h1>
            <div class="user-info">
                <span style="color: #6c757d;">Hoş geldiniz, <strong><?php echo $this->session->userdata('ad_soyad'); ?></strong></span>
                <?php if (isset($yetki) && $yetki == 'admin'): ?>
                    <span class="admin-badge">ADMIN</span>
                <?php endif; ?>
                <a href="<?php echo base_url('auth/cikis'); ?>" class="btn" style="background: #6c757d; padding: 8px 15px; font-size: 14px; margin: 0;">Çıkış Yap</a>
            </div>
        </div>
        <?php 
        $kullanici_yetki = isset($yetki) ? $yetki : $this->session->userdata('yetki');
        if ($kullanici_yetki != 'admin'): 
        ?>
            <a href="<?php echo base_url('randevu/ekle'); ?>" class="btn">Yeni Randevu Ekle</a>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('mesaj')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('mesaj'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('hata')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('hata'); ?>
            </div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <?php 
                    $kullanici_yetki = isset($yetki) ? $yetki : $this->session->userdata('yetki');
                    if ($kullanici_yetki == 'admin'): 
                    ?>
                        <th>Kullanıcı</th>
                    <?php endif; ?>
                    <th>Ad Soyad</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                    <th>Notlar</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($randevular)): ?>
                    <?php foreach ($randevular as $randevu): ?>
                        <tr>
                            <td><?php echo $randevu->id; ?></td>
                            <?php 
                            $kullanici_yetki = isset($yetki) ? $yetki : $this->session->userdata('yetki');
                            if ($kullanici_yetki == 'admin'): 
                            ?>
                                <td><?php echo isset($randevu->kullanici_adi) ? $randevu->kullanici_adi : '-'; ?></td>
                            <?php endif; ?>
                            <td><?php echo $randevu->ad_soyad; ?></td>
                            <td><?php echo $randevu->telefon; ?></td>
                            <td><?php echo $randevu->email; ?></td>
                            <td><?php echo date('d.m.Y', strtotime($randevu->tarih)); ?></td>
                            <td><?php echo date('H:i', strtotime($randevu->saat)); ?></td>
                            <td><?php echo $randevu->notlar; ?></td>
                            <td>
                                <span class="durum <?php echo $randevu->durum; ?>">
                                    <?php 
                                    $durumlar = array(
                                        'beklemede' => 'Beklemede',
                                        'onaylandi' => 'Onaylandı',
                                        'iptal' => 'İptal'
                                    );
                                    echo $durumlar[$randevu->durum];
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $kullanici_yetki = isset($yetki) ? $yetki : $this->session->userdata('yetki');
                                if ($kullanici_yetki == 'admin'): 
                                ?>
                                    <?php if ($randevu->durum == 'beklemede'): ?>
                                        <a href="<?php echo base_url('randevu/durum_guncelle/'.$randevu->id.'/onaylandi'); ?>" class="btn btn-success btn-small">Onayla</a>
                                        <a href="<?php echo base_url('randevu/durum_guncelle/'.$randevu->id.'/iptal'); ?>" class="btn btn-warning btn-small">İptal</a>
                                    <?php elseif ($randevu->durum == 'onaylandi'): ?>
                                        <a href="<?php echo base_url('randevu/durum_guncelle/'.$randevu->id.'/iptal'); ?>" class="btn btn-warning btn-small">İptal Et</a>
                                    <?php elseif ($randevu->durum == 'iptal'): ?>
                                        <a href="<?php echo base_url('randevu/durum_guncelle/'.$randevu->id.'/onaylandi'); ?>" class="btn btn-success btn-small">Onayla</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <a href="<?php echo base_url('randevu/sil/'.$randevu->id); ?>" class="btn btn-danger btn-small" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php 
                        $kullanici_yetki = isset($yetki) ? $yetki : $this->session->userdata('yetki');
                        echo ($kullanici_yetki == 'admin') ? '10' : '9'; 
                        ?>" class="empty-state">
                            <div>Henüz randevu bulunmamaktadır.</div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

