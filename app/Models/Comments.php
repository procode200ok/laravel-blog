<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'post_id' ,'user_id', 'comment_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
            $model->comment_id = Uuid::uuid4()->toString();
        });
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    
    protected $primaryKey = 'comment_id';

}
