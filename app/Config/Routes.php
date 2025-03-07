<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('mahasiswa/showName/(:any)', 'Mahasiswa::showName/$1');
$routes->get('user/showName/(:any)', 'User::showName/$1');
$routes->post('/riwayatCuti', 'RiwayatMhs::getCuti');
$routes->post('/mhsberanda', 'MhsBeranda::getMahasiswa');
$routes->post('/pengajuancuti', 'PengajuanCuti::getMahasiswaCuti');
$routes->post('/riwayatadmin', 'RiwayatAdmin::getRiwayatAdmin');
$routes->post('/viewberandadosen', 'BerandaDosen::getBerandaData');
$routes->post('/viewberandamahasiswa', 'BerandaMhs::getBerandaMahasiswa');
$routes->post('/viewriwayatadmin', 'RiwayatAdmView::getRiwayatAdmin');
$routes->post('/viewriwayatmahasiswa', 'RiwayatMhsView::getMahasiswaCuti');
$routes->resource('user');
$routes->resource('dosen');
$routes->resource('cuti');
$routes->resource('kajur');
$routes->resource('baup');
$routes->resource('koorperpus');
$routes->resource('admin');
$routes->resource('mahasiswa');