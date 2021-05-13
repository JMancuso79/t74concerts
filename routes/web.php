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

Route::get('/', function () {
	$page_data = [
		'title' => 'Tower74 Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
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

Route::get('/register', function () {
	$page_data = [
		'title' => 'Tower74 Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
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
		'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
		'url' => 'https://tower74concerts.com/contact'
	];
	session([
		'slug' => 'contact',
		'page' => 'contact',
		'page_data' => $page_data
	]);
    return Inertia::render('Contact');
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
		'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
		'url' => 'https://tower74concerts.com/booking'
	];
	session([
		'slug' => 'booking',
		'page' => 'booking',
		'page_data' => $page_data
	]);
    return Inertia::render('Booking');
});

Route::get('/tickets/{slug}', function ($slug) {
	if($slug == 'kyle-smith-the-b-foundation') {
		$page_data = [
			'title' => 'Tower74 Concerts | Kyle Smith w/The B Foundation at Tiki Bar Costa Mesa',
			'description' => 'Tower74 Presents Kyle Smith, The B Foundation, Rebel Shakedown and Die Criminal at Tiki Bar in Costa Mesa, CA. Capacity of this concert will be determined by Orange County COVID guidelines on the day of.',
			'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
			'url' => 'https://tower74concerts.com/tickets/'.$slug
		];
	}
	if($slug == 'sammy-ramone') {
		$page_data = [
			'title' => 'Tower74 Concerts | Sammy Ramone w/ Velvateen, Doahs Daydream and Noble Savage at Tiki Bar Costa Mesa',
			'description' => 'Tower74 Presents Sammy Ramone w/ Velvateen, Doahs Day Dream and Noble Savage at Tiki Bar in Costa Mesa, CA. Capacity of this concert will be determined by Orange County COVID guidelines on the day of.',
			'image' => 'https://tower74concerts.com/images/tower-74-sammy-ramone-full.jpg',
			'url' => 'https://tower74concerts.com/tickets/'.$slug
		];	
	}
	if($slug == 'inimical-drive-red-flag-2021-07-17') {
		$page_data = [
			'title' => 'Tower74 Concerts | Inimical Drive at Red Flag - St. Louis, MO',
			'description' => 'Tower74 Concerts | Inimical Drive at Red Flag - St. Louis, MO.',
			'image' => 'https://tower74concerts.com/images/id-full.jpg',
			'url' => 'https://tower74concerts.com/tickets/'.$slug
		];	
	}
	session([
		'slug' => $slug,
		'page' =>'tickets',
		'page_data' => $page_data
	]);
    return Inertia::render('Tickets', [
    	'slug' => $slug
    ]);
});
Route::get('/venue/{slug}', function ($slug) {
	$page_data = [
		'title' => 'Tower74 Concerts',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/tower74-ks-bf-full.jpg',
		'url' => 'https://tower74concerts.com/venue/'.$slug
	];
	session([
		'slug' => $slug,
		'page' =>'venue',
		'page_data' => $page_data
	]);
    return Inertia::render('Venue', [
    	'slug' => $slug
    ]);
});

Route::get('/sunset-strip-showcase', function () {
	$page_data = [
		'title' => 'Tower74 Concerts | Sunset Strip Showcase',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/sunset-strip-showcase.jpg',
		'url' => 'https://tower74concerts.com/sunset-strip-showcase'
	];
	session([
		'slug' => 'sunset-strip-showcase',
		'page' => 'sunset-strip-showcase',
		'page_data' => $page_data
	]);
    return Inertia::render('SunsetStripShowcase');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/manage/concert/{id}', function ($id) {
	$page_data = [
		'title' => 'Tower74 Concerts | Manage Concert',
		'description' => 'Tower74 Concerts is based in Newport Beach, CA.',
		'image' => 'https://tower74concerts.com/images/sunset-strip-showcase.jpg',
		'url' => 'https://tower74concerts.com/sunset-strip-showcase'
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
		'image' => 'https://tower74concerts.com/images/sunset-strip-showcase.jpg',
		'url' => 'https://tower74concerts.com/sunset-strip-showcase'
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

