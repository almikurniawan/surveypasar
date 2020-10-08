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

class RefProdukSatuan extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Satuan';

        return view('admin/refProdukSatuan', $data);
    }

    public function grid()
    {
        $SQL = "select ref_produk_satuan_id as id,* from ref_produk_satuan";

        $action['edit']     = array(
            'link'          => 'admin/refProdukSatuan/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteSatuan'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('ref_produk_satuan_label', $this->request->getGet('satuan'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/refProdukSatuan/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_satuan_label',
                            'title' => 'Nama Satuan',
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/refProdukSatuan/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('satuan', 'satuan', 'text', false, $this->request->getGet('satuan'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Satuan';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Satuan';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $cek = $this->db->table('ref_produk_varian')->getWhere(['ref_produk_var_satuan_id' => $id])->getRowArray();
        if ($cek == null) {
            $this->db->table('ref_produk_satuan')->delete(['ref_produk_satuan_id' => $id]);
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
            $data = $this->db->table('ref_produk_satuan')->getWhere(['ref_produk_satuan_id' => $id])->getRowArray();
        } else {
            $data = array(
                'ref_produk_satuan_label' => '',
            );
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')->set_form_action(base_url(('admin/refProdukSatuan/form/' . $id)))
            ->add('ref_produk_satuan_label', 'Nama Satuan', 'text', true, ($data) ? $data['ref_produk_satuan_label'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'ref_produk_satuan_label'    => $this->request->getPost('ref_produk_satuan_label'),
                );
                $this->db->table('ref_produk_satuan')->where('ref_produk_satuan_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/refProdukSatuan')));
            } else {
                $data_insert = array(
                    'ref_produk_satuan_label'    => $this->request->getPost('ref_produk_satuan_label'),
                );
                $this->db->table('ref_produk_satuan')->insert($data_insert);
                $id = $this->db->insertID();
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/refProdukSatuan')));
            }
        } else {
            return $form->output();
        }
    }
}
