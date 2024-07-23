<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SidebarMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KepegawaianController;

Route::get('/',                                 [MaintenanceController::class, 'index'])->name('index');
Route::get('/buku-tamu',                        [GuestBookController::class, 'showBukuTamu'])->name('show.bukutamu');
Route::post('/submit-guestbook',                [GuestbookController::class, 'submit'])->name('submit-guestbook');

Route::get('/auth',                             [AuthController::class, 'showLoginForm'])->name('login.view')->middleware(RedirectIfAuthenticated::class);
Route::get('/register',                         [AuthController::class, 'showRegisterForm'])->name('register.view')->middleware(RedirectIfAuthenticated::class);
Route::get('/logout',                           [AuthController::class, 'logout'])->name('logout');
Route::post('/login',                           [AuthController::class, 'login'])->name('submitLogin');

Route::post('/register',                        [AuthController::class, 'register'])->name('register');
Route::get('/email/verify',                     [AuthController::class, 'verifyEmail'])->name('email.verify');
Route::get('/whatsapp/verify',                  [AuthController::class, 'verifyWhatsapp'])->name('whatsapp.verify');

    Route::get('/admin/user/access',                [AdminController::class, 'showRole'])->name('admin.user.access');
    Route::get('/admin/menu/menulist',              [AdminController::class, 'showMenu'])->name('admin.menu.menulist');
    Route::get('/admin/menu/submenulist',           [AdminController::class, 'showsubMenu'])->name('admin.menu.submenulist');
    Route::get('/admin/menu/childmenulist',         [AdminController::class, 'showchildMenu'])->name('admin.menu.childmenulist');
    Route::get('/admin/menu/role',                  [AdminController::class, 'showRoleList'])->name('admin.menu.role');

Route::middleware([AuthMiddleware::class, SidebarMiddleware::class])->group(function () {
    Route::get('/kepegawaian/pegawai/list',         [KepegawaianController::class, 'showPegawaiList'])->name('kepegawaian.pegawai.list');

    Route::get('/user/account/detil',               [UserController::class, 'showAccount'])->name('user.account.detil');
    Route::get('/user/account/activity',            [UserController::class, 'showActivity'])->name('user.account.activity');
    
    // Route::get('/admin/user/access',                [AdminController::class, 'showRole'])->name('admin.user.access');
    // Route::get('/admin/menu/menulist',              [AdminController::class, 'showMenu'])->name('admin.menu.menulist');
    // Route::get('/admin/menu/submenulist',           [AdminController::class, 'showsubMenu'])->name('admin.menu.submenulist');
    // Route::get('/admin/menu/childmenulist',         [AdminController::class, 'showchildMenu'])->name('admin.menu.childmenulist');
    // Route::get('/admin/menu/role',                  [AdminController::class, 'showRoleList'])->name('admin.menu.role');
    Route::get('/admin/instansi',            [AdminController::class, 'showInstasi'])->name('admin.instansi');
});
        
        
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::post('/admin/user/changeaccess',         [AdminController::class, 'changeAccess'])->name('admin.user.changeaccess');    
    Route::post('/menu',                            [AdminController::class, 'addMenu'])->name('menu.add');
    Route::post('/add-submenu',                     [AdminController::class, 'addSubmenu'])->name('add.submenu');
    Route::post('/add-childsubmenu',                [AdminController::class, 'addChildSubmenu'])->name('add.ChildSubmenu');
    Route::get('/delete/menu',                      [AdminController::class, 'deleteMenu'])->name('delete.menu');
    Route::post('/role/add',                        [AdminController::class, 'addRole'])->name('role.add');
    Route::post('/role/edit',                       [AdminController::class, 'editRole'])->name('role.edit');
    Route::get('/delete/role',                      [AdminController::class, 'deleteRole'])->name('role.delete');
    Route::post('/account/avatar',                  [UserController::class, 'uploadAvatar'])->name('upload.avatar');
    Route::post('/account/update',                  [UserController::class, 'accountUpdate'])->name('account.update');    
    Route::post('/pegawai/add',                     [KepegawaianController::class, 'pegawaiAdd'])->name('pegawai.add');
    //Move
        Route::post('/move-menu',                   [AdminController::class, 'moveMenu'])->name('move.menu');
        Route::post('/move-submenu',                [AdminController::class, 'moveSubmenu'])->name('move.submenu');
        Route::post('/move-childsubmenu',           [AdminController::class, 'moveChildSubmenu'])->name('moveChildSubmenu');
    //!Move
    Route::post('/store-device-token',              [NotificationController::class, 'storeDeviceToken']);
    Route::post('/check-divice',                    [NotificationController::class, 'checkDivice']);
    Route::post('/send-notification/{userId}', [NotificationController::class, 'sendNotificationToUser']);
    Route::get('/test-notif', function () {return view('test-notif');});    
    
    

    Route::get('/getdata/menu',                     [AdminController::class, 'getDataMenu'])->name('menu.getData');
    Route::get('/getdata/submenu',                  [AdminController::class, 'getDatasubMenu'])->name('getDatasubMenu');
    Route::get('/getdata/childmenu',                [AdminController::class, 'getDataChildMenu'])->name('getDataChildMenu');
    Route::get('/getdata/rolelist',                 [AdminController::class, 'getDataRoleList'])->name('roleList.getData');
    Route::get('/getdata/pegawai',                  [KepegawaianController::class, 'pegawaiGetData'])->name('pegawai.getData');
});


