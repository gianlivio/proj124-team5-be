<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;

    public function apartments(){
        return $this->belongsToMany(Apartment::class, "apartment_sponsorship")
        ->withPivot("end_date")
        ->withTimestamps();
    }

    protected $fillable = [
        'type',
        'duration',
        'price',
        'sponsorship_description'
    ];
}
