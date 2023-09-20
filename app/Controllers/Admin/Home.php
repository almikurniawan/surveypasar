<?php

namespace App\Controllers\Admin;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Home extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Form Kegiatan';
        $data['form'] = $this->form();
        return view('admin/home', $data);
    }

    public function form()
    {
        $form = new Form();
        $form
            ->set_form_method('POST')
            ->add('kegiatantanggal', 'Tanggal Kegiatan', 'datetime', true, '', 'style="width:100%;" ')
            // ->add('kegiatanjudul', 'Judul', 'text', true, '', 'style="width:100%;" ')
            ->add('kegiatanjumlahpersonil', 'Jumlah Personil', 'number', true, '', 'style="width:100%;" ')
            ->add('kegiatanketerangan', 'Keterangan', 'text', false, '', 'style="width:100%;" ')
            ->add('kegiatanijin', 'Ijin', 'text', false, '', 'style="width:100%;" ')
            ->add('kegiatansakit', 'Sakit', 'text', false, '', 'style="width:100%;" ')
            ->add('kegiatantanpaketerangan', 'Tanpa Keterangan', 'text', false, '', 'style="width:100%;" ')
            ->add(
                'kategori',
                'Kategori - Sub Kategori',
                'select',
                true,
                '',
                'style="width:100%;" ',
                array(
                    'table' => 'kategori left join sub_kategori on kategori.idkategori = sub_kategori.sub_kategori_idkategori',
                    'id' => "concat(idsub_kategori,'::',sub_kategori_idkategori)",
                    'label' => "concat(kategori.kategorinama,' - ',sub_kategori.sub_kategorinama)"
                )
            );

            if ($form->formVerified()) {
                $data = $form->get_data();
                $kategori = explode("::",$data['kategori']);
                $data['kegiatankategori'] = $kategori[1];
                $data['kegiatansubkategori'] = $kategori[0];
                $data['kegiatancreatedat'] = date("Y-m-d H:i:s");
                $data['kegiatancreatedby'] = $this->user['user_id'];
                unset($data['kategori']);
                $this->db->table("kegiatan")->insert($data);
                $this->session->setFlashdata('success', "Sukses Input Kegiatan ".$data['kegiatanjudul']);
                die(forceRedirect(base_url("admin")));
            } else {
                return $form->output();
            }
    }
}
