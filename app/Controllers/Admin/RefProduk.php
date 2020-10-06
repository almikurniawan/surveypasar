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

class RefProduk extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Produk';

        return view('admin/refProduk', $data);
    }

    public function grid()
    {
        $SQL = "select ref_produk_id as id,* from ref_produk";

        $action['edit']     = array(
            'link'          => 'admin/refProduk/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteProduk'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('ref_produk_label', $this->request->getGet('produk'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/refProduk/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_label',
                            'title' => 'Nama produk',
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/refProduk/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('produk', 'produk', 'text', false, $this->request->getGet('produk'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah produk';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit produk';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $cek = $this->db->table('ref_produk_varian')->getWhere(['ref_produk_var_produk_id' => $id])->getRowArray();
        if ($cek == null) {
            $this->db->table('ref_produk')->delete(['ref_produk_id' => $id]);
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
                    'message' => 'Tidak bisa menghapus data'
                )
            );
        }
    }
    public function form($id = null)
    {

        if ($id != null) {
            $data = $this->db->table('ref_produk')->getWhere(['ref_produk_id' => $id])->getRowArray();
        } else {
            $data = array(
                'ref_produk_label' => '',
            );
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')->set_form_action(base_url(('admin/refProduk/form/' . $id)))
            ->add('ref_produk_label', 'Nama Pedagang', 'text', true, ($data) ? $data['ref_produk_label'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'ref_produk_label'    => $this->request->getPost('ref_produk_label'),
                );
                $this->db->table('ref_produk')->where('ref_produk_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/refProduk')));
            } else {
                $data_insert = array(
                    'ref_produk_label'    => $this->request->getPost('ref_produk_label'),
                );
                $this->db->table('ref_produk')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/refProduk')));
            }
        } else {
            return $form->output();
        }
    }
}
