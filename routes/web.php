<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\klien\KlienController;
use App\Http\Controllers\klien\PerusahaanController;
use App\Http\Controllers\klien\BankLeasingController;
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
});
// proses lembar kerja
Route::prefix('lembar-kerja')->name('lembar-kerja.')->group(function() {
    Route::post('/{lembarKerja}/proses', [LembarKerjaController::class, 'storeProses'])->name('proses.store');
    Route::put('/proses/{proses}', [LembarKerjaController::class, 'updateProses'])->name('proses.update');
    Route::delete('/proses/{proses}', [LembarKerjaController::class, 'destroyProses'])->name('proses.destroy');
    Route::get('/{lembarKerja}/proses', [LembarKerjaController::class, 'getProses'])->name('proses.index');
    Route::get('/proses/{proses}', [LembarKerjaController::class, 'showProses'])->name('proses.show');
});

});
