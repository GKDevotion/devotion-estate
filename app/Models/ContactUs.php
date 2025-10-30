<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    //

      use HasFactory;

    protected $fillable = [
        'website_id',
        'name',
        'type',
        'sub_type',
        'email',
        // 'mobile_number',
        'ip_address',
        'comment',
    ];
}
