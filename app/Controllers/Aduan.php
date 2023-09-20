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
use App\Libraries\SmartComponent\ListView;
use App\Libraries\SmartComponent\Form;

class Aduan extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Aduan Kasus';
        $data['form'] = $this->form();
        return view('aduan', $data);
    }

    public function Detail($id)
    {
        $data['title']  = 'Kasus Detail';
        $data['form'] = $this->resume($id);
        return view('aduan', $data);
    }

    public function resume($id){
        $data_kasus = $this->db->table("kasus")->getWhere(["kasusid"=>$id])->getRowArray();

        $form = new Form();
        $form->set_resume(true)
            ->set_template('admin/sf_kasus_resume',$data_kasus)
            ->add('kasusjudul', 'Judul Kasus', 'text', true, $data_kasus['kasusjudul'], 'style="width:100%;" ')
            ->add('kasuscatatanpetugas', 'Catatan Petugas', 'text', true, $data_kasus['kasuscatatanpetugas'], 'style="width:100%;" ')
            ->add('kasusdeskripsi', 'Deskripsi', 'textEditor', true, $data_kasus['kasusdeskripsi'], 'style="width:100%;" ')
            ->add('kasuslatitude', 'Latitude', 'text', false, $data_kasus['kasuslatitude'], 'style="width:100%;" readonly')
            ->add('kasuslongitude', 'Longitude', 'text', false, $data_kasus['kasuslongitude'], 'style="width:100%;" readonly')
            ->add('kasustanggal', 'Tanggal Kasus', 'datetime', true, $data_kasus['kasustanggal'], 'style="width:100%;" ')
            ->add('kasusfoto', 'Foto / Dokumen', 'file', false, '', 'style="width:100%;" ')
            ->add('kasustanggalinformasi', 'Tanggal Informasi (Tanggal Surat, Postingan, Laporan)', 'date', false, $data_kasus['kasustanggalinformasi'], 'style="width:100%;" ')
            ->add('kasusnomorsurat', 'Nomor Surat / Link Postingan / Berita', 'text', false, $data_kasus['kasusnomorsurat'], 'style="width:100%;" ')
            ->add('kasusstatus', 'Status', 'select', true, $data_kasus['kasusstatus'], 'style="width:100%;" ',
                array(
                    'table' => 'status',
                    'id' => 'statusid',
                    'label' => 'statusname'
                )
            )
            ->add(
                'kasusurusan',
                'Urusan',
                'select',
                true,
                $data_kasus['kasusurusan'],
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
                $data_kasus['kasussubkategori']."::".$data_kasus['kasuskategori'],
                'style="width:100%;" ',
                array(
                    'table' => 'kategori left join sub_kategori on kategori.idkategori = sub_kategori.sub_kategori_idkategori',
                    'id' => "concat(idsub_kategori,'::',sub_kategori_idkategori)",
                    'label' => "concat(kategori.kategorinama,' - ',sub_kategori.sub_kategorinama)"
                )
            );
            
            return $form->output();
    }

    public function Search(){
        $data['title']  = 'Lihat Kasus Saya';
        $data['grid'] = $this->grid();
        return view('search', $data);
    }

    public function grid(){
        $SQL = "select *, kasusid as id from kasus";

        $template = '<div class="col-sm-4 list">#:kasusjudul#</div>';

        $url_detail = base_url('Aduan/Detail');

        $template = <<<HTML
                    <div class="card mb-3" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">#:kasusjudul#</h5>
                            <p class="card-text">#:kasusdeskripsi#</p>
                            <em>#:kasustanggal#</em>
                        </div>
                        <div class="card-body">
                            <a href={$url_detail}/#:kasusid# class="btn btn-sm btn-primary float-right"><i class="k-icon k-i-eye"/> Lihat</a>
                        </div>
                    </div>
                    HTML;

        $nohp = $this->request->getGet('nohp');
        if($nohp==""){
            $nohp = "x";
        }
        $list = new ListView();
        return $list->set_datasource(array(
            'url' => base_url("Aduan/grid?datasource&" . get_query_string()),
        ))
            ->set_query($SQL, array(
                ['kasusnohp', $nohp, '=']
            ))
            ->set_title("")
            ->set_template($template)
            ->output();
    }

    public function form()
    {
        $form = new Form();
        $form
            ->set_form_action("./Aduan/form")
            ->set_form_method('POST')
            ->set_template('sf_kasus',array())
            ->add('kasusnohp', 'Nomor HP', 'text', true, '', 'style="width:100%;" ')
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
            ->add(
                'kasusdesaid',
                'Desa',
                'select',
                false,
                '',
                'style="width:100%;" ',
                array(
                    'table' => 'master_desa',
                    'id' => "idmaster_desa",
                    'label' => "concat(nama_desa,' - ',nama_kec)"
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
                    $data['kasuscreatedby'] = $data['kasusnohp'];
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
