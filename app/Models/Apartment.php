<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'rooms',
        'beds',
        'bathroom',
        'square_mt',
        'apartment_description',
        'available',
        'latitude',
        'longitude',
        'sponsorship_id',
        'slug',
        'img_path'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class, "apartment_sponsorship")
        ->withPivot("end_date")
        ->withTimestamps();


    }

    public function views(){
        return $this->hasMany(View::class);
    }

    public function services(){
        return $this->belongsToMany(Service::class);


    }

    public function leads(){
        return $this->hasMany(Lead::class);
    }
}
