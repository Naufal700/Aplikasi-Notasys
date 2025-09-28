<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\klien\KlienController;
use App\Http\Controllers\master\PartnerController;
use App\Http\Controllers\master\ProvinsiController;
use App\Http\Controllers\setting\SettingController;
use App\Http\Controllers\klien\PerusahaanController;
use App\Http\Controllers\master\KabupatenController;
use App\Http\Controllers\keuangan\KeuanganController;
use App\Http\Controllers\klien\BankLeasingController;
use App\Http\Controllers\jenisakta\JenisAktaController;
use App\Http\Controllers\keuangan\MasterKasBankController;
use App\Http\Controllers\lembarkerja\LembarKerjaController;

/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/
Route::post('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Redirect root ke login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Halaman Login (bebas diakses)
|--------------------------------------------------------------------------
*/
Route::get('/auth/login-basic', function() {
    return view('content.authentications.auth-login-basic');
})->name('login');

Route::post('/auth/login-basic', function (Request $request) {
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    // Login bisa pakai email atau username
    $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    $credentials = [$loginType => $request->login, 'password' => $request->password];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard'); // langsung ke dashboard
    }

    return back()->with('error', 'Email atau Username / Password salah');
})->name('login.perform');

/*
|--------------------------------------------------------------------------
| Halaman Register (bebas diakses)
|--------------------------------------------------------------------------
*/
Route::get('/auth/register-basic', function() {
    return view('content.authentications.auth-register-basic');
})->name('register');

Route::post('/auth/register-basic', function(Request $request){
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    \App\Models\User::create([
        'name' => $request->username,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'email_verified_at' => now(),
    ]);

    // Arahkan ke login, jangan login otomatis
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
})->name('register.perform');

/*
|--------------------------------------------------------------------------
| Halaman Lupa Password (bebas diakses)
|--------------------------------------------------------------------------
*/
Route::get('/auth/forgot-password-basic', function(){
    return view('content.authentications.auth-forgot-password-basic');
})->name('password.request');

Route::post('/auth/forgot-password-basic', function(Request $request){
    $request->validate(['email' => 'required|email']);

    \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));

    return back()->with('status', 'Link reset password sudah dikirim ke email Anda.');
})->name('password.email');

/*
|--------------------------------------------------------------------------
| Semua route yang membutuhkan login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function() {
        return view('content.dashboard.dashboards-analytics');
    })->name('dashboard');

//  Route Maste Jenis Akta
Route::prefix('jenis')->group(function () {
    Route::resource('akta', JenisAktaController::class)
        ->names([
            'index'   => 'jenis.akta.index',
            'create'  => 'jenis.akta.create',
            'store'   => 'jenis.akta.store',
            'edit'    => 'jenis.akta.edit',
            'update'  => 'jenis.akta.update',
            'destroy' => 'jenis.akta.destroy',
        ])
        ->parameters(['akta' => 'jenis_akta']); // <<< penting
});


    /*
    |--------------------------------------------------------------------------
    | Route Klien
    |--------------------------------------------------------------------------
    */
Route::prefix('klien')->group(function () {

    // Ajax / API
    Route::get('/get-provinsi', [KlienController::class, 'getProvinsi'])->name('klien.getProvinsi');
    Route::get('/get-kabupaten', [KlienController::class, 'getKabupaten'])->name('klien.getKabupaten');
    Route::get('/get-kota', [KlienController::class, 'getKota'])->name('klien.getKota');

    Route::get('/search-provinsi', [KlienController::class, 'searchProvinsi'])->name('klien.searchProvinsi');
    Route::get('/search-kabupaten', [KlienController::class, 'searchKabupaten'])->name('klien.searchKabupaten');
    Route::get('/search-kota', [KlienController::class, 'searchKota'])->name('klien.searchKota');

    // Dashboard klien harus di atas {klien} supaya tidak tertangkap sebagai parameter
    Route::get('/dashboard-klien', [KlienController::class, 'dashboard'])->name('klien.dashboard');

    // CRUD klien
    Route::get('/', [KlienController::class, 'index'])->name('klien.index');
    Route::get('/create', [KlienController::class, 'create'])->name('klien.create');
    Route::post('/', [KlienController::class, 'store'])->name('klien.store');

    // Route dengan parameter {klien} harus diberi constraint number untuk menghindari conflict
    Route::get('/{klien}', [KlienController::class, 'show'])
        ->whereNumber('klien')
        ->name('klien.show');

    Route::get('/{klien}/edit', [KlienController::class, 'edit'])
        ->whereNumber('klien')
        ->name('klien.edit');

    Route::put('/{klien}', [KlienController::class, 'update'])
        ->whereNumber('klien')
        ->name('klien.update');

    Route::delete('/{klien}', [KlienController::class, 'destroy'])
        ->whereNumber('klien')
        ->name('klien.destroy');
});


    /*
    |--------------------------------------------------------------------------
    | Route Bank Leasing
    |--------------------------------------------------------------------------
    */
    Route::prefix('bank-leasing')->name('bank-leasing.')->group(function(){
        Route::get('/', [BankLeasingController::class, 'index'])->name('index');
        Route::get('/create', [BankLeasingController::class, 'create'])->name('create');
        Route::post('/', [BankLeasingController::class, 'store'])->name('store');
        Route::get('/{bankLeasing}/edit', [BankLeasingController::class, 'edit'])->name('edit');
        Route::put('/{bankLeasing}', [BankLeasingController::class, 'update'])->name('update');
        Route::delete('/{bankLeasing}', [BankLeasingController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Route Perusahaan
    |--------------------------------------------------------------------------
    */
    Route::prefix('perusahaan')->name('perusahaan.')->group(function () {
        Route::get('/', [PerusahaanController::class, 'index'])->name('index');
        Route::get('/create', [PerusahaanController::class, 'create'])->name('create');
        Route::post('/store', [PerusahaanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PerusahaanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PerusahaanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PerusahaanController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Route Lembar Kerja
    |--------------------------------------------------------------------------
    */
   Route::prefix('lembar-kerja')->name('lembar-kerja.')->group(function() {
    Route::get('/', [LembarKerjaController::class, 'index'])->name('index');
    Route::get('/create', [LembarKerjaController::class, 'create'])->name('create');
    Route::post('/', [LembarKerjaController::class, 'store'])->name('store');
    Route::get('/{lembarKerja}/edit', [LembarKerjaController::class, 'edit'])->name('edit');
    Route::put('/{lembarKerja}', [LembarKerjaController::class, 'update'])->name('update');
    Route::delete('/{lembarKerja}', [LembarKerjaController::class, 'destroy'])->name('destroy');

    Route::get('/get-klien/{id}', [LembarKerjaController::class, 'getTipeKlien'])->name('getTipeKlien');
    Route::get('/monitoring', [LembarKerjaController::class, 'monitoring'])->name('monitoring');

    Route::post('/upload-file', [LembarKerjaController::class, 'uploadFile'])->name('uploadFile');
    Route::get('/{id}/print', [LembarKerjaController::class, 'print'])->name('print'); // cukup 'print'
//  Tambah Tagihan
    Route::post('/{id}/tagihan', [LembarKerjaController::class, 'storeTagihan'])->name('tagihan.store');
    // Hapus Tagihan
  Route::delete('/{id}/tagihan/{tagihan}', [LembarKerjaController::class, 'destroyTagihan'])->name('tagihan.destroy');
    // Edit tagihan
    Route::put('/{id}/tagihan/{tagihan}', [LembarKerjaController::class, 'updateTagihan'])->name('tagihan.update');
    Route::get('/{id}/tagihan/total', [LembarKerjaController::class, 'getTotalTagihan'])->name('tagihan.total');
Route::get('/dashboard', [LembarKerjaController::class, 'dashboard'])->name('lembar-kerja.dashboard');

});
// proses lembar kerja
Route::prefix('lembar-kerja')->name('lembar-kerja.')->group(function() {
    Route::post('/{lembarKerja}/proses', [LembarKerjaController::class, 'storeProses'])->name('proses.store');
    Route::put('/proses/{proses}', [LembarKerjaController::class, 'updateProses'])->name('proses.update');
    Route::delete('/proses/{proses}', [LembarKerjaController::class, 'destroyProses'])->name('proses.destroy');
    Route::get('/{lembarKerja}/proses', [LembarKerjaController::class, 'getProses'])->name('proses.index');
    Route::get('/proses/{proses}', [LembarKerjaController::class, 'showProses'])->name('proses.show');
});
Route::patch('/lembar-kerja/{id}/update-status', [LembarKerjaController::class, 'updateStatus'])
    ->name('lembar-kerja.update-status');
// route keuangan
Route::prefix('keuangan')->group(function () {
    Route::get('/', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('cetak/{id}', [KeuanganController::class, 'printTagihan'])->name('tagihan.print');
});
// Master Kas Bank
Route::prefix('keuangan/master')->group(function() {
    Route::resource('kasbank', MasterKasBankController::class, [
        'names' => [
            'index' => 'master.kasbank.index',
            'create' => 'master.kasbank.create',
            'store' => 'master.kasbank.store',
            'edit' => 'master.kasbank.edit',
            'update' => 'master.kasbank.update',
            'destroy' => 'master.kasbank.destroy',
        ]
    ]);
});
// Dashboard Keuangan
Route::get('/keuangan/dashboard', [KeuanganController::class, 'dashboard'])->name('keuangan.dashboard');
// Master Partner
Route::prefix('partners')->group(function() {
    Route::get('/', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('/create', [PartnerController::class, 'create'])->name('partners.create');
    Route::post('/store', [PartnerController::class, 'store'])->name('partners.store');
    Route::get('/{partner}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
    Route::put('/{partner}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');

    // AJAX route untuk ambil kabupaten
    Route::get('/kabupaten/{provinsi_id}', [PartnerController::class, 'getKabupaten'])->name('partners.kabupaten');
});
// ================== PROVINSI ================== //
// CRUD Provinsi
Route::prefix('provinsi')->name('provinsi.')->group(function () {
    Route::get('/', [ProvinsiController::class, 'index'])->name('index');
    Route::get('/create', [ProvinsiController::class, 'create'])->name('create');
    Route::post('/store', [ProvinsiController::class, 'store'])->name('store');
    Route::get('/{provinsi}/edit', [ProvinsiController::class, 'edit'])->name('edit');
    Route::put('/{provinsi}/update', [ProvinsiController::class, 'update'])->name('update');
    Route::delete('/{provinsi}/delete', [ProvinsiController::class, 'destroy'])->name('destroy');

    // Endpoint AJAX untuk dropdown select2
    Route::get('/all', [ProvinsiController::class, 'getAll'])->name('getAll');
});

// ================== KABUPATEN ================== //
// CRUD Kabupaten
Route::prefix('kabupaten')->name('kabupaten.')->group(function () {
    Route::get('/', [KabupatenController::class, 'index'])->name('index');
    Route::get('/create', [KabupatenController::class, 'create'])->name('create');
    Route::post('/store', [KabupatenController::class, 'store'])->name('store');
    Route::get('/{kabupaten}/edit', [KabupatenController::class, 'edit'])->name('edit');
    Route::put('/{kabupaten}/update', [KabupatenController::class, 'update'])->name('update');
    Route::delete('/{kabupaten}/delete', [KabupatenController::class, 'destroy'])->name('destroy');

    // Endpoint AJAX untuk ambil kabupaten berdasarkan provinsi
    Route::get('/provinsi/{provinsi_id}', [KabupatenController::class, 'getByProvinsi'])->name('getByProvinsi');
});
// Route Log Aktivitas
Route::get('/aktivitas', [App\Http\Controllers\LogAktivitasController::class, 'index'])
    ->name('aktivitas.index')
    ->middleware('auth');
// Route Setting
Route::prefix('setting')->group(function(){

    // Halaman setting (index)
    Route::get('/', [SettingController::class, 'index'])->name('setting.index');

    // Simpan Profil Notaris
    Route::post('/profil-notaris', [SettingController::class, 'saveProfilNotaris'])->name('setting.profil_notaris.save');

    // Ambil kabupaten berdasarkan provinsi (AJAX)
    Route::get('/get-kabupaten', [SettingController::class, 'getKabupaten'])->name('setting.get_kabupaten');

    // Tambahan route tab lain bisa ditambah di sini
    // Route::post('/tab-lain', [SettingController::class, 'saveTabLain'])->name('setting.tab_lain.save');

});
});
