<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitingCard extends Model
{
    use HasFactory;

    protected $table = "visiting_cards";

    public function admin(){
        return $this->hasOne(Admin::class, 'id', 'admin_id');
    }

    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
