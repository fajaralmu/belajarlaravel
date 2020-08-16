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
Route::group(['middleware' => 'web'], function () {
    
    Route::get('/', 'MyApp\MainController@index');
    Route::auth();


    Route::prefix('account')->group(function () {
  
         Route::get('login', 'MyApp\AccountController@login_page')->name('login');
    });




    Route:: group(['prefix' => 'public' /*, 'middleware'=>'auth' */], function () {
     
        Route::get('about', 'MyApp\PublicPageController@about_page');
    });
});

//Route::group(['middleware' => ['web,','auth'], 'prefix' => 'admin'], function () {
       
    Route::get('home', 'MyApp\AdminController@home_page')->name('admin_home');
//});