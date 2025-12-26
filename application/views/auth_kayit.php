<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #ffffff; min-height: 100vh; padding: 20px; display: flex; align-items: center; justify-content: center; }
        .container { max-width: 400px; width: 100%; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        h1 { margin-bottom: 30px; color: #333; text-align: center; font-size: 28px; }
        .form-group { margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 12px; border: 2px solid #e9ecef; border-radius: 6px; font-size: 14px; transition: border-color 0.3s; }
        input:focus { outline: none; border-color: #667eea; }
        .btn { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 500; margin-bottom: 10px; transition: all 0.3s; }
        .btn:hover { background: #0056b3; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,123,255,0.3); }
        .error { color: #dc3545; font-size: 14px; background: #f8d7da; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #dc3545; }
        .link { text-align: center; margin-top: 20px; }
        .link a { color: #007bff; text-decoration: none; font-weight: 500; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kayıt Ol</h1>
        
        <?php if (isset($hata)): ?>
            <div class="error"><?php echo $hata; ?></div>
        <?php endif; ?>
        
        <?php if (validation_errors()): ?>
            <div class="error"><?php echo validation_errors(); ?></div>
        <?php endif; ?>
        
        <form method="post" action="<?php echo base_url('auth/kayit'); ?>">
            <div class="form-group">
                <label>Ad Soyad *</label>
                <input type="text" name="ad_soyad" value="<?php echo set_value('ad_soyad'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?php echo set_value('email'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Şifre * (Min 6 karakter)</label>
                <input type="password" name="sifre" required>
            </div>
            
            <div class="form-group">
                <label>Şifre Tekrar *</label>
                <input type="password" name="sifre_tekrar" required>
            </div>
            
            <button type="submit" class="btn">Kayıt Ol</button>
        </form>
        
        <div class="link">
            <a href="<?php echo base_url('auth/giris'); ?>">Zaten hesabınız var mı? Giriş yapın</a>
        </div>
    </div>
</body>
</html>

