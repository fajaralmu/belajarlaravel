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

use Illuminate\Support\Facades\Route;

Route::get('/', 'MyApp\MainController@index');
Route::prefix('account')->group(function () {
   
    Route::get('login', 'MyApp\AccountController@login_page');
});

Route::prefix('public')->group(function () {
   
    Route::get('about', 'MyApp\PublicPageController@about_page');
});

