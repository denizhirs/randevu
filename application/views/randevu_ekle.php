<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Randevu Ekle</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #ffffff; min-height: 100vh; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        h1 { margin-bottom: 30px; color: #333; font-size: 28px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        input[type="text"], input[type="email"], input[type="date"], input[type="time"], textarea { 
            width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 6px; font-size: 14px; 
            transition: border-color 0.3s;
        }
        input:focus, textarea:focus { outline: none; border-color: #667eea; }
        textarea { resize: vertical; min-height: 100px; }
        .btn { padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 500; transition: all 0.3s; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,123,255,0.3); }
        .btn-secondary { background: #6c757d; margin-left: 10px; }
        .btn-secondary:hover { background: #5a6268; }
        .error { color: #dc3545; font-size: 14px; margin-top: 5px; background: #f8d7da; padding: 12px; border-radius: 6px; border-left: 4px solid #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Yeni Randevu Ekle</h1>
        
        <?php if (isset($hata)): ?>
            <div class="error" style="background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo $hata; ?>
            </div>
        <?php endif; ?>
        
        <?php if (validation_errors()): ?>
            <div class="error" style="background: #f8d7da; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo base_url('randevu/ekle'); ?>">
            <div class="form-group">
                <label>Ad Soyad *</label>
                <input type="text" name="ad_soyad" value="<?php echo set_value('ad_soyad'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Telefon *</label>
                <input type="text" name="telefon" value="<?php echo set_value('telefon'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo set_value('email'); ?>">
            </div>
            
            <div class="form-group">
                <label>Tarih *</label>
                <input type="date" name="tarih" value="<?php echo set_value('tarih'); ?>" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Saat *</label>
                <input type="time" name="saat" value="<?php echo set_value('saat'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Notlar</label>
                <textarea name="notlar"><?php echo set_value('notlar'); ?></textarea>
            </div>
            
            <button type="submit" class="btn">Randevu Ekle</button>
            <a href="<?php echo base_url('randevu'); ?>" class="btn btn-secondary">Geri Dön</a>
        </form>
    </div>
</body>
</html>

