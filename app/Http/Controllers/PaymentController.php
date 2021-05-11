<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Stripe;
use App\Models\Order;
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
            'concertDate' => 'required|string|max:255',
            'concertTime' => 'required|string|max:255',
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
                'code' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
        	// Process payment
        	$res = $this->processPayment($request);
          
            return $res;  
        }
    }

    public function processPayment($paymentData) {
    	if($paymentData) {
            // Authenticate through Stripe
            $stripeSecret = \config('payment.stripeSecret');
            Stripe\Stripe::setApiKey($stripeSecret);

            try {
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
                                'concertDate' => $paymentData->concertDate,
                                'concertTime' => $paymentData->concertTime,
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
                            // Customer email
                            $this->sendToCustomer($notification);
                            // Admin email
                            $this->sendToAdmin($notification);
                            // Save order in DB
                            $this->storeOrder($paymentData, $charge->id);

                            return response()->json([
                                'charge_details' => $charge,
                                'code' => 'success',
                                'message' => 'Your payment has been completed successfully'
                            ]);
                        } 
                        // Charge was not successful
                        else {
                            return response()->json([
                                'code' => 'fail-charge',
                                'message' => 'There was a problem charging your card'
                            ]);
                        }
                    }
                    // Customer fails
                    else {
                        return response()->json([
                            'code' => 'fail-customer',
                            'message' => 'There was a problem and your card was not charged'
                        ]); 
                    }
                } 
                // Fail Token
                else {
                    return response()->json([
                        'code' => 'fail-token',
                        'message' => 'There was a problem and your card was not charged'
                    ]);
                }
            } catch(\Stripe\Exception\CardException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (\Stripe\Exception\RateLimitException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
            } catch (Exception $e) {
                $body = $e->getJsonBody();
                $err  = $body['error'];
                return response()->json($err);
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

    public function storeOrder($orderData, $stripe_id) {
    	if( ($orderData) && (isset($stripe_id)) ) {
    		$order = new Order;

    		$order->stripe_payment_id = $stripe_id;
    		$order->name_on_card = $orderData->nameOnCard;
    		$order->ticket_holder = $orderData->ticketHolder;
    		$order->email = $orderData->email;
    		$order->phone = $orderData->phone;
    		$order->city = $orderData->city;
    		$order->state = $orderData->state;
    		$order->zip = $orderData->zip;
    		$order->num_of_tickets = $orderData->ticketNumber;
    		$order->price_per_ticket = $orderData->concertPrice;
    		$order->total_sale = $orderData->total;
    		$order->concert_id = $orderData->concertId;
    		$order->concert_title = $orderData->concertTitle;
    		$order->concert_date = $orderData->concertDate;
    		$order->venue = $orderData->concertVenue;
    		$order->venue_city = $orderData->venueCity;
    		$order->venue_state = $orderData->venueState;

    		$order->save();

    		if($order) {
    			return 1;
    		} else {
    			return 0;
    		}
    	} else {
    		return 0;
    	}
    }

    public function boxOfficeOrder(Request $request) {

        // Validate 
        $validator = Validator::make($request->all(), [
            'ticketNumber' => 'required|integer|max:255',
            // App input
            'total' => 'required|integer',
            'concertId' => 'required|integer',
            'concertDate' => 'required|string|max:255',
            'concertTime' => 'required|string|max:255',
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
                'code' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
            $order = new Order;

            $order->stripe_payment_id = null;
            $order->name_on_card = $request->nameOnCard;
            $order->ticket_holder = $request->ticketHolder;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->num_of_tickets = $request->ticketNumber;
            $order->price_per_ticket = $request->concertPrice;
            $order->total_sale = $request->total;
            $order->concert_id = $request->concertId;
            $order->concert_title = $request->concertTitle;
            $order->concert_date = $request->concertDate;
            $order->venue = $request->concertVenue;
            $order->venue_city = $request->venueCity;
            $order->venue_state = $request->venueState;

            $order->save();

            if($order) {
                return response()->json([
                    'code' => 'success',
                    'message' => 'Your order was created.'
                ]);
            } else {
                return response()->json([
                    'code' => 'fail',
                    'message' => 'Something went wrong.'
                ]);
            }
        } 
    }

    public function getOrders($concert_id) {
        $orders = Order::where('concert_id', $concert_id)->get();

        return $orders;
    }

    public function getOrdersByConcert() {
        $concert_ids = Order::all(['concert_id']);
        $unique_ids = [];
        $orders = [];
        if($concert_ids) {
            $ids = [];
            foreach ($concert_ids as $concert_id) {
                $ids[] = $concert_id->concert_id;
            }

            $ids = array_unique($ids);
            
            foreach ($ids as $id) {
                $unique_ids[] = $id;
            }

            foreach ($unique_ids as $unique_id) {
                $ticket_orders = Order::where('concert_id', $unique_id)->get();

                if($ticket_orders) {
                   
                    $cid = $ticket_orders[0]->concert_id;
                    $title = $ticket_orders[0]->concert_title;
                    $concert_date = $ticket_orders[0]->concert_date;

                    $orders[] = [
                        'id' => $cid,
                        'title' => $title,
                        'date' => $concert_date,
                        'tickets_sold' => $this->getTixSold($ticket_orders),
                        'gross_sales' => $this->getGrossSales($ticket_orders)
                    ];
                }

            }
        } 
        return $orders;
    }

    public function getConcertOrders($id) {
        $ticket_orders = Order::where('concert_id', $id)->get();
        $data = [
            'tickets_sold' => $this->getTixSold($ticket_orders),
            'gross_sales' => $this->getGrossSales($ticket_orders),
            'orders' => $ticket_orders
        ];

        return $data;
    }

    public function getTixSold($ticket_orders) {
        $tixSold = 0;
        foreach ($ticket_orders as $ticket_order) {
            $tixSold = $ticket_order->num_of_tickets + $tixSold;
        }
        return $tixSold;
    }

    public function getGrossSales($ticket_orders) {
        $grossSales = 0;
        foreach ($ticket_orders as $ticket_order) {
            $grossSales = $ticket_order->total_sale + $grossSales;
        }
        return $grossSales;
    }
}
