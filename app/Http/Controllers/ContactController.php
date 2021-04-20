<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendMessage(Request $request) {
        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
        	'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]); 
        if ($validator->fails()) {
        // If Validation Fails
            return response()->json([
                'message' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {

        	$data = [
        		'name' =>  $request->name,
        		'email' => $request->email,
        		'phone' =>  $request->phone,
        		'message' =>  $request->message
        	];

	        Mail::send('mail.contact', ['data' => $request], function ($message) {
	            $message->subject('Website Contact');
	            $message->from('noreply@tower74concerts.com', 'Tower74 Concerts');
	            $message->to('booking@tower74concerts.com');
	        });

	        if( count(Mail::failures()) > 0 ) {
	            return response()->json([
	                'message' => 'fail',
	            ]);            
	        } else {
	            return response()->json([
	                'message' => 'success',
	            ]);
	        }
        }
    }

}
