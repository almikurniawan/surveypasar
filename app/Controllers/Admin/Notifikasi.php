<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Notifikasi extends BaseController
{
    public function index()
    {
        $data['title']   = 'Notifikasi';
        $data['grid']   = $this->gridNotifikasi();
        $data['search'] = $this->search();
        return view('admin/notifikasi', $data);
    }

    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('bulan', 'Bulan', 'month', false, ($this->request->getGet('bulan') == '' ? date("Y-m") : $this->request->getGet('bulan')), 'style="width:100%;" ')
            ->output();
    }

    public function gridNotifikasi()
    {
        $bulan      = ($this->request->getGet('bulan')=='' ? date("Y-m") : $this->request->getGet('bulan'));
        $SUB_SQL 	= " select '".$bulan."-01' as Date";
		$start_satu = strtotime($bulan.'-01');
		$start 		= $month = strtotime($bulan.'-02');
		$end 		= strtotime(date("Y-m-d", strtotime("+1 month", $start_satu)));
		while($month < $end)
		{
			$SUB_SQL .= " union all select '".date('Y-m-d', $month)."' ";
    		$month = strtotime("+1 day", $month);
        }
        $SQL = "SELECT
                    MonthDate.Date AS id,
                    MonthDate.Date AS tanggal,
                    (
                        select count(*) as jumlah from seller_produk where seller_prod_produk_var_id||'-'||seller_prod_seller_id not in 
                        (
                            select survey_det_produk_var_id||'-'||survey_det_seller_id from survey_detail where to_char(survey_det_tanggal,'YYYY-MM-DD')=MonthDate.DATE
                        )
                    ) as belum_survey
                FROM
                    (".$SUB_SQL.") AS MonthDate
                WHERE 
                (
                    select count(*) as jumlah from seller_produk where seller_prod_produk_var_id||'-'||seller_prod_seller_id not in 
                    (
                        select survey_det_produk_var_id||'-'||survey_det_seller_id from survey_detail where to_char(survey_det_tanggal,'YYYY-MM-DD')=MonthDate.DATE
                    )
                )>0";

        $action['detail']     = array(
            'jsf'          => 'detail'
        );
        $grid = new Grid();
        return $grid->set_query($SQL)
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/notifikasi/gridNotifikasi?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'tanggal',
                            'title' => 'Tanggal',
                            'format'=> 'date'
                        ),
                        array(
                            'field' => 'belum_survey',
                            'title' => 'Belum Disurvey',
                            'format' => 'number',
                            'align' => 'right'
                        ),
                    ),
                    'action'    => $action,
                )

            )->output();
    }

    public function detail($tanggal)
    {
        $data['title']  = 'Detail Produk Belum Disurvey tanggal '.$tanggal;
        $data['id'] = $tanggal;
        $data['grid']   = $this->gridBelumSurvey($tanggal);

        return view('admin/notifikasiDetail', $data);
    }

    public function gridBelumSurvey($tanggal)
    {
        $SQL = "SELECT
                    ref_produk_var_label,
                    ref_produk_label,
                    ref_produk_var_id AS ID,
                    (
                        SELECT 
                            array_to_string(ARRAY_AGG(seller_nama),',') 
                            FROM
                                seller_produk 
                                left join seller on seller_id = seller_prod_seller_id
                                left join survey_detail on survey_detail.survey_det_seller_id = seller_id and survey_detail.survey_det_produk_var_id = seller_produk.seller_prod_produk_var_id and survey_detail.survey_det_tanggal = '".$tanggal."'
                            WHERE true and survey_det_id is null and seller_produk.seller_prod_produk_var_id = ref_produk_var_produk_id
                    ) as penjual
                FROM
                    ref_produk_varian
                    LEFT JOIN ref_produk ON ref_produk_id = ref_produk_var_produk_id 
                    WHERE 
                    (
                        SELECT 
                            array_to_string(ARRAY_AGG(seller_nama),',') 
                            FROM
                                seller_produk 
                                left join seller on seller_id = seller_prod_seller_id
                                left join survey_detail on survey_detail.survey_det_seller_id = seller_id and survey_detail.survey_det_produk_var_id = seller_produk.seller_prod_produk_var_id and survey_detail.survey_det_tanggal = '".$tanggal."'
                            WHERE true and survey_det_id is null and seller_produk.seller_prod_produk_var_id = ref_produk_var_produk_id
                    ) IS NOT NULL";

        $grid = new Grid();
        return $grid->set_query($SQL)
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/notifikasi/gridBelumSurvey/".$tanggal."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_var_label',
                            'title' => 'Nama Bahan Pokok',
                        ),
                        array(
                            'field' => 'penjual',
                            'title' => 'Penjual',
                        ),
                        array(
                            'field' => 'ref_produk_label',
                            'title' => 'GROUP',
                        )
                    )
                )
            )->output();
    }
}
