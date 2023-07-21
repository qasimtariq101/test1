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

//Admin routes
Route::group([
    'prefix'     => 'admin',
    'middleware' => ['eco.web'],
    'namespace'  => 'Admin',
], function () {

    Route::get('login', 'AdminController@showLogin')->name('admin.login');

});

Route::group([
    'prefix'     => 'admin',
    'middleware' => ['eco.admin'],
    'namespace'  => 'Admin',
], function () {

    Route::get('clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return redirect()->back()->withSuccess(__('Cache cleaned successfully'));
    });

    Route::get('dashboard', 'AdminController@index')->name('dashboard');

//Slider
    Route::get('slider', 'SliderController@index')->name('slider');
    Route::get('slider/create', 'SliderController@create')->name('slider');
    Route::post('slider/create', 'SliderController@store');
    Route::get('slider/{id}/edit', 'SliderController@edit')->name('slider');
    Route::post('slider/{id}/edit', 'SliderController@update');
    Route::get('slider/get-slider', 'SliderController@get')->name('slider.get');
    Route::get('slider/{id}/delete', 'SliderController@destroy')->name('slider.delete');

//Pages
    Route::get('pages', 'PageController@index')->name('pages');
    Route::get('pages/create', 'PageController@create')->name('pages');
    Route::post('pages/create', 'PageController@store');
    Route::get('pages/{id}/edit', 'PageController@edit')->name('pages');
    Route::post('pages/{id}/edit', 'PageController@update');
    Route::get('pages/get-pages', 'PageController@get')->name('pages.get');
    Route::get('pages/{id}/delete', 'PageController@destroy')->name('pages.delete');

//Users
    Route::get('users', 'UserController@index')->name('users');
    Route::get('users/get', 'UserController@get')->name('users.get');
    Route::get('users/{id}/delete', 'UserController@destroy')->name('users.delete');
    Route::get('users/{id}/edit', 'UserController@edit');
    Route::post('users/{id}/edit', 'UserController@update');
    Route::get('users/create', 'UserController@create');
    Route::post('users/create', 'UserController@store');

//Categories
    Route::get('categories', 'CategoryController@index')->name('categories');
    Route::get('categories/get', 'CategoryController@get')->name('categories.get');
    Route::get('categories/{id}/delete', 'CategoryController@destroy')->name('categories.delete');
    Route::get('categories/{id}/edit', 'CategoryController@edit');
    Route::post('categories/{id}/edit', 'CategoryController@update');
    Route::get('categories/create', 'CategoryController@create');
    Route::post('categories/create', 'CategoryController@store');

//Site languages
    Route::get('site-languages', 'LanguageController@index')->name('site_languages');
    Route::get('site-languages/get', 'LanguageController@get')->name('site_languages.get');
    Route::get('site-languages/{id}/delete', 'LanguageController@destroy')->name('site_languages.delete');
    Route::get('site-languages/{id}/edit', 'LanguageController@edit');
    Route::post('site-languages/{id}/edit', 'LanguageController@update');
    Route::get('site-languages/create', 'LanguageController@create');
    Route::post('site-languages/create', 'LanguageController@store');
    Route::get('site-languages/{id}/translations', 'LanguageController@translationsEdit');
    Route::post('site-languages/{id}/translations', 'LanguageController@translationsUpdate');

//Books
    Route::get('books', 'BookController@index')->name('books');
    Route::get('books/get', 'BookController@get')->name('books.get');
    Route::get('books/{id}/delete', 'BookController@destroy')->name('books.delete');
    Route::get('books/{id}/edit', 'BookController@edit')->name('books.edit');
    Route::post('books/{id}/edit', 'BookController@update');
    Route::get('books/create', 'BookController@create')->name('books.create');
    Route::post('books/create', 'BookController@store');    
    Route::get('books/bulk-create', 'BookController@createBulk')->name('books.create_bulk');
    Route::post('books/bulk-create', 'BookController@storeBulk');
    Route::post('books/delete-selected', 'BookController@deleteSelected')->name('books.delete_selected');

//Reported Books
    Route::get('reported-books', 'ReportController@index')->name('reports');
    Route::get('reported-books/get', 'ReportController@get')->name('reports.get');
    Route::get('reported-books/{id}/delete', 'ReportController@destroy')->name('reports.delete');
    Route::post('reported-books/delete-selected', 'ReportController@deleteSelected');

//Settings
    Route::get('settings', 'SettingController@edit')->name('settings');
    Route::post('settings', 'SettingController@update');
});

//Auth routes
Route::group([
    'middleware' => ['eco.auth'],
], function () {

    Route::post('books/add_to_favorite', 'FavoriteController@store')->name('books.add_to_favorite');
    Route::get('books/{slug}/edit', 'BookController@edit')->name('book.edit');
    Route::post('books/{slug}/edit', 'BookController@update');
    Route::get('books/{slug}/delete', 'BookController@destroy')->name('book.delete');

    Route::get('my-books', 'BookController@myBooks')->name('my_books');
    Route::get('profile', 'UserController@edit')->name('profile');
    Route::post('profile', 'UserController@update');
    Route::post('profile/delete', 'UserController@destroy')->name('profile.delete');

    Route::post('rate-book', 'BookController@rateNow')->name('books.rate_now');

    Route::post('report-issue', 'BookController@report')->name('book.report');

    Route::get('favorites', 'FavoriteController@index')->name('favorites');

});


//Non Auth Routes
Route::group([
    'middleware' => ['eco.web'],
], function () {

    Auth::routes(['verify' => true]);

    Route::get('auth/{provider}', 'Auth\RegisterController@redirectToSocialProvider')->name('social.login');
    Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleSocialProviderCallback')->name('social.callback');

    Route::get('home', 'HomeController@index')->name('home');


    Route::get('publishers', 'UserController@index')->name('publishers.index');

    Route::get('upload', 'BookController@create')->name('upload');
    Route::post('upload', 'BookController@store');

    Route::post('login', 'Auth\LoginController@authenticate')->name('user.login');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('search', 'BookController@search')->name('search');

    Route::get('contact', 'PageController@contact')->name('contact');
    Route::post('contact', 'PageController@contactPost');
    
    Route::get('categories', 'PageController@mycategories')->name('mycategories');
	Route::get('textbooks', 'PageController@textbooks')->name('textbooks');
	Route::get('punjabtextbooks', 'PageController@punjabtextbooks')->name('punjabtextbooks');
	Route::get('sindhtextbooks', 'PageController@sindhtextbooks')->name('sindhtextbooks');
	Route::get('balochistantextbooks', 'PageController@balochistantextbooks')->name('balochistantextbooks');

    Route::get('pages/{slug}', 'PageController@show')->name('page.show');

    Route::get('download/{slug}', 'BookController@download')->name('download');
    Route::get('embed/{slug}', 'BookController@embed')->name('embed');
    Route::get('print/{slug}', 'BookController@print')->name('print');

    Route::post('get-book', 'BookController@getBook')->name('book.get');

    Route::get('epub/{slug}', 'BookController@epub')->name('book.epub');

    Route::get('audio/{slug}', 'BookController@audio')->name('book.audio');

    Route::get('pdf/{slug}', 'BookController@pdf')->name('book.pdf');

    Route::get('u/{name}', 'UserController@profile')->name('user.profile');
    Route::post('u/{name}/contact', 'UserController@contact')->name('user.contact');

    Route::get('books', 'BookController@index')->name('books.index');
    Route::get('categories/{category}', 'BookController@index')->name('books.categories.index');

    Route::get('sitemap-main.xml','PageController@sitemapMain')->name('sitemap.main');
    Route::get('sitemap.xml','PageController@sitemaps')->name('sitemaps');
    Route::get('sitemap-{date}.xml','PageController@sitemap')->name('sitemap.show');


    Route::get('{slug}', 'BookController@show')->name('book.show');
	
// Menu routes
Route::get('admin/menus/get', 'Admin\MenuController@get')->name('menus.get');
Route::get('/admin/menus', 'Admin\MenuController@index')->name('menus.index');
Route::get('/admin/menus/create', 'Admin\MenuController@create')->name('menus.create');
Route::post('/admin/menus', 'Admin\MenuController@store')->name('menus.store');
Route::get('/admin/menus/{menu}', 'Admin\MenuController@show')->name('menus.show');
Route::get('/admin/menus/{menu}/edit', 'Admin\MenuController@edit')->name('menus.edit');
Route::put('/admin/menus/{menu}', 'Admin\MenuController@update')->name('menus.update');
Route::delete('/admin/menus/{menu}', 'Admin\MenuController@destroy')->name('menus.destroy');

// Routes for managing menu items
Route::get('/admin/menus/{menu}/items', 'Admin\MenuController@items')->name('menus.items');
Route::get('/admin/menus/{menu}/items/create', 'Admin\MenuController@createItem')->name('menus.create-item');
Route::post('/admin/menus/{menu}/items', 'Admin\MenuController@storeItem')->name('menus.store-item');
Route::get('/admin/menus/{menu}/items/{item}/edit', 'Admin\MenuController@editItem')->name('menus.items.edit');
Route::put('/admin/menus/{menu}/items/{item}', 'Admin\MenuController@updateItem')->name('menus.items.update');
Route::delete('/admin/menus/{menu}/items/{item}', 'Admin\MenuController@destroyItem')->name('menus.items.destroy');
Route::get('/admin/menus/{menu}/items/get', 'Admin\MenuController@getItems')->name('menus.items.get');


});
