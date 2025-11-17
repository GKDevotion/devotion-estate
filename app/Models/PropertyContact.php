<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyContact extends Model
{
    use HasFactory;
    // protected $table = 'admin_menus';
    // protected $guarded = array();
    protected $table = 'property_contact';
      protected $fillable = [
    'website_id',
    'name',
    'email',
    'mobile_number',
    'message',
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
        return $this->belongsTo(Properties::class, 'property_id','unique_id');
    }

    // public function parent(){
    //     return $this->hasOne( PropertyFeature::class, 'id', 'parent_id');
    // }
}
