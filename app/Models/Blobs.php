<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blobs extends Model
{
    use HasFactory;
    protected $fillable = ['fileName', 'type' ,'extension', 'post_id'];
}
