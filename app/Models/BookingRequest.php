<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_name',
        'type',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'message',
        'url',
        'genres',
        'gig_swap',
        'gig_swap_home',
        'gig_swap_away',
        'dates',
    ];
}
