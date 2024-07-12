<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);


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
