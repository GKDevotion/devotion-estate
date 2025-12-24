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
        return $this->hasOne( PropertyImageMap::class, 'property_id', 'id', 'filename');
    }

       public function images(){
        return $this->hasMany( PropertyImageMap::class, 'property_id', 'id')->orderBy('sort_order', 'ASC');
    }

    public function location(){
        return $this->hasOne( Location::class, 'id', 'location_id');
    }

    public function feature()
    {
        return $this->hasOne(PropertyFeature::class, 'id', 'name');
    }

    public function subType(){
        return $this->hasOne(PropertyType::class, 'id', 'sub_type_id', 'name');
    }

    public function featureMap(){
        return $this->hasMany(PropertyFeatureMap::class, 'property_id', 'id')->where( 'status', 1 );
    }

    public function paymentPlan()
    {
        return $this->hasOne(PaymentPlan::class, 'id','name');
    }

    public function agent(){
    return $this->hasOne(User::class, 'id', 'agent_id', 'image');
    }

    public function developer(){
    return $this->hasOne(Developer::class, 'id', 'developer_id');
    }
}
