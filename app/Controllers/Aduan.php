<?php

namespace App\Controllers;

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

class Aduan extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Aduan Kasus';
        $data['form'] = $this->form();
        return view('aduan', $data);
    }

    public function form()
    {
        $form = new Form();
        $form
            ->set_form_action("./Aduan/form")
            ->set_form_method('POST')
            ->set_template('sf_kasus',array())
            ->add('kasusjudul', 'Judul Kasus', 'text', true, '', 'style="width:100%;" ')
            ->add('kasusdeskripsi', 'Deskripsi', 'textArea', true, '', 'style="width:100%;" ')
            ->add(
                'kasusurusan',
                'Urusan',
                'select',
                true,
                '',
                'style="width:100%;" ',
                array(
                    'table' => 'urusan',
                    'id' => "urusanid",
                    'label' => "urusannama"
                )
            )
            ->add(
                'tantrib',
                'Tantrib',
                'select',
                true,
                '',
                'style="width:100%;" ',
                array(
                    'table' => 'kategori left join sub_kategori on kategori.idkategori = sub_kategori.sub_kategori_idkategori',
                    'id' => "concat(idsub_kategori,'::',sub_kategori_idkategori)",
                    'label' => "concat(kategori.kategorinama,' - ',sub_kategori.sub_kategorinama)"
                )
            )
            ->add('kasuslatitude', 'Latitude', 'text', false, '', 'style="width:100%;" readonly')
            ->add('kasuslongitude', 'Longitude', 'text', false, '', 'style="width:100%;" readonly')
            ->add('kasustanggal', 'Tanggal Kasus', 'datetime', true, '', 'style="width:100%;" ')
            ->add('kasusfoto', 'Foto / Dokumen', 'file', false, '', 'style="width:100%;" ')
            ->add('kasustanggalinformasi', 'Tanggal Informasi (Tanggal Surat, Postingan, Laporan)', 'date', false, '', 'style="width:100%;" ')
            ->add('kasusnomorsurat', 'Nomor Surat / Link Postingan / Berita', 'text', false, '', 'style="width:100%;" ');

            if ($form->formVerified()) {
                try {
                    $data = $form->get_data();
                    $file = $this->request->getFile('kasusfoto');
                    if ($file->getName() != '') {
                        $ext = $file->getClientExtension();
                        $name = $file->getName();
                        $name = $file->getRandomName();
                        if ($file->move('./uploads/', $name)) {
                            $data['kasusfile'] = $name;
                        }
                    }

                    $kategori = explode("::",$data['tantrib']);
                    $data['kasuskategori'] = $kategori[1];
                    $data['kasussubkategori'] = $kategori[0];
                    $data['kasuscreatedat'] = date("Y-m-d H:i:s");
                    $data['kasuscreatedby'] = $this->user['user_id'];
                    $data['kasussumber'] = "masyarakat";
                    $data['kasusstatus'] = 1;

                    unset($data['tantrib']);
                    $this->db->table("kasus")->insert($data);
                    $this->session->setFlashdata('success', "Sukses Mengadukan Kasus ".$data['kasusjudul']);
                    die(forceRedirect(base_url("Aduan/success")));
                } catch (\mysqli_sql_exception $th) {
                    //throw $th;
                    dd($th);
                }
                
            } else {
                return $form->output();
            }
    }

    public function success(){
        
        $data['title']  = 'Aduan Kasus';
        return view('aduan_success', $data);
    }
}
