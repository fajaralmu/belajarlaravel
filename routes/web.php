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

use App\Http\Middleware\MyAppMiddleware;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web', MyAppMiddleware::class]], function () {
    
    Route::get('/', 'MyApp\MainController@index');
    Route::auth();


    Route::prefix('account')->group(function () {
  
         Route::get('login', 'MyApp\AccountController@login_page')->name('login');
         Route::get('logout', 'MyApp\AccountController@logout')->name('logout');
    });
 
    Route:: group(['prefix' => 'public' /*, 'middleware'=>'auth' */], function () {
     
        Route::get('about', 'MyApp\PublicPageController@about_page');
    });

    Route:: group(['prefix' => 'webapp' /*, 'middleware'=>'auth' */], function () {
     
        Route::get('page/{code}', 'MyApp\GeneralWebAppController@common_page');
    });
});

//ADMIN 
Route::group(['middleware' => [ 'auth', MyAppMiddleware::class], 'prefix' => 'admin'], function () {
       
    Route::get('home', 'MyApp\AdminController@home_page')->name('admin_home');
    Route::get('sidemenudisplayorder', 'MyApp\AdminController@menu_order')->name('menu_rder');
    Route::get('mealschedule', 'MyApp\AdminController@meal_scheduling')->name('meal_scheduling');
});

//MANAGEMENT
Route::group(['middleware' => [ 'auth', MyAppMiddleware::class], 'prefix' => 'management'], function () {
       
    Route::get('common/{code}', 'MyApp\ManagementController@management_page')->name('management_common');
});