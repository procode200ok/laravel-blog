<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
            $model->post_id = Uuid::uuid4()->toString();
        });
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
    protected $primaryKey = 'post_id';

}
