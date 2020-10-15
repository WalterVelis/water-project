<?php

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
  if(auth()->check()){
    return redirect('home');
  }else{
    return view('auth.login');
  }
})->name('login');
Route::get('lang/{locale}', 'LocalizationController@index');

Auth::routes();
Route::post('user/doubleFactor','DfaController@checkDoubleFactor')->name('loginDoubleFactor');
Route::post('user/doubleFactor/tokenEmail/verificate','DfaController@tokenByEmail');
Route::post('user/doubleFactor/tokenGoogle/verificate','DfaController@tokenByGoogle');


Route::get('home', 'HomeController@index')->name('home');
Route::get('dashboard', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth','change']], function () {
    Route::resource('role', 'RoleController');
    Route::get('role/uniqueName/{text}', 'RoleController@nameUniqueRol');
    Route::get('role/uniqueUpdateName/{text}/{text2}', 'RoleController@nameUniqueUpdateRol');
    Route::get('roleAllPdf/{all}', 'RoleController@query1PdfRole')->name('rolePdf');
    
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('userAllPdf/{all}', 'UserController@query1PdfUser')->name('userPdf');
    Route::get('userInactiveAllPdf/{all}', 'UserController@query2PdfUser')->name('user2Pdf');
    Route::post('changeUser/{id}','UserController@change');
    Route::post('email2reset/{id}','UserController@email2Reset');
    Route::get('user/uniqueEmail/{text}', 'UserController@emailUniqueUser');
    Route::get('user/uniqueEmailEdit/{text}/{text2}', 'UserController@emailUniqueUserEdit');

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::get('profile/auth-google-view/{value}', 'ProfileController@viewDoubleFactorAuth');
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    Route::post('profile/auth-google', 'ProfileController@doubleFactorGoogle')->name('googleFactor');
    Route::post('profile/auth-google-form', 'ProfileController@login2FA')->name('login.2fa');
    Route::post('profile/auth-google-sendEmail', 'ProfileController@sendEmailDoubleFactor');
    Route::post('profile/auth-google-sendEmailCode', 'ProfileController@tokenEmailCode');
    Route::post('profile/auth-google-activateGoogle', 'ProfileController@activateGoogle')->name('activateGoogle');
    Route::post('profile/dobleFactorActivate', 'ProfileController@doubleFactorAuthenticationActivate')->name('doubleFactorEmail');
    Route::post('profile/dobleFactorDeactivate', 'ProfileController@doubleFactorAuthenticationDeactivate')->name('doubleFactorDeactivate');

    //projects
    Route::resource('projects', 'ProjectController'); 
    
    //Permission Route
    Route::get('permission/searchName/{text}', 'PermissionController@searchNamePermissions');
    Route::get('permission/all', 'PermissionController@searchAllPermissions');

    //Excel Report
    Route::get('user_xlsx', 'UserController@excelExport_xlsx')->name('user_xlsx');
    Route::get('user_csv', 'UserController@excelExport_csv')->name('user_csv');
    Route::get('user_xlsx2', 'UserController@excelExport_xlsx2')->name('user_xlsx2');
    Route::get('user_csv2', 'UserController@excelExport_csv2')->name('user_csv2');

    Route::get('role_xlsx', 'RoleController@excelExport_xlsx')->name('role_xlsx');
    Route::get('role_csv', 'RoleController@excelExport_csv')->name('role_csv');

    Route::post('/vendor/showPreview', 'VendorController@showPreview')->name('showPreview');
    Route::post('/watchDocument', 'VendorController@watchDocument')->name('watchDocument');
  });