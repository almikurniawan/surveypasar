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

class Kegiatan extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'List Kegiatan';
        $data['search'] = $this->search();
        $data['grid'] = $this->grid();
        return view('admin/kegiatan_list', $data);
    }

    private function search(){
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('kegiatanjudul', 'Kegiatan', 'text', false, $this->request->getGet('kegiatanjudul'), 'style="width:100%;" ')
            ->add('kegiatankategori', 'Kategori', 'select', false, $this->request->getGet('kegiatankategori'), 'style="width:100%;" ',
                array(
                    'table' => 'kategori',
                    'id' => 'idkategori',
                    'label' => 'kategorinama'
                )
            )
            ->add('kegiatansubkategori', 'Sub Kategori', 'select', false, $this->request->getGet('kegiatansubkategori'), 'style="width:100%;" ',
                array(
                    'table' => 'sub_kategori',
                    'id' => 'idsub_kategori',
                    'label' => 'sub_kategorinama'
                )
            )
            ->output();
    }

    public function grid()
    {
        $SQL = "select *, idkegiatan as id from kegiatan
        left join kategori on kegiatan.kegiatankategori = kategori.idkategori
        left join sub_kategori on sub_kategori.idsub_kategori = kegiatan.kegiatansubkategori
        left join user on user_id = kegiatan.kegiatancreatedby
        ";

        $action['edit']     = array(
            'link'          => 'admin/kegiatan/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/kegiatan/detail/'
        );
        // $action['delete']     = array(
        //     'jsf'          => 'deleteKegiatan'
        // );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('kegiatanjudul', $this->request->getGet('kegiatanjudul')),
            array('kegiatankategori', $this->request->getGet('kegiatankategori'),'='),
            array('kegiatansubkategori', $this->request->getGet('kegiatansubkategori'),'=')
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/kegiatan/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'kegiatanjudul',
                            'title' => 'Kegiatan',
                        ),
                        array(
                            'field' => 'kegiatantanggal',
                            'title' => 'Tanggal',
                            'format'=> 'datetime'
                        ),
                        array(
                            'field' => 'kegiatanjumlahpersonil',
                            'title' => 'Personil'
                        ),
                        array(
                            'field' => 'kegiatanketerangan',
                            'title' => 'Keterangan'
                        ),
                        array(
                            'field' => 'kategorinama',
                            'title' => 'Kategori'
                        ),
                        array(
                            'field' => 'sub_kategorinama',
                            'title' => 'Sub Kategori'
                        ),
                        array(
                            'field' => 'user_nama_lengkap',
                            'title' => 'Oleh'
                        )
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin'))
                )
            )->output();
    }

    public function edit($id){
        $data['title']  = 'Edit Kegiatan';
        $data['form']   = $this->form($id);

        return view('admin/kegiatan_edit', $data);
    }

    public function form($id){
        $data_edit = $this->db->table("kegiatan")->getWhere(['idkegiatan' => $id])->getRowArray();
        $form = new Form();
        $form
            ->set_form_method('POST')
            ->add('kegiatantanggal', 'Tanggal Kegiatan', 'datetime', true, $data_edit['kegiatantanggal'], 'style="width:100%;" ')
            ->add('kegiatanjudul', 'Judul', 'text', true,  $data_edit['kegiatanjudul'], 'style="width:100%;" ')
            ->add('kegiatanjumlahpersonil', 'Jumlah Personil', 'number', true, $data_edit['kegiatanjumlahpersonil'], 'style="width:100%;" ')
            ->add('kegiatanketerangan', 'Keterangan', 'text', false, $data_edit['kegiatanketerangan'], 'style="width:100%;" ')
            ->add('kegiatanijin', 'Ijin', 'text', false, $data_edit['kegiatanijin'], 'style="width:100%;" ')
            ->add('kegiatansakit', 'Sakit', 'text', false, $data_edit['kegiatansakit'], 'style="width:100%;" ')
            ->add('kegiatantanpaketerangan', 'Tanpa Keterangan', 'text', false, $data_edit['kegiatantanpaketerangan'], 'style="width:100%;" ')
            ->add(
                'kategori',
                'Kategori - Sub Kategori',
                'select',
                true,
                $data_edit['kegiatansubkategori']."::".$data_edit['kegiatankategori'],
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
                unset($data['kategori']);
                $this->db->table("kegiatan")->where('idkegiatan',$id)->update($data);
                $this->session->setFlashdata('success', "Sukses Update Kegiatan ".$data['kegiatanjudul']);
                die(forceRedirect(base_url("admin/kegiatan/edit/".$id)));
            } else {
                return $form->output();
            }
    }

    public function detail($id){
        $data['title']  = 'Detail Kegiatan';
        $data['form']   = $this->resume($id);

        return view('admin/kegiatan_detail', $data);
    }

    private function resume($id){
        $data_edit = $this->db->table("kegiatan")->getWhere(['idkegiatan' => $id])->getRowArray();
        $form = new Form();
        $form
            ->set_resume(true)
            ->set_template_column(2)
            ->set_form_method('POST')
            ->add('kegiatantanggal', 'Tanggal Kegiatan', 'datetime', true, $data_edit['kegiatantanggal'], 'style="width:100%;" ')
            ->add('kegiatanjudul', 'Judul', 'text', true,  $data_edit['kegiatanjudul'], 'style="width:100%;" ')
            ->add('kegiatanjumlahpersonil', 'Jumlah Personil', 'number', true, $data_edit['kegiatanjumlahpersonil'], 'style="width:100%;" ')
            ->add('kegiatanketerangan', 'Keterangan', 'text', false, $data_edit['kegiatanketerangan'], 'style="width:100%;" ')
            ->add('kegiatanijin', 'Ijin', 'text', false, $data_edit['kegiatanijin'], 'style="width:100%;" ')
            ->add('kegiatansakit', 'Sakit', 'text', false, $data_edit['kegiatansakit'], 'style="width:100%;" ')
            ->add('kegiatantanpaketerangan', 'Tanpa Keterangan', 'text', false, $data_edit['kegiatantanpaketerangan'], 'style="width:100%;" ')
            ->add(
                'kategori',
                'Kategori - Sub Kategori',
                'select',
                true,
                $data_edit['kegiatansubkategori']."::".$data_edit['kegiatankategori'],
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
