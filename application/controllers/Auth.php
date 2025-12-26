<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'session'));
    }

    public function kayit() {
        $this->form_validation->set_rules('ad_soyad', 'Ad Soyad', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[kullanicilar.email]');
        $this->form_validation->set_rules('sifre', 'Şifre', 'required|min_length[6]');
        $this->form_validation->set_rules('sifre_tekrar', 'Şifre Tekrar', 'required|matches[sifre]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth_kayit');
        } else {
            $data = array(
                'ad_soyad' => $this->input->post('ad_soyad'),
                'email' => $this->input->post('email'),
                'sifre' => $this->input->post('sifre'),
                'yetki' => 'kullanici'
            );

            if ($this->User_model->kayit_ol($data)) {
                $this->session->set_flashdata('mesaj', 'Kayıt başarılı! Giriş yapabilirsiniz.');
                redirect('auth/giris');
            } else {
                $data['hata'] = 'Kayıt olurken bir hata oluştu!';
                $this->load->view('auth_kayit', $data);
            }
        }
    }

    public function giris() {
        if ($this->session->userdata('giris_yapildi')) {
            redirect('randevu');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('sifre', 'Şifre', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth_giris');
        } else {
            $kullanici = $this->User_model->giris_yap(
                $this->input->post('email'),
                $this->input->post('sifre')
            );

            if ($kullanici) {
                // Session verilerini kaydet
                $session_data = array(
                    'giris_yapildi' => true,
                    'kullanici_id' => $kullanici->id,
                    'ad_soyad' => $kullanici->ad_soyad,
                    'email' => $kullanici->email,
                    'yetki' => $kullanici->yetki
                );
                $this->session->set_userdata($session_data);
                
                // Session'ın kaydedildiğini kontrol et
                if ($this->session->userdata('giris_yapildi')) {
                    redirect('randevu');
                } else {
                    $data['hata'] = 'Oturum açılırken bir sorun oluştu. Lütfen tekrar deneyin.';
                    $this->load->view('auth_giris', $data);
                }
            } else {
                $data['hata'] = 'Email veya şifre hatalı! Lütfen bilgilerinizi kontrol edin.';
                $this->load->view('auth_giris', $data);
            }
        }
    }

    public function cikis() {
        $this->session->sess_destroy();
        redirect('auth/giris');
    }
}

