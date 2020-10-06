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

class AksesUser extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = '';

        return view('admin/aksesUser', $data);
    }

    public function grid()
    {
        $SQL = "SELECT
        user_id AS ID,user_name,
        ARRAY_TO_STRING(( SELECT ARRAY_AGG(ref_group_akses_label) FROM ref_user_akses left join ref_group_akses on ref_group_akses_id = ref_user_akses_group_id where ref_user_akses_user_id = user_id ),', ') as group
    FROM
        PUBLIC.USER";

        $action['edit']     = array(
            'link'          => 'admin/aksesUser/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteUser'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('user_name', $this->request->getGet('user'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/aksesUser/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'user_name',
                            'title' => 'Nama User',
                        ),
                        array(
                            'field' => 'group',
                            'title' => 'Group',
                            'encoded' => false
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/aksesUser/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('user', 'Username', 'text', false, $this->request->getGet('user'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah user';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit user';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('ref_user_akses')->delete(['ref_user_akses_id' => $id]);
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
            $data = $this->db->table('user')->getWhere(['user_id' => $id])->getRowArray();
            $group = $this->db->table('ref_user_akses')->select('ref_user_akses_group_id')->getWhere(['ref_user_akses_user_id' => $id])->getResultArray();
            foreach ($group as $key => $value) {
                $group[] = $value['ref_user_akses_group_id'];
            }
        } else {
            $data = array(
                'group' => array(),
                'user_name' => '',
                'user_password' => '',
                'user_namalengkap' => '',
            );
            $group = array();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')->set_form_action(base_url(('admin/aksesUser/form/' . $id)))
            ->add('user_namalengkap', 'Nama Lengkap', 'text', true, ($data) ? $data['user_namalengkap'] : '', 'style="width:100%;"')
            ->add('user_name', 'Username', 'text', true, ($data) ? $data['user_name'] : '', 'style="width:100%;"')
            ->add('user_password', 'Password', 'password', false, '', 'style="width:100%;"')
            ->add('ref_user_akses_group_id', 'Nama Group', 'select_multiple', true, ($data) ? $group : '', ' style="width:100%;"', array(
                'table' => 'ref_group_akses',
                'id' => 'ref_group_akses_id',
                'label' => 'ref_group_akses_label',
            ));
        if ($form->formVerified()) {
            $data_insert = array(
                'user_namalengkap'    => $this->request->getPost('user_namalengkap'),
                'user_name'    => $this->request->getPost('user_name'),
                // 'user_password'    => sha1($this->request->getPost('user_password')),
            );
            if($this->request->getPost('user_password')!=''){
                $data_insert['user_password'] = sha1($this->request->getPost('user_password'));
            }
            if ($id != null) {
                $this->db->table('public.user')->where('user_id', $id)->update($data_insert);
                $this->db->table('ref_user_akses')->delete(['ref_user_akses_user_id' => $id]);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
            } else {
                $this->db->table('public.user')->insert($data_insert);
                $id = $this->db->insertID();
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
            }
            foreach ($this->request->getPost('ref_user_akses_group_id') as $key => $value) {
                $this->db->table('ref_user_akses')->insert(array(
                    'ref_user_akses_user_id' => $id,
                    'ref_user_akses_group_id' => $value
                ));
            }
            die(forceRedirect(base_url('/admin/aksesUser/edit/' . $id)));
        } else {
            return $form->output();
        }
    }
}
