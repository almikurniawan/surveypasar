<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\SmartComponent\Grid;
use App\Libraries\SmartComponent\Form;

class Survey extends BaseController
{
    public function index()
    {
        $tanggal        = ($this->request->getGet('tanggal')=='' ? date("Y-m-d") : $this->request->getGet('tanggal'));
        $data['grid']   = $this->gridSeller($tanggal);
        $data['search'] = $this->searchSeller();
        $data['notif']  = $this->getNotif($tanggal);
        return view('admin/pickSeller', $data);
    }

    private function getNotif($tanggal)
    {
        $cek = $this->db->query("select count(*) as jumlah from ref_produk_varian where ref_produk_var_id not in (select survey_detail.survey_det_produk_var_id from survey_detail where survey_det_tanggal='".$tanggal."')")->getRowArray();
        if($cek['jumlah']>0){
            $url = base_url("admin/survey/belum/".$tanggal);
            return '<div class="alert alert-warning" role="alert">Ada '.$cek['jumlah'].' produk yang belum disurvey ditanggal '.date_format(date_create($tanggal),'d F Y').'. lihat disini <a href="'.$url.'">Lihat</a></div>';
        }
        return '';
    }

    public function pickSeller($tanggal)
    {
        $data['grid'] = $this->gridSeller($tanggal);
        $data['search'] = $this->searchSeller();
        return view('admin/pickSeller', $data);
    }

    public function searchSeller()
    {
        $form = new Form();
        return $form->set_form_type('search')
		->set_form_method('GET')
        ->set_submit_label('Mulai Survey')
        ->add('tanggal', 'Tanggal', 'date', false, $this->request->getGet('tanggal'), 'style="width:100%;" ')
        ->add('seller', 'Pedagang', 'select', false, $this->request->getGet('seller'), 'style="width:100%;" ',
            array(
                'table' => 'seller left join ref_pasar on ref_pasar_id = seller_pasar_id',
                'id' => 'seller_id',
                'label' => "seller_nama||' - '||ref_pasar_label"
            )
        )->output();
    }

    public function gridSeller($tanggal)
    {
        $SQL = "select '<a href=\"".base_url("admin/survey/start/".$tanggal)."/'||seller_id||'\">'||seller_nama||'</a>' as seller_nama, ref_pasar_label, seller_id as id from seller left join ref_pasar on ref_pasar_id = seller_pasar_id";

        $grid = new Grid();
        return $grid->set_query($SQL,array(
            array('seller_id', $this->request->getGet('seller'),'=')
        ))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/survey/gridSeller/".$tanggal."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'seller_nama',
                            'title' => 'Pedagang',
                            'encoded'=> false
                        ),
                        array(
                            'field' => 'ref_pasar_label',
                            'title' => 'Pasar',
                        )
                    )
                )
            )->output();
    }

    public function start($tanggal, $seller_id)
    {
        //cek jika sudah ada
        $cek = $this->db->query("select * from survey_header where survey_head_tanggal='".$tanggal."' and survey_head_seller_id=".$seller_id)->getRowArray();
        if(empty($cek)){
            $data['form'] = $this->formSurvey($tanggal, $seller_id);
            return view('admin/surveyStart', $data);
        }else{
            if($cek['survey_head_approve_is']=='t'){
                return view('admin/surveyApproved');
            }
            return redirect()->to(base_url("admin/survey/edit/".$cek['survey_head_id']));
        }
    }

    public function formSurvey($tanggal, $seller_id)
    {
        $produk_seller = $this->db->query("select ref_produk_var_id, ref_produk_var_label, '( '||ref_produk_satuan_label||' )' as ref_produk_satuan_label from seller_produk left join ref_produk_varian on seller_prod_produk_var_id = ref_produk_var_id left join ref_produk_satuan on ref_produk_satuan_id = ref_produk_varian.ref_produk_var_satuan_id where seller_prod_seller_id=".$seller_id)->getResult('array');
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
        ->set_form_action(base_url("/admin/survey/formSurvey/".$tanggal."/".$seller_id));
        foreach($produk_seller as $key => $value){
            $form->add($value['ref_produk_var_id'], $value['ref_produk_var_label'].' '.$value['ref_produk_satuan_label'], 'number', false, '', 'style="width:100%;"');
        }

		if ($form->formVerified()) {
            $qb = $this->db->table('survey_header');
            $data_header = array(
                'survey_head_tanggal'   => $tanggal,
                'survey_head_seller_id' => $seller_id,
                'survey_head_created_by'=> $this->user['user_id']
            );
            $qb->insert($data_header);
            $id_header = $this->db->insertID();
            $data_detail = array();
            foreach($_POST as $key => $value){
                if($key!=='submit'){
                    if($value>0){
                        $data_detail[] = array(
                            'survey_det_head_id'    => $id_header,
                            'survey_det_tanggal'    => $tanggal,
                            'survey_det_seller_id'  => $seller_id,
                            'survey_det_produk_var_id'=> $key,
                            'survey_det_harga'      => ($value=='' ? 0 : $value),
                            'survey_det_created_by' => $this->user['user_id']
                        );
                    }
                }
            }
            $qb = $this->db->table('survey_detail');
            $qb->insertBatch($data_detail);
            $this->session->setFlashdata('sukses','Sukses Survey');
            return redirect()->to(base_url("admin/survey"));
		} else {
			return $form->output();
		}
    }

    public function edit($head_id)
    {
        $data['form'] = $this->formSurveyEdit($head_id);
        return view('admin/surveyStart', $data);
    }

    public function formSurveyEdit($head_id)
    {
        $header = $this->db->query("select * from survey_header where survey_head_id=".$head_id)->getRowArray();
        $seller_id = $header['survey_head_seller_id'];
        $tanggal = $header['survey_head_tanggal'];
        $produk_seller = $this->db->query("select ref_produk_var_id, ref_produk_var_label, survey_det_harga, '( '||ref_produk_satuan_label||' )' as ref_produk_satuan_label from seller_produk left join ref_produk_varian on seller_prod_produk_var_id = ref_produk_var_id left join ref_produk_satuan on ref_produk_satuan_id = ref_produk_varian.ref_produk_var_satuan_id left join survey_detail on survey_det_head_id = ".$head_id." and survey_det_produk_var_id = ref_produk_var_id where seller_prod_seller_id=".$seller_id." order by ref_produk_var_urutan asc")->getResult('array');

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
        ->set_form_action(base_url("/admin/survey/formSurveyEdit/".$head_id));
        foreach($produk_seller as $key => $value){
            $form->add($value['ref_produk_var_id'], $value['ref_produk_var_label'].' '.$value['ref_produk_satuan_label'], 'number', false, $value['survey_det_harga'], 'style="width:100%;"');
        }

		if ($form->formVerified()) {
            $data_detail = array();
            foreach($_POST as $key => $value){
                if($key!=='submit'){
                    if($value>0){
                        $data_detail[] = array(
                            'survey_det_head_id'    => $head_id,
                            'survey_det_tanggal'    => $tanggal,
                            'survey_det_seller_id'  => $seller_id,
                            'survey_det_produk_var_id'=> $key,
                            'survey_det_harga'      => ($value=='' ? 0 : $value),
                            'survey_det_created_by' => $this->user['user_id']
                        );
                    }
                }
            }
            $qb = $this->db->table('survey_detail');
            $qb->delete(['survey_det_head_id'=> $head_id]);
            $qb->insertBatch($data_detail);
            $this->db->table('survey_header')->where('survey_head_id', $head_id)->update([
                'survey_head_approve_is'=> null,
                'survey_head_approve_at'=> null,
                'survey_head_approve_by'=> null,
                'survey_head_reject_is'=> null,
                'survey_head_reject_at'=> null,
                'survey_head_reject_by'=> null
            ]);
            $this->session->setFlashdata('sukses','Sukses Survey');
            return redirect()->to(base_url("admin/survey"));
        }else{
            return $form->output();
        }
    }

    public function belum($tanggal)
    {
        $data['grid']   = $this->gridBelumSurvey($tanggal);
        return view('admin/belumSurvey', $data);
    }

    public function gridBelumSurvey($tanggal)
    {
        $SQL = "SELECT
                    ref_produk_var_label,
                    ref_produk_label ,
                    ref_produk_var_id as id
                FROM
                    ref_produk_varian
                    LEFT JOIN ref_produk ON ref_produk_id = ref_produk_var_produk_id 
                WHERE
                    ref_produk_var_id NOT IN (
                SELECT
                    survey_detail.survey_det_produk_var_id 
                FROM
                    survey_detail 
                WHERE
                    survey_det_tanggal = '".$tanggal."')";

        $grid = new Grid();
        return $grid->set_query($SQL)
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/survey/gridBelumSurvey/".$tanggal."?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'ref_produk_var_label',
                            'title' => 'Nama Bahan Pokok',
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
