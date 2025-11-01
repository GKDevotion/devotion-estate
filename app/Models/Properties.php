<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;
    // protected $table = 'admin_menus';
    // protected $guarded = array();

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

    public function single_image(){
        return $this->hasOne( PropertyImageMap::class, 'property_id', 'id');
    }

       public function images(){
        return $this->hasMany( PropertyImageMap::class, 'property_id', 'id');
    }

    public function location(){
        return $this->hasOne( Location::class, 'id', 'location_id');
    }

    public function type(){
        return $this->belongsTo(PropertyType::class, 'sub_type_id');
    }

    public function featureMap(){
        return $this->hasMany(PropertyFeatureMap::class, 'property_id', 'id')->where( 'status', 1 );
    }

}
