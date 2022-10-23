<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe;
use App\Models\Order;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function store(Request $request) {

        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'genres' => 'required|string|max:255',
            'dates' => 'required|string|max:255',
        ]); 
        if ($validator->fails()) {
        // If Validation Fails
            return response()->json([
                'message' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
        	// Process payment
        	$res = $this->storeBookingRequest($request);
          
            if($res === 1) {
                $this->sendToAdmin($request);
                $this->sendToCustomer($request);
                // success
                return response()->json([
                    'message' => 'success',
                ]);
            } else {
                // fail
                return response()->json([
                    'message' => 'fail',
                ]);
            }
        }
    }

    public function sendToAdmin($notification) {
    	if($notification) {
	        Mail::send('mail.admin-booking-confirmation', ['notification' => $notification], function ($message) {
	            $message->subject('Booking Request');
	            $message->from('noreply@tower74concerts.com', 'Tower74 Concerts');
	            $message->to('booking@tower74concerts.com');
	        });


            return response()->json([
                'message' => 'success',
            ]);
	        
    	} else {
            return response()->json([
                'message' => 'fail',
            ]); 
    	}
    }

    public function sendToCustomer($notification) {
        if($notification) {
            Mail::send('mail.customer-booking-confirmation', ['notification' => $notification], function ($message) use ($notification) {
                $message->subject('Tower74 Booking');
                $message->from('noreply@tower74concerts.com', 'Tower74 Concerts');
                $message->to($notification->email);
            });


            return response()->json([
                'message' => 'success',
            ]);
            
        } else {
            return response()->json([
                'message' => 'fail',
            ]); 
        }
    }

    public function storeBookingRequest($bookingData) {
    	if($bookingData) {
    		$booking = new BookingRequest;

            if($bookingData->type == 'venue') {
                $booking->gig_swap = 0;
            } else {
                $booking->gig_swap = $bookingData->gig_swap;
            }

    		$booking->email = $bookingData->email;
    		$booking->phone = $bookingData->phone;
    		$booking->name = $bookingData->name;
    		$booking->contact_name = $bookingData->contact_name;
    		$booking->address = $bookingData->address;
    		$booking->city = $bookingData->city;
    		$booking->state = $bookingData->state;
    		$booking->zip = $bookingData->zip;
    		$booking->type = $bookingData->type;
    		$booking->url = $bookingData->url;
    		$booking->genres = $bookingData->genres;
    		$booking->dates = $bookingData->dates;
    		$booking->gig_swap_home = $bookingData->gig_swap_home;
            $booking->gig_swap_away = $bookingData->gig_swap_away;
            $booking->message = $bookingData->message;

    		$booking->save();

    		if($booking) {
    			return 1;
    		} else {
    			return 0;
    		}
    	} else {
    		return 0;
    	}
    }
}
