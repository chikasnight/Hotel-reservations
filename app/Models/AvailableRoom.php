<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableRoom extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description'
    ];
       // relationship of user & post is one to many;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reservation(){
        return $this->hasMany(Gallery::class);
    }
}