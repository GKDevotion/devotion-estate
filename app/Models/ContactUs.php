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

      // ✅ Add accessor
    public function getTypeDisplayAttribute()
    {
        // Handle nulls gracefully
        if ($this->type && $this->sub_type) {
            return "{$this->type} → {$this->sub_type}";
        }

        

        return $this->type ?? '-';
    }

  public function subType()
  {
    return $this->belongsTo(PropertyType::class, 'sub_type', 'id');
  }


  //use type_display to show both Commercial → Office

}
