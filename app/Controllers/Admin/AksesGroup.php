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

class AksesGroup extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = '';

        return view('admin/aksesGroup', $data);
    }

    public function grid()
    {
        $SQL = "select ref_group_akses_id as id,* from ref_group_akses";

        $action['edit']     = array(
            'link'          => 'admin/aksesGroup/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteGroup'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('ref_moudl_akses_label', $this->request->getGet('group'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/aksesGroup/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_group_akses_label',
                            'title' => 'Nama Group',
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/aksesGroup/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('group', 'Group', 'text', false, $this->request->getGet('group'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah group';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit group';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $cek = $this->db->table('ref_modul_akses')->getWhere(['ref_modul_akses_group_id' => $id])->getRowArray();
        if ($cek == null) {
            $this->db->table('ref_group_akses')->delete(['ref_group_akses_id' => $id]);
            return $this->response->setJSON(
                array(
                    'status' => true,
                    'message' => 'Success delete data'
                )
            );
        }else{
            return $this->response->setJSON(
                array(
                    'status' => false,
                    'message' => 'Tidak bisa delete data ini'
                )
            );
        }
    }
    public function form($id = null)
    {

        if ($id != null) {
            $data = $this->db->table('ref_group_akses')->getWhere(['ref_group_akses_id' => $id])->getRowArray();
        } else {
            $data = array(
                'ref_group_akses_label' => '',
            );
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')->set_form_action(base_url(('admin/aksesGroup/form/' . $id)))
            ->add('ref_group_akses_label', 'Nama Group', 'text', true, ($data) ? $data['ref_group_akses_label'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'ref_group_akses_label'    => $this->request->getPost('ref_group_akses_label'),
                );
                $this->db->table('ref_group_akses')->where('ref_group_akses_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/aksesGroup/edit/' . $id)));
            } else {
                $data_insert = array(
                    'ref_group_akses_label'    => $this->request->getPost('ref_group_akses_label'),
                );
                $this->db->table('ref_group_akses')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/aksesGroup/')));
            }
        } else {
            return $form->output();
        }
    }
}
