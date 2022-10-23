<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Stripe;
use App\Models\CustomerArtist;
use App\Models\CustomerDetail;
use App\Models\ProcessedOrder;
use App\Models\OrderedItem;
use App\Models\Order;
use App\Models\PromoCode;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PaymentController extends Controller
{
    public function validateForm(Request $request) {

        // Validate 
        $validator = Validator::make($request->all(), [
        	// User input
            'email' => 'required|email|max:255',
            'nameOnCard' => 'required|string|max:255',
            'cardNumber' => 'required|string|max:255',
            'expMonth' => 'required|string|max:2',
            'expYear' => 'required|string|max:2',
            'cvv' => 'required|string|max:5',
            'zip' => 'required|string|max:255',
            'ticketNumber' => 'required|integer|max:255',
            'ticketHolder' => 'required|string|max:255',
            // App input
            'total' => 'required|integer',
            'concertId' => 'required|integer',
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
                        'address_zip' => $paymentData->zip, 
                    ],
                ]);
                // Token is successful
                if($token['id']) {
                    // Create Customer
                    $stripe_customer = Stripe\Customer::create([
                        'source' => $token['id'],
                        'email' => $paymentData->email,
                        'name' => $paymentData->nameOnCard,
                    ]);
                    // Customer successful
                    if($stripe_customer) {
                        // Create authorization charge
                        $charge = Stripe\Charge::create([
                            'customer' => $stripe_customer->id,
                            'amount' => number_format($paymentData->total, 2, '', '.'),
                            'currency' => 'usd',
                            'description' => 'ID:'.$paymentData->concertId,
                        ]); 
                        // Charge was successful
                        if($charge) {
                            // Customer email   
                            $concertDate = substr($paymentData->concert['event']['date_time'], 0, 10);
                            $notification = [
                                // Customer
                                'customerName' => $paymentData->nameOnCard,
                                'customerEmail' => $paymentData->email,
                                'customerZipCode' => $paymentData->zip,
                                // Concert
                                'concertId' => $paymentData->concertId,
                                'concertTitle' => $paymentData->concert['title'],
                                'concertDate' =>  $concertDate,
                                'concertBody' => $paymentData->concert['body'],
                                // Tickets
                                'ticketPrice' => $paymentData->concertPrice,
                                'ticketHolder' => $paymentData->ticketHolder,
                                'ticketNumber' => $paymentData->ticketNumber,
                                'ticketTotal' => $paymentData->total,
                                // Venue
                                'venueName' =>  $paymentData->concert['event']['venue']['name'],
                                'venueStreetAddress' =>  $paymentData->concert['event']['venue']['street_address'],
                                'venueCity' =>  $paymentData->concert['event']['venue']['city'],
                                'venueState' =>  $paymentData->concert['event']['venue']['state'],
                                'venueZipCode' =>  $paymentData->concert['event']['venue']['zip_code'],
                            ];
                            // Save order in DB
                            $this->storeOrder($paymentData, $charge->id);
                            // Customer email
                            $this->sendToCustomer($notification);
                            // Admin email
                            $this->sendToAdmin($notification);
                            
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


	        return response()->json([
                'message' => 'success',
	        ]);
	      
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

	 
            return response()->json([
                'message' => 'success',
            ]);
	        
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
    		$order->phone = null;
    		$order->city = null;
    		$order->state = null;
    		$order->zip = $orderData->zip;
    		$order->num_of_tickets = $orderData->ticketNumber;
    		$order->total_sale = $orderData->total;
    		$order->concert_id = $orderData->concertId;
            $order->promo_code = $orderData->promo_code;

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
        $data = [];
        $ticket_orders = Order::where('concert_id', $id)->orderBy('created_at', 'DESC')->get();
        if($ticket_orders) {
            $title = $ticket_orders[0]->concert_title;
            $data = [
                'title' => $title,
                'tickets_sold' => $this->getTixSold($ticket_orders),
                'gross_sales' => $this->getGrossSales($ticket_orders),
                'orders' => $ticket_orders
            ];  
        }


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

    public function getPromoCodes($concert_id) {
        $promo_codes = PromoCode::where('concert_id', $concert_id)->where('status', 1)->get();

        return $promo_codes;
    }

    public function getAllPromoCodes($concert_id) {
        $promo_codes = PromoCode::where('concert_id', $concert_id)->get();

        return $promo_codes;
    }

    public function storePromoCode(Request $request) {

        // Validate 
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
        ]); 
        if ($validator->fails()) {
            // If Validation Fails
            return response()->json([
                'code' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
            $promo_code = new PromoCode;

            $promo_code->concert_id = $request->concert_id;
            $promo_code->code = $request->code;
            $promo_code->discount = $request->discount;
            $promo_code->discount_type = $request->discount_type;
            $promo_code->status = $request->status;

            $promo_code->save();

            if($promo_code) {
                return response()->json([
                    'code' => 'success',
                    'message' => 'Your promo code was created.'
                ]);
            } else {
                return response()->json([
                    'code' => 'fail',
                    'message' => 'Something went wrong.'
                ]);
            }
        }  

    }

    public function storeCustomerArtists(Request $request) {
        // Validate 
        $validator = Validator::make($request->all(), [
            'concert_id' => 'required|integer',
        ]); 
        if ($validator->fails()) {
            // If Validation Fails
            return response()->json([
                'code' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
            if($request->artists) {
                foreach ($request->artists as $artist) {
                    $this->storeArtist($artist, $request->concert_id);
                }
            }
        }

        return response()->json([
            'code' => 'complete',
        ]);   
    }

    public function storeArtist($artist_id, $concert_id) {
        $customer_artist = new CustomerArtist;

        $customer_artist->concert_id = $concert_id;
        $customer_artist->artist_id = $artist_id;

        $customer_artist->save();

        if($customer_artist) {
            return response()->json([
                'code' => 'success',
                'message' => 'Thank you.'
            ]);
        } else {
            return response()->json([
                'code' => 'fail',
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function getArtistTixSold($artist_id, $concert_id) {
        $artist_customers = CustomerArtist::where('artist_id', $artist_id)->where('concert_id', $concert_id)->get();

        return $artist_customers;
    }

    public function storeProductPayment(Request $request) {
        // Validate 
        $validator = Validator::make($request->all(), [
            'total' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'delivery_method' => 'required|string|max:255',
            'name_on_card' => 'required|string|max:255',
            'card_number' => 'required|string|max:255',
            'exp_month' => 'required|string|max:2',
            'exp_year' => 'required|string|max:4',
            'cvc' => 'required|string|max:5',
        ]); 
        if ($validator->fails()) {
        // If Validation Fails
            return response()->json([
                'code' => 'fail-validation',
                'errors' => $validator->errors()->first()
            ]);
        } else {
            // Make sure there are products
            if(($request->products) && (count($request->products) > 0)) {

                $stripeSecret = \config('payment.stripeSecret');
                Stripe\Stripe::setApiKey($stripeSecret);

                // Create Token
                $token = Stripe\Token::create([
                    'card' => [
                        'number' => $request->card_number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                        'address_zip' => $request->zip, 
                    ],
                ]);

                // check if customer exists
                $user = $this->isNewCustomer($request->email);
                if(!$user) {

                    if($token['id']) {
                        // Create Customer
                        $stripe_customer = Stripe\Customer::create([
                            'source' => $token['id'],
                            'email' => $request->email,
                            'name' => $request->name_on_card,
                        ]);
                    }

                    $user = $this->storeUser($request, $stripe_customer->id);
                } else {
                    $stripe_customer = Stripe\Customer::retrieve($user->stripe_id);
                }

                $user_details = $this->isNewCustomerDetails($user->id);

                if(!$user_details) {
                    $user_details = $this->storeCustomerDetails($user->id, $request);
                } 
                // Update the details
                else {
                    $user_details = $this->updateCustomerDetails($user->id, $request);
                }

                try {
                    // charge
                    $charge = Stripe\Charge::create([
                        'customer' => $stripe_customer->id,
                        'amount' => number_format($request->total, 2, '', '.'),
                        'currency' => 'usd',
                        'description' => 'test'
                    ]); 

                    // store order
                    $order = $this->storeNewOrder($charge->id, $charge->status, $user->id, $request->total, $request->delivery_method);
                    // store order items
                    if($order) {
                        $this->storeProducts($order->id, $user->id, $request->products);
                    }

                    $notification = [
                        'customer' => $user,
                        'customer_details' => $user_details,
                        'products' => $request->products,
                        'total' => $request->total
                    ];

                    // do notification to customer
                    $this->sendEmailToCustomer($notification, $request->email);           
                    // do notification to admin
                    $this->sendEmailToAdmin($notification);

                    session([
                        'products' => []
                    ]);

                    return response()->json([
                        'message' => 'success',
                        'charge_details' => $charge,
                        'errors' => []
                    ]); 

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
            // Return validation error
            else {
                return response()->json([
                    'code' => 'fail-validation',
                    'errors' => ['You must have at least one product in the cart.']
                ]);
            }
        }   
    }

    public function isNewCustomer($email) {
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function isNewCustomerDetails($user_id) {
        $user = CustomerDetail::where('user_id', $user_id)->first();
        return $user;
    }

    public function storeUser($data, $stripe_id) {
        $user = new User;

        $user->name = $data->first_name.' '.$data->last_name;
        $user->email = $data->email;
        $user->password = Hash::make(rand().''.rand());
        $user->stripe_id = $stripe_id;

        $user->save();

        return $user;
    }

    public function storeCustomerDetails($id, $data) {
        $user_details = new CustomerDetail;

        $user_details->user_id = $id;
        $user_details->phone = $data->phone;
        $user_details->street_address = $data->street_address;
        $user_details->unit = $data->unit;
        $user_details->city = $data->city;
        $user_details->state = $data->state;
        $user_details->zip = $data->zip;
        $user_details->country = $data->country;

        $user_details->save();

        return $user_details;
    }

    public function updateCustomerDetails($id, $data) {
        $user_details = CustomerDetail::where('user_id', $id)->first();

        $user_details->phone = $data->phone;
        $user_details->street_address = $data->street_address;
        $user_details->unit = $data->unit;
        $user_details->city = $data->city;
        $user_details->state = $data->state;
        $user_details->zip = $data->zip;
        $user_details->country = $data->country;

        $user_details->save();  

        return $user_details;
    }

    public function storeNewOrder($transaction_id, $status, $user_id, $total, $delivery_method) {
        $order = new ProcessedOrder;

        $order->customer_id = $user_id; 
        $order->transaction_id = $transaction_id;   
        $order->total = $total;   
        $order->status = $status;   
        $order->promo_code = null;   
        $order->discount = null;   
        $order->delivery_method = $delivery_method;   

        $order->save();           

        return $order;
    }

    public function storeProducts($order_id, $user_id, $products) {
        foreach ($products as $product) {
            $this->storeProduct($order_id, $user_id, $product);
        }
        return;
    }

    public function storeProduct($order_id, $user_id, $product) {
        $p = new OrderedItem;

        $p->order_id = $order_id;
        $p->customer_id = $user_id;
        $p->product_id = $product['id'];
        $p->quantity = $product['quantity'];
        $p->size = $product['size'];
        $p->color = $product['color'];
        $p->status = 'test';

        $p->save();

        return;
    }

    public function sendEmailToCustomer($notification, $email) {
        if($notification) {
            Mail::send('mail.shop-customer-notification', ['notification' => $notification], function ($message) use ($notification, $email) {
                $message->subject('Thank you for your order!');
                $message->from('noreply@tower74concerts.com', 'Tower 74');
                $message->to($email);
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

    public function sendEmailToAdmin($notification) {
        if($notification) {
            Mail::send('mail.shop-admin-notification', ['notification' => $notification], function ($message) use ($notification) {
                $message->subject('New Order!');
                $message->from('noreply@tower74concerts.com', 'Tower 74');
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
}
