<?php

namespace App\Libraries;

class Navigation
{
    public function __construct()
    {
    }

    public function menu()
    {
        $data['menu'] = $this->gen_menu();
        return view('template/menu', $data);
    }
    private function gen_menu()
    {
        $menu = '';
        $list_menu = $this->list_menu();
        foreach ($list_menu as $key => $value) {
            if (isset($value['child'])) {
                $menu .= '<li class="nav-item dropdown"><a class="nav-link pl-0 dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#"><i class="' . $value['icon'] . '"></i> ' . $value['label'] . ' </a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                foreach ($value['child'] as $k => $v) {
                    $menu .= '<a class="dropdown-item" href="' . base_url($v['controller']) . '">' . $v['label'] . ' </a>';
                }
                $menu .= '</div></li>';
            } else {
                $menu .= '<li class="nav-item"><a class="nav-link pl-0" href="' . base_url($value['controller']) . '"><i class="' . $value['icon'] . '"></i> ' . $value['label'] . ' </a></li>';
            }
        }
        $menu .= '<li><a class="nav-link pl-0" href="' . base_url("login/logout") . '"><i class="k-icon k-i-logout"></i> Logout </a></li>';

        return $menu;
    }

    private function list_menu()
    {

        $list_menu = array(
            array(
                'label'         => 'Survey',
                'controller'    => 'admin/survey',
                'icon'          => 'fa-home'
            ),
            array(
                'label'         => 'Rekap',
                'controller'    => 'admin/rekap',
                'icon'          => 'fa-home'
            ),
            array(
                'label'         => 'Master Data',
                'controller'    => '#referensi',
                'icon'          => 'fa-home',
                'child'         => array(
                    array(
                        'label'     => 'Pasar',
                        'controller' => 'admin/refPasar',
                    ),
                    array(
                        'label'     => 'Produk',
                        'controller' => 'admin/refProduk',
                    ),
                    array(
                        'label'     => 'Produk Varian',
                        'controller' => 'admin/refProdukVarian',
                    ),
                    array(
                        'label'     => 'Pedagang',
                        'controller' => 'admin/refSeller',
                    ),
                )
            ),
        );

        return $list_menu;
    }
}
