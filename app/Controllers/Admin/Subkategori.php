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

class Subkategori extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Sub Kategori';

        return view('admin/subkategori', $data);
    }

    public function grid()
    {
        $SQL = "select *, idsub_kategori as id 
        from sub_kategori
        left join kategori on kategori.idkategori = sub_kategori.sub_kategori_idkategori";

        $action['edit']     = array(
            'link'          => 'admin/subkategori/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteProduk'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('sub_kategori_idkategori', $this->request->getGet('sub_kategori_idkategori'), '='),
            array('sub_kategorinama', $this->request->getGet('sub_kategorinama'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/subkategori/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'kategorinama',
                            'title' => 'Kategori',
                        ),
                        array(
                            'field' => 'sub_kategorinama',
                            'title' => 'Sub Kategori',
                        )
                    ),
                    // 'action'    => $action,
                    // 'head_left' => array('add' => base_url('/admin/subkategori/add')),
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
            ->add('sub_kategori_idkategori', 'Kategori', 'select', false, $this->request->getGet('sub_kategori_idkategori'), 'style="width:100%;" ',
                array(
                    'table' => 'kategori',
                    'id' => 'idkategori',
                    'label' => 'kategorinama'
                )
            )
            ->add('sub_kategorinama', 'Sub Kategori', 'text', false, $this->request->getGet('sub_kategorinama'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Sub Kategori';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit produk varian';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->db->table('ref_produk_varian')->delete(['ref_produk_var_id' => $id]);
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
        if ($id != null) {
            $data = $this->db->table('ref_produk_varian')->getWhere(['ref_produk_var_id' => $id])->getRowArray();
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')->set_form_action(base_url(('admin/RefProdukVarian/form/' . $id)))
            ->add('ref_produk_var_produk_id', 'Nama Produk', 'select', true, ($data) ? $data['ref_produk_var_produk_id'] : '', 'style="width:100%;"', array(
                'table' => 'ref_produk',
                'id' => 'ref_produk_id',
                'label' => 'ref_produk_label',
            ))
            ->add('ref_produk_var_label', 'Varian', 'text', true, ($data) ? $data['ref_produk_var_label'] : '', 'style="width:100%;"')
            ->add('ref_produk_var_satuan_id', 'Satuan', 'select', true, ($data) ? $data['ref_produk_var_satuan_id'] : '', 'style="width:100%;"', array(
                'table' => 'ref_produk_satuan',
                'id' => 'ref_produk_satuan_id',
                'label' => 'ref_produk_satuan_label',
            ))
            ->add('ref_produk_var_urutan', 'Urutan', 'number', true, ($data) ? $data['ref_produk_var_urutan'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'ref_produk_var_produk_id'    => $this->request->getPost('ref_produk_var_produk_id'),
                    'ref_produk_var_label'    => $this->request->getPost('ref_produk_var_label'),
                    'ref_produk_var_satuan_id'    => $this->request->getPost('ref_produk_var_satuan_id'),
                    'ref_produk_var_urutan'    => $this->request->getPost('ref_produk_var_urutan'),
                );
                $this->db->table('ref_produk_varian')->where('ref_produk_var_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/RefProdukVarian')));
            } else {
                $data_insert = array(
                    'ref_produk_var_produk_id'    => $this->request->getPost('ref_produk_var_produk_id'),
                    'ref_produk_var_label'    => $this->request->getPost('ref_produk_var_label'),
                    'ref_produk_var_satuan_id'    => $this->request->getPost('ref_produk_var_satuan_id'),
                    'ref_produk_var_urutan'    => $this->request->getPost('ref_produk_var_urutan'),
                );
                $this->db->table('ref_produk_varian')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/RefProdukVarian')));
            }
        } else {
            return $form->output();
        }
    }
}
