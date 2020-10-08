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

class Home2 extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Dashboard';
        $bulan = ($bulan == null ? date('m') : $bulan);
        $tahun = ($tahun == null ? date('Y') : $tahun);

        $data['filter1']  = $this->filter1();
        $data['filter_tren_svy_prod']  = $this->filter_tren_svy_prod();
        $data['filter_tren_svy_seller']  = $this->filter_tren_svy_seller();
        $data['series'] = $this->dash()['series'];
        $data['category'] = $this->dash()['category'];
        $data['svy_produk'] = $this->dashboard_svy_produk();
        $data['svy_pedagang'] = $this->dashboard_svy_pedagang();
        return view('admin/home2', $data);
    }
    public function filter1()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal', 'Tanggal Awal', 'date', false, ($this->request->getGet('tanggal_awal') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_awal')), 'style="width:100%;" ')
            ->add('tanggal_akhir', 'Tanggal Akhir', 'date', false, ($this->request->getGet('tanggal_akhir') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir')), 'style="width:100%;" ')
            ->add(
                'kategori',
                'Kategori',
                'select_multiple',
                false,
                $this->request->getGet('kategori'),
                'style="width:100%;" ',
                array(
                    'table' => 'ref_produk',
                    'id' => 'ref_produk_id',
                    'label' => 'ref_produk_label'
                )
            )
            ->output();
    }

    public function filter_tren_svy_prod()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_prod')=='' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_prod'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_prod')=='' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_prod'));
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal_sv_seller','','hidden',false,$this->request->getGet('tanggal_awal_sv_seller'),'')
            ->add('tanggal_akhir_sv_seller','','hidden',false,$this->request->getGet('tanggal_akhir_sv_seller'),'')
            ->add('tanggal_awal_sv_prod', 'Tanggal Awal', 'date', false, $tanggal_awal, 'style="width:100%;" ')
            ->add('tanggal_akhir_sv_prod', 'Tanggal Akhir', 'date', false, $tanggal_akhir, 'style="width:100%;" ')
            ->output();
    }

    public function filter_tren_svy_seller()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_seller')=='' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_seller'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_seller')=='' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_seller'));
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal_sv_prod','','hidden',false,$this->request->getGet('tanggal_awal_sv_prod'),'')
            ->add('tanggal_akhir_sv_prod','','hidden',false,$this->request->getGet('tanggal_akhir_sv_prod'),'')
            ->add('tanggal_awal_sv_seller', 'Tanggal Awal', 'date', false, $tanggal_awal, 'style="width:100%;" ')
            ->add('tanggal_akhir_sv_seller', 'Tanggal Akhir', 'date', false, $tanggal_akhir, 'style="width:100%;" ')
            ->output();
    }

    public function dashboard_svy_produk()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_prod')=='' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_prod'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_prod')=='' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_prod'));

        $start_date = strtotime($tanggal_awal);
        $end_date = strtotime($tanggal_akhir);
        $kategori = array();
        while($start_date <= $end_date)
		{
            $kategori[] = date('Y-m-d',$start_date);
            $start_date = strtotime("+1 day", $start_date);
        }

        $surveyor = $this->db->query("SELECT DISTINCT(user_id) as user_id, user_namalengkap as nama FROM PUBLIC.USER left join ref_user_akses on PUBLIC.USER.user_id = ref_user_akses_user_id  WHERE ref_user_akses_group_id = 2")->getResult('array');
        $series = array();
        foreach($surveyor as $key => $value){
            $data_surveyor = array();
            foreach($kategori as $kat){
                $data_surveyor_per_tanggal = $this->db->query("select count(*) as jumlah from survey_detail where survey_det_tanggal = '".$kat."' and survey_det_created_by = ".$value['user_id'])->getRowArray();
                $data_surveyor[] = $data_surveyor_per_tanggal['jumlah'];
            }
            $series[] = array(
                'name'  => $value['nama'],
                'data'  => $data_surveyor
            );
        }

        return array(
            'series'        => $series,
            'categoryAxis'  => $kategori
        );
    }

    public function dashboard_svy_pedagang()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_seller')=='' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_seller'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_seller')=='' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_seller'));

        $start_date = strtotime($tanggal_awal);
        $end_date = strtotime($tanggal_akhir);
        $kategori = array();
        while($start_date <= $end_date)
		{
            $kategori[] = date('Y-m-d',$start_date);
            $start_date = strtotime("+1 day", $start_date);
        }

        $surveyor = $this->db->query("SELECT DISTINCT(user_id) as user_id, user_namalengkap as nama FROM PUBLIC.USER left join ref_user_akses on PUBLIC.USER.user_id = ref_user_akses_user_id  WHERE ref_user_akses_group_id = 2")->getResult('array');
        $series = array();
        foreach($surveyor as $key => $value){
            $data_surveyor = array();
            foreach($kategori as $kat){
                $data_surveyor_per_tanggal = $this->db->query("select count(*) as jumlah from survey_header where survey_head_tanggal='".$kat."' and survey_head_created_by=".$value['user_id'])->getRowArray();
                $data_surveyor[] = $data_surveyor_per_tanggal['jumlah'];
            }
            $series[] = array(
                'name'  => $value['nama'],
                'data'  => $data_surveyor
            );
        }

        return array(
            'series'        => $series,
            'categoryAxis'  => $kategori
        );
    }

    public function dash($tgl_awl = null, $tgl_akr = null, $var = null)
    {
        $tgl_akr = '';
        $tgl_akr = '';
        $var = '';

        $tanggal_start = strtotime('2020-09-24');
        $tanggal_akhir = strtotime('2020-09-26');
        $SUB_SQL = "select '".date('Y-m-d',$tanggal_start)."' as date";
        $key = 1;
        while ($tanggal_start < $tanggal_akhir) {
            if($key>1){
                $SUB_SQL .= " union all select '" . date('Y-m-d', $tanggal_start) . "' ";
            }
            $tanggal_start = strtotime("+1 day", $tanggal_start);
            $key++;
        }
  
        $name = $this->db->query("select ref_produk_var_label as name from ref_produk_varian where ref_produk_var_id = 2")->getRowArray();

        $data = $this->db->query("select DATE AS tgl, (SELECT coalesce(avg(survey_det_harga),0) FROM survey_detail where to_char(survey_det_tanggal,'YYYY-MM-DD')=DATE and survey_det_produk_var_id = 2) as avg FROM
        (".$SUB_SQL.") as foo;")->getResult('array');
  
        $series['name'] = $name['name'];
        foreach ($data as $key => $value) {
            $series['data'][] = $value['avg'];
            $category[] = $value['tgl'];
        }
        $result['series'] = json_encode($series);
        $result['category'] = json_encode($category);
        // die(json_encode($result));
        return $result;
    }
}
