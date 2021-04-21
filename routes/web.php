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
        'canRegister' => Route::has('register'),
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
		'slug' => null,
		'page' =>'contact',
		'page_data' => $page_data
	]);
    return Inertia::render('Contact');
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
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
