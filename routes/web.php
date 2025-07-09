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
Route::get('artikel/{slug}', 'FrontController@beritaDetail')->name('artikel.detail');
Route::get('pengumuman/', 'FrontController@pengumuman')->name('pengumuman');
Route::get('pengumuman/{id}', 'FrontController@pengumumanDetail')->name('pengumuman.detail');
Route::get('profil', 'FrontController@profil')->name('profil');
Route::get('galery', 'FrontController@galery')->name('galery');
Route::get('layanan/', 'FrontController@layanan')->name('layanan');
Route::get('layanan/{id}', 'FrontController@layananDetail')->name('layanan.detail');

Route::get('keuangan', 'FrontController@keuanganList')->name('keuangan.list');
Route::get('keuangan/detail/{id}', 'FrontController@keuanganDetail')->name('keuangan.detail');



/*
|--------------------------------------------------------------------------
| Rute Otentikasi (Login/Logout)
|--------------------------------------------------------------------------
*/
Route::get('login_page', 'FrontController@login_page')->name('login_page');
Route::post('login', 'AuthController@login')->name('login');
Route::get('logout', 'AuthController@logout')->name('logout');

/*
|--------------------------------------------------------------------------
| Rute Dasbor (Memerlukan Login)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'CheckLoginMiddleware'], function () {
    // --- Rute Utama Dasbor ---
    Route::get('dashboard', 'DashboardController@index')->name('dashboard_admin');
    Route::get('ganti_setting', 'DashboardController@ganti_setting')->name('ganti_setting');
    Route::post('ganti_setting/resetsetting', 'DashboardController@reset_usersetting')->name('ganti_setting/resetsetting');

    // --- Manajemen Petugas Harian ---
    Route::prefix('dashboard/petugas-harian')
        ->name('petugas.')
        ->group(function () {
            Route::get('/', 'PetugasController@index')->name('index');
            Route::get('/edit/{id}', 'PetugasController@edit')->name('edit');
            Route::post('/edit', 'PetugasController@update')->name('update');
        });



    Route::prefix('dashboard/keuangan')->name('keuangan.')->group(function () {
        Route::get('/', 'KeuanganController@index')->name('index');
        Route::get('/create', 'KeuanganController@create')->name('create');
        Route::post('/store', 'KeuanganController@store')->name('store');
        Route::get('/show/{id}', 'KeuanganController@show')->name('show');
        Route::get('/delete/{id}', 'KeuanganController@destroy')->name('destroy');

        Route::post('/detail/store/{header_id}', 'KeuanganController@storeDetail')->name('detail.store');
        Route::get('/detail/delete/{id}', 'KeuanganController@destroyDetail')->name('detail.destroy');
    });
    // --- Manajemen Pengurus ---
    Route::prefix('dashboard/pengurus')
        ->name('pengurus.')
        ->group(function () {
            Route::get('/', 'PengurusController@index')->name('index');
            Route::get('/create', 'PengurusController@create')->name('create');
            Route::post('/store', 'PengurusController@store')->name('store');
            Route::get('/edit/{id}', 'PengurusController@edit')->name('edit');
            Route::put('/update/{id}', 'PengurusController@update')->name('update');
            Route::get('/delete/{id}', 'PengurusController@destroy')->name('destroy');
        });

    // --- Manajemen Layanan ---
    Route::prefix('dashboard/layanan')
        ->name('layanan.')
        ->group(function () {
            Route::get('/', 'LayananController@index')->name('index');
            Route::get('/create', 'LayananController@create')->name('create');
            Route::post('/store', 'LayananController@store')->name('store');
            Route::get('/edit/{id}', 'LayananController@edit')->name('edit');
            Route::put('/update/{id}', 'LayananController@update')->name('update');
            Route::get('/delete/{id}', 'LayananController@destroy')->name('destroy');
        });

    // --- Manajemen Pengumuman ---
    Route::prefix('dashboard/pengumuman')
        ->name('pengumuman.')
        ->group(function () {
            Route::get('/', 'PengumumanController@index')->name('index');
            Route::get('/create', 'PengumumanController@create')->name('create');
            Route::post('/store', 'PengumumanController@store')->name('store');
            Route::get('/edit/{id}', 'PengumumanController@edit')->name('edit');
            Route::put('/update/{id}', 'PengumumanController@update')->name('update');
            Route::get('/delete/{id}', 'PengumumanController@destroy')->name('destroy');
        });

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
});
