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
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = '';

        return view('admin/admin', $data);
    }

    public function grid()
    {
        $SQL = "select true as id";

        $action['detail']     = array(
            'link'          => 'rekapan/perkasir_detail/'
        );

        $grid = new Grid();
        return $grid->set_query($SQL)
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/home/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'waktu_buka_tutup',
                            'title' => 'Waktu Buka',
                            'width'    => 250
                        ),
                        array(
                            'field' => 'user_nama_lengkap',
                            'title' => 'User',
                            'width'    => 200
                        ),
                        array(
                            'field' => 'kasir_log_cash_in',
                            'title' => 'Modal',
                            'align'    => 'right',
                            'format' => 'number',
                            'width'    => 100
                        ),
                        array(
                            'field' => 'kasir_log_total_penjualan',
                            'title' => 'Tunai',
                            'align'    => 'right',
                            'format' => 'number',
                            'width'    => 100
                        ),
                        array(
                            'field' => 'kasir_log_total_penjualan_non_tunai',
                            'title' => 'Non Tunai',
                            'align'    => 'right',
                            'format' => 'number',
                            'width'    => 100
                        ),
                        array(
                            'field' => 'kasir_log_total_return',
                            'title' => 'Return',
                            'align'    => 'right',
                            'format' => 'number',
                            'width'    => 100
                        ),
                    ),
                    'action'    => $action
                )
            )->output();
    }

    public function search()
    {
        $tgl_awal = '';
        $form = new Form();
        return $form->set_form_type('search')
		->set_form_method('GET')
		->set_submit_label('Cari')
		->add('produk', 'Produk', 'text', false, $this->request->getGet('produk'), 'style="width:100%;" ')
		->add('tgl_awal', 'Tgl', 'date', false, ($tgl_awal=='' ? date("Y-m-d") : $tgl_awal), 'style="width:100%;" ')
		->output();
    }

    public function add()
    {
        $data['form']   = $this->form();
        $data['title']  = '';

        return view('admin/add', $data);
    }

    public function form($id=null)
    {
        
        if ($id!=null) {
            $data = $this->db->get_where('kasir', array('kasir_id' => $id))->row_array();
        }
        $data = array(
            'kasir_label'=>'tes'
        );
        
        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
		->add('kasir_label', 'Label', 'text', true, ($data) ? $data['kasir_label'] : '', 'style="width:100%;"')
		->add('kasir_printer_use', 'Ada Printer?', 'select_custom', true, '', 'style="width:100%;"', array(
			'option'=> array(
				array(
					'id'=> 1, 'label'=> 'Ya'
				),
				array(
					'id'=> 0, 'label'=> 'Tidak'
				)
			)
		))
		->add('kasir_print_konektor', 'Koneksi Printer', 'select_custom', true, '', 'style="width:100%;"', array(
			'option'=> array(
				array(
					'id'=> 'USB', 'label'=> 'USB'
				),
				array(
					'id'=> 'LAN', 'label'=> 'LAN'
				)
			)
		))
		->add('kasir_print_name_ip', 'Nama Printer / IP Printer', 'text', true, '', 'style="width:100%;"');

		if ($form->formVerified()) {
			if ($id!=null) {
				$data_update = array(
					'kasir_label'	=> $this->input->post('kasir_label'),
					'kasir_printer_use' => $this->input->post('kasir_printer_use'),
					'kasir_print_konektor' => $this->input->post('kasir_print_konektor'),
					'kasir_print_name_ip' => $this->input->post('kasir_print_name_ip'),
				);
				$this->db->update("kasir", $data_update, array('kasir_id' => $id));
				return $form->output('success','Sukses Edit Data');
			} else {
				$data_insert = array(
					'kasir_label'	=> $this->input->post('kasir_label'),
					'kasir_printer_use' => $this->input->post('kasir_printer_use'),
					'kasir_print_konektor' => $this->input->post('kasir_print_konektor'),
					'kasir_print_name_ip' => $this->input->post('kasir_print_name_ip'),
				);
				$this->db->insert("kasir", $data_insert);
				return $form->output('success','Sukses Insert Baru');
			}
		} else {
			return $form->output();
		}
    }
}
