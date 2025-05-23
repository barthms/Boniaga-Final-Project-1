<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Categories extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(){
        return $this->hasMany(Products::class, 'category_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->user_id = Auth::id();
        });
    }
}
