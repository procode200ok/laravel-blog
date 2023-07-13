<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedPosts extends Model
{
    use HasFactory;

    protected $fillable = ['post_id' ,'reson'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
    }


}
