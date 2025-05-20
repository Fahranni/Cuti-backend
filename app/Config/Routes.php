<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home default
$routes->get("/", "Home::index");

// Mahasiswa
$routes->get("mahasiswa/showName/(:any)", 'Mahasiswa::showName/$1');
$routes->get("mahasiswa/(:segment)", 'Mahasiswa::show/$1');
$routes->put("mahasiswa/(:segment)", "Mahasiswa::update/$1");
$routes->put("user/(:segment)", "User::update/$1");
$routes->get("mahasiswa", "Mahasiswa::index");
$routes->delete("mahasiswa/(:any)", 'Mahasiswa::delete/$1');
$routes->delete("user/(:any)", 'User::delete/$1');
$routes->options("mahasiswa/(:segment)", "Mahasiswa::options");
$routes->post("mahasiswa", "Mahasiswa::create"); // <-- ini penting
$routes->post("user", "User::create");
$routes->put("mahasiswa/(:segment)", "Mahasiswa::update/$1"); // biar PUT juga aman

// Cuti
$routes->get("cuti/npm/(:any)", 'Cuti::getCutiByNpm/$1');
$routes->post("cuti", "Cuti::create");
$routes->post("cuti/(:segment)", "Cuti::createWithNpm/$1"); // Kalau kamu butuh bisa dipakai
$routes->resource("cuti");
$routes->post("pengajuancuti", "PengajuanCuti::getMahasiswaCuti");
$routes->get("pengajuan-cuti", "PengajuanCuti::index");

// User
$routes->get("user/showName/(:any)", 'User::showName/$1');
$routes->get("/user", "User::index");
$routes->post("/riwayatCuti", "RiwayatMhs::getCuti");
$routes->post("/mhsberanda", "MhsBeranda::getMahasiswa");
$routes->post("/pengajuancuti", "PengajuanCuti::getMahasiswaCuti");
$routes->post("/riwayatadmin", "RiwayatAdmin::getRiwayatAdmin");
$routes->post("/viewberandamahasiswa", "BerandaMhs::getBerandaMahasiswa");
$routes->post("/viewriwayatadmin", "RiwayatAdmView::getRiwayatAdmin");
$routes->post("/viewriwayatmahasiswa", "RiwayatMhsView::getMahasiswaCuti");

// Kajur
$routes->options("kajur/(:segment)", 'Kajur::options/$1');
$routes->get("kajur/(:segment)", 'Kajur::show/$1');
$routes->resource("kajur");
$routes->post("/viewberandakajur", "KajurBrnd::getBerandaKajurCntrl");

// Admin
$routes->resource("admin");

// Global CORS preflight (OPTIONS) handling
$routes->options("(:any)", "Home::options");
