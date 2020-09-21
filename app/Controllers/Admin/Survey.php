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

class Survey extends BaseController
{
    public function index()
    {
        $data['form'] = $this->form_tanggal();
        return view('admin/survey', $data);
    }

    public function form_tanggal()
    {
        $form = new Form();
        $form->set_form_type('search')
        ->set_form_action(base_url("/admin/survey/form_tanggal"))
		->set_form_method('GET')
		->set_submit_label('Mulai Survey')
		->add('tanggal', 'Tanggal', 'date', false, $this->request->getGet('tanggal'), 'style="width:100%;" ');
        if($form->formVerified()){
            $tanggal = $this->request->getGet('tanggal');
            if($tanggal==''){
                return redirect()->to(base_url("admin/survey"));
            }
            return redirect()->to(base_url("admin/survey/pickSeller/".$tanggal));
        }else{
            return $form->output();
        }
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
		->set_submit_label('Cari')
        ->add('seller', 'Pedagang', 'text', true, $this->request->getGet('seller'), 'style="width:100%;" ')
        ->add('pasar_id', 'Pasar', 'select', false, $this->request->getGet('pasar_id'), 'style="width:100%;" ',
            array(
                'table' => 'ref_pasar',
                'id' => 'ref_pasar_id',
                'label' => 'ref_pasar_label'
            )
        )
        ->output();        
    }

    public function gridSeller($tanggal)
    {
        $SQL = "select '<a href=\"".base_url("admin/survey/start/".$tanggal)."/'||seller_id||'\">'||seller_nama||'</a>' as seller_nama, ref_pasar_label, seller_id as id from seller left join ref_pasar on ref_pasar_id = seller_pasar_id";

        $grid = new Grid();
        return $grid->set_query($SQL,array(
            array('seller_nama', $this->request->getGet('seller')),
            array('ref_pasar_id', $this->request->getGet('pasar_id'),'=')
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
            return view('admin/surveyDuplicate');
        }
    }

    public function formSurvey($tanggal, $seller_id)
    {
        $produk_seller = $this->db->query("select ref_produk_var_id, ref_produk_var_label from seller_produk left join ref_produk_varian on seller_prod_produk_var_id = ref_produk_var_id where seller_prod_seller_id=".$seller_id)->getResult('array');
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
        ->set_form_action(base_url("/admin/survey/formSurvey/".$tanggal."/".$seller_id));
        foreach($produk_seller as $key => $value){
            $form->add($value['ref_produk_var_id'], $value['ref_produk_var_label'], 'number', false, '', 'style="width:100%;"');
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
            $qb = $this->db->table('survey_detail');
            $qb->insertBatch($data_detail);
            $this->session->setFlashdata('sukses','Sukses Survey');
            return redirect()->to(base_url("admin/survey"));
		} else {
			return $form->output();
		}
    }
}
