<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function kayit_ol($data) {
        $data['sifre'] = password_hash($data['sifre'], PASSWORD_DEFAULT);
        return $this->db->insert('kullanicilar', $data);
    }

    public function giris_yap($email, $sifre) {
        $kullanici = $this->db->where('email', $email)->get('kullanicilar')->row();
        
        if ($kullanici) {
            // Şifre hash ile başlıyorsa (password_hash ile oluşturulmuş)
            if (strpos($kullanici->sifre, '$2y$') === 0 || strpos($kullanici->sifre, '$2a$') === 0) {
                // Hash ile kontrol et
                if (password_verify($sifre, $kullanici->sifre)) {
                    return $kullanici;
                }
            } else {
                // Düz metin şifre kontrolü (geçici çözüm - admin için)
                if ($kullanici->sifre === $sifre) {
                    return $kullanici;
                }
            }
        }
        return false;
    }

    public function kullanici_getir($id) {
        return $this->db->where('id', $id)->get('kullanicilar')->row();
    }
}

