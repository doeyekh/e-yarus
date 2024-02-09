<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/admin/tahun-ajar', 'TahunAjar::index');
$routes->get('/admin/tahunajar', 'TahunAjar::getData');
$routes->post('/admin/tahun-ajar', 'TahunAjar::insert');
$routes->put('/admin/tahun-ajar', 'TahunAjar::update');

$routes->get('/admin/guru-aktif','Guru::index');
$routes->get('/admin/guruaktif','Guru::getDataGuruActive');
$routes->post('/admin/guru-aktif','Guru::insertUpdate');
$routes->post('/admin/guru-import','Guru::import');
$routes->put('/admin/guru-aktif','Guru::edit');
$routes->put('/admin/guruaktif','Guru::updateStatus');
$routes->get('/admin/guru-nonaktif','Guru::guruNon');
$routes->get('/admin/gurunonaktif','Guru::getDataGuruNonActive');

$routes->get('/admin/data-sekolah','Sekolah::index');
$routes->get('/admin/data-pesantren','Sekolah::pesantren');
$routes->get('/admin/datapesantren','Sekolah::getPesantren');
$routes->get('/admin/datasekolah','Sekolah::getData');
$routes->post('/admin/data-sekolah','Sekolah::insertSekolah');
$routes->put('/admin/data-sekolah','Sekolah::getSekolah');

$routes->get('/admin/data-kantin','Kantin::index');
$routes->get('/admin/datakantin','Kantin::getData');
$routes->post('/admin/data-kantin','Kantin::insert');
$routes->put('/admin/data-kantin','Kantin::update');

$routes->get('/admin/data-wakasek','Wakasek::index');
$routes->get('/admin/datawakasek','Wakasek::getData');
$routes->PUT('/admin/datawakasek','Wakasek::updateStatus');
$routes->post('/admin/data-wakasek','Wakasek::insert');
$routes->put('/admin/data-wakasek','Wakasek::edit');

$routes->get('/admin/siswa-aktif','Siswa::index');
$routes->get('/admin/tarik-siswa','Siswa::tarikRegistrasi');
$routes->post('/admin/tarik-siswa','Siswa::salinRegistrasi');
$routes->get('/admin/tariksantri','Siswa::getTarikRegistrasi');
$routes->POST('/admin/santri','Siswa::insert');
$routes->post('/admin/santri-upload/(:any)','Siswa::upload/$1');
$routes->PUT('/admin/santri','Siswa::update');
$routes->get('/admin/santri','Siswa::getData');
$routes->get('/admin/santri/(:any)','Siswa::detail/$1');
$routes->post('/admin/ortu-santri','Siswa::updateOrtu');
$routes->post('/admin/regis-santri','Siswa::updateRegis');
$routes->post('/admin/alumni-santri','Siswa::regisAlumni');
$routes->get('/admin/data-alumni','Siswa::indexAlumni');
$routes->get('/admin/dataalumni','Siswa::getAlumni');
$routes->post('/admin/santri-import','Siswa::importSantri');

$routes->get('/admin/ortu','OrangTua::index');
$routes->get('/admin/data-ortu','OrangTua::getData');
$routes->POST('/admin/orang-tua','OrangTua::insertUpdate');
$routes->PUT('/admin/orang-tua','OrangTua::edit');
$routes->DELETE('/admin/orang-tua','OrangTua::Delete');

$routes->get('/admin/data-kelas','Kelas::index');
$routes->get('/admin/datakelas','Kelas::getData');
$routes->POST('/admin/data-kelas','Kelas::insertUpdate');
$routes->DELETE('/admin/data-kelas','Kelas::delete');
$routes->PUT('/admin/data-kelas','Kelas::update');

$routes->get('/admin/kartu-santri','KartuSantri::index');
$routes->post('/admin/kartu-santri','KartuSantri::generateKartu');
$routes->get('/admin/datakartu','KartuSantri::getData');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
