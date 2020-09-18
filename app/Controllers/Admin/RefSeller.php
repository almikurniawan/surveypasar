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

class RefSeller extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = '';

        return view('admin/refSeller', $data);
    }

    public function grid()
    {
        $SQL = "select seller_id as id,* from seller left join ref_pasar on ref_pasar_id = seller_pasar_id";

        $action['detail']     = array(
            'link'          => 'admin/refSeller/detail/'
        );
        $action['edit']     = array(
            'link'          => 'admin/refSeller/edit/'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('seller_nama',$this->request->getGet('seller'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/refSeller/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'seller_nama',
                            'title' => 'Nama Penjual',
                        ),
                        array(
                            'field' => 'ref_pasar_label',
                            'title' => 'Pasar',
                        ),
                        array(
                            'field' => 'seller_alamat',
                            'title' => 'Alamat',
                        ),
                        array(
                            'field' => 'seller_no_hp',
                            'title' => 'No HP',
                        ),
                    ),
                    'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/refSeller/add'))
                )
            )->output();
    }
    public function grid_detail($id)
    {
        $SQL = "select seller_prod_id as id,* from seller_produk left join seller on seller_id = seller_prod_seller_id 
        left join ref_produk_varian on ref_produk_var_id = seller_prod_produk_var_id";

        $action['delete']     = array(
            'link'          => 'admin/refSeller/delete/'
        );

        $grid = new Grid();
        return $grid->set_query($SQL,array(
            array('seller_prod_seller_id',$id,'=')
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/refSeller/grid_detail/".$id."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_var_label',
                            'title' => 'Nama Produk',
                        ),
                    ),
                    'action'    => $action,
                    // 'head_left'        => array('add' => '/admin/refSeller/add')
                )
            )->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('seller', 'Pedagang', 'text', false, $this->request->getGet('seller'), 'style="width:100%;" ')
            ->output();
    }
    public function search_pilih_produk($id)
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('kategori', 'Kategori', 'select', false, $this->request->getGet('kategori'), 'style="width:100%;" ',
            array(
                'table' => 'ref_produk',
                'id' => 'ref_produk_id',
                'label' => 'ref_produk_label'
            ))
            ->add('varian', 'Sub Kategory', 'text', false, $this->request->getGet('varian'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Tambah Pedagang';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Pedagang';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }

    public function detail($id)
    {
        $data['title']  = 'Detail Produk Pedagang';
        $data['id'] = $id;
        $data['form']   = $this->grid_detail($id);

        return view('admin/refSellerResume', $data);
    }
    public function add_produk($id)
    {
        $data['title']  = 'Add Produk Pedagang';
        $data['id_seller'] = $id;
        $data['search_pilih_produk']   = $this->search_pilih_produk($id);
        $data['grid_pilih_produk']   = $this->grid_pilih_produk($id);

        return view('admin/refSellerResumeAddProduk', $data);
    }

    public function form($id = null)
    {

        if ($id != null) {
            $data = $this->db->table('seller')->getWhere(['seller_id' => $id])->getRowArray();
        } else {
            $data = array(
                'seller_nama' => '',
                'seller_pasar_id' => '',
                'seller_alamat' => '',
                'seller_no_hp' => '',
            );
        }

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('seller_nama', 'Nama Pedagang', 'text', true, ($data) ? $data['seller_nama'] : '', 'style="width:100%;"')
            ->add('seller_pasar_id', 'Pasar', 'select', true, ($data) ? $data['seller_pasar_id'] : '', 'style="width:100%;"', array(
                'table' => 'ref_pasar',
                'id' => 'ref_pasar_id',
                'label' => 'ref_pasar_label',
            ))
            ->add('seller_alamat', 'Alamat', 'text', true, ($data) ? $data['seller_alamat'] : '', 'style="width:100%;"')
            ->add('seller_no_hp', 'No HP', 'text', true, ($data) ? $data['seller_no_hp'] : '', 'style="width:100%;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = array(
                    'seller_nama'    => $this->request->getPost('seller_nama'),
                    'seller_pasar_id' => $this->request->getPost('seller_pasar_id'),
                    'seller_alamat' => $this->request->getPost('seller_alamat'),
                    'seller_no_hp' => $this->request->getPost('seller_no_hp'),
                );
                $this->db->table('seller')->where('seller_id', $id)->update( $data_update);
                $form->output('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/refSeller/detail/'.$id)));
            } else {
                $data_insert = array(
                    'seller_nama'    => $this->request->getPost('seller_nama'),
                    'seller_pasar_id' => $this->request->getPost('seller_pasar_id'),
                    'seller_alamat' => $this->request->getPost('seller_alamat'),
                    'seller_no_hp' => $this->request->getPost('seller_no_hp'),
                );
                $this->db->table('seller')->insert( $data_insert);
                $id = $this->db->insertID();
                $form->output('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/refSeller/detail/'.$id)));
            }
        } else {
            return $form->output();
        }
    }
    public function resume($id)
    {
        $data = $this->db->table('seller')->getWhere(['seller_id' => $id])->getRowArray();
        return view('admin/refSellerResume', $data);
    }
    public function grid_pilih_produk($id)
    {
        $SQL = "select ref_produk_var_id AS ID,*, concat('<button class=\"btn btn-success btn-xs\" onclick=\"pilih(',ref_produk_var_id,')\"><i class=\"k-i-check-outline\">pilih</button>') as pilih
        FROM
        ref_produk_varian
        ";
        $grid = new Grid();
        return $grid->set_query($SQL,array(
            array('ref_produk_var_id', '(select seller_prod_produk_var_id from seller_produk where seller_prod_seller_id = '.$id.')','not in'),
            array('ref_produk_var_produk_id',$this->request->getGet('kategori'), '='),
            array('ref_produk_var_label',$this->request->getGet('varian'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/refSeller/grid_pilih_produk/".$id."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_var_label',
                            'title' => 'Nama Produk',
                        ),
                        array(
                            'field' => 'pilih',
                            'title' => 'pilih',
                            'encoded' => false
                        ),
                    ),
                )
            )->output();
    }
    public function pilih()
    {
        $data_insert = array(
            'seller_prod_seller_id'    => $this->request->getPost('id_seller'),
            'seller_prod_produk_var_id' => $this->request->getPost('id')
        );
        $this->db->table('seller_produk')->insert( $data_insert);
        return $this->response->setJSON(
			array(
				'status'=> true,
				'message'=> 'Success tambah data'
			)
		);
    }
}
