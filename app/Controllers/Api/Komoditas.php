<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Komoditas extends BaseController
{
    public function index()
    {
        $tanggal    = ($this->request->getGet('tanggal')!='' ? $this->request->getGet('tanggal') : date("Y-m-d"));
        $data       = $this->db->query("SELECT
                                            ref_produk_var_id AS id_barang,
                                            ref_produk_var_label AS nama_barang,
                                            '".$tanggal."' AS tanggal,
                                            (select avg(survey_detail.survey_det_harga) from survey_detail where to_char(survey_det_tanggal,'YYYY-MM-DD')='".$tanggal."' and survey_det_produk_var_id = ref_produk_var_id) as harga
                                        FROM
                                            ref_produk_varian")->getResult('array');
        if(!empty($data)){
            $response = array(
                'status'=> true,
                'code'=> '00',
                'message'=> 'sukses load data',
                'data'=> $data
            );
        }else{
            $response = array(
                'status'=> true,
                'code'=> '01',
                'message'=> 'data empty',
                'data'=> $data
            );
        }
        return $this->response->setJSON($response);
    }
}