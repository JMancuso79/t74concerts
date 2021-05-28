<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PagesController extends Controller
{
	public function getConcert($slug) {
		// Get Concert
		$client = new \GuzzleHttp\Client();
		$request = $client->get('https://api.artistwave.com/api/get/concert/'.$slug);
		$response = $request->getBody();

		$page_data = [
			'title' => 'Tower74 Concerts | Against The Grave & Inimical Drive at Tiki Bar - Costa Mesa, CA',
			'description' => 'Tower74 Concerts | Against The Grave & Inimical Drive at Tiki Bar - Costa Mesa, CA',
			'image' => 'https://tower74concerts.com/images/tower74-atg-id-full.jpg',
			'url' => 'https://tower74concerts.com/tickets/'.$slug
		];	
	
		session([
			'slug' => $slug,
			'page' =>'concert',
			'page_data' => $page_data
		]);

	    return Inertia::render('Concert', [
	    	'slug' => $slug,
	    	'concert' => json_decode($response)
	    ]);
    }
}
