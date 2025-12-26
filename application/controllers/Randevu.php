<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Randevu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Randevu_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'session'));
        
        // Giriş kontrolü
        if (!$this->session->userdata('giris_yapildi')) {
            redirect('auth/giris');
        }
    }

    public function index() {
        // Admin ise tüm randevuları, kullanıcı ise sadece kendi randevularını göster
        if ($this->session->userdata('yetki') == 'admin') {
            $data['randevular'] = $this->Randevu_model->tum_randevular();
        } else {
            $data['randevular'] = $this->Randevu_model->kullanici_randevulari($this->session->userdata('kullanici_id'));
        }
        $data['yetki'] = $this->session->userdata('yetki');
        $this->load->view('randevu_liste', $data);
    }

    public function ekle() {
        // Admin randevu ekleyemez
        if ($this->session->userdata('yetki') == 'admin') {
            $this->session->set_flashdata('hata', 'Admin kullanıcıları randevu ekleyemez.');
            redirect('randevu');
        }

        $this->form_validation->set_rules('ad_soyad', 'Ad Soyad', 'required');
        $this->form_validation->set_rules('telefon', 'Telefon', 'required');
        $this->form_validation->set_rules('tarih', 'Tarih', 'required');
        $this->form_validation->set_rules('saat', 'Saat', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('randevu_ekle');
        } else {
            $data = array(
                'kullanici_id' => $this->session->userdata('kullanici_id'),
                'ad_soyad' => $this->input->post('ad_soyad'),
                'telefon' => $this->input->post('telefon'),
                'email' => $this->input->post('email'),
                'tarih' => $this->input->post('tarih'),
                'saat' => $this->input->post('saat'),
                'notlar' => $this->input->post('notlar'),
                'durum' => 'beklemede'
            );

            if ($this->Randevu_model->randevu_ekle($data)) {
                redirect('randevu');
            } else {
                $data['hata'] = 'Randevu eklenirken bir hata oluştu!';
                $this->load->view('randevu_ekle', $data);
            }
        }
    }

    public function sil($id) {
        // Sadece admin veya randevu sahibi silebilir
        $randevu = $this->Randevu_model->randevu_getir($id);
        if ($this->session->userdata('yetki') == 'admin' || 
            $randevu->kullanici_id == $this->session->userdata('kullanici_id')) {
            $this->Randevu_model->randevu_sil($id);
        }
        redirect('randevu');
    }

    public function durum_guncelle($id, $durum) {
        // Sadece admin durum güncelleyebilir
        $yetki = $this->session->userdata('yetki');
        if ($yetki == 'admin') {
            $result = $this->Randevu_model->randevu_guncelle($id, array('durum' => $durum));
            if ($result) {
                $this->session->set_flashdata('mesaj', 'Randevu durumu güncellendi.');
            } else {
                $this->session->set_flashdata('hata', 'Randevu durumu güncellenirken bir hata oluştu.');
            }
        } else {
            $this->session->set_flashdata('hata', 'Bu işlem için admin yetkisi gereklidir.');
        }
        redirect('randevu');
    }
}

