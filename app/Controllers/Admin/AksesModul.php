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

class AksesModul extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = '';

        return view('admin/aksesModul', $data);
    }

    public function grid()
    {
        $SQL = "select ref_modul_akses_id as id,* from ref_modul_akses
        left join ref_group_akses on ref_modul_akses_group_id = ref_group_akses_id";

        $action['edit']     = array(
            'link'          => 'admin/aksesModul/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteModul'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('ref_modul_akses_label', $this->request->getGet('modul')),
            array('ref_modul_akses_group_id', $this->request->getGet('group'), '=')
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/aksesModul/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_modul_akses_label',
                            'title' => 'Nama Modul',
                        ),
                        array(
                            'field' => 'ref_group_akses_label',
                            'title' => 'Nama Group',
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/aksesModul/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('modul', 'Modul', 'text', false, $this->request->getGet('modul'), 'style="width:100%;" ')
            ->add('group', 'Nama Group', 'select', true, $this->request->getGet('group'), 'style="width:100%;"', array(
                'table' => 'ref_group_akses',
                'id' => 'ref_group_akses_id',
                'label' => 'ref_group_akses_label',
            ))
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Modul';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Modul';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');

        $this->db->table('ref_modul_akses')->delete(['ref_modul_akses_id' => $id]);
        return $this->response->setJSON(
            array(
                'status' => true,
                'message' => 'Success delete data'
            )
        );
    }
    public function form($id = null)
    {

        if ($id != null) {
            $data = $this->db->table('ref_modul_akses')->getWhere(['ref_modul_akses_id' => $id])->getRowArray();
        } else {
            $data = array(
                'ref_modul_akses_group_id' => '',
                'ref_modul_akses_label' => '',
            );
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('ref_modul_akses_group_id', 'Nama Group', 'select', true, ($data) ? $data['ref_modul_akses_group_id'] : '', 'style="width:100%;"', array(
                'table' => 'ref_group_akses',
                'id' => 'ref_group_akses_id',
                'label' => 'ref_group_akses_label',
            ))
            ->add('ref_modul_akses_label', 'Nama modul', 'text', true, ($data) ? $data['ref_modul_akses_label'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'ref_modul_akses_group_id'    => $this->request->getPost('ref_modul_akses_group_id'),
                    'ref_modul_akses_label'    => $this->request->getPost('ref_modul_akses_label'),
                );
                $this->db->table('ref_modul_akses')->where('ref_modul_akses_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/aksesModul/edit/' . $id)));
            } else {
                $data_insert = array(
                    'ref_modul_akses_group_id'    => $this->request->getPost('ref_modul_akses_group_id'),
                    'ref_modul_akses_label'    => $this->request->getPost('ref_modul_akses_label'),
                );
                $this->db->table('ref_modul_akses')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                return $form->output();
                // die(forceRedirect(base_url('/admin/aksesModul/edit/' . $id)));
            }
        } else {
            return $form->output();
        }
    }
}
