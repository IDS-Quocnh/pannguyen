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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::post('/cv-rank', 'FileextractorController@rankCV');
// Route::post('/quick-rank', 'CVRankingController@rankCV');
// Route::post('/cv-post', 'FileextractorController@cvUpload');
// Route::post('/cv-delete', 'FileextractorController@deleteCV');



// Route::get('/extract-pdf', 'FileextractorController@extractPdf');
// Route::get('/extract-word', 'FileextractorController@extractWord');


Route::group(['middleware' => 'localization'], function () {
    Route::get('/', 'HomeController@index')->name('/');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/ranking', 'CVRankingController@index')->name('ranking');
    Route::post('/ranking', 'CVRankingController@rankCV');
    Route::get('/ranking-detail', 'CVRankingController@PointDetail')->name('ranking-detail');


    Route::get('/quick-ranking', 'QuickRankingController@index')->name('quick-ranking');
    Route::post('/quick-ranking', 'QuickRankingController@rankCV');
    Route::get('/quick-ranking-detail', 'QuickRankingController@PointDetail')->name('quick-ranking-detail');

    Route::get('/cv-list', 'CVCollectionController@index')->name('cv-list');
    Route::post('/cv-delete', 'CVCollectionController@deleteCV');
    Route::post('/cv-clear', 'CVCollectionController@clearCV');

    Route::get('/cv-upload', 'CVCollectionController@cvFormRaw')->name('cv-upload');
    Route::post('/cv-upload', 'CVCollectionController@cvUploadRaw');

    Route::get('/keyword-parsing', 'KeywordParsingController@index')->name('keyword-parsing');
    Route::post('/keyword-parsing', 'KeywordParsingController@keyParsing');
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/upload_language', 'SettingController@uploadLanguagesIndex')->name('upload_language');
        Route::post('/upload_language', 'SettingController@uploadLanguages')->name('upload_language');
        Route::post('/download-zip', 'CVCollectionController@downloadZip')->name('download-zip');
        Route::post('/download-language', 'SettingController@downloadLanguage')->name('download-language');
    });
    Route::get('/my-profiles', 'MyProfilesController@edit')->name('my-profiles');
    Route::post('/my-profiles', 'MyProfilesController@edit')->name('my-profiles');
    Route::get('/user-management', 'UserManagementController@index')->name('user-management');
    Route::get('/user-management/edit', 'UserManagementController@edit')->name('user-management/edit');
    Route::post('/user-management/edit', 'UserManagementController@edit')->name('user-management/edit');
    Route::post('/user-management/delete', 'UserManagementController@delete')->name('user-management/delete');
    Route::get('/user-management/delete', 'UserManagementController@index')->name('user-management/delete');

});

    Route::get('change-language/{language}', 'SettingController@changeLanguage')->name('user.change-language');



