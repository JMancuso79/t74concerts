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
}
