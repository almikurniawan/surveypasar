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

    public function bapoting(){
        $tg     = date("d", strtotime($this->request->getGet('tanggal')));
        $bln    = date("m", strtotime($this->request->getGet('tanggal')));
        $thn    = date("Y", strtotime($this->request->getGet('tanggal')));

        $req_tanggal    = $thn."-".$bln."-".$tg;
        // $tanggal    = ($this->request->getGet('tanggal')!='' ? $this->request->getGet('tanggal') : date("Y-m-d"));
        $tanggal        = ($req_tanggal!='') ? $req_tanggal : date("Y-m-d");
        $data           = $this->db->query($this->query_bapoting($tanggal))->getResult('array');
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

    function query_bapoting($tanggal){
        $sql = "SELECT q.nomor, q.nama_barang, 
        CASE WHEN q.satuan_barang IS NULL THEN '' ELSE q.satuan_barang END AS satuan_barang,
        CASE WHEN q.harga_sekarang IS NULL THEN 0 ELSE q.harga_sekarang END AS harga_sekarang,
        q.urutan
        FROM (
        SELECT 
            ROW_NUMBER() OVER (ORDER BY rp.ref_produk_id) AS nomor,
            rp.ref_produk_id AS id_produk,
            0 AS id_barang,
            rp.ref_produk_label AS nama_barang,
            '' AS satuan_barang,
            0 AS harga_sekarang,
                1 as urutan
        FROM ref_produk AS rp
        UNION ALL
        SELECT
            0 AS nomor,
            rpv.ref_produk_var_produk_id AS id_produk,
            rpv.ref_produk_var_id AS id_barang,
            rpv.ref_produk_var_label AS nama_barang,    
            rps.ref_produk_satuan_label  AS satuan_barang,
            ( SELECT avg( survey_detail.survey_det_harga ) FROM survey_detail 
            WHERE to_char ( survey_det_tanggal, 'YYYY-MM-DD' ) = '".$tanggal."' 
                AND survey_det_produk_var_id = ref_produk_var_id ) AS harga_sekarang,
                2 AS urutan
        FROM
            ref_produk_varian as rpv
        LEFT JOIN ref_produk_satuan as rps ON rpv.ref_produk_var_satuan_id=rps.ref_produk_satuan_id
        ) as q
        ORDER BY q.id_produk, q.urutan";
        return $sql;
    }
}