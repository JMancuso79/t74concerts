<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function validateForm(Request $request) {

        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'nameOnCard' => 'required|string|max:255',
            'cardNumber' => 'required|string|max:255',
            'expMonth' => 'required|string|max:2',
            'expYear' => 'required|string|max:2',
            'cvv' => 'required|string|max:5',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'ticketNumber' => 'required|integer|max:255',
            'ticketHolder' => 'required|string|max:255',
            // App input
            'total' => 'required|integer',
            'concertId' => 'required|integer',
            'concertPrice' => 'required|integer',
            'concertTitle' => 'required|string|max:255',
            'concertVenue' => 'required|string|max:255',
            'venueAddress' => 'required|string|max:255',
            'venueCity' => 'required|string|max:255',
            'venueState' => 'required|string|max:255',
            'venueZip' => 'required|integer'
        ]); 
        if ($validator->fails()) {
        // If Validation Fails
            return response()->json([
                'message' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
        	// Process payment
        	$res = $this->processPayment($request);
        	// Successful charge
        	if($res['message'] === 'success') {
	            return response()->json($res);
        	}
        	// Failed charge
        	if($res['message'] === 'fail-charge') {
	            return response()->json($res);
        	}
        }
    }

    public function processPayment($paymentData) {
    	if($paymentData) {
            // Authenticate through Stripe
            $stripeSecret = \config('payment.stripeSecret');
            Stripe\Stripe::setApiKey($stripeSecret);
            // Create Token
            $token = Stripe\Token::create([
                'card' => [
                    'number' => $paymentData->cardNumber,
                    'exp_month' => $paymentData->expMonth,
                    'exp_year' => $paymentData->expYear,
                    'cvc' => $paymentData->cvv,
                    'address_city' => $paymentData->city,
                    'address_line1' => $paymentData->address, 
                    'address_state' => $paymentData->state, 
                    'address_zip' => $paymentData->zip, 
                ],
            ]);
            // Token is successful
            if($token['id']) {
	            // Create Customer
	            $stripe_customer = Stripe\Customer::create([
	                'source' => $token['id'],
	                'email' => $paymentData->email,
	                'phone' => $paymentData->phone,
	                'name' => $paymentData->nameOnCard,
	            ]);
	            // Customer successful
	            if($stripe_customer) {
			        // Create authorization charge
			        $charge = Stripe\Charge::create([
			        	'customer' => $stripe_customer->id,
			            'amount' => number_format($paymentData->total, 2, '', '.'),
			            'currency' => 'usd',
			            'description' => 'ID:'.$paymentData->concertId.' | '.$paymentData->concertTitle,
			        ]); 
			        // Charge was successful
			        if($charge) {
			        	// Customer email
			        	$notification = [
			        		// Customer
			        		'customerName' => $paymentData->nameOnCard,
			        		'customerEmail' => $paymentData->email,
			        		'customerPhone' => $paymentData->phone,
			        		'customerCity' => $paymentData->city,
			        		'customerState' => $paymentData->state,
			        		'customerZipCode' => $paymentData->zip,
			        		// Concert
			        		'concertId' => $paymentData->concertId,
			        		'concertTitle' => $paymentData->concertTitle,
			        		// Tickets
			        		'ticketPrice' => $paymentData->concertPrice,
			        		'ticketHolder' => $paymentData->ticketHolder,
			        		'ticketNumber' => $paymentData->ticketNumber,
			        		'ticketTotal' => $paymentData->total,
			        		// Venue
			        		'venueName' => $paymentData->concertVenue,
			        		'venueStreetAddress' => $paymentData->venueAddress,
			        		'venueCity' => $paymentData->venueCity,
			        		'venueState' => $paymentData->venueState,
			        		'venueZipCode' => $paymentData->venueZip,
			        	];

			        	$this->sendToCustomer($notification);
			        	// Admin email
			        	$this->sendToAdmin($notification);
						$res = [
		                    'message' => 'success',
		                    'charge_details' => $charge
		                ];
			        } 
			        // Charge was not successful
			        else {
		                $res = [
		                    'message' => 'fail-charge',
		                ];
			        }
			        return $res;
			    }
			    // Customer fails
			    else {
	                return response()->json([
	                    'message' => 'fail-customer',
	                ]);	
			    }
            } 
            // Fail Token
            else {
                return response()->json([
                    'message' => 'fail-token',
                ]);
            }
		}
    }

    public function sendToCustomer($notification) {

    	if($notification) {
	        Mail::send('mail.customer-confirmation', ['notification' => $notification], function ($message) use ($notification) {
	            $message->subject('Confirmation of Ticket Purchase');
	            $message->from('noreply@tower74concerts.com', 'Tower74 Concerts');
	            $message->to($notification['customerEmail']);
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
    	} else {
            return response()->json([
                'message' => 'fail',
            ]); 
    	}

    }
    public function sendToAdmin($notification) {
    	if($notification) {
	        Mail::send('mail.admin-confirmation', ['notification' => $notification], function ($message) use ($notification) {
	            $message->subject('Ticket Purchase | ID: '.$notification['concertId'].' '.$notification['concertTitle']);
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
    	} else {
            return response()->json([
                'message' => 'fail',
            ]); 
    	}
    }
}
