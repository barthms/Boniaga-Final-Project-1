<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InformationStore extends Model
{
    use HasFactory;
    protected $guarded = [];

    public  function user(){
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::creating(function ($category) {
            $category->user_id = Auth::id();
        });
    }
}
