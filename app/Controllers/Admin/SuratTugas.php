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
use TCPDF;

class SuratTugas extends BaseController
{
    public function index()
    {
        $data['grid']   = $this->grid();
        $data['search'] = $this->search();
        $data['title']  = 'Surat Tugas';

        return view('admin/surattugas', $data);
    }

    public function grid()
    {
        $SQL = "select *, surat_tugas_id as id, concat('<a onclick=\"cetak(',surat_tugas_id,');\"><i class=\"k-icon k-i-print\"></i></a>') as cetak from surat_tugas
        left join user on user_id = surat_tugas_created_by
        left join pegawai on pegawaiid = user_kar_id";

        $action['edit']     = array(
            'link'          => 'admin/surat_tugas/edit/'
        );
        $action['delete']     = array(
            'jsf'          => 'deleteProduk'
        );

        $grid = new Grid();
        return $grid->set_query($SQL, array(
            array('surat_tugas_created_by', $this->user['user_id'],'='),
            array('surat_tugas_nomor', $this->request->getGet('surat_tugas_nomor'))
        ))
            ->set_sort(array('id', 'desc'))
            ->configure(
                array(
                    'datasouce_url' => base_url("admin/suratTugas/grid?datasource&" . get_query_string()),
                    'grid_columns'  => array(
                        array(
                            'field' => 'surat_tugas_nomor',
                            'title' => 'Nomor',
                        ),
                        array(
                            'field' => 'surat_tugas_created_at',
                            'title' => 'Dibuat Pada',
                        ),
                        array(
                            'field' => 'pegawainamalengkap',
                            'title' => 'Dibuat Oleh',
                        ),
                        array(
                            'field' => 'cetak',
                            'title' => '&nbsp',
                            'encoded'=> false
                        )
                    ),
                    // 'action'    => $action,
                    'head_left'        => array('add' => base_url('/admin/suratTugas/add'))
                )
            )->output();
    }
    public function search()
    {
        $form = new Form();
        return $form->set_form_type('search')
            ->set_form_method('GET')
            ->set_submit_label('Cari')
            ->add('surat_tugas_nomor', 'Nomor', 'text', false, $this->request->getGet('surat_tugas_nomor'), 'style="width:100%;" ')
            ->output();
    }

    public function add()
    {
        $data['title']  = 'Buat Surat Tugas';
        $data['form']   = $this->form();

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $data['title']  = 'Edit Surat Tugas';
        $data['form']   = $this->form($id);

        return view('admin/add', $data);
    }
    public function delete()
    {
        $id = $this->request->getPost('id');
        $cek = $this->db->table('ref_produk_varian')->getWhere(['ref_produk_var_produk_id' => $id])->getRowArray();
        if ($cek == null) {
            $this->db->table('ref_produk')->delete(['ref_produk_id' => $id]);
            return $this->response->setJSON(
                array(
                    'status' => true,
                    'message' => 'Success delete data'
                )
            );
        }else{
            return $this->response->setJSON(
                array(
                    'status' => false,
                    'message' => 'Tidak bisa menghapus data'
                )
            );
        }
    }
    public function form($id = null)
    {
        $data = false;
        if ($id != null) {
            $data = $this->db->table('surat_tugas')->getWhere(['surat_tugas_id' => $id])->getRowArray();
        }

        $default_isi = <<<HTML
                <table border="0" cellpadding="1" cellspacing="1" style="width:100%">
                    <tbody>
                        <tr>
                            <td style="width:15%"><img alt="" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Lambang-tulungagung.png/511px-Lambang-tulungagung.png" style="height:90px; width:70px" /></td>
                            <td style="width:85%">
                            <p style="text-align:center"><span style="font-size:14px">PEMERINTAH KABUPATEN TULUNGAGUNG</span><br />
                            <span style="font-size:14px"><strong>SATUAN POLISI PAMONG PRAJA</strong></span><br />
                            <span style="font-size:14px">Jl. R.A. Kartini No. 7, Tlp/Fax (0355) 323655</span><br />
                            <span style="font-size:14px">TULUNGAGUNG Kode Pos 66212</span></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>==========================================================================</strong></p>
                <p style="text-align:center"><strong>SURAT PERINTAH TUGAS</strong><br />
                Nomor : 300.1 / / 42.03 / 2023</p>
                <p>Dasar :</p>
                <ul>
                    <li style="text-align:justify">Peraturan Pemerintah Nomor 18 tahun 2018 tentang Satuan Polisi Pamong Praja.</li>
                    <li style="text-align:justify">Peraturan Menteri Dalam Negeri Nomor 54 Tahun 2011 tentang Standar Operasional Prosedur Satuan Polisi Pamong Praja.</li>
                    <li style="text-align:justify">Peraturan Menteri Dalam Negeri Nomor 26 Tahun 2020 tentang Penyelenggaraan Ketertiban Umum dan Ketentraman Masyarakat Serta Perlindungan Masyarakat.</li>
                    <li style="text-align:justify">Peraturan Bupati Tulungagung Nomor 74 Tahun 2019 tentang Kedudukan, Susunan Organisasi, Tupoksi dan Tata Kerja Satuan Polisi Pamong Praja.</li>
                    <li style="text-align:justify">Surat Keputusan Kepala Satuan Polisi Pamong Praja Nomor 800/005/SK.KEP/42.03/2023, tanggal 02 Januari 2023 tentang Penerimaan Belanja Jasa Tenaga Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat TNI/CPM/Polri/Linmas/ Satpol PP/Dishub pada Satuan Polisi Pamong Praja Kabupaten Tulungagung dalam Rangka Kegiatan Penindakan atas Gangguan Ketentraman dan Ketertiban Umum berdasarkan Perda dan Perkada Melalui Penertiban dan Penanganan Unjuk Rasa dan kerusuhan massa Tahun Anggaran 202</li>
                </ul>
                <p style="text-align:center"><strong>MEMERINTAHKAN</strong></p>
                <p><strong>Kepada :</strong></p>
                <ol>
                    <li>Pejabat Struktural di Lingkup Satuan Polisi Pamong Praja Tulungagung</li>
                    <li>Nama &ndash; nama sebagaimana terlampir</li>
                </ol>
                <p><strong>Untuk :</strong></p>
                <ul>
                    <li>Melaksanakan Pengamanan Pagelaran Wayang Kulit tahun 2023</li>
                    <li>&nbsp;</li>
                </ul>
        HTML;

        $default_lampiran = <<<HTML
            <p style="text-align:center"><span style="font-size:16px"><strong>Daftar Anggota Satuan Polisi Pamong Praja Kabupaten Tulungagung Pengamanan Pagelaran Wayang Kulit tahun 2023</strong></span></p>
                <table border="1" cellspacing="0" style="border-collapse:collapse; width:100%">
                    <tbody>
                        <tr>
                            <td style="width:50px">Titik PAM</td>
                            <td style="width:291px">Nama Anggota</td>
                            <td>TUGAS</td>
                        </tr>
                        <tr>
                            <td style="width:50px">1</td>
                            <td style="width:291px">TEJO SULISTYANTO, EDY PURNOMO</td>
                            <td>PENGAMANAN</td>
                        </tr>
                        <tr>
                            <td style="width:50px">2</td>
                            <td style="width:291px">&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <p>&nbsp;</p>
            HTML;

        $form = new Form();
        $form->set_attribute_form('class="form-horizontal"')
            ->add('surat_tugas_nomor', 'Nomor', 'text', true, ($data) ? $data['surat_tugas_nomor'] : '', 'style="width:100%;"')
            ->add('surat_tugas_untuk', 'Untuk', 'textEditor', true, ($data) ? $data['surat_tugas_untuk'] : $default_isi, 'style="width:90%; height:700px;"')
            ->add('surat_tugas_lampiran', 'Lampiran', 'textEditor', true, ($data) ? $data['surat_tugas_lampiran'] : $default_lampiran, 'style="width:90%; height:700px;"');

        if ($form->formVerified()) {
            if ($id != null) {
                $data_update = $form->get_data();
                $this->db->table('surat_tugas')->where('surat_tugas_id', $id)->update($data_update);
                $this->session->setFlashdata('success', 'Sukses Edit Data');
                die(forceRedirect(base_url('/admin/suratTugas')));
            } else {
                $data_insert = $form->get_data();
                $data_insert['surat_tugas_created_by'] = $this->user['user_id'];
                $data_insert['surat_tugas_created_at'] = date("Y-m-d H:i:s");
                $this->db->table('surat_tugas')->insert($data_insert);
                $this->session->setFlashdata('success', 'Sukses Insert Baru');
                die(forceRedirect(base_url('/admin/suratTugas')));
            }
        } else {
            return $form->output();
        }
    }

    public function cetak($id) {
        $data = $this->db->table("surat_tugas")->getWhere(['surat_tugas_id' => $id])->getRowArray();

        $pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		setlocale(LC_TIME, 'id_ID');
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('DINKOP');
		$pdf->SetTitle('Profil');
		$pdf->SetSubject('Profil');

		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->SetMargins(20, 20, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);

		$pdf->SetFont('times', '', 12, '', 'false');

		$pdf->addPage();
		$pdf->writeHTML($data['surat_tugas_untuk'], true, false, true, false, '');

		$pdf->addPage();
		$pdf->writeHTML($data['surat_tugas_lampiran'], true, false, true, false, '');

		$pdf->Output();
		die();
    }
}
