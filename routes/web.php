<?php
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
})->name('root');

Route::get('/tes', function() {
    return view('tes');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['checkRole:admin'])->prefix('admin')->name('admin.')->group(function()
{
	Route::get('/dashboard', 'DashboardController@admin')->name('dashboard');

	Route::get('/user', 'UserController@index')->name('user.index');
	Route::get('/user/create', 'UserController@create')->name('user.create');
	Route::post('/user', 'UserController@store')->name('user.store');
	Route::get('/user/{id_user}', 'UserController@show')->name('user.show');
	Route::get('/user/{id_user}/edit', 'UserController@edit')->name('user.edit');
	Route::put('/user/{id_user}', 'UserController@update')->name('user.update');
	Route::delete('/user/{id_user}', 'UserController@destroy')->name('user.destroy');
	Route::get('/user/{id_user}/resetPassword', 'UserController@resetPassword')->name('user.resetPassword');
	Route::put('/user/{id_user}/updatePassword', 'UserController@updatePassword')->name('user.updatePassword');

	Route::resource('/kategori', 'KategoriController')->except(['create', 'edit', 'show']);
	// Route::resource('/divisi', 'DivisiController')->except(['create', 'edit', 'show']);
	Route::resource('/lemari', 'LemariController');
	
});

Route::get('/profile', 'UserController@show')->name('profile');
Route::get('/profile/edit', 'UserController@edit')->name('profile.edit');
Route::put('/profile/{id_user}', 'UserController@update')->name('profile.update');
Route::get('/profile/resetPassword', 'UserController@resetPassword')->name('profile.resetPassword');
Route::put('/profile/{id_user}/updatePassword', 'UserController@updatePassword')->name('profile.updatePassword');

Route::middleware(['checkRole:operator'])->prefix('operator')->name('operator.')->group(function()
{
	Route::get('/dashboard', 'DashboardController@operator')->name('dashboard');

	Route::resource('/surat-masuk', 'SuratMasukController');
	Route::get('/surat-masuk/kelengkapan/{data}', 'SuratMasukController@kelengkapan')->name('surat-masuk.kelengkapan');

	Route::resource('/surat-keluar', 'SuratKeluarController');
	Route::get('/surat-keluar/kelengkapan/{data}', 'SuratKeluarController@kelengkapan')->name('surat-keluar.kelengkapan');
});

Route::middleware(['checkRole:manajer'])->prefix('manajer')->name('manajer.')->group(function()
{
	Route::get('/dashboard', 'DashboardController@manajer')->name('dashboard');
	Route::get('/surat-masuk', 'SuratMasukController@index')->name('surat-masuk.index');
	Route::get('/surat-masuk/{id}', 'SuratMasukController@show')->name('surat-masuk.show');
	Route::get('/surat-keluar', 'SuratKeluarController@index')->name('surat-keluar.index');
	Route::get('/surat-keluar/{id}', 'SuratKeluarController@show')->name('surat-keluar.show');

	Route::put('/surat-keluar/{id}/updateStatus', 'SuratKeluarController@updateStatus')->name(
		'surat-keluar.updateStatus');

	Route::get('/laporan', 'LaporanController@index')->name('laporan.index');
	// Route::get('/notif/surat-keluar/{id}', 'NotificationController@readSuratKeluar')->name('notification.surat-keluar');
});

//Read Notification surat (masuk dan keluar)
Route::get('/notif/surat/{id}', 'NotificationController@readSurat')->name('notification.readSurat');

//AJAX
Route::post('/laporan/getData', 'LaporanController@getData')->name('laporan.getData');
Route::put('surat-masuk/updateStatus', 'SuratMasukController@updateStatus')->name('surat-masuk.updateStatus');
