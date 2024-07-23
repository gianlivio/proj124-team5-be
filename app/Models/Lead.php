<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lastname', 'mail', 'phone_number', 'message', "apartment_id"];

    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }
}
