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

class Home extends BaseController
{
    public function index($bulan = null, $tahun = null)
    {
        $data['title']  = 'Dashboard';
        $bulan = ($bulan == null ? date('m') : $bulan);
        $tahun = ($tahun == null ? date('Y') : $tahun);

        $data['filter1']  = $this->filter1();

        $data['data'] = $this->dash();

        $data['filter_tren_svy_prod']  = $this->filter_tren_svy_prod();
        $data['filter_tren_svy_seller']  = $this->filter_tren_svy_seller();

        $data['svy_produk'] = $this->dashboard_svy_produk();
        $data['svy_pedagang'] = $this->dashboard_svy_pedagang();
        return view('admin/home', $data);
    }
    public function filter1()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir'));

        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal', 'Tanggal Awal', 'date', false, $tanggal_awal, 'style="width:100%;" ')
            ->add('tanggal_akhir', 'Tanggal Akhir', 'date', false, $tanggal_akhir, 'style="width:100%;" ')
            ->add('tanggal_awal_sv_prod', '', 'hidden', false, $this->request->getGet('tanggal_awal_sv_prod'), '')
            ->add('tanggal_akhir_sv_prod', '', 'hidden', false, $this->request->getGet('tanggal_akhir_sv_prod'), '')
            ->add('tanggal_awal_sv_seller', '', 'hidden', false, $this->request->getGet('tanggal_awal_sv_seller'), '')
            ->add('tanggal_akhir_sv_seller', '', 'hidden', false, $this->request->getGet('tanggal_akhir_sv_seller'), '')
            ->add(
                'kategori',
                'Kategori',
                'select',
                false,
                $this->request->getGet('kategori'),
                'style="width:100%;" ',
                array(
                    'table' => 'ref_produk',
                    'id' => 'ref_produk_id',
                    'label' => 'ref_produk_label'
                )
            )
            ->add(
                'sub_kategori',
                'Sub Kategori',
                'select',
                false,
                $this->request->getGet('sub_kategori'),
                'style="width:100%;" ',
                array(
                    'table' => 'ref_produk_varian',
                    'id' => 'ref_produk_var_id',
                    'label' => 'ref_produk_var_label'
                )
            )
            ->output();
    }
    public function dash()
    {
        $kategori = ($this->request->getGet('kategori') == '' ? 1 : $this->request->getGet('kategori'));
        $sub_kategori = ($this->request->getGet('sub_kategori') == '' ? 0 : $this->request->getGet('sub_kategori'));
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir'));

        $SUB_SQL = "select '" . $tanggal_awal . "' as date";
        $start_date = strtotime($tanggal_awal);
        $end_date = strtotime($tanggal_akhir);
        $tgl = array();
        while ($start_date <= $end_date) {
            $tgl[] = date('Y-m-d', $start_date);
            $start_date = strtotime("+1 day", $start_date);
        }
        if ($sub_kategori > 0) {
            $where1 = ' ref_produk_var_id = ' . $sub_kategori;
            $where2 = ' survey_det_produk_var_id = '.$sub_kategori;
        } else {
            $where1 = ' ref_produk_var_produk_id = ' . $kategori;
            $where2 = ' survey_det_produk_var_id in (select ref_produk_var_id from ref_produk_varian where ref_produk_var_produk_id = '.$kategori.' )';
        }
        $name = $this->db->query("select ref_produk_var_id as id, ref_produk_var_label as name from ref_produk_varian where " . $where1)->getResult('array');
        foreach ($name as $k => $v) {
            $data_komoditas = array();
            foreach ($tgl as $kat) {
                $data_komoditas_per_tanggal = $this->db->query("SELECT coalesce(avg(survey_det_harga),0) as jumlah FROM survey_detail where to_char(survey_det_tanggal,'YYYY-MM-DD')='".$kat."' and survey_det_produk_var_id=".$v['id'])->getRowArray();
                $data_komoditas[] = $data_komoditas_per_tanggal['jumlah'];
            }
            $series[] = array(
                'name'  => $v['name'],
                'data'  => $data_komoditas
            );
        }

        $count = $this->db->query("SELECT
        ( SELECT COUNT ( * ) FROM ref_produk_varian ) AS produk,
        ( SELECT COUNT ( * ) FROM seller ) AS seller,
        ( SELECT count(*) FROM PUBLIC.USER left join ref_user_akses on PUBLIC.USER.user_id = ref_user_akses_user_id  WHERE ref_user_akses_group_id = 2 ) AS surveyor")->getRowArray();
        return array(
            'series'        => $series,
            'category'  => $tgl,
            'jml' => $count
        );
    }

    public function filter_tren_svy_prod()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_prod') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_prod'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_prod') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_prod'));
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal_sv_seller', '', 'hidden', false, $this->request->getGet('tanggal_awal_sv_seller'), '')
            ->add('tanggal_akhir_sv_seller', '', 'hidden', false, $this->request->getGet('tanggal_akhir_sv_seller'), '')
            ->add('tanggal_awal', '', 'hidden', false, $this->request->getGet('tanggal_awal'), '')
            ->add('tanggal_akhir', '', 'hidden', false, $this->request->getGet('tanggal_akhir'), '')
            ->add('kategori', '', 'hidden', false, $this->request->getGet('kategori'), '')
            ->add('sub_kategori', '', 'hidden', false, $this->request->getGet('sub_kategori'), '')
            ->add('tanggal_awal_sv_prod', 'Tanggal Awal', 'date', false, $tanggal_awal, 'style="width:100%;" ')
            ->add('tanggal_akhir_sv_prod', 'Tanggal Akhir', 'date', false, $tanggal_akhir, 'style="width:100%;" ')
            ->output();
    }

    public function filter_tren_svy_seller()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_seller') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_seller'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_seller') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_seller'));
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('tanggal_awal_sv_prod', '', 'hidden', false, $this->request->getGet('tanggal_awal_sv_prod'), '')
            ->add('tanggal_akhir_sv_prod', '', 'hidden', false, $this->request->getGet('tanggal_akhir_sv_prod'), '')
            ->add('tanggal_awal', '', 'hidden', false, $this->request->getGet('tanggal_awal'), '')
            ->add('tanggal_akhir', '', 'hidden', false, $this->request->getGet('tanggal_akhir'), '')
            ->add('kategori', '', 'hidden', false, $this->request->getGet('kategori'), '')
            ->add('sub_kategori', '', 'hidden', false, $this->request->getGet('sub_kategori'), '')
            ->add('tanggal_awal_sv_seller', 'Tanggal Awal', 'date', false, $tanggal_awal, 'style="width:100%;" ')
            ->add('tanggal_akhir_sv_seller', 'Tanggal Akhir', 'date', false, $tanggal_akhir, 'style="width:100%;" ')
            ->output();
    }

    public function dashboard_svy_produk()
    {
        $tgl_awal = strtotime("-7 day", time());
        $tomorrowDATE = date('Y-m-d', $tgl_awal);

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_prod') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_prod'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_prod') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_prod'));

        $start_date = strtotime($tanggal_awal);
        $end_date = strtotime($tanggal_akhir);
        $kategori = array();
        while ($start_date <= $end_date) {
            $kategori[] = date('Y-m-d', $start_date);
            $start_date = strtotime("+1 day", $start_date);
        }

        $surveyor = $this->db->query("SELECT DISTINCT(user_id) as user_id, user_namalengkap as nama FROM PUBLIC.USER left join ref_user_akses on PUBLIC.USER.user_id = ref_user_akses_user_id  WHERE ref_user_akses_group_id = 2")->getResult('array');
        $series = array();
        foreach ($surveyor as $key => $value) {
            $data_surveyor = array();
            foreach ($kategori as $kat) {
                $data_surveyor_per_tanggal = $this->db->query("select count(*) as jumlah from survey_detail where survey_det_tanggal = '" . $kat . "' and survey_det_created_by = " . $value['user_id'])->getRowArray();
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

        $tanggal_awal = ($this->request->getGet('tanggal_awal_sv_seller') == '' ? $tomorrowDATE : $this->request->getGet('tanggal_awal_sv_seller'));
        $tanggal_akhir = ($this->request->getGet('tanggal_akhir_sv_seller') == '' ? date("Y-m-d") : $this->request->getGet('tanggal_akhir_sv_seller'));

        $start_date = strtotime($tanggal_awal);
        $end_date = strtotime($tanggal_akhir);
        $kategori = array();
        while ($start_date <= $end_date) {
            $kategori[] = date('Y-m-d', $start_date);
            $start_date = strtotime("+1 day", $start_date);
        }

        $surveyor = $this->db->query("SELECT DISTINCT(user_id) as user_id, user_namalengkap as nama FROM PUBLIC.USER left join ref_user_akses on PUBLIC.USER.user_id = ref_user_akses_user_id  WHERE ref_user_akses_group_id = 2")->getResult('array');
        $series = array();
        foreach ($surveyor as $key => $value) {
            $data_surveyor = array();
            foreach ($kategori as $kat) {
                $data_surveyor_per_tanggal = $this->db->query("select count(*) as jumlah from survey_header where survey_head_tanggal='" . $kat . "' and survey_head_created_by=" . $value['user_id'])->getRowArray();
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
}
