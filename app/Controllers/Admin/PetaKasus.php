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

class PetaKasus extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Peta Kasus';
        $data['kasus'] = $this->db->query("select *, kasusid as id, concat(kategori.kategorinama,' - ',sub_kategori.sub_kategorinama) as tantrib from kasus
        left join kategori on kasus.kasuskategori = kategori.idkategori
        left join sub_kategori on sub_kategori.idsub_kategori = kasus.kasussubkategori
        left join user on user_id = kasus.kasuscreatedby
        left join urusan on urusanid = kasusurusan
        left join status on statusid = kasus.kasusstatus")->getResultArray();

        // dd($data['kasus']);
        return view('admin/peta_kasus', $data);
    }

    private function search(){
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('kasusjudul', 'Kasus', 'text', false, $this->request->getGet('kasusjudul'), 'style="width:100%;" ')
            ->add('kasuskategori', 'Kategori', 'select', false, $this->request->getGet('kasuskategori'), 'style="width:100%;" ',
                array(
                    'table' => 'kategori',
                    'id' => 'idkategori',
                    'label' => 'kategorinama'
                )
            )
            ->add('kasussubkategori', 'Sub Kategori', 'select', false, $this->request->getGet('kasussubkategori'), 'style="width:100%;" ',
                array(
                    'table' => 'sub_kategori',
                    'id' => 'idsub_kategori',
                    'label' => 'sub_kategorinama'
                )
            )
            ->add('kasusstatus', 'Status', 'select', false, $this->request->getGet('kasusstatus'), 'style="width:100%;" ',
                array(
                    'table' => 'status',
                    'id' => 'statusid',
                    'label' => 'statusname'
                )
            )
            ->output();
    }

    public function grid()
    {
        $SQL = "select *, kasusid as id, concat(kategori.kategorinama,' - ',sub_kategori.sub_kategorinama) as tantrib from kasus
        left join kategori on kasus.kasuskategori = kategori.idkategori
        left join sub_kategori on sub_kategori.idsub_kategori = kasus.kasussubkategori
        left join user on user_id = kasus.kasuscreatedby
        left join status on statusid = kasus.kasusstatus
        ";

        $action['edit']     = array(
            'link'          => 'admin/kasus/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/kasus/detail/'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('kasusjudul', $this->request->getGet('kasusjudul')),
            array('kasuskategori', $this->request->getGet('kasuskategori'),'='),
            array('kasussubkategori', $this->request->getGet('kasussubkategori'),'='),
            array('kasusstatus', $this->request->getGet('kasusstatus'),'=')
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/kasus/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'kasusjudul',
                            'title' => 'Kasus',
                        ),
                        array(
                            'field' => 'kasustanggal',
                            'title' => 'Tanggal',
                            'format'=> 'datetime'
                        ),
                        array(
                            'field' => 'tantrib',
                            'title' => 'Tantrib'
                        ),
                        array(
                            'field' => 'statusname',
                            'title' => 'Status'
                        ),
                        array(
                            'field' => 'user_nama_lengkap',
                            'title' => 'Oleh'
                        )
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/kasus/add'))
                )
            )->output();
    }

    public function edit($id){
        $data['title']  = 'Edit Kasus';
        $data['form']   = $this->form_edit($id);

        return view('admin/kasus_add', $data);
    }

    public function detail($id){
        $data['title']  = 'Detail Kasus';
        $data['form']   = $this->resume($id);

        return view('admin/kasus_add', $data);
    }

    public function add(){
        $data['title']  = 'Buat Kasus';
        $data['form']   = $this->form();

        return view('admin/kasus_add', $data);
    }

    public function form(){
        $form = new Form();
        $form
            ->set_form_method('POST')
            ->set_template('admin/sf_kasus',array())
            ->add('kasusjudul', 'Judul Kasus', 'text', true, '', 'style="width:100%;" ')
            ->add('kasusdeskripsi', 'Deskripsi', 'textEditor', true, '', 'style="width:100%;" ')
            ->add('kasuslatitude', 'Latitude', 'text', false, '', 'style="width:100%;" readonly')
            ->add('kasuslongitude', 'Longitude', 'text', false, '', 'style="width:100%;" readonly')
            ->add('kasustanggal', 'Tanggal Kasus', 'datetime', true, '', 'style="width:100%;" ')
            ->add('kasusfoto', 'Foto / Dokumen', 'file', false, '', 'style="width:100%;" ')
            ->add('kasustanggalinformasi', 'Tanggal Informasi (Tanggal Surat, Postingan, Laporan)', 'date', false, '', 'style="width:100%;" ')
            ->add('kasusnomorsurat', 'Nomor Surat / Link Postingan / Berita', 'text', false, '', 'style="width:100%;" ')
            ->add('kasusstatus', 'Status', 'select', true, $this->request->getGet('kasusstatus'), 'style="width:100%;" ',
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
            );

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
                    $data['kasussumber'] = "operator";

                    unset($data['tantrib']);
                    $this->db->table("kasus")->insert($data);
                    $this->session->setFlashdata('success', "Sukses Insert Kasus ".$data['kasusjudul']);
                    die(forceRedirect(base_url("admin/kasus")));
                } catch (\mysqli_sql_exception $th) {
                    //throw $th;
                    dd($th);
                }
                
            } else {
                return $form->output();
            }
    }

    public function form_edit($id){
        $data_kasus = $this->db->table("kasus")->getWhere(["kasusid"=>$id])->getRowArray();

        $form = new Form();
        $form
            ->set_form_method('POST')
            ->set_template('admin/sf_kasus_edit',$data_kasus)
            ->add('kasusjudul', 'Judul Kasus', 'text', true, $data_kasus['kasusjudul'], 'style="width:100%;" ')
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

                    unset($data['tantrib']);
                    $this->db->table("kasus")->where("kasusid",$id)->update($data);
                    $this->session->setFlashdata('success', "Sukses Insert Kasus ".$data['kasusjudul']);
                    die(forceRedirect(base_url("admin/kasus")));
                } catch (\mysqli_sql_exception $th) {
                    //throw $th;
                    dd($th);
                }
                
            } else {
                return $form->output();
            }
    }

    public function resume($id){
        $data_kasus = $this->db->table("kasus")->getWhere(["kasusid"=>$id])->getRowArray();

        $form = new Form();
        $form->set_resume(true)
            ->set_template('admin/sf_kasus_resume',$data_kasus)
            ->add('kasusjudul', 'Judul Kasus', 'text', true, $data_kasus['kasusjudul'], 'style="width:100%;" ')
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
}
