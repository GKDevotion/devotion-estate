<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "addresses";

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

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function continent(){
        return $this->hasOne(Continent::class, 'id', 'continent_id');
    }

    public function country(){
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function state(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
