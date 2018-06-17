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
//URL::forceRootUrl('http://devbox-cfaf.ketsuka-hosting.fr/');

Auth::routes();

/* -- ESPACE PUBLIC -- */

// GENERAL
Route::get('/', 'GlobalController@index')->name('index');
Route::get('/plan', 'GlobalController@map')->name('map');
Route::get('/mentions', 'GlobalController@mentions')->name('mentions');
Route::get('/contact', 'ContactController@getForm');

// ARTICLES
Route::get('/articles', 'ArticleController@show')->name('articles');
Route::get('/article/{slug}', 'ArticleController@showOne')->name('article');

// CATEGORIES
Route::get('/categorie/{slug}', 'CategoryController@show')->name('category');
// TAGS
Route::get('/mot-cle/{slug}', 'TagController@show')->name('tag');


/* -- ESPACE ADMINISTRATION -- */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

	// DASHBOARD
	Route::get('/tableau', 'AdminController@dashboard')->name('dashboard');

	// USERS
	Route::get('/utilisateurs', 'UserController@list')->name('users');
	Route::get('/utilisateur/voir/{id}', 'UserController@edit')->name('user.edit');
	Route::get('/utilisateur/ajouter', 'UserController@add')->name('user.add');
	Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
	Route::post('/user/store', 'UserController@store')->name('user.store');

	// ROLES
	Route::get('/roles', 'RoleController@list')->name('roles');
	Route::get('/role/voir/{id}', 'RoleController@edit')->name('role.edit');
	Route::get('/role/ajouter', 'RoleController@add')->name('role.add');
	Route::post('/role/update/{id}', 'RoleController@update')->name('role.update');
	Route::post('/role/store', 'RoleController@store')->name('role.store');

	// ARTICLES
	Route::get('/articles', 'ArticleController@list')->name('articles');
	Route::get('/article/voir/{id}', 'ArticleController@edit')->name('article.edit');
	Route::get('/article/ajouter', 'ArticleController@add')->name('article.add');
	Route::post('/article/update/{id}', 'ArticleController@update')->name('article.update');
	Route::post('/article/store', 'ArticleController@store')->name('article.store');

	// CATEGORIES
	Route::get('/categories', 'CategoryController@list')->name('categories');
	Route::get('/categorie/voir/{id}', 'CategoryController@edit')->name('category.edit');
	Route::get('/categorie/ajouter', 'CategoryController@add')->name('category.add');
	Route::post('/category/update/{id}', 'CategoryController@update')->name('category.update');
	Route::post('/category/store', 'CategoryController@store')->name('category.store');

	// TAGS
	Route::get('/mots-cles', 'TagController@list')->name('tags');
	Route::get('/mot-cle/voir/{id}', 'TagController@edit')->name('tag.edit');
	Route::get('/mot-cle/ajouter', 'TagController@add')->name('tag.add');
	Route::post('/tag/update/{id}', 'TagController@update')->name('tag.update');
	Route::post('/tag/store', 'TagController@store')->name('tag.store');

	/* --- AJAX --- */
	Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
		// USERS
		Route::post('user/delete', 'UserController@delete')->name('user.delete');
		Route::post('user/restore', 'UserController@restore')->name('user.restore');

		// ROLES
		Route::post('role/delete', 'RoleController@delete')->name('role.delete');
		Route::post('role/restore', 'RoleController@restore')->name('role.restore');

		// ARTICLES
		Route::get('article/latest', 'ArticleController@latest')->name('article.latest');
		Route::post('article/delete', 'ArticleController@delete')->name('article.delete');
		Route::post('article/restore', 'ArticleController@restore')->name('article.restore');
		Route::post('article/unpublish', 'ArticleController@unpublish')->name('article.unpublish'); //drafted
		Route::post('article/publish', 'ArticleController@publish')->name('article.publish'); //undrafted

		// CATEGORIES
		Route::post('category/delete', 'CategoryController@delete')->name('category.delete');
		Route::post('category/restore', 'CategoryController@restore')->name('category.restore');

		// TAGS
		Route::post('tag/delete', 'TagController@delete')->name('tag.delete');
		Route::post('tag/restore', 'TagController@restore')->name('tag.restore');


	});

});