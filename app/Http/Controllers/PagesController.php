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

		$data = json_decode($response);
		$description = null;
		if($data) {
			$description = $data->title.' ';
			if($data->artists) {
				$i = 0;
				$len = count($data->artists);
				$description .= 'Featuring ';
				foreach ($data->artists as $artist) {
					if($i < $len - 1) {
						$description .= $artist->name.', ';
					}
				    if ($i == $len - 1) {
				        $description .= $artist->name.'. ';
				    }

				    $i++;
				}
			}
			if($data->event->venue) {
				$description .= 'At '.$data->event->venue->name;
			}
			if($data->event->venue->city) {
				$description .= ' '.$data->event->venue->city.'. ';
			}
			if($data->event->venue->state) {
				$description .= strtoupper($data->event->venue->state);
			}
			$image = null;
			if($data->filename) {
				$image = $data->filename;
			}
		}

		$page_data = [
			'title' => 'Tower74 | '.$data->title,
			'description' => $description,
			'image' => $image,
			'url' => 'https://tower74concerts.com/concert/'.$slug
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

    public function getPromo($slug) {

    	if($slug == 'josh-heinrichs') {
	 		$page_data = [
				'title' => 'Tower74 | Josh Heinrichs Southern California Dates October 2021',
				'description' => 'Tower74 has three dates with Josh Heinrichs in Southern California October 2021. Friday, October 8th is the kickoff with Eureka Sound, Rebel Shakedown, SGV Vibes, Ganda, Triple Thread and special apperance by Josh Heinrichs at DiPiazzas in Long Beach. Saturday, October 9th Josh Heinrichs headlines The Viper Room in West Hollywood. Sunday, October 10th Josh Heinrichs headlines Tiki Bar in Costa Mesa. Tickets are on sale now.',
				'image' => 'https://tower74concerts.com/images/tower74-full.jpg',
				'url' => 'https://tower74concerts.com/promo/'.$slug
			];
    	}

		session([
			'slug' => $slug,
			'page' =>'promo',
			'page_data' => $page_data
		]);

	    return Inertia::render('Promo', [
	    	'slug' => $slug,
	    	//'concert' => json_decode($response)
	    ]);   	
    }
}
