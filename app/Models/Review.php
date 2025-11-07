<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
  protected $table = 'reviews';
  protected $fillable = [
    'admin_id',
    'name',
    'email',
    'contact_no',
    'review',
    'rating',
    'property_id',
    'status',
];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = Carbon::now('Asia/Dubai');
            $model->updated_at = Carbon::now('Asia/Dubai');
        });

        static::updating(function ($model) {
            $model->updated_at = Carbon::now('Asia/Dubai');
        });
    }


        public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

      public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }
    // public function user(){
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }
}
