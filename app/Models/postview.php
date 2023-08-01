<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class postview extends Model
{
    use HasFactory;

    protected $fillable = ['ip_adress', 'post_id', 'user_id','user_agent'];
}
