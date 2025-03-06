<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('mahasiswa/showName/(:any)', 'Mahasiswa::showName/$1');
$routes->get('user/showName/(:any)', 'User::showName/$1');
$routes->resource('user');
$routes->resource('dosen');
$routes->resource('cuti');
$routes->resource('kajur');
$routes->resource('baup');
$routes->resource('koorperpus');
$routes->resource('admin');
$routes->resource('mahasiswa');