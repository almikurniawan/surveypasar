<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Validasi extends BaseController
{
    public function index()
    {
        $data['title']   = 'Validasi';
        $data['grid']   = $this->gridValidasi();
        $data['search'] = $this->search();
        return view('admin/validasi', $data);
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal', 'Tanggal', 'date', false, ($this->request->getGet('tanggal') == '' ? date("Y-m-d") : $this->request->getGet('tanggal')), 'style="width:100%;" ')
            ->add(
                'seller',
                'Pedagang',
                'select',
                false,
                $this->request->getGet('seller'),
                'style="width:100%;" ',
                array(
                    'table' => 'seller left join ref_pasar on ref_pasar_id = seller_pasar_id',
                    'id' => 'seller_id',
                    'label' => "seller_nama||' - '||ref_pasar_label"
                )
            )->output();
    }

    public function gridValidasi()
    {
        $SQL = "select *, survey_head_id as id from survey_header left join public.user on public.user.user_id = survey_head_created_by left join seller on seller_id = survey_head_seller_id  where survey_head_reject_is is not true and survey_head_approve_is is not true";
        $action['detail']     = array(
            'link'          => 'admin/validasi/detail/'
        );
        $grid = new Grid();
        return $grid->set_query($SQL)
            ->configure(

                array(
                    'datasouce_url' => base_url("admin/validasi/gridValidasi?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'user_namalengkap',
                            'title' => 'Surveyor',
                        ),
                        array(
                            'field' => 'survey_head_tanggal',
                            'title' => 'Tanggal',
                            'format' => 'date'
                        ),
                        array(
                            'field' => 'seller_nama',
                            'title' => 'Pedagang'
                        )
                    ),
                    'action'    => $action,
                )

            )->output();
    }
    public function detail($id)
    {
        $data['title']  = 'Detail Produk Pedagang';
        $data['id'] = $id;
        $data['grid']   = $this->gridDetail($id);

        return view('admin/validasiDetail', $data);
    }
    public function gridDetail($id)
    {
        $SQL = "select survey_det_id as id,* from survey_detail
        left join ref_produk_varian on ref_produk_var_id = survey_det_produk_var_id 
        left join ref_produk_satuan on ref_produk_satuan_id = ref_produk_var_satuan_id 
        left join ref_produk on ref_produk_id = ref_produk_var_produk_id
        where survey_det_head_id=".$id;
        // die($SQL);
        $grid = new Grid();
        return $grid->set_query($SQL)
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/validasi/gridDetail/".$id."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_var_label',
                            'title' => 'Produk',
                        ),
                        array(
                            'field' => 'ref_produk_satuan_label',
                            'title' => 'Satuan',
                        ),
                        array(
                            'field' => 'survey_det_harga',
                            'title' => 'Harga',
                            'format' => 'number',
                            'align' => 'right'
                        )
                    )
                )
            )->output();
    }

    public function approve($id)
    {
        $this->db->table('survey_header')->where('survey_head_id', $id)->update([
            'survey_head_approve_is'=> 'true',
            'survey_head_approve_at'=> date("Y-m-d H:i:s"),
            'survey_head_approve_by'=> $this->user['user_id']
        ]);
        return redirect()->to(base_url("admin/validasi"));
    }

    public function reject($id)
    {
        $this->db->table('survey_header')->where('survey_head_id', $id)->update([
            'survey_head_reject_is'=> 'true',
            'survey_head_reject_at'=> date("Y-m-d H:i:s"),
            'survey_head_reject_by'=> $this->user['user_id']
        ]);
        return redirect()->to(base_url("admin/validasi"));
    }
}
