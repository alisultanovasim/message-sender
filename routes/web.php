<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/home', 'MessagesController@statics')->name('home')->middleware('auth');
Route::post('/admin/login', 'LoginController@loginPost');
Route::get('/admin/logout', 'LoginController@logout');

Route::group(['prefix' => 'admin','middleware' => 'auth:web'],function () {

    Route::get('/home', 'MessagesController@statics');
    Route::get('/company_messages', 'MessagesController@messages');
    Route::get('/company_add_messages', 'MessagesController@addmessage');
    Route::get('/template', 'MessagesController@allTemplates');
    Route::post('/add-template', 'MessagesController@addNewTemplate');
    Route::post('/delete-template/{id}', 'MessagesController@deleteTemplate')->name('delete-template');
    Route::post('/company_add_message_post', 'MessagesController@addmessagepost');
    Route::post('/send-collection-message', 'MessagesController@sendCollectionMessage');
    Route::get('/checkmessages', 'MessagesController@checkmessages');
    Route::get('/message_status/{id}', 'MessagesController@messagestatus');
    Route::get('/date-filter', 'MessagesController@dateFilter');


    Route::get('/chatbot', 'CommandsController@chatbot');
    Route::get('/chatbotlist', 'CommandsController@chatbotlist');
    Route::post('/addcommands', 'CommandsController@addcommands');

    Route::get('/company/edit', 'CompanyController@editCompany');
    Route::post('/company/edit', 'CompanyController@editCompanyPost');
    Route::post('/checknumber', 'CompanyController@checkNumber');
    Route::get('/company/whatsapp/profile', 'CompanyController@checkNumberProfile');

});
