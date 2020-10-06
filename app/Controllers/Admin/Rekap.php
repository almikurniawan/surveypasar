<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Rekap extends BaseController
{
    public function index()
    {
        $data['grid'] = $this->gridRekap();
        $data['search'] = $this->search();
        $data['tanggal'] = ($this->request->getGet('tanggal')=='' ? date("Y-m-d") : $this->request->getGet('tanggal'));
        return view('admin/rekap', $data);
    }

    public function gridRekap()
    {
        $tanggal = $this->request->getGet('tanggal');
        $new_tanggal = $tanggal;
        $pasar_id = $this->request->getGet('pasar_id');
        if($tanggal==''){
            $new_tanggal = date("Y-m-d");
        }
        if($pasar_id!=''){
            $where = " and seller.seller_pasar_id = ".$pasar_id;
            $pasar_url      = "/".$pasar_id;
        }else{
            $where          = "";
            $pasar_url      = "/0";
        }
        $SQL    = "SELECT
                        ref_produk_label||' - '||ref_produk_var_label as nama_bahan,
	                    ref_produk_label,
                        ref_produk_var_id as id,
                        coalesce((select AVG(survey_det_harga) from survey_detail left join seller on seller_id = survey_det_seller_id where survey_det_produk_var_id = ref_produk_var_id and survey_det_tanggal = '".$new_tanggal."' ".$where."),0) as avg
                    FROM
                        ref_produk_varian
                        left join ref_produk on ref_produk_id = ref_produk_var_produk_id";
        $grid   = new Grid();
        return $grid->set_query($SQL)
            ->set_sort(array('ref_produk_label','asc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/rekap/gridRekap?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'nama_bahan',
                            'title' => 'NAMA BAHAN POKOK'
                        ),
                        array(
                            'field' => 'ref_produk_label',
                            'title' => 'GROUP'
                        ),
                        array(
                            'field' => 'avg',
                            'title' => 'HARGA (Rp)',
                            'format'=> 'number',
                            'align' => 'right'
                        )
                    ),
                    'action'=> array(
                        'detail'    => array('jsf'=> 'detail')
                    ),
                    'toolbar'    => array('download')
                )
            )
            ->set_row_start(3)
            ->set_header(array('A1'=> 'Rekap'))
            ->output();
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
		->set_form_method('GET')
		->set_submit_label('Filter')
        ->add('tanggal', 'Tanggal', 'date', false, $this->request->getGet('tanggal'), 'style="width:100%;" ')
        ->add('pasar_id', 'Pasar', 'select', false, $this->request->getGet('pasar_id'), 'style="width:100%;" ',
            array(
                'table' => 'ref_pasar',
                'id' => 'ref_pasar_id',
                'label' => 'ref_pasar_label'
            )
        )
        ->output();
    }

    public function detail($tanggal, $produk_id)
    {
        $data['grid'] = $this->gridRekapDetail($tanggal, $produk_id);
        return view('admin/rekap_detail', $data);
    }
    
    public function gridRekapDetail($tanggal, $produk_id)
    {
        $SQL    = "SELECT
                        survey_detail.* ,
                        public.user.user_namalengkap,
                        seller_nama,
	                    ref_pasar_label
                    FROM
                        survey_detail 
                        left join survey_header on survey_header.survey_head_id = survey_detail.survey_det_head_id
                        left join public.user on public.user.user_id = survey_header.survey_head_created_by
                        left join seller on survey_det_seller_id = seller_id
	                    left join ref_pasar on ref_pasar_id = seller_pasar_id
                    WHERE
                        survey_detail.survey_det_tanggal = '".$tanggal."' 
                        AND survey_detail.survey_det_produk_var_id = ".$produk_id;
        $grid   = new Grid();
        return $grid->set_query($SQL)
            ->set_sort(array('seller_nama','asc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/rekap/gridRekapDetail/".$tanggal."/".$produk_id."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'seller_nama',
                            'title' => 'Pedagang'
                        ),
                        array(
                            'field' => 'ref_pasar_label',
                            'title' => 'Pasar'
                        ),
                        array(
                            'field' => 'survey_det_harga',
                            'title' => 'HARGA (Rp)',
                            'format'=> 'number',
                            'align' => 'right'
                        ),
                        array(
                            'field' => 'user_namalengkap',
                            'title' => 'Surveyor'
                        ),
                    ),
                )
            )->output();
    }
}