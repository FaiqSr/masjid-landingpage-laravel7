<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Frontend)
|--------------------------------------------------------------------------
*/

Route::get('/', 'FrontController@beranda')->name('beranda');
Route::get('kontak', 'FrontController@kontak')->name('kontak');
Route::get('artikel', 'FrontController@berita')->name('artikel');
Route::get('profil', 'FrontController@profil')->name('profil');
Route::get('artikel/{slug}', 'FrontController@beritaDetail')->name('artikel.detail');

Route::get('keuangan', 'FrontController@keuanganList')->name('keuangan.list');
Route::get('keuangan/detail/{id}', 'FrontController@keuanganDetail')->name('keuangan.detail');

Route::get('/ppdb/register', 'PpdbController@create')->name('ppdb.register');
Route::post('/ppdb/store', 'PpdbController@store')->name('ppdb.store');
Route::get('/ppdb/success', 'PpdbController@success')->name('ppdb.success');

Route::post('/ppdb/search', 'PpdbController@searchByNik')->name('ppdb.search');
Route::get('/ppdb/result/{id}', 'PpdbController@showResult')->name('ppdb.result.show');
Route::get('/ppdb/result/{id}/download', 'PpdbController@downloadPdf')->name('ppdb.result.download');

Route::group(['middleware' => 'authLogin'], function () {
    Route::get('login_page', 'AuthController@showLogin')->name('login_page');
    Route::post('loginSiswa', 'AuthController@siswaLogin')->name('login.siswa.submit');
    Route::post('login', 'AuthController@login')->name('login.admin.submit');
});
Route::get('logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'CheckLoginMiddleware'], function () {
    // --- Rute Utama Dasbor ---
    Route::get('dashboard', 'DashboardController@index')->name('dashboard_admin');
    Route::get('ganti_setting', 'DashboardController@ganti_setting')->name('ganti_setting');
    Route::post('ganti_setting/resetsetting', 'DashboardController@reset_usersetting')->name('ganti_setting/resetsetting');

    // --- Manajemen Berita (News) ---
    Route::prefix('dashboard/news')->group(function () {
        Route::get('/index', 'NewsController@index')->name('dashboard/news/index');
        Route::get('/add', 'NewsController@create')->name('dashboard/news/add');
        Route::post('/add', 'NewsController@add')->name('dashboard/news/add'); // Nama duplikat, dibiarkan sesuai permintaan
        Route::get('/edit/{id}', 'NewsController@edit')->name('dashboard/news/edit');
        Route::post('/edit', 'NewsController@update')->name('dashboard/news/edit'); // Nama duplikat, dibiarkan sesuai permintaan
        Route::get('/delete/{id}', 'NewsController@delete')->name('dashboard/news/news/delete');
        Route::get('/detail/{id}', 'NewsController@detail')->name('dashboard/news/detail');
    });

    // --- Manajemen Slider ---
    Route::prefix('dashboard/sliders')->group(function () {
        Route::get('/index', 'SlidersController@index')->name('dashboard/sliders/index');
        Route::get('/add', 'SlidersController@create')->name('dashboard/sliders/add');
        Route::post('/add', 'SlidersController@add')->name('dashboard/sliders/add');
        Route::get('/edit/{id}', 'SlidersController@edit')->name('dashboard/sliders/edit');
        Route::post('/edit', 'SlidersController@update')->name('dashboard/sliders/edit');
        Route::get('/delete/{id}', 'SlidersController@delete')->name('dashboard/sliders/delete');
    });

    // --- Manajemen Galeri ---
    Route::prefix('dashboard/galery')->group(function () {
        Route::get('/', 'GaleryController@index')->name('dashboard/galery/index');
        Route::get('/add', 'GaleryController@add')->name('dashboard/galery/add');
        Route::post('/add', 'GaleryController@create')->name('dashboard/galery/add');
        Route::get('/edit/{id}', 'GaleryController@edit')->name('dashboard/galery/edit');
        Route::post('/edit', 'GaleryController@update')->name('dashboard/galery/edit');
        Route::get('/delete/{id}', 'GaleryController@delete')->name('dashboard/galery/delete');
    });

    // --- Pengaturan Website ---
    Route::prefix('dashboard/settings')->group(function () {
        Route::get('/', 'SettingController@edit')->name('setting.edit');
        Route::put('/', 'SettingController@update')->name('setting.update');
    });

    Route::prefix('dashboard/ppdb')
        ->name('ppdb.')
        ->group(function () {
            Route::get('/', 'Admin\PpdbAdminController@index')->name('index');
            Route::get('/siswa/{id}', 'Admin\PpdbAdminController@show')->name('show');

            Route::get('/sudah-berkas', 'Admin\PpdbAdminController@sudahBerkas')->name('sudah_berkas');
            Route::get('/belum-berkas', 'Admin\PpdbAdminController@belumBerkas')->name('belum_berkas');

            // Menampilkan form edit (Edit)
            Route::get('/{id}/edit', 'Admin\PpdbAdminController@edit')->name('edit');

            // Memproses update dari form edit (Update)
            Route::put('/{id}', 'Admin\PpdbAdminController@update')->name('update');

            // Menghapus data pendaftar (Delete)
            Route::delete('/{id}', 'Admin\PpdbAdminController@destroy')->name('destroy');
        });

    Route::get('/pengaturan-ppdb', 'Admin\PengaturanPpdbController@index')->name('pengaturan.index');
    Route::post('/pengaturan-ppdb', 'Admin\PengaturanPpdbController@store')->name('pengaturan.store');
    Route::put('/pengaturan-ppdb/{id}/set-active', 'Admin\PengaturanPpdbController@setActive')->name('pengaturan.setActive');
    Route::delete('/pengaturan-ppdb/{id}', 'Admin\PengaturanPpdbController@destroy')->name('pengaturan.destroy');
});

Route::group(['middleware' => 'SiswaMiddleware'], function () {
    Route::prefix('dashboard/siswa')
        ->name('dashboard.')
        ->group(function () {
            Route::get('/', 'SiswaDashboardController@index')->name('siswa.index');
            Route::get('/show', 'SiswaDashboardController@showData')->name('siswa.show');
            Route::get('/edit', 'SiswaDashboardController@edit')->name('siswa.edit');
            Route::put('/update', 'SiswaDashboardController@update')->name('siswa.update');
        });
});
