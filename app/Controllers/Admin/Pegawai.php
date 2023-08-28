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

class Pegawai extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Pegawai';

        return view('admin/pegawai', $data);
    }

    public function grid()
    {
        $SQL = "select *, pegawaiid as id 
        from pegawai";

        $action['edit']     = array(
            'link'          => 'admin/pegawai/edit/'
        );
        $action['detail']     = array(
            'link'          => 'admin/pegawai/detail/'
        );
        $action['delete']     = array(
            'jsf'          => 'deletePegawai'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('pegawainamalengkap', $this->request->getGet('pegawainamalengkap'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/pegawai/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'pegawainamalengkap',
                            'title' => 'Nama Lengkap',
                        ),
                        array(
                            'field' => 'pegawainip',
                            'title' => 'NIP',
                        ),
                        array(
                            'field' => 'pegawaigolongan',
                            'title' => 'Golongan',
                        ),
                        array(
                            'field' => 'pegawainamajabatan',
                            'title' => 'Jabatan',
                        ),
                        array(
                            'field' => 'pegawaipendidikan',
                            'title' => 'Pendidikan',
                        )
                    ),
                    'action'    => $action,
                    'head_left' => array('add' => base_url('/admin/pegawai/add')),
                    // 'toolbar'   => array('download')
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('pegawainamalengkap', 'Pegawai', 'text', false, $this->request->getGet('pegawainamalengkap'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Pegawai';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Pegawai';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }

    public function detail($id)
    {
        $data['title']  = 'Detail Pegawai';
        $data['form']   = $this->resume($id);

        return view('admin/add', $data);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('pegawai')->delete(['pegawaiid' => $id]);
        $this->db->table('user')->delete(['user_kar_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }
    
    public function form($id = null)
    {
        $data = false;
        if($id!=null){
            $data = $this->db->table("pegawai")->getWhere(['pegawaiid' => $id])->getRowArray();
            $data_user = $this->db->table("user")->getWhere(['user_kar_id' => $id])->getRowArray();
        }
        
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->set_template_column(2)
            ->add('pegawainamalengkap', 'Nama Lengkap', 'text', true, ($data) ? $data['pegawainamalengkap'] : '', 'style="width:100%;"')
            ->add('pegawainip', 'NIP', 'text', true, ($data) ? $data['pegawainip'] : '', 'style="width:100%;"')
            ->add('pegawaigolongan', 'Golongan', 'text', false, ($data) ? $data['pegawaigolongan'] : '', 'style="width:100%;"')
            ->add('pegawaitmtgol', 'TMT Golongan', 'date', false, ($data) ? $data['pegawaitmtgol'] : '', 'style="width:100%;"')
            ->add('pegawainamajabatan', 'Jabatan', 'text', false, ($data) ? $data['pegawainamajabatan'] : '', 'style="width:100%;"')
            ->add('pegawaiselon', 'Eselon', 'text', false, ($data) ? $data['pegawaiselon'] : '', 'style="width:100%;"')
            ->add('pegawaitmteselon', 'TMT Eselon', 'date', false, ($data) ? $data['pegawaitmteselon'] : '', 'style="width:100%;"')
            ->add('pegawaitanggalmasuk', 'Tanggal Masuk', 'date', false, ($data) ? $data['pegawaitanggalmasuk'] : '', 'style="width:100%;"')
            ->add('pegawailatihan', 'Pelatihan', 'text', false, ($data) ? $data['pegawailatihan'] : '', 'style="width:100%;"')
            ->add('pegawailatihantahun', 'Pelatihan Tahun', 'number', false, ($data) ? $data['pegawailatihantahun'] : '', 'style="width:100%;"')
            ->add('pegawaipendidikan', 'Pendidikan', 'text', false, ($data) ? $data['pegawaipendidikan'] : '', 'style="width:100%;"')
            ->add('pegawaipendidikantahun', 'Pendidikan Tahun', 'number', false, ($data) ? $data['pegawaipendidikantahun'] : '', 'style="width:100%;"')
            ->add('pegawaijk', 'Jenis Kelamin', 'text', false, ($data) ? $data['pegawaijk'] : '', 'style="width:100%;"')
            ->add('pegawaipangkattahun', 'Pangkat Tahun', 'text', false, ($data) ? $data['pegawaipangkattahun'] : '', 'style="width:100%;"')
            ->add('pegawaiberkltahun', 'Berkl Tahun', 'date', false, ($data) ? $data['pegawaiberkltahun'] : '', 'style="width:100%;"')
            ->add('username', 'Username', 'text', false, ($data) ? $data_user['user_name'] : '', 'style="width:100%;"')
            ->add('password', 'Password', 'password', false, ($data) ? '' : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = $form->get_data();
                unset($data_update['username']);
                unset($data_update['password']);
                
                $this->db->table("pegawai")->where('pegawaiid',$id)->update($data_update);
                if($this->request->getPost('password')!=''){
                    $data_update_user = array(
                        'user_name'=> $this->request->getPost('username'),
                        'user_password'=> sha1($this->request->getPost('password')),
                    );
                    $this->db->table("user")->where('user_id',$data_user['user_id'])->update($data_update_user);
                }

                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/pegawai')));
            } else {
                $data_insert = $form->get_data();
                unset($data_insert['username']);
                unset($data_insert['password']);

                $this->db->table('pegawai')->insert($data_insert);
                $idPegawai = $this->db->insertID();

                $adta_insert_user = array(
                    'user_name'=> $this->request->getPost('username'),
                    'user_password'=> sha1($this->request->getPost('password')),
                    'user_kar_id'=> $idPegawai,
                    'user_type'=> 2,
                    'user_nama_lengkap'=> $this->request->getPost('pegawainamalengkap')
                );
                $this->db->table('user')->insert($adta_insert_user);

                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/pegawai')));
            }
        } else {
            return $form->output();
        }
    }


    public function resume($id)
    {
        $data = $this->db->table("pegawai")->getWhere(['pegawaiid' => $id])->getRowArray();
        $data_user = $this->db->table("user")->getWhere(['user_kar_id' => $id])->getRowArray();
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->set_template_column(2)
            ->set_resume(true)
            ->add('pegawainamalengkap', 'Nama Lengkap', 'text', true, ($data) ? $data['pegawainamalengkap'] : '', 'style="width:100%;"')
            ->add('pegawainip', 'NIP', 'text', true, ($data) ? $data['pegawainip'] : '', 'style="width:100%;"')
            ->add('pegawaigolongan', 'Golongan', 'text', false, ($data) ? $data['pegawaigolongan'] : '', 'style="width:100%;"')
            ->add('pegawaitmtgol', 'TMT Golongan', 'date', false, ($data) ? $data['pegawaitmtgol'] : '', 'style="width:100%;"')
            ->add('pegawainamajabatan', 'Jabatan', 'text', false, ($data) ? $data['pegawainamajabatan'] : '', 'style="width:100%;"')
            ->add('pegawaiselon', 'Eselon', 'text', false, ($data) ? $data['pegawaiselon'] : '', 'style="width:100%;"')
            ->add('pegawaitmteselon', 'TMT Eselon', 'date', false, ($data) ? $data['pegawaitmteselon'] : '', 'style="width:100%;"')
            ->add('pegawaitanggalmasuk', 'Tanggal Masuk', 'date', false, ($data) ? $data['pegawaitanggalmasuk'] : '', 'style="width:100%;"')
            ->add('pegawailatihan', 'Pelatihan', 'text', false, ($data) ? $data['pegawailatihan'] : '', 'style="width:100%;"')
            ->add('pegawailatihantahun', 'Pelatihan Tahun', 'text', false, ($data) ? $data['pegawailatihantahun'] : '', 'style="width:100%;"')
            ->add('pegawaipendidikan', 'Pendidikan', 'text', false, ($data) ? $data['pegawaipendidikan'] : '', 'style="width:100%;"')
            ->add('pegawaipendidikantahun', 'Pendidikan Tahun', 'text', false, ($data) ? $data['pegawaipendidikantahun'] : '', 'style="width:100%;"')
            ->add('pegawaijk', 'Jenis Kelamin', 'text', false, ($data) ? $data['pegawaijk'] : '', 'style="width:100%;"')
            ->add('pegawaipangkattahun', 'Pangkat Tahun', 'text', false, ($data) ? $data['pegawaipangkattahun'] : '', 'style="width:100%;"')
            ->add('pegawaiberkltahun', 'Berkl Tahun', 'date', false, ($data) ? $data['pegawaiberkltahun'] : '', 'style="width:100%;"')
            ->add('username', 'Username', 'text', false, ($data) ? $data_user['user_name'] : '', 'style="width:100%;"');
        
        return $form->output();
    }
}
