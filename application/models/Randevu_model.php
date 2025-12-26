<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Randevu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function tum_randevular() {
        return $this->db->select('randevular.*, kullanicilar.ad_soyad as kullanici_adi')
                       ->from('randevular')
                       ->join('kullanicilar', 'kullanicilar.id = randevular.kullanici_id')
                       ->order_by('randevular.tarih', 'ASC')
                       ->order_by('randevular.saat', 'ASC')
                       ->get()
                       ->result();
    }

    public function kullanici_randevulari($kullanici_id) {
        return $this->db->where('kullanici_id', $kullanici_id)
                       ->order_by('tarih', 'ASC')
                       ->order_by('saat', 'ASC')
                       ->get('randevular')
                       ->result();
    }

    public function randevu_ekle($data) {
        return $this->db->insert('randevular', $data);
    }

    public function randevu_sil($id) {
        return $this->db->where('id', $id)->delete('randevular');
    }

    public function randevu_getir($id) {
        return $this->db->where('id', $id)->get('randevular')->row();
    }

    public function randevu_guncelle($id, $data) {
        return $this->db->where('id', $id)->update('randevular', $data);
    }
}

