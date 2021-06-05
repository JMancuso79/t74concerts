<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_on_card',
        'ticket_holder',
        'email',
        'phone',
        'city',
        'state',
        'zip',
        'stripe_payment_id',
        'num_of_tickets',
        'price_per_ticket',
        'total_sale',
        'concert_id',
        'promo_code'
    ];
}
