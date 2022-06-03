<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::get('/concert/old-blood-zero-theorem-against-the-grave-fate-destroyed-scarlet-siren-683953680', function () {
	$page_data = [
		'title' => 'Old Blood, Against The Grave, Fate Destroyed, Constraints Of Light, & Scarlet Siren',
		'description' => 'Old Blood, Against The Grave, Fate Destroyed, Constraints Of Light, & Scarlet Siren at The Viper. West Hollywood, CA',
		'image' => 'https://artistwavesoftware.s3-us-west-1.amazonaws.com/posts/6205cab9d0f6c.jpeg',
		'url' => 'https://tower74concerts.com/concert/old-blood-against-the-grave-fate-destroyed-constraints-of-light-scarlet-siren-459074972'
	];
	session([
		'slug' => null,
		'page' =>'concert',
		'page_data' => $page_data
	]);
    return Inertia::render('Concerts', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function () {
	$page_data = [
		'title' => 'Tower74 Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com'
	];
	session([
		'slug' => null,
		'page' =>'calendar',
		'page_data' => $page_data
	]);
    return Inertia::render('Concerts', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/register', function () {
	$page_data = [
		'title' => 'Tower74 Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com'
	];
	session([
		'slug' => null,
		'page' =>'calendar',
		'page_data' => $page_data
	]);
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/contact', function () {
	$page_data = [
		'title' => 'Tower74 Concerts | Contact',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com/contact'
	];
	session([
		'slug' => 'contact',
		'page' => 'contact',
		'page_data' => $page_data
	]);
    return Inertia::render('Contact');
});

Route::get('/product/{id}', function ($id) {
	$page_data = [
		'title' => 'Tower74 | Shop',
		'description' => '',
		'image' => '',
		'url' => 'https://tower74concerts.com/product/'.$id
	];
	session([
		'slug' => 'product',
		'page' => 'product',
		'page_data' => $page_data
	]);
    return Inertia::render('Product', [
    	'id' => $id
    ]);
});

Route::get('/cart', function () {
	$page_data = [
		'title' => 'Tower74 | Shop',
		'description' => '',
		'image' => '',
		'url' => 'https://tower74concerts.com/cart'
	];
	session([
		'slug' => 'cart',
		'page' => 'cart',
		'page_data' => $page_data
	]);

	$products = [];

	if(session('products')) {
		$products = session('products');
	}

    return Inertia::render('Cart', [
    	'cartItems' => $products,
    ]);
});

Route::get('/check-out', function () {
	$page_data = [
		'title' => 'Tower74 | Shop',
		'description' => '',
		'image' => '',
		'url' => 'https://tower74concerts.com/check-out'
	];
	session([
		'slug' => 'check-out',
		'page' => 'check-out',
		'page_data' => $page_data
	]);

	$products = [];

	if(session('products')) {
		$products = session('products');
	}
	
    return Inertia::render('CheckOut', [
    	'cartItems' => $products,
    ]);
});

Route::get('/manage/product/{id}', function ($id) {
	$page_data = [
		'title' => 'Tower74 | Shop',
		'description' => '',
		'image' => '',
		'url' => 'https://tower74concerts.com/product/'.$id
	];
	session([
		'slug' => 'manage_product',
		'page' => 'manage-product',
		'page_data' => $page_data
	]);
    return Inertia::render('ManageProduct', [
    	'id' => $id
    ]);
});

Route::get('/about', function () {
	$page_data = [
		'title' => 'Tower74 Concerts | About',
		'description' => 'Tower 74 LLC was formed in January of 2021 by John Mancuso. John is a web and app developer and long time concert promoter. Originally from St. Louis, MO, he played in bands in the STL metal scene in high school. Shortly after high school, in 2000, he moved to Huntington Beach, CA. While looking for a new band, he found intern work at Americoma Records, owned by Nikki Sixx, in West Hollywood. While stuffing envelopes to send out to Americomas street team, he began booking local bands at venues up and down the Sunset Strip. He booked and managed local bands in his early 20s while working for indie record labels Americoma and Rotten Records.',
		'image' => 'https://tower74concerts.com/images/joshua-tree.jpg',
		'url' => 'https://tower74concerts.com/about'
	];
	session([
		'slug' => 'about',
		'page' => 'about',
		'page_data' => $page_data
	]);
    return Inertia::render('About');
});

Route::get('/booking', function () {
	$page_data = [
		'title' => 'Tower74 Concerts | Booking',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com/booking'
	];
	session([
		'slug' => 'booking',
		'page' => 'booking',
		'page_data' => $page_data
	]);
    return Inertia::render('Booking');
});

Route::get('/concerts', function () {
	$page_data = [
		'title' => 'Tower74 Concerts | Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com/concerts'
	];
	session([
		'slug' => 'concerts',
		'page' => 'concerts',
		'page_data' => $page_data
	]);
    return Inertia::render('Concerts');
});

Route::get('/promo/{slug}', '\App\Http\Controllers\PagesController@getPromo');
Route::get('/concert/{slug}', '\App\Http\Controllers\PagesController@getConcert');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/manage/products', function () {
    return Inertia::render('ManageProducts');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/manage/concert/{id}', function ($id) {
	$page_data = [
		'title' => 'Tower74 Concerts | Manage Concert',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com/'
	];
	session([
		'slug' => 'manage-concert',
		'page' => 'manage-concert',
		'page_data' => $page_data
	]);
    return Inertia::render('ManageConcert', [
    	'id' => $id
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/box-office/{id}', function ($id) {
	$page_data = [
		'title' => 'Tower74 Concerts | Box Office',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
		'url' => 'https://tower74concerts.com/'
	];
	session([
		'slug' => 'box-office',
		'page' => 'box-office',
		'page_data' => $page_data
	]);
    return Inertia::render('BoxOffice', [
    	'id' => $id
    ]);
});

Route::middleware('auth:sanctum')->get('/web-api/orders/concert/{concert_id}', 'App\Http\Controllers\PaymentController@getOrders');
Route::middleware('auth:sanctum')->get('/web-api/orders-by-concert', 'App\Http\Controllers\PaymentController@getOrdersByConcert');
Route::middleware('auth:sanctum')->post('/web-api/box-office-order', 'App\Http\Controllers\PaymentController@boxOfficeOrder');
Route::middleware('auth:sanctum')->get('/web-api/get-concert-orders/{id}', 'App\Http\Controllers\PaymentController@getConcertOrders');
Route::middleware('auth:sanctum')->post('/web-api/post/promo-code', 'App\Http\Controllers\PaymentController@storePromoCode');
Route::middleware('auth:sanctum')->get('/web-api/get-customer-artists/artist/{artist_id}/concert/{concert_id}', 'App\Http\Controllers\PaymentController@getArtistTixSold');
/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->post('/web-api/v1/product', 'App\Http\Controllers\ProductsController@store');
Route::middleware('auth:sanctum')->post('/web-api/v1/update-product/{id}', 'App\Http\Controllers\ProductsController@update');
Route::middleware('auth:sanctum')->get('/web-api/v1/delete-product/{id}', 'App\Http\Controllers\ProductsController@destroy');
Route::get('/web-api/v1/product/{id}', 'App\Http\Controllers\ProductsController@show');
Route::middleware('auth:sanctum')->get('/web-api/v1/manage-product-list', 'App\Http\Controllers\ProductsController@manageProductsList');
Route::post('/web-api/v1/cart', 'App\Http\Controllers\CartController@addProductToCart');
Route::post('/web-api/v1/remove-item-from-cart', 'App\Http\Controllers\CartController@destroy');
Route::post('/web-api/v1/update-cart', 'App\Http\Controllers\CartController@update');

/*
|--------------------------------------------------------------------------
| Image Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->post('/web-api/v1/image', 'App\Http\Controllers\ImagesController@store');
